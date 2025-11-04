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



final class ProfilPhotoController extends AbstractController
{
    #[Route('/profil/photo', name: 'app_profil_photo')]
    public function editPhoto(Request $request, EntityManagerInterface $em)
    {
                /** @var Utilisateur $user */
        $user = $this->getUser();

        $form = $this->createForm(ProfilPhotoType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Erreur lors de l\'upload de la photo.');
                }

                $user->setPhoto($newFilename);
            }

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Photo de profil mise à jour avec succès !');

            return $this->redirectToRoute('app_profile_photo');
        }
        return $this->render('profil_photo/index.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
