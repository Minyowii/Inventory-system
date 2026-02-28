<?php namespace App\Models;
use CodeIgniter\Model;

class SupplierModel extends Model {
    protected $table = 'suppliers';
    protected $primaryKey = 'SupplierID';
    protected $allowedFields = ['SupplierName', 'Email', 'PhoneNumber'];
}