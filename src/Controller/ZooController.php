<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ZooController extends AbstractController
{
    #[Route('/zoo', name: 'app_zoo')]
    public function index(): Response
    {
        return $this->render('zoo/index.html.twig', [
            'controller_name' => 'ZooController',
        ]);
    }
}
