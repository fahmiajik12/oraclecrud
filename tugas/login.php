<?php
require './config/koneksi.php';

if (isset($_SESSION["login"]) ? $_SESSION["login"] : false) {
  header("Location: index.php");
  exit;
}

$errorUser = false;
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Query ke database Oracle untuk memeriksa username dan password
  $conn = getDbConnection();  // Memanggil fungsi untuk mendapatkan koneksi ke Oracle
  $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
  
  // Persiapkan statement
  $stmt = oci_parse($conn, $sql);

  // Binding parameter untuk mencegah SQL injection
  oci_bind_by_name($stmt, ':username', $username);
  oci_bind_by_name($stmt, ':password', $password);

  // Eksekusi query
  oci_execute($stmt);

  // Periksa apakah ada hasil yang ditemukan
  if (oci_fetch_row($stmt)) {
    $_SESSION['login'] = true;
    header("Location: index.php");
    exit;
  } else {
    $errorUser = true;
  }
}

?>

<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <style>
    .login-form {
      width: 340px;
      margin: 50px auto;
      font-size: 15px;
    }

    .login-form form {
      margin-bottom: 15px;
      background: #f7f7f7;
      box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
      padding: 30px;
    }

    .login-form h2 {
      margin: 0 0 15px;
    }

    .form-control,
    .btn {
      min-height: 38px;
      border-radius: 2px;
    }

    .btn {
      font-size: 15px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="login-form">
    <?php if ($errorUser) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal</strong> Password atau username salah
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>
    <form action="" method="post">
      <h6 class="text-center">Aplikasi pengelolaan data obat</h6>
      <h3 class="text-center">Log in</h3>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username" value="<?= @$_POST['username'] ?>" required="required">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" value="<?= @$_POST['password'] ?>" required="required">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block" name="login">Log in</button>
      </div>
    </form>
  </div>
</body>

</html>
