<?php

namespace App\Controller;

use App\Entity\Hospedagem;
use App\Form\HospedagemType;
use App\Repository\HospedagemRepository;
use App\Repository\ReciboRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



#[Route('/')]
class HomeController extends AbstractController
{

    // #[Route('/', name: 'app_hospedagem_index', methods: ['GET'])]
    // public function index(HospedagemRepository $hospedagemRepository): Response
    // {
    //     // $hospedagems = $hospedagemRepository->findAll();
    //     $hospedagensAtivas = $hospedagemRepository->findBy(['estado' => 'em aberto']);

    //     return $this->render('hospedagem/index.html.twig', [
    //         // 'hospedagems' => $hospedagems,
    //         'hospedagensAtivas' => $hospedagensAtivas,

    //     ]);
    // }

    #[Route('/recibos', name: 'app_recibos', methods: ['GET'])]
    public function recibos(ReciboRepository $reciboRepository): Response
    {
        $recibos = $reciboRepository->listaRecentes();
        //Bug nessa parte
        
        return $this->render('recibo/listaCompleta.html.twig', [
            'recibos' => $recibos
        ]);
    }    

}
