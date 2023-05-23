<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Opinions;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Afficher la view dashboard
    public function AfficheAdmin(Request $request){
        // USER CONNECTE
        $user = $request->user();
        // ALL COMMANDES
        $order = Order::all();
        // Total des ventes
        $TotalProduct = OrderProduct::with('product')
            ->selectRaw('SUM(quantity * products.price_ht) as total')
            ->join('products', 'order_product.product_id', '=', 'products.id_product')
            ->first()
            ->total;

            // Meilleur produit
            $product = OrderProduct::select('product_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->first();

            // SI PAS DE commande
            if($product !== null){
                $MeilleurProduct = Product::findOrFail($product->product_id);

                // Nouveau utilisateur
                $NewUser = User::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Nouveau produit
                $NewProduct = Product::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Gérer les avis
                $NewAvis = Opinions::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Nouvelle commande
                $NewOrder = Order::query()->orderBy('created_at', 'desc')->take(5)->get();

                // ALL AVIS
                $avis = Opinions::all();

                return view('admin',compact('order', 'avis', 'TotalProduct', 'MeilleurProduct', 'NewUser', 'NewProduct', 'NewAvis', 'NewOrder'));
            }else{
                // Nouveau utilisateur
                $NewUser = User::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Nouveau produit
                $NewProduct = Product::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Gérer les avis
                $NewAvis = Opinions::query()->orderBy('created_at', 'desc')->take(3)->get();

                // Nouvelle commande
                $NewOrder = Order::query()->orderBy('created_at', 'desc')->take(3)->get();

                // ALL AVIS
                $avis = Opinions::all();
                return view('admin',compact('order', 'avis', 'TotalProduct', 'NewUser', 'NewProduct', 'NewAvis', 'NewOrder'));
            }


    }

    public function AddProduct(Request $request){

        $validatedData = $request->validate([
            'product-name' => 'required|string|max:50',
            'product-description' => 'required|string|max:255',
            'product-image' => 'required',
            'product-size' => 'required|regex:/^\d+$/',
            'product-thc' => 'required|regex:/^\d+$/',
            'product-cbd' => 'required|regex:/^\d+$/',
            'product-culture' => 'required|string|max:20',
            'product-price-ht' => 'required',
            'product-stock' => 'required|regex:/^\d+$/',
            'product-categrory' => 'required',
        ],[
            'product-name.regex' => 'Le nom du produit doit contenir uniquement des lettres et maximum 50 caractères',
            'product-description.regex' => 'Le nom du produit doit contenir uniquement des lettres et maximum 255 caractères',
            'product-image.regex' => "l'image du produit est obligatoire",
             //'product-image.image' => "l'image doit être une image",
            'product-size.regex' => 'La taille peux contenir que des chiffres',
            'product-thc.regex' => 'Le taux de thc peux contenir que des chiffres',
            'product-cbd.regex' => 'Le taux de cbd peux contenir que des chiffres',
            'product-culture.regex' => 'La culture du produit doit contenir uniquement des lettres et maximum 20 caractères',
            'product-price-ht.regex' => 'Le prix hors taxe doit contenir deux chiffres après la virgule',
            'product-stock.regex' => 'Le stock peux contenir que des chiffres',
            'product-categrory.regex' => 'La category du produit est obligatoire',
        ]);

        // AJOUTER L'IMAGE DANS LE DOSSIER PUBLIC/IMG/PRODUCTS
        /*
        $image = $request->file('product-image');

        // AJOUTER UN PRODUIT
        if($image){
            $extension = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = 'product_' . time() . '.' . $extension;
            $image->storeAs('public/img/Products', $imageName);
        }
        */

        $productAjouter = new Product();
        $productAjouter->name_product = $validatedData['product-name'];
        $productAjouter->description = $validatedData['product-description'];
        //$productAjouter->image_product = $imageName;
        $productAjouter->image_product = $validatedData['product-image'];
        $productAjouter->size = $validatedData['product-size'];
        $productAjouter->thc_rate = $validatedData['product-thc'];
        $productAjouter->cbd_rate = $validatedData['product-cbd'];
        $productAjouter->culture = $validatedData['product-culture'];
        $productAjouter->price_ht = $validatedData['product-price-ht'];
        $productAjouter->available = $validatedData['product-stock'];
        $productAjouter->category_id = $validatedData['product-categrory'];
        $productAjouter->save();

        return redirect()->back()->with('success', 'Le nouveau produit a bien été ajouté.');
    }

}
