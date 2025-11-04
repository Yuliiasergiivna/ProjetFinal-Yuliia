<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Form\ProfilPhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var Utilisateur $user */
        $user = $this->getUser();
        
        return $this->render('profil/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profil/photo', name: 'app_profile_photo', methods: ['POST'])]
    public function updatePhoto(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var Utilisateur $user */
        $user = $this->getUser();

        $photoFile = $request->files->get('photo');
        if (!$photoFile) {
            $this->addFlash('warning', 'Aucune photo sélectionnée.');
            return $this->redirectToRoute('app_profil');
        }

        $newFilename = uniqid( "", true) . '.' . $photoFile->guessExtension();

            try {
                $photoFile->move(
                    $this->getParameter('photo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                $this->addFlash('danger', 'Erreur lors du téléchargement de la photo.');
                return $this->redirectToRoute('app_profil');
            }

            // Удаляем старое фото, если есть
            if ($user->getPhoto()) {
                $oldPath = $this->getParameter('photo_directory') . '/' . $user->getPhoto();
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $user->setPhoto($newFilename);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Photo de profil mise à jour avec succès !');


            return $this->redirectToRoute('app_profil');
    }
    #[Route('/profil/photo/delete', name: 'app_profile_photo_delete', methods: ['POST'])]
    public function deletePhoto(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        /** @var Utilisateur $user */
        $user = $this->getUser();

        if ($user->getPhoto()) {
            $photoPath = $this->getParameter('photo_directory') . '/' . $user->getPhoto();
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            $user->setPhoto(null);
            $em->flush();
            $this->addFlash('success', 'Votre photo de profil a été supprimée.');
        } else {
            $this->addFlash('warning', 'Aucune photo de profil trouvée.');
        }

        return $this->redirectToRoute('app_profil');
    }
}


