<?php 
include "./koneksi.php";


$user_id= $_GET['user_id'];

if (!isset($user_id)) {
    header('Location: index.php');
}

if (isset($_SESSION['user']) && $user_id == $_SESSION['user']['user_id']) {
    header('Location: profile.php');
}

$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE user_id = $user_id LIMIT 1");

$query_postingan = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id = $user_id ORDER BY user_id ASC");

$user = mysqli_fetch_assoc($query_user);

function jumlah_like($foto_id){
    global $koneksi;
    $foto_id = mysqli_real_escape_string($koneksi, $foto_id); // Melakukan sanitasi input
    $q = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_like FROM like_foto WHERE foto_id = '$foto_id'");
    $row = mysqli_fetch_assoc($q);
    return $row['jumlah_like'];
  }
  
  function jumlah_komentar($foto_id){
    global $koneksi;
    $foto_id = mysqli_real_escape_string($koneksi, $foto_id); // Melakukan sanitasi input
    $r = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah_komentar FROM komentar_foto WHERE foto_id = '$foto_id'");
    $row = mysqli_fetch_assoc($r);
    return $row['jumlah_komentar'];
  }
  ?>
  
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
      <title>User</title>
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
        <h2 style="text-align:center;" class="text-primary">User Profile</h2>
      <div style="display: flex; flex-direction: column; max-width: 210px; height: 190px; border: 1px solid black; margin: -0 auto; padding-left: 16px;  background-color: #50727B;">
          <p>
            Username:
            <?php echo $user['username']; ?>
          </p>
          <p>
            Email:
            <?php echo $user['email']; ?>
          </p>
          <p>
            Nama lengkap:
            <?php echo $user['nama_lengkap']; ?>
          </p>
          <p>
            Alamat:
            <?php echo $user['alamat']; ?>
          </p>
         
        </div>
      </div>
  
      <div style="display: flex; gap: 20px; flex-direction: column; max-width: 400px; margin: -0 auto; margin-top: 20px">
        <?php while ($row = mysqli_fetch_assoc($query_postingan)): ?>
        <div style="padding: 16px; background-color: #50727B; ">
          <div style="display: flex; flex-direction: column;  max-width: 400px">
          
          <p>Tanggal unggah: <?php echo $row['tanggal_unggah']; ?></p>
            <p><b>Judul: <?php echo $row['judul_foto']; ?></b></p>
            <p>Deskripsi: <?php echo $row['deskripsi_foto']; ?></p>
            <img src="./foto/<?php echo $row['lokasi_file']; ?>" alt="" style="width: 100%" />
            <div class="mt-2" style="display: flex; align-items: center; gap: 20px">
            <a href="./like.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAQpJREFUSEvV1b0uRUEQwPHfVSl1GiQ0vnqeQSs6vRfQ+ahIiMILaJUSjRfQiZ7QCaVSIdFgElfWidhz7t0tbHmy+//P7OzM6am8epX5ugo2sY1DHLUJrotgHacJdBoPOUlbwQouMJIAp/BUQrCEy89rGU1gAQ5BduUymMUVxhqkfexm6WSL/IjJX0DzuOsqWENEFlH3M3tvA2nsuccOzuJ7ekU3WPjaPIwgELdYbArSaIcVfLPTDP6VIBowGvFHDUpmECPluJbgBeN4rSU4wFb/6ZYu8hsm8FxLcIKNtPFKZhCPZKY5wkt28jlWm6MlFcQs2sPcgLNoGdd/CQaYa/kjuf9BnpDZUV3wAUmENRkde5ahAAAAAElFTkSuQmCC"/><?= jumlah_like($row['foto_id']) ?></a>


            <a href="./detail-post.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKVJREFUSEvllDEOwjAMRV/O0anqwm16GZZu7caJOAgLW8XAPYBURDJVBBa2lzZbhvyX/239RPBJwfpIQA+cgIMRegWOwDnrSMAdaIzi5fkMdGvAw0m8yCyflw62CdBuWc29KqJwgGXuKgfhgG8R/do6lYNwQHhE+wXcgDaqiy7AUKtruXbTiz5aBvBRqe9LAbiJ1yJyFV8DciQuschotW359zjCAU+JNSEZDLM0zgAAAABJRU5ErkJggg=="/><?= jumlah_komentar($row['foto_id']) ?></a>

            <?php if (!empty($_SESSION['user']) &&  $_SESSION['user']['user_id'] == $row['user_id']) : ?>

              <a onclick="return confirm('Yakin ingin menghapus?')" href="./delete.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAKVJREFUSEvtlbERgzAMRZ8LNqFKVmAMhmAI+oyQyw6ZIQPQwx2zUJBzkcA5CAkfTgMubfk/6duWHYmHS6yPBVABdyERv/ZYS1IDFMALyASRAfAxjQQJAeNOln11/w7YqYBJRjqDWKt+9I4B+FQZ2rY0H2XRCVi8+nO/T4sOYNGWBmh+aC1w2aIMdMA13CM1uxK4AbkR0gM18LQCjLp6mPYn6wpKxBs0qysZAkh0fgAAAABJRU5ErkJggg=="/></a>
              <a href="./update.php?foto_id=<?= $row['foto_id'] ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAThJREFUSEvl1b1KxEAUhuFnK7HSSgTBQgQt9AYsrO28A6/AUlErFWT97fQWbLW1F7wBsRNBEMRC0M5K3QNZiMlmmUS38kBIQma+d853zmRaBhytAev7S8AxXnCSX3QRsIwDzPbJ7BMrOM+NOcVq9r6ehxQBT5ioKT6GW8S9G1vZQksWfWUjUq0bxRumcY3xbP4GjuK5KFQHsIa4FjqWPWAKN9jDWTeVpoBN7Gciz1jEPUbw3q/IKRmEv+1CnQIyj9di/epmEJZEOxYjWjO6pxR1AKniS7iqW4MdbCesPMQvMVwHEMIBSLHlo1P8oXx3pljULXweUOV5qUmaACKb3Yrd/mvAj/9MD0gjQJ9fU+nTPwA8YrKOJz3G3mGuah/EgXOImYaQOBeiyy6qAA11q6elHiyNwQMHfAOdL0QZH51cjgAAAABJRU5ErkJggg=="/></a>
            <?php endif ; ?>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </body>
  </html>
  