<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penerbit.php');
include('classes/Template.php');

// Inisialisasi objek Penerbit
$penerbit = new Penerbit($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penerbit->open();

$penerbitData = null;

// Jika formulir disubmit
if (isset($_POST['btn-submit'])) {
    
    $data = [
        'id_penerbit' => $_POST['id_penerbit'],
        'nama_penerbit' => $_POST['nama_penerbit']
    ];

    $result = $penerbit->updatePenerbit($_POST['id_penerbit'], $data);
    // if ($result) {
        header("Location: index.php");
        exit;
    // } else {
    //     echo "Gagal memperbarui data penerbit!";
    // }
}

// Jika ID penerbit yang akan diupdate disertakan di URL
if (isset($_GET['id'])) {
    $id_penerbit = $_GET['id'];
    // Mendapatkan data penerbit berdasarkan ID penerbit
    $penerbit->getPenerbitById($id_penerbit);
    $row = $penerbit->getResult();

    // Jika data penerbit ditemukan
    if ($row) {
        // Buat instance template
        $home = new Template('templates/skineditpenerbit.html');

        // Simpan data penerbit ke dalam template untuk ditampilkan dalam form
        $home->replace('ID_PENERBIT_BROO', $row['id_penerbit']);
        $home->replace('NAMA_PENERBIT', $row['nama_penerbit']);
        $home->write();
    } else {
        // Jika data penerbit tidak ditemukan, tampilkan pesan error
        echo "Data penerbit tidak ditemukan!";
    }
}

// Tutup koneksi database
$penerbit->close();
?>
