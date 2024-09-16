<?php

namespace App\Controller;

use App\Entity\Zoo;
use App\Repository\ZooRepository;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/zoo', name: 'app_api_zoo')]
class ZooController extends AbstractController
{
public function __construct(
private EntityManagerInterface $manager,
private ZooRepository $zooRepository,
private SerializerInterface $serializer,
private UrlGeneratorInterface $urlhenerator
)
{

}

    #[Route(name: 'new', methods: 'post')]
    public function new(Request$request): JsonResponse
    {
        $zoo = $this->serializer->deserialize($request->getContent(), Zoo::class, 'json');
       $zoo->setCreatedAt(new \DateTimeImmutable());

       $this->manager->persist($zoo);
       $this->manager->flush();
//a stoquer en bas de donnee
$responseData = $this->serializer->serialize($zoo, 'json');

        $location = $this->urlhenerator->generate(
             'app_api_zoo_show',
             ['id' => $zoo->getId()],
             UrlGeneratorInterface::ABSOLUTE_URL,
        );
        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }
    #[Route('/{id}', name: 'show', methods: 'get')]
    public function show(int $id): JsonResponse
    {
        $zoo = $this->zooRepository->findOneBy(['id' => $id]);
        if (!$zoo) 
        {$responsedata=$this->serializer->serialize($zoo, format: 'Json');
        
            return new JsonResponse($responsedata, Response::HTTP_OK, [], true);
        }
        
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);   
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
