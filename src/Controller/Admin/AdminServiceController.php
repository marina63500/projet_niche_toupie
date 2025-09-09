<?php

namespace App\Controller\Admin;


use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function add(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // --- Upload image principale ---
            // $imageFile = $form->get('image')->getData();
            // if ($imageFile) {
            //     $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            //     $imageFile->move(
            //         $this->getParameter('images_directory'),
            //         $newFilename
            //     );

            //     $service->setImage($newFilename);
            // }

            // --- Upload image header ---
            // $imageHeaderFile = $form->get('ImageHeader')->getData();
            // if ($imageHeaderFile) {
            //     $originalFilename = pathinfo($imageHeaderFile->getClientOriginalName(), PATHINFO_FILENAME);
            //     $safeFilename = $slugger->slug($originalFilename);
            //     $newFilename = $safeFilename.'-'.uniqid().'.'.$imageHeaderFile->guessExtension();

            //     $imageHeaderFile->move(
            //         $this->getParameter('images_directory'),
            //         $newFilename
            //     );

            //     $service->setImageHeader($newFilename);
            // }

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
    public function edit(int $id, ServiceRepository $serviceRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            throw $this->createNotFoundException('Service not found');
        }

        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('admin_service_index');
    }
}