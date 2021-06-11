<?php

namespace App\Controller;

use App\Entity\Mark;
use App\Repository\MarkRepository;
use App\Repository\PromoRepository;
use App\Repository\StudentRepository;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageMarksController extends AbstractController
{
    private PromoRepository $promoRepository;
    private StudentRepository $studentRepository;
    private SubjectRepository $subjectRepository;
    private MarkRepository $markRepository;

    /**
     * ManageMarksController constructor.
     * @param PromoRepository $promoRepository
     * @param StudentRepository $studentRepository
     */
    public function __construct(PromoRepository $promoRepository, StudentRepository $studentRepository,
                                SubjectRepository $subjectRepository, MarkRepository $markRepository)
    {
        $this->promoRepository = $promoRepository;
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->markRepository = $markRepository;
    }

    /**
     * @Route("/manage/marks", name="manage_marks")
     */
    public function index(): Response
    {
        $teacher = $this->getUser();
        return $this->render('manage_marks/index.html.twig', [
            'controller_name' => 'ManageMarksController',
            'promos' => $this->promoRepository->findby(array('teacher' => $teacher)),
            'subjects' => $this->subjectRepository->findby(array('teacher' => $teacher))
        ]);
    }

    /**
     * @Route("/manage/marks/promo/{id}/students", name="get_students")
     */
    public function getStudents($id): JsonResponse
    {
        return new JsonResponse($this->studentRepository->findStudentsByPromo($id));
    }

    /**
     * @Route("/manage/marks/add", name="add_mark")
     */
    public function addMark(Request $request): Response
    {
        $studentId =  $request->get('studentId');
        $subjectId =  $request->get('subjectId');
        $markType =  $request->get('markType');
        $markValue =  $request->get('markValue');
        $markCoef =  $request->get('markCoef');
        $markDesc =  $request->get('markDesc');

        $newMark = new Mark();
        $newMark->setStudent($this->studentRepository->find($studentId));
        $newMark->setSubject($this->subjectRepository->find($subjectId));
        $newMark->setType($markType);
        $newMark->setMark($markValue);
        $newMark->setCoef($markCoef);
        $newMark->setDescription($markDesc);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($newMark);
        $manager->flush();

        return new Response("mark added", Response::HTTP_OK);
    }
}
