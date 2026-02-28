<?php 
class Admin extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('M_data');
    }

    // Fungsi Generic untuk menampilkan tabel (Responsive & Paging)
    private function _tampilkan($table, $view) {
        $this->load->library('pagination');
        $config['base_url'] = base_url()."index.php/admin/$table/";
        $config['total_rows'] = $this->M_data->ambil_data($table)->num_rows();
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        
        $from = $this->uri->segment(3);
        $data[$table] = $this->M_data->data_paging($table, $config['per_page'], $from);
        $this->load->view($view, $data);
    }

    function users() { $this->_tampilkan('users', 'v_users'); }
    function inventory() { $this->_tampilkan('inventory', 'v_inventory'); }
    function categories() { $this->_tampilkan('categories', 'v_categories'); }
    function suppliers() { $this->_tampilkan('suppliers', 'v_suppliers'); }
    function orders() { $this->_tampilkan('orders', 'v_orders'); }

    function hapus($id, $table) {
        $where = array('id' => $id);
        $this->M_data->hapus_data($where, $table);
        redirect('admin/'.$table);
    }
}