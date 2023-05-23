<!doctype html>
<html lang="fr">
<head>
    @include('Include/header')
    <title>Namek - Accueil</title>

    <!-- CSS HOME -->
    <link rel="stylesheet" href="{{ asset('css/style-home.css') }}">
    <!-- FLUX RSS -->
    <link rel="alternate" href="{{ route('flux_rss') }}" type="application/rss+xml" title="channel">
</head>
<body>
<main>
    <!-- CAROUSEL DE DIAPO -->
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- DIAPO 1 -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="bd-placeholder-img img-welcome" width="100%" height="100%" src="{{ asset('img/home/welcome.png') }}" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></img>
                <div class="container">
                    <div class="carousel-caption" id="button-home" style="bottom: 6em">
                        <h1 style="color: white">Bienvenue à Namek</h1>
                        <p>Le paradis du CBD</p>
                        @if(auth()->check())
                            <a class="btn btn-lg btn-green" href="/dashboard">Mon compte</a>
                            @if(Auth::user()->function_id == 1)
                                <a id="a-admin" class="btn btn-lg btn-green" href="/admin">Administration</a>
                            @endif
                        @else
                            <p><a class="btn btn-lg btn-green" href="/login">Se connecter</a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ABOUT US -->
    <div class="wrapper">
        <h1>Qui sommes-nous</h1>
        <div class="quote">
            <span><strong>- Namek est une entreprise Suisse -</strong></span>
            <p></br>L'équipe Namek est jeune et dynamique. Nous travaillons chaque jour pour proposer à nos clients le meilleur rapport qualité-prix ! Nous sommes tous les jours à la recherche des meilleures produits de CBD.
                <br><br>
                Travailleurs et à l'écoute, notre service clients est disponible 6j/7. N'hésitez pas à nous contacter, nous serons ravis de pouvoir vous aider.
            </p>
        </div>
    </div>

    <!-- CATEGORIES -->
    <h1 style="text-align: center;margin-top: 5%">Catégories</h1>

    @yield('category')

    <!-- RSS FLUX -->
    <h1 style="text-align: center;">Dernières sorties</h1>

    @yield('rss')

</main>
@include('Include/footer')
</body>
</html>
