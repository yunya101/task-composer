<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function show(Group $group, Task $task)
    {
        $members_row = $group->users()->wherePivot('is_active', true)->get();
        $comments = $task->comments()->get();
        $members = array();

        foreach ($members_row as $user) {
            $members[$user->id] = $user;
        }

        return view('tasks.show', compact(['group', 'task', 'members', 'comments']));
    }

    public function store(Group $group, Request $request)
    {
        $date = $request->validate([
            'title' => ['string', 'required'],
            'deadline' => ['date', 'required'],
            'description' => ['string', 'nullable'],
        ]);
        $date['executor'] = Auth::id();
        $date['group_id'] = $group->id;

        Task::create($date);

        return redirect()->route('groups.show', ['group' => $group]);
    }

    public function edit(Group $group, Task $task, Request $request)
    {
        $data = $request->validate([
            'title' => ['string', 'required'],
            'deadline' => ['date', 'required'],
            'description' => ['string', 'nullable'],
            'executor' => ['integer', 'required'],
        ]);

        $task->update($data);

        return redirect()->back();
    }
}
