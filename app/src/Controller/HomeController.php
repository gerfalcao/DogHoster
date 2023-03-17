<?php

namespace App\Controller;

use App\Entity\Hospedagem;
use App\Form\HospedagemType;
use App\Repository\HospedagemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



#[Route('/')]
class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_hospedagem_index', methods: ['GET'])]
    public function index(HospedagemRepository $hospedagemRepository): Response
    {
        return $this->render('hospedagem/index.html.twig', [
            'hospedagems' => $hospedagemRepository->findAll(),
        ]);
    }


}
