; (function ($) {

  $(document).ready(function () {

    //========== HEADER ACTIVE STRATS ============= //
    if ($("#header").length > 0) {
      $(window).on("scroll", function (event) {
        var scroll = $(window).scrollTop();
        if (scroll < 1) {
          $(".header-area").removeClass("sticky");
        } else {
          $(".header-area").addClass("sticky");
        }
      });
    }
    //========== HEADER ACTIVE ENDS ============= //

    //========== SIDEBAR/SEARCH AREA ============= //
    $(".header-search-btn").on("click", function (e) {
      e.preventDefault();
      $(".header-search-form-wrapper").addClass("open");
      $('.header-search-form-wrapper input[type="search"]').focus();
      $('.body-overlay').addClass('active');
    });
    $(".tx-search-close").on("click", function (e) {
      e.preventDefault();
      $(".header-search-form-wrapper").removeClass("open");
      $("body").removeClass("active");
      $('.body-overlay').removeClass('active');
    });
    //========== SIDEBAR/SEARCH AREA ============= //

    //========== PAGE PROGRESS STARTS ============= // 
    var progressPath = document.querySelector(".progress-wrap path");
    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "none";
    progressPath.style.strokeDasharray = pathLength + " " + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "stroke-dashoffset 10ms linear";
    var updateProgress = function () {
      var scroll = $(window).scrollTop();
      var height = $(document).height() - $(window).height();
      var progress = pathLength - (scroll * pathLength) / height;
      progressPath.style.strokeDashoffset = progress;
    };
    updateProgress();
    $(window).scroll(updateProgress);
    var offset = 50;
    var duration = 550;
    jQuery(window).on("scroll", function () {
      if (jQuery(this).scrollTop() > offset) {
        jQuery(".progress-wrap").addClass("active-progress");
      } else {
        jQuery(".progress-wrap").removeClass("active-progress");
      }
    });
    jQuery(".progress-wrap").on("click", function (event) {
      event.preventDefault();
      jQuery("html, body").animate({ scrollTop: 0 }, duration);
      return false;
    });
    //========== PAGE PROGRESS STARTS ============= // 

    //========== VIDEO POPUP STARTS ============= //
    if ($(".popup-youtube").length > 0) {
      $(".popup-youtube").magnificPopup({
        type: "iframe",
      });
    }
    //========== VIDEO POPUP ENDS ============= //
    AOS.init;
    AOS.init({ disable: 'mobile' });

    //========== NICE SELECT ============= //
    $('select:not([multiple]):not(.form-select)').niceSelect();

    //========== CASE IMAGE ============= //
    $('.cs_hover_active').hover(function () {
      $(this).addClass('active').siblings().removeClass('active');
    });
  });
  //========== COUNTER UP============= //
  const ucounter = $('.counter');
  if (ucounter.length > 0) {
    ucounter.countUp();
  };

  const color = $(".box-lists a.heart");
  color.on("click", function () {
    $(".box-lists a.heart");
    $(this).addClass("active");
  });

  const color1 = $(".love a");
  color1.on("click", function () {
    $(".love a");
    $(this).addClass("active");
  });

  //========== TESTIMONIAL AREA ============= //

  // testimonial //
  $('.header-carousel-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    dots: false,
    items: 10,
    mouseDrag: false,
    navText: ["<i class='fa-solid fa-angle-up'></i>", "<i class='fa-solid fa-angle-down'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  // testimonial //
  $('.instagram-posts-slider').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: false,
    items: 10,
    center: true,
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
        nav: false,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });
  // testimonial //
  $('.service-slider-area').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: false,
    items: 10,
    center: true,
    autoplay: true,
    navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"],
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      700: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });
  //testimonial slider
  $(".slider2").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slider1",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    fade: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 2000,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(".slider1").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 2000,
    loop: true,
    focusOnSelect: true,
    asNavFor: ".slider2",
    infinite: true,
    prevArrow: $('.next-arrow'),
    nextArrow: $('.prev-arrow'),
  });

  // testimonial //
  $('.header-carousel-area2').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    dots: false,
    items: 10,
    mouseDrag: false,
    navText: ["<i class='fa-solid fa-angle-up'></i>", "<i class='fa-solid fa-angle-down'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  // testimonial //
  $('.header-carousel-area3').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    dots: false,
    items: 10,
    mouseDrag: false,
    navText: ["<i class='fa-solid fa-angle-up'></i>", "<i class='fa-solid fa-angle-down'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  $('.about-slider-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  $('.about8-slider-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  $('.testimonial3-vertical-slider').slick({
    slidesToScroll: 2,
    arrows: true,
    dots: false,
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 2,
    autoplay: true,
    prevArrow: $(".testimonial-next-arrow"),
    nextArrow: $(".testimonial-prev-arrow"),
    responsive: [
      {
        breakpoint: 1400,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
        }
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
        }
      },

      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },

      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },

      {
        breakpoint: 375,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },

      {
        breakpoint: 320,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
    ]
  });

  $('.header-carousel-area4').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeIn',
    dots: false,
    items: 10,
    mouseDrag: false,
    navText: ["<i class='fa-solid fa-angle-up'></i>", "<i class='fa-solid fa-angle-down'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  $('.gallery-images-slider').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });

  // testimonial slider //
  $(".testimonial-nav").slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: ".slider-testimonial",
    dots: false,
    loop: true,
    centerMode: true,
    focusOnSelect: true,
    arrows: false,
  });

  $(".slider-testimonial").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    prevArrow: $(".testimonial-prev-arrow"),
    nextArrow: $(".testimonial-next-arrow"),
    fade: true,
    loop: true,
    asNavFor: ".testimonial-nav",
  });

  // testimonial //
  $(".testimonial-horizental-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slider-boxarea",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 2000,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(".slider-boxarea").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 2000,
    loop: true,
    focusOnSelect: true,
    vertical: true,
    asNavFor: ".testimonial-horizental-slider",
    infinite: true,
    prevArrow: $('.next-arrow'),
    nextArrow: $('.prev-arrow'),
  });

  // testimonial //
  $('.gallery-slider-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: false,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });

  // testimonial //
  $('.gallery2-slider-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: false,
    dots: false,
    rtl: true,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-arrow-left'></i>", "<i class='fa-solid fa-arrow-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });

  // testimonial //
  $('.gallery3-slider-area').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: false,
    items: 10,
    mouseDrag: true,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });
  // testimonial //
  $('.arpart-slider-area').owlCarousel({
    loop: false,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      }
    }
  });

  // testimonial //
  $('.center-slider').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    centerMode: true,
    arrows: false,
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          centerMode: true,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false,
        }
      },

      {
        breakpoint: 375,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false,
        }
      },
    ]
  });

  // testimonial //
  $(".header-slick-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slick-button-area",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    fade: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(".slick-button-area").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: true,
    autoplaySpeed: 4000,
    loop: true,
    focusOnSelect: true,
    items: 10,
    vertical: false,
    asNavFor: ".header-slick-slider",
    infinite: true,
  });

  // testimonial //
  $('.testimonial7-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 2,
      }
    }
  });


  // testimonial //
  $('.testimonial8-area').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 2,
      }
    }
  });

  // testimonial //
  $(".header3-slick-slider").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slick3-button-area",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    fade: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 4000,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(".slick3-button-area").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: false,
    loop: true,
    focusOnSelect: true,
    autoplaySpeed: 4000,
    items: 10,
    vertical: false,
    asNavFor: ".header3-slick-slider",
    infinite: true,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          vertical: true,
        }
      },
    ]
  });

  // testimonial //
  $(".testimonial-horizental-slider2").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    asNavFor: ".slider-boxarea2",
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    loop: true,
    autoplay: true,
    autoplaySpeed: 2000,
    infinite: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $(".slider-boxarea2").slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: true,
    autoplay: true,
    autoplaySpeed: 2000,
    loop: true,
    focusOnSelect: true,
    vertical: true,
    asNavFor: ".testimonial-horizental-slider2",
    infinite: true,
    prevArrow: $('.next-arrow'),
    nextArrow: $('.prev-arrow'),
  });

  // testimonial //
  $('.center-slider2').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    centerMode: true,
    arrows: false,
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          centerMode: true,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false,
        }
      },

      {
        breakpoint: 375,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          centerMode: false,
        }
      },
    ]
  });

  // testimonial //
  $('.details-slider').owlCarousel({
    loop: true,
    margin: 30,
    nav: true,
    dots: false,
    items: 10,
    navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
    autoplay: true,
    smartSpeed: 3000,
    autoplayTimeout: 4000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      }
    }
  });
  //========== PRELOADER ============= //
  $(window).on("load", function (event) {
    setTimeout(function () {
      $(".preloader").fadeToggle();
    }, 200);

    //========== GSAP AREA ============= //

    if ($('.text-anime-style-1').length) {
      let staggerAmount = 0.05,
        translateXValue = 0,
        delayValue = 0.5,
        animatedTextElements = document.querySelectorAll('.text-anime-style-1');

      animatedTextElements.forEach((element) => {
        let animationSplitText = new SplitText(element, { type: "chars, words" });
        gsap.from(animationSplitText.words, {
          duration: 1,
          delay: delayValue,
          x: 20,
          autoAlpha: 0,
          stagger: staggerAmount,
          scrollTrigger: { trigger: element, start: "top 85%" },
        });
      });
    }

    if ($('.text-anime-style-2').length) {
      let staggerAmount = 0.05,
        translateXValue = 20,
        delayValue = 0.5,
        easeType = "power2.out",
        animatedTextElements = document.querySelectorAll('.text-anime-style-2');

      animatedTextElements.forEach((element) => {
        let animationSplitText = new SplitText(element, { type: "chars, words" });
        gsap.from(animationSplitText.chars, {
          duration: 1,
          delay: delayValue,
          x: translateXValue,
          autoAlpha: 0,
          stagger: staggerAmount,
          ease: easeType,
          scrollTrigger: { trigger: element, start: "top 85%" },
        });
      });
    }

    if ($('.text-anime-style-3').length) {
      let animatedTextElements = document.querySelectorAll('.text-anime-style-3');

      animatedTextElements.forEach((element) => {
        //Reset if needed
        if (element.animation) {
          element.animation.progress(1).kill();
          element.split.revert();
        }

        element.split = new SplitText(element, {
          type: "lines,words,chars",
          linesClass: "split-line",
        });
        gsap.set(element, { perspective: 400 });

        gsap.set(element.split.chars, {
          opacity: 0,
          x: "50",
        });

        element.animation = gsap.to(element.split.chars, {
          scrollTrigger: { trigger: element, start: "top 90%" },
          x: "0",
          y: "0",
          rotateX: "0",
          opacity: 1,
          duration: 1,
          ease: Back.easeOut,
          stagger: 0.02,
        });
      });
    }

  });


  if ($('.reveal').length) {
    gsap.registerPlugin(ScrollTrigger);
    let revealContainers = document.querySelectorAll(".reveal");
    revealContainers.forEach((container) => {
      let image = container.querySelector("img"); let tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: "play none none none"
        }
      });
      tl.set(container,
        { autoAlpha: 1 });
      tl.from(container, 1.5,
        {
          xPercent: -100,
          ease: Power2.out
        });
      tl.from(image, 1.5,
        {
          xPercent: 100,
          scale: 1.3,
          delay: -1.5,
          ease: Power2.out

        });
    });
  }
  //========== GSAP BAR AREA ============= //

})(jQuery);


