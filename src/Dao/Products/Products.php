<?php
namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function getFeaturedProducts()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus
                   FROM products p
                   INNER JOIN highlights h ON p.productId = h.productId
                   WHERE h.highlightStart <= NOW() AND h.highlightEnd >= NOW()";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getNewProducts()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus
                   FROM products p
                   WHERE p.productStatus = 'ACT'
                   ORDER BY p.productId DESC
                   LIMIT 3";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getDailyDeals()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, s.salePrice as productPrice, p.productImgUrl, p.productStatus
                   FROM products p
                   INNER JOIN sales s ON p.productId = s.productId
                   WHERE s.saleStart <= NOW() AND s.saleEnd >= NOW()";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
    }

    public static function getProducts(
  string $partialName = "",
  string $status = "",
  string $orderBy = "",
  bool $orderDescending = false,
  int $page = 0,
  int $itemsPerPage = 10
) {
  $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus,
  case when p.productStatus = 'ACT' then 'Activo'
       when p.productStatus = 'INA' then 'Inactivo'
       else 'Sin Asignar' end as productStatusDsc
  FROM products p";

  $sqlstrCount = "SELECT COUNT(*) as count FROM products p";

  $conditions = [];
  $params = [];

  if ($partialName != "") {
    $conditions[] = "p.productName LIKE :partialName";
    $params["partialName"] = "%" . $partialName . "%";
  }

  if (!in_array($status, ["ACT", "INA", ""])) {
    throw new \Exception("Error Processing Request Status has invalid value");
  }

  if ($status != "") {
    $conditions[] = "p.productStatus = :status";
    $params["status"] = $status;
  }

  if (count($conditions) > 0) {
    $sqlstr .= " WHERE " . implode(" AND ", $conditions);
    $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
  }

  if (!in_array($orderBy, ["productId", "productName", "productPrice", ""])) {
    throw new \Exception("Error Processing Request OrderBy has invalid value");
  }

  if ($orderBy != "") {
    $sqlstr .= " ORDER BY " . $orderBy;
    if ($orderDescending) {
      $sqlstr .= " DESC";
    }
  }

  $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
  $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);

  if ($page > $pagesCount - 1) {
    $page = $pagesCount - 1;
  }

  $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

  $registros = self::obtenerRegistros($sqlstr, $params);

  return [
    "products" => $registros,
    "total" => $numeroDeRegistros,
    "page" => $page,
    "itemsPerPage" => $itemsPerPage
  ];
}
}