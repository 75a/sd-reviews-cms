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
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'rating' => ['required','integer']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $rating = new Rating();
            $rating->fill($request->all());
            $rating->review_id = $review->id;
            $rating->save();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }
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
