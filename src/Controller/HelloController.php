<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    /**
     * Index
     * Return twig page
     *
     * @return Response
     */
    #[Route('/hello', name: 'hello')]
    public function index(): Response
    {

        $randomNumber = random_int(1, 99);

        return $this->render('hello/index.html.twig', [
            'random_number' => $randomNumber,
        ]);
    }

    /**
     * helloName
     * 
     * Says hello based on the route parameter
     *
     * @param string $name
     * @return Response
     */#[Route('/hello/{name}', name:'hello_name', methods: ['GET', 'HEAD'])]
    public function helloName(string $name): Response
    {
        return $this->json(
        [   'name' => 'name',
            'message' => 'Hello ' . $name,]
        );
    }
}
