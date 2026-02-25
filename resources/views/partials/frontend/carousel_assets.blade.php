<style>
    .property-carousel {
        position: relative;
        overflow: hidden;
    }

    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(135, 82, 51, 0.7);
        /* Matching theme color #875233 */
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        z-index: 10;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        opacity: 0;
    }

    .property-carousel:hover .carousel-btn {
        opacity: 1;
    }

    .carousel-btn:hover {
        background: rgba(135, 82, 51, 1);
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-btn.prev {
        left: 10px;
    }

    .carousel-btn.next {
        right: 10px;
    }

    .property-img {
        transition: opacity 0.3s ease-in-out;
    }
</style>

<script>
    function togglePropertyImage(btn, direction) {
        const container = btn.closest('.property-carousel');
        const img = container.querySelector('.property-img-carousel');
        if (!img) return;

        const images = JSON.parse(img.getAttribute('data-images'));
        if (!images || images.length <= 1) return;

        let currentIndex = parseInt(img.getAttribute('data-current-index') || 0);

        if (direction === 'next') {
            currentIndex = (currentIndex + 1) % images.length;
        } else {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
        }

        img.style.opacity = '0.5';
        img.src = images[currentIndex];
        img.setAttribute('data-current-index', currentIndex);

        img.onload = function () {
            img.style.opacity = '1';
        };
    }
</script>