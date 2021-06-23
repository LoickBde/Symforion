<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Repository\SubjectRepository;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use App\Service\PromoService;
use App\Service\SubjectService;
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
    private $teacherRepository;

    public function __construct(PromoRepository $promoRepository, UserRepository $userRepository,
                                SubjectRepository $subjectRepository, TeacherRepository $teacherRepository)
    {
        $this->promoRepository = $promoRepository;
        $this->userRepository = $userRepository;
        $this->subjectRepository = $subjectRepository;
        $this->teacherRepository = $teacherRepository;
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

        return $this->render('admin/manageUser.html.twig', [
            'users' => $users,
            'promos' => $promos
        ]);
    }

    /**
     * @Route("/manage/subject", name="admin_subject", methods={"GET"})
     */
    public function manageSubject(): Response
    {
        $subjects = $this->subjectRepository->findAll();
        $teachers = $this->teacherRepository->findAll();

        return $this->render('admin/manageSubject.html.twig', [
            "subjects" => $subjects,
            "teachers" => $teachers
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
     * @Route("/manage/subject/{id}", name="remove_subject", methods={"DELETE"})
     */
    public function removeSubject(SubjectService $subjectService, int $id): JsonResponse{
        return $subjectService->removeSubject($id);
    }

    /**
     * @Route("/manage/subject", name="add_subject", methods={"POST"})
     */
    public function addSubject(SubjectService $subjectService,Request $request): JsonResponse{
        return $subjectService->addSubject($request);
    }

    /**
     * @Route("/manage/promo", name="add_promo", methods={"POST"})
     */
    public function addPromo(PromoService $promoService,Request $request): JsonResponse{
        $promoName = $request->get('name');
        return $promoService->addPromo($promoName);
    }

    /**
     * @Route("/manage/user", name="add_user", methods={"POST"})
     */
    public function addUser(UserService $userService,Request $request): JsonResponse{
        return $userService->addUser($request);
    }

}
