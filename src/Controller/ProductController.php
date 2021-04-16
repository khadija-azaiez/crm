<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ProductRepository */
    private $productRepository;

    /** @var ProductService */
    private $productService;

    public function __construct(ProductService $proServ, EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->productService = $proServ;
        $this->em = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route ("/product", name="product-list")
     */
    public function index(Request $request): Response
    {
        $prix = $request->query->get('prixKey');
        if (null === $prix) {
            $products = $this->productRepository->findAll();
        } else {
            $products = $this->productRepository->findProductsGraterThanValue($prix);
        }

        return $this->render("product/index.html.twig", [
            'porducts' => $products
        ]);
    }

    /**
     * @Route ("/product/view/{id}", name="product-view")
     */
    public function view($id): Response
    {
        $product = $this->productRepository->find($id);

        return $this->render("product/view.html.twig", [
            'affichage' => $product,
        ]);
    }

    /**
     * @Route("/product/add", name="product-add")
     */
    public function add(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();

            return $this->render("product/view.html.twig", [
                'affichage' => $product,
            ]);
        }

        return $this->render("product/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/edit/{id}", name="product-edit")
     */
    public function edit($id, Request $request): Response
    {
        $product = $this->productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->merge($product);
            $this->em->flush();

            return $this->render("product/view.html.twig", [
                'affichage' => $product,
            ]);
        }

        return $this->render("product/add.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product-delete")
     */
    public function delete($id): Response
    {
        $product = $this->productRepository->find($id);

        $this->em->remove($product);
        $this->em->flush();

        return $this->redirectToRoute('product-list');
    }
}
