<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder; }

        /**
         * @Route ("/subscribe", name="user-subscribe")
         */
        public
        function subscribe(Request $request, EntityManagerInterface $em): Response
        {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('home_page_route');
            }
            return $this->render("security/subscribe.html.twig", [
                'form' => $form->createView(),

            ]);
        }
    }