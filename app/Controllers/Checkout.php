<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Checkout extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart');
        }

        echo view('templates/header');
        echo view('checkout/index', ['cart' => $cart]);
        echo view('templates/footer');
    }

    public function placeOrder()
    {
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart');
        }

        $validation = $this->validate([
            'name' => 'required|min_length[2]',
            'email' => 'required|valid_email',
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');

        $total = 0;
        foreach ($cart as $c) {
            $total += $c['price'] * $c['qty'];
        }

        $orderModel = new OrderModel();
        $orderData = [
            'user_name' => $name,
            'user_email' => $email,
            'total' => $total,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $orderId = $orderModel->createWithItems($orderData, $cart);
        if (! $orderId) {
            return redirect()->back()->with('error', 'Unable to place order. Please try again.');
        }

        // clear cart
        session()->remove('cart');

        return redirect()->to('/checkout/thanks/' . $orderId);
    }

    public function thanks($orderId = null)
    {
        echo view('templates/header');
        echo view('checkout/thanks', ['orderId' => $orderId]);
        echo view('templates/footer');
    }
}
