<?php namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model {
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $allowedFields = ['name', 'description'];
}