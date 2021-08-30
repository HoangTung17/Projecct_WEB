<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use function PHPUnit\Framework\throwException;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'product_list')]
    public function listProduct() {
        $products = $this -> getDoctrine() -> getRepository(Product::class)->findAll();
        return $this ->  render(
            'product/index.html.twig',
            [
                'products' => $products,
            ]
        );
    }

    #[Route('/product/detail/{id}', name: 'product_detail')]
    public function detailProduct($id) {
        $product = $this -> getDoctrine() -> getRepository(Product::class) -> find($id);
        /* SQL: "SELECT * FROM Author WHERE id = '$id'" */
        if ($product == null) {
            return $this -> render(
                "product/notfound.html.twig",
            );
        }
        return $this -> render( 
            "product/detail.html.twig",
            [
                'product' => $product
            ]
        );
    }

    #[Route('/product/create', name: 'product_create')]
    public function createProduct(Request $request) {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //get image from upload file
            $image = $product->getImage();
            
            //create unique image name
            $fileName = md5(uniqid());
            //get image extension
            $fileExtension = $image->guessExtension();
            //combine image name + image extension => complete image name
            $imageName = $fileName . '.' . $fileExtension;
            
            //move uploaded image to defined location
            try {
                $image->move(
                    $this->getParameter('product_image'), $imageName
                );
            } catch (FileException $e) {
                throwException($e);
            }

            //set imageName to database
            $product->setImage($imageName);

            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash("Success","Add product successfully !");
            return $this->redirectToRoute("product_list");
        }

        return $this->render(
            "product/create.html.twig",
            [
                "form" => $form->createView()
            ]
        );
    }


    #[Route('/product/update/{id}', name: 'product_update')]
    public function updateProduct(Request $request, $id) {
        $product = $this -> getDoctrine() -> getRepository(Product::class) -> find($id);
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //get image from upload file

            $image = $product->getImage();
            
            if ($image) {
                $fileName = md5(uniqid());
            //get image extension
                $fileExtension = $image->getExtension();
                //combine image name + image extension => complete image name
                $imageName = $fileName . '.' . $fileExtension;
                
                //move uploaded image to defined location
                try {
                    $image->move(
                        $this->getParameter('product_image'), $imageName
                    );
                } catch (FileException $e) {
                    throwException($e);
                }
                $product->setImage($imageName);

            }
            //create unique image name
          

            //set imageName to database

            $manager = $this->getDoctrine()
                            ->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash("Success","Add product successfully !");
            return $this->redirectToRoute("product_list");
        }

        return $this->render(
            "product/create.html.twig",
            [
                "form" => $form->createView()
            ]
        );
    }

    #[Route('/product/delete/{id}', name: 'product_delete', methods: ['GET'])]
    public function deleteOne(int $id) : Response {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);
        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirect('/product', 301);
    }
}
