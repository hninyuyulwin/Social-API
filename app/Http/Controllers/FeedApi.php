<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedApi extends Controller
{
    public function create()
    {
        $image = request()->image;
        $image_name = uniqid().$image->getClientOriginalName();
        $path = 'feed';
        $image->move($path,$image_name);

        $feed = Feed::create([
            'description' => request()->description,
            'user_id' => Auth::id(),
            'image' => "$path/$image_name"
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Created Feed',
            'data' => $feed
        ]);
    }
}
