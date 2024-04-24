<?php
include "./koneksi.php";
if (empty($_SESSION['user'])) {
  header('location:login.php');
}  

if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $user_id = $_SESSION['user']['user_id'];
    $tanggal_unggah = date('Y-m-d');

    // Pastikan ada file yang diunggah
    if (isset($_FILES['lokasi_file']) && $_FILES['lokasi_file']['error'] === UPLOAD_ERR_OK) {
        $tmp_file = $_FILES['lokasi_file']['tmp_name'];
        $nama_file = uniqid(). "_". $_FILES['lokasi_file']['name'];

        move_uploaded_file($tmp_file, './foto/' . $nama_file);

        // Perbaiki nama kolom yang sesuai dengan struktur tabel
        $query = mysqli_query($koneksi, "INSERT INTO `foto` VALUES ('', '$judul', '$deskripsi', '$tanggal_unggah', '$nama_file', '$user_id')");

        if ($query) {
            header('Location: index.php');
        } else {
            echo "<script>alert('Upload gagal')</script>";
        }
    } else {
        echo "<script>alert('File tidak diunggah atau terjadi kesalahan saat mengunggah')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

<link rel="stylesheet" href="style.css" />

    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-success">
      <div class="container">
        <a class="navbar-brand" href="./index.php">Galery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          
          <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['user_id'])) : ?>
              <a class="nav-link active" aria-current="page" href="./insert.php">Uplod</a>
              <a class="nav-link active" aria-current="page" href="./profile.php">Profile</a>
              <a class="nav-link active" aria-current="page" href="./logout.php">Logout</a>
                    
            <?php else : ?>
              <a class="nav-link active" aria-current="page" href="login.php">Login</a>
              <a class="nav-link active" aria-current="page" href="register.php">Registrasi</a>
            <?php endif ; ?>

          </ul>
        </div>
      </div>
    </nav>
    
    <div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <h1 class="card-title text-center">Tambah</h1>
        </div>
        <div class="card-text">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control">
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <input type="text" name="deskripsi" class="form-control">
            </div>
            <div class="mb-3">
              <label for="lokasi_file" class="form-label">Lokasi File</label>
              <input type="file" name="lokasi_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success" name="submit" >Submit</button>
          </form>
        </div>
      </div>
    </div>
</body>
</html>
