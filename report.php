<?php
include "proses/connect.php";
date_default_timezone_get('Asia/Jakarta');

// Dapatkan username pelanggan dari session
$username_pelanggan = $_SESSION['username_vienna_coffee'];
$level_user = $_SESSION['level_vienna_coffee'];

// Kueri untuk laporan
$query_sql = "SELECT tb_order.*,tb_bayar.*,nama, SUM(harga*jumlah) AS harganya FROM tb_order
  LEFT JOIN tb_user ON tb_user.id = tb_order.pelayan
  LEFT JOIN tb_list_order ON tb_list_order.kode_order = tb_order.id_order
  LEFT JOIN tb_daftar_menu ON tb_daftar_menu.id = tb_list_order.menu
  JOIN tb_bayar ON tb_bayar.id_bayar = tb_order.id_order";

// Tambahkan kondisi WHERE jika user adalah pelanggan
if ($level_user == 5) { // Jika level adalah pelanggan
  $query_sql .= " WHERE tb_order.pelanggan = '$username_pelanggan'";
}

$query_sql .= " GROUP BY id_order ORDER BY waktu_order DESC";

$query = mysqli_query($conn, $query_sql);


while ($record = mysqli_fetch_array($query)) {
  $result[] = $record;
}

?>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="col-lg-9 mt-2">
  <div class="card">
    <div class="card-header">
      Halaman Laporan
    </div>


    <?php
    if (empty($result)) {
      echo "Data laporan tidak ada"; // Ubah pesan agar lebih sesuai
    } else {
      foreach ($result as $row) {
    ?>


      <?php
      }
      ?>


      <?php

      ?>
      <div class=" table-responsive mt-2">
        <table class="table table-hover" id="example">
          <thead>
            <tr class="text-nowrap">
              <th scope="col">No</th>
              <th scope="col">Kode Order</th>
              <th scope="col">Waktu Order</th>
              <th scope="col">Waktu Bayar</th>
              <th scope="col">Pelanggan</th>
              <th scope="col">Meja</th>
              <th scope="col">Total Harga</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            foreach ($result as $row) {
            ?>
              <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td> <?php echo $row['id_order'] ?></td>
                <td> <?php echo $row['waktu_order'] ?></td>
                <td> <?php echo $row['waktu_bayar'] ?></td>
                <td> <?php echo $row['nama'] ?></td>
                <td> <?php echo $row['meja'] ?> </td>
                <td> <?php echo number_format((int)$row['harganya'], 0, ',', '.')  ?> </td>
                <td>
                  <div class="d-flex">
                    <a class="btn btn-primary btn-sm me-1" href="./?x=viewitem&order=<?php echo $row['id_order'] . "&meja=" . $row['meja'] . "&pelanggan=" . $row['pelanggan'] ?>"><i class="bi bi-eye"></i></a>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>




  </div>
</div>
</div>