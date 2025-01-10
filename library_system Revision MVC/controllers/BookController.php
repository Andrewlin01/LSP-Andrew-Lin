<?php
//session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Book.php';

class BookController
{
    private $model;

    public function __construct()
    {
        global $koneksi;
        $this->model = new Book($koneksi);
    }

    
    // Method untuk menampilkan daftar buku
    public function index()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $data = $this->model->getAll($search);
        include '../app/views/index.php';
    }

    // Method untuk menampilkan form tambah buku
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi data input
            $data = [
                'nama_buku' => $_POST['nama_buku'] ?? '',
                'penulis' => $_POST['penulis'] ?? '',
                'penerbit_buku' => $_POST['penerbit_buku'] ?? '',
                'isbn' => $_POST['isbn'] ?? '',
            ];

            if ($this->validateBookData($data)) {
                $this->model->create($data);
                header('Location: index.php');
                exit;
            } else {
                $error = "Semua field harus diisi dengan benar.";
            }
        }

        //include __DIR__ . '/../views/index.php';
    }

    // Method untuk menampilkan form edit buku
    public function update()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID tidak ditemukan.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validasi data input
            $data = [
                'nama_buku' => $_POST['nama_buku'] ?? '',
                'penulis' => $_POST['penulis'] ?? '',
                'penerbit_buku' => $_POST['penerbit_buku'] ?? '',
                'isbn' => $_POST['isbn'] ?? '',
            ];

            if ($this->validateBookData($data)) {
                $this->model->update($id, $data);
                header('Location: index.php?controller=Book&action=index');
                exit;
            } else {
                $error = "Semua field harus diisi dengan benar.";
            }
        } else {
            $data = $this->model->getById($id);
            if (!$data) {
                die("Data dengan ID $id tidak ditemukan.");
            }
        }

        //include __DIR__ . '/../views/edit.php';
    }

    public function edit()
    {

        $id = $_GET['id'];

        if (!$id) {
            die("ID tidak ditemukan.");
        }

        $data1 = $this->model->getById($id);
        $book['nama_buku'] = $data1['nama_buku'];
        $book['penulis'] = $data1['penulis'];
        $book['penerbit_buku'] = $data1['penerbit_buku'];
        $book['isbn'] = $data1['isbn'];

        $search = '';
        $data = $this->model->getAll($search);
        include '../app/views/index.php';

    }

    public function return_book()
    {
        $search = '';
        $data = $this->model->getAll($search);

        $id = $_GET['id'];

        if (!$id) {
            die("ID tidak ditemukan.");
        }
        $d = $this->model->kembalikan($id);
        header('Location: index.php?controller=Book&action=index');

        //include '../app/views/index.php';

    }

    // Method untuk menghapus buku
    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("ID tidak ditemukan.");
        }

        if ($this->model->delete($id)) {
            header('Location: index.php');
            exit;
        } else {
            die("Gagal menghapus data.");
        }
    }

    // Method untuk validasi data buku
    private function validateBookData($data)
    {
        foreach ($data as $field) {
            if (empty(trim($field))) {
                return false;
            }
        }
        return true;
    }

    
    public function signup()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sukses = '';
            $error = '';
            $nama = $_POST['nama'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($nama && $username && $password) {
                // Cek apakah username sudah ada
                $data = $this->model->getByUsername($username);
                if ($data['username']) {
                    header('Location: loading.php');

                    } else {
                        $data = $this->model->insertUsername($_POST);                    
                        if ($data) {
                            $sukses = "Signup berhasil. Anda dapat login sekarang.";
                        } else {
                            $error = "Terjadi kesalahan saat menyimpan data.";
                        }
                    }
            } else {
                $error = "Silakan isi semua field.";
            }
        }
    }

    

    

}
