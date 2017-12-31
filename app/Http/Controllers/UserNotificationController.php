<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserNotificationController extends Controller
{
    public function index(User $user)
    {
    	return $user->unreadNotifications;
    }
}
