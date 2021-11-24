<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProductController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ProductRepository */
    private $productRepository;


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
        $showForm = true;
        $form = $this->createForm(SearchProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Product $product */
            $product = $form->getData();

            $products = $this->productRepository->findProductsGraterThanValue($product->getPrix());
        } else {
            $showForm = false;
            $products = $this->productRepository->getAllProducts();
        }

        return $this->render("product/index.html.twig", [
            'form' => $form->createView(),
            'showForm' => $showForm,
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
     *  @IsGranted("ROLE_ADMIN")
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
            'form' => $form->createView(),
            'mode' => 'Ajouter'
        ]);
    }


    /**
     * @Route("/product/edit/{id}", name="product-edit")
     *  @IsGranted("ROLE_ADMIN")
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
            'form' => $form->createView(),
            'mode' => 'Modifier'
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product-delete")
     *  @IsGranted("ROLE_ADMIN")
     */
    public function delete($id): Response
    {
        $product = $this->productRepository->find($id);

        $this->em->remove($product);
        $this->em->flush();

        return $this->redirectToRoute('product-list');
    }
}
