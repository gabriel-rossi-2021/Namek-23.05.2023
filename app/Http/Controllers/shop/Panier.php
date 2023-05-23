<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Discount;
use Cart;
use Illuminate\Http\Request;

class Panier extends Controller
{
    // RETOURNE LA VUE PANIER
    public function showPanier(){

        $content = Cart::getContent();

        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'VAT 7.7%',
            'type' => 'tax',
            'target' => 'subtotal',
            'value' => '7.7%'
        ));
        // APPLIQUER LA CONDITION
        Cart::condition($condition);

        // TOTAL TTC
        $total_ttc_panier = Cart::getTotal();

        // TOTAL TVA
        $tva = $total_ttc_panier / (1 + 0.077) * 0.077;

        // TOTAL HT
        $total_ht_panier = round($total_ttc_panier - $tva, 2);

        // INITALISATION
        $discount_name = null;
        $discount_pourcentage = null;
        $reduction = 0;

        if(session()->has('codePromo')){
            $discount_name = session('codePromo');
            $discount_pourcentage = session('pourcentage');;

            // OBTENIR VALEUR DE LA REDUCTION
            $cartConditions = Cart::getConditions();
            foreach($cartConditions as $condition){
                if($condition->getName() === 'Code Promo'){
                    $reduction = abs($condition->getValue());
                    break;
                }
            }
        }else{
            // SUPPRIMER LA REDUCTION
            Cart::removeCartCondition('Code Promo');
        }

        return view('panier.panier', compact('content', 'total_ttc_panier', 'total_ht_panier', 'tva', 'discount_name', 'reduction', 'discount_pourcentage'));
    }

    // AJOUTER UN PRODUIT AU PANIER
    public function add(Request $request, $id) {
        // récupérer le produit
        $produit = Product::where('id_product', $id)->first();

        // Calculer le prix TTC
        $prix_ttc = $produit->prixTTC() * $request->quantity;

        Cart::add(array(
            'id' => $produit->id_product,
            'name' => $produit->name_product,
            'price' => $produit->price_ht,
            'quantity' => $request->quantity,
            'attributes' => array('image'=>$produit->image_product, 'prix_ttc'=>$prix_ttc)
        ));

        return redirect(route('panier_show'));
    }


    public function promo(Request $request)
    {
        // Récupérer le code promo potentiel
        $codePromo = $request->input('codePromo');

        // Vérifier si le code promo est valide
        $discount = Discount::where('name_discount', $codePromo)
                            ->where('status', 'actif')
                            ->first();

        if ($discount) {
            // Vérifier si le code promo a déjà été utilisé en vérifiant la session
            $sessionPromo = $request->session()->get('codePromo');

            if ($sessionPromo === null) {
                // Appliquer la réduction
                $tauxReduction = $discount->percentage;
                $reduction = round(Cart::getTotal() * ($tauxReduction / 100), 2);

                Cart::condition(new \Darryldecode\Cart\CartCondition([
                    'name' => 'Code Promo',
                    'type' => 'discount',
                    'target' => 'subtotal',
                    'value' => '-' . $reduction,
                ]));

                // Stocker le code promo dans la session
                $request->session()->put('codePromo', $codePromo);

                // Assigner le nom du code promo à la variable $discount_name
                $discount_name = $discount->name_discount;
                // STOCKER LE POURCENTAGE
                $discount_pourcentage = $discount->percentage;
                session()->put('pourcentage', $discount_pourcentage);

                // Arrondir le total à deux chiffres après la virgule
                $total_ttc_panier = round(Cart::getTotal(), 2);
            } else {
                // Le code promo a déjà été utilisé
                return redirect()->back()->withErrors([
                    'codePromo' => "Ce code promo a déjà été utilisé.",
                ]);
            }
        } else {
            // Le code promo n'est pas valide
            return redirect()->back()->withErrors([
                'codePromo' => "Ce code promo n'est pas valide.",
            ]);
        }

        return redirect()->route('panier_show')->with(compact('discount_name', 'reduction', 'total_ttc_panier', 'discount_pourcentage'));
    }



    // SUPPRIMER UN PRODUIT DU PANIER
    public function suppProduit($id){
        Cart::remove($id);

        // SUPPRIMER LE CODE PROMO
        session()->forget('codePromo');

        return back();
    }

    // SUPPRIMER UN CODE PROMO
    public function promoRemove(){
        // SUPPRIMER LE CODE PROMO
        session()->forget('codePromo');

        // SUPPRIMER LA CONDITION DE REDUCTION DU CODE PROMO
        Cart::removeCartCondition('Code Promo');

        // RECALCULER LE MONTANT DE LA REDUCTION
        $reduction = 0;

        $total_ttc_panier = round(Cart::getTotal(), 2);

        return back()->with('reduction', 'total_ttc_panier');
    }
}
