<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Mention;
use Illuminate\Support\Facades\DB;
use Validator;

class CommentController extends Controller
{
    private function _loopChild($comments) {
        $data = [];

        foreach ($comments as $comment) {
            $childData = [];

            if ($comment->children != null) {
                $childData = $this->_loopChild($comment->children);
            }

            $data[] = [
                'id' => $comment->id,
                'author' => $comment->user->name,
                'username' => $comment->user->name,
                'content' => $comment->comment,
                'timestamp' => $comment->created_at,
                'children' => $childData,
            ];
        }

        return $data;
    }

    function commentOfThread($thread) {
        $comments  = Comment::where("threads_id", $thread)->where("comments_id", null)->get()->load('user');

        $data = $this->_loopChild($comments);

        return response()->json($data, 200);
    }

    function createComment(Request $request) {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'threads_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ]);
        }
        DB::transaction(function () use ($request) {
            $comment = Comment::create([
                'comment' => $request->comment,
                'threads_id' => $request->threads_id,
                'users_id' => $request->user()->id,
                'comments_id' => $request->comment_id,
            ]);

            if ($request->mentions) {
                $this->_createmention($request->mentions, $comment->id, $request->threads_id);
            }
        });

        return response()->json("Berhasil", 200);
    }

    function _createmention($mentions, $comment_id, $thread_id) {
        foreach ($mentions as $user_id) {
            Mention::create([
                'users_id' => $user_id,
                'comments_id' => $comment_id,
                'thread_id' => $thread_id,
            ]);
        }
    }
}
