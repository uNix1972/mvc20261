<?php

namespace Controllers\Cart;

use Views\Renderer;

class View extends \Controllers\PublicController
{
    public function run(): void
    {
        $viewData = array();

        if (!isset($_SESSION["anoncod"])) {
            $_SESSION["anoncod"] = md5(session_id() . time());
        }

        $carrito = \Dao\Cart\Cart::getAnonCart($_SESSION["anoncod"]);

        $total = 0;
        foreach ($carrito as $item) {
            $total += $item["subtotal"];
        }

        $viewData["carrito"] = $carrito;
        $viewData["total"] = $total;

        Renderer::render("cart/view", $viewData);
    }
}