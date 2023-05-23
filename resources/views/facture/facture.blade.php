<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Namek - Confirmation </title>
    <!-- Favicons -->
    <link rel="icon" href="{{asset('img/favicon.png')}}" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/style-print.css') }}" type="text/css" media="print">
    <style>
        .container{
            border: 3px solid #499b4a;
            width: 90%;
            margin:auto;
            padding:20px; /* ajout de l'espace intérieur */
        }
        .invoice-container {
            margin: 0 auto; /* centrage de la facture */
        }
        #information{
            width:100%;
            height:auto;
            text-align:center;
        }
        #information tbody{
            background:#ffff;
            padding:20px;
        }
        #produit-table{
            width:100%;
            height:auto;
            background-color:#fff;
            text-align:center;
            padding:10px;
            background:#fafafa
        }
        #produit-table th{
            color:#6c757d;
            font-size: 20px;
        }
        #produit-table td{
            background-color:#fff;
            font-size:12px;
            color:#262626;
        }
        #table-info-produit{
            width:100%;
            height:auto;
            background-color:#fff;
            margin-top:0px;
            padding:20px;
            font-size:12px;
            border: 1px solid #ebebeb;
            border-top:0px;
        }
        #table-info-produit tr{
            font-weight: bold;
            padding: 5px;
            text-align:center
        }
        #table-info-prix{
            width:100%;
            height:auto;
            background-color:#fff;
            padding:20px;
            font-size:12px;
            border: 1px solid #ebebeb;
            border-top:0
        }

    </style>
</head>
<body>
<div class="container">
    <div class="invoice-container" ref="document" id="html">
        <table id="information"BORDER=0 CELLSPACING=0>
            <tbody>
                <tr>
                    <td colspan="4" style="padding:20px 0px 0px 20px;text-align:left;font-size: 20px; font-weight: bold;color:#000;">Bonjour <span style="color:#499b4a;">{{ $user->first_name }} {{ $user->last_name }}</span></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center;padding:10px 10px 10px 20px;font-size:25px;font-weight: bold;color:#499b4a">Confirmation de paiement</td>
                </tr>
            </tbody>
        </table>
        <table id="produit-table">
            <tbody>
            <tr>
                <th style="border-right:1.5px dashed  #DCDCDC; width:25%;font-size:16px;font-weight:700;padding: 0px 0px 10px 0px;">Date de commande</th>
                <th style="border-right: 1.5px dashed  #DCDCDC ;width:25%;font-size:16px;font-weight:700;padding: 0px 0px 10px 0px;">N° de commande</th>
                <th style="border-right:1.5px dashed  #DCDCDC ;width:25%;font-size:16px;font-weight:700;padding: 0px 0px 10px 0px;">Paiement</th>
                <th style="width:25%;font-size:16px;font-weight:700;padding: 0px 0px 10px 0px;">Adresse de livraison</th>
            </tr>
            <tr>
                <td style="border-right:1.5px dashed  #DCDCDC ;width:25%; font-weight:bold;background: #fafafa;">{{ $date_achat }}</td>
                <td style="border-right:1.5px dashed  #DCDCDC ;width:25% ; font-weight:bold;background: #fafafa;">{{ $order_number }}</td>
                <td style="border-right:1.5px dashed  #DCDCDC ;width:25%; font-weight:bold;background: #fafafa;">Carte de crédit</td>
                <td style="width:25%; font-weight:bold;background: #fafafa;">Suisse, {{ $user->address->city }}</td>
            </tr>
            </tbody>
        </table>
        <table id="table-info-produit">
            <thead>
            <tr>
                <td colspan="2" style="text-align: left;">INFORMATIONS PRODUITS</td>
            </tr>
            <tr style="">
                <td>NOM PRODUIT</td>
                <td >QUANTITE</td>
                <td>PRIX HT</td>
                <td>PRIX TTC</td>
            </tr>
            </thead>
            <tbody>
            @foreach($content as $produit)
                <tr>
                    <td style="width:20%;margin-left:10px;text-align: center;">{{$produit->name}}</td>
                    <td style="width:20%;padding: 10px; text-align:center;">{{$produit->quantity}}</td>
                    <td style="width:20%;padding: 10px;text-align: center;">{{ number_format(($price_ht[$loop->index] * (1 + 0.077)) / $produit->quantity, 2) }}</td>
                    <td style="width:30%; ;font-weight: bold;font-size: 16px;">
                        <table style="width:100%;">
                            <tr><td style="text-align:center;font-size:12px;font-weight:600;">{{ number_format($produit->attributes['prix_ttc'], 2) }} CHF</td></tr>
                        </table>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <table id="table-info-prix">
            <tbody>
            <tr>
                <td style="font-weight: bold;padding:5px 0px">TOTAL HT</td>
                <td style="text-align:right;padding:5px 0px;font-size:16px;">{{number_format($total_ht_panier, 2)}} CHF</td>
            </tr>
            <tr>
                <td style="font-weight: bold;padding:5px 0px">FRAIS TVA (7.7%)</td>
                <td style="text-align:right;padding:5px 0px;font-size:16px;">{{number_format($tva, 2)}} CHF</td>
            </tr>
            <tr style="padding:20px;color:#000;font-size:15px">
                <td style="font-weight: bold;padding:5px 0px">TOTAL TTC</td>
                <td style="text-align:right;padding:5px 0px;font-weight: bold;font-size:16px;">{{number_format($total_ttc_panier, 2)}} CHF</td>
            </tr>
            </tbody>
            <tfoot style="padding-top:5px;font-weight: bold;">
            <tr>
                <td style="padding-top:10px;"><span style="color:#499b4a;font-weight: bold">MERCI</span> pour votre confiance !</td>
            </tr>
            <tr>
                <td style="padding-top:10px;">Besoin d'aide ? Contactez-nous <span style="color:#499b4a">info@namek.com</span></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
</body>
</html>
