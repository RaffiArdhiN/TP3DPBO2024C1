<?php

    include('config/db.php');
    include('classes/DB.php');
    include('classes/Penulis.php');
    include('classes/Template.php');

    $penulis = new Penulis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $penulis->open();
    $penulis->getPenulis();

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        
        // Lakukan penghapusan data penulis
        $result = $penulis->deletePenulis($id);
        if ($result) {
            header("Location: penulis.php");
            exit;
        } else {
            echo "Gagal menghapus data penulis!";
        }
    }

    if (!isset($_GET['id'])) {
        if (isset($_POST['submit'])) {
            if ($penulis->addPenulis($_POST) > 0) {
                echo "<script>
                    alert('Data berhasil ditambah!');
                    document.location.href = 'penulis.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal ditambah!');
                    document.location.href = 'penulis.php';
                </script>";
            }
        }

        $btn = 'Tambah';
        $title = 'Tambah';
    }
    
    $view = new Template('templates/skintabel.html');

    $mainTitle = 'Penulis';
    $header = '<tr>
    <th scope="row">No.</th>
    <th scope="row">Nama Penulis</th>
    <th scope="row">Aksi</th>
    </tr>';
    $data = null;
    $no = 1;
    $formLabel = 'penulis';

    while ($nulis = $penulis->getResult()) {
        $data .= '<tr>
        <th scope="row">' . $no . '</th>
        <td>' . $nulis['nama_penulis'] . '</td>
        <td style="font-size: 22px;">
            <a href="updatepenulis.php?id=' . $nulis['id_penulis'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="penulis.php?hapus=' . $nulis['id_penulis'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
            </td>
        </tr>';
        $no++;
    }

    if (isset($_GET['id_penulis'])) {
        $id = $_GET['id_penulis'];
        if ($id > 0) {
            if (isset($_POST['submit'])) {
                if ($penulis->updatePenulis($id, $_POST) > 0) {
                    echo "<script>
                    alert('Data berhasil diubah!');
                    document.location.href = 'penulis.php';
                </script>";
                } else {
                    echo "<script>
                    alert('Data gagal diubah!');
                    document.location.href = 'penulis.php';
                </script>";
                }
            }

            $penulis->getPenulisById($id);
            $row = $penulis->getResult();

            $dataUpdate = $row['penulis_nama'];
            $btn = 'Simpan';
            $title = 'Ubah';

            $view->replace('DATA_VAL_UPDATE', $dataUpdate);
        }
    }


    $penulis->close();

    $view->replace('DATA_MAIN_TITLE', $mainTitle);
    $view->replace('DATA_TABEL_HEADER', $header);
    $view->replace('DATA_TITLE', $title);
    $view->replace('DATA_BUTTON', $btn);
    $view->replace('DATA_FORM_LABEL', $formLabel);
    $view->replace('DATA_TABEL', $data);
    $view->write();
