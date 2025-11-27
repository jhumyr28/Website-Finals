<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Cart extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $data['cart'] = $cart;
        echo view('templates/header');
        echo view('cart/index', $data);
        echo view('templates/footer');
    }

    public function add()
    {
        $id = $this->request->getPost('product_id');
        $rawQty = $this->request->getPost('quantity') ?? $this->request->getPost('qty');
        $qty = max(1, (int) $rawQty);
        $color = $this->request->getPost('color') ?? 'Default';

        $productModel = new ProductModel();
        $product = $productModel->find($id);
        if(!$product) return redirect()->back();

        $cart = session()->get('cart') ?? [];
        
        // Use a composite key to allow same product with different colors
        $cartKey = $id . '_' . $color;
        
        if(isset($cart[$cartKey])){
            $cart[$cartKey]['qty'] += $qty;
        }else{
            $cart[$cartKey] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'price' => $product['price'],
                'qty' => $qty,
                'color' => $color,
                'image' => $product['image'],
            ];
        }
        session()->set('cart', $cart);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'ok', 'cartCount' => array_sum(array_column($cart, 'qty'))]);
        }

        return redirect()->to('/cart');
    }

    public function update()
    {
        $id = $this->request->getPost('product_id');
        $rawQty = $this->request->getPost('quantity') ?? $this->request->getPost('qty');
        $qty = (int) $rawQty;

        $cart = session()->get('cart') ?? [];
        if (!isset($cart[$id])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Item not in cart']);
            }
            return redirect()->back();
        }

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['qty'] = $qty;
        }

        session()->set('cart', $cart);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'ok', 'cartCount' => array_sum(array_column($cart, 'qty'))]);
        }

        return redirect()->to('/cart');
    }

    public function remove()
    {
        $id = $this->request->getPost('product_id');

        $cart = session()->get('cart') ?? [];
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->set('cart', $cart);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'ok', 'cartCount' => array_sum(array_column($cart, 'qty'))]);
        }

        return redirect()->to('/cart');
    }
}
