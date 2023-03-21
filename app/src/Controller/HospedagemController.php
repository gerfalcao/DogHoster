<?php

namespace App\Controller;

use App\Entity\Hospedagem;
use App\Entity\Recibo;
use App\Entity\Servicos;
use App\Form\HospedagemType;
use App\Form\ServicosType;
use App\Repository\HospedagemRepository;
use App\Repository\ReciboRepository;
use App\Repository\ServicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HospedagemController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_hospedagem_index', methods: ['GET'])]
    public function index(HospedagemRepository $hospedagemRepository): Response
    {
        return $this->render('hospedagem/index.html.twig', [
            'hospedagems' => $hospedagemRepository->findAll(),
        ]);
    }

    // #[Route('/{id}/recibo/novo', name: 'novo_recibo', methods: ['GET'])]
    // public function novo(Request $request, EntityManagerInterface $entityManager, $id): Response
    // {

    //     $hospedagem = $this->em->getRepository(Hospedagem::class)->find($id);
    //     $tempo_total = $hospedagem->getDuration();

    //     $recibo = new Recibo();
    //     $recibo->setHospedagem($hospedagem);
    //     $recibo->setCachorroDono();
    //     $recibo->setTempoTotal($tempo_total);
    //     $entityManager->persist($recibo);
    //     $entityManager->flush();

        
    //     return $this->render('recibo/novo.html.twig', [
    //         'recibo' => $recibo,
    //     ]);
    // }


    #[Route('/new', name: 'app_hospedagem_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HospedagemRepository $hospedagemRepository): Response
    {
        $hospedagem = new Hospedagem();
        $form = $this->createForm(HospedagemType::class, $hospedagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hospedagemRepository->save($hospedagem, true);

            return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hospedagem/new.html.twig', [
            'hospedagem' => $hospedagem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hospedagem_show', methods: ['GET', 'POST'])]
    public function show(Hospedagem $hospedagem, Request $request, ServicosRepository $servicosRepository): Response
    {
        $servico = new Servicos();
        $form = $this->createForm(ServicosType::class, $servico);
        $servico->setHospedagem($hospedagem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $servicosRepository->save($servico, true);

            

            return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
        }
        // return $this->renderForm('hospedagem/new.html.twig', [
        //     'hospedagem' => $hospedagem,
        //     'form' => $form,
        // ]);

        $valor_total = $hospedagem->calcularPreco();
        return $this->render('hospedagem/show.html.twig', [
            'hospedagem' => $hospedagem,
            'valor_total' => $valor_total,
            'form' => $form,
            'servicos' => $servico
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hospedagem_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hospedagem $hospedagem, HospedagemRepository $hospedagemRepository): Response
    {
        $form = $this->createForm(HospedagemType::class, $hospedagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hospedagemRepository->save($hospedagem, true);

            return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hospedagem/edit.html.twig', [
            'hospedagem' => $hospedagem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hospedagem_delete', methods: ['POST'])]
    public function delete(Request $request, Hospedagem $hospedagem, HospedagemRepository $hospedagemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospedagem->getId(), $request->request->get('_token'))) {
            $hospedagemRepository->remove($hospedagem, true);
        }

        return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
    }

 
}
