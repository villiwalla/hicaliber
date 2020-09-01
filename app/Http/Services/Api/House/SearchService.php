<?php

namespace App\Http\Services\Api\House;

use App\House;
use App\Http\Requests\Api\House\SearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchService
{
    public function search(SearchRequest $request, Builder $query): Builder
    {
        $name      = $request->get('name');
        $priceFrom = $request->get('priceFrom');
        $priceTo   = $request->get('priceTo');
        $bedroom   = $request->get('bedroom');
        $bathroom  = $request->get('bathroom');
        $storey    = $request->get('storey');
        $garage    = $request->get('garage');

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($priceFrom && $priceTo) {
            $query->whereBetween('price', [$priceFrom, $priceTo]);
        } elseif ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }

        if($bedroom) {
            $query->where('bedroom', $bedroom);
        }

        if($bathroom) {
            $query->where('bathroom', $bathroom);
        }

        if($storey) {
            $query->where('storey', $storey);
        }

        if($garage) {
            $query->where('garage', $garage);
        }

        return $query;
    }

    public function searchWithPagination(
        SearchRequest $request,
        Builder $query,
        int $perPage
    ): LengthAwarePaginator
    {
        $this->search($request, $query);

        $query->orderBy($request->get('sort', 'id'), $request->get('direction', 'asc'));

        return $query->paginate($perPage);
    }
}
