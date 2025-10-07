<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\PhotoType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class PhotoController extends AbstractController
{
    #[Route('/photo', name: 'app_photo')]
    public function index(Request $request, EntityManagerInterface $em,SluggerInterface $slugger): Response
    {
        $formPhoto = $this->createForm(PhotoType::class);
        $formPhoto->handleRequest($request);
        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            $photo = $formPhoto->getData();
            $photo->setSlug($slugger->slug($photo->getName()));
            $em->persist($photo);
            $em->flush();
            return $this->redirectToRoute('app_photo');
            if($photo){
                $originaleFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originaleFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
                try{
                    $photo->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                }catch(FileException $e){
                    
                }
            }
        }
        

        $this->addFlash('succes','Photo téléchargée avec succès !');
        return $this->render('photo/index.html.twig',['formPhoto'=>$formPhoto->createView()]);
    }
 //   return $this->render('photo/index.html.twig');


}
