<?php

namespace Controllers\Cart;

class Remove extends \Controllers\PublicController
{
    public function run(): void
    {
        if (!isset($_SESSION["anoncod"])) {
            header("Location: index.php?page=Cart_View");
            exit();
        }

        $productId = intval($_GET["productId"] ?? 0);

        if ($productId > 0) {
            \Dao\Cart\Cart::removeFromAnonCart($_SESSION["anoncod"], $productId);
        }

        header("Location: index.php?page=Cart_View");
        exit();
    }
}