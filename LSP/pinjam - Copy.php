<?php
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
$search_query = "";

// Cek apakah ada pencarian
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $tanggal_pinjam = $_GET['tanggal_pinjam'] ?? '';
    $tanggal_kembali = $_GET['tanggal_kembali'] ?? '';
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

// Update Data
if (isset($_POST['simpan'])) {
    $judul_buku = $_POST['judul_buku'];
    $penulis_buku = $_POST['penulis_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    if ($judul_buku && $penulis_buku && $tanggal_pinjam && $tanggal_kembali) {
      if (isset($_GET['op']) && $_GET['op'] == 'edit') {
            $id = $_GET['id'];
            $sql1 = "UPDATE peminjaman SET judul_buku = '$judul_buku', penulis_buku = '$penulis_buku', tanggal_pinjam = '$tanggal_pinjam', tanggal_kembali = '$tanggal_kembali' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
           }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }

}

// Menambah Data Baru
if (isset($_POST['pinjam'])) {
    $judul_buku = $_POST['judul_buku'];
    $penulis_buku = $_POST['penulis_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    // Validasi durasi peminjaman
    $tanggal_pinjam_date = new DateTime($tanggal_pinjam);
    $tanggal_kembali_date = new DateTime($tanggal_kembali);
    $interval = $tanggal_pinjam_date->diff($tanggal_kembali_date);

    if ($interval->days > 7) {
        $warning = "Durasi peminjaman tidak boleh lebih dari 7 hari.";
    } else {
        $check_sql = "SELECT * FROM peminjaman WHERE judul_buku = '$judul_buku' AND penulis_buku = '$penulis_buku' AND tanggal_kembali IS NULL";
        $check_query = mysqli_query($koneksi, $check_sql);

        if (mysqli_num_rows($check_query) > 0) {
            $error = "Buku ini sudah dipinjam. Harap kembalikan sebelum meminjam lagi.";
        } else {
            $sql1 = "INSERT INTO peminjaman (judul_buku, penulis_buku, tanggal_pinjam, tanggal_kembali) VALUES ('$judul_buku', '$penulis_buku', '$tanggal_pinjam', '$tanggal_kembali')";
            $q1 = mysqli_query($koneksi, $sql1);

            if ($q1) {
                $sukses = "Peminjaman berhasil dicatat.";
            } else {
                $error = "Gagal mencatat peminjaman.";
            }
        }
    }
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
                        <input type="text" class="form-control" placeholder="Search by Judul Buku, Penulis buku"
                            name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                        <input type="date" class="form-control" name="tanggal_pinjam"
                            value="<?php echo $tanggal_pinjam; ?>" placeholder="Tanggal Pinjam">
                        <input type="date" class="form-control" name="tanggal_kembali"
                            value="<?php echo $tanggal_kembali; ?>" placeholder="Tanggal Kembali">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-left">
                <!-- Form untuk mencatat atau mengedit peminjaman -->
                <div class="card">
                    <div class="card-header">Cari Buku</div>
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
                                        value="<?php echo $penulis_buku; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_pinjam" class="col-sm-3 col-form-label">Tanggal Pinjam</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                                        value="<?php echo $tanggal_pinjam; ?>" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_kembali" class="col-sm-3 col-form-label">Tanggal Kembali</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                        value="<?php echo $tanggal_kembali; ?>" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                    name="<?php echo isset($_GET['op']) && $_GET['op'] == 'edit' ? 'simpan' : 'pinjam'; ?>"
                                    class="btn btn-primary">Simpan</button>
                                <a href="loading.php" class="btn btn-danger ms-2">Kembali Ke Home</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Menampilkan Data Peminjaman -->
                <div class="card mt-5">
                    <div class="card-header bg-secondary text-white">Data Peminjaman Buku</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql2 = "SELECT * FROM peminjaman WHERE 
                                    (judul_buku LIKE '%$search_query%' OR penulis_buku LIKE '%$search_query%') AND 
                                    (tanggal_pinjam LIKE '%$tanggal_pinjam%' AND tanggal_kembali LIKE '%$tanggal_kembali%')
                                    ORDER BY id DESC";
                                $q2 = mysqli_query($koneksi, $sql2);
                                $no = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    echo "<tr>
                                            <td>" . $no++ . "</td>
                                            <td>{$r2['judul_buku']}</td>
                                            <td>{$r2['penulis_buku']}</td>
                                            <td>{$r2['tanggal_pinjam']}</td>
                                            <td>{$r2['tanggal_kembali']}</td>
                                            <td>
                                                <a href='pinjam.php?op=edit&id={$r2['id']}' class='btn btn-warning'>Pinjam</a>
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
                    <div class="card-header bg-info text-white">History of Borrowed Books</div>
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
                                $sql3 = "SELECT * FROM peminjaman WHERE tanggal_kembali IS NOT NULL ORDER BY id DESC";
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
</body>

</html>