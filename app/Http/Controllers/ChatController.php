<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function chat()
    {
    	return view('chat');
    }

    public function send(request $request)
    {
    	$user = User::find(Auth::id());
    	$this->saveToSession($request);
    	event(new ChatEvent($request->message,$user));
    }
    public function saveToSession(request $request)
    {
    	session()->put('chat',$request->chat);
    }

    public function getOldMessage()
    {
    	return session('chat');
    }

    public function deleteSession()
    {
    	session()->forget('chat');
    }
}
