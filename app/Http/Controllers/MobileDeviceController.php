<?php

namespace App\Http\Controllers;

use App\Models\MobileDevice;
use App\Http\Requests\StoreMobileDeviceRequest;
use App\Http\Requests\UpdateMobileDeviceRequest;

class MobileDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMobileDeviceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMobileDeviceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MobileDevice  $mobileDevice
     * @return \Illuminate\Http\Response
     */
    public function show(MobileDevice $mobileDevice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MobileDevice  $mobileDevice
     * @return \Illuminate\Http\Response
     */
    public function edit(MobileDevice $mobileDevice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMobileDeviceRequest  $request
     * @param  \App\Models\MobileDevice  $mobileDevice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMobileDeviceRequest $request, MobileDevice $mobileDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MobileDevice  $mobileDevice
     * @return \Illuminate\Http\Response
     */
    public function destroy(MobileDevice $mobileDevice)
    {
        //
    }
}
