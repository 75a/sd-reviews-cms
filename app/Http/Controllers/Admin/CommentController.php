<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommentController extends Controller
{
    public function index(Review $review): JsonResponse
    {
        return response()->json(CommentResource::collection($review->comments));
    }

    public function store(Request $request, Review $review): JsonResponse
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
            $review->comments()->save($comment);
            $comment->save();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return response()->json(new CommentResource($comment), 201);
    }

    public function show(Review $review, Comment $comment): JsonResponse
    {
        return response()->json(new CommentResource($comment));
    }

    public function update(Request $request, Review $review, Comment $comment): JsonResponse
    {
        $comment->update($request->all());
        return response()->json(new CommentResource($comment));
    }

    public function destroy(Review $review, Comment $comment): JsonResponse
    {
        try {
            $comment->delete();
        } catch (Throwable $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
