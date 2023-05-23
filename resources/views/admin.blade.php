<!doctype html>
<html lang="fr">
<head>
    @include('Include/header')
    <title>Namek - Admin</title>

    <!-- CSS HOME -->
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
</head>
<body>
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    @if(session()->has('success'))
                        <br>
                        <div class="alert alert-success" style="width: 60%;margin-left:20%">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-5">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 mb-30">
                    <div class="card" id="card-principale">
                        <div class="card-body">
                          <h4 class="card-title">Total des ventes</h4>
                          <p class="card-text" style="color:red;" id="card-principale-text">{{ number_format($TotalProduct,2) }} CHF</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-30">
                    <div class="card" id="card-principale">
                        <div class="card-body">
                          <h4 class="card-title">Commande total</h4>
                          <p class="card-text" id="card-principale-text">{{ $order->COUNT('id_order') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-30">
                    <div class="card" id="card-principale">
                        <div class="card-body">
                          <h4 class="card-title">Meilleur produit</h4>
                          <!-- SI $MeilleurProduct est null, affiché un message "Pas eu de commande" -->
                          @if (isset($MeilleurProduct) == null)
                            <p class="card-text" id="card-principale-text">Pas eu de commande</p>
                          @else
                            <p class="card-text" id="card-principale-text">{{ $MeilleurProduct->name_product }}</p>
                          @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-30">
                    <div class="card" id="card-principale">
                        <div class="card-body">
                          <h4 class="card-title">Moyenne des avis</h4>
                          <p class="card-text" id="card-principale-text">{{ number_format($avis->AVG('notation'),2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>

        <div class="row" id="admin-resume">
            <div class="col">
                <h3 style="color:#499b4a;">Dashboard</h3><br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <h4 class="mb-4">Nouveaux utilisateurs</h4>
                                <a href="{{ route('adminGerer') }}">
                                    <h6 class="voir-plus">GÉRER</h6>
                                </a>
                                <div class="row">
                                    <table id="table-new-user">
                                        <!-- SI AUCUNE PRODUIT -->
                                        @if (empty($NewUser))
                                            <p class="card-text" id="card-principale-text">Pas d'utilisateur</p>
                                        @else
                                        <thead>
                                            <tr class="table-hr">
                                                <th>Name</th>
                                                <th>email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($NewUser as $NouvelleUtilisateur )
                                                <tr class="table-hr">
                                                    <td>{{ $NouvelleUtilisateur->last_name }} {{ $NouvelleUtilisateur->first_name }}</td>
                                                    <td>{{ $NouvelleUtilisateur->email }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <h4 class="mb-4">Nouveaux produits</h4>
                                <a href="{{ route('adminGerer') }}">
                                    <h6 class="voir-plus">GÉRER</h6>
                                </a>
                                <div class="row">
                                    <table id="table-order">
                                        <!-- SI AUCUNE PRODUIT -->
                                        @if (empty($NewProduct))
                                            <p class="card-text" id="card-principale-text">Pas de produit</p>
                                        @else
                                        <thead>
                                            <tr class="table-hr">
                                                <th>Nom</th>
                                                <th>Date</th>
                                                <th>Prix</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($NewProduct as $NouveauProduit )
                                                <tr class="table-hr">
                                                    <td>{{ $NouveauProduit->name_product }}</td>
                                                    <td>{{ date_format(date_create($NouveauProduit->created_at), 'd.m.y') }}</td>
                                                    <td>{{ number_format($NouveauProduit->price_ht, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <h4 class="mb-4">Nouveaux commentaires</h4>
                                <a href="{{ route('adminGerer') }}">
                                    <h6 class="voir-plus">GÉRER</h6>
                                </a>
                                <div class="row">
                                    <table id="table-order">
                                        <!-- SI AUCUNE COMMANDE -->
                                        @if (empty($NewAvis))
                                            <p class="card-text" id="card-principale-text">Pas de commentaire</p>
                                        @else
                                        <thead>
                                            <tr class="table-hr">
                                                <th>Nom</th>
                                                <th>Commentaire</th>
                                                <th style="text-align: right">Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($NewAvis as $NouveauAvis )
                                                <tr class="table-hr">
                                                    <td>{{ $NouveauAvis->user->username }}</td>
                                                    <td>{{ $NouveauAvis->comment }}</td>
                                                    <td style="text-align: right">{{ $NouveauAvis->notation }}/5</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4 mb-md-0">
                            <div class="card-body">
                                <h4 class="mb-4">Nouvelles commandes</h4>
                                <a href="{{ route('adminGerer') }}">
                                    <h6 class="voir-plus">GÉRER</h6>
                                </a>
                                <div class="row">
                                    <table id="table-order">
                                        <!-- SI AUCUNE COMMANDE -->
                                        @if (empty($NewOrder))
                                            <p class="card-text" id="card-principale-text">Pas eu de commande</p>
                                        @else
                                            <thead>
                                                <tr class="table-hr">
                                                    <th>Number</th>
                                                    <th>Date d'achat</th>
                                                    <th style="text-align: right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($NewOrder as $NouvelleCommande )
                                                    <tr class="table-hr">
                                                        <td>{{ $NouvelleCommande->order_number }}</td>
                                                        <td>{{ date_format(date_create($NouvelleCommande->date_purchase), 'd.m.y') }}</td>
                                                        <td style="text-align: right">
                                                            @if($NouvelleCommande->status == "En attente")
                                                                <span class="badge badge-warning" style="background: rgb(211, 211, 29)">{{ $NouvelleCommande->status }}</span>
                                                            @elseif($NouvelleCommande->status == "En cours")
                                                                <span class="badge badge-info" style="background: blue">{{ $NouvelleCommande->status }}</span>
                                                            @elseif($NouvelleCommande->status == "Terminé")
                                                                <span class="badge badge-info" style="background: green">{{ $NouvelleCommande->status }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="#flush-collapseOne">
                                Ajouter un produit
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <form action="{{ route('add_product') }}" method="POST">
                                    @csrf
                                    <table>
                                        <tr>
                                            <td>
                                                <label for="product-name"> <b>Nom</b></label><br>
                                                <input type="text" placeholder="Lemon Haze" name="product-name" id="input" required>
                                            </td>
                                            <td>
                                                <label for="product-description"> <b>Description</b></label><br>
                                                <input type="text" placeholder="Description du produit" name="product-description" id="input" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="product-image"><b>Image</b></label><br>
                                                <input type="file" placeholder="Image du produit" name="product-image" id="input" accept="image/*" required>
                                            </td>
                                            <td>
                                                <label for="product-size"><b>Poids [gr]</b></label><br>
                                                <input type="number" placeholder="Taille du produit" name="product-size" id="input" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="product-thc"><b>Taux [THC]</b></label><br>
                                                <input type="number" min="0" max="1" placeholder="1" name="product-thc" id="input" required>
                                            </td>
                                            <td>
                                                <label for="product-cbd"><b>Taux [CBD]</b></label><br>
                                                <input type="number" min="0" placeholder="26" name="product-cbd" id="input" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="product-culture"><b>Culture</b></label><br>
                                                <input type="text" placeholder="intérieur" name="product-culture" id="input" required>
                                            </td>
                                            <td>
                                                <label for="product-price-ht"><b>Prix [HT]</b></label><br>
                                                <input type="number" placeholder="12,45" step="0.01" min="0" name="product-price-ht" id="input" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="product-stock"><b>En stock</b></label><br>
                                                <input type="number" min="0" placeholder="7" name="product-stock" id="input" required>
                                            </td>
                                            <td>
                                                <label for="product-categrory"><b>Category</b></label><br>
                                                <select name="product-categrory" id="input" required>
                                                    <option value="1">Plantes CBD</option>
                                                    <option value="2">Huiles CBD</option>
                                                    <option value="3">Bonbons CBD</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @error('product-name')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-description')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-image')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-size')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-thc')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-cbd')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-culture')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-price-ht')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-stock')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                                @error('product-categrory')
                                                    <div class="alert alert-danger">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><button class="cta-btn" type="submit">Envoyer</button></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('Include/footer')
</body>
</html>
