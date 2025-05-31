<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Task;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Group $group, Task $task, Request $request)
    {
        $data = $request->validate([
            'text' => ['string', 'required', 'min:1', 'max:500'],
        ]);
        $data['task_id'] = $task->id;
        $data['user_id'] = Auth::id();

        Comment::create($data);

        return back();
    }
}
