<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Buku.php');
include('classes/Template.php');

// Inisialisasi objek Buku
$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

// Proses pencarian berdasarkan nama buku
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    // Modifikasi query untuk mencari buku berdasarkan nama
    $buku->searchBukuByName($searchTerm);

    // Buat instance template untuk menampilkan hasil pencarian
    $detailView = new Template('templates/skindetail.html');

    $mainTitle = 'Detail Buku';
    $detailView->replace('DATA_MAIN_TITLE', $mainTitle);

    $header = '<tr>
    <th scope="row">No.</th>
    <th scope="row">Nama</th>
    <th scope="row">NIM</th>
    <th scope="row">Semester</th>
    <th scope="row">Divisi</th>
    <th scope="row">Jabatan</th>
    <th scope="row">Aksi</th>
    </tr>';
    $detailView->replace('DATA_TABEL_HEADER', $header);

    $data = null;
    $no = 1;

    // Mengambil hasil pencarian buku
    while ($row = $buku->getResult()) {
        $data .= '<tr>
        <th scope="row">' . $no . '</th>
        <td>' . $row['buku_nama'] . '</td>
        <td>' . $row['buku_nim'] . '</td>
        <td>' . $row['buku_semester'] . '</td>
        <td>' . (isset($row['divisi_nama']) ? $row['divisi_nama'] : '') . '</td>
        <td>' . (isset($row['jabatan_nama']) ? $row['jabatan_nama'] : '') . '</td>
        <td style="font-size: 22px;">
            <a href="buku.php?id=' . $row['buku_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="buku.php?hapus=' . $row['buku_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
            </td>
        </tr>';
        $no++;
    }

    $detailView->replace('DATA_TABEL', $data);

    // Menutup koneksi database
    $buku->close();

    // Menampilkan hasil pencarian menggunakan template skindetail.html
    $detailView->write();
    exit; // Keluar dari skrip agar tidak melanjutkan ke bagian berikutnya
}