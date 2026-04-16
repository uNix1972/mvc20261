<?php

namespace Dao\ProductosElectronica;

use Dao\Table;

class ProductosElectronica extends Table
{
    public static function getAll()
    {
        $sqlstr = "SELECT * FROM productoselectronica;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $id)
    {
        $sqlstr = "SELECT * FROM productoselectronica WHERE id_producto = :id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    public static function insert(
        string $nombre,
        string $tipo,
        float $precio,
        string $marca,
        string $fecha
    ){
        $sqlstr = "INSERT INTO productoselectronica
        (nombre,tipo,precio,marca,fecha_lanzamiento)
        VALUES
        (:nombre,:tipo,:precio,:marca,:fecha);";

        return self::executeNonQuery($sqlstr, [
            "nombre"=>$nombre,
            "tipo"=>$tipo,
            "precio"=>$precio,
            "marca"=>$marca,
            "fecha"=>$fecha
        ]);
    }

    public static function update(
        int $id,
        string $nombre,
        string $tipo,
        float $precio,
        string $marca,
        string $fecha
    ){
        $sqlstr = "UPDATE productoselectronica
        SET
        nombre=:nombre,
        tipo=:tipo,
        precio=:precio,
        marca=:marca,
        fecha_lanzamiento=:fecha
        WHERE id_producto=:id;";

        return self::executeNonQuery($sqlstr,[
            "id"=>$id,
            "nombre"=>$nombre,
            "tipo"=>$tipo,
            "precio"=>$precio,
            "marca"=>$marca,
            "fecha"=>$fecha
        ]);
    }

    public static function delete(int $id)
    {
        $sqlstr = "DELETE FROM productoselectronica WHERE id_producto=:id;";
        return self::executeNonQuery($sqlstr,["id"=>$id]);
    }
}