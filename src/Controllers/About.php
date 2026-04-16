<?php 

namespace Controllers;

use Views\Renderer;
class About extends PublicController{
    public function run() :void
    {

    $viewdata = [
        "nombre" => "Johnny Varela",
        "correo" => "flickmotion3@gmail.com",
        "telefono" => "32336321",
    ];

        Renderer::render("about", $viewdata);
    }

}

