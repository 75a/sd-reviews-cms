<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WidgetPostRequest;
use App\Http\Resources\WidgetResource;
use App\Models\Widget;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class WidgetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(WidgetResource::collection(Widget::all()));
    }

    public function store(WidgetPostRequest $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'header' => ['required'],
            'main_content' => ['required'],
            'is_published' => ['required','boolean'],
            'position' => ['integer']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $widget = new Widget();
            $widget->fill($request->all());
            $widget->save();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }
        return response()->json(new WidgetResource($widget), 201);
    }

    public function show(Widget $widget): JsonResponse
    {
        return response()->json(new WidgetResource($widget));
    }

    public function update(Request $request, Widget $widget): JsonResponse
    {
        $widget->update($request->all());
        return response()->json(new WidgetResource($widget));
    }

    public function destroy(Widget $widget): JsonResponse
    {
        try {
            $widget->delete();
        } catch (Throwable $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
