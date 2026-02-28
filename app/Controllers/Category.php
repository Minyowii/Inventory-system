<?php namespace App\Controllers;
use App\Models\CategoryModel;

class Category extends BaseController {
    
    public function index() {
        $model = new CategoryModel();
        return view('categories/index', [
            'title' => 'Kategori',
            'categories' => $model->findAll()
        ]);
    }

    public function add() {
        return view('categories/add', ['title' => 'Tambah Kategori']);
    }

    public function store() {
        $model = new CategoryModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to(base_url('categories'))->with('success', 'Kategori baru berhasil ditambah.');
    }

    public function edit($id) {
        $model = new CategoryModel();
        return view('categories/edit', [
            'title' => 'Edit Kategori',
            'category' => $model->find($id)
        ]);
    }

    public function update($id) {
        $model = new CategoryModel();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to(base_url('categories'))->with('success', 'Kategori berhasil diupdate.');
    }

    public function delete($id) {
        $model = new CategoryModel();
        $model->delete($id);
        return redirect()->to(base_url('categories'))->with('success', 'Kategori berhasil dihapus.');
    }
}