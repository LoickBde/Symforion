<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MarkRepository;

class DisplayMarksController extends AbstractController
{
    private MarkRepository $markRepository;

    public function __construct(MarkRepository $markRepository){
        $this->markRepository = $markRepository;
    }

    /**
     * @Route("/display/marks", name="display_marks")
     */
    public function index(): Response
    {
        return $this->render('display_marks/index.html.twig', [
            'controller_name' => 'DisplayMarksController',
        ]);
    }
}
