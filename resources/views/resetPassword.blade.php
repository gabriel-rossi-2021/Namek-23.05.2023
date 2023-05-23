<!doctype html>
<html lang="fr">
<head>
    @include('Include/header');
    <title>Namek - Inscription</title>

    <!-- CSS SIGNUP -->
    <link rel="stylesheet" href="{{ asset('css/style-login.css') }}">
</head>
<body>
    <form method="POST" action="{{ route('send.email') }}">
        @csrf
        <div class="card">
            <h2 class="title">Mot de passe oublié</h2>
            <p style="margin-top:5%;text-align:justify">Saisissez l'adresse électronique associé à votre compte. Nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            <div class="email-login">
                <label for="email"><b>Votre email</b></label>
                <input type="email" placeholder="Entrer email" name="email" id="email" class="input" required>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button class="cta-btn" disabled>Envoyer le lien</button>
            <p style="color: red">*Ne fonctionne pas, pas de servie de messagerie</p>
        </div>
    </form>
@include('Include/footer')
</body>
