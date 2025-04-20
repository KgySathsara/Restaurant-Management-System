<?php

namespace Database\Seeders;

use App\Models\Concession;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ConcessionSeeder extends Seeder
{
    public function run(): void
    {
        $concessions = [
            [
                'name' => 'Burger',
                'description' => 'Delicious beef burger with cheese and vegetables',
                'price' => 8.99,
                'color' => [200, 120, 80],
            ],
            [
                'name' => 'Pizza',
                'description' => 'Classic margherita pizza with fresh mozzarella',
                'price' => 12.99,
                'color' => [255, 200, 150],
            ],
            [
                'name' => 'Salad',
                'description' => 'Fresh garden salad with vinaigrette dressing',
                'price' => 6.99,
                'color' => [100, 180, 100],
            ],
            [
                'name' => 'Pasta',
                'description' => 'Spaghetti with homemade tomato sauce',
                'price' => 10.99,
                'color' => [220, 160, 140],
            ],
            [
                'name' => 'Ice Cream',
                'description' => 'Vanilla ice cream with chocolate sauce',
                'price' => 4.99,
                'color' => [240, 240, 240],
            ],
        ];

        foreach ($concessions as $concession) {
            $imagePath = 'concessions/' . uniqid() . '.jpg';

            // Generate a colored placeholder image
            $image = imagecreatetruecolor(300, 300);
            $backgroundColor = imagecolorallocate(
                $image,
                $concession['color'][0],
                $concession['color'][1],
                $concession['color'][2]
            );
            imagefill($image, 0, 0, $backgroundColor);

            // Add text to the image
            $textColor = imagecolorallocate($image, 0, 0, 0);
            $text = $concession['name'];
            $font = 5;
            $textWidth = imagefontwidth($font) * strlen($text);
            $textHeight = imagefontheight($font);
            $x = (300 - $textWidth) / 2;
            $y = (300 - $textHeight) / 2;
            imagestring($image, $font, $x, $y, $text, $textColor);

            // Save the image
            ob_start();
            imagejpeg($image);
            $imageContent = ob_get_clean();
            Storage::disk('public')->put($imagePath, $imageContent);
            imagedestroy($image);

            Concession::create([
                'name' => $concession['name'],
                'description' => $concession['description'],
                'image' => $imagePath,
                'price' => $concession['price'],
            ]);
        }
    }
}
