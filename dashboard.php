<?php
session_start();
include 'koneksi.php'; // Pastikan file ini ada dan sesuai

// Cek login
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Tentukan kategori berdasarkan email
$kategori = '';
if ($_SESSION['email'] === 'elina@gmail.com') {
    $kategori = 'Remaja';
} elseif ($_SESSION['email'] === 'salsa@gmail.com') {
    $kategori = 'Dewasa';
}

// Simpan ulasan jika dikirim
if (isset($_POST['submit_ulasan'])) {
    $email = $_SESSION['email']; // pastikan email tersimpan di session saat login
    $isi = mysqli_real_escape_string($conn, $_POST['ulasan']);

    $sql = "INSERT INTO ulasan (email, isi_ulasan) VALUES ('$email', '$isi')";
    if ($conn->query($sql)) {
        echo "<script>alert('Ulasan berhasil dikirim!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #e6f0fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            height: 100vh;
            background-color: #b3d9f7;
            padding-top: 20px;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #9cccec;
        }

        .main-content {
            margin-left: 220px;
            padding: 20px;
        }

        .card {
            border: none;
            background-color: #dff1fd;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .card-title {
            font-weight: bold;
            color: #075985;
        }

        .user-info {
            font-size: 1.2em;
            color: #0c4a6e;
        }

        textarea {
            resize: none;
        }

        .btn-primary {
            background-color: #60a5fa;
            border-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #3b82f6;
            border-color: #2563eb;
        }

        .list-group-item {
            background-color: #f0f9ff;
            border: 1px solid #cfe8fc;
        }

        .sidebar {
            height: 100vh;
            width: 100%;
            background-color: #b3d9f7;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .menu-box {
            background-color: #a4ceec;
            border: 2px solid #ffffff;
            border-radius: 10px;
            padding: 30px 20px;
            width: 80%;
            text-align: center;
        }

        .menu-link {
            display: block;
            padding: 10px 15px;
            margin: 10px 0;
            color: #fff;
            background-color: #69a8d9;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .menu-link:hover {
            background-color: #539dcf;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar">
            <div class="menu-box">
                <h4 class="mb-4 text-white">Anggota</h4>
                <a href="dashboard.php" class="menu-link"><i class="fas fa-home"></i> Dashboard</a>
                <a href="profil.php" class="menu-link"><i class="fas fa-user"></i> Profil</a>
                <a href="logout.php" class="menu-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </nav>

        <main class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Dashboard Anggota</h2>
            </div>

            <p class="user-info">Halo, <strong><?php echo htmlspecialchars($_SESSION['nama']); ?></strong>! Anda login sebagai <strong><?php echo $kategori; ?></strong>.</p>

            <div class="row mt-4">
                <!-- Form Ulasan -->
                <div class="col-md-6 mb-4">
                    <div class="card p-3">
                        <h5 class="card-title">Ulasan kritik & saran</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <textarea name="ulasan" rows="4" class="form-control" placeholder="Tulis ulasan Anda tentang perpustakaan..." required></textarea>
                            </div>
                            <button type="submit" name="submit_ulasan" class="btn btn-primary">Kirim Ulasan</button>
                        </form>
                    </div>
                </div>

                <!-- Ulasan Terbaru -->
                <div class="col-md-6 mb-4">
                    <div class="card p-3">
                        <h5 class="card-title">Ulasan Terbaru</h5>
                        <ul class="list-group list-group-flush">
                            <?php
                            $result = $conn->query("SELECT email, isi_ulasan FROM ulasan ORDER BY id DESC LIMIT 5");
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li class='list-group-item'><strong>" . htmlspecialchars($row['email']) . ":</strong> " . htmlspecialchars($row['isi_ulasan']) . "</li>";
                                }
                            } else {
                                echo "<li class='list-group-item'>Belum ada ulasan.</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>