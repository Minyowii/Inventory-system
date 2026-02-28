<?php namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\OrderModel;

class Dashboard extends BaseController {
    public function index() {
        $inventoryModel = new InventoryModel();
        $orderModel = new OrderModel();

        $data = [
            'title' => 'Dashboard',
            'total_products' => $inventoryModel->countAllResults(),
            'low_stock' => $inventoryModel->where('Quantity <', 10)->countAllResults(),
            'total_entries' => $orderModel->countAllResults(),
            'recent_orders' => $orderModel->select('orders.*, users.full_name')
                                         ->join('users', 'users.user_id = orders.user_id', 'left')
                                         ->orderBy('orders.id_order', 'DESC')
                                         ->limit(5)
                                         ->findAll(),
        ];

        return view('dashboard', $data);
    }
}
