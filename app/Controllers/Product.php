<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class Product extends BaseController
{
    public function browse()
    {
        $model = new ProductModel();
        $search = $this->request->getGet('search');
        $sort = $this->request->getGet('sort') ?? 'name';
        
        $query = $model;
        
        if ($search) {
            $query = $query->like('name', $search)->orLike('description', $search);
        }
        
        // Sort options
        switch($sort) {
            case 'price_low':
                $query = $query->orderBy('price', 'ASC');
                break;
            case 'price_high':
                $query = $query->orderBy('price', 'DESC');
                break;
            case 'newest':
                $query = $query->orderBy('id', 'DESC');
                break;
            default:
                $query = $query->orderBy('name', 'ASC');
        }
        
        $data['products'] = $query->findAll();
        $data['search'] = $search;
        $data['sort'] = $sort;
        
        echo view('templates/header');
        echo view('product/browse', $data);
        echo view('templates/footer');
    }

    public function view($slug)
    {
        $model = new ProductModel();
        $data['product'] = $model->where('slug',$slug)->first();
        if(! $data['product']){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
        echo view('templates/header');
        echo view('product/view', $data);
        echo view('templates/footer');
    }
}
