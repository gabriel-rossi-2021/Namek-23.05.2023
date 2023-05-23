<?php

namespace App\Http\Controllers\shop;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\Login;
use App\Models\Product;
use App\Models\User;
use App\Models\Opinions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

class MainController extends Controller
{
    // RETOURNE LA VUE INDEX.BLADE.PHP
    public function index(){
        // RENVOIE LES CATEGORIES
        $categories = Category::all();

        // RENVOIE LES 5 DERNIERS PRODUITS AJOUTEE - FLUX RSS
        $rss = Product::query()->orderBy('created_at', 'desc')->take(6)->get();

        return view('shop.indexCategory',  compact('categories', 'rss'));
    }

    public function showFunction(){
        $function = User::where('function_id == 1')->get();

        return view('include.header', compact('function'));
    }


    public function productAll(Request $request){
        // Récupère la valeur du paramètre de requête "tri"
        $tri = $request->input('tri');

        // Tri les produits en fonction de la valeur de "tri"
        if ($tri == 'prix-croissant') {
            $produits = Product::orderBy('price_ht', 'asc')->get();
        }
        else if ($tri == 'prix-decroissant') {
            $produits = Product::orderBy('price_ht', 'desc')->get();
        }
        else if($tri == 'enstock'){
            $produits = Product::where('available', '>', 0)->get();
        }
        else {
            $produits = Product::all();
        }

        return view('shop.produit', compact('produits'));
    }

    public function product(Request $request){
        // Récupère la valeur du paramètre de requête "tri"
        $tri = $request->input('tri');

        // Récupère la valeur du paramètre de requête "category_id"
        $category_id = $request->id;

        // Initialise la requête de sélection de produits
        $query = Product::query();

        // Ajoute la condition de filtrage par category_id
        $query->where('category_id', $category_id);

        // Tri les produits en fonction de la valeur de "tri"
        if ($tri == 'prix-croissant') {
            $query->orderBy('price_ht', 'asc');
        }
        else if ($tri == 'prix-decroissant') {
            $query->orderBy('price_ht', 'desc');
        }
        // Tri en fonction des produit en stock
        else if($tri == 'enstock'){
            $query->where('available', '>', 0);
        }

        // Récupère les produits triés
        $produits = $query->get();

        // RENVOIE LA CATEGORY ASSOCIER AUX PRODUITS
        $category = Category::findOrFail($category_id);

        return view('shop.produit', compact('produits', 'category'));
    }

    // DETAILS PRODUIT
    public function detailsProduit(Request $request, $id){
        // NOMBRE RANDOM POUR CAPTCHA
        $num1Avis = rand(1, 10);
        $num2Avis = rand(1, 10);
        // RESULTAT DU CAPTCHA
        $resultAvis = $num1Avis + $num2Avis;
        session(['captcha_result_avis' => $resultAvis]);

        $produit = Product::findOrFail($id);

        $opinions = $produit->opinions()->where('etat', 'Actif')->get();

        // SELECT * FROM product WHERE id_product = ? + charger les opinions avec with + que les commentaire activer
        $details = Product::with(['opinions' => function ($query) {
            $query->where('etat', 'Actif');
        }])->where('id_product', $id)->first();


        // Moyenne des notaitons sans les commentaire désactiver
        $averageRating = Opinions::where('product_id', $produit->id_product)
            ->where('etat', 'Actif')
            ->avg('notation');

        return view('shop.details', compact('details', 'produit', 'opinions', 'averageRating', 'num1Avis', 'num2Avis'));
    }

    // Créer un commentaire sur un produit
    public function AjoutComment(Request $request, $id){
        // SELECT * FROM product WHERE id_product = ?
        $details = Product::where('id_product', $id)->first();

        $validatedData = $request->validate([
            'comment' => 'required|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'captcha_avis' => 'required',
        ], [
            'comment.regex' => 'Le commentaire ne doit pas dépasser 255 caractères',
        ]);

        $captcha = $request->input('captcha_avis');

        // RECUPERER LE RESULTAT DU CAPTCHA
        $resultAvis = session('captcha_result_avis');

        // VERIFICATION CAPTCHA
        if ($captcha == $resultAvis){
            // New Opinions
            $opinion = new Opinions;
            $opinion->comment = $validatedData['comment'];
            $opinion->notation = $validatedData['rating'];
            $opinion->product_id = $details->id_product;
            $opinion->user_id = auth()->id();
            $opinion->etat = 'Passif';
            // DATE ET HEURE ACTUEL
            $opinion->created_at = Carbon::now();
            $opinion->updated_at = Carbon::now();
            $opinion->save();

            return redirect()->back()->with('success', "Votre avis a été ajouté avec succès. L'administrateur doit le valider avant qu'il apparaît");
        }else{
            return redirect()->back()->withErrors(['captcha' => 'Le captcha est pas correct'])->withInput();
        }
    }


    // AFFICHE LA PAGE DE CONNEXION
    public function showLoginForm()
    {
        return view('login');
    }

    // SALT FIXE
    protected $salt = 'i;151-120#';

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password') . $this->salt,
        ];

        // Récupérer l'utilisateur correspondant
        // $user = User::where('email', $credentials['email'])->first();

        // Vérification du mot de passe en ajoutant le salt
        if (Auth::attempt($credentials)) {
            // Si les informations d'identification sont valides, l'utilisateur est connecté
            return redirect()->intended('/');
        }
        else {
            // Si les informations d'identification ne sont pas valides, l'utilisateur est redirigé vers la page de connexion avec un message d'erreur
            return redirect()->back()->withInput($request->only('email'))->withErrors([
                'email' => "L'email et/ou le mot de passe ne sont pas valides."
            ]);
        }
    }

    // DECONNECTER LA SESSION DE L'UTILISATEUR
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home'); // RENVOIE SUR LA PAGE HOME
    }

    // INSCRIPTION AFFICHE
    public function inscription(){
        // NOMBRE RANDOM POUR CAPTCHA
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        // RESULTAT DU CAPTCHA
        $result = $num1 + $num2;
        session(['captcha_result' => $result]);

        return view('signup', compact('num1', 'num2'));
    }

    // CREATION UTILISATEUR
    public function register(Request $request)
    {

         // Variable qui stock le pays par defaut
         $PaysParDefaut = 'Suisse';

         // Valider les données du formulaire
         $validatedData = $request->validate([
             'titre' => 'required|max:50',
             'phone' => ['required', 'regex:/^(?!0|\+41)\d{9}$/'],
             'name' => 'required|string|max:50',
             'lastName' => 'required|string|max:50',
             'username' => 'required|regex:/^[^A-Z@]*$/|max:20',
             'email' => 'required|regex:/^([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/',
             'psw' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'],
             'confirm-psw' => 'required|same:psw',
             'birth' => 'required|date|before_or_equal:'.now()->subYears(18)->format('Y-m-d'),
             'rue' => 'required|regex:/^[a-zA-Z\s]+$/',
             'num-rue' => 'required|regex:/^\d+$/',
             'ville' => 'required|regex:/^[a-zA-Z]{1,50}$/',
             'npa' => ['required', 'regex:/^(1[0-9]{3}|2[0-9]{3}|3[0-9]{3}|4[0-9]{3}|5[0-9]{3}|6[0-5][0-9]{2}|965[0-8])$/'],
         ], [
            'phone.regex' => 'Le numéro de téléphone doit être renseigné comme ceci 788237818',
            'name.regex' => 'Le prénom doit contenir uniquement des lettres et maximum 50 caractères',
            'lastName.regex' => 'Le nom doit contenir uniquement des lettres et maximum 50 caractères',
            'username.regex' => "Le nom d'utilisateur ne doit pas contenir de majusucules et de '@'.",
            'email.regex' => "L'email doit contenir un '@' et un '.'",
            'psw.regex' => "Le mot de passe doit contenir au moins 8 caractère et 1 majuscule",
            'rue.regex' => 'La rue ne peux contenir que des lettres miniscules et majuscules',
            'num-rue.regex' => 'Le numéro de rue peux contenir que des chiffres',
            'ville.regex' => 'La ville ne peux pas contenir de chiffre et dois faire max 50 caractères',
            'npa.regex' => 'Le npa doit être entre 1000 et 9658',

         ]);

         $password = $validatedData['psw'];
         $captcha = $request->input('captcha');

         // Vérifier si le mot de passe correspond à la confirmation
         if ($password !== $validatedData['confirm-psw']) {
             return redirect()->back()->withErrors(['password' => 'Le mot de passe et la confirmation ne correspondent pas.'])->withInput();
         }

         // RECUPERER LE RESULTAT DU CAPTCHA
         $result = session('captcha_result');

         // VERIFICATION CAPTCHA
         if ($captcha == $result){
             // Créer un nouvel utilisateur
             $user = new User();
             $user->title = $validatedData['titre'];
             $user->phone_number = $validatedData['phone'];
             $user->first_name = $validatedData['name'];
             $user->last_name = $validatedData['lastName'];
             $user->username = $validatedData['username'];
             $user->email = $validatedData['email'];
             $user->password = $password . $this->salt;
             $user->birth_date = $validatedData['birth'];
             $user->function_id = 3;

             // Créer une nouvelle adresse
             $address = new Address();
             $address->street = $validatedData['rue'];
             $address->street_number = $validatedData['num-rue'];
             $address->city = $validatedData['ville'];
             $address->NPA = $validatedData['npa'];
             $address->country = $PaysParDefaut;
             $address->save();

             // Lier l'adresse à l'utilisateur
             $user->address()->associate($address);

             // Enregistrer l'utilisateur
             $user->save();

             // Connecter l'utilisateur
             auth()->login($user);

             // Rediriger vers la page d'accueil
             return redirect('/');
         }else{
             return redirect()->back()->withErrors(['captcha' => 'Le captcha est pas correct'])->withInput();
         }
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::where('name_product', 'like', '%'.$query.'%')->get();

        return view('Include.search', ['products' => $products], compact('query'));
    }




}
