<?php

namespace App\Http\Controllers\Api\House;

use App\House;
use App\Http\Controllers\Controller;
use App\Http\Repository\HouseRepository;
use App\Http\Requests\Api\House\SearchRequest;
use App\Http\Services\Api\House\SearchService;
use Illuminate\Http\JsonResponse;
use Throwable;

class SearchController extends Controller
{
    const PER_PAGE = 15;
    private HouseRepository $repository;
    private SearchService $service;

    public function __construct(HouseRepository $repository, SearchService $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }

    public function index(SearchRequest $request)
    {
        try {
            $request->validated();
        } catch (Throwable $e) {
            return response()->json($e->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->service->searchWithPagination($request, $this->repository->query(), self::PER_PAGE);
    }

    public function priceRange()
    {
        return response()->json([House::min('price'), House::max('price')]);
    }
}
