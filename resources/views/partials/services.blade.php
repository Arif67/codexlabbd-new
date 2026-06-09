<!-- Service Start -->
<div class="container-fluid py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Services</h6>
            <h2 class="mt-2">What Solutions We Provide</h2>
        </div>
        <div class="row g-4">
            @forelse ($services as $i => $service)
                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="{{ 0.1 + ($i % 3) * 0.2 }}s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa {{ $service->icon }} fa-2x"></i>
                        </div>
                        <h5 class="mb-3">{{ $service->title }}</h5>
                        <p>{{ $service->description }}</p>
                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('contact') }}">Read More</a>
                    </div>
                </div>
            @empty
                <p class="text-center">No services available right now.</p>
            @endforelse
        </div>
    </div>
</div>
<!-- Service End -->
