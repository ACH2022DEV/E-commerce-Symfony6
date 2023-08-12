<?php

namespace App\Controller;

use App\Entity\MyUser;
use App\Form\MyUserType;
use App\Repository\MyUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/my/user')]
class MyUserController extends AbstractController
{
    #[Route('/', name: 'app_my_user_index', methods: ['GET'])]
    public function index(MyUserRepository $myUserRepository): Response
    {
        return $this->render('my_user/index.html.twig', [
            'my_users' => $myUserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_my_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $myUser = new MyUser();
        $form = $this->createForm(MyUserType::class, $myUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($myUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_my_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('my_user/new.html.twig', [
            'my_user' => $myUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_my_user_show', methods: ['GET'])]
    public function show(MyUser $myUser): Response
    {
        return $this->render('my_user/show.html.twig', [
            'my_user' => $myUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_my_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MyUser $myUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MyUserType::class, $myUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_my_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('my_user/edit.html.twig', [
            'my_user' => $myUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_my_user_delete', methods: ['POST'])]
    public function delete(Request $request, MyUser $myUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$myUser->getId(), $request->request->get('_token'))) {
            $entityManager->remove($myUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_my_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
