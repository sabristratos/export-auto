<?php

namespace Database\Seeders;

use App\Enums\AttributeType;
use App\Enums\CarStatus;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Enums\ReviewStatus;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Car;
use App\Models\CarAttribute;
use App\Models\CarModel;
use App\Models\Lead;
use App\Models\Make;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    protected array $carPhotoUrls = [
        'https://images.unsplash.com/photo-1580273916550-e323be2ae537?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1662134632184-383a3432e6a3?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1622942904360-b00e03c4c521?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        'https://images.unsplash.com/photo-1486326658981-ed68abe5868e?q=80&w=735&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    ];

    public function run(): void
    {
        $this->seedMakes();
        $this->seedCarModels();
        $this->seedAttributes();
        $this->seedCars();
        $this->seedReviews();
        $this->seedLeads();
    }

    private function seedMakes(): void
    {
        $makes = [
            ['name' => 'Mercedes-Benz', 'website_url' => 'https://www.mercedes-benz.com'],
            ['name' => 'BMW', 'website_url' => 'https://www.bmw.com'],
            ['name' => 'Audi', 'website_url' => 'https://www.audi.com'],
            ['name' => 'Volkswagen', 'website_url' => 'https://www.volkswagen.com'],
            ['name' => 'Porsche', 'website_url' => 'https://www.porsche.com'],
            ['name' => 'Toyota', 'website_url' => 'https://www.toyota.com'],
            ['name' => 'Honda', 'website_url' => 'https://www.honda.com'],
            ['name' => 'Nissan', 'website_url' => 'https://www.nissan-global.com'],
            ['name' => 'Ford', 'website_url' => 'https://www.ford.com'],
            ['name' => 'Chevrolet', 'website_url' => 'https://www.chevrolet.com'],
        ];

        foreach ($makes as $index => $makeData) {
            Make::create([
                'name' => $makeData['name'],
                'slug' => Str::slug($makeData['name']),
                'website_url' => $makeData['website_url'],
                'is_active' => true,
                'display_order' => $index + 1,
            ]);
        }
    }

    private function seedCarModels(): void
    {
        $models = [
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE', 'AMG GT'],
            'BMW' => ['3 Series', '5 Series', '7 Series', 'X3', 'X5', 'M3', 'M5'],
            'Audi' => ['A3', 'A4', 'A6', 'A8', 'Q3', 'Q5', 'Q7', 'R8'],
            'Volkswagen' => ['Golf', 'Passat', 'Tiguan', 'Touareg', 'Arteon'],
            'Porsche' => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan'],
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Prius', 'Land Cruiser'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'HR-V'],
            'Nissan' => ['Altima', 'Sentra', 'Rogue', 'Murano', 'Pathfinder', 'GT-R'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape', 'Edge'],
            'Chevrolet' => ['Silverado', 'Camaro', 'Equinox', 'Tahoe', 'Corvette'],
        ];

        foreach ($models as $makeName => $modelNames) {
            $make = Make::where('name', $makeName)->first();

            foreach ($modelNames as $modelName) {
                CarModel::create([
                    'make_id' => $make->id,
                    'name' => $modelName,
                    'slug' => Str::slug($modelName),
                    'is_active' => true,
                ]);
            }
        }
    }

    private function seedAttributes(): void
    {
        $attributes = [
            [
                'name' => ['en' => 'Year', 'ar' => 'سنة الصنع'],
                'slug' => 'year',
                'type' => AttributeType::Number,
                'unit' => null,
                'is_required' => true,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'basic',
                'display_order' => 1,
                'description' => ['en' => 'Manufacturing year of the vehicle', 'ar' => 'سنة صنع المركبة'],
            ],
            [
                'name' => ['en' => 'Mileage', 'ar' => 'المسافة المقطوعة'],
                'slug' => 'mileage',
                'type' => AttributeType::Number,
                'unit' => 'km',
                'is_required' => true,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'basic',
                'display_order' => 2,
                'description' => ['en' => 'Total distance traveled by the vehicle', 'ar' => 'إجمالي المسافة التي قطعتها المركبة'],
            ],
            [
                'name' => ['en' => 'Fuel Type', 'ar' => 'نوع الوقود'],
                'slug' => 'fuel_type',
                'type' => AttributeType::Select,
                'unit' => null,
                'is_required' => true,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'engine',
                'display_order' => 3,
                'description' => ['en' => 'Type of fuel used by the vehicle', 'ar' => 'نوع الوقود المستخدم في المركبة'],
            ],
            [
                'name' => ['en' => 'Transmission', 'ar' => 'ناقل الحركة'],
                'slug' => 'transmission',
                'type' => AttributeType::Select,
                'unit' => null,
                'is_required' => true,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'engine',
                'display_order' => 4,
                'description' => ['en' => 'Type of transmission system', 'ar' => 'نوع نظام ناقل الحركة'],
            ],
            [
                'name' => ['en' => 'Engine Power', 'ar' => 'قوة المحرك'],
                'slug' => 'engine_power',
                'type' => AttributeType::Number,
                'unit' => 'HP',
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'engine',
                'display_order' => 5,
                'description' => ['en' => 'Engine power in horsepower', 'ar' => 'قوة المحرك بالحصان'],
            ],
            [
                'name' => ['en' => 'Color', 'ar' => 'اللون'],
                'slug' => 'color',
                'type' => AttributeType::Select,
                'unit' => null,
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'exterior',
                'display_order' => 6,
                'description' => ['en' => 'Exterior color of the vehicle', 'ar' => 'لون المركبة الخارجي'],
            ],
            [
                'name' => ['en' => 'Number of Doors', 'ar' => 'عدد الأبواب'],
                'slug' => 'doors',
                'type' => AttributeType::Select,
                'unit' => null,
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'basic',
                'display_order' => 7,
                'description' => ['en' => 'Number of doors', 'ar' => 'عدد الأبواب'],
            ],
            [
                'name' => ['en' => 'Air Conditioning', 'ar' => 'تكييف الهواء'],
                'slug' => 'air_conditioning',
                'type' => AttributeType::Boolean,
                'unit' => null,
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'comfort',
                'display_order' => 8,
                'description' => ['en' => 'Air conditioning system available', 'ar' => 'نظام تكييف الهواء متوفر'],
            ],
            [
                'name' => ['en' => 'Navigation System', 'ar' => 'نظام الملاحة'],
                'slug' => 'navigation',
                'type' => AttributeType::Boolean,
                'unit' => null,
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'technology',
                'display_order' => 9,
                'description' => ['en' => 'Built-in navigation system', 'ar' => 'نظام ملاحة مدمج'],
            ],
            [
                'name' => ['en' => 'Leather Seats', 'ar' => 'مقاعد جلدية'],
                'slug' => 'leather_seats',
                'type' => AttributeType::Boolean,
                'unit' => null,
                'is_required' => false,
                'is_filterable' => true,
                'is_searchable' => false,
                'group' => 'comfort',
                'display_order' => 10,
                'description' => ['en' => 'Leather seat upholstery', 'ar' => 'تنجيد المقاعد الجلدية'],
            ],
        ];

        foreach ($attributes as $attributeData) {
            Attribute::create($attributeData);
        }

        $this->seedAttributeValues();
    }

    private function seedAttributeValues(): void
    {
        $attributeValues = [
            'fuel_type' => [
                'Gasoline' => ['en' => 'Gasoline', 'ar' => 'بنزين'],
                'Diesel' => ['en' => 'Diesel', 'ar' => 'ديزل'],
                'Electric' => ['en' => 'Electric', 'ar' => 'كهربائي'],
                'Hybrid' => ['en' => 'Hybrid', 'ar' => 'هجين'],
                'Plug-in Hybrid' => ['en' => 'Plug-in Hybrid', 'ar' => 'هجين قابل للشحن'],
            ],
            'transmission' => [
                'Manual' => ['en' => 'Manual', 'ar' => 'يدوي'],
                'Automatic' => ['en' => 'Automatic', 'ar' => 'أوتوماتيكي'],
                'CVT' => ['en' => 'CVT', 'ar' => 'CVT'],
            ],
            'color' => [
                'Black' => ['en' => 'Black', 'ar' => 'أسود'],
                'White' => ['en' => 'White', 'ar' => 'أبيض'],
                'Silver' => ['en' => 'Silver', 'ar' => 'فضي'],
                'Gray' => ['en' => 'Gray', 'ar' => 'رمادي'],
                'Blue' => ['en' => 'Blue', 'ar' => 'أزرق'],
                'Red' => ['en' => 'Red', 'ar' => 'أحمر'],
                'Green' => ['en' => 'Green', 'ar' => 'أخضر'],
                'Brown' => ['en' => 'Brown', 'ar' => 'بني'],
            ],
            'doors' => [
                '2' => ['en' => '2 Doors', 'ar' => 'باباين'],
                '3' => ['en' => '3 Doors', 'ar' => '3 أبواب'],
                '4' => ['en' => '4 Doors', 'ar' => '4 أبواب'],
                '5' => ['en' => '5 Doors', 'ar' => '5 أبواب'],
            ],
        ];

        foreach ($attributeValues as $attributeSlug => $values) {
            $attribute = Attribute::where('slug', $attributeSlug)->first();

            if ($attribute) {
                foreach ($values as $valueKey => $translations) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value' => $translations,
                        'display_order' => array_search($valueKey, array_keys($values)) + 1,
                    ]);
                }
            }
        }
    }

    private function seedCars(): void
    {
        $carData = [
            [
                'make' => 'Mercedes-Benz',
                'model' => 'C-Class',
                'status' => CarStatus::Published,
                'price' => 45000,
                'featured' => true,
                'description' => ['en' => 'Luxury sedan with excellent performance and comfort features.', 'ar' => 'سيدان فاخرة مع أداء ممتاز وميزات راحة استثنائية.'],
                'attributes' => [
                    'year' => 2021,
                    'mileage' => 25000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Automatic',
                    'engine_power' => 255,
                    'color' => 'Black',
                    'doors' => '4',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => true,
                ],
            ],
            [
                'make' => 'BMW',
                'model' => '3 Series',
                'status' => CarStatus::Published,
                'price' => 42000,
                'featured' => true,
                'description' => ['en' => 'Sport sedan with dynamic driving experience and premium interior.', 'ar' => 'سيدان رياضية مع تجربة قيادة ديناميكية وداخلية فاخرة.'],
                'attributes' => [
                    'year' => 2020,
                    'mileage' => 35000,
                    'fuel_type' => 'Diesel',
                    'transmission' => 'Automatic',
                    'engine_power' => 190,
                    'color' => 'White',
                    'doors' => '4',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => false,
                ],
            ],
            [
                'make' => 'Audi',
                'model' => 'A4',
                'status' => CarStatus::Published,
                'price' => 38000,
                'featured' => false,
                'description' => ['en' => 'Elegant sedan with advanced technology and refined design.', 'ar' => 'سيدان أنيقة مع تقنية متطورة وتصميم راقي.'],
                'attributes' => [
                    'year' => 2019,
                    'mileage' => 45000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Manual',
                    'engine_power' => 150,
                    'color' => 'Silver',
                    'doors' => '4',
                    'air_conditioning' => true,
                    'navigation' => false,
                    'leather_seats' => true,
                ],
            ],
            [
                'make' => 'Volkswagen',
                'model' => 'Golf',
                'status' => CarStatus::Published,
                'price' => 28000,
                'featured' => false,
                'description' => ['en' => 'Compact hatchback with reliable performance and practical design.', 'ar' => 'هاتشباك مدمجة مع أداء موثوق وتصميم عملي.'],
                'attributes' => [
                    'year' => 2020,
                    'mileage' => 30000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Manual',
                    'engine_power' => 110,
                    'color' => 'Blue',
                    'doors' => '5',
                    'air_conditioning' => true,
                    'navigation' => false,
                    'leather_seats' => false,
                ],
            ],
            [
                'make' => 'Porsche',
                'model' => '911',
                'status' => CarStatus::Published,
                'price' => 95000,
                'featured' => true,
                'description' => ['en' => 'Iconic sports car with exceptional performance and timeless design.', 'ar' => 'سيارة رياضية أسطورية مع أداء استثنائي وتصميم خالد.'],
                'attributes' => [
                    'year' => 2022,
                    'mileage' => 15000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Automatic',
                    'engine_power' => 379,
                    'color' => 'Red',
                    'doors' => '2',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => true,
                ],
            ],
            [
                'make' => 'Toyota',
                'model' => 'Camry',
                'status' => CarStatus::Published,
                'price' => 32000,
                'featured' => false,
                'description' => ['en' => 'Reliable family sedan with excellent fuel economy and spacious interior.', 'ar' => 'سيدان عائلية موثوقة مع اقتصاد ممتاز في الوقود وداخلية واسعة.'],
                'attributes' => [
                    'year' => 2021,
                    'mileage' => 20000,
                    'fuel_type' => 'Hybrid',
                    'transmission' => 'CVT',
                    'engine_power' => 208,
                    'color' => 'Gray',
                    'doors' => '4',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => false,
                ],
            ],
            [
                'make' => 'Honda',
                'model' => 'CR-V',
                'status' => CarStatus::Published,
                'price' => 35000,
                'featured' => false,
                'description' => ['en' => 'Versatile SUV with practical features and comfortable ride quality.', 'ar' => 'سيارة دفع رباعي متعددة الاستخدامات مع ميزات عملية وجودة ركوب مريحة.'],
                'attributes' => [
                    'year' => 2020,
                    'mileage' => 28000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'CVT',
                    'engine_power' => 190,
                    'color' => 'Green',
                    'doors' => '5',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => false,
                ],
            ],
            [
                'make' => 'Ford',
                'model' => 'Mustang',
                'status' => CarStatus::Published,
                'price' => 55000,
                'featured' => true,
                'description' => ['en' => 'American muscle car with powerful V8 engine and classic styling.', 'ar' => 'سيارة عضلية أمريكية مع محرك V8 قوي وتصميم كلاسيكي.'],
                'attributes' => [
                    'year' => 2021,
                    'mileage' => 18000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Automatic',
                    'engine_power' => 450,
                    'color' => 'Red',
                    'doors' => '2',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => true,
                ],
            ],
            [
                'make' => 'BMW',
                'model' => 'X5',
                'status' => CarStatus::Draft,
                'price' => 68000,
                'featured' => false,
                'description' => ['en' => 'Premium SUV with exceptional comfort and advanced safety features.', 'ar' => 'سيارة دفع رباعي فاخرة مع راحة استثنائية وميزات أمان متطورة.'],
                'attributes' => [
                    'year' => 2022,
                    'mileage' => 12000,
                    'fuel_type' => 'Diesel',
                    'transmission' => 'Automatic',
                    'engine_power' => 265,
                    'color' => 'Black',
                    'doors' => '5',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => true,
                ],
            ],
            [
                'make' => 'Nissan',
                'model' => 'GT-R',
                'status' => CarStatus::Sold,
                'price' => 115000,
                'featured' => false,
                'description' => ['en' => 'High-performance sports car with all-wheel drive and cutting-edge technology.', 'ar' => 'سيارة رياضية عالية الأداء مع دفع رباعي وتقنية حديثة.'],
                'attributes' => [
                    'year' => 2020,
                    'mileage' => 8000,
                    'fuel_type' => 'Gasoline',
                    'transmission' => 'Automatic',
                    'engine_power' => 565,
                    'color' => 'Silver',
                    'doors' => '2',
                    'air_conditioning' => true,
                    'navigation' => true,
                    'leather_seats' => true,
                ],
            ],
        ];

        foreach ($carData as $data) {
            $make = Make::where('name', $data['make'])->first();
            $model = CarModel::where('name', $data['model'])->where('make_id', $make->id)->first();

            $car = Car::create([
                'make_id' => $make->id,
                'model_id' => $model->id,
                'slug' => Str::slug($make->name . '-' . $model->name . '-' . $data['attributes']['year']),
                'status' => $data['status'],
                'price' => $data['price'],
                'currency' => 'EUR',
                'featured' => $data['featured'],
                'description' => $data['description'],
            ]);

            foreach ($data['attributes'] as $attributeSlug => $value) {
                $attribute = Attribute::where('slug', $attributeSlug)->first();

                if ($attribute) {
                    if ($attribute->type === AttributeType::Select) {
                        $attributeValue = AttributeValue::where('attribute_id', $attribute->id)
                            ->whereJsonContains('value->en', $value)
                            ->first();

                        if ($attributeValue) {
                            CarAttribute::create([
                                'car_id' => $car->id,
                                'attribute_id' => $attribute->id,
                                'attribute_value_id' => $attributeValue->id,
                                'value' => $value,
                            ]);
                        }
                    } else {
                        CarAttribute::create([
                            'car_id' => $car->id,
                            'attribute_id' => $attribute->id,
                            'value' => $value,
                        ]);
                    }
                }
            }

            // Attach a random car photo
            $this->attachCarPhoto($car);
        }
    }

    private function attachCarPhoto($car): void
    {
        try {
            // Load the car with its relationships
            $car = $car->load(['make', 'model']);

            // Get a random photo URL from the array
            $photoUrl = $this->carPhotoUrls[array_rand($this->carPhotoUrls)];

            // Clear existing photos first
            $car->clearMediaCollection('photos');

            // Add photo from URL using Spatie Media Library
            $car->addMediaFromUrl($photoUrl)
                ->usingName($car->make->name . ' ' . $car->model->name)
                ->toMediaCollection('photos');

            echo "✓ Added photo to {$car->make->name} {$car->model->name}\n";
        } catch (\Exception $e) {
            echo "✗ Failed to add photo to {$car->make->name} {$car->model->name}: {$e->getMessage()}\n";
        }
    }

    private function seedReviews(): void
    {
        $reviews = [
            [
                'customer_name' => 'Michael Schmidt',
                'customer_location' => 'Berlin, Germany',
                'content' => [
                    'en' => 'Excellent service and beautiful car! The Mercedes C-Class exceeded all my expectations. Professional handling throughout the entire process.',
                    'ar' => 'خدمة ممتازة وسيارة جميلة! مرسيدس C-Class فاقت كل توقعاتي. تعامل احترافي طوال العملية بأكملها.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Mercedes-Benz',
                'car_model' => 'C-Class',
            ],
            [
                'customer_name' => 'Sarah Müller',
                'customer_location' => 'Munich, Germany',
                'content' => [
                    'en' => 'Very satisfied with my BMW 3 Series purchase. Great value for money and the car arrived in perfect condition.',
                    'ar' => 'راضٍ جداً عن شراء BMW 3 Series. قيمة ممتازة مقابل المال والسيارة وصلت في حالة مثالية.'
                ],
                'rating' => 4,
                'status' => ReviewStatus::Approved,
                'car_make' => 'BMW',
                'car_model' => '3 Series',
            ],
            [
                'customer_name' => 'Thomas Weber',
                'customer_location' => 'Hamburg, Germany',
                'content' => [
                    'en' => 'The Audi A4 is exactly what I was looking for. Smooth transaction and reliable communication throughout.',
                    'ar' => 'أودي A4 هي بالضبط ما كنت أبحث عنه. معاملة سلسة وتواصل موثوق طوال الوقت.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Audi',
                'car_model' => 'A4',
            ],
            [
                'customer_name' => 'Anna Hoffmann',
                'customer_location' => 'Frankfurt, Germany',
                'content' => [
                    'en' => 'Outstanding experience buying the Volkswagen Golf. Fast delivery and excellent customer service.',
                    'de' => 'Hervorragende Erfahrung beim Kauf des Volkswagen Golf. Schnelle Lieferung und ausgezeichneter Kundenservice.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Volkswagen',
                'car_model' => 'Golf',
            ],
            [
                'customer_name' => 'Robert Klein',
                'customer_location' => 'Cologne, Germany',
                'content' => [
                    'en' => 'The Porsche 911 is a dream come true! Exceptional condition and performance. Highly recommend this dealer.',
                    'ar' => 'بورش 911 هي حلم يتحقق! حالة وأداء استثنائيان. أنصح بشدة بهذا التاجر.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Porsche',
                'car_model' => '911',
            ],
            [
                'customer_name' => 'Julia Fischer',
                'customer_location' => 'Stuttgart, Germany',
                'content' => [
                    'en' => 'Great experience with the Toyota Camry. Fuel efficient and reliable, perfect for daily commuting.',
                    'de' => 'Tolle Erfahrung mit dem Toyota Camry. Kraftstoffsparend und zuverlässig, perfekt für das tägliche Pendeln.'
                ],
                'rating' => 4,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Toyota',
                'car_model' => 'Camry',
            ],
            [
                'customer_name' => 'David Richter',
                'customer_location' => 'Düsseldorf, Germany',
                'content' => [
                    'en' => 'The Honda CR-V is perfect for my family needs. Spacious, comfortable, and well-maintained.',
                    'de' => 'Der Honda CR-V ist perfekt für meine Familienbedürfnisse. Geräumig, komfortabel und gut gepflegt.'
                ],
                'rating' => 4,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Honda',
                'car_model' => 'CR-V',
            ],
            [
                'customer_name' => 'Lisa Wagner',
                'customer_location' => 'Nuremberg, Germany',
                'content' => [
                    'en' => 'Amazing Ford Mustang! The sound of the V8 engine is incredible. Professional service from start to finish.',
                    'ar' => 'فورد موستنغ مذهلة! صوت محرك V8 لا يصدق. خدمة احترافية من البداية إلى النهاية.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Ford',
                'car_model' => 'Mustang',
            ],
            [
                'customer_name' => 'Martin Becker',
                'customer_location' => 'Leipzig, Germany',
                'content' => [
                    'en' => 'Good service overall, but delivery took longer than expected. The car quality is excellent though.',
                    'de' => 'Insgesamt guter Service, aber die Lieferung dauerte länger als erwartet. Die Autoqualität ist jedoch ausgezeichnet.'
                ],
                'rating' => 3,
                'status' => ReviewStatus::Pending,
                'car_make' => 'BMW',
                'car_model' => 'X5',
            ],
            [
                'customer_name' => 'Christina Lange',
                'customer_location' => 'Dresden, Germany',
                'content' => [
                    'en' => 'The Nissan GT-R is an absolute beast! Incredible acceleration and handling. Worth every penny.',
                    'ar' => 'نيسان GT-R وحش حقيقي! تسارع ومناورة لا تصدق. تستحق كل قرش.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Nissan',
                'car_model' => 'GT-R',
            ],
            [
                'customer_name' => 'Ahmed Al-Rashid',
                'customer_location' => 'Dubai, UAE',
                'content' => [
                    'en' => 'Outstanding service for international customers. The car export process was smooth and efficient.',
                    'ar' => 'خدمة ممتازة للعملاء الدوليين. عملية تصدير السيارة كانت سلسة وفعالة.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Mercedes-Benz',
                'car_model' => 'S-Class',
            ],
            [
                'customer_name' => 'Fatima Al-Zahra',
                'customer_location' => 'Riyadh, Saudi Arabia',
                'content' => [
                    'en' => 'Perfect BMW for my needs. Fast shipping to Saudi Arabia and excellent condition upon arrival.',
                    'ar' => 'بي إم دبليو مثالية لاحتياجاتي. شحن سريع إلى السعودية وحالة ممتازة عند الوصول.'
                ],
                'rating' => 4,
                'status' => ReviewStatus::Approved,
                'car_make' => 'BMW',
                'car_model' => '5 Series',
            ],
            [
                'customer_name' => 'Omar Khalil',
                'customer_location' => 'Doha, Qatar',
                'content' => [
                    'en' => 'Great experience with the Audi Q7. Professional team and transparent pricing.',
                    'ar' => 'تجربة رائعة مع أودي Q7. فريق محترف وتسعير شفاف.'
                ],
                'rating' => 5,
                'status' => ReviewStatus::Approved,
                'car_make' => 'Audi',
                'car_model' => 'Q7',
            ],
        ];

        foreach ($reviews as $reviewData) {
            $make = Make::where('name', $reviewData['car_make'])->first();
            $model = CarModel::where('name', $reviewData['car_model'])->where('make_id', $make->id)->first();
            $car = Car::where('make_id', $make->id)->where('model_id', $model->id)->first();

            if ($car) {
                Review::create([
                    'customer_name' => $reviewData['customer_name'],
                    'customer_location' => $reviewData['customer_location'],
                    'content' => $reviewData['content'],
                    'rating' => $reviewData['rating'],
                    'status' => $reviewData['status'],
                    'car_id' => $car->id,
                ]);
            }
        }
    }

    private function seedLeads(): void
    {
        $leads = [
            [
                'name' => 'Andreas Schneider',
                'email' => 'andreas.schneider@email.com',
                'phone' => '+49 30 12345678',
                'message' => 'I am interested in the Mercedes C-Class. Can you provide more information about the warranty and maintenance history?',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::New,
                'source' => 'Website Contact Form',
                'car_make' => 'Mercedes-Benz',
                'car_model' => 'C-Class',
            ],
            [
                'name' => 'Petra Zimmermann',
                'email' => 'petra.zimmermann@email.com',
                'phone' => '+49 89 87654321',
                'message' => 'Hello, I would like to schedule a test drive for the BMW 3 Series. What times are available this week?',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::Contacted,
                'source' => 'Phone Call',
                'car_make' => 'BMW',
                'car_model' => '3 Series',
            ],
            [
                'name' => 'Klaus Meier',
                'email' => 'klaus.meier@email.com',
                'phone' => '+49 40 55443322',
                'message' => 'Do you have any financing options available? I am interested in purchasing the Audi A4.',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::New,
                'source' => 'Website Contact Form',
                'car_make' => 'Audi',
                'car_model' => 'A4',
            ],
            [
                'name' => 'Sabine Koch',
                'email' => 'sabine.koch@email.com',
                'phone' => '+49 221 99887766',
                'message' => 'I am looking for a reliable family car. Can you tell me more about the Toyota Camry hybrid system?',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::New,
                'source' => 'Social Media',
                'car_make' => 'Toyota',
                'car_model' => 'Camry',
            ],
            [
                'name' => 'Frank Krüger',
                'email' => 'frank.krueger@email.com',
                'phone' => '+49 69 11223344',
                'message' => 'Is the Porsche 911 still available? I am very interested and can make a quick decision.',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::Converted,
                'source' => 'Referral',
                'car_make' => 'Porsche',
                'car_model' => '911',
            ],
            [
                'name' => 'Inge Schulz',
                'email' => 'inge.schulz@email.com',
                'phone' => '+49 711 66778899',
                'message' => 'What is your trade-in policy? I have a 2015 Volkswagen Passat that I would like to trade for the Golf.',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::Contacted,
                'source' => 'Website Contact Form',
                'car_make' => 'Volkswagen',
                'car_model' => 'Golf',
            ],
            [
                'name' => 'Ralf Braun',
                'email' => 'ralf.braun@email.com',
                'phone' => '+49 911 44556677',
                'message' => 'I need a vehicle for business purposes. Does the Honda CR-V come with any commercial warranties?',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::New,
                'source' => 'Google Ads',
                'car_make' => 'Honda',
                'car_model' => 'CR-V',
            ],
            [
                'name' => 'Monika Wolf',
                'email' => 'monika.wolf@email.com',
                'phone' => '+49 341 33221100',
                'message' => 'The Ford Mustang looks amazing! Can you provide the VIN number and a detailed inspection report?',
                'type' => LeadType::CarInquiry,
                'status' => LeadStatus::Contacted,
                'source' => 'Website Contact Form',
                'car_make' => 'Ford',
                'car_model' => 'Mustang',
            ],
            [
                'name' => 'Stefan Herrmann',
                'email' => 'stefan.herrmann@email.com',
                'phone' => '+49 351 77889900',
                'message' => 'Do you offer international shipping? I am interested in several vehicles and located in Austria.',
                'type' => LeadType::General,
                'status' => LeadStatus::New,
                'source' => 'Website Contact Form',
            ],
            [
                'name' => 'Gabriele Fuchs',
                'email' => 'gabriele.fuchs@email.com',
                'phone' => '+49 30 88776655',
                'message' => 'What are your business hours? I would like to visit your showroom to see the available inventory.',
                'type' => LeadType::General,
                'status' => LeadStatus::Contacted,
                'source' => 'Phone Call',
            ],
        ];

        foreach ($leads as $leadData) {
            $carId = null;

            if ($leadData['type'] === LeadType::CarInquiry && isset($leadData['car_make']) && isset($leadData['car_model'])) {
                $make = Make::where('name', $leadData['car_make'])->first();
                $model = CarModel::where('name', $leadData['car_model'])->where('make_id', $make->id)->first();
                $car = Car::where('make_id', $make->id)->where('model_id', $model->id)->first();

                if ($car) {
                    $carId = $car->id;
                }
            }

            Lead::create([
                'name' => $leadData['name'],
                'email' => $leadData['email'],
                'phone' => $leadData['phone'],
                'message' => $leadData['message'],
                'type' => $leadData['type'],
                'status' => $leadData['status'],
                'source' => $leadData['source'],
                'car_id' => $carId,
            ]);
        }
    }
}