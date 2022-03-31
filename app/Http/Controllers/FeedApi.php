<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedApi extends Controller
{
    public function feed()
    {
        $feeds = Feed::orderBy('id','DESC')->with('user')->paginate(10);
        return response()->json([
            'status' => 200,
            'message' => "OK",
            'data' => $feeds,            
        ]);
    }
    public function create()
    {
        $v = Validator::make(request()->all(), [
            'description' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Create Feed',
                'data' => $v->errors(),
            ]);
        }
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
    public function delete()
    {
        $v = Validator::make(request()->all(), [
            'feed_id' => 'required',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Delete Feed',
                'data' => $v->errors(),
            ]);
        }
        $feed_id = request()->feed_id;
        $delete = Feed::find($feed_id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Delete Success',
            'data' => $delete
        ]);
    }
    public function createComment()
    {
        $v = Validator::make(request()->all(), [
            'feed_id' => 'required',
            'comment' => 'required',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Create Comment',
                'data' => $v->errors(),
            ]);
        }
        $feed_id = request()->feed_id;
        $user_id = Auth::id();
        $comment = request()->comment;

        $comment = Comment::create([
            'user_id' => $user_id,
            'feed_id' => $feed_id,
            'comment' => $comment
        ]);
        return response()->json([
            'Status' => 200,
            'Message' => 'Created Comment',
            'data' => $comment
        ]);
    }
    public function comment()
    {
        $v = Validator::make(request()->all(), [
            'feed_id' => 'required',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Show Comment',
                'data' => $v->errors(),
            ]);
        }
        $feed_id = request()->feed_id;
        $comments = Comment::where('feed_id',$feed_id)->with('user')->paginate(10);
        // $com = Feed::find($feed_id)->comment;
        // $comment = Comment::all();
        return response()->json([
            'Status' => 200,
            'Message' => 'Show Comment Success',
            'data' => $comments
        ]);
    }
    public function deleteComment()
    {
        $v = Validator::make(request()->all(), [
            'comment_id' => 'required',
        ]); 
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to Delete Comment',
                'data' => $v->errors(),
            ]);
        }
        $comment_id = request()->comment_id;
        $cmt = Comment::where('id',$comment_id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Deleted Comment',
            'data' => $cmt,
        ]);
    }
}
