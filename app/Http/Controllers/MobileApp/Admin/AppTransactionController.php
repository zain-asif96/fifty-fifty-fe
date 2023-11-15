<?php

namespace App\Http\Controllers\MobileApp\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentIntent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppTransactionController extends Controller
{

    public function transactionsPage(Request $request): Response
    {
//        $sort = $request->get('column')!=null ? $request->get('column') : 'id';
//        $sortType =$request->get('type')!=null? $request->get('type') : 'asc';
//        $query = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
//            ->join('receivers', 'transactions.receiver_id', '=', 'receivers.id')
//            ->join('payment_intents', 'transactions.payment_intent_id', '=', 'payment_intents.id')
//            ->select('users.*', 'receivers.*', 'transactions.*');
//        if (request()->has('q') && !empty(request('q'))) {
//            $search = request('q');
//            $query->where(function ($innerQuery) use ($search) {
//                $innerQuery->whereHas('user', function ($userQuery) use ($search) {
//                    $userQuery->where('first_name', 'like', '%' . $search . '%')
//                        ->orWhere('last_name', 'like', '%' . $search . '%');
//                })
//                    ->orWhere('type', 'like', '%' . $search . '%')
//                    ->orWhere('status', 'like', '%' . $search . '%')
//                    ->orWhere('payment_status', 'like', '%' . $search . '%');
//            });
//        }
//
//
//        if ($sort == 'user') {
//            $query = $query->orderBy('users.first_name', $sortType);
//        } elseif ($sort == 'receiver') {
//            $query = $query->orderBy('receivers.first_name', $sortType);
//        } elseif ($sort == 'amount') {
//            $query = $query->orderBy('payment_intents.amount', $sortType);
//        }  else {
//            $query = Transaction::with('user')->orderBy($sort, $sortType);
//        }

        $columnName = $request->get('column')!=null?$request->get('column'):'id';
        $columnType = $request->get('type')!=null?$request->get('type'):'asc';
        $query = Transaction::with('user');

        switch ($columnName) {
            case 'user':
                $query = $query->orderBy('users.first_name', $columnType);
                break;
            case 'receiver':
                $query = $query->orderBy('receivers.first_name', $columnType);
                break;
            case 'amount':
                $query = $query->orderBy('payment_intents.amount', $columnType);
                break;
            default:
                $query = Transaction::with('user')->orderBy($columnName, $columnType);
        }


        if (request()->has('q') && !empty(request('q'))) {
            $query->where('type','LIKE', '%' . request('q') . '%')
                ->orWhere('status','LIKE', '%' . request('q') . '%')
                ->orWhereHas('user', function ($query) {
                    $query->where('first_name', 'LIKE', '%' . request('q') . '%')
                        ->orWhere('last_name', 'LIKE', '%' . request('q') . '%');
                })
                ->orWhereHas('receiver', function ($query) {
                    $query->where('first_name', 'LIKE', '%' . request('q') . '%')
                        ->orWhere('last_name', 'LIKE', '%' . request('q') . '%');
                });
        }





        $transactions = $query->paginate(10);
        // return Inertia::render('AppAdmin/Transactions/Index', [
        //     'transactions' => $transactions,
        // ]);
        return Inertia::render('AppAdmin/Transactions/Index');
    }

    public function paymentIntentPage(Request $request, PaymentIntent $paymentIntent): Response
    {
        $paymentIntent->load('transaction');

        // return Inertia::render('AppAdmin/Transactions/SinglePaymentIntent', [
        //     'paymentIntent' => $paymentIntent,
        // ]);
        return Inertia::render('AppAdmin/Transactions/SinglePaymentIntent');
    }
}
