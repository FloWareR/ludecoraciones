<script>
    let currentIndex = 1; 
    const images = [
        "assets/images/img1.jpeg",
        "assets/images/img2.jpeg",
        "assets/images/img3.jpeg",
        "assets/images/img4.jpeg",
        "assets/images/img5.jpeg",
        "assets/images/img6.jpeg",
        "assets/images/img7.jpeg",
        "assets/images/img8.jpeg",
        "assets/images/img9.jpeg"
    ];

    function updateCarousel() {
        // Definir la imagen anterior, actual y siguiente
        const prevIndex = (currentIndex - 1 + images.length) % images.length;
        const nextIndex = (currentIndex + 1) % images.length;

        // Seleccionar los elementos de imagen en el carrusel
        const previousImage = document.querySelector('.previous-image img');
        const mainImage = document.querySelector('.main-image img');
        const nextImage = document.querySelector('.next-image img');

        // Asignar las fuentes de las imágenes
        previousImage.src = images[prevIndex];
        mainImage.src = images[currentIndex];
        nextImage.src = images[nextIndex];
    }

    function moveCarousel(direction) {
        currentIndex = (currentIndex + direction + images.length) % images.length;
        updateCarousel();
    }

    updateCarousel();
</script>
<div class="header-container">
    <h1 class="title">LuDecoraciones2</h1>
    </div>
<div class="carousel-container">
    <div class="carousel">
        <div class="carousel-image previous-image" onclick="moveCarousel(-1)">
            <img src="assets/images/img1.jpeg" alt="Imagen 1">
        </div>
        <div class="carousel-image main-image">
            <img src="assets/images/img2.jpeg" alt="Imagen 2">
        </div>
        <div class="carousel-image next-image" onclick="moveCarousel(1)">
            <img src="assets/images/img3.jpeg" alt="Imagen 3">
        </div>
        <button class="carousel-button" onclick="window.location.href='/views/sections/quote.php'">Cotizar</button>

    </div>
</div>
