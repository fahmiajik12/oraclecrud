<?php
require './config/koneksi.php';
cek_login();

// deklarasi variable pesan
$message = false;
$message_status = false;
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  // Query untuk menghapus data di Oracle
  $sql = "DELETE FROM satuan WHERE id = :id";
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":id", $id);

  // Eksekusi query
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
  <!-- Bootstrap CDN -->
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
          <a class="nav-link" href="./index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" href="./satuan.php">Satuan</a>
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

  <main class="container">
    <?php if ($message) : ?>
      <div class="alert alert-<?= $message_status ? 'success' : 'danger' ?> alert-dismissible fade show mt-2" role="alert">
        <strong><?= $message_status ? 'Berhasil' : 'Gagal' ?></strong> <?= $message ?>
      </div>
    <?php endif; ?>
    <div class="card shadow mt-3">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <label class="h6">Data Satuan</label>
          <a href="./satuan-form.php" class="btn btn-sm btn-info">Tambah</a>
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
            $query = "SELECT ps.*, 
                                (SELECT COUNT(*) FROM obat bu WHERE ps.id = bu.satuan_id) as obat 
                        FROM satuan ps";
                $stmt = oci_parse($conn, $query);
                oci_execute($stmt);

                $counter = 0;
                while ($row = oci_fetch_assoc($stmt)) {
                $counter++;
                $row = (object)$row;

                // Jika kolom 'deskripsi' merupakan CLOB, gunakan oci_lob_read untuk mengambil data
                if (is_a($row->DESKRIPSI, 'OCILob')) {
                    $row->DESKRIPSI = oci_lob_read($row->DESKRIPSI, oci_lob_size($row->DESKRIPSI));
                }

                $btn_edit =  '<a href="./satuan-form.php?edit=' . $row->ID . '" class="btn btn-sm btn-primary">Edit</a>';
                $btn_delete =  '<a href="./satuan.php?delete=' . $row->ID . '" onclick="return confirm(\'Apakah anda yakin?\')" class="btn btn-sm btn-danger">Hapus</a>';
                echo "<tr>
                <th>$counter</th>
                <td>{$row->NAMA}</td>
                <td>{$row->OBAT}</td>
                <td>{$row->DESKRIPSI}</td>
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
      <p class="m-0">Copyright &copy 2025 </p>
    </div>
  </div>

  <!-- jQuery, Popper.js, and Bootstrap JS CDN -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy2QxM4cA7bPpWl1L1vLDh6Uco5x9yFH7h4/5eQp" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0p3Qfuf5PUbqA2rZ3gs8+FjhTj3ns+WBf9FqH3p6GhE1hGtr" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0p3Qfuf5PUbqA2rZ3gs8+FjhTj3ns+WBf9FqH3p6GhE1hGtr" crossorigin="anonymous"></script>
</body>

</html>
