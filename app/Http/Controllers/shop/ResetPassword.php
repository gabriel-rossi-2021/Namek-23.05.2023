<?php

namespace App\Http\Controllers\shop;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPassword extends Controller
{
    // VUE resetPassword
    public function index(){
        return view('resetPassword');
    }

    public function sendEmail(Request $request){
        // NE FONCTIONNE PAS CAR JE N'AI PAS DE SERVICES DE MESSAGERIES
        $email = $request->input('email');
        $token = Str::random(60);
        $url = url('password/reset', $token);
        $subject = 'Réinitialisation de votre mot de passe';

        Mail::send('emails.password_reset', compact('url'), function($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
