<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'category_id' => null,
                'name' => 'White T-Shirt',
                'slug' => 'white-t-shirt',
                'description' => 'Comfortable white cotton t-shirt. Available in multiple sizes.',
                'price' => 299.99,
                'stock' => 50,
                'image' => 'tshirt.jpg',
            ],
            [
                'category_id' => null,
                'name' => 'Blue Hoodie',
                'slug' => 'blue-hoodie',
                'description' => 'Cozy blue hoodie with front pocket.',
                'price' => 799.00,
                'stock' => 30,
                'image' => 'mouse.jpg',
            ],
            [
                'category_id' => null,
                'name' => 'Black Jeans',
                'slug' => 'black-jeans',
                'description' => 'Classic black denim jeans with comfortable fit.',
                'price' => 1299.00,
                'stock' => 25,
                'image' => 'headphones.jpg',
            ],
        ];

        $this->db->table('products')->insertBatch($products);
    }
}
