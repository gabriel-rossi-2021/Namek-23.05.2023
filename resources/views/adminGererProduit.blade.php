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
                            <li class="breadcrumb-item active" aria-current="page">Modifier produit</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <form method="POST" action="{{ route('update_produit_gerer', ['id' => $updateProduit->id_product]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <table>
                            <h3>Modifier - {{ $updateProduit->name_product  }}</h3>
                            <tr>
                                <td>
                                    <label for="name"> <b>Nom</b></label><br>
                                    <input type="text" name="name" id="input" value="{{ $updateProduit->name_product }}" required>
                                </td>
                                <td>
                                    <label for="description"> <b>Description</b></label><br>
                                    <textarea type="text" name="description" id="input" required>{{ $updateProduit->description }}</textarea>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="size"> <b>Taille [gr/ml]</b></label><br>
                                    <input type="number" name="size" id="input" value="{{ $updateProduit->size }}" required>
                                </td>
                                <td>
                                    <label for="thc"> <b>Taux THC</b></label><br>
                                    <input type="number"  name="thc" id="input" value="{{ $updateProduit->thc_rate }}" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="cbd"> <b>Taux CBD</b></label><br>
                                    <input type="number"  name="cbd" id="input" value="{{ $updateProduit->cbd_rate }}" required>
                                </td>
                                <td>
                                    <label for="culture"><b>Culture</b></label><br>
                                    <input type="text" name="culture" id="input" value="{{ $updateProduit->culture }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="prix"><b>Prix HT</b></label><br>
                                    <input type="number" name="prix" id="input" step="0.01" value="{{ $updateProduit->price_ht }}" required>
                                </td>
                                <td>
                                    <label for="stock"><b>En stock</b></label><br>
                                    <input type="number" name="stock" id="input" value="{{ $updateProduit->available }}" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="category"> <b>Category</b></label><br>
                                    <select id="input" name="category">
                                        <option value="1" {{ $updateProduit->category->name_category == 'Plantes CBD' ? 'selected' : '' }}>Plantes CBD</option>
                                        <option value="2" {{ $updateProduit->category->name_category == 'Huiles CBD' ? 'selected' : '' }}>Huiles CBD</option>
                                        <option value="3" {{ $updateProduit->category->name_category == 'Bonbons CBD' ? 'selected' : '' }}>Bonbons CBD</option>
                                    </select>
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

