<?php

namespace App\Controller;

use App\Entity\Hospedagem;
use App\Entity\Ocorrencias;
use App\Entity\Recibo;
use App\Entity\Servicos;
use App\Form\HospedagemType;
use App\Form\OcorrenciaType;
use App\Form\ServicosType;
use App\Repository\CachorroRepository;
use App\Repository\HospedagemRepository;
use App\Repository\OcorrenciasRepository;
use App\Repository\ReciboRepository;
use App\Repository\ServicosRepository;
use App\Service\ReciboService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HospedagemController extends AbstractController
{
    private $servicosRepository;
    private $reciboService;
    private $ocorrenciasRepository;
    private $hospedagemRepository;
    private $em;
    private $cachorroRepository;

    public function __construct(EntityManagerInterface $em, ReciboService $reciboService, HospedagemRepository $hospedagemRepository, OcorrenciasRepository $ocorrenciasRepository, ServicosRepository $servicosRepository, CachorroRepository $cachorroRepository)
    {
        $this->em = $em;
        $this->hospedagemRepository = $hospedagemRepository;
        $this->ocorrenciasRepository = $ocorrenciasRepository;
        $this->reciboService = $reciboService;
        $this->servicosRepository = $servicosRepository;
        $this->cachorroRepository = $cachorroRepository;
    }

    #[Route('/', name: 'app_hospedagem_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $hospedagensAtivas = $this->hospedagemRepository->findHospedagemsEmAberto();
        $hospedagensAtivasQuantidade = 15 - count($hospedagensAtivas);
        
        // $hospedagensDisponiveis = $this->hospedagemRepository->findHospedagemsFechadas();
        // $opcoesCachorros = array_map(function($hospedage) {
        //     return $hospedage->getCachorro();
        // }, $hospedagensDisponiveis);


        $hospedagem = new Hospedagem();
        $form = $this->createForm(HospedagemType::class, $hospedagem);
        $hospedagem->setDataInicio(new DateTime());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->hospedagemRepository->save($hospedagem, true);

            return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
        }

    
        return $this->render('hospedagem/index.html.twig', [
            'hospedagems' => $this->hospedagemRepository->findAll(),
            'hospedagensAtivas' => $hospedagensAtivas,
            'hospedagensAtivasQuantidade' => $hospedagensAtivasQuantidade,
            'form' => $form,
        ]);
    }

   
    #[Route('/{id}', name: 'app_hospedagem_show', methods: ['GET', 'POST'])]
    public function show(Hospedagem $hospedagem, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $servico = new Servicos();
        $formServico = $this->createForm(ServicosType::class, $servico);
        $servico->setHospedagem($hospedagem);
        $formServico->handleRequest($request);
        if ($formServico->isSubmitted() && $formServico->isValid()) {
            $this->servicosRepository->save($servico, true);

            return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
        }

        $ocorrencia = new Ocorrencias();
        $formOcorrencia = $this->createForm(OcorrenciaType::class, $ocorrencia);
        $ocorrencia->setHospedagem($hospedagem);
        $formOcorrencia->handleRequest($request);
        if ($formOcorrencia->isSubmitted() && $formOcorrencia->isValid()) {
            $this->ocorrenciasRepository->save($ocorrencia, true);

            return $this->redirectToRoute('app_hospedagem_show', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER);
        }

        $checkout = $request->query->get('checkout');

        if ($checkout) {
            $hospedagem->setDataFim(new \DateTime($checkout));
            $this->em->flush();
        }


        $valor_diarias = $hospedagem->calcularPrecoEstadia();
        $valor_servico = $hospedagem->calcularTotalServicos();
        $valor_total = $hospedagem->calcularPrecoTotal();
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
    public function edit(Request $request, Hospedagem $hospedagem): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $form = $this->createForm(HospedagemType::class, $hospedagem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->hospedagemRepository->save($hospedagem, true);

            return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hospedagem/edit.html.twig', [
            'hospedagem' => $hospedagem,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/recibo', name: 'app_hospedagem_recibo', methods: ['GET'])]
    public function recibo(Request $request, Hospedagem $hospedagem): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $recibo = $hospedagem->getRecibo();
        return $this->render('recibo/index.html.twig', [
            'recibo' => $recibo
        ]);
    }

    #[Route('/{id}', name: 'app_hospedagem_delete', methods: ['POST'])]
    public function delete(Request $request, Hospedagem $hospedagem): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hospedagem->getId(), $request->request->get('_token'))) {
            $this->hospedagemRepository->remove($hospedagem, true);
        }

        return $this->redirectToRoute('app_hospedagem_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/fechar', name: 'fechar_hospedagem')]
    public function fechar(Request $request, Hospedagem $hospedagem): Response
    {
        $hospedagem->setDataFim(new DateTime());
        $this->em->flush();

        $recibo = $this->reciboService->createRecibo($hospedagem);
        $hospedagem->setRecibo($recibo);
        $this->em->flush();

        return $this->redirectToRoute('app_hospedagem_recibo', ['id' => $hospedagem->getId()], Response::HTTP_SEE_OTHER, [
            'recibo' => $recibo
        ]);
        
    }

   



}
