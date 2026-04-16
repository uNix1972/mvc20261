<h2>Listado de Productos Digitales</h2>

<a href="index.php?page=ProductosDigitales_ProductosDigitalesForm&mode=INS">Nuevo Producto</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        {{foreach productos}}
        <tr>
            <td>{{productId}}</td>
            <td>{{productName}}</td>
            <td>{{productPrice}}</td>
            <td>{{productStock}}</td>
            <td>{{productStatus}}</td>
            <td>
                <a href="index.php?page=ProductosDigitales_ProductosDigitalesForm&mode=UPD&id={{productId}}">Editar</a>
                |
                <a href="index.php?page=ProductosDigitales_ProductosDigitalesForm&mode=DEL&id={{productId}}">Eliminar</a>
            </td>
        </tr>
        {{endfor productos}}
    </tbody>
</table>