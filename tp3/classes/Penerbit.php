<?php

class Penerbit extends DB
{
    function getPenerbit()
    {
        $query = "SELECT * FROM penerbit";
        return $this->execute($query);
    }

    function getPenerbitById($id)
    {
        $query = "SELECT * FROM penerbit WHERE id_penerbit=$id";
        return $this->execute($query);
    }

    function addPenerbit($data)
    {
        $nama_penerbit = $data['nama_penerbit'];

        $query = "INSERT INTO penerbit (nama_penerbit) VALUES ('$nama_penerbit')";
        return $this->execute($query);
    }

    function updatePenerbit($id, $data)
    {
        $nama_penerbit = $data['nama_penerbit'];

        $query = "UPDATE penerbit SET nama_penerbit='$nama_penerbit' WHERE id_penerbit=$id";
        return $this->execute($query);
    }

    function deletePenerbit($id)
    {
        $query = "DELETE FROM penerbit WHERE id_penerbit=$id";
        return $this->execute($query);
    }
}
?>
