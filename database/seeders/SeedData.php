<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Food;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\NutritionTracking;
use Illuminate\Support\Facades\Hash;

class SeedData extends Seeder
{
    public function run()
    {
        // Isi kategori makanan
        $categories = [
            ['name' => 'Makanan Utama', 'description' => 'Hidangan utama yang mengenyangkan'],
            ['name' => 'Minuman', 'description' => 'Berbagai minuman segar dan hangat'],
            ['name' => 'Dessert', 'description' => 'Makanan penutup yang manis'],
            ['name' => 'Snack', 'description' => 'Camilan ringan untuk segala waktu'],
            ['name' => 'Salad', 'description' => 'Salad segar dan sehat'],
            ['name' => 'Smoothie', 'description' => 'Smoothie buah dan sayuran segar'],
            ['name' => 'Sup', 'description' => 'Sup hangat dan bergizi'],
            ['name' => 'Pasta', 'description' => 'Berbagai jenis pasta Italia'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Isi 10 customer (9 customer biasa + 1 admin)
        $customers = [
            // Admin user
            [
                'name' => 'Admin System',
                'email' => 'admin@healthyfood.com',
                'password' => 'admin123',
                'phone' => '08123456789',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'allergies' => 'None',
                'role' => 'admin',
                'is_active' => true
            ],
            // Customer biasa
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => 'password123',
                'phone' => '08111111111',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'allergies' => 'Kacang',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => 'password123',
                'phone' => '08222222222',
                'address' => 'Jl. Sudirman No. 25, Bandung',
                'allergies' => 'Susu',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'password' => 'password123',
                'phone' => '08333333333',
                'address' => 'Jl. Diponegoro No. 15, Surabaya',
                'allergies' => 'Gluten',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya@example.com',
                'password' => 'password123',
                'phone' => '08444444444',
                'address' => 'Jl. Gatot Subroto No. 30, Medan',
                'allergies' => 'None',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi@example.com',
                'password' => 'password123',
                'phone' => '08555555555',
                'address' => 'Jl. Ahmad Yani No. 45, Yogyakarta',
                'allergies' => 'Seafood',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Rina Wati',
                'email' => 'rina@example.com',
                'password' => 'password123',
                'phone' => '08666666666',
                'address' => 'Jl. Pahlawan No. 20, Semarang',
                'allergies' => 'None',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@example.com',
                'password' => 'password123',
                'phone' => '08777777777',
                'address' => 'Jl. Veteran No. 35, Malang',
                'allergies' => 'Telur',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Lina Marlina',
                'email' => 'lina@example.com',
                'password' => 'password123',
                'phone' => '08888888888',
                'address' => 'Jl. Kartini No. 12, Denpasar',
                'allergies' => 'None',
                'role' => 'customer',
                'is_active' => true
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi@example.com',
                'password' => 'password123',
                'phone' => '08999999999',
                'address' => 'Jl. Pemuda No. 8, Makassar',
                'allergies' => 'Kacang, Susu',
                'role' => 'customer',
                'is_active' => true
            ]
        ];

        foreach ($customers as $customer) {
            $createdCustomer = Customer::create($customer);

            // Insert NutritionTracking untuk setiap customer
            NutritionTracking::create([
                'customer_id' => $createdCustomer->id,
                'total_calories' => 0,
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fat' => 0,
            ]);
        }

        // Isi 20 menu makanan dengan berbagai kategori
        $foods = [
            // Makanan Utama (category_id: 1)
            [
                'name' => 'Nasi Ayam Teriyaki',
                'category_id' => 1,
                'description' => 'Nasi putih dengan ayam teriyaki dan sayuran segar',
                'price' => 25000,
                'nutrition_fact' => 'Tinggi protein, karbohidrat seimbang',
                'calories' => 450,
                'protein' => 35,
                'carbs' => 55,
                'fat' => 12,
                'is_vegetarian' => false,
                'is_vegan' => false,
                'is_dairy_free' => true,
                'is_gluten_free' => false,
                'is_low_calorie' => false,
                'is_available' => true,
                'image' => 'nasi-ayam-teriyaki.jpg'
            ],
            [
                'name' => 'Salmon Grilled Bowl',
                'category_id' => 1,
                'description' => 'Salmon panggang dengan quinoa dan sayuran panggang',
                'price' => 35000,
                'nutrition_fact' => 'Tinggi omega-3 dan protein',
                'calories' => 380,
                'protein' => 32,
                'carbs' => 25,
                'fat' => 18,
                'is_vegetarian' => false,
                'is_vegan' => false,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'salmon-grilled-bowl.jpg'
            ],
            [
                'name' => 'Buddha Bowl Vegetarian',
                'category_id' => 1,
                'description' => 'Bowl sehat dengan quinoa, chickpeas, dan sayuran segar',
                'price' => 22000,
                'nutrition_fact' => 'Tinggi serat dan protein nabati',
                'calories' => 320,
                'protein' => 15,
                'carbs' => 45,
                'fat' => 10,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'buddha-bowl.jpg'
            ],
            // Minuman (category_id: 2)
            [
                'name' => 'Green Tea Latte',
                'category_id' => 2,
                'description' => 'Teh hijau dengan susu almond dan madu',
                'price' => 15000,
                'nutrition_fact' => 'Antioksidan tinggi, rendah kalori',
                'calories' => 120,
                'protein' => 3,
                'carbs' => 18,
                'fat' => 4,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'green-tea-latte.jpg'
            ],
            [
                'name' => 'Cold Brew Coffee',
                'category_id' => 2,
                'description' => 'Kopi dingin dengan es batu, tanpa gula tambahan',
                'price' => 12000,
                'nutrition_fact' => 'Rendah kalori, tinggi kafein',
                'calories' => 5,
                'protein' => 0,
                'carbs' => 1,
                'fat' => 0,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'cold-brew-coffee.jpg'
            ],
            [
                'name' => 'Infused Water Lemon Mint',
                'category_id' => 2,
                'description' => 'Air mineral dengan irisan lemon dan daun mint segar',
                'price' => 8000,
                'nutrition_fact' => 'Bebas kalori, menyegarkan',
                'calories' => 0,
                'protein' => 0,
                'carbs' => 0,
                'fat' => 0,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'infused-water.jpg'
            ],
            // Dessert (category_id: 3)
            [
                'name' => 'Chia Pudding Berry',
                'category_id' => 3,
                'description' => 'Pudding chia dengan berry segar dan madu',
                'price' => 18000,
                'nutrition_fact' => 'Tinggi omega-3 dan serat',
                'calories' => 180,
                'protein' => 6,
                'carbs' => 25,
                'fat' => 8,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'chia-pudding.jpg'
            ],
            [
                'name' => 'Dark Chocolate Avocado Mousse',
                'category_id' => 3,
                'description' => 'Mousse cokelat sehat dengan alpukat dan kakao',
                'price' => 20000,
                'nutrition_fact' => 'Lemak sehat, antioksidan',
                'calories' => 220,
                'protein' => 4,
                'carbs' => 28,
                'fat' => 12,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => false,
                'is_available' => true,
                'image' => 'chocolate-mousse.jpg'
            ],
            // Snack (category_id: 4)
            [
                'name' => 'Energy Balls',
                'category_id' => 4,
                'description' => 'Bola energi dari kurma, kacang, dan biji-bijian',
                'price' => 12000,
                'nutrition_fact' => 'Energi alami, protein nabati',
                'calories' => 150,
                'protein' => 5,
                'carbs' => 20,
                'fat' => 7,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'energy-balls.jpg'
            ],
            [
                'name' => 'Kale Chips',
                'category_id' => 4,
                'description' => 'Keripik kale panggang dengan bumbu alami',
                'price' => 10000,
                'nutrition_fact' => 'Tinggi vitamin K dan antioksidan',
                'calories' => 80,
                'protein' => 3,
                'carbs' => 8,
                'fat' => 4,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'kale-chips.jpg'
            ],
            // Salad (category_id: 5)
            [
                'name' => 'Caesar Salad Healthy',
                'category_id' => 5,
                'description' => 'Salad caesar dengan dressing yogurt dan crouton gandum',
                'price' => 20000,
                'nutrition_fact' => 'Rendah lemak, tinggi serat',
                'calories' => 180,
                'protein' => 8,
                'carbs' => 15,
                'fat' => 10,
                'is_vegetarian' => true,
                'is_vegan' => false,
                'is_dairy_free' => false,
                'is_gluten_free' => false,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'caesar-salad.jpg'
            ],
            [
                'name' => 'Rainbow Salad',
                'category_id' => 5,
                'description' => 'Salad warna-warni dengan berbagai sayuran segar',
                'price' => 18000,
                'nutrition_fact' => 'Vitamin dan mineral lengkap',
                'calories' => 120,
                'protein' => 4,
                'carbs' => 20,
                'fat' => 3,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'rainbow-salad.jpg'
            ],
            // Smoothie (category_id: 6)
            [
                'name' => 'Green Detox Smoothie',
                'category_id' => 6,
                'description' => 'Smoothie hijau dengan bayam, apel, dan lemon',
                'price' => 16000,
                'nutrition_fact' => 'Detoksifikasi alami, vitamin C tinggi',
                'calories' => 140,
                'protein' => 3,
                'carbs' => 32,
                'fat' => 1,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'green-smoothie.jpg'
            ],
            [
                'name' => 'Protein Berry Smoothie',
                'category_id' => 6,
                'description' => 'Smoothie berry dengan protein powder dan yogurt',
                'price' => 20000,
                'nutrition_fact' => 'Tinggi protein, antioksidan',
                'calories' => 200,
                'protein' => 15,
                'carbs' => 25,
                'fat' => 5,
                'is_vegetarian' => true,
                'is_vegan' => false,
                'is_dairy_free' => false,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'protein-smoothie.jpg'
            ],
            // Sup (category_id: 7)
            [
                'name' => 'Sup Ayam Jahe',
                'category_id' => 7,
                'description' => 'Sup ayam hangat dengan jahe dan sayuran',
                'price' => 18000,
                'nutrition_fact' => 'Menghangatkan, tinggi protein',
                'calories' => 160,
                'protein' => 20,
                'carbs' => 12,
                'fat' => 5,
                'is_vegetarian' => false,
                'is_vegan' => false,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'sup-ayam-jahe.jpg'
            ],
            [
                'name' => 'Sup Lentil Merah',
                'category_id' => 7,
                'description' => 'Sup lentil merah dengan rempah-rempah',
                'price' => 15000,
                'nutrition_fact' => 'Tinggi protein nabati dan serat',
                'calories' => 180,
                'protein' => 12,
                'carbs' => 28,
                'fat' => 3,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'sup-lentil.jpg'
            ],
            // Pasta (category_id: 8)
            [
                'name' => 'Zucchini Noodles Pesto',
                'category_id' => 8,
                'description' => 'Mie zucchini dengan saus pesto basil',
                'price' => 22000,
                'nutrition_fact' => 'Rendah karbohidrat, tinggi vitamin',
                'calories' => 150,
                'protein' => 6,
                'carbs' => 12,
                'fat' => 10,
                'is_vegetarian' => true,
                'is_vegan' => false,
                'is_dairy_free' => false,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'zucchini-noodles.jpg'
            ],
            [
                'name' => 'Whole Wheat Pasta Primavera',
                'category_id' => 8,
                'description' => 'Pasta gandum utuh dengan sayuran musiman',
                'price' => 24000,
                'nutrition_fact' => 'Tinggi serat, vitamin lengkap',
                'calories' => 280,
                'protein' => 12,
                'carbs' => 45,
                'fat' => 8,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => false,
                'is_low_calorie' => false,
                'is_available' => true,
                'image' => 'pasta-primavera.jpg'
            ],
            [
                'name' => 'Shirataki Noodles Teriyaki',
                'category_id' => 8,
                'description' => 'Mie shirataki rendah kalori dengan saus teriyaki',
                'price' => 20000,
                'nutrition_fact' => 'Sangat rendah kalori, tinggi serat',
                'calories' => 80,
                'protein' => 3,
                'carbs' => 15,
                'fat' => 2,
                'is_vegetarian' => true,
                'is_vegan' => true,
                'is_dairy_free' => true,
                'is_gluten_free' => true,
                'is_low_calorie' => true,
                'is_available' => true,
                'image' => 'shirataki-noodles.jpg'
            ]
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }

        // Isi beberapa order contoh
        $orders = [
            [
                'customer_id' => 2, // Budi
                'order_number' => 'ORD' . date('Ymd') . '001',
                'order_type' => 'dine_in',
                'status' => 'completed',
                'total_amount' => 52000,
                'special_requests' => 'Tidak pedas'
            ],
            [
                'customer_id' => 3, // Siti
                'order_number' => 'ORD' . date('Ymd') . '002',
                'order_type' => 'take_away',
                'status' => 'processing',
                'total_amount' => 35000,
                'special_requests' => 'Extra sayuran'
            ],
            [
                'customer_id' => 4, // Ahmad
                'order_number' => 'ORD' . date('Ymd') . '003',
                'order_type' => 'dine_in',
                'status' => 'pending',
                'total_amount' => 30000,
                'special_requests' => 'Tanpa gluten'
            ],
            [
                'customer_id' => 5, // Maya
                'order_number' => 'ORD' . date('Ymd') . '004',
                'order_type' => 'take_away',
                'status' => 'completed',
                'total_amount' => 36000,
                'special_requests' => 'Porsi besar'
            ],
            [
                'customer_id' => 6, // Dedi
                'order_number' => 'ORD' . date('Ymd') . '005',
                'order_type' => 'dine_in',
                'status' => 'cancelled',
                'total_amount' => 22000,
                'special_requests' => 'Tanpa seafood'
            ]
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        // Isi detail pesanan
        // Attach foods to orders using many-to-many relationship
        $orderFoodData = [
            // Order 1 (Budi)
            1 => [
                1 => ['quantity' => 1, 'price' => 25000, 'customization' => 'Tidak pedas'],
                4 => ['quantity' => 1, 'price' => 15000, 'customization' => 'Hangat'],
                9 => ['quantity' => 1, 'price' => 12000, 'customization' => 'Porsi kecil']
            ],
            // Order 2 (Siti)
            2 => [
                2 => ['quantity' => 1, 'price' => 35000, 'customization' => 'Extra sayuran']
            ],
            // Order 3 (Ahmad)
            3 => [
                3 => ['quantity' => 1, 'price' => 22000, 'customization' => 'Tanpa gluten'],
                6 => ['quantity' => 1, 'price' => 8000, 'customization' => 'Extra mint']
            ],
            // Order 4 (Maya)
            4 => [
                11 => ['quantity' => 1, 'price' => 20000, 'customization' => 'Porsi besar'],
                13 => ['quantity' => 1, 'price' => 16000, 'customization' => 'Extra berry']
            ],
            // Order 5 (Dedi) - Cancelled
            5 => [
                3 => ['quantity' => 1, 'price' => 22000, 'customization' => 'Tanpa seafood']
            ]
        ];

        foreach ($orderFoodData as $orderId => $foods) {
            $order = Order::find($orderId);
            if ($order) {
                $order->foods()->attach($foods);
            }
        }

        // Isi pembayaran
         $payments = [
             ['order_id' => 1, 'method' => 'credit_card', 'amount' => 52000, 'transaction_id' => 'TXN' . time() . '001', 'status' => 'completed'],
             ['order_id' => 2, 'method' => 'e_wallet', 'amount' => 35000, 'transaction_id' => 'TXN' . time() . '002', 'status' => 'pending'],
             ['order_id' => 3, 'method' => 'debit_card', 'amount' => 30000, 'transaction_id' => 'TXN' . time() . '003', 'status' => 'pending'],
             ['order_id' => 4, 'method' => 'qris', 'amount' => 36000, 'transaction_id' => 'TXN' . time() . '004', 'status' => 'completed'],
             ['order_id' => 5, 'method' => 'credit_card', 'amount' => 22000, 'transaction_id' => 'TXN' . time() . '005', 'status' => 'failed']
         ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }

        // Update nutrition tracking untuk pesanan yang completed
        $completedOrders = Order::whereIn('status', ['completed'])->get();
        foreach ($completedOrders as $order) {
            $nutritionTracking = NutritionTracking::where('customer_id', $order->customer_id)->first();
            if ($nutritionTracking) {
                foreach ($order->foods as $food) {
                    if ($food) {
                        $nutritionTracking->total_calories += $food->calories * $food->pivot->quantity;
                        $nutritionTracking->total_protein += $food->protein * $food->pivot->quantity;
                        $nutritionTracking->total_carbs += $food->carbs * $food->pivot->quantity;
                        $nutritionTracking->total_fat += $food->fat * $food->pivot->quantity;
                        $nutritionTracking->save();
                    }
                }
            }
        }
    }
}
