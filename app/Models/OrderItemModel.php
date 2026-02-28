<?php namespace App\Models;
use CodeIgniter\Model;

class OrderItemModel extends Model {
    protected $table = 'order_items';
    protected $primaryKey = 'id_item_order';
    protected $allowedFields = ['order_id', 'item_id', 'quantity', 'price'];
}