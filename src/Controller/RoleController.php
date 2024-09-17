<?php

namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
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

class RoleController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private RoleRepository $RoleRepository,
    private SerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Role = $this->serializer->deserialize($request->getContent(), Role::class, 'json');
           $Role->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Role);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Role, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_Role_show',
                 ['id' => $Role->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Role = $this->RoleRepository->findOneBy(['id' => $id]);
            if (!$Role) 
            {$responsedata=$this->serializer->serialize($Role, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Role=$this->RoleRepository->findOneBy(['id' => '$id']);
        if ($Role){
            $Role = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Role::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Role] 
            );
        $Role->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Role = $this->RoleRepository->findOneBy(['id' => $id]);
            if (!$Role) {
            $this->manager->remove($Role);
            $this->manager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }