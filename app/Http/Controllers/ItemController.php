<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
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
        $rules = [
            'barcode' => ['required'],
            'name' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
        ];

        try {
            $payload = $this->validate(request(), $rules);
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), 400);
        }

        try {
            $item = new Item();
            $item->updateWithTransaction($payload);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
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
            return response()->json($e->getMessage(), 400);
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
        $rules = [
            'barcode' => ['required'],
            'name' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
        ];

        try {
            $payload = $this->validate(request(), $rules);
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), 400);
        }

        try {
            $item = Item::query()->findOrFail($id);
            $item->updateWithTransaction($payload);
        } catch (ModelNotFoundException | \Exception $e) {
            return response()->json($e->getMessage(), 400);
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
        } catch (ModelNotFoundException | \Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

        $item->delete();

        return response()->json('Deletion successful');
    }
}
