<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Models\Review;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RatingResource::collection(Rating::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Review $review
     * @return JsonResponse
     */
    public function store(Request $request, Review $review)
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
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new RatingResource($rating))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @param Rating $rating
     * @return RatingResource
     */
    public function show(Review $review, Rating $rating)
    {
        return new RatingResource($rating);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Review $review
     * @param Rating $rating
     * @return RatingResource
     */
    public function update(Request $request, Review $review, Rating $rating)
    {
        $rating->update($request->all());
        return new RatingResource($rating);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @param Rating $rating
     * @return JsonResponse
     */
    public function destroy(Review $review, Rating $rating)
    {
        try {
            $rating->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
