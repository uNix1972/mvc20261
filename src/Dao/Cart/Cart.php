<?php

namespace Dao\Cart;

class Cart extends \Dao\Table
{
    public static function getProductosDisponibles()
    {
        $sqlAllProductosActivos = "SELECT * from products where productStatus in ('ACT');";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array());

        // Stock carretilla autorizada
        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select productId, sum(crrctd) as reserved
            from carretilla 
            where TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("delta" => $deltaAutorizada)
        );

        // Stock carretilla NO autorizada (CORREGIDO)
        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select productId, sum(crrctd) as reserved
            from carretillaanon 
            where TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("delta" => $deltaNAutorizada)
        );

        $productosCurados = array();

        foreach ($productosDisponibles as $producto) {
            $productosCurados[$producto["productId"]] = $producto;
        }

        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }

        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }

        return $productosCurados;
    }

    public static function getProductoDisponible($productId)
    {
        $sqlAllProductosActivos = "SELECT * from products 
            where productStatus in ('ACT') and productId=:productId;";
        $productosDisponibles = self::obtenerRegistros(
            $sqlAllProductosActivos,
            array("productId" => $productId)
        );

        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select productId, sum(crrctd) as reserved
            from carretilla 
            where productId=:productId 
            and TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("productId" => $productId, "delta" => $deltaAutorizada)
        );

        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select productId, sum(crrctd) as reserved
            from carretillaanon 
            where productId = :productId 
            and TIME_TO_SEC(TIMEDIFF(now(), crrfching)) <= :delta
            group by productId;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("productId" => $productId, "delta" => $deltaNAutorizada)
        );

        $productosCurados = array();

        foreach ($productosDisponibles as $producto) {
            $productosCurados[$producto["productId"]] = $producto;
        }

        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }

        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["productId"]])) {
                $productosCurados[$producto["productId"]]["productStock"] -= $producto["reserved"];
            }
        }

        return $productosCurados;
    }

    public static function getProducto($productId)
    {
        $sql = "SELECT * from products where productId=:productId;";
        return self::obtenerRegistros($sql, array("productId" => $productId));
    }

    // 🔥 MÉTODO NUEVO (CARRITO ANÓNIMO)
    public static function addToAnonCart(string $anoncod, int $productId)
    {
        $producto = self::obtenerUnRegistro(
            "SELECT * FROM products WHERE productId = :productId AND productStatus = 'ACT';",
            array("productId" => $productId)
        );

        if (!$producto) {
            return false;
        }

        $existente = self::obtenerUnRegistro(
            "SELECT * FROM carretillaanon WHERE anoncod = :anoncod AND productId = :productId;",
            array(
                "anoncod" => $anoncod,
                "productId" => $productId
            )
        );

        if ($existente) {
            $sql = "UPDATE carretillaanon
                SET crrctd = crrctd + 1,
                    crrprc = :price,
                    crrfching = NOW()
                WHERE anoncod = :anoncod
                  AND productId = :productId;";

            return self::executeNonQuery(
                $sql,
                array(
                    "price" => $producto["productPrice"],
                    "anoncod" => $anoncod,
                    "productId" => $productId
                )
            );
        }

        $sql = "INSERT INTO carretillaanon
            (anoncod, productId, crrctd, crrprc, crrfching)
            VALUES
            (:anoncod, :productId, 1, :price, NOW());";

        return self::executeNonQuery(
            $sql,
            array(
                "anoncod" => $anoncod,
                "productId" => $productId,
                "price" => $producto["productPrice"]
            )
        );
    }
}