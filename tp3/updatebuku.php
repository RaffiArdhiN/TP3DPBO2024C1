<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Buku.php');
include('classes/Template.php');

// Inisialisasi objek Buku
$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

// Inisialisasi objek Penulis
$penulis = new Penulis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penulis->open();
$penulis->getPenulis();

// Inisialisasi objek Penerbit
$penerbit = new Penerbit($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penerbit->open();
$penerbit->getPenerbit();

$penulisData = null;
$penerbitData = null;

// Mendapatkan data penulis dan penerbit untuk ditampilkan pada form
while ($nulis = $penulis->getResult()) {
    $penulisData .= '<option value="' . $nulis['id_penulis'] . '">' . $nulis['nama_penulis'] . '</option>';
}

while ($nerbit = $penerbit->getResult()) {
    $penerbitData .= '<option value="' . $nerbit['id_penerbit'] . '">' . $nerbit['nama_penerbit'] . '</option>';
}

// Jika formulir disubmit
if (isset($_POST['btn-submit'])) {
    
    $data = [
        'id_buku' => $_POST['id_buku'],
        'judul_buku' => $_POST['judul_buku'],
        'harga_buku' => $_POST['harga_buku'],
        'id_penulis' => $_POST['id_penulis'],
        'id_penerbit' => $_POST['id_penerbit']
    ];

    $result = $buku->updateData($_POST['id_buku'], $data);
    // if ($result) {
        header("Location: index.php");
        exit;
    // } else {
    //     echo "Gagal memperbarui data buku!";
    // }
}

// Jika ID buku yang akan diupdate disertakan di URL
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];
    // Mendapatkan data buku berdasarkan ID buku
    $buku->getBukuById($id_buku);
    $row = $buku->getResult();

    // Jika data buku ditemukan
    if ($row) {
        // Buat instance template
        $home = new Template('templates/skineditbuku.html');
        $penulis->getPenulisById($row['id_penulis']);
        $penulisRow = $penulis->getResult();

        $penerbit->getPenerbitById($row['id_penerbit']);
        $penerbitRow = $penerbit->getResult();

        // Simpan data buku ke dalam template untuk ditampilkan dalam form
        $home->replace('ID_BUKU_YANG_AKAN_DI_UPDATE_DISINI', $row['id_buku']);
        $home->replace('DATA_JUDUL_BUKU', $row['judul_buku']);
        $home->replace('DATA_HARGA_BUKU', $row['harga_buku']);
        $home->replace('DATA_PENULIS', $penulisData);
        $home->replace('DATA_PENERBIT', $penerbitData);
        $home->replace('DATA_PENULIS_2', $penulisRow['nama_penulis']);
        $home->replace('DATA_PENERBIT_2', $penerbitRow['nama_penerbit']);
        $home->write();
    } else {
        // Jika data buku tidak ditemukan, tampilkan pesan error
        echo "Data buku tidak ditemukan!";
    }
}

// Tutup koneksi database
$buku->close();
