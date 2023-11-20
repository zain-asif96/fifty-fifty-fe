<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStatusStoreRequest;
use App\Models\Post;
use App\Models\UpdateStatusTime;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppUpdateStatusController extends Controller
{
    public function index(){
        // return Inertia::render('Admin/Time/Index', [
        //     'times' => UpdateStatusTime::paginate(10),
        // ]);
        return Inertia::render('AppAdmin/Time/Index');
    }
    public function store(UpdateStatusStoreRequest $request)
    {
        try{
            $updateStatusTime = UpdateStatusTime::create([
                'model_name' => $request->model_name ?? Post::class,
                'status' => $request->status ?? Post::ON_HOLD,
                'time' => $request->time,
            ]);

            return response()->json([
                'message' => 'Update status time created successfully',
                'data' => $updateStatusTime
            ], 201);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateStatusStoreRequest $request, UpdateStatusTime $updateStatusTime)
    {
        try{
            $updateStatusTime->update([
                'model_name' => isset($request->model_name) ? $request->model_name : $updateStatusTime->model_name,
                'status' => isset($request->status) ? $request->status : $updateStatusTime->status,
                'time' => $request->time ?? $updateStatusTime->time,
            ]);

            return response()->json([
                'message' => 'Update status time updated successfully',
                'data' => $updateStatusTime
            ], 200);

        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
