<!-- Footer Start -->
<div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Get In Touch</h5>
                <p><i class="fa fa-map-marker-alt me-3"></i>{{ config('site.address') }}</p>
                <p><i class="fa fa-phone-alt me-3"></i>{{ config('site.phone') }}</p>
                <p><i class="fa fa-envelope me-3"></i>{{ config('site.email') }}</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href="{{ config('site.social.twitter') }}"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{ config('site.social.facebook') }}"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{ config('site.social.youtube') }}"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{ config('site.social.instagram') }}"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href="{{ config('site.social.linkedin') }}"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Popular Link</h5>
                <a class="btn btn-link" href="{{ route('about') }}">About Us</a>
                <a class="btn btn-link" href="{{ route('contact') }}">Contact Us</a>
                <a class="btn btn-link" href="{{ route('service') }}">Our Services</a>
                <a class="btn btn-link" href="{{ route('project') }}">Our Projects</a>
                <a class="btn btn-link" href="{{ route('contact') }}">Get a Quote</a>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Project Gallery</h5>
                <div class="row g-2">
                    @foreach (config('site.projects') as $project)
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('img/' . $project['img']) }}" alt="{{ $project['title'] }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Newsletter</h5>
                <p>Get the latest digital marketing tips, trends and offers delivered straight to your inbox.</p>
                <div class="position-relative w-100 mt-3">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                    <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="{{ route('home') }}">{{ config('site.name') }}</a>, All Rights Reserved {{ date('Y') }}.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('service') }}">Services</a>
                        <a href="{{ route('project') }}">Projects</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
