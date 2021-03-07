<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(SiteSettingResource::collection(SiteSetting::all()));
    }

    public function show(SiteSetting $siteSetting): JsonResponse
    {
        return response()->json(new SiteSettingResource($siteSetting));
    }

    public function update(Request $request, SiteSetting $siteSetting): JsonResponse
    {
        $siteSetting->update($request->all());
        return response()->json(new SiteSettingResource($siteSetting));
    }
}
