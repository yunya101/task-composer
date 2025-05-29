<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $invitations = Auth::user()->groups()->wherePivot('is_active', false)->get();

        return view('notifications.index', compact('invitations'));
    }

    public function accept(Group $group)
    {
        Auth::user()->groups()->updateExistingPivot($group, ['is_active' => true]);
        $group->count_members = $group->count_members + 1;
        $group->update();

        return redirect()->route('notifications.index');
    }

    public function reject(Group $group)
    {
        Auth::user()->groups()->detach($group->id);

        return redirect()->route('notifications.index');
    }
}
