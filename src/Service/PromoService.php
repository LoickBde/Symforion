<?php

namespace App\Service;



use App\Entity\Promo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PromoService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function removePromo(int $promoId){
        $promo = $this->em->getRepository(Promo::class)->find($promoId);

        if(isset($promo) || !is_null($promo)){
            $this->em->remove($promo);
            $this->em->flush();
            return new JsonResponse($promo,200);
        }

        return new JsonResponse(array("message" => "Promo introuvable"),404);
    }

    public function addPromo(string $promoName){

        if(isset($promoName) || !is_null($promoName)){
            $promo = new Promo();
            $promo->setName($promoName);

            $this->em->persist($promo);
            $this->em->flush();
            return new JsonResponse([
                "id" => $promo->getId(),
                "name" => $promo->getName()
            ],200);
        }

        return new JsonResponse(array("message" => "Nom de promo incorrect"),400);
    }
}