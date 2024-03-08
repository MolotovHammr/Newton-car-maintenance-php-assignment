<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController
{   
    #[Route('/fun-text')]
    public function funText()
    {
        return new Response('This is a fun text!');
    }
}
