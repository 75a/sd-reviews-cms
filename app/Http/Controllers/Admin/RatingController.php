<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingPostRequest;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Models\Review;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class RatingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RatingResource::collection(Rating::all()));
    }

    public function store(RatingPostRequest $request, Review $review): JsonResponse
    {
        $rating = new Rating();
        $rating->fill($request->all());
        $rating->review_id = $review->id;
        $rating->save();
        return response()->json(new RatingResource($rating), 201);
    }

    public function show(Review $review, Rating $rating): JsonResponse
    {
        return response()->json(new RatingResource($rating));
    }

    public function update(Request $request, Review $review, Rating $rating): JsonResponse
    {
        $rating->update($request->all());
        return response()->json(new RatingResource($rating));
    }

    public function destroy(Review $review, Rating $rating): JsonResponse
    {
        try {
            $rating->delete();
        } catch (Throwable $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
