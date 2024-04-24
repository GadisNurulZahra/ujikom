<?php
include "koneksi.php";

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = md5($_POST['password']);

    $query = mysqli_query($koneksi, "INSERT INTO user (username, nama_lengkap, email, alamat, password) VALUES ('$username', '$nama_lengkap', '$email', '$alamat', '$password')");

    if ($query) {
        echo '<script>alert("Register berhasil, silahkan login"); location.href ="login.php"</script>';
    } else {
        echo '<script>alert("Register gagal")</script>';
    }
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

    <link rel="stylesheet" href="style.css" />

    <title>Registrasi</title>
  </head>
  <body>
    <div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <h3 class="card-title text-center">REGISTRASI</h3>
        </div>
        <div class="card-text">
          <form action="" method="post">
          <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="username" class="form-control" id="username" aria-describedby="username" name="username"/>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"/>
            </div>
            <div class="mb-3">
              <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
              <input type="nama_lengkap" class="form-control" id="nama_lengkap" aria-describedby="nama_lengkap" name="nama_lengkap" />
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea name="alamat" id="" class="form-control" rows="5"></textarea>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password"/>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
          </form>
          <div class="mb-3">
            <p class="text-center">Sudah memiliki akun?<button type="button" class="btn btn-link "><a href="login.php" class="text-success">Login</a></button></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
