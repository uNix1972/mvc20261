<?php

namespace Controllers\Cart;

class Add extends \Controllers\PublicController
{
    public function run(): void
    {
        if (!isset($_SESSION["anoncod"])) {
            $_SESSION["anoncod"] = md5(session_id() . time());
        }

        $productId = intval($_GET["productId"] ?? 0);

        if ($productId > 0) {
            \Dao\Cart\Cart::addToAnonCart($_SESSION["anoncod"], $productId);
        }

        header("Location: index.php?page=Cart_View");
        exit();
    }
}