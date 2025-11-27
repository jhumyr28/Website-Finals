<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeaturedToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'is_featured' => [
                'type' => 'BOOLEAN',
                'default' => 0,
                'after' => 'category_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'is_featured');
    }
}
