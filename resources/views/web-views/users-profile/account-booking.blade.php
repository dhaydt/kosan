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
        border-radius: 5px;
    }

    .card-header .status {
        font-weight: 600;
    }
    .img-kos{
        height: 15px;
    }
    .title-kost {
        font-weight: 600;
    }
    .room-info{
        font-size: 14px;
        font-weight: 500;
    }
    .dated{
        color: #787878;
        font-size: 14px;
    }
    .date-date{
        font-size: 14px;
        font-weight: 600;
    }
    .see-more {
        font-size: 14px;
        font-weight: 600;
    }
    .price-card{
        font-weight: 600;
    }
    .price-card .satuan{
        font-weight: 400;
    }
    .fasilitas{
        font-weight: 600;
    }
    .data-penyewa {
        border: 1px solid #d1d1d1;
        border-radius: 5px;
    }
    .field{
        font-size: 14px;
        font-weight: 500;
        color: #383746;
        text-transform: capitalize;
    }
    .content{
        font-size: 14px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container pb-5 mb-2 mb-md-4 mt-3 rtl">
    <div class="row">
        @include('web-views.partials._profile-aside')
        <section class="col-lg-9 mt-2 col-md-9 booking-col">
            <h1 class="h3 float-left headerTitle w-100">{{\App\CPU\translate('booking')}}</h1>
            @foreach ($orders as $order)
            <div class="card w-100 mt-4">
                <div class="card-header">
                    @if ($order->order_status == 'pending')
                    <span class="status text-warning">Tunggu Konfirmasi</span>
                    @endif
                    @if ($order->order_status == 'processing')
                    <span class="status text-success">Dikonfirmasi</span>
                    @endif
                    @if ($order->order_status == 'delivered')
                    <span class="status text-success">Pembayaran berhasil</span>
                    @endif
                    @if ($order->order_status == 'canceled')
                    <span class="status text-danger">Booking dibatalkan</span>
                    @endif
                    {{-- {{ dd($orders) }} --}}
                    @php($detail = json_decode($order->details[0]->product_details))
                    @php($district = strtolower($detail->kost->district))
                    @php($city = strtolower($detail->kost->city))
                </div>
                <hr class="line">
                <div class="card-body">
                    <div class="row">
                        <img class="img-booking mr-3"
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{asset('storage/product')}}/{{json_decode($detail->images)[0]}}" alt="">
                        <div class="kost-detail d-flex flex-column">
                            <span class="title-kost capitalize">{{ $detail->kost->name }} {{ $detail->type }} {{ $district }} {{ $city }}</span>
                            <div class="status mt-1">
                                <img src="{{ asset('assets/front-end/img/room.png') }}" class="img-kos" alt="">
                                <span class="capitalize room-info ml-2">Kamar belum dikonfirmasi</span>
                            </div>
                            <div class="date row mt-1">
                                <div class="col-12">
                                    <img src="{{ asset('assets/front-end/img/date.png') }}" style="height: 15px" alt="">
                                    <span class="ml-2 dated">Tanggal masuk</span>
                                </div>
                                @php($date = Carbon\Carbon::parse($order->mulai)->isoFormat('dddd, D MMMM Y'))
                                <div class="ml-4 mt-1">
                                    <span class="date-date">{{ App\CPU\Helpers::dateChange($date) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="more-content d-none" id="more_content{{ $order->id }}">
                    <div class="row justify-content-center px-4 mb-4">
                        <div class="price mt-3 col-md-9 px2">
                            <span class="price-card">{{\App\CPU\Helpers::currency_converter($detail->purchase_price)}} <span class="satuan">/bulan</span></span>
                        </div>
                        <div class="col-md-9">
                            <div class="btn-fasilitas">
                                <a href="javascript:" class="fasilitas capitalize text-success" data-toggle="modal" data-target="#exampleModal">
                                    Lihat fasilitas
                                </a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    ...
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 data-penyewa p-3 mt-3">
                            <span class="title-kost capitalize">
                                data penyewa
                            </span>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="field">Nama</span>
                                    <span class="content">Muhammad Hidayat</span>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-3">
                                    <span class="field">Nomor Handphone</span>
                                    <span class="content">082382852283</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 data-penyewa p-3 mt-3">
                            <span class="title-kost capitalize">
                                detail booking
                            </span>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <span class="field">ID Booking</span>
                                    <span class="content">INROOM22021962</span>
                                </div>
                                <div class="col-12 d-flex justify-content-between mt-3">
                                    <span class="field">Tanggal Masuk</span>
                                    <span class="content">Senin, 09 Mei 2022</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($order->order_status == 'pending')
                    <div class="col-12 d-flex justify-content-end mb-4 pr-3">
                        <button onclick="route_alert('{{ route('order-cancel',[$order->id]) }}','{{\App\CPU\translate('ingin_membatalkan_bookingan_ini ?')}}')" class="btn btn-outline-success capitalize">
                            Batalkan booking
                        </button>
                    </div>
                    @endif
                </div>
                <div class="col-12 text-center mb-2">
                    <a href="javascript:" id="lengkap{{ $order->id }}" class="see-more text-success" onclick="lihat({{ $order->id }})">
                        Lihat selengkapnya
                        <i class="fa fa-chevron-down ml-2"></i>
                    </a>
                    <a href="javascript:" id="sedikit{{ $order->id }}" class="d-none see-more text-success" onclick="hide({{ $order->id }})">
                        Lihat lebih sedikit
                        <i class="fa fa-chevron-up ml-2"></i>
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
            @endforeach
        </section>
    </div>
</div>
@endsection
@push('script')
    <script>
        function lihat(val){
            $('#more_content' +  val).removeClass('d-none')
            $('#lengkap'+  val).addClass('d-none')
            $('#sedikit'+  val).removeClass('d-none')
        }
        function hide(val){
            $('#more_content'+  val).addClass('d-none')
            $('#lengkap'+  val).removeClass('d-none')
            $('#sedikit'+  val).addClass('d-none')
        }
    </script>
@endpush
