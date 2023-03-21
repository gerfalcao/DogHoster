<?php

namespace App\Controller;

use App\Entity\Hospedagem;
use App\Entity\Ocorrencias;
use App\Entity\Recibo;
use App\Entity\Servicos;
use App\Form\HospedagemType;
use App\Form\OcorrenciaType;
use App\Form\ServicosType;
use App\Repository\HospedagemRepository;
use App\Repository\OcorrenciasRepository;
use App\Repository\ReciboRepository;
use App\Repository\ServicosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/new', name: 'app_hospedagem_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HospedagemRepository $hospedagemRepository): Response
    {
        $hospedagem = new Hospedagem();
        $form = $this->createForm(HospedagemType::class, $hospedagem);
        $hospedagem->setEstado('em aberto');
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
    public function show(Hospedagem $hospedagem, Request $request, ServicosRepository $servicosRepository, OcorrenciasRepository $ocorrenciasRepository): Response
    {
        $servico = new Servicos();
        $formServico = $this->createForm(ServicosType::class, $servico);
        $servico->setHospedagem($hospedagem);
        $formServico->handleRequest($request);
        if ($formServico->isSubmitted() && $formServico->isValid()) {
            $servicosRepository->save($servico, true);

            

            return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
        }
        // return $this->renderForm('hospedagem/new.html.twig', [
        //     'hospedagem' => $hospedagem,
        //     'form' => $form,
        // ]);

        $ocorrencia = new Ocorrencias();
        $formOcorrencia = $this->createForm(OcorrenciaType::class, $ocorrencia);
        $ocorrencia->setHospedagem($hospedagem);
        $formOcorrencia->handleRequest($request);
        if ($formOcorrencia->isSubmitted() && $formOcorrencia->isValid()) {
            $ocorrenciasRepository->save($ocorrencia, true);
        
            return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
        }


        $checkout = $request->query->get('checkout');

        if ($checkout) {
            $hospedagem->setDataFim(new \DateTime($checkout));
            $this->em->flush();
        }

        // $removeServico = $request->query->get('remove-servico');

        // if ($removeServico) {
        //     $servicosRepository->remove($servico, true);
        // }

        $valor_diarias = $hospedagem->calcularTotalDiarias();
        $valor_servico = $hospedagem->calcularTotalServicos();
        $valor_total = $hospedagem->calcularPreco();
        return $this->render('hospedagem/show.html.twig', [
            'hospedagem' => $hospedagem,
            'valor_diarias' => $valor_diarias,
            'valor_servico' => $valor_servico,
            'valor_total' => $valor_total,
            'form_servico' => $formServico,
            'form_ocorrencia' => $formOcorrencia,
            'servicos' => $servico,
            'ocorrencia' => $ocorrencia
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

    #[Route('/{id}/recibo', name: 'app_hospedagem_recibo', methods: ['GET'])]
    public function recibo(Request $request, Hospedagem $hospedagem, HospedagemRepository $hospedagemRepository): Response
    {
        $recibo = new Recibo();
        $recibo->setHospedagem($hospedagem);
        $recibo->setCachorroDono();
        $recibo->setTempoTotal();
        $recibo->setPrecoDiaria();
        $recibo->setPrecoServicos();
        $recibo->setPrecoTotal();
        
        // $this->em->flush();
        return $this->render('recibo/index.html.twig', [
            'recibo' => $recibo
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

    #[Route('/{id}/fechar', name: 'fechar_hospedagem')]
    public function fechar(Hospedagem $hospedagem): Response
    {
        $hospedagem->setEstado('fechado');
        $this->em->flush();

        return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/abrir', name: 'abrir_hospedagem')]
    public function abrir(Hospedagem $hospedagem): Response
    {
        $hospedagem->setEstado('em aberto');
        $this->em->flush();

        return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
    }
   
 
}
