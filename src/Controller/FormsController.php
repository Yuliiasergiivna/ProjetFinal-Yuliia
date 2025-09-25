<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategorieType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class FormsController extends AbstractController
{
    // #[Route('/afficher_form', name: 'app_forms_controler')]
    // public function afficherForm(): Response
    // {
        //cree un objet categorie
        
        // $formCategorie = $this->createForm(CategorieType::class);
        // dd($formCategorie);
        // $vars = [
        //     'formCategorie' => $formCategorie->createView()
        // ];

        //faire rendu de la vue
        
    //     return $this->render('forms_controler/afficher_form.html.twig', $vars);
    // }

    #[Route('/forms_controler/insert_categorie', name: 'app_forms_controler_insert_categorie')]
    public function insertCategorie(Request $request , EntityManagerInterface $entityManager): Response
    { $categorie = new Category();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        // dd($formCategorie);

        // recupere les données du formulaire
        $formCategorie->handleRequest($request);
        // verifie si le formulaire est soumis et valide
        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('app_forms_controler_resultat_traitement_form_insert');
        }else{
            $vars = ['formCategorie' => $formCategorie];
            return $this->render('forms_controler/afficher_forms_insert_categorie.html.twig',$vars);  
        
        }

    }
    #[Route('/forms_controler/afficher_resultat_traitement_form_insert', name: 'app_forms_controler_resultat_traitement_form_insert')]
    public function afficherResultatTraitementFormInsert(EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Category::class);
        $arrayCategorie = $categorie->findAll();

        $vars = [
            'arrayCategorie' => $arrayCategorie
        ];
        return $this->render('forms_controler/afficher_resultat_traitement_form_insert.html.twig', $vars);
    }



}
