<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactController extends Controller
{

    public function __construct(
        protected ContactService $contactService
    ) {}


    public function index(): AnonymousResourceCollection
    {
        $contacts = $this->contactService->all();

        return ContactResource::collection($contacts);
    }

    public function store(StoreContactRequest $request): ContactResource
    {
        $contact = $this->contactService->store($request->validated());

        return new ContactResource($contact);
    }

    public function show(int $id): ContactResource
    {
        $contact = $this->contactService->find($id);

        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, int $id): ContactResource
    {
        $contact = $this->contactService->update($id, $request->validated());

        return new ContactResource($contact);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->contactService->delete($id);

        return response()->json(['message' => 'Contact deleted successfully', 'status' => 'success']);
    }
}
