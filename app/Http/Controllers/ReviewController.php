<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ReviewResource::collection(Review::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header' => ['required'],
            'main_content' => ['required'],
            'rating' => ['integer'],
            'is_published' => ['boolean']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $review = new Review();
            $review->fill($request->all());
            $review->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new ReviewResource($review))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return ReviewResource
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Review $review
     * @return ReviewResource
     */
    public function update(Request $request, Review $review)
    {
        $review->update($request->all());
        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Review $review
     * @return JsonResponse
     */
    public function destroy(Request $request, Review $review)
    {
        try {
            $review->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
