<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewAttributePostRequest;
use App\Http\Resources\ReviewAttributeResource;
use App\Models\ReviewAttribute;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ReviewAttributeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ReviewAttributeResource::collection(ReviewAttribute::all()));
    }

    public function store(ReviewAttributePostRequest $request): JsonResponse
    {
        $reviewAttribute = new ReviewAttribute();
        $reviewAttribute->fill($request->all());
        $reviewAttribute->save();
        return response()->json(new ReviewAttributeResource($reviewAttribute), 201);
    }

    public function show(ReviewAttribute $reviewAttribute): JsonResponse
    {
        return response()->json(new ReviewAttributeResource($reviewAttribute));
    }

    public function update(Request $request, ReviewAttribute $reviewAttribute): JsonResponse
    {
        $reviewAttribute->update($request->all());
        return response()->json(new ReviewAttributeResource($reviewAttribute));
    }

    public function destroy(ReviewAttribute $reviewAttribute): JsonResponse
    {
        try {
            $reviewAttribute->delete();
        } catch (Throwable $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
