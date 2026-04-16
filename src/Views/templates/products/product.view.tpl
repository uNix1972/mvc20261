<section class="container-m row px-4 py-4">
  <h1>{{FormTitle}}</h1>
</section>

<section class="container-m row px-4 py-4">
  {{with product}}
  <form action="index.php?page=Products_Product&mode={{~mode}}&productId={{productId}}" method="POST" class="col-12 col-m-8 offset-m-2">

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Código</label>
      <input class="col-12 col-m-9" readonly disabled type="text" value="{{productId}}" />
      <input type="hidden" name="mode" value="{{~mode}}" />
      <input type="hidden" name="productId" value="{{productId}}" />
      <input type="hidden" name="product_xss_token" value="{{~product_xss_token}}" />
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Producto</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="productName" value="{{productName}}" />
      {{if productName_error}}
      <div class="error">{{productName_error}}</div>
      {{endif productName_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Descripción</label>
      <textarea class="col-12 col-m-9" {{~readonly}} name="productDescription">{{productDescription}}</textarea>
      {{if productDescription_error}}
      <div class="error">{{productDescription_error}}</div>
      {{endif productDescription_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Precio</label>
      <input class="col-12 col-m-9" {{~readonly}} type="number" name="productPrice" value="{{productPrice}}" />
      {{if productPrice_error}}
      <div class="error">{{productPrice_error}}</div>
      {{endif productPrice_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Imagen</label>
      <input class="col-12 col-m-9" {{~readonly}} type="text" name="productImgUrl" value="{{productImgUrl}}" />
      {{if productImgUrl_error}}
      <div class="error">{{productImgUrl_error}}</div>
      {{endif productImgUrl_error}}
    </div>

    <div class="row my-2 align-center">
      <label class="col-12 col-m-3">Estado</label>
      <select name="productStatus" class="col-12 col-m-9" {{if ~readonly}}disabled{{endif ~readonly}}>
        <option value="ACT" {{productStatus_act}}>Activo</option>
        <option value="INA" {{productStatus_ina}}>Inactivo</option>
      </select>
    </div>

  {{endwith product}}

<div class="row my-4 align-center flex-end">

{{if showCommitBtn}}
<button class="primary col-12 col-m-2" type="submit">
Confirmar
</button>
{{endif showCommitBtn}}

<button class="col-12 col-m-2" type="button" id="btnCancelar">
Cancelar
</button>

</div>

  

  

  </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", ()=>{
  const btnCancelar = document.getElementById("btnCancelar");

  btnCancelar.addEventListener("click", ()=>{
    window.location.assign("index.php?page=Products_Products");
  });

});
</script>