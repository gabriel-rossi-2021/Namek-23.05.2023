<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Opinions;

class AdminGererController extends Controller
{
    // VUE GererAdmin
    public function index(){
        // ALL USER
        $userGerer = User::all();

        // ALL PRODUCTS
        $productGerer = Product::all();

        // ALL COMMENT
        $commentGerer = Opinions::all();

        // ALL COMMANDE
        $orderGerer = Order::all();


        return view('adminGerer', compact('userGerer', 'productGerer', 'commentGerer', 'orderGerer'));
    }

    // AFFICHER VUE adminGererUser
    public function indexUserGerer($id){

        $updateUser = User::find($id);

        return view('adminGererUser', compact('updateUser'));
    }

    // UPDATE UTILISATEUR
    public function updateUser(Request $request, $id){
        $user = User::find($id);

        $ipUser = $request->ip();

        $user->title = $request->input('titre');
        $user->phone_number = $request->input('phone');
        $user->first_name = $request->input('name');
        $user->last_name = $request->input('lastName');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->birth_date = $request->input('birth');
        $user->save();

        $address = $user->address;
        $address->street = $request->input('rue');
        $address->street_number = $request->input('num-rue');
        $address->city = $request->input('ville');
        $address->NPA = $request->input('npa');
        $address->save();

        return redirect()->route('adminGerer')->with('success', "Votre modification a été ajouté avec succès.");
    }

    // AFFICHER VUE adminGererProduit
    public function indexProduitGerer($id){

        $updateProduit = Product::find($id);

        return view('adminGererProduit', compact('updateProduit'));
    }

    // UPDATE PRODUIT
    public function updateProduit(Request $request, $id){
        $produit = Product::find($id);

        $produit->name_product = $request->input('name');
        $produit->description = $request->input('description');
        $produit->size = $request->input('size');
        $produit->thc_rate = $request->input('thc');
        $produit->cbd_rate = $request->input('cbd');
        $produit->culture = $request->input('culture');
        $produit->price_ht = $request->input('prix');
        $produit->available = $request->input('stock');
        $produit->category_id = $request->input('category');
        $produit->save();

        return redirect()->route('adminGerer')->with('success', "Le produit a été modifié avec succès.");
    }


    // SUPRESSION D'UN PRODUIT
    public function removeProduit($id){
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('adminGerer')->with('success', "Le produit a été supprimé avec succès.");
    }


    // SUPRESSION D'UN UTILISATEUR
    public function removeUser($id){
        $user = User::find($id);
        $user->delete();
        $user->address()->delete(); // SUPPRIMER L'ADRESSE ASSOCIEE
        return redirect()->route('adminGerer')->with('success', "Votre utilisateur a été supprimé avec succès.");
    }


    // UPDATE COMMENT
    public function manageComment($id)
    {

        $comment = Opinions::find($id);
        if ($comment) {
            if ($comment->etat == 'Actif') {
                $comment->etat = 'Passif';
            } else {
                $comment->etat = 'Actif';
            }

            $comment->save();
        }

        return redirect()->route('adminGerer')->with('success', "Le commentaire a été changé d'état.");
    }

    // SUPRESSION D'UN COMMENTAIRE
    public function removeComment($id){
        $comment = Opinions::find($id);
        $comment->delete();
        return redirect()->route('adminGerer')->with('success', "Le commentaire a été ajouté avec succès.");
    }


    // UPDATE STATUS COMMANDE
    public function updateOrderStatus(Request $request, $id){
        $order = Order::find($id);
        $order->status = $request->input('status_commande');
        $order->save();
        return redirect()->route('adminGerer')->with('success', "La status a été changé avec succès.");
    }

    // SUPRESSION D'UNE COMMANDE
    public function removeOrder($id){
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('adminGerer')->with('success', "La commande a été supprimé avec succès.");
    }

}
