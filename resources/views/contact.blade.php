<!doctype html>
<html lang="fr">
<head>
    @include('Include/header');
    <title>Namek - Contact</title>

    <!-- CSS CONTACT -->
    <link rel="stylesheet" href="{{ asset('css/style-contact.css') }}">
</head>
<body>
<!-- CHOIX 1 -->
<form method="POST" action="{{ route('contact.envoyer') }}">
    @csrf
    <div class="card">
        <h2 class="title">Contact</h2>
        <p class="subtitle">Avez-vous une question ?</p>
        <div class="contact-info">
            <ul class="ul-contact">
                <li class="li-contact"><div class="circle"><i class="fas fa-home"></i></div> Lausanne, Suisse</li>
                <li class="li-contact"><div class="circle"><i class="fas fa-phone"></i></div> +41 78 823 78 18</li>
                <li class="li-contact"><div class="circle"><i class="fas fa-envelope"></i></div>namekcbd@gmail.com</li>
            </ul>
            <ul class="ul-contact">

            </ul>
        </div>
        <p class="or"></p>
        <table>
            <tr>
                <td>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <label for="email"> <b>Email</b></label><br>
                    <input type="text" placeholder="Votre Email" name="email" id="input" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="text"><b>Sujet</b></label><br>
                    <input type="text" placeholder="Sujet" name="subject" id="input" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="text"><b>Message</b></label><br>
                    <textarea placeholder="Votre demande / question" id="input" name="message"></textarea>
                </td>
            </tr>
            <tr>
                <td>
                    @error('email')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    @error('subject')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    @error('message')
                        <div class="alert alert-danger">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </td>
            </tr>
        </table>
        <button class="cta-btn" type="submit">Envoyer</button>
    </div>
</form>
@include('Include/footer')
</body>
