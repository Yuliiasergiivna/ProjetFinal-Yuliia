<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PhotoType;
use App\Entity\Photo;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


final class PhotoController extends AbstractController
{
    
     #[Route('/photo', name:'app_photo')]
     
    public function index(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $formPhoto = $this->createForm(PhotoType::class);
        $formPhoto->handleRequest($request);

        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $photoEntity = $formPhoto->getData();

            /** @var UploadedFile $photoFile */
            $photoFile = $formPhoto->get('image')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );

                    // Mise à jour de l'entité avec le nom du fichier
                    $photoEntity->setUrl('/uploads/photos/' . $newFilename);
                    $photoEntity->setSlug($slugger->slug($photoEntity->getName()));

                    $em->persist($photoEntity);
                    $em->flush();

                    $this->addFlash('success', 'Photo téléchargée avec succès !');
                    return $this->redirectToRoute('app_photo');

                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de la photo.');
                }
            } else {
                $this->addFlash('warning', 'Veuillez sélectionner une photo valide.');
            }
        }

        // Récupérer toutes les photos pour les afficher
        $photos = $em->getRepository(Photo::class)->findAll();

        return $this->render('photo/index.html.twig', [
            'formPhoto' => $formPhoto->createView(),
            'photos' => $photos
        ]);
    }
}
