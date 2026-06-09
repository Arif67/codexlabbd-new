<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container px-lg-5">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="section-title position-relative mb-4 pb-2">
                    <h6 class="position-relative text-primary ps-4">About Us</h6>
                    <h2 class="mt-2">Your technology & growth partner</h2>
                </div>
                <p class="mb-4">{{ config('site.name') }} is a custom software development company helping businesses build powerful web, mobile and enterprise applications. Alongside engineering, our digital marketing team drives traffic, leads and revenue — so you get a great product and the growth to match.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Custom-Built Software</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Experienced Engineers</h6>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Agile Delivery</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>24/7 Support</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                    <a class="btn btn-primary rounded-pill px-4 me-3" href="{{ route('contact') }}">Read More</a>
                    <a class="btn btn-outline-primary btn-square me-3" href="{{ config('site.social.facebook') }}"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary btn-square me-3" href="{{ config('site.social.twitter') }}"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary btn-square me-3" href="{{ config('site.social.instagram') }}"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-primary btn-square" href="{{ config('site.social.linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{ asset('img/about.jpg') }}" alt="About {{ config('site.name') }}">
            </div>
        </div>
    </div>
</div>
<!-- About End -->
