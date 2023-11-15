<?php

namespace App\Http\Controllers\MobileApp\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receiver;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppReceiverController extends Controller
{

    public function receiversPage(Request $request): Response
    {
        $columnName = $request->get('column')!=null?$request->get('column'):'created_at';
        $columnType = $request->get('type')!=null?$request->get('type'):'desc';
        if ($columnName != 'label') {
            $query = Receiver::orderBy($columnName,$columnType);
        } else {
            $query = Receiver::join('banks', 'receivers.bank_id', '=', 'banks.id')
                ->orderBy('banks.label', $columnType)
                ->select('receivers.*');
        }
        if (request()->has('q') && !empty(request('q')))  {
            $search = request('q');
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%');
            });
        }

        $receivers = $query->paginate(5);

        // return Inertia::render('AppAdmin/Receivers/Index', [
        //     'receivers' =>$receivers
        // ]);
        return Inertia::render('AppAdmin/Receivers/Index');
    }

    public function singleReceiverPage(Request $request, Receiver $receiver): Response
    {
        return Inertia::render('AppAdmin/Receivers/SingleReceiver', [
            'receiver' => $receiver
        ]);
    }
}
