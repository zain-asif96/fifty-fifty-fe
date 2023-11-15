<?php

namespace App\Http\Controllers\MobileApp\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AppUsersController extends Controller
{


    public function usersPage(Request $request): Response
    {
        // $columnName = $request->get('column')!=null ? $request->get('column') : 'created_at';
        // $columnType =$request->get('type')!=null? $request->get('type') : 'desc';
        // $query = User::whereDoesntHave('roles')
        //     ->orderBy($columnName, $columnType);
        // if (request()->has('q') && !empty(request('q')))  {
        //     $search = request('q');
        //     $query->where(function ($innerQuery) use ($search) {
        //         $innerQuery->where('first_name', 'like', '%' . $search . '%')
        //             ->orWhere('last_name', 'like', '%' . $search . '%')
        //             ->orWhere('phone', 'like', '%' . $search . '%')
        //             ->orWhere('email', 'like', '%' . $search . '%')
        //             ->orWhere('country', 'like', '%' . $search . '%');
        //     });
        // }

        // $users = $query->paginate(10);

        // return Inertia::render('AppAdmin/Users/Index', [
        //     'users' =>$users
        // ]);
        return Inertia::render('AppAdmin/Users/Index');
    }

    public function singleUserPage(Request $request , $user)
    {
        // $response = Http::withHeaders([
        //     'Authorization' : 
        //     ])->post('https://fifty-backend-production.up.railway.app/user-auth/login', [
        //                 'email' => 'admin@gmail.com',
        //                 'password' => '123456',
        //             ]);
    
        //     // return "Hello World";
    
    
        //     return redirect()->intended(RouteServiceProvider::HOME)->with("authdata", $response->json());
        // return dd($user);
        // return Inertia::render('AppAdmin/Users/SingleUser', [
        //     'user' => $user
        // ]);
        return Inertia::render('AppAdmin/Users/SingleUser',
        [
                'user' => $user
        ]);
    
    }


}
