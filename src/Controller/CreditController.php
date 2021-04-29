<?php


namespace App\Controller;


use App\Entity\Credit;
use App\Entity\Customer;
use App\Form\CreditType;
use App\Form\SearchCustomerType;
use App\Repository\CreditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;


class CreditController extends AbstractController
{

    /** @var CreditRepository */
    private $creditRepository;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManager, CreditRepository $creditRepository)
    {
        $this->em = $entityManager;
        $this->creditRepository = $creditRepository;
    }

    /**
     * @Route ("/credit", name="credit-list")
     */
    public function index(Request $request): Response
    {
        $show = true;
        $form = $this->createForm(SearchCustomerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var Customer $customer */
            $customer = $form->getdata();
            $credit = $this->creditRepository->findCreditByCustomer($customer->getname());

        } else{
            $show = false;
            $credit = $this->creditRepository->getAllCredits();
        }

        return $this->render("credit/index.html.twig", [
            'form' => $form->createView(),
            'show' =>$show,
            'credits' => $credit
        ]);

    }

    /**
     * @Route ("/credit/view/{id}", name="credit-view")
     */
    public function view($id): Response
    {
        $credit = $this->creditRepository->find($id);

        return $this->render("credit/view.html.twig", [
            'credit' => $credit
        ]);

    }

    /**
     * @Route ("/credit/add", name="credit-add")
     */
    public function add(Request $request): Response
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($credit);
            $this->em->flush();

            return $this->render("credit/view.html.twig", [
                'credit' => $credit
            ]);
        }

        return $this->render("credit/add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Ajouter'
        ]);

    }

    /**
     * @Route ("/credit/edit/{id}", name="credit-edit")
     */
    public function edit(Request $request, $id): Response
    {
        $credit = $this->creditRepository->find($id);
        $form = $this->createForm(CreditType::class, $credit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->merge($credit);
            $this->em->flush();
            return $this->render("credit/view.html.twig", [
                'credit' => $credit
            ]);
        }
        return $this->render("credit/add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Modifier'
        ]);

    }

    /**
     * @Route ("/credit/delete/{id}", name="credit-delete")
     */
    public function delete(Request $request, $id): Response
    {
        $credit = $this->creditRepository->find($id);
        $this->em->remove($credit);
        $this->em->flush();
        return $this->redirectToRoute('credit-list');

    }

}