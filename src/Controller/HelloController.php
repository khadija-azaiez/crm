<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    /**
     * @Route("/", name="home_page")
     */
    public function hello(): Response
    {
        return new Response('salut Daj');
    }
}
