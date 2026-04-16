<h2>Formulario de Producto Digital</h2>

<form method="post">
    <label>Nombre</label>
    <br>
    <input type="text" name="productName" value="{{productName}}">
    <br><br>

    <label>Descripción</label>
    <br>
    <textarea name="productDescription">{{productDescription}}</textarea>
    <br><br>

    <label>Precio</label>
    <br>
    <input type="number" step="0.01" name="productPrice" value="{{productPrice}}">
    <br><br>

    <label>URL Imagen</label>
    <br>
    <input type="text" name="productImgUrl" value="{{productImgUrl}}">
    <br><br>

    <label>Stock</label>
    <br>
    <input type="number" name="productStock" value="{{productStock}}">
    <br><br>

    <label>Estado</label>
    <br>
    <input type="text" name="productStatus" value="{{productStatus}}">
    <br><br>

    <button type="submit">Guardar</button>
</form>

<br>

<a href="index.php?page=ProductosDigitales_ProductosDigitales">Volver</a>