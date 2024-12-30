<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db = "library_system";

// Koneksi ke database
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database: " . mysqli_connect_error());
}

$sukses = "";
$error = "";
$warning = "";

$judul_buku = "";
$penulis_buku = "";
$tanggal_pinjam = "";
$tanggal_kembali = "";
$search_query_judul = "";
$search_query_penulis = "";

// Cek apakah ada pencarian
if (isset($_GET['search'])) {
    $search_query_judul = $_GET['judul_buku'] ?? '';
    $search_query_penulis = $_GET['penulis_buku'] ?? '';
}

// Cek apakah ada data buku yang dipilih untuk dipinjam
if (isset($_GET['judul_buku']) && isset($_GET['penulis_buku'])) {
    $judul_buku = $_GET['judul_buku'];
    $penulis_buku = $_GET['penulis_buku'];
}

// Fungsi Edit
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM peminjaman WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    if ($r1) {
        $judul_buku = $r1['judul_buku'];
        $penulis_buku = $r1['penulis_buku'];
        $tanggal_pinjam = $r1['tanggal_pinjam'];
        $tanggal_kembali = $r1['tanggal_kembali'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

// Menambah Data Baru
if (isset($_POST['pinjam'])) {
    $judul_buku = $_POST['judul_buku'];
    $penulis_buku = $_POST['penulis_buku'];
    //$tanggal_pinjam = $_POST['tanggal_pinjam'];
    //$tanggal_kembali = $_POST['tanggal_kembali'];

    // Validasi durasi peminjaman
    //$tanggal_pinjam_date = new DateTime($tanggal_pinjam);
    //$tanggal_kembali_date = new DateTime($tanggal_kembali);
    //$interval = $tanggal_pinjam_date->diff($tanggal_kembali_date);


    //if ($interval->days > 7) {
    //    $warning = "Durasi peminjaman tidak boleh lebih dari 7 hari.";
    //} else {
        // Menyimpan data peminjaman ke tabel peminjaman
        $tanggal_pinjam = date('Y-m-d', strtotime('+1 days', time()));
        $tanggal_kembali = date('Y-m-d', strtotime('+8 days', time()));
        $username = $_SESSION['username'];
        $sql = "INSERT INTO peminjaman (judul_buku, penulis_buku, tanggal_pinjam, tanggal_kembali, username) 
                VALUES ('$judul_buku', '$penulis_buku', '$tanggal_pinjam', '$tanggal_kembali', '$username')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            $sukses = "Peminjaman berhasil dicatat.";
        } else {
            $error = "Gagal mencatat peminjaman.";
        }

        $sql = "UPDATE library_system SET status = 'Dipinjam' WHERE nama_buku = '$judul_buku'";
        $query = mysqli_query($koneksi, $sql);
        if ($query) {
            $sukses = "Peminjaman berhasil dicatat.";
        } else {
            $error = "Gagal mencatat peminjaman.";
        }

    //}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .mx-auto {
            width: 1000px;
        }

        .card {
            margin-top: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-left,
        .col-right {
            padding: 15px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Form untuk pencarian -->
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Judul Buku" name="judul_buku"
                            value="<?php echo htmlspecialchars($search_query_judul); ?>">
                        <input type="text" class="form-control" placeholder="Penulis Buku" name="penulis_buku"
                            value="<?php echo htmlspecialchars($search_query_penulis); ?>">
                        <button class="btn btn-outline-secondary" type="submit" name="search">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-left">
                <!-- Form untuk mencatat atau mengedit peminjaman -->
                <div class="card">
                    <div class="card-header">Pinjam Buku</div>
                    <div class="card-body">
                        <?php
                        if ($error) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        if ($sukses) {
                            echo "<div class='alert alert-success'>$sukses</div>";
                        }
                        if ($warning) {
                            echo "<div class='alert alert-warning'>$warning</div>";
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="mb-3 row">
                                <label for="judul_buku" class="col-sm-3 col-form-label">Judul Buku</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                                        value="<?php echo $judul_buku; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="penulis_buku" class="col-sm-3 col-form-label">Penulis Buku</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="penulis_buku" name="penulis_buku"
                                        value="<?php echo $penulis_buku; ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="pinjam" class="btn btn-primary">Pinjam Buku</button>
                                <a href="loading.php" class="btn btn-danger ms-2">Kembali Ke Home</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Menampilkan Data Pencarian Buku -->
                <div class="card mt-5">
                    <div class="card-header bg-secondary text-white">Daftar Buku</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $sql = "SELECT * FROM library_system WHERE status != 'Dipinjam'";

                                 // Tambahkan filter jika pencarian diisi
                                 if (!empty($search_query_judul)) {
                                     $sql .= " AND nama_buku LIKE '%" . mysqli_real_escape_string($koneksi, $search_query_judul) . "%'";
                                 }

                                 if (!empty($search_query_penulis)) {
                                     $sql .= " AND penulis LIKE '%" . mysqli_real_escape_string($koneksi, $search_query_penulis) . "%'";
                                 }

                                 $query = mysqli_query($koneksi, $sql);
                                 $no = 1;
                                 while ($row = mysqli_fetch_array($query)) {
                                     echo "<tr>
                                             <td>" . $no++ . "</td>
                                             <td>{$row['nama_buku']}</td>
                                             <td>{$row['penulis']}</td>
                                             <td>
                                                 <button class='btn btn-primary' onclick='autoFillForm(\"{$row['nama_buku']}\", \"{$row['penulis']}\")'>Pinjam</button>
                                             </td>
                                           </tr>";
                                 }
                                 ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>

             <div class="col-md-6 col-right">
                 <div class="card">
                     <div class="card-header bg-info text-white">History of Borrowed Books, <?php echo $_SESSION['username'].' - ';?>
                     <a href="signout.php">sign-out</a></div>
                     <div class="card-body">
                         <table class="table">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>Judul Buku</th>
                                     <th>Penulis Buku</th>
                                     <th>Tanggal Pinjam</th>
                                     <th>Tanggal Kembali</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                 $username = $_SESSION['username'];
                                 $sql3 = "SELECT * FROM peminjaman WHERE username = '$username' ORDER BY id DESC";
                                 $q3 = mysqli_query($koneksi, $sql3);
                                 $no = 1;
                                 while ($r3 = mysqli_fetch_array($q3)) {
                                     echo "<tr>
                                             <td>" . $no++ . "</td>
                                             <td>{$r3['judul_buku']}</td>
                                             <td>{$r3['penulis_buku']}</td>
                                             <td>{$r3['tanggal_pinjam']}</td>
                                             <td>{$r3['tanggal_kembali']}</td>
                                           </tr>";
                                 }
                                 ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <script>
         function autoFillForm(judul, penulis) {
             document.getElementById('judul_buku').value = judul;
             document.getElementById('penulis_buku').value = penulis;
         }

         document.getElementById('tanggal_pinjam').addEventListener('change', function () {
             let tanggalPinjam = new Date(this.value); // Ambil tanggal pinjam
             if (!isNaN(tanggalPinjam)) { // Pastikan input valid
                 tanggalPinjam.setDate(tanggalPinjam.getDate() + 7); // Tambahkan 7 hari
                 let dd = String(tanggalPinjam.getDate()).padStart(2, '0');
                 let mm = String(tanggalPinjam.getMonth() + 1).padStart(2, '0'); // Januari adalah 0!
                 let yyyy = tanggalPinjam.getFullYear();
                 let tanggalKembali = yyyy + '-' + mm + '-' + dd;
                 document.getElementById('tanggal_kembali').value = tanggalKembali;
             }
         });
     </script>
</body>

</html>
