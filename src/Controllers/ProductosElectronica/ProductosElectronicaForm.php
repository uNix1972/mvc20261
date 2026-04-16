<?php

namespace Controllers\ProductosElectronica;

use Views\Renderer;

class ProductosElectronicaForm extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = [];

        $viewData["mode"] = $_GET["mode"] ?? "INS";
        $viewData["id_producto"] = $_GET["id"] ?? 0;

        $viewData["nombre"] = "";
        $viewData["tipo"] = "";
        $viewData["precio"] = "";
        $viewData["marca"] = "";
        $viewData["fecha_lanzamiento"] = "";

        if ($viewData["mode"] != "INS") {

            $producto = \Dao\ProductosElectronica\ProductosElectronica::getById($viewData["id_producto"]);

            if ($producto) {
                $viewData = array_merge($viewData, $producto);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $nombre = $_POST["nombre"];
            $tipo = $_POST["tipo"];
            $precio = $_POST["precio"];
            $marca = $_POST["marca"];
            $fecha = $_POST["fecha_lanzamiento"];

            if ($viewData["mode"] === "INS") {

                \Dao\ProductosElectronica\ProductosElectronica::insert(
                    $nombre,
                    $tipo,
                    $precio,
                    $marca,
                    $fecha
                );
            }

            if ($viewData["mode"] === "UPD") {

                \Dao\ProductosElectronica\ProductosElectronica::update(
                    $viewData["id_producto"],
                    $nombre,
                    $tipo,
                    $precio,
                    $marca,
                    $fecha
                );
            }

            if ($viewData["mode"] === "DEL") {

                \Dao\ProductosElectronica\ProductosElectronica::delete(
                    $viewData["id_producto"]
                );
            }

            header("Location: index.php?page=ProductosElectronica_ProductosElectronica");
            exit();
        }

        Renderer::render("productoselectronica/productoselectronicaform", $viewData);
    }
}