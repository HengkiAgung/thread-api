<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\User;
use Validator;

class MentionController extends Controller
{
    function findUser(Request $request) {
        $users = User::where('name','LIKE','%' . $request->name . '%')->get()->take(4);
        // dd($users);

        return response()->json(["success" => true, "data" => $users], 200);
    }

    function getMentionedComment(){
        $mentionComments = auth()->user()->mention->load("thread.user", "comment.user");
        $threads = [];

        foreach ($mentionComments as $mentionComment) {
            $thread = $mentionComment->thread;
            $thread->comment = $mentionComment->comment;
            $threads[] = $thread;
        }

        return response()->json($threads, 200);
    }
}
