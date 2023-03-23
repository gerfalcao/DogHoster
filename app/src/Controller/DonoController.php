<?php

namespace App\Controller;

use App\Entity\Cachorro;
use App\Entity\Dono;
use App\Form\DonoType;
use App\Repository\CachorroRepository;
use App\Repository\DonoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new(Request $request, DonoRepository $donoRepository, CachorroRepository $cachorroRepository): Response
    {
        $dono = new Dono();

        // $cachorro = new Cachorro();
        // $cachorro->setNome('Cachorro 1');
        // $cachorro->setDono($dono);
        // $dono->getCachorro()->add($cachorro);
        $form = $this->createForm(DonoType::class, $dono);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $donoRepository->save($dono, true);
           
            // $photo = $form->get('photo')->getData();

            // // this condition is needed because the 'brochure' field is not required
            // // so the PDF file must be processed only when a file is uploaded
            // if (!is_null($photo)) {
            //     $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            //     // this is needed to safely include the file name as part of the URL
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

            //     // Move the file to the directory where brochures are stored
            //     try {
            //         $photo->move(
            //             $this->getParameter('photos_directory'),
            //             $newFilename
            //         );
            //     } catch (FileException $e) {
            //         throw new \Exception('Opa, tem algum problema com seu arquivo');
            //     }

            //     // updates the 'brochureFilename' property to store the PDF file name
            //     // instead of its contents
            //     $cachorro->setPhoto($newFilename);
            // }
           
            // $cachorroRepository->save($cachorro, true);

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
        $cachorros = $dono->getCachorro();
        return $this->render('dono/show.html.twig', [
            'dono' => $dono,
            'cachorros' => $cachorros,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dono_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dono $dono, DonoRepository $donoRepository, CachorroRepository $cachorroRepository, SluggerInterface $slugger): Response
    {
        // $cachorro = new Cachorro();
        // $dono->getCachorro()->add($cachorro);


        
        // $cachorro->setNome('Cachorro');
        // $cachorro->setDono($dono);
        $form = $this->createForm(DonoType::class, $dono);
        $form->handleRequest($request);
        

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $donoRepository->save($dono, true);
           
        //     $photo = $form->get('photo')->getData();

        //     // this condition is needed because the 'brochure' field is not required
        //     // so the PDF file must be processed only when a file is uploaded
        //     if (!is_null($photo)) {
        //         $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        //         // this is needed to safely include the file name as part of the URL
        //         $safeFilename = $slugger->slug($originalFilename);
        //         $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

        //         // Move the file to the directory where brochures are stored
        //         try {
        //             $photo->move(
        //                 $this->getParameter('/uploads/files/'),
        //                 $newFilename
        //             );
        //         } catch (FileException $e) {
        //             // ... handle exception if something happens during file upload
        //         }

        //         // updates the 'brochureFilename' property to store the PDF file name
        //         // instead of its contents
        //         $cachorro->setPhoto($newFilename);
        //     }

        //     // ... persist the $product variable or any other work
           
        //     $cachorroRepository->save($cachorro, true);
        //     return $this->redirectToRoute('app_dono_index', [], Response::HTTP_SEE_OTHER);
        // }

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
