<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use App\Entity\Dono;
use App\Repository\DonoRepository;
use App\Entity\Cachorro;
use App\Form\CachorroType;
use App\Repository\CachorroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;



#[Route('/cachorro')]
class CachorroController extends AbstractController
{
    private $cachorroRepository;

    public function __construct(CachorroRepository $cachorroRepository)
    {
      $this->cachorroRepository = $cachorroRepository;
    }

    #[Route('/', name: 'app_cachorro_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('cachorro/index.html.twig', [
            'cachorros' => $this->cachorroRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cachorro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $cachorro = new Cachorro();
      
        $form = $this->createForm(CachorroType::class, $cachorro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           /** @var UploadedFile $photo  */
           $newPhoto = $form->get('photo')->getData();
               
                if ($newPhoto) {
                    $originalFilename = pathinfo($newPhoto->getClientOriginalName(), PATHINFO_FILENAME);

                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$newPhoto->guessExtension();

           
                try {
                    $newPhoto->move(
                        $this->getParameter('photos_directory'), 
                        $newFilename);
                    
                } catch (FileException $e) {
                    echo 'Opa, tem algum problema com seu arquivo' . $e->getMessage();
                }

                $cachorro->setPhoto($newFilename);
            }

            // ... persist the $cachorro variable or any other work
           
            $this->cachorroRepository->save($cachorro, true);

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
    public function edit(Request $request, Cachorro $cachorro, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CachorroType::class, $cachorro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPhoto = $form->get('photo')->getData();
               
            if ($newPhoto) {
                $originalFilename = pathinfo($newPhoto->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$newPhoto->guessExtension();

       
            try {
                $newPhoto->move(
                    $this->getParameter('photos_directory'), 
                    $newFilename);
                
            } catch (FileException $e) {
                echo 'Opa, tem algum problema com seu arquivo' . $e->getMessage();
            }

            $cachorro->setPhoto($newFilename);
        }
            
            $this->cachorroRepository->save($cachorro, true);

            return $this->redirectToRoute('app_cachorro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cachorro/edit.html.twig', [
            'cachorro' => $cachorro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cachorro_delete', methods: ['POST'])]
    public function delete(Request $request, Cachorro $cachorro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cachorro->getId(), $request->request->get('_token'))) {
            $this->cachorroRepository->remove($cachorro, true);
        }

        return $this->redirectToRoute('app_cachorro_index', [], Response::HTTP_SEE_OTHER);
    }

 
}
