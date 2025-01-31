<?php
require './config/koneksi.php';  // Assuming Oracle connection
cek_login();

// deklarasi variable pesan
$message = false;
$message_status = false;

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $query = "DELETE FROM jenis WHERE id = :id";
  $stmt = oci_parse($conn, $query);
  oci_bind_by_name($stmt, ':id', $id);
  $result = oci_execute($stmt);

  // buat pesan untuk menandakan query berhasil atau tidak
  $message = $result ? "Data berhasil dihapus" : "Data gagal dihapus";
  $message_status = $result;
}
?>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Satuan | CRUD Data Obat</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap template -->

  <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="./index.php">CRUD Data Obat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="./index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="./satuan.php">Satuan</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="./jenis.php">Jenis</a>
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

  <main class="container">
    <?php if ($message) : ?>
      <div class="alert alert-<?= $message_status ? 'success' : 'danger' ?> alert-dismissible fade show mt-2" role="alert">
        <strong><?= $message_status ? 'Berhasil' : 'Gagal' ?></strong> <?= $message ?>
      </div>
    <?php endif; ?>
    <div class="card shadow mt-3">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <label class="h6">Data Jenis</label>
          <a href="./jenis-form.php" class="btn btn-sm btn-info">Tambah</a>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-responsive-md table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Obat</th>
              <th scope="col">Deskripsi</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT pt.*, (SELECT count(*) FROM obat bu WHERE pt.id = bu.jenis_id ) as obat FROM jenis pt";

            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);
            $counter = 0;
            while ($row = oci_fetch_assoc($stmt)) {
              $counter++;
              $row = (object)$row;

              // Read CLOB content if 'DESKRIPSI' is a CLOB object
              if (is_object($row->DESKRIPSI)) {
                $deskripsi_content = $row->DESKRIPSI->load();
              } else {
                $deskripsi_content = $row->DESKRIPSI;
              }

              $btn_edit =  '<a href="./jenis-form.php?edit=' . $row->ID . '" class="btn btn-sm btn-primary">Edit</a>';
              $btn_delete =  '<a href="./jenis.php?delete=' . $row->ID . '" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-sm btn-danger">Hapus</a>';
              echo "<tr>
              <th>$counter</th>
              <td>{$row->NAMA}</td>
              <td>{$row->OBAT}</td>
              <td>{$deskripsi_content}</td>
              <td>$btn_edit  $btn_delete</td>
            </tr>";
            }
            ?>

          </tbody>
        </table>
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