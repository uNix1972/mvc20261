<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{

public static function getProducts(
string $partialName="",
string $status="",
string $orderBy="",
bool $orderDescending=false,
int $page=0,
int $itemsPerPage=10
){

$sqlstr="SELECT
p.productId,
p.productName,
p.productDescription,
p.productPrice,
p.productImgUrl,
p.productStatus,
CASE
WHEN p.productStatus='ACT' THEN 'Activo'
WHEN p.productStatus='INA' THEN 'Inactivo'
ELSE 'Sin Asignar'
END productStatusDsc
FROM products p";

$sqlstrCount="SELECT COUNT(*) count FROM products p";

$conditions=[];
$params=[];

if($partialName!=""){
$conditions[]="p.productName LIKE :partialName";
$params["partialName"]="%".$partialName."%";
}

if($status!=""){
$conditions[]="p.productStatus=:status";
$params["status"]=$status;
}

if(count($conditions)>0){
$sqlstr.=" WHERE ".implode(" AND ",$conditions);
$sqlstrCount.=" WHERE ".implode(" AND ",$conditions);
}

if($orderBy!=""){
$sqlstr.=" ORDER BY ".$orderBy;
if($orderDescending){
$sqlstr.=" DESC";
}
}

$total=self::obtenerUnRegistro($sqlstrCount,$params)["count"];

$sqlstr.=" LIMIT ".($page*$itemsPerPage).",".$itemsPerPage;

$products=self::obtenerRegistros($sqlstr,$params);

return[
"products"=>$products,
"total"=>$total
];

}



public static function getProductById(int $productId){

$sqlstr="SELECT * FROM products WHERE productId=:productId";

return self::obtenerUnRegistro(
$sqlstr,
["productId"=>$productId]
);

}



public static function insertProduct(
$productName,
$productDescription,
$productPrice,
$productImgUrl,
$productStatus
){

$sqlstr="INSERT INTO products
(productName,productDescription,productPrice,productImgUrl,productStatus)
VALUES
(:productName,:productDescription,:productPrice,:productImgUrl,:productStatus)";

return self::executeNonQuery(
$sqlstr,
[
"productName"=>$productName,
"productDescription"=>$productDescription,
"productPrice"=>$productPrice,
"productImgUrl"=>$productImgUrl,
"productStatus"=>$productStatus
]
);

}



public static function updateProduct(
$productId,
$productName,
$productDescription,
$productPrice,
$productImgUrl,
$productStatus
){

$sqlstr="UPDATE products SET
productName=:productName,
productDescription=:productDescription,
productPrice=:productPrice,
productImgUrl=:productImgUrl,
productStatus=:productStatus
WHERE productId=:productId";

return self::executeNonQuery(
$sqlstr,
[
"productId"=>$productId,
"productName"=>$productName,
"productDescription"=>$productDescription,
"productPrice"=>$productPrice,
"productImgUrl"=>$productImgUrl,
"productStatus"=>$productStatus
]
);

}



public static function deleteProduct(int $productId){

$sqlstr="DELETE FROM products
WHERE productId=:productId";

return self::executeNonQuery(
$sqlstr,
[
"productId"=>$productId
]
);

}

}