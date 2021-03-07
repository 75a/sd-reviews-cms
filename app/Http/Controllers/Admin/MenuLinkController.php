<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuLinkResource;
use App\Models\MenuLink;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MenuLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return MenuLinkResource::collection(MenuLink::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_name' => ['required'],
            'label' => ['required'],
            'url' => ['required'],
            'zindex' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }

        DB::beginTransaction();
        try {
            $menuLink = new MenuLink();
            $menuLink->fill($request->all());
            $menuLink->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 409);
        }

        return (new MenuLinkResource($menuLink))->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuLink  $menuLink
     * @return MenuLinkResource
     */
    public function show(MenuLink $menuLink)
    {
        return new MenuLinkResource($menuLink);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuLink  $menuLink
     * @return MenuLinkResource
     */
    public function update(Request $request, MenuLink $menuLink)
    {
        $menuLink->update($request->all());
        return new MenuLinkResource($menuLink);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Models\MenuLink $menuLink
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, MenuLink $menuLink)
    {
        try {
            $menuLink->delete();
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        return response()->json(null, 204);
    }
}
