<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use Validator;

class ThreadController extends Controller
{
    function getAll() {
        $threads = Thread::with('user')->paginate(9);

        return response()->json($threads, 200);
    }

    function detailThread($thread) {
        $thread = Thread::whereId($thread)->with('user')->first();

        return response()->json(["data" => $thread], 200);
    }

    function createThread(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ]);
        }

        $thread = Thread::create([
            'title' => $request->title,
            'description' => $request->description,
            'users_id' => $request->user()->id,
        ]);

        return response()->json($thread, 200);
    }

    function deleteThread($id) {
        Thread::whereId($id)->delete();

        return response()->json("berhasil", 200);
    }
}
