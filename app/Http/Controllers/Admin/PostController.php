<?php

namespace App\Http\Controllers\Admin;

use App\Classes\CurrencyExchange;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\UpdateRequest;
use App\Models\Post;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Http\Requests\Admin\Posts\StorePostRequest;
use App\Http\Requests\Admin\Posts\DeletePostRequest;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Receiver;


class PostController extends Controller
{
    public function postsPage(Request $request): Response
    {

        ##the sorting and filter values are getting to the backend please set the boht accordingly
        ##update it according to the condition just added to check if the crud working
        $sort = $request->get('column')!=null ? $request->get('column') : 'created_at';
        $sortType =$request->get('type')!=null? $request->get('type') : 'desc';
        $query = Post::with('transaction.user')->with('transaction.receiver')->with('transaction.paymentIntent');
        if (request()->has('q') && !empty(request('q'))) {
            $search = request('q');
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->whereHas('transaction.user', function ($userQuery) use ($search) {
                    $userQuery->where('country', 'like', '%' . $search . '%');
                })
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }
        ##UPDATE THE SORTING ACCORDING TO THE CODE
        if ($sort == 'user') {
            $query = $query->orderBy('users.first_name', $sortType);
        } elseif ($sort == 'receiver') {
            $query = $query->orderBy('receivers.first_name', $sortType);
        } elseif ($sort == 'amount') {
            $query = $query->orderBy('transaction.paymentIntent.amount', $sortType);
        } elseif ($sort == 'id') {
            $query = $query->orderBy('transaction.id', $sortType);
        } else {
            $query = $query->orderBy($sort, $sortType);
        }

        $posts = $query->paginate(10);
        $receivers = Receiver::all();
        return Inertia::render('Admin/Posts/Index', [
            'posts' => $posts,
            'receivers' => $receivers,
        ]);
        ##update it according to the condition just added to check if the crud working
    }

    public function store(StorePostRequest $request)
    {
        try {
            /*Get FiftyFifty Random User*/
            $fiftyUserEmails = User::whereHas('roles', function ($query) {
                $query->where('name', 'fifty.user');
            })->inRandomOrder()->first();

            if (!$fiftyUserEmails) {
                throw new \Exception('No user found with the required role.');
            }

            DB::beginTransaction();

            $amount = $request->input('amount', 1) * 100;
            if ($request->input('receiver_id') != null) {
                $receiver = Receiver::find($request->input('receiver_id'));
                if (!$receiver) {
                    throw new \Exception('No receiver found with the given id.');
                }

                $receiverCountry = Country::where('code', $receiver->country)
                                    ->orWhere('code_iso_2',$receiver->country)
                                    ->first();

                if (!$receiverCountry) {
                    throw new \Exception('No country found with the given code.');
                }

                $requiredCurrency = $receiverCountry->currency->code;

                if (!$requiredCurrency) {
                    throw new \Exception('No currency found with the given code.');
                }
                $baseCurrency = $request->input('currency', 'USD');
                $amount_in_receiver_currency[] = CurrencyExchange::convertCurrencies($baseCurrency, $requiredCurrency);
                $currencyValue = $amount_in_receiver_currency[0][$requiredCurrency]['value'] * $amount;
            }

            /*Store Payment Intent Data*/
            $paymentIntentData = [
                'stripe_payment_intent_id' => $request->input('stripe_payment_intent_id', rand(100000, 999999)),
                'amount' => $amount,
                'currency' => $request->input('currency', 'usd'),
                'status' => $request->input('status', Post::AVAILABLE),
                'receiver_id' => $request->input('receiver_id'),
                'amount_in_receiver_currency' => $currencyValue ?? 1,
            ];

            $paymentIntent = $fiftyUserEmails->paymentIntents()->create($paymentIntentData);

            /*Store Transaction Data*/
            $transaction = Transaction::create([
                'user_id' => $fiftyUserEmails->id,
                'receiver_id' => $request->input('receiver_id', 1),
                'payment_intent_id' => $paymentIntent->id,
                'type' => 'direct',
                'status' => Transaction::PAIRING_PENDING,
                'payment_status' => Transaction::PAYMENT_ON_HOLD
            ]);

            $response = Post::create([
                'transaction_id' => $transaction->id,
                'country_code'=> $request->input('country_code', 'US'),
                'status' => Post::AVAILABLE,
            ]);
            $response->load('transaction.user','transaction.receiver');

            DB::commit();

            return response()->json([
                'message' => 'Post created successfully.',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function refresh($id)
    {
        $post = Post::find($id);
        $post->makeAvailable();
        $post = Post::find($id);
        $post->load('transaction.user','transaction.receiver');

        return response()->json(['message' => 'Post refreshed successfully', 'data'=>$post,'status'=>'success']);
    }

    /*Update Post*/
    public function update(UpdateRequest $request, Post $post)
    {
        try {
            DB::beginTransaction();

            $status = $request->input('status');
            switch ($status) {
                case Post::AVAILABLE:
                    $post->makeAvailable();
                    break;
                case Post::ON_HOLD:
                    $post->putOnHold();
                    break;
            }


            $post->update([
                'status' => $status,
            ]);

            $post->transaction->paymentIntent->update([
                'amount' => $request->input('amount', $post->transaction->paymentIntent->amount),
            ]);


            $post->load('transaction.user','transaction.receiver');
            DB::commit();

            return response()->json([
                'message' => 'Post updated successfully.',
                'data' => $post,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function delete(DeletePostRequest $request, Post $post): array | bool
    {
        if ($post->delete()) {
            return ['id' => $post->id];
        }

        return false;
    }
}
