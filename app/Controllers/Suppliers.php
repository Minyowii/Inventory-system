<?php namespace App\Controllers;
use App\Models\SupplierModel;

class Suppliers extends BaseController {
    public function index() {
        $model = new SupplierModel();
        return view('suppliers/index', [
            'title' => 'Manajemen Supplier',
            'suppliers' => $model->findAll()
        ]);
    }

    public function add() {
        return view('suppliers/add', ['title' => 'Tambah Supplier']);
    }

    public function store() {
        $model = new SupplierModel();
        $model->save([
            'SupplierName' => $this->request->getPost('SupplierName'),
            'Email' => $this->request->getPost('Email'),
            'PhoneNumber' => $this->request->getPost('PhoneNumber'),
            'Address' => $this->request->getPost('Address'),
        ]);
        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit($id) {
        $model = new SupplierModel();
        return view('suppliers/edit', [
            'title' => 'Edit Supplier',
            'supplier' => $model->find($id)
        ]);
    }

    public function update($id) {
        $model = new SupplierModel();
        $model->update($id, [
            'SupplierName' => $this->request->getPost('SupplierName'),
            'Email' => $this->request->getPost('Email'),
            'PhoneNumber' => $this->request->getPost('PhoneNumber'),
            'Address' => $this->request->getPost('Address'),
        ]);
        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil diupdate');
    }

    public function delete($id) {
        $model = new SupplierModel();
        $model->delete($id);
        return redirect()->to('/suppliers')->with('success', 'Supplier berhasil dihapus');
    }
}