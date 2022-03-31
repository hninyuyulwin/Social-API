<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LikeApi extends Controller
{
    //
    public function like()
    {   
        $v = Validator::make(request()->all(), [
            'feed_id' => 'required'
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Like',
                'data' => $v->errors(),
            ]);
        }
        
        $user_id = Auth::id();
        $feed_id = request()->feed_id;
        if (!$this->isLike($user_id,$feed_id)) {
            $like = Like::create([
                'user_id' => $user_id,
                'feed_id' => $feed_id
            ]);
            return response()->json([
                'Status' => 200,
                'Message' => 'Liked',
                'data' => $like
            ]);
        }
        return response()->json([
            'Status' => 500,
            'Message' => 'Fail',
            'data' => 'Already Liked'
        ]);
        
    }
    // isLike
    public function isLike($user_id,$feed_id)
    {
        $like = Like::where('user_id',$user_id)->where('feed_id',$feed_id)->count();
        if ($like) {
            return true;
        }
        return false;
    }
    // Dislike
    public function unlike()
    {
        $like_id = request()->like_id;
        $unlike = Like::find($like_id)->delete();
        return response()->json([
            'Status' => 200,
            'Message' => 'Unliked',
            'Data' => $unlike
        ]);
    }
}
