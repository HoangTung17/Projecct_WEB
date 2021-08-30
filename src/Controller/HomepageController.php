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

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products = $entityManager->getRepository(Product::class)->findAll();
        return $this->render('homepage/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/homepage/detail/{id}', name: 'homepage_product_detail')]
    public function detailProduct($id) {
        $product = $this -> getDoctrine() -> getRepository(Product::class) -> find($id);
        /* SQL: "SELECT * FROM Author WHERE id = '$id'" */
        if ($product == null) {
            return $this -> render(
                "homepage/notfound.html.twig",
            );
        }
        return $this -> render( 
            "homepage/product_detail.html.twig",
            [
                'product' => $product
            ]
        );
    }
}
