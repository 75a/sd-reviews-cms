<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewAttributeResource;
use App\Models\ReviewAttribute;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ReviewAttributeResource::collection(ReviewAttribute::all());
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
            'label' => ['required', 'unique:App\Models\ReviewAttribute,label'],
            'is_nullable' => ['required','boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $reviewAttribute = new ReviewAttribute();
            $reviewAttribute->fill($request->all());
            $reviewAttribute->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new ReviewAttributeResource($reviewAttribute))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param ReviewAttribute $reviewAttribute
     * @return ReviewAttributeResource
     */
    public function show(ReviewAttribute $reviewAttribute)
    {
        return new ReviewAttributeResource($reviewAttribute);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ReviewAttribute $reviewAttribute
     * @return ReviewAttributeResource
     */
    public function update(Request $request, ReviewAttribute $reviewAttribute)
    {
        $reviewAttribute->update($request->all());
        return new ReviewAttributeResource($reviewAttribute);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReviewAttribute $reviewAttribute
     * @return JsonResponse
     */
    public function destroy(ReviewAttribute $reviewAttribute)
    {
        try {
            $reviewAttribute->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
