<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;

class FileUploadController extends AbstractController
{
    private string $photoDirectory;

    public function __construct(string $photo_directory)
    {
        $this->photoDirectory = $photo_directory;
    }

    #[Route('/upload/photo', name: 'app_upload_photo')]
    public function uploadPhoto(Request $request, SluggerInterface $slugger): Response
    {
        $file = $request->files->get('photo');
        
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->photoDirectory,
                    $newFilename
                );

                return $this->json([
                    'success' => true,
                    'filename' => $newFilename
                ]);
            } catch (FileException $e) {
                return $this->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 400);
            }
        }

        return $this->json([
            'success' => false,
            'error' => 'Aucun fichier téléchargé'
        ], 400);
    }
}
