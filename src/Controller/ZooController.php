<?php

namespace App\Controller;

use App\Entity\Zoo;
use App\Repository\ZooRepository;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/zoo', name: 'app_api_zoo')]
class ZooController extends AbstractController
{
public function __construct(private EntityManagerInterface $manager, private ZooRepository $zooRepository)
{

}

    #[Route(name: 'new', methods: 'post')]
    public function new(): response
    {
        $zoo = new Zoo();
        $zoo->setName('Arcadia');
        $zoo->setDescription('ce zoo fait le bonheur de tous ces visiteur depuis 1963.');
       $zoo->setCreatedAt(new \DateTimeImmutable());

       $this->manager->persist($zoo);
       $this->manager->flush();
//a stoquer en bas de donnee
return $this->json(['message' => "zoo resource created with {$zoo->getId()} id"],
    
                Response::HTTP_CREATED,);

    }
    #[Route('/{id}', name: 'show', methods: 'get')]
    public function show(int $id): Response
    {
        $zoo = $this->zooRepository->findOneBy(['id' => $id]);
        if (!$zoo) 
        {throw new \Exception('No zoo found for {$id} id');}
        
        return $this->json(['message' => "A zoo was found : {$zoo->getName()} for {$zoo->getId()} id"]);   
    }

    #[Route('/{id}', name:'edit', methods: 'put')]
    public function edit(int $id): response
    {
        $zoo = $this->zooRepository->findOneBy(['id' => $id]);
          if (!$zoo) 
        {throw new \Exception("No zoo found for {$id} id");}
 
        $zoo->setName('zoo name updated');

        $this->manager->flush();

        return $this->redirectToRoute('app_api_zoo_show', ['id' => $zoo->getId()]);
    }

    #[Route('/{id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): response
    {
        $zoo = $this->zooRepository->findOneBy(['id' => $id]);
        if (!$zoo) 
        {throw new \Exception("No zoo found for {$id} id");}

        $this->manager->remove($zoo);
        $this->manager->flush();
        return $this->json(['message'=> 'zoo ressource delated'], Response::HTTP_NO_CONTENT);
    }
}
