<?php

    include('config/db.php');
    include('classes/DB.php');
    include('classes/Penerbit.php');
    include('classes/Template.php');

    $penerbit = new Penerbit($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
    $penerbit->open();
    $penerbit->getPenerbit();

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        
        // Lakukan penghapusan data penulis
        $result = $penerbit->deletePenerbit($id);
        if (!$result) {
            header("Location: penerbit.php");
            exit;
        } else {
            echo "Gagal menghapus data penerbit!";
        }
    }

    if (!isset($_GET['id'])) {
        if (isset($_POST['submit'])) {
            if ($penerbit->addPenerbit($_POST) > 0) {
                echo "<script>
                    alert('Data berhasil ditambah!');
                    document.location.href = 'penerbit.php';
                </script>";
            } else {
                echo "<script>
                    alert('Data gagal ditambah!');
                    document.location.href = 'penerbit.php';
                </script>";
            }
        }

        $btn = 'Tambah';
        $title = 'Tambah';
    }

    $view = new Template('templates/skintabelpenerbit.html');

    $mainTitle = 'Penerbit';
    $header = '<tr>
    <th scope="row">No.</th>
    <th scope="row">Nama Penerbit</th>
    <th scope="row">Aksi</th>
    </tr>';
    $data = null;
    $no = 1;
    $formLabel = 'penerbit';

    while ($nulis = $penerbit->getResult()) {
        $data .= '<tr>
        <th scope="row">' . $no . '</th>
        <td>' . $nulis['nama_penerbit'] . '</td>
        <td style="font-size: 22px;">
            <a href="updatepenerbit.php?id=' . $nulis['id_penerbit'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="penerbit.php?hapus=' . $nulis['id_penerbit'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
            </td>
        </tr>';
        $no++;
    }

    $penerbit->close();

    $view->replace('DATA_MAIN_TITLE', $mainTitle);
    $view->replace('DATA_TABEL_HEADER', $header);
    $view->replace('DATA_TITLE', $title);
    $view->replace('DATA_BUTTON', $btn);
    $view->replace('DATA_FORM_LABEL', $formLabel);
    $view->replace('DATA_TABEL', $data);
    $view->write();
?>
