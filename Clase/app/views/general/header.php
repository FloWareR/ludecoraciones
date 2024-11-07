<div class="offers">
    ofertas de cambio de temporada
    <a href="" class="btn btn-white">¡Descubre!</a>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img class="img-responsive" src="<?= URL.'images/logo.png' ?>" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <?php
        $router = \System\Router::getInstance("index",SUBDIR);
        $current = $router->getController();
        $menu = [
          "index" => "Inicio",
          "news" => "Nuevos",
          "offers" => "Ofertas",
          "contact" => "Contacto",
        ];
        foreach ($menu as $key => $item) {
          $active = ($current == $key) ? 'active': '';
          ?>
          <li class="nav-item">
            <a class="nav-link <?= $active?>" aria-current="page" href="<?= URL.'/'.$key?>"><?=$item?></a>
          </li>
          <?php
        }
        ?>
      </ul> 

      
    </div>
    <div class="search-user-container">
      <form class="d-flex search-header" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit"> <i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
      
    <div class="items-shoppingcart-user">
      <div class="dropdown user-header">
        <button type="button" class="btn btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
          <i class="fa fa-user"></i>
        </button>
        <form class="dropdown-menu p-4 dropdown-menu-end">
          <div class="mb-3">
            <label for="exampleDropdownFormEmail2" class="form-label">correo</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
          </div>
          <div class="mb-3">
            <label for="exampleDropdownFormPassword2" class="form-label">contraseña</label>
            <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
          </div>
          <div class="mb-3">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="dropdownCheck2">
              <label class="form-check-label" for="dropdownCheck2">
                Remember me
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Iniciar sesion</button>
        </form>
        <a href="<?= URL?>/shoppingcart/checkout" class="shoppingcart btn btn-action-header">
          <i class="fa-solid fa-cart-shopping"></i>
        </a>
      </div>
    </div>
  </div>
</nav>