<?php

namespace App\Controller;

use App\Entity\Rapportsverinaires;
use App\Repository\RapportsverinairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('api/Rapportsverinaires', name: 'app_api_Rapportsverinaires')]
class RapportsrerinairesController extends AbstractController

{
public function __construct(
    private EntityManagerInterface $manager, 
    private RapportsverinairesRepository $rapportsverinairesRepository,
    private SerializerInterface $serializer,
private UrlGeneratorInterface $urlhenerator
    )
{

}

    #[Route(name: 'new', methods: 'post')]
    public function new(): response
    {
       $Rapportsverinaires = new Rapportsverinaires(); 
       $Rapportsverinaires->setDate(new \DateTimeImmutable());
       $Rapportsverinaires->setDetails('');
       $this->manager->persist($Rapportsverinaires);
       $this->manager->flush();

//a stoquer en bas de donnee
return $this->json(['message' => "Rapportsverinaires resource created with {$Rapportsverinaires->getId()} id"],
    
                Response::HTTP_CREATED,);

    }
    #[Route('/{id}', name: 'show', methods: 'get')]
    public function show(int $id): Response
    {
        $Rapportsverinaires = $this->rapportsverinairesRepository->findOneBy(['id' => $id]);
        if (!$Rapportsverinaires) 
        {throw new \Exception('No Rapportsverinaires found for {$id} id');}
        
        return $this->json(['message' => "A Rapportsverinaires was found : {$Rapportsverinaires->getName()} for {$Rapportsverinaires->getId()} id"]);     
    }

    #[Route('/{id}', name:'edit', methods: 'put')]
    public function edit(int $id): response
    {
        $Rapportsverinaires = $this->rapportsverinairesRepository->findOneBy(['id' => $id]);
          if (!$Rapportsverinaires) 
        {throw new \Exception("No Rapportsverinaires found for {$id} id");}
 
        $Rapportsverinaires->setName('Rapportsverinaires name updated');

        $this->manager->flush();

        return $this->redirectToRoute('app_api_Rapportsverinaires_show', ['id' => $Rapportsverinaires->getId()]);
    }

    #[Route('/{id}', name: 'delete', methods: 'delete')]
    public function delete(int $id): response
    {
        $Rapportsverinaires = $this->rapportsverinairesRepository->findOneBy(['id' => $id]);
        if (!$Rapportsverinaires) 
        {throw new \Exception("No Rapportsverinaires found for {$id} id");}

        $this->manager->remove($Rapportsverinaires);
        $this->manager->flush();
        return $this->json(['message'=> 'Rapportsverinaires ressource delated'], Response::HTTP_NO_CONTENT);
    }
}
