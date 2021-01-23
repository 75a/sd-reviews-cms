<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(SiteSetting::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(SiteSetting $siteSetting)
    {
        return response()->json($siteSetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        $siteSetting->update($request->all());
        return response()->json($siteSetting);
    }
}
