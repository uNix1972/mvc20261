<?php

namespace Controllers\ProductosDigitales;

use Views\Renderer;

class ProductosDigitales extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = [];

        $viewData["productos"] = \Dao\Productos\Productos::getAll();

        Renderer::render("products/productos", $viewData);
    }
}