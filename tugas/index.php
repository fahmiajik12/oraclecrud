<?php
require './config/koneksi.php';
cek_login();
?>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CRUD Data Obat</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap template -->
  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./index.php">CRUD Data Obat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link active" href="./index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./satuan.php">Satuan</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./jenis.php">Jenis</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./obat.php">Obat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <main class="container my-3">
    <div class="card">
      <h5 class="card-header">CRUD Data Obat</h5>
      <div class="card-body">
        <h5 class="card-title">Aplikasi pengelolaan data obat</h5>
        <p class="card-text">Dalam aplikasi ini terdapat fitur autentikasi, dan beberapa tabel di antaranya tabel Satuan, Jenis, dan tabel obat.</p>
      </div>
    </div>
  </main>

  <div class="footer bg-info text-light py-3 mt-3">
    <div class="container">
      <p class="m-0">Copyright &copy 2025</p>
    </div>
  </div>

  <script src="./bootstrap/jquery-3.6.0.js"></script>
  <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
