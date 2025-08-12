
<!-- Carousel Wrapper -->
<div id="carouselVideoExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <!-- Inner -->
  <div class="carousel-inner">
    <!-- Single Item -->
    <div class="carousel-item active">
      <video class="img-fluid" autoplay loop muted>
        <source src="{{ asset('image_website/video/ttt.mp4') }}" type="video/mp4" />
      </video>
    </div>
  </div>
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselVideoExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
  </div>
</div>

<style>

/* Carousel Video Styles */
.carousel {
    position: relative;
    width: 100%;
    height: 80vh;
    margin: 0 auto;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

/* Carousel Inner */
.carousel-inner {
    position: relative;
    width: 100%;
    overflow: hidden;
}

/* Carousel Item */
.carousel-item {
    position: relative;
    display: none;
    width: 100%;
    transition: opacity 0.5s ease-in-out;
}

.carousel-item.active {
    display: block;
}

.carousel-item video.img-fluid {
    width: 100%;
    height: auto;
    object-fit: cover;
    display: block;
}

/* Carousel Caption */
.carousel-caption {
    background: rgba(0, 0, 0, 0.6);
    padding: 15px 20px;
    border-radius: 8px;
    bottom: 20px;
    color: #fff;
    text-align: center;
}

.carousel-caption h5 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #fff;
}

.carousel-caption p {
    font-size: 1rem;
    margin: 0;
    color: #ecf0f1;
}

/* Carousel Indicators */
.carousel-indicators {
    bottom: 10px;
    margin-bottom: 15px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #7f8c8d;
    border: none;
    margin: 0 5px;
    transition: background-color 0.3s ease;
}

.carousel-indicators .active {
    background-color: #e74c3c;
}

@media (max-width: 1200px) {
        .carousel {
        height: auto;
    }
}

@media (max-width: 992px) {
     .carousel {
        height: auto;
    }
}

@media (max-width: 576px) {
    .carousel {
        height: auto;
    }
}

</style>
