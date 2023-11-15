<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banks\DeleteBankRequest;
use App\Http\Requests\Admin\Banks\StoreBankRequest;
use App\Http\Requests\Admin\Banks\UpdateBankRequest;
use App\Models\Bank;
use App\Models\Country;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class AppBankController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Bank::whereNotNull('country_id');
        $sort = $request->get('column')!=null? $request->get('column') : 'id';
        $sortType =$request->get('type')!=null? $request->get('type') : 'asc';
        if ($sort != 'country') {
            $query = $query->orderBy($sort, $sortType);
        } else {
            $query = $query->join('countries', 'banks.country_id', '=', 'countries.id')
                ->orderBy('countries.label', $sortType)
                ->select('banks.*');
        }
        if (request()->has('q') && !empty(request('q'))) {
            $search = request('q');
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery
                    ->whereHas('country', function ($countryQuery) use ($search) {
                        $countryQuery->where('label', 'like', '%' . $search . '%');
                    })
                    ->orWhere('label', 'like', '%' . $search . '%');
            });
        }

        $banks = $query->paginate(50);

        return Inertia::render('AppAdmin/Banks/Index', [
            'banks' => $banks,
            'countries' => Country::supportedCountries(),
        ]);
    }

    public function store(StoreBankRequest $request)
    {
        return Bank::create($request->validated());
    }

    public function update(UpdateBankRequest $request, Bank $bank): bool
    {
        return $bank->update($request->validated());
    }

    public function delete(DeleteBankRequest $request, Bank $bank): array|bool
    {
        if ($bank->delete()) {
            return ['id' => $bank->id];
        }

        return false;
    }
}
