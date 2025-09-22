<?php

namespace Database\Seeders;

use App\Models\Make;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MakeSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $luxuryMakes = [
            [
                'name' => 'Mercedes-Benz',
                'website_url' => 'https://www.mercedes-benz.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/90/Mercedes-Logo.svg',
                'display_order' => 1,
            ],
            [
                'name' => 'BMW',
                'website_url' => 'https://www.bmw.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/f/f4/BMW_logo_%28gray%29.svg',
                'display_order' => 2,
            ],
            [
                'name' => 'Audi',
                'website_url' => 'https://www.audi.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/Audi_logo_detail.svg/960px-Audi_logo_detail.svg.png?20230111204302',
                'display_order' => 3,
            ],
            [
                'name' => 'Porsche',
                'website_url' => 'https://www.porsche.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/de/thumb/7/70/Porsche_Logo.svg/500px-Porsche_Logo.svg.png?20250407095904',
                'display_order' => 4,
            ],
            [
                'name' => 'Ferrari',
                'website_url' => 'https://www.ferrari.com',
                'logo_url' => 'https://www.citypng.com/public/uploads/preview/hd-ferrari-logo-transparent-background-701751694773105xaxoflrdiu.png',
                'display_order' => 5,
            ],
            [
                'name' => 'Lamborghini',
                'website_url' => 'https://www.lamborghini.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/df/Lamborghini_Logo.svg/1068px-Lamborghini_Logo.svg.png',
                'display_order' => 6,
            ],
            [
                'name' => 'Bentley',
                'website_url' => 'https://www.bentleymotors.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/fr/thumb/1/12/Bentley-logo-svg-vector.svg/2560px-Bentley-logo-svg-vector.svg.png',
                'display_order' => 7,
            ],
            [
                'name' => 'Rolls-Royce',
                'website_url' => 'https://www.rolls-roycemotorcars.com',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/52/Rolls-Royce_Motor_Cars_logo.svg/500px-Rolls-Royce_Motor_Cars_logo.svg.png',
                'display_order' => 8,
            ],
            [
                'name' => 'Maserati',
                'website_url' => 'https://www.maserati.com',
                'logo_url' => 'https://logos-world.net/wp-content/uploads/2020/04/Maserati-Logo.png',
                'display_order' => 9,
            ],
            [
                'name' => 'Jaguar',
                'website_url' => 'https://www.jaguar.com',
                'logo_url' => 'https://logos-world.net/wp-content/uploads/2020/04/Jaguar-Logo.png',
                'display_order' => 10,
            ],
            [
                'name' => 'Land Rover',
                'website_url' => 'https://www.landrover.com',
                'logo_url' => 'https://logos-world.net/wp-content/uploads/2020/04/Land-Rover-Logo.png',
                'display_order' => 11,
            ],
            [
                'name' => 'Lexus',
                'website_url' => 'https://www.lexus.com',
                'logo_url' => 'https://logos-world.net/wp-content/uploads/2020/04/Lexus-Logo.png',
                'display_order' => 12,
            ],
        ];

        foreach ($luxuryMakes as $makeData) {
            // Create or update the make
            $make = Make::updateOrCreate(
                ['slug' => Str::slug($makeData['name'])],
                [
                    'name' => $makeData['name'],
                    'slug' => Str::slug($makeData['name']),
                    'website_url' => $makeData['website_url'],
                    'is_active' => true,
                    'display_order' => $makeData['display_order'],
                ]
            );

            // Add logo from URL using Spatie Media Library
            try {
                // Clear existing logos first
                $make->clearMediaCollection('logo');

                // Add new logo from URL
                $make->addMediaFromUrl($makeData['logo_url'])
                    ->toMediaCollection('logo');

                $this->command->info("✅ Added logo for {$makeData['name']}");
            } catch (\Exception $e) {
                $this->command->error("❌ Failed to add logo for {$makeData['name']}: " . $e->getMessage());
            }
        }

        $this->command->info("🎉 MakeSeeder completed successfully!");
    }
}
