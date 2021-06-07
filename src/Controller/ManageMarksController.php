<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageMarksController extends AbstractController
{
    private PromoRepository $promoRepository;
    private StudentRepository $studentRepository;

    /**
     * ManageMarksController constructor.
     * @param PromoRepository $promoRepository
     * @param StudentRepository $studentRepository
     */
    public function __construct(PromoRepository $promoRepository, StudentRepository $studentRepository)
    {
        $this->promoRepository = $promoRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/manage/marks", name="manage_marks")
     */
    public function index(): Response
    {
        return $this->render('manage_marks/index.html.twig', [
            'controller_name' => 'ManageMarksController',
            'promos' => $this->promoRepository->findAll()
        ]);
    }

    /**
     * @Route("/manage/marks/promo/{id}/students", name="get_students")
     */
    public function getStudents($id): JsonResponse
    {
        return new JsonResponse($this->studentRepository->findStudentsByPromo($id));
    }
}
