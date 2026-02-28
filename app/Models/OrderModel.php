<?php namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $allowedFields = ['user_id', 'total_price', 'status', 'created_at'];
}