<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    // Afficher la view dashboard
    public function AfficheDashboard(Request $request){
        // Si l'utilisateur est co
        $user = $request->user();

        // COMMANDE
        $order = Order::where('user_id', $user->id_users)->get();

        // FORMAT AFFICHAGE N° TEL SUISSE
        $phone_number = $user->phone_number;
        $formatted_number = substr($phone_number, 0, 2) . ' ' . substr($phone_number, 2, 3) . ' ' . substr($phone_number, 5, 2) . ' ' . substr($phone_number, 7, 2);

        return view('dashboard', ['user' => $user], compact('formatted_number', 'order'));
    }

    // Update form info gen
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            // REGEX
            'email' => 'required|regex:/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/',
            'phone_number' => ['required', 'regex:/^(?!0|\+41)\d{9}$/'],
            'username' => 'required|regex:/^[^A-Z@]*$/|max:20',
        ], [
            // MESSAGE D'ERREUR EN CAS DE NON RESPECT DE LA REGEX
            'email.regex' => "L'email doit contenir un '@' et un '.'",
            'phone_number.regex' => 'Le numéro de téléphone doit être renseigné comme ceci 788237818',
            'username.regex' =>  "Le nom d'utilisateur ne doit pas contenir de majusucules et de '@'.",
        ]);

        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->username = $request->input('username');

        $user->save();

        // REDIRECTION /DASHBOARD + MESSAGE DE SUCCESS
        return redirect()->route('dashboard', $id)->with('success', 'Les informations générales a été changé avec succès.');

    }

    // Update password
    public function updatePassword(Request $request, $id)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'],
        ], [
            // MESSAGE D'ERREUR EN CAS DE NON RESPECT DE LA REGEX
            'password.regex' => "Le mot de passe doit contenir au moins 8 caractère et 1 majuscule",
        ]);


        // Variable qui stock le SALT
        $salt = 'i;151-120#';

        if (!Hash::check($request->current_password . $salt, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = $request->input('password') . $salt;
        $user->save();

        // REDIRECTION /DASHBOARD + MESSAGE DE SUCCESS
        return redirect()->route('dashboard', $id)->with('success', 'Le mot de passe a été changé avec succès.');
    }

    // Update password
    public function updateAddress(Request $request, $id)
    {
        $user = auth()->user();

        $request->validate([
            // REGEX
            'rue' => 'required|regex:/^[a-zA-Z\s]+$/',
            'NdeRue' => 'required|regex:/^\d+$/',
            'ville' => 'required|regex:/^[a-zA-Z]{1,50}$/',
            'npa' => ['required', 'regex:/^(1[0-9]{3}|2[0-9]{3}|3[0-9]{3}|4[0-9]{3}|5[0-9]{3}|6[0-5][0-9]{2}|965[0-8])$/'],
        ], [
            // MESSAGE D'ERREUR EN CAS DE NON RESPECT DE LA REGEX
            'rue.regex' => 'La rue ne peux contenir que des lettres miniscules et majuscules',
            'NdeRue.regex' => 'Le numéro de rue peux contenir que des chiffres',
            'ville.regex' => 'La ville ne peux pas contenir de chiffre et dois faire max 50 caractères',
            'npa.regex' => 'Le npa est doit être entre 1000 et 9658',
        ]);

        $user->address->street = $request->input('rue');
        $user->address->street_number = $request->input('NdeRue');
        $user->address->city = $request->input('ville');
        $user->address->NPA = $request->input('npa');

        $user->address->save();

        // REDIRECTION /DASHBOARD + MESSAGE DE SUCCESS
        return redirect()->route('dashboard', $id)->with('success', "L'adresse a été changé avec succès.");
    }
}
