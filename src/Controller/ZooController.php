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
        $zoo = new Zoo();
        $zoo->setName('Arcadia');
        $zoo->setDescription('ce zoo fait le bonheur de tous ces visiteur depuis 1963.');
       $zoo->setCreatedAt(new DateTimeImmutable(1963));
//a stoquer en bas de donnee
return $this->json(['message' => "zoo resource created with {$zoo->getId()} id"],
    
                Response::HTTP_CREATED,);

    }
    #[Route('/show', name: 'show', methods: 'get')]
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
