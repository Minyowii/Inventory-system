<?php namespace App\Controllers;
use App\Models\InventoryModel; 
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Orders extends BaseController {
    
    public function index() { 
        $orderModel = new OrderModel();
        return view('orders/index', [
            'title' => 'Pesanan Saya',
            'orders' => $orderModel->where('user_id', session()->get('user_id'))->findAll()
        ]); 
    }

    // Tampilan Halaman Keranjang
    public function cart() {
        return view('orders/cart', [
            'title' => 'Keranjang Belanja',
            'cart' => session()->get('cart') ?? []
        ]);
    }

    // Menambah Barang ke Keranjang (Session)
    public function addToCart() {
        $id = $this->request->getPost('item_id');
        $qty = (int)$this->request->getPost('quantity');
        
        $inventoryModel = new InventoryModel();
        $item = $inventoryModel->find($id);

        if ($item) {
            $cart = session()->get('cart') ?? [];
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += $qty;
            } else {
                $cart[$id] = [
                    'id'       => $id,
                    'name'     => $item['ItemName'],
                    'quantity' => $qty,
                    'price'    => 15000, // Kamu bisa ganti ke harga asli dari DB jika ada
                ];
            }
            session()->set('cart', $cart);
            return redirect()->to(base_url('inventory'))->with('success', 'Barang ditambahkan ke keranjang!');
        }
        return redirect()->back();
    }

    // Menghapus Item dari Keranjang
    public function removeCart($id) {
        $cart = session()->get('cart');
        unset($cart[$id]);
        session()->set('cart', $cart);
        return redirect()->to(base_url('orders/cart'));
    }

    // Proses Checkout ke Database
    public function checkout() {
        $cart = session()->get('cart');
        if (!$cart) return redirect()->back();

        $orderModel = new OrderModel();
        $itemModel = new OrderItemModel();

        $total = 0;
        foreach ($cart as $item) { $total += ($item['price'] * $item['quantity']); }

        $orderId = $orderModel->insert([
            'user_id' => session()->get('user_id'),
            'total_price' => $total,
            'status' => 'Pending'
        ]);

        foreach ($cart as $item) {
            $itemModel->insert([
                'order_id' => $orderId,
                'item_id'  => $item['id'],
                'quantity' => $item['quantity'],
                'price'    => $item['price']
            ]);
        }

        session()->remove('cart');
        return redirect()->to(base_url('orders'))->with('success', 'Checkout berhasil! Pesanan diproses.');
    }

    // Admin: Kelola Order
    public function manage() {
        $orderModel = new OrderModel();
        // Cek join dengan users agar nama tampil
        $orders = $orderModel->select('orders.*, users.full_name')
                             ->join('users', 'users.user_id = orders.user_id', 'left')
                             ->findAll();
        return view('orders/manage', [
            'title' => 'Kelola Pesanan',
            'orders' => $orders
        ]);
    }

    // Admin: Update Status Pesanan
    public function updateStatus($id) {
        $orderModel = new OrderModel();
        $status = $this->request->getPost('status');
        $orderModel->update($id, ['status' => $status]);
        return redirect()->to(base_url('orders/manage'))->with('success', 'Status pesanan berhasil diubah!');
    }
}