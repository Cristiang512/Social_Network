<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Idea;
use App\Models\GroupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupRequestController extends Controller
{
    public function index()
    {
        // Obtén las solicitudes de grupos
        $requests = GroupRequest::all();

        // Obtén los grupos relacionados con las solicitudes
        $group = Group::all()->where('id_user',auth()->user()->id);


        // Pasar las variables a la vista
        return view('solicitudes', ['requests' => $requests, 'group' => $group]);
    }


    public function showRequests($groupId)
    {
        $group = Group::with('requests.user')->findOrFail($groupId);

        return view('solicitudes', compact('group'));
    }
}
