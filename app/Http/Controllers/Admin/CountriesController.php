<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Countries\StoreCountryRequest;
use App\Http\Requests\Admin\Countries\UpdateCountryRequest;
use App\Models\Country;
use App\Models\Currency;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function countriesPage(Request $request): Response
    {
        $columnName = $request->get('column')!=null?$request->get('column'):'label';
        $columnType = $request->get('type')!=null?$request->get('type'):'ASC';

        if ($columnName === 'name') {
            $query = Country::with(['currency' => function ($query) use ($columnType) {
                $query->orderBy('name', $columnType);
            }]);
        }

        else{
            $query = Country::with('currency')->orderBy($columnName, $columnType);
        }

        if (request()->has('q')) {
            $query->where('id', 'LIKE', '%' . request('q') . '%')
                ->orWhere('label', 'LIKE', '%' . request('q') . '%')
                ->orWhere('code', 'LIKE', '%' . request('q') . '%')
                ->orWhere('can_send', 'LIKE', '%' . request('q') . '%')
                ->orWhere('can_receive', 'LIKE', '%' . request('q') . '%')
                // ->orWhere('status', 'LIKE', '%' . request('q') . '%')
                ->orWhereHas('currency', function ($query) {
                    $query->where('code', 'LIKE', '%' . request('q') . '%');
                    $query->where('name', 'LIKE', '%' . request('q') . '%');
                });
        }

        $countries = $query->paginate(25);

        return Inertia::render('Admin/Countries/Index', [
            'countries' => $countries,
            'currencies' => Currency::all(),
        ]);
    }

    public function store(StoreCountryRequest $request)
    {
        return Country::create($request->validated());
    }

    public function update(UpdateCountryRequest $request): bool
    {
        $country = Country::find($request->id);

        return $country->update($request->validated());
    }

}
