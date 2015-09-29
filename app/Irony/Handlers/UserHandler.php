<?php namespace Irony\Handlers;

use Illuminate\Support\Facades\Mail;

class UserHandler {


	public function onCreate($user)
	{
			// I'm creating an array with user's info but most likely you can use $user->email or pass $user object to closure later
			$userEmail = array(
			  'email'=> $user->email,
			  'username'=> $user->present()->username
			);
			 
			// the data that will be passed into the mail view blade template
			$data = array(
			  'token'=> $user->token,
			  'username'  => $user->present()->username
			);
			 
			// use Mail::send function to send email passing the data and using the $user variable in the closure
			Mail::send('emails.auth.confirmation', $data, function($message) use ($userEmail)
			{
				$message->to($userEmail['email'], $userEmail['username'])->subject('My Market Ottawa confirmation');
			});
	}


	public function subscribe($events)
	{
		$events->listen('users.create','Irony\Handlers\UserHandler@onCreate');
	}

}