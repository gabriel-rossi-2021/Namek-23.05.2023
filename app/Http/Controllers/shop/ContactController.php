<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Afficher le formulaire de contact
    public function AfficheContactView(){
        return view('contact');
    }

    // Traitement / Envoie du formulaire
    public function EnvoieContactForm(Request $request){

        $validatedData = $request->validate([
            'email' => 'required|regex:/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/',
            'subject' => 'required|string|max:50',
            'message' => 'required|max:255',
        ], [
            // MESSAGE EN CAS DE NON RESPECT DE LA REGEX
            'email.regex' => "L'email doit contenir un '@' et un '.'",
            'subject.regex' => 'Le sujet ne peux continir que des lettres et max 100 caractères',
            'message.regex' => 'Le message doit contenir maximum 255 caractères',
        ]);

        // REDIRECTION /DASHBOARD + MESSAGE DE SUCCESS
        return redirect()->route('contact.affiche')->with('success', 'Votre message a bien été envoyé');
    }
}
