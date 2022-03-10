@extends('layouts.front-end.app')
@section('title',\App\CPU\translate('My_booking_list'))

@push('css_or_js')
<style>
    .booking-col{
        border: 1px solid #d1d1d1;
        border-radius: 8px;
        padding: 10px 17px;
    }
    .headerTitle {
        font-weight: 600;
        color: #7f7f7f;
    }
    .img-booking{
        height: 84px;
        width: 90px;
    }
</style>
@endpush

@section('content')
<div class="container pb-5 mb-2 mb-md-4 mt-3 rtl">
    <div class="row">
        @include('web-views.partials._profile-aside')
        <section class="col-lg-9 mt-2 col-md-9 booking-col">
            <h1 class="h3 float-left headerTitle w-100">{{\App\CPU\translate('booking')}}</h1>
            <div class="card w-100 mt-4">
                <div class="card-header">
                    <span class="text-warning">Tunggu Konfirmasi</span>
                </div>
                <hr class="line">
                <div class="card-body">
                    <div class="row">
                        <img class="img-booking mr-3" src="{{ asset('assets/front-end/img/maintenance-mode.jpg') }}" alt="">
                        <div class="kost-detail d-flex flex-column">
                            <span class="title-kost">Kost programmer</span>
                            <div class="status">
                                <img src="{{ asset('assets/front-end/img/room.png') }}" style="height: 15px" alt="">
                                <span>Kamar belum dikonfirmasi</span>
                            </div>
                            <div class="date row">
                                <div class="col-12">
                                    <img src="{{ asset('assets/front-end/img/date.png') }}" style="height: 15px" alt="">
                                    <span>Tanggal masuk</span>
                                </div>
                                <div class="ml-4">
                                    <span>09 Mei 2022</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="more-content">
                    <div class="row justify-content-center">
                        <div class="price mt-3 col-md-9 px2">
                            <span class="price-card">Rp.1.900.000 <span class="satuan">/bulan</span></span>
                        </div>
                        <div class="col-md-9">
                            <div class="btn-fasilitas">
                                <a href="javascript:" class="fasilitas capitalize">
                                    Lihat fasilitas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mb-2">
                    <a href="javascript:" class="see-more">
                        Lihat selengkapnya
                        <i class="fa fa-chevron-down ml-2"></i>
                    </a>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-outline-success">
                                Chat pemilik
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
