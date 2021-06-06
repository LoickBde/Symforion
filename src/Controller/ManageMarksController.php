<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageMarksController extends AbstractController
{
    /**
     * @Route("/manage/marks", name="manage_marks")
     */
    public function index(): Response
    {
        return $this->render('manage_marks/index.html.twig', [
            'controller_name' => 'ManageMarksController',
        ]);
    }
}
