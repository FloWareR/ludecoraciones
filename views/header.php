
<script>
    function toggleDrawer() {
        const drawer = document.getElementById('drawer');
        drawer.style.display = drawer.style.display === 'flex' ? 'none' : 'flex';
    }
</script>

<div class="navbar">
    <div class="logo">
        <img src="/assets/images/logo.png" alt="Logo">
    </div>
    <button class="menu-toggle" onclick="toggleDrawer()">☰</button>
    <nav id="drawer" class="drawer-nav">
        <ul class="nav-links">
            <li><a href="https://ludecoraciones.com/">Inicio</a></li>
            <li><a href="/views/sections/proyects.php">Proyectos</a></li>
            <li><a href="/views/sections/quote.php">Cotizar</a></li>
            <li><a href="/views/sections/about.php">Conoce LU</a></li>
        </ul>
    </nav>
</div>