<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['id_pengguna'])) {
    header("Location: ../login.php");
    exit();
}

$email = $_SESSION['email'];
$nama_pengguna = $_SESSION['nama_pengguna'];

$allowed_users = ['elina@gmail.com', 'salsa@gmail.com'];
if (!in_array($email, $allowed_users)) {
    echo "Akses ditolak.";
    exit();
}

// Tambah pengguna
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_pengguna'];
    $email_baru = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO pengguna (nama_pengguna, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email_baru, $password);
    $stmt->execute();
    header("Location: manajemen_pengguna.php");
    exit();
}

// Ambil data untuk edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM pengguna WHERE id_pengguna = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    $user = $result_edit->fetch_assoc();
}

// Proses update pengguna
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_pengguna'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE pengguna SET nama_pengguna=?, email=? WHERE id_pengguna=?");
    $stmt->bind_param("ssi", $nama, $email, $id);
    $stmt->execute();
    header("Location: manajemen_pengguna.php");
    exit();
}

// Proses hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $conn->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manajemen_pengguna.php");
    exit();
}

// Ambil semua pengguna
$result = $conn->query("SELECT * FROM pengguna");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f8e9;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .form-section, .table-section {
            background: #e0f2f1;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-section h4, .table-section h4 {
            color: #00796b;
        }
        .btn-success, .btn-warning, .btn-danger {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-success">Manajemen Anggota Perpustakaan</h1>

    <div class="form-section mt-4">
        <h4><?= isset($user) ? 'Edit Anggota' : 'Tambah Anggota Baru' ?></h4>
        <form method="POST">
            <?php if (isset($user)): ?>
                <input type="hidden" name="id" value="<?= $user['id_pengguna']; ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label for="nama_pengguna" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required value="<?= isset($user) ? $user['nama_pengguna'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?= isset($user) ? $user['email'] : ''; ?>">
            </div>
            <?php if (!isset($user)): ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password (default)</label>
                <input type="text" class="form-control" id="password" name="password" required>
            </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-success" name="<?= isset($user) ? 'update' : 'tambah' ?>">
                <?= isset($user) ? 'Simpan Perubahan' : 'Tambah Anggota' ?>
            </button>
            <?php if (isset($user)): ?>
                <a href="manajemen_pengguna.php" class="btn btn-secondary">Batal</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-section mt-4">
        <h4>Daftar Anggota</h4>
        <table class="table table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pengguna']; ?></td>
                        <td><?= htmlspecialchars($row['nama_pengguna']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td>
                            <a href="?edit=<?= $row['id_pengguna']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?hapus=<?= $row['id_pengguna']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>