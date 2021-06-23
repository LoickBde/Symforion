<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Repository\SubjectRepository;
use App\Repository\UserRepository;
use App\Service\PromoService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $promoRepository;
    private $userRepository;
    private $subjectRepository;

    public function __construct(PromoRepository $promoRepository, UserRepository $userRepository,
                                SubjectRepository $subjectRepository)
    {
        $this->promoRepository = $promoRepository;
        $this->userRepository = $userRepository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * @Route("/manage/promo", name="admin_promo", methods={"GET"})
     */
    public function index(): Response
    {
        $promos = $this->promoRepository->findAll();

        return $this->render('admin/managePromo.html.twig', [
            'promos' => $promos,
        ]);
    }

    /**
     * @Route("/manage/user", name="admin_user", methods={"GET"})
     */
    public function manageUser(): Response
    {
        $users = $this->userRepository->findAll();
        $promos = $this->promoRepository->findAll();
        $subjects = $this->subjectRepository->findAll();

        return $this->render('admin/manageUser.html.twig', [
            'users' => $users,
            'promos' => $promos,
            "subjects" => $subjects
        ]);
    }

    /**
     * @Route("/manage/user/{id}", name="remove_user", methods={"DELETE"})
     */
    public function removeUser(UserService $userService, int $id): JsonResponse{
        return $userService->removeUser($id);
    }


    /**
     * @Route("/manage/promo/{id}", name="remove_promo", methods={"DELETE"})
     */
    public function removePromo(PromoService $promoService, int $id): JsonResponse{
        return $promoService->removePromo($id);
    }

    /**
     * @Route("/manage/promo", name="add_promo", methods={"POST"})
     */
    public function addPromo(PromoService $promoService,Request $request): JsonResponse{
        $promoName = $request->get('promoName');
        return $promoService->addPromo($promoName);
    }

    /**
     * @Route("/manage/user", name="add_user", methods={"POST"})
     */
    public function addUser(UserService $userService,Request $request): JsonResponse{
        return $userService->addUser($request);
    }

}
