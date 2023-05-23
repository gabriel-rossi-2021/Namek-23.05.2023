<!doctype html>
<html lang="fr">
<head>
    @include('Include/header')
    <title>Namek - Admin</title>

    <!-- CSS HOME -->
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-signup.css') }}">
</head>
<body>
    <section>
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-5">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="/admin">Tableau de bord</a></li>
                            <li class="breadcrumb-item" aria-current="/gerer"><a href="/gerer">Gérer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Modifier utilisateur</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <form method="POST" action="{{ route('update_user_gerer', ['id' => $updateUser->id_users]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <table>
                            <h3>Modifier infos</h3>
                            <tr>
                                <td>
                                    <label for="titre"> <b>Titre</b></label><br>
                                    <select id="input" name="titre">
                                        <option value="Madame" {{ $updateUser->title == 'Madame' ? 'selected' : '' }}>Madame</option>
                                        <option value="Monsieur" {{ $updateUser->title == 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                                        <option value="Autres" {{ $updateUser->title == 'Autres' ? 'selected' : '' }}>Autres</option>
                                    </select>
                                </td>
                                <td>
                                    <label for="phone"> <b>Numéro téléphone</b></label><br>
                                    <input type="text" placeholder="Votre numéro" name="phone" id="input" value="{{ $updateUser->phone_number }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="name"> <b>Prénom</b></label><br>
                                    <input type="text" placeholder="Votre prénom" name="name" id="input" value="{{ $updateUser->first_name }}" required>
                                </td>
                                <td>
                                    <label for="lastName"> <b>Nom</b></label><br>
                                    <input type="text" placeholder="Votre nom" name="lastName" id="input" value="{{ $updateUser->last_name }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="username"> <b>Nom d'utilisateur</b></label><br>
                                    <input type="text" placeholder="Votre nom d'utilisateur" name="username" id="input" value="{{ $updateUser->username }}" required>
                                </td>
                                <td>
                                    <label for="email"> <b>Email</b></label><br>
                                    <input type="email" placeholder="Votre Email" name="email" id="input" value="{{ $updateUser->email }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="psw"><b>Mot de passe</b></label><br>
                                    <input type="password" placeholder="Votre mot de passe" name="psw" id="input" required>
                                </td>
                                <td>
                                    <label for="confirm-psw"><b>Confirmation</b></label><br>
                                    <input type="password" placeholder="Encore une fois" name="confirm-psw" id="input" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="birth"><b>Date de naissance</b></label><br>
                                    <input type="date" placeholder="Date de naissance" name="birth" id="input" value="{{ $updateUser->birth_date }}" required>
                                </td>
                            </tr>
                        </table>
                        <table>
                            <h3>Modifier infos complémentaires</h3>
                            <tr>
                                <td>
                                    <label for="rue"> <b>Rue</b></label><br>
                                    <input type="text" placeholder="Votre rue" name="rue" id="input" value="{{ $updateUser->address->street }}" required>
                                </td>
                                <td>
                                    <label for="num-rue"> <b>N° de rue</b></label><br>
                                    <input type="number" placeholder="Votre n° de rue" name="num-rue" id="input" value="{{ $updateUser->address->street_number }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="ville"> <b>Ville</b></label><br>
                                    <input type="text" placeholder="Votre ville" name="ville" id="input" value="{{ $updateUser->address->city }}" required>
                                </td>
                                <td>
                                    <label for="npa"> <b>NPA</b></label><br>
                                    <input type="number" placeholder="Votre NPA" name="npa" id="input" value="{{ $updateUser->address->NPA }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="pays"> <b>Pays</b></label><br>
                                    <input type="text" placeholder="Votre pays" name="pays" id="input" value="Suisse" disabled required>
                                </td>
                                <td>
                                    <label for="pays"> <b>IP</b></label><br>
                                    <input type="text" placeholder="Votre IP" name="pays" id="input" value="{{ $ip = request()->getClientIp() }}" disabled required>
                                </td>
                            </tr>
                        </table>
                        <button type="submit" class="cta-btn">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @include('Include/footer')
</body>
</html>
