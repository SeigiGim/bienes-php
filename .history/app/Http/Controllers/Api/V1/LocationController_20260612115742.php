<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Resources\LocationResource;
use App\Services\LocationService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LocationController extends Controller
{
    public function __construct(protected LocationService $locationService) {}

    public function index(): AnonymousResourceCollection
    {
        $locations = $this->locationService->all();

        return LocationResource::collection($locations);
    }

    public function store(StoreLocationRequest $request): LocationResource
    {
        $location = $this->locationService->store($request->validated());

        return new LocationResource($location);
    }

    public function show(int $id): LocationResource
    {
        $location = $this->locationService->find($id);

        return new LocationResource($location);
    }
}
