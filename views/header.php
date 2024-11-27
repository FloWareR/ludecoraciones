<script>
function toggleDrawer() {
    const drawer = document.getElementById('drawer');
    drawer.classList.toggle('open');
}
</script>
<div class="navbar">
    <div class="logo">
        <a href="https://ludecoraciones.com/">
            <img src="assets/images/logo.png" alt="Logo">
        </a>
    </div>
    <button class="hamburger-btn" onclick="toggleDrawer()">
        <img src="/assets/images/Menu.png" alt="Menu">
    </button>
    <nav id="drawer" class="drawer-nav">
        <button class="close-btn" onclick="toggleDrawer()">✖</button>
        <ul class="nav-links drawer-links">
            <li><a href="https://ludecoraciones.com/">Inicio</a></li>
            <li><a href="/views/sections/proyects.php">Galería</a></li>
            <li><a href="/views/sections/services.php">Servicios</a></li>
            <li><a href="/views/sections/quote.php">Cotizar</a></li>
            <li><a href="/views/sections/about.php">Conoce LU</a></li>
        </ul>
    </nav>
    <ul class="nav-links desktop-links">
        <li><a href="https://ludecoraciones.com/">Inicio</a></li>
        <li><a href="/views/sections/proyects.php">Galería</a></li>
        <li><a href="/views/sections/services.php">Servicios</a></li>
        <li><a href="/views/sections/quote.php">Cotizar</a></li>
        <li><a href="/views/sections/about.php">Conoce LU</a></li>
    </ul>
</div>
