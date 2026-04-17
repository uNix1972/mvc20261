<?php

namespace Controllers\ProductosDigitales;

use Views\Renderer;

class ProductosDigitales extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = array();

        $productos = \Dao\Productos\Productos::getAll();

        $viewData["productos"] = $productos;

        Renderer::render("products/productos", $viewData);
    }
}