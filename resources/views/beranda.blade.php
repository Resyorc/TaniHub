@extends('layout.app')

@section('content')
<section class=" my-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div>
                    <img class="img-fluid w-100 d-block mx-auto" src="{{ asset('image/petani.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="text-start">
                    <h2 class="fw-bold display-5 mb-4">Apa itu TaniCare?</h2>
                    <p style="font-size: 18px;">BizHub merupakan aplikasi berbasis website yang diperuntukan kepada
                        pelaku UMKM
                        untuk dapat memasarkan
                        produk dan layanan kepada lebih banyak konsumen secara efektif dan efisien. BizHub memiliki
                        berbagai fitur
                        yang dapat membantu pelaku UMKM dan konsumen dalam menemukan dan memasarkan produk UMKM mereka.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="margin-section bg-soft-bizhub-secondary py-5">
    <div class="container">
        <div class="row align-items-center justify-content-beetween">
            <div class="col-12 col-lg-6">
                <div class="text-center">
                    <h3 class="fw-bold display-5">400</h3>
                    <p class="text-bizhub-secondary fw-semibold" style="font-size: 20px;">Perangkat</p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="text-center">
                    <h3 class="fw-bold display-5">300</h3>
                    <p class="text-bizhub-secondary fw-semibold" style="font-size: 20px;">Produk</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection