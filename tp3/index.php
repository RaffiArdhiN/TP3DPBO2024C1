<?php

// Saya Raffi Ardhi Naufal NIM 2202495 mengerjakan Tugas Praktikum 3 dalam mata kuliah DPBO untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

include('config/db.php');
include('classes/DB.php');
include('classes/Penulis.php');
include('classes/Penerbit.php');
include('classes/Buku.php');
include('classes/Template.php');

$listBuku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$listBuku->open();

if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];

    $listBuku->searchBuku($searchTerm);
    
    $searchResult = $listBuku->getResult();

    if ($searchResult) {

        $firstBookId = $searchResult['id_buku'];

        // Alihkan pengguna ke halaman detail.php dengan menyertakan id buku sebagai parameter URL
        header("Location: detail.php?id=$firstBookId");
        exit;
            // if (is_array($book)) {
            //     // Kode HTML untuk menampilkan informasi buku
            // } else {
            //     echo "Data buku tidak valid.";
            // }
            // var_dump($searchResult);
            // $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
            //     '<div class="card pt-4 px-2 pengurus-thumbnail">
            //         <a href="detail.php?id=' . $searchResult['id_buku'] . '">
            //             <div class="card-body">
            //                 <p class="card-text jabatan-nama my-0">' . $searchResult['judul_buku'] . '</p>
            //                 <p class="card-text divisi-nama my-0">' . $searchResult['harga_buku'] . '</p>
            //                 <p class="card-text divisi-nama my-0">' . $searchResult['nama_penulis'] . '</p>
            //                 <p class="card-text jabatan-nama my-0">' . $searchResult['nama_penerbit'] . '</p>
            //             </div>
            //         </a>
            //     </div>    
            // </div>';
    } else {
        $data .= "Tidak ada hasil pencarian yang ditemukan.";
    }
}

$listBuku->getBukuJoin();

$data = null;

while ($row = $listBuku->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="detail.php?id=' . $row['id_buku'] . '">
            <div class="card-body">
                <p class="card-text jabatan-nama my-0">' . $row['judul_buku'] . '</p>
                <p class="card-text divisi-nama my-0">' . $row['harga_buku'] . '</p>
                <p class="card-text divisi-nama my-0">' . $row['nama_penulis'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $row['nama_penerbit'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

$listBuku->close();

$home = new Template('templates/skin.html');

$home->replace('DATA_BUKU', $data);
$home->write();
?>
