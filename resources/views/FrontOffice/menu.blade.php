
@extends('FrontOffice/layouts.app')


@section('content')


<div class="container-xxl bg-white p-0 mt-3" style="margin-top:15%;">
    <div class="container-xxl py-5" style="margin-top:8%;">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu</h5>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab-entree">
                            <i class="fas fa-utensils fa-2x text-primary"></i>
                            <div class="ps-3">
                                <h6 class="mt-n1 mb-0">Entrée</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3" data-bs-toggle="pill" href="#tab-plat">
                            <i class="fas fa-drumstick-bite fa-2x text-primary"></i>
                            <div class="ps-3">
                                <h6 class="mt-n1 mb-0">Plat</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3" data-bs-toggle="pill" href="#tab-dessert">
                            <i class="fas fa-ice-cream fa-2x text-primary"></i>
                            <div class="ps-3">
                                <h6 class="mt-n1 mb-0">Dessert</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-entree" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            @foreach ($entrees as $plat)
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $plat->photo) }}" alt="" style="width: 80px;">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span>{{ $plat->titre }}</span>
                                            </h5>
                                            <small class="fst-italic">{{ $plat->ingredients }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="tab-plat" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            @foreach ($plats as $plat)
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $plat->photo) }}" alt="" style="width: 80px;">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span>{{ $plat->titre }}</span>
                                            </h5>
                                            <small class="fst-italic">{{ $plat->ingredients }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="tab-dessert" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            @foreach ($desserts as $plat)
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('storage/' . $plat->photo) }}" alt="" style="width: 80px;">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span>{{ $plat->titre }}</span>
                                            </h5>
                                            <small class="fst-italic">{{ $plat->ingredients }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu End -->
</div>
@endsection







