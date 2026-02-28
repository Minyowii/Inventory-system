<?php namespace App\Controllers;

use App\Models\InventoryModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;

class Inventory extends BaseController {

    public function index() {
        $model = new InventoryModel();
        $role = session()->get('role');
        $catId = $this->request->getVar('category_id');
        $search = $this->request->getVar('search');

        if ($role == 'admin') {
            $builder = $model->select('inventory.*, categories.name as category_name')
                             ->join('categories', 'categories.id_category = inventory.category_id', 'left');
            if ($search) $builder->like('ItemName', $search);
            $data['items'] = $builder->findAll();
        } else {
            $builder = $model;
            if ($catId) $builder->where('category_id', $catId);
            if ($search) $builder->like('ItemName', $search);
            $data['items'] = $builder->findAll();
        }

        $data['title'] = 'Daftar Barang';
        return view('inventory/index', $data);
    }
    
    public function add() {
        $data = [
            'title'      => 'Tambah Barang Baru',
            'suppliers'  => (new SupplierModel())->findAll(),
            'categories' => (new CategoryModel())->findAll()
        ];
        return view('inventory/add', $data);
    }

    public function store() {
        $model = new InventoryModel();
        $itemName = $this->request->getPost('ItemName');

       
        $existing = $model->where('ItemName', $itemName)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Barang dengan nama "' . $itemName . '" sudah ada!');
        }

        $model->save([
            'ItemName'    => $itemName,
            'Quantity'    => $this->request->getPost('Quantity'),
            'SupplierID'  => $this->request->getPost('SupplierID'),
            'category_id' => $this->request->getPost('category_id'),
        ]);

        return redirect()->to('/inventory')->with('success', 'Barang berhasil ditambahkan!');
    }

   
    public function edit($id) {
        $model = new InventoryModel();
        
        $data = [
            'title'      => 'Edit Barang',
            'result'     => $model->find($id),
            'suppliers'  => (new SupplierModel())->findAll(),
            'categories' => (new CategoryModel())->findAll()
        ];
        return view('inventory/edit', $data);
    }

  
    public function update($id) {
        $model = new InventoryModel();
        $model->update($id, [
            'ItemName'    => $this->request->getPost('ItemName'),
            'Quantity'    => $this->request->getPost('Quantity'),
            'SupplierID'  => $this->request->getPost('SupplierID'),
            'category_id' => $this->request->getPost('category_id'),
        ]);

        return redirect()->to('/inventory')->with('success', 'Data inventori berhasil diubah');
    }
    
  
    public function delete($id) {
        $model = new InventoryModel();
        $model->delete($id);
        return redirect()->to('/inventory')->with('success', 'Barang telah dihapus dari sistem');
    }

    public function show($id) {
        $model = new InventoryModel();
    
        $item = $model->select('inventory.*, categories.name as category_name, suppliers.SupplierName as supplier_name')
                    ->join('categories', 'categories.id_category = inventory.category_id', 'left')
                    ->join('suppliers', 'suppliers.SupplierID = inventory.SupplierID', 'left')
                    ->find($id);

        if (empty($item)) {
            return redirect()->to('/inventory')->with('error', 'Data barang tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Barang: ' . $item['ItemName'],
            'result' => $item
        ];
        return view('inventory/show', $data);
    }
} 