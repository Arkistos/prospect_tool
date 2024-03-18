<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Client;
use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name:'categories')]
    public function clients(
        EntityManagerInterface $entityManager
    ):Response
    {
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('/clients/main.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categories/add', name:'categories_add')]
    public function categoriesAdd(
        Request $request,
        EntityManagerInterface $entityManager
    ):Response
    {
        $categoryForm = $this->createForm(CategoryFormType::class);

        $categoryForm->handleRequest($request);
        
        if($categoryForm->isSubmitted() && $categoryForm->isValid()){
            $category = $categoryForm->getData();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render('categories/add.html.twig',[
            'categoryForm' => $categoryForm
        ]);
    }


    #[Route('/categories/{name}', name:'clients_category')]
    public function clientCategory(
        Category $category,
        EntityManagerInterface $entityManager
    ):Response
    {

        $clients = $entityManager->getRepository(Client::class)->findBy([
            'category' => $category->getId()
        ]);
        

        return $this->render('clients/dashboard.html.twig', [
            'category' => $category,
            'clients' => $clients
        ]);
    }

    #[Route('/categories/delete/{id}', name:'categories_delete')]
    public function categoriesDelete(
        Category $category,
        EntityManagerInterface $entityManager
    ):Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('categories');
    }

    #[Route('categories/update/{id}', name:'categories_update')]
    public function categoriesUpdate(
        Category $category,
        EntityManagerInterface $entityManager,
        Request $request
    ):Response
    {

        $categoryForm = $this->createForm(CategoryFormType::class,$category);
        $categoryForm->handleRequest($request);

        if($categoryForm->isSubmitted() && $categoryForm->isValid()){

            $category = $categoryForm->getData();
            $entityManager->flush();

            return $this->redirectToRoute('categories');
        }

        return $this->render('categories/add.html.twig', [
            'categoryForm' => $categoryForm
        ]);
    }

}
