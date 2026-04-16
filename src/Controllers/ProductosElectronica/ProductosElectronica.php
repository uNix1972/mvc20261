<?php

namespace Controllers\ProductosElectronica;

use Views\Renderer;

class ProductosElectronica extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = [];

        $viewData["productos"] = \Dao\ProductosElectronica\ProductosElectronica::getAll();

        Renderer::render("productoselectronica/productoselectronica", $viewData);
    }
}