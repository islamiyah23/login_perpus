<?php
session_start();

// Cek login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil data dari session
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];

// Bersihkan tambahan kata "Dewasa" atau "Remaja" dari nama jika ada
$nama = str_ireplace(['Dewasa', 'Remaja'], '', $nama);
$nama = trim($nama);

// Tentukan kategori berdasarkan email
if ($email === 'salsa@gmail.com') {
    $kategori = 'Dewasa';
} elseif ($email === 'elina@gmail.com') {
    $kategori = 'Remaja';
} else {
    $kategori = 'Umum';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            color: #0c4a6e;
        }

        .info-label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Profil Anggota</h2>
    <hr>
    <p><span class="info-label">Nama :</span> <?= htmlspecialchars($nama); ?></p>
    <p><span class="info-label">Email :</span> <?= htmlspecialchars($email); ?></p>
    <p><span class="info-label">Kategori :</span> <?= htmlspecialchars($kategori); ?></p>
    <a href="dashboard.php" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
</div>

</body>
</html>