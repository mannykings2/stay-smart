<!--===== PRELOADER STARTS =======-->
<div class="preloader"
    style="background-image: url('{{ asset('assets/img/logo/preloader.gif') }}'); filter: hue-rotate(315deg) saturate(80%)">
</div>
<!--===== PRELOADER ENDS =======-->

<!--===== PROGRESS STARTS=======-->
<div class="paginacontainer">
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
</div>
<!--===== PROGRESS ENDS=======-->

<!--=====HEADER START=======-->
<header>
    <div class="header-area homepage10 header header-sticky d-none d-lg-block " id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav id="navbar-example2" class="navbar">
                        <div class="header-elements">
                            <div class="site-logo">
                                <a href="/"><img src="{{ asset('assets/img/logo/stay-smart.png') }}" alt=""></a>
                            </div>
                            <div class="main-menu">
                                <ul>
                                    <li class="nav-item"><a href="{{ url('properties') }}"
                                            class="nav-link"><span>Apartments</span></a></li>
                                    <li class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="partnerDropdown" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>Partner with Us</span>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="partnerDropdown">
                                            <li><a class="dropdown-item" href="{{ route('register.apartment') }}">List
                                                    Your
                                                    Apartment</a></li>
                                            <li><a class="dropdown-item" href="{{ route('lease.staysmart') }}">Lease to
                                                    Stay Smart</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a href="{{ url('/') }}#property" class="nav-link"><span>Book a
                                                Service</span></a></li>
                                    <li class="nav-item"><a href="{{route('home')}}" class="nav-link"><span>My
                                                Account</span></a></li>
                                </ul>
                            </div>
                            <div class="btn-area4">
                                @guest
                                    <a href="{{ route('auth.google') }}"
                                        class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2"
                                        style="border-radius: 20px; padding: 5px 15px; font-weight: 500; border: 1px solid #ddd;">
                                        <!--<img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                                                            alt="Google" width="18">-->
                                        <img src="assets/img/all-images/about/google.svg" alt="Google" width="18">
                                        Sign In With Google
                                    </a>
                                @else
                                    <a href="{{ route('home') }}"
                                        class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2"
                                        style="border-radius: 20px; padding: 5px 15px; font-weight: 500; border: 1px solid #ddd;">
                                        <i class="fa-solid fa-user"></i>Account
                                    </a>
                                @endguest
                            </div>
                            <div class="body-overlay"></div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!--=====HEADER END =======-->

<!--===== MOBILE HEADER STARTS =======-->
<div class="mobile-header mobile-haeder10 d-block d-lg-none">
    <div class="container-fluid">
        <div class="col-12">
            <div class="mobile-header-elements">
                <div class="mobile-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/stay-smart.png') }}" alt=""></a>
                </div>
                <div class="mobile-nav-icon dots-menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-sidebar mobile-sidebar10">
    <div class="logosicon-area">
        <div class="logos">
            <img src="{{ asset('assets/img/logo/stay-smart.png') }}" alt="">
        </div>
        <div class="menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="mobile-nav mobile-nav1">
        <ul class="mobile-nav-list nav-list1">
            <li class="nav-item"><a href="{{ url('/') }}#apartment" class="nav-link"><span>Apartments</span></a></li>

            <!-- Partner with Us Dropdown -->
            <li>
                <a href="#">Partner with Us</a>
                <ul>
                    <li><a href="{{ route('register.apartment') }}">List Your Apartment</a></li>
                    <li><a href="{{ route('lease.staysmart') }}">Lease to Stay Smart</a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="{{ url('/') }}#property" class="nav-link"><span>Book a Service</span></a></li>
            <li class="nav-item"><a href="{{route('home')}}" class="nav-link"><span>My Account</span></a></li>
        </ul>

        <style>
            /* Harmonize all mobile menu font sizes */
            .mobile-nav-list .nav-item .nav-link {
                font-size: 16px !important;
                font-weight: 500;
            }

            .mobile-nav-list .nav-item .nav-link span {
                font-size: inherit;
            }

            /* Hide submenu by default */
            .mobile-nav-list li ul {
                display: none;
            }

            /* Style submenu items when open */
            .mobile-nav-list li ul {
                padding-left: 20px;
                background-color: rgba(255, 255, 255, 0.05);
                border-radius: 8px;
                margin-top: 8px;
                margin-bottom: 8px;
            }

            .mobile-nav-list li ul li a {
                font-size: 15px !important;
                padding: 10px 15px;
                display: block;
            }
        </style>


        <div class="allmobilesection">
            <a href="{{route('home')}}" class="header-btn11">Get Started <span><i
                        class="fa-solid fa-arrow-right"></i></span></a>
            <div class="single-footer">
                <h3>Contact Info</h3>
                <div class="footer1-contact-info">
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="tel:+(234)7044479938">+(234) 704 447 9938
                            </a>
                        </div>
                    </div>

                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="contact-info-text">
                            <a href="mailto:info@staysmartbookings.com">info@staysmartbookings.com
                            </a>
                        </div>
                    </div>

                    <div class="single-footer">
                        @guest
                            <a href="{{ route('auth.google') }}"
                                class="header-btn11 w-100 justify-content-center d-flex align-items-center gap-2"
                                style="margin-top: 20px;">
                                <!--<img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google"
                                            width="18" style="filter: brightness(0) invert(1);">-->
                                <img src="assets/img/all-images/about/google.svg" alt="Google" width="18"
                                    style="filter: brightness(0) invert(1);">
                                Sign In with Google
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== MOBILE HEADER STARTS =======-->