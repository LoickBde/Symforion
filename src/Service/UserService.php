<?php

namespace App\Service;



use App\Entity\Promo;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
use App\Repository\PromoRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class UserService
{

    private $subjectRepository;
    private $promoRepository;
    private $em;

    public function __construct(EntityManagerInterface $em, PromoRepository $promoRepository,SubjectRepository $subjectRepository)
    {
        $this->em = $em;
        $this->promoRepository = $promoRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function removeUser(int $userId){
        $user = $this->em->getRepository(User::class)->find($userId);

        if(isset($user) || !is_null($user)){
            $this->em->remove($user);
            $this->em->flush();
            return new JsonResponse($user,200);
        }

        return new JsonResponse(array("message" => "User introuvable"),404);
    }

    public function addUser(Request $request){

        $role = "User";
        $email = $request->get("email");
        $password = $request->get('password');
        $firstname = $request->get('firstname');
        $lastname = $request->get("lastname");

        $roles = $request->get("roles");

        $params = [$email,$password,$firstname,$lastname,$roles];

        if($this->checkParameters($params)){
            $user = null;
            if(in_array("ROLE_STUDENT",$roles)){
                $user = new Student();

                $promoId = $request->get("promo");
                $promo = $this->promoRepository->find($promoId);
                $user->setPromo($promo);
                $role = "Eleve";
            } elseif (in_array("ROLE_TEACHER",$roles)){
                $user = new Teacher();

                $promosId = $request->get("promos");
                $promos = $this->promoRepository->findBy(array('id' => $promosId));

                foreach($promos as $promo)
                    $user->addPromo($promo);

                $role = "Professeur";
            } elseif (in_array("ROLE_ADMIN",$roles)){
                $user = new User();
                $role = "Administrateur";
            }

            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setRoles($roles);

            $this->em->persist($user);
            $this->em->flush();

            return new JsonResponse([
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "firstname" => $user->getFirstname(),
                "lastname" => $user->getLastname(),
                "role" => $role
            ],200);
        }

        return new JsonResponse(array("message" => "Nom de promo incorrect"),400);
    }

    private function checkParameters(array $parameters):bool {
        foreach($parameters as $object){
           if(is_null($object) || !isset($object)){
               return false;
           }
        }
        return true;
    }
}