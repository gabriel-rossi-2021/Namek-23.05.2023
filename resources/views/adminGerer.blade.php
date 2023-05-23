<!doctype html>
<html lang="fr">
<head>
    @include('Include/header')
    <title>Namek - Admin</title>

    <!-- CSS HOME -->
    <link rel="stylesheet" href="{{ asset('css/style-adminGerer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-dashboard.css') }}">
</head>
<body>
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    @error('current_password')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="admin">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gérer</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 mb-lg-0">
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush rounded-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 show-form" id="show-form-gerer-user">
                                    <p class="mb-0">Gérer les utilisateurs</p>
                                    <i class="fa-solid fa-user"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 show-form"  id="show-form-gerer-produit">
                                    <p class="mb-0">Gérer les produits</p>
                                    <i class="fa-solid fa-stop"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 show-form" id="show-form-gerer-comment">
                                    <p class="mb-0">Gérer les commentaires</p>
                                    <i class="fa-solid fa-comment"></i>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 show-form" id="show-form-gerer-commande">
                                    <p class="mb-0">Gérer les commandes</p>
                                    <i class="fa-solid fa-shopping-cart"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div id="my-form-gerer-user" style="display: flex">
                        <table>
                            <thead>
                                <tr class="table-hr">
                                    <th>Nom</th>
                                    <th>email</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!-- FORMULAIRE DE GESTION DES UTILISATEURS -->
                            @foreach ($userGerer as $formGererUser)
                                <form class="my-form" method="POST" action="{{ route('remove_user', ['id' => $formGererUser->id_users]) }}">
                                @csrf
                                @method('DELETE')
                                    <tbody>
                                        <tr class="table-hr">
                                            <td>{{ $formGererUser->last_name }} {{ Str::limit($formGererUser->first_name, 1, '.') }}</td>
                                            <td>{{ $formGererUser->email }}</td>
                                            <td>
                                                <a href="{{ route('index_user_gerer', ['id'=>$formGererUser->id_users]) }}">
                                                    <span class="badge badge-warning" style="background: rgb(211, 211, 29)"><i class="fa-solid fa-edit"></i></span>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="submit" class="badge badge-warning" style="background: red">
                                                    <i class="fa-solid fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </form>
                            @endforeach
                        </table>
                    </div>

                    <div id="my-form-gerer-produit" style="display: none">
                        <table>
                            <thead>
                                <tr class="table-hr">
                                    <th>Nom</th>
                                    <th>Prix HT</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!-- FORMULAIRE DE GESTION DES PRODUITS -->
                            @foreach ($productGerer as $formGererProduit)
                                <form class="my-form" method="POST" action="{{ route('remove_produit', ['id' => $formGererProduit->id_product]) }}">
                                @csrf
                                @method('DELETE')
                                    <tbody>
                                        <tr class="table-hr">
                                            <td>{{ $formGererProduit->name_product }}</td>
                                            <td>{{ number_format($formGererProduit->price_ht,2) }}</td>
                                            <td>
                                                <a href="{{ route('index_produit_gerer', ['id'=>$formGererProduit->id_product]) }}">
                                                    <span class="badge badge-warning" style="background: rgb(211, 211, 29)"><i class="fa-solid fa-edit"></i></span>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="submit" class="badge badge-warning" style="background: red">
                                                   <i class="fa-solid fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </form>
                            @endforeach
                        </table>
                    </div>

                    <div id="my-form-gerer-comment" style="display: none">
                        <table>
                            <thead>
                                <tr class="table-hr">
                                    <th>Utilisateur</th>
                                    <th>Produit</th>
                                    <th>Avis</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!-- FORMULAIRE DE GESTION DES COMMENTAIRES -->
                            <tbody>
                                @foreach ($commentGerer as $formGererCommentaire)
                                    <tr class="table-hr">
                                        <form style="display:flex" class="my-form" method="POST" action="{{ route('manage_comment', ['id' => $formGererCommentaire->id_opinion]) }}">
                                            @csrf
                                            @method('PUT')
                                                <td>{{ $formGererCommentaire->user->username }}</td>
                                                <td>{{ $formGererCommentaire->product->name_product }}</td>
                                                <td>{{ implode(' ', array_slice(explode(' ', $formGererCommentaire->comment ), 0,3)) }}... </td>
                                                <td>
                                                    @if ($formGererCommentaire->etat == 'Actif')
                                                        <button type="submit" class="badge badge-warning" style="background: rgb(211, 211, 29)" title="Cacher le commentaire">
                                                            <i class="fa-solid fa-ban"></i>
                                                        </button>
                                                    @else
                                                        <button type="submit" class="badge badge-warning" style="background: green" title="Afficher le commentaire">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                        </form>

                                        <form class="my-form" method="POST" action="{{ route('remove_comment', ['id' => $formGererCommentaire->id_opinion]) }}">
                                            @csrf
                                            @method('DELETE')
                                                <td>
                                                    <button type="submit" class="badge badge-warning" style="background: red" title="Supprimer le commentaire">
                                                        <i class="fa-solid fa-remove"></i>
                                                    </button>
                                                </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="my-form-gerer-commande" style="display: none">
                        <table>
                            <thead>
                                <tr class="table-hr">
                                    <th>N° commande</th>
                                    <th>Status</th>
                                    <th>Modifier</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <!-- FORMULAIRE DE GESTION DES COMMANDES -->
                            <tbody>
                                @foreach ($orderGerer as $formGererCommande)
                                    <tr class="table-hr">
                                        <form class="my-form" method="POST" action="{{ route('update_order_status', ['id' => $formGererCommande->id_order]) }}">
                                        @csrf
                                        @method('PUT')
                                            <td>{{ $formGererCommande->order_number }}</td>
                                            <td>{{ $formGererCommande->status }}</td>
                                            <td>
                                                <select name="status_commande" id="status_commande">
                                                    <option value="En attente" {{ $formGererCommande->status == 'En attente' ? 'selected' : '' }}>En attente</option>
                                                    <option value="En cours" {{ $formGererCommande->status == 'En cours' ? 'selected' : '' }}>En cours</option>
                                                    <option value="Terminé" {{ $formGererCommande->status == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="submit" class="badge badge-warning" style="background: rgb(211, 211, 29)">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                            </td>
                                        </form>
                                        <form class="my-form" method="POST" action="{{ route('remove_order', ['id' => $formGererCommande->id_order]) }}">
                                            @csrf
                                            @method('DELETE')
                                                <td>
                                                    <button type="submit" class="badge badge-warning" style="background: red">
                                                        <i class="fa-solid fa-remove"></i>
                                                    </button>
                                                </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="my-form-edit-user" style="display:none" class="update-form">
                        <h5>Modifier compte : </h5>
                        <div class="col-lg-6">
                            <form method="POST" action="">
                                @csrf
                                @method('PUT')
                                <table>
                                    <tr>
                                        <td>
                                            <label for="prenom">Prénom :</label><br>
                                            <input type="text" value="" id="input" name="prenom">
                                        </td>
                                        <td>
                                            <label for="nom">Nom :</label><br>
                                            <input type="text" value="test" id="input" name="nom">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="date">Date de naissance :</label><br>
                                            <input type="date" id="input" name="date">
                                        </td>
                                        <td>
                                            <label for="phone">N° de tél :</label><br>
                                            <input type="number" id="input" name="phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="username">Utilisateur :</label><br>
                                            <input type="text" id="input" name="username">
                                        </td>
                                        <td>
                                            <label for="role">Rôle</label><br>
                                            <select name="role" id="input">
                                                <option value="1">Admin</option>
                                                <option value="2">Modérateur</option>
                                                <option value="3">Client</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="email">Email :</label><br>
                                            <input type="email" id="input" name="email">
                                        </td>
                                        <td>
                                            <label for="password">Mot de passe :</label><br>
                                            <input type="password" id="input" name="password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button class="cta-btn" type="submit">Modifier</button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Récupération des éléments du DOM
        const showFormBtnUser = document.querySelector('#show-form-gerer-user');
        const formUser = document.querySelector('#my-form-gerer-user');

        const showFormBtnProduit = document.querySelector('#show-form-gerer-produit');
        const formProduit = document.querySelector('#my-form-gerer-produit');

        const showFormBtnComment = document.querySelector('#show-form-gerer-comment');
        const formComment = document.querySelector('#my-form-gerer-comment');

        const showFormBtnCommande = document.querySelector('#show-form-gerer-commande');
        const formCommande = document.querySelector('#my-form-gerer-commande');

        /*
        // EDITER UTILISATEUR
        const showFormUpdateUser = document.querySelector('#show-form-gerer-update-user');
        const formUpdateUser = document.querySelector('#my-form-edit-user');
*/
        // Ajout de l'événement de clic
        showFormBtnUser.addEventListener('click', () => {
            formUser.style.display = 'flex';
            // masquer les autres formulaires
            formProduit.style.display = 'none';
            formComment.style.display = 'none';
            formCommande.style.display = 'none';
        });

        // Ajout de l'événement de clic
        showFormBtnProduit.addEventListener('click', () => {
            formProduit.style.display = 'flex';
            // masquer les autres formulaires
            formUser.style.display = 'none';
            formComment.style.display = 'none';
            formCommande.style.display = 'none';
            formUpdateUser.style.display = 'none';
        });

        // Ajout de l'événement de clic
        showFormBtnComment.addEventListener('click', () => {
            formComment.style.display = 'flex';
            // masquer les autres formulaires
            formUser.style.display = 'none';
            formProduit.style.display = 'none';
            formCommande.style.display = 'none';
            formUpdateUser.style.display = 'none';

        });

        // Ajout de l'événement de clic
        showFormBtnCommande.addEventListener('click', () => {
            formCommande.style.display = 'flex';
            // masquer les autres formulaires
            formUser.style.display = 'none';
            formProduit.style.display = 'none';
            formComment.style.display = 'none';
            formUpdateUser.style.display = 'none';
        });

        // Ajout de l'événement de clic
        showFormUpdateUser.addEventListener('click', () => {
            formUser.style.display = 'flex';
            formUpdateUser.style.display = 'flex';
            // masquer les autres formulaires
            formProduit.style.display = 'none';
            formComment.style.display = 'none';
        });
    </script>
    @include('Include/footer')
</body>
</html>
