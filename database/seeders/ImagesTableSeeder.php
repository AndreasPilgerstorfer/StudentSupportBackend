<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createImage("JavaScript Logo",
            "https://upload.wikimedia.org/wikipedia/commons/9/99/Unofficial_JavaScript_logo_2.svg");

        $this->createImage("Maths Logo",
            "https://upload.wikimedia.org/wikipedia/commons/e/eb/Math.svg");

        $this->createImage("English Logo",
            "https://upload.wikimedia.org/wikipedia/commons/3/3a/English_Speech_balloon.png");

        $this->createImage("German Logo",
            "https://upload.wikimedia.org/wikipedia/commons/3/3d/Flag_of_germany_800_480.png");

        $this->createImage("JavaScript Logo Offer",
            "https://upload.wikimedia.org/wikipedia/commons/e/e8/Education%2C_Studying%2C_University%2C_Alumni_-_icon.png");

        $this->createImage("Andreas König",
            "https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1160&q=80");

        $this->createImage("Anna Djokovic",
            "https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1740&q=80");

        $this->createImage("Michael Muster",
            "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2574&q=80");

        $this->createImage("Jürgen Maier",
            "https://images.unsplash.com/photo-1527980965255-d3b416303d12?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1160&q=80");
    }

    //creates and saves a new image
    private function createImage(string $title, string $url) {
        $image = new Image();
        $image->title = $title;
        $image->url = $url;
        $image->save();
    }
}
