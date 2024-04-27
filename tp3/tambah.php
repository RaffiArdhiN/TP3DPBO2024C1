<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Buku.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

$penulis = new Penulis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penulis->open();
$penulis->getPenulis();

$penerbit = new Penerbit($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penerbit->open();
$penerbit->getPenerbit();

if (isset($_POST['btn-submit'])) {
    // methode mencari data pengurus
    $data = [
        'judul_buku' => $_POST['judul_buku'],
        'harga_buku' => $_POST['harga_buku'],
        'id_penulis' => $_POST['id_penulis'],
        'id_penerbit' => $_POST['id_penerbit']
    ];

    $result = $buku->addData($data);
    header("Location: index.php");
    exit;
}

$penulisData = null;
$penerbitData = null;

while($nulis = $penulis->getResult()) {
    $penulisData .= '<option value="'.$nulis['id_penulis'].'">' .$nulis['nama_penulis'].'</option>';
}

while($nerbit = $penerbit->getResult()) {
    $penerbitData .= '<option value="'.$nerbit['id_penerbit'].'">' .$nerbit['nama_penerbit'].'</option>';
}


// buat instance template
$home = new Template('templates/skinform.html');

// simpan data ke template
$home->replace('DATA_PENULIS', $penulisData);
$home->replace('DATA_PENERBIT', $penerbitData);
$home->write();
