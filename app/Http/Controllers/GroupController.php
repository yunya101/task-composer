<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    
    public function show(Group $group)
    {
        $tasks = $group->tasks()->get();

        return view('groups.show', compact('group', 'tasks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'members' => ['nullable'],
        ]);

        $group = Group::create([
            'title' => $data['title'],
        ]);

        $emails = $data['members'] == "" ? [] : explode(' ', $data['members']);
        $error = '';
        $ids = array();

        $not_found = array();

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();

            if ($user === null) {
                $not_found[] = $user;
            }
            else {
                $ids[] = $user->id;
            }
        }

        $group->users()->attach(Auth::id(), ['is_active' => true]);
        $group->users()->attach($ids);

        if (empty($not_found)) {
            return redirect()->route('dashboard')->with('message', 'Группа успешно создана');
        }
        else {
            $error = 'Пользователи с email: ';
            foreach ($not_found as $email) {
                $error = $error . " $email ";
            }
            $error = $error . ' не были найдены';

            return redirect()->route('dashboard')->withErrors($error);
        }

    }
}
