<?php

class Penulis extends DB
{
    function getPenulis()
    {
        $query = "SELECT * FROM penulis";
        return $this->execute($query);
    }

    function getPenulisById($id)
    {
        $query = "SELECT * FROM penulis WHERE id_penulis=$id";
        return $this->execute($query);
    }

    function addPenulis($data)
    {
        $nama = $data['nama_penulis'];
        $query = "INSERT INTO penulis (nama_penulis) VALUES ('$nama')";
        return $this->executeAffected($query);
    }

    function updatePenulis($id, $data)
    {
        $nama = $data['nama_penulis'];
        $query = "UPDATE penulis SET nama_penulis='$nama' WHERE id_penulis=$id";
        return $this->executeAffected($query);
    }

    function deletePenulis($id)
    {
        $query = "DELETE FROM penulis WHERE id_penulis=$id";
        return $this->executeAffected($query);
    }
}
?>
