<?php

namespace App\Controller\Admin;


use App\Entity\Service;
use App\Form\ServiceFullType;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/admin/service')]
final class AdminServiceController extends AbstractController
{
    // routes de tous les services pour l'admin
    #[Route('', name: 'admin_service_index')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();

        return $this->render('admin_service/index.html.twig', [
            'services' => $services,
        ]);
    }

    // route d'un service 
    #[Route('/show/{id}', name: 'admin_service_show')]
    public function show(int $id, ServiceRepository $serviceRepository): Response
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        return $this->render('admin_service/show.html.twig', [
            'service' => $service
        ]);
    }

    // ajout d'un service par l'admin
    #[Route('/add', name: 'admin_service_add')]
    public function add(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger, ParameterBagInterface $param): Response
    {
        $service = new Service();

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // dossier la ou doivent etre les uploads
            $directory = $param->get('uploads_directory');

            //je recupere le champ du form
            //ex : chat bleu.jpg
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                //chat bleu
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);

                //chatbleu
                $safeFilename = $slugger->slug($originalFilename);

                //chatbleu-5f2c1e7e8c9a3.jpg
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                //deplace du dossier temporaire vers mon uploads
                $imageFile->move(
                    $directory,
                    $newFilename
                );

                //on met dans l'entitée service le vrai chemin
                $service->setImage("uploads/" . $newFilename);
            }



            // $service->setImageHeader($newFilename);
            // pour ImageHeader
              $imagefileHeader = $form->get('ImageHeader')->getData();
            if ($imagefileHeader) {
                //chat bleu
                $originalHeadername = pathinfo($imagefileHeader->getClientOriginalName(), PATHINFO_FILENAME);

                //chatbleu
                $safeFileheader = $slugger->slug($originalHeadername);

                //chatbleu-5f2c1e7e8c9a3.jpg
                $newheader = $safeFileheader . '-' . uniqid() . '.' . $imagefileHeader->guessExtension();

                //deplace du dossier temporaire vers mon uploads
                $imagefileHeader->move(
                    $this->getParameter('uploads_directory'),
                    $newheader
                );

                //on met dans l'entitée service le vrai chemin
                $service->setImageHeader("uploads/" . $newheader);
            }




            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Service ajouté avec succès.');
            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin_service/add.html.twig', [
            'form' => $form->createView(),
            'service' => $service
        ]);
    }

    // modification d'un service par l'admin
    #[Route('/edit/{id}', name: 'admin_service_edit')]
    public function edit(
        int $id,
        ServiceRepository $serviceRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        SluggerInterface $slugger,
        ParameterBagInterface $param
    ): Response {

        $service = $serviceRepository->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        //je recupere les anciennes images/imageHeader
        $oldImage = $service->getImage();
        $oldImageHeader = $service->getImageHeader();

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
        //dossier la ou doivent etre les uploads
            $directory = $param->get('uploads_directory');

            // on gere juste le champ image
            //ex : chat bleu petit.jpg
            $image = $form->get('image')->getData();
            if ($image) {
                //chat bleu petit sans extension
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

                //chat-bleu-petit
                $safeFilename = $slugger->slug($originalFilename);

                //chat-bleu-petit-5f2c1e7e8c9a3.jpg
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                $image->move($directory, $newFilename);
                $service->setImage('uploads/' . $newFilename);
            } else {
                // si pas de nouvelle image, on remet l'ancienne
                $service->setImage($oldImage);
            }


            // le champ imageHeader
            $imageHeader = $form->get('ImageHeader')->getData();
            if ($imageHeader) {
                //chat bleu
                $originalHeadername = pathinfo($imageHeader->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileheader = $slugger->slug($originalHeadername);
                $newheader = $safeFileheader . '-' . uniqid() . '.' . $imageHeader->guessExtension();

                $imageHeader->move($directory, $newheader);
                $service->setImageHeader("uploads/" . $newheader);
            } else {
                // si pas de nouvelle image, on remet l'ancienne
                $service->setImageHeader($oldImageHeader);
            }

            // envoi en base
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Service modifié avec succès.');

            return $this->redirectToRoute('admin_service_index');
        }

        return $this->render('admin_service/edit.html.twig', [
            'form' => $form->createView(),
            'service' => $service
        ]);
    }

    // suppression d'un service par l'admin
    #[Route('/delete/{id}', name: 'admin_service_delete')]
    public function delete(int $id, ServiceRepository $serviceRepository, EntityManagerInterface $entityManager): Response
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }


        // supprimer les réservations associées au service  
              count($service->getReservations());

              if (count($service->getReservations()) > 0) {
                  $this->addFlash('error', 'Impossible de supprimer ce service car il est associé à des réservations.');
                  return $this->redirectToRoute('admin_service_index');
              }


        $entityManager->remove($service);
        $entityManager->flush();

        $this->addFlash('success', 'Service supprimé avec succès.');

        return $this->redirectToRoute('admin_service_index');
    }
}
