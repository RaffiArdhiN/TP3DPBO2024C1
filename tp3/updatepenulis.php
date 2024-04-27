<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Buku.php');
include('classes/Template.php');

// Inisialisasi objek Penulis
$penulis = new Penulis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penulis->open();
$penulis->getPenulis();

$penulisData = null;

// Jika formulir disubmit
if (isset($_POST['btn-submit'])) {
    
    $data = [
        'id_penulis' => $_POST['id_penulis'],
        'nama_penulis' => $_POST['nama_penulis']
    ];

    $result = $penulis->updatePenulis($_POST['id_penulis'], $data);
    // if ($result) {
        header("Location: index.php");
        exit;
    // } else {
    //     echo "Gagal memperbarui data penulis!";
    // }
}

// Jika ID penulis yang akan diupdate disertakan di URL
if (isset($_GET['id'])) {
    $id_penulis = $_GET['id'];
    // Mendapatkan data penulis berdasarkan ID penulis
    $penulis->getPenulisById($id_penulis);
    $row = $penulis->getResult();

    // Jika data penulis ditemukan
    if ($row) {
        // Buat instance template
        $home = new Template('templates/skineditpenulis.html');

        // Simpan data penulis ke dalam template untuk ditampilkan dalam form
        $home->replace('ID_PENULIS_BROO', $row['id_penulis']);
        $home->replace('NAMA_PENULIS', $row['nama_penulis']);
        $home->write();
    } else {
        // Jika data penulis tidak ditemukan, tampilkan pesan error
        echo "Data penulis tidak ditemukan!";
    }
}

// Tutup koneksi database
$penulis->close();
