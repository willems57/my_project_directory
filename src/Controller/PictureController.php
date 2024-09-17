<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Repository\PictureRepository;
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

class PictureController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private PictureRepository $PictureRepository,
    private SerializerSerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Picture = $this->serializer->deserialize($request->getContent(), Picture::class, 'json');
           $Picture->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Picture);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Picture, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_Picture_show',
                 ['id' => $Picture->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Picture = $this->PictureRepository->findOneBy(['id' => $id]);
            if (!$Picture) 
            {$responsedata=$this->serializer->serialize($Picture, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Picture=$this->PictureRepository->findOneBy(['id' => '$id']);
        if ($Picture){
            $Picture = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Picture::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Picture] 
            );
        $Picture->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Picture = $this->PictureRepository->findOneBy(['id' => $id]);
            if (!$Picture) {
            $this->manager->remove($Picture);
            $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse( null, Response::HTTP_NOT_FOUND);
        }
    }