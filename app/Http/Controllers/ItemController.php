<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ItemRepository;
use App\Http\Resources\ItemResource;
use App\Interfaces\IRepository;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    /**
     * @var \App\Http\Repositories\ItemRepository
     */
    private IRepository $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all records from the `items` table
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $items = Item::query()->get();

        $resource = ItemResource::collection($items);
        return $resource->response();
    }

    /**
     * Add a new record into the `items` table
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(): JsonResponse
    {
        try {
            $payload = $this->validate(request(), $this->repository->getRules('create'));
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), 400);
        }

        try {
            $item = $this->repository->update(new Item(), $payload);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        $resource = new ItemResource($item);
        return $resource->response();
    }

    /**
     * Retrieve a specific record from the `items` table by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $item = Item::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        }

        $resource = new ItemResource($item);
        return $resource->response();
    }


    /**
     * Update a specific record from the `items` table by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(int $id): JsonResponse
    {
        try {
            $payload = $this->validate(request(), $this->repository->getRules('edit'));
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), 400);
        }

        try {
            /** @var \App\Models\Item $item */
            $item = Item::query()->findOrFail($id);
            $item = $this->repository->update($item, $payload);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        $resource = new ItemResource($item);
        return $resource->response();
    }

    /**
     * Soft-delete a specific record from the `items` table by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $item = Item::query()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 404);
        }

        $item->delete();

        return response()->json('Deletion successful');
    }
}
