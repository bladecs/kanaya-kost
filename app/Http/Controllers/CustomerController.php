<?php

namespace App\Http\Controllers;

use App\Models\FacilityModel;
use App\Models\User;
use App\Models\RoomModels;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
    public function rooms()
    {
        $available_rooms = RoomModels::where('available', 0)->count();
        return view('dashboard.detail-room', compact('available_rooms'));
    }
    public function profile(Request $request)
    {
        $previous_url = $request->query('previous');
        $user = User::where('name', session('name'))->first();
        return view('dashboard.profile', compact('user', 'previous_url'));
    }
}
