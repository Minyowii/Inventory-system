<?php namespace App\Models;
use CodeIgniter\Model;
class InventoryModel extends Model {
    protected $table = 'inventory';
    protected $primaryKey = 'ItemID';
    protected $allowedFields = ['ItemName', 'Quantity', 'SupplierID', 'category_id'];
}