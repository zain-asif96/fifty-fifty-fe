<?php

namespace App\Http\Controllers\Admin;

use App\Classes\CurrencyExchange;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Currencies\DeleteCurrencyRequest;
use App\Http\Requests\Admin\Currencies\StoreCurrencyRequest;
use App\Http\Requests\Admin\Currencies\UpdateCurrencyRequest;
use App\Models\Currency;
use App\Models\Setting;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class AppCurrencyController extends Controller
{
    public function currenciesPage(Request $request):Response
    {
        $columnName = $request->get('column')!=null?$request->get('column'):'code';
        $columnType = $request->get('type')!=null?$request->get('type'):'asc';
        $fetched_at = Setting::first() ? Setting::first()->main['fetched_at'] : null;
        $query = Currency::with(['country:label,id,currency_id'])->orderBy($columnName,$columnType);

        if (request()->has('q') ) {
            $query->where('code','LIKE', '%' . request('q') . '%')
            ->orWhere('name','LIKE', '%' . request('q') . '%')
            ->orWhere('symbol','LIKE', '%' . request('q') . '%')
                ->orWhereHas('country', function ($query) {
                    $query->where('label', 'LIKE', '%' . request('q') . '%');
                });
        }
        $currencies = $query->paginate(25);

            return Inertia::render('AppAdmin/Currencies/Index', [
            'currencies' => $currencies,
            'info' => [
                'fetched_at' => $fetched_at ? Carbon::parse($fetched_at)->diffForHumans() : ''
            ]
        ]);
    }

    public function store(StoreCurrencyRequest $request){
        return Currency::create($request->validated());
    }

    public function update(UpdateCurrencyRequest $request, Currency $currency): bool
    {
        return $currency->update($request->validated());
    }

    public function delete(DeleteCurrencyRequest $request, Currency $currency): array|bool
    {
        if($currency->delete()){
            return ['id' => $currency->id];
        }

        return false;
    }

    public function updateRates(): array
    {
        $newRates =  CurrencyExchange::getLatestRates();

        Currency::updateRates($newRates);

        return [
            'status' => 'success',
            'currencies' => Currency::all()->fresh(),
            'fetched_at' => Carbon::now()->diffForHumans()
        ];
    }
     // added by huma 2807
     public function currenciesPageSort($column_name,$type){
        $sort = $column_name!=null?$column_name:'code';
        $sortType = $type!=null?$type:'asc';
        $query = Currency::with(['country:label,id,currency_id'])->orderBy($sort,$sortType);
        $currencies = $query->paginate(25);
        return $currencies;
    }
}
