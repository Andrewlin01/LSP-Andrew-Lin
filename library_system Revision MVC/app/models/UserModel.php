<?php
class UserModel {
    private $db;

    // Constructor untuk inisialisasi koneksi database
    public function __construct($db) {
        $this->db = $db;
    }

    // Fungsi untuk membersihkan input data
    public function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    // Memeriksa apakah nama dan username cocok di database

    // Fungsi autentikasi untuk memeriksa username dan password
      
    public function checkNama($data) {
        $nama = $data['nama'];
        $usernm = $data['usernm'];
        $passwd = $data['passwd'];
        $sql = "SELECT * FROM users WHERE nama = $nama AND usernm = $usernm AND passwd = $passwd";
        return mysqli_query($this->db, $sql);
        
    }

    // Fungsi untuk menambahkan pengguna baru
    public function registerUser($nama, $username, $password) {
        $stmt = $this->db->prepare("INSERT INTO users (nama, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $username, $password);
        return $stmt->execute();
    }
}
?>
