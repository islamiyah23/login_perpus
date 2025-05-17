<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_pengguna'])) {
    header("Location: ./login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5fff7;
        }

        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            background-color: #a8d5ba;
            padding-top: 20px;
            color: white;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #8ec6a5;
        }

        .content {
            margin-left: 230px;
            padding: 20px;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            background-color: #b5e7c0;
            color: #2e4e34;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .card-title {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center">Perpustakaan</h4>
        <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
        <a href="profil.php"><i class="fas fa-user"></i> Profil</a>
        <a href="buku.php"><i class="fas fa-book"></i> Daftar Buku</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-text ms-auto">
                    Selamat datang, <strong><?php echo $_SESSION['nama_pengguna']; ?></strong>
                </span>
            </div>
        </nav>

        <?php
        $total_buku_sql = "SELECT COUNT(*) as total FROM buku";
        $total_buku_result = $conn->query($total_buku_sql);
        $total_buku_row = $total_buku_result->fetch_assoc();
        $total_buku = $total_buku_row['total'];
        ?>

        <div class="container mt-4">
            <h2>Dashboard Anggota</h2>
            <div class="row mt-4">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-book-open"></i> Total Buku</h5>
                            <p class="card-text fs-4"><?php echo $total_buku; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
