<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/Service', name: 'app_api_Service')]
class ServiceController extends AbstractController

{
    public function __construct(private EntityManagerInterface $manager, private ServiceRepository $ServiceRepository)
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(): response
        {
            $Service = new Service();
            $Service->setNameservice('');
            $Service->setDescription('');
         
    
           $this->manager->persist($Service);
           $this->manager->flush();
    //a stoquer en bas de donnee
    return $this->json(['message' => "Service resource created with {$Service->getId()} id"],
        
                    Response::HTTP_CREATED,);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): Response
        {
            $Service = $this->ServiceRepository->findOneBy(['id' => $id]);
            if (!$Service) 
            {throw new \Exception('No Service found for {$id} id');}
            
            return $this->json(['message' => "Service was found : {$Service->getName()} for {$Service->getId()} id"]);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id): response
        {
            $service = $this->ServiceRepository->findOneBy(['id' => $id]);
              if (!$service) 
            {throw new \Exception("No Service found for {$id} id");}
     
            $service->setPseudo('Service name updated');
    
            $this->manager->flush();
    
            return $this->redirectToRoute('app_api_Service_show', ['id' => $service->getId()]);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): response
        {
            $Service = $this->ServiceRepository->findOneBy(['id' => $id]);
            if (!$Service) 
            {throw new \Exception("No Service found for {$id} id");}
    
            $this->manager->remove($Service);
            $this->manager->flush();
            return $this->json(['message'=> 'Service ressource delated'], Response::HTTP_NO_CONTENT);
        }
    }