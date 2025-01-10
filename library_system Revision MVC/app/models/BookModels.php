<?php
class BookModel {
    private $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli("localhost", "root", "", "mvc-library");
        if ($this->koneksi->connect_error) {
            die("Tidak bisa terkoneksi ke database: " . $this->koneksi->connect_error);
        }
    }

    // Mengambil semua buku dengan pencarian
    public function getAllBooks($search_query = "") {
        $query = "SELECT * FROM library_system";
        if ($search_query != "") {
            $query .= " WHERE nama_buku LIKE ? OR penulis LIKE ? OR penerbit_buku LIKE ? OR isbn LIKE ?";
        }
        $query .= " ORDER BY id DESC";

        $stmt = $this->koneksi->prepare($query);
        if ($search_query != "") {
            $like_query = '%' . $search_query . '%';
            $stmt->bind_param('ssss', $like_query, $like_query, $like_query, $like_query);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil buku berdasarkan ID
    public function getBookById($id) {
        $query = "SELECT * FROM library_system WHERE id = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Menambahkan buku baru
    public function insertBook($nama_buku, $penulis, $penerbit_buku, $isbn) {
        $query = "INSERT INTO library_system (nama_buku, penulis, penerbit_buku, isbn) VALUES (?, ?, ?, ?)";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param('ssss', $nama_buku, $penulis, $penerbit_buku, $isbn);
        return $stmt->execute();
    }

    // Memperbarui data buku
    public function updateBook($id, $nama_buku, $penulis, $penerbit_buku, $isbn) {
        $query = "UPDATE library_system SET nama_buku = ?, penulis = ?, penerbit_buku = ?, isbn = ? WHERE id = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param('ssssi', $nama_buku, $penulis, $penerbit_buku, $isbn, $id);
        return $stmt->execute();
    }

    // Menghapus buku berdasarkan ID
    public function deleteBook($id) {
        $query = "DELETE FROM library_system WHERE id = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // Menutup koneksi saat model tidak lagi digunakan
    public function __destruct() {
        $this->koneksi->close();
    }
}
?>
