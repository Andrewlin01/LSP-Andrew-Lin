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
            width: 1250px;
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
                <form action="index.php?controller=Book&action=index" method="GET">
                    <div class="input-group mb-3">
                        <input type="hidden" name="controller" value="Book">
                        <input type="hidden" name="action" value="index">
                        <input type="text" class="form-control" placeholder="Search by Nama Buku, Penulis, Penerbit Buku, ISBN"
                               name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form to Insert or Edit Data -->
        <div class="card">
            <div class="card-header">
                Silahkan Simpan / Edit Data Buku, <?php echo $_SESSION['username'] ?? 'admin'; ?> - 
                <a href="../view/login.php?controller=Book&action=signout" class="text-danger">sign-out</a>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php elseif (!empty($sukses)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php endif; ?>
                <form action="index.php?controller=Book&action=create" method="POST">
                    <input type="hidden" name="id" value="<?php echo $book['id'] ?? ''; ?>">
                    <div class="mb-3 row">
                        <label for="nama_buku" class="col-sm-2 col-form-label">Nama Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_buku" name="nama_buku"
                                   value="<?php echo htmlspecialchars($book['nama_buku'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penulis" name="penulis"
                                   value="<?php echo htmlspecialchars($book['penulis'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="penerbit_buku" class="col-sm-2 col-form-label">Penerbit Buku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="penerbit_buku" name="penerbit_buku"
                                   value="<?php echo htmlspecialchars($book['penerbit_buku'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="isbn" name="isbn"
                                   value="<?php echo htmlspecialchars($book['isbn'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Tombol Simpan Data -->
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        
                        <!-- Tombol Kembali Ke Home -->
                        <a href="index.php" class="btn btn-danger ms-2">Kembali Ke Home</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (!empty($sukses)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $sukses; ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

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
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Penulis</th>
                            <th scope="col">Penerbit Buku</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php $urut = 1; foreach ($data as $book): ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++; ?></th>
                                    <td><?php echo htmlspecialchars($book['nama_buku']); ?></td>
                                    <td><?php echo htmlspecialchars($book['penulis']); ?></td>
                                    <td><?php echo htmlspecialchars($book['penerbit_buku']); ?></td>
                                    <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                                    <td>
                                    <!-- Update Edit Button with URL -->
                                        <a href="index.php?controller=Book&action=edit&id=<?php echo $book['id']; ?>"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <a href="index.php?controller=Book&action=delete&id=<?php echo $book['id']; ?>"
                                           onclick="return confirm('Yakin mau menghapus buku ini?');"
                                           class="btn btn-danger btn-sm">Delete</a>
                                      

                                        <!-- Ready / Kembalikan actions -->
                                        <?php if (empty($book['statuss'])): ?>
                                            <a>Ready</a>
                                        <?php else: ?>
                                            <a href="index.php?controller=Book&action=return_book&id=<?php echo $book['id']; ?>"
                                               class="btn btn-warning btn-sm">Kembalikan</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data buku.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
