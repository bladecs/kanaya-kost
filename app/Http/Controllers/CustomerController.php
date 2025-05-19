<?php

namespace App\Http\Controllers;

use App\Models\FacilityModel;
use App\Models\User;
use App\Models\RoomModels;
use App\Models\PaymentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = User::where('id', Auth::id())->first();
        $payment = PaymentModel::where('user_id', $user->id)->first();
        $payments = PaymentModel::where('user_id', $user->id)->get();
        $room = RoomModels::where('tenant', $user->id)->first();
        $rooms = RoomModels::where('tenant', $user->id)->get();
        return view('dashboard.profile', compact('user', 'previous_url','payment','payments','room', 'rooms'));
    }
}
