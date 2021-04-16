<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use App\Service\CustomerService;
use App\Service\SearchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var CustomerRepository */
    private $customerRepository;

    /** @var CustomerService */
    private $customerService;


    public function __construct(CustomerService $custser, EntityManagerInterface $manager, CustomerRepository $repos)
    {
        $this->customerService = $custser;
        $this->em = $manager;
        $this->customerRepository = $repos;

    }

    /**
     * @Route ("/customer", name="customer-list")
     */
    public function index(): Response
    {
        $customer = $this->customerRepository->findAll();
        return $this->render('customer/index.html.twig', [
            'listecust' => $customer
        ]);
    }

    /**
     * @Route("/customer/view/{id}", name="customer-view")
     */
    public function view($id): Response
    {
        $affich= $this->customerRepository->find($id);

        return $this->render('customer/view.html.twig', [
            'affichcust' => $affich
        ]);
    }
 /**
  * @Route ("/customer/add", name="customer-add")
  */
 public function add( Request $request):Response
 {
     $customer = new Customer();
     $form = $this->createForm(CustomerType::class, $customer);

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $this->em->persist($customer);
         $this->em->flush();

         return $this->render('customer/view.html.twig', [
             'affichcust' => $customer]);
     }
     return $this->render("customer/add.html.twig", [
         'form' => $form->createView(),
         'btnName' => 'ajouter'
     ]);
 }

    /**
     * @Route ("/customer/edit/{id}", name="customer-edit")
     */
 public function edit($id, Request $request): Response
 {

     $customer = $this->customerRepository->find($id);
     $form = $this->createForm(CustomerType::class, $customer);

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
         $this->em->merge($customer);
         $this->em->flush();

         return $this->render('customer/view.html.twig', [
             'affichcust' => $customer]);
     }
     return $this->render("customer/add.html.twig", [
         'form' => $form->createView(),
         'btnName' => 'modifier'
     ]);
 }

    /**
     * @Route ("/customer/delete/{id}", name="customer-delete")
     */
 public function delete($id): Response
 {
     $product= $this->customerRepository->find($id);

     $this->em->remove($product);
     $this->em->flush();

     return $this->redirectToRoute('customer-list');
 }
}
