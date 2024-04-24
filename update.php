<?php  
include "./koneksi.php";

if (isset($_GET['foto_id'])) {
    $foto_id = $_GET['foto_id'];

    $query = mysqli_query($koneksi, "SELECT * FROM `foto` WHERE `foto_id` = $foto_id LIMIT 1");
    $foto = mysqli_fetch_assoc($query);

    if (!$foto) {
        echo "<script>alert('Foto tidak ditemukan')</script>";
        exit; // Hentikan eksekusi jika foto tidak ditemukan
    }

    if (isset($_POST['submit'])){
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        
        if ($_FILES['lokasi_file']['size'] > 0){ // Periksa apakah file diunggah
            $filename = uniqid(). "_" . $_FILES['lokasi_file']['name'];
    
            move_uploaded_file($_FILES['lokasi_file']['tmp_name'], './foto/' . $filename);
        } else {
            $filename = $foto['lokasi_file'];
        }
    
        $query_update = mysqli_query($koneksi, "UPDATE `foto` SET `judul_foto` = '$judul', `deskripsi_foto` = '$deskripsi', `lokasi_file` = '$filename' WHERE foto_id = $foto_id ");   
    
        if($query_update){
            header('Location: index.php');
        } else {
            echo "<script>alert('Gagal update')</script>";
        }
    }
} else {
    echo "<script>alert('Parameter foto_id tidak ditemukan')</script>";
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

    <title>UPDATE</title>
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
<form action="" method="post" enctype="multipart/form-data">
<div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <h1 class="card-title text-center">UPDATE</h1>
        </div>
        <div class="card-text">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control" value="<?= $foto['judul_foto'] ?>" required>
            </div>
            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <input type="text" name="deskripsi" class="form-control" value="<?= $foto['deskripsi_foto'] ?>" required>
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
    </form>
</body>
</html>
