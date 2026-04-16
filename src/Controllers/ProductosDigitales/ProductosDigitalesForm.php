<?php

namespace Controllers\ProductosDigitales;

use Views\Renderer;

class ProductosDigitalesForm extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = [];

        $viewData["mode"] = $_GET["mode"] ?? "INS";
        $viewData["id"] = $_GET["id"] ?? 0;

        $viewData["productName"] = "";
        $viewData["productDescription"] = "";
        $viewData["productPrice"] = "";
        $viewData["productImgUrl"] = "";
        $viewData["productStock"] = "";
        $viewData["productStatus"] = "ACT";

        if ($viewData["mode"] != "INS") {
            $producto = \Dao\Productos\Productos::getById((int)$viewData["id"]);
            if ($producto) {
                $viewData = array_merge($viewData, $producto);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["productName"];
            $description = $_POST["productDescription"];
            $price = $_POST["productPrice"];
            $image = $_POST["productImgUrl"];
            $stock = $_POST["productStock"];
            $status = $_POST["productStatus"];

            if ($viewData["mode"] === "INS") {
                \Dao\Productos\Productos::insert(
                    $name,
                    $description,
                    (float)$price,
                    $image,
                    (int)$stock,
                    $status
                );
            }

            if ($viewData["mode"] === "UPD") {
                \Dao\Productos\Productos::update(
                    (int)$viewData["id"],
                    $name,
                    $description,
                    (float)$price,
                    $image,
                    (int)$stock,
                    $status
                );
            }

            if ($viewData["mode"] === "DEL") {
                \Dao\Productos\Productos::delete((int)$viewData["id"]);
            }

            header("Location: index.php?page=ProductosDigitales_ProductosDigitales");
            exit();
        }

        Renderer::render("products/productosform", $viewData);
    }
}