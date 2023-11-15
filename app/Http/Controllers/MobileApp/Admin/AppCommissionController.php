<?php

namespace App\Http\Controllers\MobileApp\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Commission\UpdateRequest;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AppCommissionController extends Controller
{
    public function commissionPage(Request $request): \Inertia\Response
    {
        $sort = $request->get('column')!=null ? $request->get('column') : 'created_at';
        $sortType =$request->get('type')!=null? $request->get('type') : 'desc';
        $query = Commission::query();
        if (request()->has('q') && !empty(request('q'))) {
            $search = request('q');
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('from', 'like', '%' . $search . '%')
                    ->orWhere('to', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }
        ##UPDATE THE SORTING ACCORDING TO THE CODE
        if ($sort == 'from') {
            $query = $query->orderBy('from', $sortType);
        } elseif ($sort == 'to') {
            $query = $query->orderBy('to', $sortType);
        } elseif ($sort == 'amount') {
            $query = $query->orderBy('amount', $sortType);
        } elseif ($sort == 'id') {
            $query = $query->orderBy('id', $sortType);
        } else {
            $query = $query->orderBy($sort, $sortType);
        }

        $commissions = $query->paginate(10);
        // return Inertia::render('AppAdmin/Commissions/Index', [
        //     'commissions' => $commissions,
        // ]);
        return Inertia::render('AppAdmin/Commissions/Index');
    }

    public function updateCommission(UpdateRequest $request, Commission $commission)
    {
        try {
            $commission->update($request->validated());
            return response()->json([
                'message' => 'Updated successfully',
                'data' => $commission
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
