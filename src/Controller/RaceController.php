<?php

namespace App\Controller;

use App\Entity\Race;
use App\Repository\RaceRepository;
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

class RaceController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private RaceRepository $RaceRepository,
    private SerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Race = $this->serializer->deserialize($request->getContent(), Race::class, 'json');
           $Race->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Race);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Race, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_Race_show',
                 ['id' => $Race->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Race = $this->RaceRepository->findOneBy(['id' => $id]);
            if (!$Race) 
            {$responsedata=$this->serializer->serialize($Race, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Race=$this->RaceRepository->findOneBy(['id' => '$id']);
        if ($Race){
            $Race = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Race::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Race] 
            );
        $Race->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Race = $this->RaceRepository->findOneBy(['id' => $id]);
            if (!$Race) {
            $this->manager->remove($Race);
            $this->manager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }