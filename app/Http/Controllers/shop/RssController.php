<?php

namespace App\Http\Controllers\shop;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function index(){

        // Récupérer les derniers produits
        $products = Product::orderBy('created_at', 'desc')->take(3)->get();

        // Créer un objet SimpleXMLElement pour le flux RSS
        $rss = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
        $rss->addAttribute('version', '2.0');

        // Ajouter les éléments du flux RSS
        $channel = $rss->addChild('channel');
        $channel->addChild('title', 'Nouveaux Produits');
        $channel->addChild('link', url('/'));
        $channel->addChild('description', 'Les 10 derniers produits ajoutés');

        foreach ($products as $product) {
            $item = $channel->addChild('item');
            $item->addChild('title', $product->name_product);
            $item->addChild('link', url('/details/'.$product->id_product));
            $item->addChild('description', $product->description);
            $item->addChild('price_ht', $product->price_ht);
            $item->addChild('pubDate', $product->created_at->format('D, d M Y H:i:s O'));
        }

        // Retourner la réponse HTTP avec le contenu du flux RSS
        return Response::make($rss->asXML(), '200')->header('Content-Type', 'application/rss+xml');
    }
}
