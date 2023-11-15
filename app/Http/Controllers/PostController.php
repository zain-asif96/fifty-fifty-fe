<?php

namespace App\Http\Controllers;

use App\Classes\GeoLocation;
use App\Models\Country;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function postsPage(): Response
    {
        return Inertia::render('AvailablePosts', [
            'posts' => Post::getAvailablePosts()
        ]);
    }

    public function index(Request $request): Collection|array
    {
        $posts = Post::getAvailablePosts(100, false, $request->has('country_code') ? $request->country_code : null);

        // convert payment intent amount from cents to dollars
        foreach ($posts as $post) {
            $post['transaction']['paymentIntent']['amount'] = $post['transaction']['paymentIntent']['amount'] / 100;
        }

        return $posts;
    }
}
