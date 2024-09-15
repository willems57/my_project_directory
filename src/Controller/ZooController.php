<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/zoo', name: 'app_api_zoo')]
class ZooController extends AbstractController
{
    #[Route(name: 'new', methods: 'post')]
    public function new(): response
    {

    }
    #[Route('/', name: 'show', methods: 'get')]
    public function show(): response
    {
        return $this->json(['message'=> 'zoo de ma BDD']);
    }
    #[Route('/', name:'edit', methods: 'put')]
    public function edit(): response
    {

    }
    #[Route('/', name: 'delete', methods: 'delete')]
    public function delete(): response
    {

    }
}
