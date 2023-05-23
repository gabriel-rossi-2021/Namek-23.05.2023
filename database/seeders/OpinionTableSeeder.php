<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opinions;

class OpinionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 4;
        $opinion->comment = "Au top, le goût le parfum y est, vraiment une bonne surprise.";
        $opinion->user_id = 1; // Admin
        $opinion->product_id = 1; // Lemon Haze
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 4;
        $opinion->comment = "Si vous cherchez une CBD qui a un bon goût d'agrume, c'est celle qui vous faut";
        $opinion->user_id = 1; // Admin
        $opinion->product_id = 2; // 24K
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 4;
        $opinion->comment = "Au top pour de la cbd je recommande fortement.";
        $opinion->user_id = 1; // Admin
        $opinion->product_id = 3; // Amnezia
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();


        /* USER 2 */

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 5;
        $opinion->comment = "Parfait !";
        $opinion->user_id = 2; // User 2
        $opinion->product_id = 1; // Lemon Haze
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 4;
        $opinion->comment = "Un très bon goût en bouche.";
        $opinion->user_id = 2; // User 2
        $opinion->product_id = 2; // 24K
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 3;
        $opinion->comment = "Très bonne, mais grosse branche";
        $opinion->user_id = 2; // User 2
        $opinion->product_id = 3; // Amnezia
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();

        /* USER 3 */

        // Créeation commentaire
        $opinion = new Opinions();
        $opinion->notation = 2;
        $opinion->comment = "Fumer tue ! mais super beau site :)";
        $opinion->user_id = 3; // User 3
        $opinion->product_id = 1; // Lemon Haze
        $opinion->created_at = Carbon::now();
        $opinion->updated_at = Carbon::now();
        $opinion->save();
    }
}
