<?php


namespace App\Controller;


use App\Entity\Spend;
use App\Form\SearchSpendType;
use App\Form\SpendType;
use App\Repository\SpendRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpendController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route ("/spend", name="spend-list")
     */
    public function index(Request $request, SpendRepository $spendRepository): Response
    {
        $show = '';
        $form = $this->createForm(SearchSpendType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $show = 'show';
            /**@var  Spend $spend */
            $spend = $form->getData();
            $spends = $spendRepository->findBySpendField($spend->getMontant(), $spend->getLabel());

        } else {
            $spends = $spendRepository->getAllSpends();
        }

        return $this->render('caisse/spend.html.twig', [
            'form' => $form->createView(),
            'spends' => $spends,
            'show' => $show
        ]);

    }

    /**
     * @Route("/spend/add", name="spend-add")
     */
    public function add(Request $request): Response
    {
        $spends = new Spend();
        $form = $this->createForm(SpendType::class, $spends);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($spends);
            $this->em->flush();

            return $this->render("caisse/spend-view.html.twig", [
                'view' => $spends
            ]);
        }

        return $this->render("caisse/spend-add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Ajouter',

        ]);
    }

    /**
     * @Route ("/spend/edit/{id}", name="spend-edit")
     */
    public function edit($id, SpendRepository $spendRepository, Request $request): Response
    {
        $spend = $spendRepository->find($id);
        $form = $this->createForm(SpendType::class, $spend);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->merge($spend);
            $this->em->flush();

            return $this->render("caisse/spend-view.html.twig", [
                'view' => $spend
            ]);
        }

        return $this->render("caisse/spend-add.html.twig", [
            'form' => $form->createView(),
            'mode' => 'Modifier'
        ]);
    }

    /**
     * @Route ("/spend/delete/{id}", name="spend-delete")
     */
    public function delete($id, SpendRepository $spendRepository): Response
    {
        $spend = $spendRepository->find($id);
        $this->em->remove($spend);
        $this->em->flush();
        return $this->redirectToRoute('spend-list');

    }

}