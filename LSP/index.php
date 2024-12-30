<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "library_system";

// Koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nama_buku = "";
$penulis = "";
$penerbit_buku = "";
$isbn = "";
$sukses = "";
$error = "";

$search_query = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

// Search functionality
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Delete and edit operations
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM library_system WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM library_system WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama_buku = $r1['nama_buku'];
    $penulis = $r1['penulis'];
    $penerbit_buku = $r1['penerbit_buku'];
    $isbn = $r1['isbn'];

    if ($nama_buku == '') {
        $error = "Data tidak ditemukan";
    }
}

if ($op == 'kembali') {
    $id = $_GET['id'];
    $sql1 = "UPDATE library_system SET status = '' WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
}


if (isset($_POST['simpan'])) { //untuk create
    $nama_buku = $_POST['nama_buku'];
    $penulis = $_POST['penulis'];
    $penerbit_buku = $_POST['penerbit_buku'];
    $isbn = $_POST['isbn'];

    if ($nama_buku && $penulis && $penerbit_buku && $isbn) {
        // Check for duplicate entries before inserting
        $sql_check = "SELECT * FROM library_system WHERE nama_buku = '$nama_buku' AND penulis = '$penulis' AND isbn = '$isbn'";
        $result_check = mysqli_query($koneksi, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            // Data already exists
            $error = "Buku ini sudah terdaftar.";
        } else {
            // No duplicates, proceed with insertion or update
            if ($op == 'edit') { //untuk update
                $sql1 = "UPDATE library_system SET nama_buku = '$nama_buku', penulis='$penulis', penerbit_buku='$penerbit_buku', isbn='$isbn' WHERE id = '$id'";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Data berhasil diupdate";
                } else {
                    $error = "Data gagal diupdate";
                }
            } else { //untuk insert
                $sql1 = "INSERT INTO library_system (nama_buku, penulis, penerbit_buku, isbn) VALUES ('$nama_buku','$penulis','$penerbit_buku','$isbn')";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    $sukses = "Berhasil memasukkan data baru";
                } else {
                    $error = "Gagal memasukkan data";
                }
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1250px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Search Bar -->
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search by Nama Buku, Penulis, Penerbit Buku, ISBN"
                               name="search" value="<?php echo $search_query; ?>">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form to Insert or Edit Data -->
        <div class="card">
            <div class="card-header">
                Silahkan Simpan / Edit Data Buku, <?php echo $_SESSION['username'].' - ';?>
                <a href="signout.php">sign-out</a>
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama_buku" class="col-sm-2 col-form-label">Nama Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_buku" name="nama_buku"
                                value="<?php echo $nama_buku ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penulis" name="penulis"
                                value="<?php echo $penulis ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penerbit_buku" class="col-sm-2 col-form-label">Penerbit Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit_buku" name="penerbit_buku"
                                value="<?php echo $penerbit_buku ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $isbn ?>">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <!-- Tombol Simpan Data -->
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        
                        <!-- Tombol Kembali Ke Home dengan warna merah -->
                        <a href="loading.php" class="btn btn-danger ms-2">Kembali Ke Home</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display Books -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Katalog Buku
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit Buku</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // SQL query with search functionality
                        if ($search_query != "") {
                            // Modified SQL query to search in 'nama_buku', 'penulis', 'penerbit_buku', and 'isbn'
                            $sql2 = "SELECT * FROM library_system WHERE nama_buku LIKE '%$search_query%' 
                                    OR penulis LIKE '%$search_query%' 
                                    OR penerbit_buku LIKE '%$search_query%' 
                                    OR isbn LIKE '%$search_query%' 
                                    ORDER BY id DESC";
                        } else {
                            //$sql2 = "SELECT * FROM library_system WHERE status = '' ORDER BY id DESC";
                            $sql2 = "SELECT * FROM library_system ORDER BY id DESC";
                        }

                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nama_buku = $r2['nama_buku'];
                            $penulis = $r2['penulis'];
                            $penerbit_buku = $r2['penerbit_buku'];
                            $isbn = $r2['isbn'];
                            $status = $r2['status'];
                            ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama_buku ?></td>
                                <td scope="row"><?php echo $penulis ?></td>
                                <td scope="row"><?php echo $penerbit_buku ?></td>
                                <td scope="row"><?php echo $isbn ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?> "
                                        onclick="return confirm('Yakin mau delete data?')"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                    <?php if ($status == "") {
                                            echo "Ready";
                                        } else { ?>
                                    <a href="index.php?op=kembali&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Dikembaklikan</button></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
