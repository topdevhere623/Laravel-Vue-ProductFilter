<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'kvp_shop_product';

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    protected $fillable = [
        'relation',
        'category',
        'name',
        'model',
        'sku',
        'url',
        'location',
        'ean',
        'jan',
        'mpn',
        'upc',
        'discount_price',
        'price',
        'stock_status',
        'manufacturer',
        'description',
        'attributes',
        'images',
        'images_d',
        'quantity',
        'status',
    ];

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_modified';
}
