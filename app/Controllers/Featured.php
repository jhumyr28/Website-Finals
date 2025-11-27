<?php namespace App\Controllers;

use App\Models\ProductModel;

class Featured extends BaseController
{
    public function markFeatured()
    {
        $db = db_connect();
        $db->query('UPDATE products SET is_featured = 1');
        echo "All products marked as featured!";
    }
}
