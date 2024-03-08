<?php

namespace App\Controller;

use App\Repository\SparePartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SparePartsController extends AbstractController
{
    #[Route('/spare-parts', methods: ['GET'])]
    public function index(Request $request, SparePartRepository $sparePartRepository): JsonResponse
    {
        // Get the IDs from the query parameters
        $ids = $request->query->get('ids');

        //convert the string to an array
        $ids = explode(',', $ids);

        // Ensure that $ids is an array
        if (!is_array($ids)) {
            // If the 'ids' parameter is not an array, return a 400 Bad Request response
            return new JsonResponse(['error' => 'Invalid value for "ids" parameter.'], Response::HTTP_BAD_REQUEST);
        }

        // Get the spare parts from the repository based on the IDs
        $spareParts = $sparePartRepository->findByIds($ids);

        foreach ($spareParts as $sparePart) {
            // edit the price slightly
            $priceChangeFactor = mt_rand(0, 1) + lcg_value();

            $sparePart->setPrice($sparePart->getPrice() * $priceChangeFactor);
        }

        // Return the spare parts as JSON response
        return $this->json($spareParts);
    }
}
