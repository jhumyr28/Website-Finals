<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        echo view('templates/header');
        echo view('admin/dashboard');
        echo view('templates/footer');
    }

    public function products()
    {
        $productModel = new ProductModel();
        $data['products'] = $productModel->findAll();

        echo view('templates/header');
        echo view('admin/products/index', $data);
        echo view('templates/footer');
    }

    public function create()
    {
        echo view('templates/header');
        echo view('admin/products/create');
        echo view('templates/footer');
    }

    public function store()
    {
        $validation = $this->validate([
            'name' => 'required|min_length[2]',
            'description' => 'permit_empty',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'permit_empty|max_size[image,1024]|is_image[image]',
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productModel = new ProductModel();
        $image = $this->request->getFile('image');
        $imageName = null;

        if ($image && $image->isValid()) {
            $imageName = $image->getRandomName();
            $image->move('uploads', $imageName);
        }

        // Auto-generate slug from product name
        $name = $this->request->getPost('name');
        $slug = strtolower(str_replace(' ', '-', trim($name)));
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);

        $data = [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'image' => $imageName,
        ];

        $productModel->insert($data);

        return redirect()->to('/admin/products')->with('success', 'Product added successfully');
    }

    public function orders()
    {
        echo view('templates/header');
        echo view('admin/orders');
        echo view('templates/footer');
    }
}
