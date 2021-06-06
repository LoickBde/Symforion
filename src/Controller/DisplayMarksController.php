<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use http\Exception\BadMessageException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarkRepository;

class DisplayMarksController extends AbstractController
{
    private MarkRepository $markRepository;
    private StudentRepository $studentRepository;

    public function __construct(MarkRepository $markRepository,StudentRepository $studentRepository){
        $this->markRepository = $markRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * @Route("/display/marks", name="display_marks")
     */
    public function index(): Response
    {
        $student = $this->studentRepository->findFirst()[0];
        return $this->render('display_marks/index.html.twig', [
            'controller_name' => 'DisplayMarksController',
            'marks' => $this->markRepository->findBy(array('student' => $student))
        ]);
    }
}
