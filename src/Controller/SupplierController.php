<?php


namespace App\Controller;


use App\Entity\Supplier;
use App\Form\SearchSupplierType;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use App\Service\SearchService;
use App\Service\SupplierService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var SupplierRepository */
    private $supplierrep;

    public function __construct(EntityManagerInterface $entity, SupplierRepository $supplier)
    {
        $this->em = $entity;
        $this->supplierrep = $supplier;

    }

    /**
     * @Route ("/supplier", name="supplier-list")
     */
    public function index(Request $request): Response
    {
        $showForm = '';

        $form = $this->createForm(SearchSupplierType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $showForm = 'show';
            $supplier = $form->getData();
            $suppliers = $this->supplierrep->findBySupplier($supplier->getName());
        } else {
            $suppliers = $this->supplierrep->findAll();
        }

        return $this->render('supplier/index.html.twig', [
            'form' => $form->createView(),
            'suppliers' => $suppliers,
            'show' => $showForm
        ]);

    }

    /**
     * @Route ("/supplier/view/{id}", name="supplier-view")
     */
    public function view($id): Response
    {
        $affich = $this->supplierrep->find($id);

        return $this->render('supplier/view.html.twig', [
            'affichage' => $affich
        ]);

    }

    /**
     * @Route("/supplier/add", name="supplier-add")
     */
    public function add(Request $request): Response
    {
        $supplier = new Supplier();
        $form = $this->createForm(SupplierType::class, $supplier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($supplier);
            $this->em->flush();

            return $this->render("supplier/view.html.twig", [
                'affichage' => $supplier
            ]);
        }

        return $this->render("supplier/add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Ajouter'
        ]);
    }

    /**
     * @Route ("/supplier/edit/{id}", name="supplier-edit")
     */

    public function edit($id, Request $request): Response
    {
        $supplier = $this->supplierrep->find($id);
        $form = $this->createForm(SupplierType::class, $supplier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->merge($supplier);
            $this->em->flush();

            return $this->render("supplier/view.html.twig", [
                'affichage' => $supplier
            ]);
        }

        return $this->render("supplier/add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Modifier'
        ]);

    }

    /**
     * @Route ("supplier/delete/{id}", name="supplier-delete")
     */

    public function delete($id): Response
    {
        $supplier = $this->supplierrep->find($id);
        $this->em->remove($supplier);
        $this->em->flush();

        return $this->redirectToRoute('supplier-list');


    }


}

