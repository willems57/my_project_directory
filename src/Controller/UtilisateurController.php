<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
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

class UtilisateurController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $manager,
    private UtilisateurRepository $utilisateurRepository,
    private SerializerInterface $serializer,
    private UrlGeneratorInterface $urlhenerator
    )
    {
    
    }
    
        #[Route(name: 'new', methods: 'post')]
        public function new(Request $request): JsonResponse
        {
            $Utilisateur = $this->serializer->deserialize($request->getContent(), Utilisateur::class, 'json');
           $Utilisateur->setCreatedAt(new \DateTimeImmutable());
    
           $this->manager->persist($Utilisateur);
           $this->manager->flush();
    //a stoquer en bas de donnee
    $responseData = $this->serializer->serialize($Utilisateur, 'json');
    
            $location = $this->urlhenerator->generate(
                 'app_api_Utilisateur_show',
                 ['id' => $Utilisateur->getId()],
                 UrlGeneratorInterface::ABSOLUTE_URL,
            );
            return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);
    
        }
        #[Route('/{id}', name: 'show', methods: 'get')]
        public function show(int $id): JsonResponse
        {
            $Utilisateur = $this->utilisateurRepository->findOneBy(['id' => $id]);
            if (!$Utilisateur) 
            {$responsedata=$this->serializer->serialize($Utilisateur, format: 'Json');
            
                return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
            }
            
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
        }
    
        #[Route('/{id}', name:'edit', methods: 'put')]
        public function edit(int $id, Request $Request): JsonResponse
        {
        $Utilisateur=$this->utilisateurRepository->findOneBy(['id' => '$id']);
        if ($Utilisateur){
            $Utilisateur = $this->serializer->deserialize(
            $Request->getContent(),
            type: $Utilisateur::class,
            format: 'Json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $Utilisateur] 
            );
        $Utilisateur->setUpdatedAt(new DateTimeImmutable());
        $this->manager->flush();
    
        return new JsonResponse( null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);
        }
    
        #[Route('/{id}', name: 'delete', methods: 'delete')]
        public function delete(int $id): JsonResponse
        {
            $Utilisateur = $this->utilisateurRepository->findOneBy(['id' => $id]);
            if (!$Utilisateur) {
            $this->manager->remove($Utilisateur);
            $this->manager->flush();
    
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
    
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }
    }
