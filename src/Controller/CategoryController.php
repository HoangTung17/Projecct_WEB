<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    #[Route('/category/api/viewall',methods: ['GET'], name: 'category_viewall_api')]
    public function viewAllCategoryAPI(SerializerInterface $serializer) {
        $categories = $this -> getDoctrine() -> getRepository(Category::class) ->findAll();

        $data = $serializer -> serialize($categories, 'json');
        return new Response(
            $data,
            Response::HTTP_OK,
            [
                "content-type" => "application/json"
            ]
        );
    }

    #[Route('/category/api/view/{id}',methods: ['GET'], name: 'view_category_by_Id')]
    public function viewCategoryByIdAPI(SerializerInterface $serializer, $id) {
        $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);
        /* SQL: "SELECT * FROM Author WHERE id = '$id" */
        if ($category == null) {
            $error = "ERROR: Invalid Category ID";
            return new Response(
                $error,
                Response::HTTP_NOT_FOUND
            );
        }

        $data = $serializer->serialize($category, 'xml');
        return new Response(
            $data,
            200,
            [
                "content-type" => "application/xml"
            ]
        );
    }

    #[Route('/category/api/delete/{id}',methods: ['DELETE'], name: 'delete_category_by_Id')]
    public function deleteCategoryAPI($id) {
        try{
            $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);
            
            if ($category == null) {
                return new Response(
                    "Category ID Invalid",
                    Response::HTTP_BAD_REQUEST
                );
            }

            $manager = $this -> getDoctrine() -> getManager();
            $manager -> remove($category);
            $manager -> flush();
            return new Response(
                "Category has been deleted",
                Response::HTTP_FOUND
            );
             
        }catch(\Exception $e){ 
            return new Response(
                json_encode(["ERROR " => $e -> getMessage()]),
                Response::HTTP_BAD_REQUEST,
                [
                    "content-type" => "application/json"
                ]
            );
        }
    }

    #[Route('/category/api/create',methods: ['POST'], name: 'create_category')]
    public function createCategoryAPI(Request $request) {
        try {
            $category = new Category();
            $data = json_decode($request -> getContent(), true);
            $category->setCatName($data['catName']);
            $category->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));

            $manager = $this -> getDoctrine() -> getManager();
            $manager->persist($category);
            $manager->flush();
            return new Response(
                "Category has been created",
                Response::HTTP_OK
            );
        }catch (\Exception $e) {
            return new Response(
                json_encode(["Error " => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                [
                    "content-type" => "application/json"
                ]
            );
        }
    }

    #[Route('/category/api/update/{id}',methods: ['PUT'], name: 'upadte_category')]
    public function updateCategoryAPI(Request $request, $id) {
        try {
            $category = $this -> getDoctrine() -> getRepository(Category::class) ->find($id);
            $data = json_decode($request -> getContent(), true);
            $category->setCatName($data['catName']);
            $category->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));

            $manager = $this -> getDoctrine() -> getManager();
            $manager->persist($category);
            $manager->flush();
            return new Response(
                "Category has been updated",
                Response::HTTP_OK
            );
        }catch (\Exception $e) {
            return new Response(
                json_encode(["Error " => $e->getMessage()]),
                Response::HTTP_BAD_REQUEST,
                [
                    "content-type" => "application/json"
                ]
            );
        }
    }

    #[Route('/category',methods: ['GET'], name: 'category_index')]
    public function viewAllCategory() {
        $categories = $this -> getDoctrine() -> getRepository(Category::class) -> findAll();
        
        return $this -> render( 
            "category/index.html.twig",
            [
                'categories' => $categories
            ]
        );
    }

    #[Route('/category/detail/{id}', name: 'view_category_detail_id')]
    public function viewAllCategoryById($id) {
        $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);
        /* SQL: "SELECT * FROM Author WHERE id = '$id'" */
        if ($category == null) {
            return $this -> render(
                "category/notfound.html.twig",
            );
        }
        return $this -> render( 
            "category/detail.html.twig",
            [
                'category' => $category
            ]
        );
    }
    #[Route('/category/delete/{id}', name: 'category_delete')]
    public function deleteCategory($id) {
        $category = $this -> getDoctrine() -> getRepository(Category::class)-> find($id);
        /* SQL: "DELETE FROM Author WHERE id = '$id'" */
        if($category == null) {
            $this -> addFlash("Error", "Category ID in valid");
            return $this -> redirectToRoute("category_index");
        }

        $manager = $this -> getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();
        $this -> addFlash("Success", "Category has been deleted");
        return $this -> redirectToRoute("category_index");
     }

     #[Route('/category/create', name: 'category_create')]
    public function createCategory(Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this -> getDoctrine() -> getManager();
            $manager->persist($category);
            $manager->flush();
            $this -> addFlash("Success", "Add Category Successfully");
            return $this -> redirectToRoute('category_index');
        }

        return $this->render(
            "category/create.html.twig",
            [
                "form" => $form->createView()
            ]
        );
     }

     #[Route('/category/update/{id}', name: 'category_update')]
     public function updateCategory(Request $request, $id) {
         $category = $this -> getDoctrine() -> getRepository(Category::class) -> find($id);

         $form = $this->createForm(CategoryFormType::class, $category);
         $form -> handleRequest($request);

         
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this -> getDoctrine() -> getManager();
            $manager->persist($category);
            $manager->flush();
            $this -> addFlash("Success", "Update Category Successfully");
            return $this -> redirectToRoute('category_index');
        }

        return $this -> render(
            "category/update.html.twig",

            [
                "form" => $form -> createView()
            ]
        );
      }
}
