<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Buku.php');
include('classes/Template.php');

$penerbit = new Penerbit($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$penerbit->open();
$penerbit->getPenerbit();

$penerbitData = null;

if (isset($_POST['btn-submit'])) {
    // methode mencari data pengurus
    $data = [
        'nama_penerbit' => $_POST['nama_penerbit'],
    ];

    $result = $penerbit->addPenerbit($data);
    if (!$result) {
        header("Location: penerbit.php");
        exit;
    }
} 
// else {
//     // method menampilkan data pengurus
//     $listPegawai->getPegawaiJoin();
// }

// ambil data pengurus
// gabungkan dgn tag html
// untuk di passing ke skin/template
// while ($row = $listPegawai->getResult()) {
//     $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
//         '<div class="card pt-4 px-2 pengurus-thumbnail">
//         <a href="detail.php?id=' . $row['id_buku'] . '">
//             <div class="card-body">
//                 <p class="card-text pengurus-judul my-0">' . $row['judul_buku'] . '</p>
//                 <p class="card-text divisi-judul my-0">' . $row['judul_penulis'] . '</p>
//                 <p class="card-text jabatan-judul my-0">' . $row['mulai_penerbit'] . '</p>
//             </div>
//         </a>
//     </div>    
//     </div>';
// }

// // tutup koneksi
// $listPegawai->close();

// buat instance template
$home = new Template('templates/skinformpenerbit.html');

// simpan data ke template
// $home->replace('DATA_PENULIS', $penulisData);
// $home->replace('DATA_PENERBIT', $penerbitData);
$home->write();
