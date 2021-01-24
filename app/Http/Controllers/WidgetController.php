<?php

namespace App\Http\Controllers;

use App\Http\Resources\WidgetResource;
use App\Models\Widget;
use http\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return WidgetResource::collection(Widget::all());
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
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new WidgetResource($widget))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param Widget $widget
     * @return WidgetResource
     */
    public function show(Widget $widget)
    {
        return new WidgetResource($widget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Widget $widget
     * @return WidgetResource
     */
    public function update(Request $request, Widget $widget)
    {
        $widget->update($request->all());
        return new WidgetResource($widget);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Widget $widget
     * @return JsonResponse
     */
    public function destroy(Widget $widget)
    {
        try {
            $widget->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
