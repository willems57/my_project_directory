<?php

namespace App\Controller;

use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class HabitatController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private HabitatRepository $habitatRepository,
    private SerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Habitat = $this->serializer->deserialize($request->getContent(), Habitat::class, 'json');
           $Habitat->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Habitat);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Habitat, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_zoo_show',
                 ['id' => $Habitat->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Habitat = $this->habitatRepository->findOneBy(['id' => $id]);
            if (!$Habitat) 
            {$responsedata=$this->serializer->serialize($Habitat, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Habitat=$this->habitatRepository->findOneBy(['id' => '$id']);
        if ($Habitat){
            $Habitat = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Habitat::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Habitat] 
            );
        $Habitat->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Habitat = $this->habitatRepository->findOneBy(['id' => $id]);
            if (!$Habitat) {
            $this->manager->remove($Habitat);
            $this->manager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }