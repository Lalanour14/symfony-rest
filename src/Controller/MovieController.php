<?php
namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Duration;


#[Route('/api/movie')]
class MovieController extends AbstractController
{
    public function __construct(private MovieRepository $repo)
    {
    }

    #[Route(methods: 'GET')]

    public function all(): JsonResponse
    {
        return $this->json($this->repo->findAll());
    }

    #[Route('/{id}', methods: 'GET')]

    public function one(int $id): JsonResponse
    {
        $movie = $this->repo->findById($id);
        if ($movie == null) {
            return $this->json('Ressource Not found', 404);
        }
        return $this->json($movie);
    }

    #[Route('/{id}', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $movie = $this->repo->findById($id);
        if ($movie == null) {
            return $this->json('Ressource Not found', 404);
        }
        $this->repo->delete($id);
        return $this->json(null, 204);
    }

    #[Route(methods: 'POST')]



    public function post(Request $request)
    {

        $data = $request->toArray();
        $movie = new Movie($data['Title'], $data['Resume'], new \DateTime($data['Date']), $data['duration']);
        $this->repo->persite($movie);
        return $this->json($movie, 201);
    }

    #[Route('{id}/', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer)
    {

        $movie = $this->repo->findById($id);
        if ($movie == null) {
            return $this->json('Ressource Not found', 404);
        }

        $serializer->deserialize($request->getContent(), Movie::class, 'json', [
            'object_to_populate' => $movie
        ]);

        $this->repo->upDate($movie);
        return $this->json($movie);

    }


}