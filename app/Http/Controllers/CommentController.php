<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Review;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CommentResource::collection(Comment::all());
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
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->review_id = $review->id;
            $comment->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new CommentResource($comment))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Review $review, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Review $review
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(Request $request, Review $review, Comment $comment)
    {
        $comment->update($request->all());
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Review $review, Comment $comment)
    {
        try {
            $comment->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
