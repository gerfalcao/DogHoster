<?php

namespace App\Controller;

use App\Entity\Dono;
use App\Form\DonoType;
use App\Repository\DonoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dono')]
class DonoController extends AbstractController
{
    #[Route('/', name: 'app_dono_index', methods: ['GET'])]
    public function index(DonoRepository $donoRepository): Response
    {
        return $this->render('dono/index.html.twig', [
            'donos' => $donoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dono_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DonoRepository $donoRepository): Response
    {
        $dono = new Dono();
        $form = $this->createForm(DonoType::class, $dono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donoRepository->save($dono, true);

            return $this->redirectToRoute('app_dono_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dono/new.html.twig', [
            'dono' => $dono,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dono_show', methods: ['GET'])]
    public function show(Dono $dono): Response
    {
        return $this->render('dono/show.html.twig', [
            'dono' => $dono,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dono_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dono $dono, DonoRepository $donoRepository): Response
    {
        $form = $this->createForm(DonoType::class, $dono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donoRepository->save($dono, true);

            return $this->redirectToRoute('app_dono_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dono/edit.html.twig', [
            'dono' => $dono,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dono_delete', methods: ['POST'])]
    public function delete(Request $request, Dono $dono, DonoRepository $donoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dono->getId(), $request->request->get('_token'))) {
            $donoRepository->remove($dono, true);
        }

        return $this->redirectToRoute('app_dono_index', [], Response::HTTP_SEE_OTHER);
    }
}
