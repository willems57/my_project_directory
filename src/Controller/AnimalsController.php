<?php

namespace App\Controller;

use App\Entity\Animals;
use App\Repository\AnimalsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class AnimalsController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private AnimalsRepository $AnimalsRepository,
    private SerializerSerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Animals = $this->serializer->deserialize($request->getContent(), Animals::class, 'json');
           $Animals->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Animals);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Animals, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_Animals_show',
                 ['id' => $Animals->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Animals = $this->AnimalsRepository->findOneBy(['id' => $id]);
            if ($Animals) 
            {$responsedata=$this->serializer->serialize($Animals, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Animals=$this->AnimalsRepository->findOneBy(['id' => '$id']);
        if ($Animals){
            $Animals = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Animals::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Animals] 
            );
        $Animals->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Animals = $this->AnimalsRepository->findOneBy(['id' => $id]);
            if (!$Animals) {
            $this->manager->remove($Animals);
            $this->manager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }