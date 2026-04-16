<?php

namespace Dao\Productos;

use Dao\Table;

class Productos extends Table
{
    public static function getAll()
    {
        $sqlstr = "SELECT * FROM products;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(int $id)
    {
        $sqlstr = "SELECT * FROM products WHERE productId = :id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }

    public static function insert(
        string $name,
        string $description,
        float $price,
        string $image,
        int $stock,
        string $status
    ){
        $sqlstr = "INSERT INTO products
        (productName, productDescription, productPrice, productImgUrl, productStock, productStatus)
        VALUES
        (:name, :description, :price, :image, :stock, :status);";

        return self::executeNonQuery($sqlstr, [
            "name"=>$name,
            "description"=>$description,
            "price"=>$price,
            "image"=>$image,
            "stock"=>$stock,
            "status"=>$status
        ]);
    }

    public static function update(
        int $id,
        string $name,
        string $description,
        float $price,
        string $image,
        int $stock,
        string $status
    ){
        $sqlstr = "UPDATE products SET
        productName=:name,
        productDescription=:description,
        productPrice=:price,
        productImgUrl=:image,
        productStock=:stock,
        productStatus=:status
        WHERE productId=:id;";

        return self::executeNonQuery($sqlstr,[
            "id"=>$id,
            "name"=>$name,
            "description"=>$description,
            "price"=>$price,
            "image"=>$image,
            "stock"=>$stock,
            "status"=>$status
        ]);
    }

    public static function delete(int $id)
    {
        $sqlstr = "DELETE FROM products WHERE productId=:id;";
        return self::executeNonQuery($sqlstr,["id"=>$id]);
    }
}