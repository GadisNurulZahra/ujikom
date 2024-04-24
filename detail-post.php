<?php
include "./koneksi.php";

$foto_id = $_GET['foto_id'];

$query = mysqli_query($koneksi, "SELECT * FROM foto WHERE foto_id = $foto_id LIMIT 1");
$row = mysqli_fetch_assoc($query);

$komentar_query = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id = $foto_id");

function jumlah_like($foto_id){
    global $koneksi;
    $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_like FROM like_foto WHERE foto_id = $foto_id ");
    $row = mysqli_fetch_assoc($q);
    return $row['jumlah_like'];
}

function jumlah_komentar($foto_id){
    global $koneksi;
    $r = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_komentar FROM komentar_foto WHERE foto_id = $foto_id ");
    $row = mysqli_fetch_assoc($r);
    return $row['jumlah_komentar'];
}

function getKomentar($foto_id){
    global $koneksi;
    $s = mysqli_query($koneksi, "SELECT * FROM komentar_foto WHERE foto_id = $foto_id ");
    return mysqli_fetch_assoc($s);
}

function nama_user($user_id){
    global $koneksi;
    if (!$user_id){
        return 'anonym';
    }
    $r = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = $user_id ");
    $row = mysqli_fetch_assoc($r);
    return $row['username'];
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">

    <title>Galery Foto</title>
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

  <div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-5 col-sm-6">
            <div class="card" style="background-color: #50727B;">
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 25px;">
                        <div style="display: flex; flex-direction: column; border: 1 solid black; border-radius: 6px; width: 100%;">
                        <h3>
                    Pemilik:
                    <a  href="./user.php?user_id=<?= $row['user_id'] ?>" class="text-dark">
                        <?= nama_user($row['user_id']) ?>
                    </a>
                </h3>
                <p>Tanggal unggah: <?php echo $row['tanggal_unggah']; ?></p>
                <p><b>Judul: <?php echo $row['judul_foto']; ?></b></p>
                  <p>Deskripsi: <?php echo $row['deskripsi_foto']; ?></p>
                            <img src="./foto/<?php echo $row['lokasi_file']; ?>" alt="" style="width: 100%; border-radius: 10px " />
                            <div class="mt-2" style="display:flex; align-items: center; gap: 20px;">
                                <a href="./like.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAQpJREFUSEvV1b0uRUEQwPHfVSl1GiQ0vnqeQSs6vRfQ+ahIiMILaJUSjRfQiZ7QCaVSIdFgElfWidhz7t0tbHmy+//P7OzM6am8epX5ugo2sY1DHLUJrotgHacJdBoPOUlbwQouMJIAp/BUQrCEy89rGU1gAQ5BduUymMUVxhqkfexm6WSL/IjJX0DzuOsqWENEFlH3M3tvA2nsuccOzuJ7ekU3WPjaPIwgELdYbArSaIcVfLPTDP6VIBowGvFHDUpmECPluJbgBeN4rSU4wFb/6ZYu8hsm8FxLcIKNtPFKZhCPZKY5wkt28jlWm6MlFcQs2sPcgLNoGdd/CQaYa/kjuf9BnpDZUV3wAUmENRkde5ahAAAAAElFTkSuQmCC"/><?= jumlah_like($row['foto_id']) ?></a>
                                <a href=""><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKVJREFUSEvllDEOwjAMRV/O0anqwm16GZZu7caJOAgLW8XAPYBURDJVBBa2lzZbhvyX/239RPBJwfpIQA+cgIMRegWOwDnrSMAdaIzi5fkMdGvAw0m8yCyflw62CdBuWc29KqJwgGXuKgfhgG8R/do6lYNwQHhE+wXcgDaqiy7AUKtruXbTiz5aBvBRqe9LAbiJ1yJyFV8DciQuschotW359zjCAU+JNSEZDLM0zgAAAABJRU5ErkJggg=="/><?= jumlah_komentar($row['foto_id']) ?></a>

                                <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id'] == $row['user_id']) : ?>
                    
                                <a href="./update.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAThJREFUSEvl1b1KxEAUhuFnK7HSSgTBQgQt9AYsrO28A6/AUlErFWT97fQWbLW1F7wBsRNBEMRC0M5K3QNZiMlmmUS38kBIQma+d853zmRaBhytAev7S8AxXnCSX3QRsIwDzPbJ7BMrOM+NOcVq9r6ehxQBT5ioKT6GW8S9G1vZQksWfWUjUq0bxRumcY3xbP4GjuK5KFQHsIa4FjqWPWAKN9jDWTeVpoBN7Gciz1jEPUbw3q/IKRmEv+1CnQIyj9di/epmEJZEOxYjWjO6pxR1AKniS7iqW4MdbCesPMQvMVwHEMIBSLHlo1P8oXx3pljULXweUOV5qUmaACKb3Yrd/mvAj/9MD0gjQJ9fU+nTPwA8YrKOJz3G3mGuah/EgXOImYaQOBeiyy6qAA11q6elHiyNwQMHfAOdL0QZH51cjgAAAABJRU5ErkJggg=="/></a>
                                <a onclick="return confirm('Yakin ingin menghapus?')" href="./delete.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKVJREFUSEvtlbERgzAMRZ8LNqFKVmAMhmAI+oyQyw6ZIQPQwx2zUJBzkcA5CAkfTgMubfk/6duWHYmHS6yPBVABdyERv/ZYS1IDFMALyASRAfAxjQQJAeNOln11/w7YqYBJRjqDWKt+9I4B+FQZ2rY0H2XRCVi8+nO/T4sOYNGWBmh+aC1w2aIMdMA13CM1uxK4AbkR0gM18LQCjLp6mPYn6wpKxBs0qysZAkh0fgAAAABJRU5ErkJggg=="/></a>
                                <?php endif ; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="./create-komentar.php" method="post" class="mt-3" style="display: flex; flex-direction: column;  border-radius: 6px; max-width: 400px; margin: 0 auto; width: 100%; background-color: #50727B;">
    <label for="isi_komentar">Komentar</label>
    <input type="hidden" name="foto_id" value="<?= $row['foto_id'] ?>">
    <input type="text" name="isi_komentar" placeholder="Isi komentar">
    <button type="submit" name="submit"  class="btn btn-primary">Kirim</button>
</form>

<div class="mt-3" style="display: flex; flex-direction: column; border: 1px solid black; border-radius: 6px; max-width: 400px; margin: 0 auto; width: 100%; background-color: #50727B; padding:20px;">
    <h3 style="text-align: center;">Komentar</h3>
    <?php while ($komentar = mysqli_fetch_assoc($komentar_query)) : ?>
        <div>
        <h5><?php echo nama_user($komentar['user_id']); ?></h5>
            <p><?php echo $komentar['tanggal_komentar']; ?></p>
            <p><?php echo $komentar['isi_komentar']; ?></p>
        </div>
    <?php endwhile ?>    
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
