<?php

namespace App\Controller;

use App\Entity\Dono;
use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use App\Form\CachorroType;
use App\Repository\CachorroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cachorro')]
class CachorroController extends AbstractController
{
    #[Route('/', name: 'app_cachorro_index', methods: ['GET'])]
    public function index(CachorroRepository $cachorroRepository): Response
    {
        return $this->render('cachorro/index.html.twig', [
            'cachorros' => $cachorroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cachorro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CachorroRepository $cachorroRepository): Response
    {
        $cachorro = new Cachorro();
        $form = $this->createForm(CachorroType::class, $cachorro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cachorroRepository->save($cachorro, true);

            return $this->redirectToRoute('app_cachorro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cachorro/new.html.twig', [
            'cachorro' => $cachorro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cachorro_show', methods: ['GET'])]
    public function show(Cachorro $cachorro): Response
    {
        return $this->render('cachorro/show.html.twig', [
            'cachorro' => $cachorro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cachorro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cachorro $cachorro, CachorroRepository $cachorroRepository): Response
    {
        $form = $this->createForm(CachorroType::class, $cachorro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cachorroRepository->save($cachorro, true);

            return $this->redirectToRoute('app_cachorro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cachorro/edit.html.twig', [
            'cachorro' => $cachorro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cachorro_delete', methods: ['POST'])]
    public function delete(Request $request, Cachorro $cachorro, CachorroRepository $cachorroRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cachorro->getId(), $request->request->get('_token'))) {
            $cachorroRepository->remove($cachorro, true);
        }

        return $this->redirectToRoute('app_cachorro_index', [], Response::HTTP_SEE_OTHER);
    }
}
