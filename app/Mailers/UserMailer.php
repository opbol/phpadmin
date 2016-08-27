<?php

namespace App\Mailers;

use App\User;

class UserMailer extends AbstractMailer {
	public function sendConfirmationEmail($user, $token) {
		$view = 'emails.registration.confirmation';
		$data = ['token' => $token];
		$subject = 'Registration Confirmation';

		$this->sendTo($user->email, $subject, $view, $data);
	}

	public function sendPasswordReminder(User $user, $token) {
		$view = 'emails.password.remind';
		$data = ['user' => $user, 'token' => $token];
		$subject = 'Password Reset Required';

		$this->sendTo($user->email, $subject, $view, $data);
	}
}