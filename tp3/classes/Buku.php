<?php

class Buku extends DB
{
    function getBukuJoin()
    {
        $query = "SELECT * FROM buku JOIN penulis ON buku.id_penulis=penulis.id_penulis JOIN penerbit ON buku.id_penerbit=penerbit.id_penerbit ORDER BY buku.id_buku";

        return $this->execute($query);
    }

    function getBuku()
    {
        $query = "SELECT * FROM buku";
        return $this->execute($query);
    }

    function getBukuById($id)
    {
        $query = "SELECT * FROM buku JOIN penulis ON buku.id_penulis=penulis.id_penulis JOIN penerbit ON buku.id_penerbit=penerbit.id_penerbit WHERE id_buku=$id";
        return $this->execute($query);
    }

    public function searchBuku($keyword)
    {
        $query = "SELECT * FROM buku WHERE judul_buku LIKE '%$keyword%' OR harga_buku LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addData($data)
    {
        $judul_buku = $data['judul_buku'];
        $harga_buku = $data['harga_buku'];
        $id_penulis = $data['id_penulis'];
        $id_penerbit = $data['id_penerbit'];

        $query = "INSERT INTO buku (judul_buku, harga_buku, id_penulis, id_penerbit) VALUES ('$judul_buku', '$harga_buku', '$id_penulis', '$id_penerbit')";

        return $this->execute($query);
    }


    function updateData($id, $data)
    {
        $judul_buku = $data['judul_buku'];
        $harga_buku = $data['harga_buku'];
        $id_penulis = $data['id_penulis'];
        $id_penerbit = $data['id_penerbit'];
    
        $query = "UPDATE buku SET judul_buku='$judul_buku', harga_buku='$harga_buku', id_penulis='$id_penulis', id_penerbit='$id_penerbit' WHERE id_buku='$id'";
    
        return $this->execute($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM buku WHERE id_buku='$id'";
    
        return $this->execute($query);
    }
}
