<?php

namespace App\Http\Controllers;

use App\Http\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SiteSettingResource::collection(SiteSetting::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return SiteSettingResource
     */
    public function show(SiteSetting $siteSetting)
    {
        return new SiteSettingResource($siteSetting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteSetting  $siteSetting
     * @return SiteSettingResource
     */
    public function update(Request $request, SiteSetting $siteSetting)
    {
        $siteSetting->update($request->all());
        return new SiteSettingResource($siteSetting);
    }
}
