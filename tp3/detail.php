<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

$data = null;

if (isset($_POST['btn-delete'])) {
    $id_buku = $_POST['id_buku'];

    // Menghapus data buku berdasarkan ID
    $result = $buku->deleteData($id_buku);
    if (!$result) {
        // Redirect ke halaman index.php setelah berhasil menghapus data
        header("Location: index.php");
    } else {
        // Tampilkan pesan jika gagal menghapus data
        echo "Gagal menghapus data buku!";
        // header("Location: index.php");
    }
} 

if (isset($_GET['id'])) {
    $id_buku = $_GET['id']; 
    var_dump($id_buku);
    if ($id_buku > 0) {
        $buku->getBukuById($id_buku);
        $row = $buku->getResult();

        // Periksa apakah $row tidak null sebelum mengakses offset
        if ($row) {
            $data .= '<div class="card-header text-center">
            <h3 class="my-0">Detail ' . $row['judul_buku'] . '</h3>
            </div>
            <div class="card-body">
                <div class="row justify-content-center mb-5">
                    <div class="col-9">
                        <div class="card px-3">
                            <table class="table"> 
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['judul_buku'] . '</td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>:</td>
                                    <td>' . $row['harga_buku'] . '</td>
                                </tr>
                                <tr>
                                    <td>Penulis</td>
                                    <td>:</td>
                                    <td>' . $row['nama_penulis'] . '</td>
                                </tr>
                                <tr>
                                    <td>Penerbit</td>
                                    <td>:</td>
                                    <td>' . $row['nama_penerbit'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="updatebuku.php?id=' . $id_buku . '"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                    <!-- Menggunakan form untuk mengirimkan data saat tombol Hapus Data ditekan -->
                    <form class="d-inline-block" method="POST">
                        <input type="hidden" name="id_buku" value="' . $id_buku . '">
                        <button type="submit" class="btn btn-danger" name="btn-delete">Hapus Data</button>
                    </form>
                </div>';
        } else {
            // Tampilkan pesan jika data buku tidak ditemukan
            echo "Data buku tidak ditemukan!";
        }
    }
}

$buku->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_BUKU', $data);
$detail->write();
?>
