<h2>Formulario Producto Electrónico</h2>

<form method="post">

<label>Nombre</label>
<br>
<input type="text" name="nombre" value="{{nombre}}">
<br><br>

<label>Tipo</label>
<br>
<input type="text" name="tipo" value="{{tipo}}">
<br><br>

<label>Precio</label>
<br>
<input type="number" step="0.01" name="precio" value="{{precio}}">
<br><br>

<label>Marca</label>
<br>
<input type="text" name="marca" value="{{marca}}">
<br><br>

<label>Fecha Lanzamiento</label>
<br>
<input type="date" name="fecha_lanzamiento" value="{{fecha_lanzamiento}}">
<br><br>

<button type="submit">Guardar</button>

</form>

<br>

<a href="index.php?page=ProductosElectronica_ProductosElectronica">
Volver
</a>