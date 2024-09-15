<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/Avis', name: 'app_api_Avis')]
class AvisController extends AbstractController


{
    public function __construct(private EntityManagerInterface $manager, private AvisRepository $AvisRepository)
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(): response
        {
            $Avis = new Avis();
            $Avis->setSpeudo('');
            $Avis->setComentaire('tres agrable moment!');
           $Avis->setVisible(Boolean());
    
           $this->manager->persist($Avis);
           $this->manager->flush();
    //a stoquer en bas de donnee
    return $this->json(['message' => "Avis resource created with {$Avis->getId()} id"],
        
                    Response::HTTP_CREATED,);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): Response
        {
            $Avis = $this->AvisRepository->findOneBy(['id' => $id]);
            if (!$Avis) 
            {throw new \Exception('No Avis found for {$id} id');}
            
            return $this->json(['message' => "Avis was found : {$Avis->getName()} for {$Avis->getId()} id"]);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id): response
        {
            $Avis = $this->AvisRepository->findOneBy(['id' => $id]);
              if (!$Avis) 
            {throw new \Exception("No Avis found for {$id} id");}
     
            $Avis->setPseudo('Avis name updated');
    
            $this->manager->flush();
    
            return $this->redirectToRoute('app_api_Avis_show', ['id' => $Avis->getId()]);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): response
        {
            $Avis = $this->AvisRepository->findOneBy(['id' => $id]);
            if (!$Avis) 
            {throw new \Exception("No Avis found for {$id} id");}
    
            $this->manager->remove($Avis);
            $this->manager->flush();
            return $this->json(['message'=> 'Avis ressource delated'], Response::HTTP_NO_CONTENT);
        }
    }





