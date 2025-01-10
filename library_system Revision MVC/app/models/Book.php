<?php

class Book {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function getAll($search = "") {
        $sql = "SELECT * FROM library_system";
        if ($search) {
            $sql .= " WHERE nama_buku LIKE '%$search%' 
                      OR penulis LIKE '%$search%' 
                      OR penerbit_buku LIKE '%$search%' 
                      OR isbn LIKE '%$search%'";
        }
        $sql .= " ORDER BY id DESC";
        return mysqli_query($this->db, $sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM library_system WHERE id = '$id'";
        return mysqli_fetch_assoc(mysqli_query($this->db, $sql));
    }

    public function create($data) {
        $nama_buku = $data['nama_buku'];
        $penulis = $data['penulis'];
        $penerbit_buku = $data['penerbit_buku'];
        $isbn = $data['isbn'];
        $sql = "INSERT INTO library_system (nama_buku, penulis, penerbit_buku, isbn) VALUES ('$nama_buku', '$penulis', '$penerbit_buku', '$isbn')";
        return mysqli_query($this->db, $sql);
    }

    public function update($id, $data) {
        $nama_buku = $data['nama_buku'];
        $penulis = $data['penulis'];
        $penerbit_buku = $data['penerbit_buku'];
        $isbn = $data['isbn'];
        $sql = "UPDATE library_system SET nama_buku = '$nama_buku', penulis = '$penulis', penerbit_buku = '$penerbit_buku', isbn = '$isbn' WHERE id = '$id'";
        return mysqli_query($this->db, $sql);
    }

    public function kembalikan($id) {
        $status = '';
        $sql = "UPDATE library_system SET statuss = '$status' WHERE id = '$id'";
        return mysqli_query($this->db, $sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM library_system WHERE id = '$id'";
        return mysqli_query($this->db, $sql);
    }

    public function checkNama($data) {
        $nama = $data['nama'];
        $usernm = $data['usernm'];
        $passwd = $data['passwd'];
        $sql = "SELECT * FROM anggota WHERE nama = '$nama' AND usernm = '$usernm' AND passwd = '$passwd'";
        return mysqli_query($this->db, $sql);
    }

    public function getByUserName($username)
{
    $stmt = $this->db->prepare("SELECT * FROM anggota WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
    
public function insertUsername($data)
{
    $stmt = $this->db->prepare("INSERT INTO anggota (nama, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data['nama'], $data['username'], $data['password']);
    return $stmt->execute();
}

    public function getAdminByCredentials($nama, $username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE nama = ? AND username = ? AND password = ?");
        $stmt->bind_param("sss", $nama, $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return data jika ditemukan, null jika tidak
    }

    

    
}
