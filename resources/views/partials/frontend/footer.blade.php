<!--===== FOOTER AREA STARTS =======-->
<div class="footer10-section-area" id="contact-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-instagram-area">
                    <div class="row justify-content-center">
                        <div class="col-lg-8" data-aos="zoom-in-down" data-aos-duration="1000">
                            <div class="footer-contact-box">
                                <h3>Send Us A Message</h3>
                                <div class="space16"></div>
                                <form action="{{ route('contact.send') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <input type="text" name="name" placeholder="Your Name*" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <input type="number" name="phone" placeholder="Mobile Number*">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="space16"></div>
                                            <div class="input-area">
                                                <textarea name="message" placeholder="Your Message*" required
                                                    minlength="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="space32"></div>
                                            <div class="input-area text-end">
                                                <button type="submit" class="header-btn11">Send Message <i
                                                        class="fa-solid fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                        @if(session('success'))
                                            <div class="col-lg-12">
                                                <div class="space16"></div>
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--<div class="col-lg-6">
                            <div class="instagram-images">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="800">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="{{ asset('assets/img/all-images/others/others-img7.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="{{ asset('assets/img/all-images/others/others-img8.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 col-md-6" data-aos="fade-up" data-aos-duration="1200">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="{{ asset('assets/img/all-images/others/others-img9.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-5 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                                        <div class="instagram-posts">
                                            <div class="img1">
                                                <img src="{{ asset('assets/img/all-images/others/others-img10.png') }}"
                                                    alt="">
                                            </div>
                                            <div class="icons">
                                                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="space40"></div>
    <div class="footer10-bottom-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-bottom-area">
                        <div class="footer-menu-area">
                            <div class="footer-logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo/stay-smart.png') }}"
                                        alt=""></a>
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ url('properties') }}#apartment">Apartments</a></li>
                                    <!--<li class="space24"></li>
                                    <li><a href="{{ url('/') }}#gallery">Gallery</a></li>-->
                                </ul>
                            </div>
                            <!--<div class="footer-menu">
                                <ul>
                                    <li><a href="javascript:void(0);">Blog</a></li>
                                    <li class="space24"></li>
                                    <li><a href="#">Pages</a></li>
                                    <li class="space24"></li>
                                    <li><a href="javascript:void(0);">Contact</a></li>
                                </ul>
                            </div>--->
                            <div class="footer-menu">
                                <ul>
                                    <li><a href="{{ route('register.apartment') }}">List Your Apartment</a></li>
                                    <li class="space24"></li>
                                    <li><a href="{{ route('lease.staysmart') }}">Lease to Stay Smart</a></li>
                                </ul>
                            </div>
                            <div class="footer-social">
                                <ul>
                                    <li><a href="tel:+(234) 704 447 9938"><span><i
                                                    class="fa-solid fa-phone"></i></span></a></li>
                                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                                    <!--<li><a href="#"><i class="fa-brands fa-youtube"></i></a></li-->
                                </ul>
                                <div class="space16"></div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="space48"></div>
                                <div class="copyright-area">
                                    <p>© 2026 Stay Smart Apartments</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== FOOTER AREA ENDS =======-->
</div>
<!--===== JS SCRIPT LINK =======-->
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fontawesome.js') }}"></script>
<script src="{{ asset('assets/js/plugins/aos.js') }}"></script>
<script src="{{ asset('assets/js/plugins/counter.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sidebar.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup.js') }}"></script>
<script src="{{ asset('assets/js/plugins/mobilemenu.js') }}"></script>
<script src="{{ asset('assets/js/plugins/owlcarousel.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/nice-select.js') }}"></script>
<script src="{{ asset('assets/js/plugins/waypoints.js') }}"></script>
<script src="{{ asset('assets/js/plugins/slick-slider.js') }}"></script>
<script src="{{ asset('assets/js/plugins/circle-progress.js') }}"></script>
<script src="{{ asset('assets/js/plugins/gsap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ScrollTrigger.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/Splitetext.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>