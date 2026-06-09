<!-- Portfolio Start -->
<div class="container-fluid py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Projects</h6>
            <h2 class="mt-2">Recently Launched Projects</h2>
        </div>
        <div class="row g-4">
            @forelse ($projects as $i => $project)
                <div class="col-lg-4 col-md-6 portfolio-item wow zoomIn" data-wow-delay="{{ 0.1 + ($i % 3) * 0.2 }}s">
                    <div class="position-relative rounded overflow-hidden">
                        <img class="img-fluid w-100" src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        <div class="portfolio-overlay">
                            <a class="btn btn-light" href="{{ $project->image_url }}"><i class="fa fa-plus fa-2x text-primary"></i></a>
                            <div class="mt-auto">
                                <small class="text-white"><i class="fa fa-folder me-2"></i>{{ $project->category }}</small>
                                <a class="h5 d-block text-white mt-1 mb-0" href="{{ route('project') }}">{{ $project->title }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No projects to show yet.</p>
            @endforelse
        </div>
    </div>
</div>
<!-- Portfolio End -->
