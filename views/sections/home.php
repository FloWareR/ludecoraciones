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
        const prevIndex = (currentIndex - 1 + images.length) % images.length;
        const nextIndex = (currentIndex + 1) % images.length;

        const previousImage = document.querySelector('.previous-image img');
        const mainImage = document.querySelector('.main-image img');
        const nextImage = document.querySelector('.next-image img');

        previousImage.src = images[prevIndex];
        mainImage.src = images[currentIndex];
        nextImage.src = images[nextIndex];
    }

    function moveCarousel(direction) {
        currentIndex = (currentIndex + direction + images.length) % images.length;

        // Agregar una clase temporal para la transición
        const carousel = document.querySelector('.carousel');
        carousel.style.transform = `translateX(${direction * -100}%)`;
        
        // Esperar un momento antes de actualizar el carrusel
        setTimeout(() => {
            carousel.style.transform = 'translateX(0)';
            updateCarousel();
        }, 500); // El tiempo debe coincidir con la duración de la transición en CSS
    }

    updateCarousel();
</script>

<div class="header-container">
    <h1 class="title">LuDecoraciones</h1>
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
