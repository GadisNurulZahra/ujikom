<?php
include "koneksi.php";



if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM user where username = '$username' and password = '$password'");

    if(mysqli_num_rows($cek) > 0 ) {
        $data = mysqli_fetch_array($cek);
        $_SESSION['user'] = $data;
        echo '<script>alert("Selamat datang '.$data['nama_lengkap'].'"); 
        location.href ="index.php"</script>';
    } else {
        echo '<script>alert("Username/Password Salah!")</script>';
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

    <title>Login</title>
  </head>
  <body>
    <div class="global-container">
      <div class="card login-form">
        <div class="card-body">
          <h1 class="card-title text-center">L O G I N</h1>
        </div>
        <div class="card-text">
          <form action="" method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="username" class="form-control" id="exampleInputEmail1" aria-describedby="username" name="username" />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" />
            </div>

            <button type="submit" class="btn btn-success" >Submit</button>
          </form>
          <div class="mb-3">
            <p class="text-center">
              Belum memiliki akun?<button type="button" class="btn btn-link"><a href="register.php" class="text-success">Registrasi</a></button>
            </p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
