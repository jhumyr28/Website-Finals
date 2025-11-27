<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Seed extends BaseController
{
    public function products()
    {
        $productModel = new ProductModel();

        $products = [
            [
                'category_id' => null,
                'name' => 'White T-Shirt',
                'slug' => 'white-t-shirt',
                'description' => 'Comfortable white cotton t-shirt. Available in multiple sizes.',
                'price' => 299.99,
                'stock' => 50,
                'image' => 'white-tshirt.jpg',
            ],
            [
                'category_id' => null,
                'name' => 'Blue Hoodie',
                'slug' => 'blue-hoodie',
                'description' => 'Cozy blue hoodie with front pocket.',
                'price' => 799.00,
                'stock' => 30,
                'image' => 'blue-hoodie.jpg',
            ],
            [
                'category_id' => null,
                'name' => 'Black Jeans',
                'slug' => 'black-jeans',
                'description' => 'Classic black denim jeans, comfortable fit.',
                'price' => 1299.99,
                'stock' => 40,
                'image' => 'black-jeans.jpg',
            ],
        ];

        foreach ($products as $p) {
            $existing = $productModel->where('slug', $p['slug'])->first();
            if (!$existing) {
                $productModel->insert($p);
            }
        }

        return redirect()->to('/')->with('success', 'Sample products added!');
    }
}
