<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Views\Renderer;

class Product extends PublicController
{

private $viewData=[];

public function run(): void
{

$this->setViewData();

Renderer::render(
"products/product",
$this->viewData
);

}

private function setViewData(): void
{

$this->viewData["product"]=[
"productId"=>0,
"productName"=>"",
"productDescription"=>"",
"productPrice"=>0,
"productImgUrl"=>"",
"productStatus"=>"ACT"
];

}

}