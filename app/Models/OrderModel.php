<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_name', 'user_email', 'total', 'created_at', 'updated_at'];

    public function createWithItems(array $orderData, array $items)
    {
        $this->db->transStart();

        $this->insert($orderData);
        $orderId = $this->getInsertID();

        $itemRows = [];
        foreach ($items as $i) {
            $itemRows[] = [
                'order_id' => $orderId,
                'product_id' => $i['id'],
                'name' => $i['name'],
                'price' => $i['price'],
                'quantity' => $i['qty'],
            ];
        }

        if (!empty($itemRows)) {
            $this->db->table('order_items')->insertBatch($itemRows);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        }

        return $orderId;
    }
}
