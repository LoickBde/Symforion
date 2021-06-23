<?php

namespace App\Service;

use App\Entity\Subject;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubjectService
{

    private $em;
    private $teacherRepository;

    public function __construct(EntityManagerInterface $em, TeacherRepository $teacherRepository)
    {
        $this->em = $em;
        $this->teacherRepository = $teacherRepository;
    }

    public function removeSubject(int $subjectId){
        $subject = $this->em->getRepository(Subject::class)->find($subjectId);

        if(isset($subject) || !is_null($subject)){
            $this->em->remove($subject);
            $this->em->flush();
            return new JsonResponse($subject,200);
        }

        return new JsonResponse(array("message" => "Matière introuvable"),404);
    }

    public function addSubject(Request $request){

        $name = $request->get("name");
        $teacherId = $request->get("teacherId");

        $teacher = $this->teacherRepository->find($teacherId);

        if(isset($name) || !is_null($name) || isset($teacher) || !is_null($teacher) ){
            $subject = new Subject();
            $subject->setName($name);
            $subject->setTeacher($teacher);
            $this->em->persist($subject);
            $this->em->flush();
            return new JsonResponse([
                "id" => $subject->getId(),
                "name" => $subject->getName(),
                "teacherFirstname" => $teacher->getFirstname(),
                "teacherLastname" => $teacher->getLastname()
            ],200);
        }

        return new JsonResponse(array("message" => "Nom de matière incorrect ou prof incorrect"),400);
    }
}