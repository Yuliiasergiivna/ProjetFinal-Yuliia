<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategorieType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


final class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Get the repository for Category entity
        $categoryRepository = $entityManager->getRepository(Category::class);
        
        // Fetch 5 categories (you might want to add some ordering)
        $categories = $categoryRepository->findBy([], ['id' => 'ASC'], 5);
        
        $formCategorie = $this->createForm(CategorieType::class);
        
        return $this->render('category/index.html.twig', [
            'formCategorie' => $formCategorie->createView(),
            'categories' => $categories
        ]);
    }
    
    #[Route('/category/insert_categorie', name: 'app_category_insert_categorie')]
    public function insertCategorie(Request $request , EntityManagerInterface $entityManager): Response
    { $categorie = new Category();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);
        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('app_category_resultat');
        }else{
            $vars = ['formCategorie' => $formCategorie];
            return $this->render('category/afficher_category.html.twig',$vars);  
        
        }
    } #[Route('/category/afficher_resultat', name: 'app_category_resultat')]
    public function afficherResultatTraitementFormInsert(EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Category::class);
        $arrayCategorie = $categorie->findAll();

        $vars = [
            'arrayCategorie' => $arrayCategorie
        ];
        return $this->render('category/afficher_resultat.html.twig', $vars);
    }
}
