
<br>

<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button class="compra">¡compra ya!</button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active btn-carousel" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" class="iconCarrusel btn-carousel"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?php echo URL.'/images/'.$sliders[5]["IDSlider"]."/".$sliders[5]["Imagen"]?>" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="<?php echo URL.'/images/'.$sliders[6]["IDSlider"]."/".$sliders[6]["Imagen"]?>" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<br>
<br> 
<div class="contenedor2">
  <img src="<?php echo URL.'/images/seguro.png'?>" alt="" class="imagen-pequena">
  <div class="textContenedor2">
    <h1 class="titleRL">RECIÉN</h1>
    <h1 class="titleRL"><strong>LLEGADOS</strong></h1>
    <h3 style="color: black;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad ninim veniam, quis nostrud exerci tation</h3>
    <button class="btn-descubre-mas">Descubre más</button>
  </div>
</div>
<br>
<br>
<div class="contenedor_producto">
  <h1 class="tituloProducto">LO MÁS <strong>VENDIDO</strong></h1>
  <br><br>
</div>

<div class="ofertas">
  <div class="ofertasTextos">
    <h1 class="ofertas-titulo">OFERTAS <strong>TODO EL AÑO</strong></h1>
    <h3 style="color: white;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut loareet dolore magna aliquam
      erat volutpat, Ut wisi enim ad minim veniam, quis nostrud exerci tation
    </h3>
    <button class="btn-descubre-mas">Descubre más</button>
  </div>
  <img class="ofertaimg" src="<?php echo URL.'/images/girl-model-1-min.jpg' ?>" alt="">
</div>

<div class="banner"> 
  <div class="banner-section"> 
    <h3><strong>ENVIOS GRATIS</strong></h3>
    <img src="<?php echo URL.'/images/envio.png'?>" alt="Icono de Envíos"> 
  </div> 
  <div class="divider">
  </div>
  <div class="banner-section"> 
    <h3><strong>MESES SIN INTERESES</strong></h3>
    <img src="<?php echo URL.'/images/cards.png'?>" alt="Icono de Tarjeta"> 
  </div> 
  <div class="divider">
  </div> 
  <div class="banner-section"> 
    <h3><Strong>DEVOLUCIONES</Strong></h3>
    <img src="<?php echo URL.'/images/devoluciones.png'?>" alt="Icono de Devoluciones"> 
  </div>
</div>
<?php 
    #\Utilities\Utilities::print($sliders)
?>