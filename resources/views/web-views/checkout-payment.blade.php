@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Pembayaran'))

@push('css_or_js')
    <style>
        .payment-title{
            font-weight: 600;
            color: #747474;
        }
        span.subtitle{
            color: #5b5b5b;
            font-weight: 500;
            font-size: 18px;
        }
        span.content {
            font-weight: 700;
            color: #818181;
        }
        span.content.price {
            width: 75%;
            text-align: right;
        }
        hr.line {
            border-top: 1px solid #cdcdcd;
        }
        .title-card {
            font-size: 16px;
            font-weight: 500;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .status-kos span {
            border: 1px solid #d1d1d1;
            text-transform: capitalize;
            border-radius: 5px;
            padding: 5px;
            margin-right: 10px;
            font-weight: 600;
            font-size: 12px;
        }
        span.price {
            font-size: 14px;
            color: #686868;
            font-weight: 600
        }
        .mulai .title{
            font-size: 14px;
        }
        .mulai span.content{
            font-weight: 600;
            color: #3e3e3e;
        }
        .info-box{
            border: 1px solid #747474;
            border-radius: 5px;
            padding: 5px;
        }
        .info-box .fa{
            color: #1e90ff;
        }
        .info-box span {
            font-size: 14px;
            font-weight: 500;
            color: #747474;
        }
    </style>

    {{--stripe--}}
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
    {{--stripe--}}
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 rtl"
         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
        <div class="row">
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>3])

                <!-- Payment methods accordion-->
                @php($ship = App\Model\CartShipping::where('cart_group_id', session()->get('cart_group_id'))->first())
                {{-- @if ($ship->shipping_cost !== "0.00") --}}
                <h2 class="pb-5 mb-3 mt-4 payment-title">{{\App\CPU\translate('Pembayaran')}}</h2>

                <div class="form-list">
                    <span class="subtitle mb-1 d-block">No. Booking</span>
                    <span class="content">{{ $order->id }}</span>
                    <hr class="line mt-4 mb-4">
                </div>
                <div class="form-list">
                    <span class="subtitle mb-1 d-block capitalize">Jenis pembayaran</span>
                    <span class="content">Bayar sewa kos</span>
                    <hr class="line mt-4 mb-4">
                </div>
                <div class="form-list">
                    <span class="subtitle mb-1 d-block capitalize">Metode pembayaran</span>
                    <div class="row">
                        <div class="col-6">
                            <span class="content">Pilih metode pembayaran</span>
                        </div>
                        <div class="col-6 text-right">
                            <span>Ubah</span>
                        </div>
                    </div>
                    <hr class="line mt-4 mb-4">
                </div>
                <div class="form-list d-flex justify-content-between w-100">
                    <span class="subtitle mb-1">Total Pembayaran</span>
                    <span class="content price">{{ \App\CPU\Helpers::currency_converter($order->details[0]->price) }}</span>
                    <hr class="line mt-4 mb-4">
                </div>
                <div class="row">
                @php($user = auth('customer')->user())
                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <form class="needs-validation" method="POST" id="payment-form"
                                action="{{route('xendit-payment.vaInvoice')}}">

                                <input type="hidden" name="type" value="OVO">
                                {{-- <input class="price" type="hidden" name="price" value="price"> --}}
                                {{ csrf_field() }}
                                <button class="btn btn-block" type="submit">
                                    <img width="150" style="margin-top: -10px"
                                    src="{{asset('public/assets/front-end/img/ovo.png')}}" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <form class="needs-validation" method="POST" id="payment-form"
                                action="{{route('xendit-payment.vaInvoice')}}">

                                <input type="hidden" name="type" value="DANA">
                                {{-- <input class="price" type="hidden" name="price" value="price"> --}}
                                {{ csrf_field() }}
                                <button class="btn btn-block" type="submit">
                                    <img width="150" style="margin-top: -10px"
                                    src="{{asset('public/assets/front-end/img/dana.png')}}" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4" style="cursor: pointer">
                    <div class="card">
                        <div class="card-body" style="height: 100px">
                            <form class="needs-validation" method="POST" id="payment-form"
                                action="{{route('xendit-payment.vaInvoice')}}">

                                <input type="hidden" name="type" value="BNI">
                                {{-- <input class="price" type="hidden" name="price" value="price"> --}}
                                {{ csrf_field() }}
                                <button class="btn btn-block" type="submit">
                                    <img width="150" style="margin-top: -10px"
                                    src="{{asset('public/assets/front-end/img/bni.png')}}" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                    @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                    @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)

                </div>
                {{-- @else --}}
                {{-- @php($shippingMethod=\App\CPU\Helpers::get_business_settings('shipping_method')) --}}
                @php($cart=\App\Model\Cart::where(['customer_id' => auth('customer')->id()])->get()->groupBy('cart_group_id'))

                @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                @php($amount = \App\CPU\CartManager::cart_grand_total() - $coupon_discount)
                {{-- @endif --}}

                    <!-- Navigation (desktop)-->
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a class="btn btn-secondary btn-block" href="{{route('checkout-details')}}">
                                <span class="d-none d-sm-inline">{{\App\CPU\translate('Back to Shipping')}}</span>
                                <span class="d-inline d-sm-none">{{\App\CPU\translate('Back')}}</span>
                            </a>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
            </section>
            <!-- Sidebar-->
            <div class="side-section col-lg-4 mt-5">
                <div class="card p-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <div class="title-card">
                                    <span class="">
                                        Kost Programmer Tipe A Gedong Tengen Yogyakarta
                                    </span>
                                </div>
                                <div class="status-kos mt-2">
                                    <span>
                                        {{-- {{ $detail->kost->penghuni }} --}}
                                        perempuan
                                    </span>
                                    <span>
                                        no kamar
                                    </span>
                                </div>
                                <div class="mt-2">
                                    <span class="price">
                                        Perbulan - Rp.1.900.000
                                    </span>
                                </div>
                            </div>
                            <div class="col-4 img-div">
                                <img class="w-100" src="{{ asset('assets/front-end/img/kos.jpg') }}" style="border-radius: 6px">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row px-0">
                            <div class="col-12 d-flex justify-content-between mt-2 px-0 mulai ">
                                <span class="capitalize title">Mulai sewa</span>
                                {{-- <span>{{ App\CPU\Helpers::dateChange($date) }}</span> --}}
                                <span class="content">12, feb 2022</span>
                            </div>
                            <div class="col-12 d-flex justify-content-between mt-3 px-0 mulai">
                                <span class="capitalize title">Durasi sewa</span>
                                {{-- <span>{{ $order->durasi }} Bulan</span> --}}
                                <span class="content">1 bulan</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="title-card capitalize d-block">
                            Informasi penyewa
                        </span>
                        <span class="content d-block mb-3" style="font-weight: 500;">
                            Muhammad Hidayat
                        </span>
                        <div class="row info-box">
                            <div class="col-1 text-center">
                                <i class="fa fa-info-circle text-blue mt-1"></i>
                            </div>
                            <div class="col-11">
                                <span>
                                    Mohon tunjukan kartu identitas asli pada pemilik kos saat masuk
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    @if(env('APP_MODE')=='live')
        <script id="myScript"
                src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    @else
        <script id="myScript"
                src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    @endif

    <script>
        setTimeout(function () {
            $('.stripe-button-el').hide();
            $('.razorpay-payment-button').hide();
        }, 10)
    </script>


<script>
    cartQuantityInitialize();

    function set_shipping_id(id, cart_group_id) {
        $.get({
            url: '{{url('/')}}/customer/set-shipping-method',
            dataType: 'json',
            data: {
                id: id,
                cart_group_id: cart_group_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                location.reload();
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }
</script>


    <script type="text/javascript">
        function BkashPayment() {
            $('#loading').show();
            // get token
            $.ajax({
                url: "{{ route('bkash-get-token') }}",
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    $('pay-with-bkash-button').trigger('click');
                    if (data.hasOwnProperty('msg')) {
                        showErrorMessage(data) // unknown error
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err);
                }
            });
        }

        let paymentID = '';
        bKash.init({
            paymentMode: 'checkout',
            paymentRequest: {},
            createRequest: function (request) {
                setTimeout(function () {
                    createPayment(request);
                }, 2000)
            },
            executeRequestOnAuthorization: function (request) {
                $.ajax({
                    url: '{{ route('bkash-execute-payment') }}',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "paymentID": paymentID
                    }),
                    success: function (data) {
                        if (data) {
                            if (data.paymentID != null) {
                                BkashSuccess(data);
                            } else {
                                showErrorMessage(data);
                                bKash.execute().onError();
                            }
                        } else {
                            $.get('{{ route('bkash-query-payment') }}', {
                                payment_info: {
                                    payment_id: paymentID
                                }
                            }, function (data) {
                                if (data.transactionStatus === 'Completed') {
                                    BkashSuccess(data);
                                } else {
                                    createPayment(request);
                                }
                            });
                        }
                    },
                    error: function (err) {
                        bKash.execute().onError();
                    }
                });
            },
            onClose: function () {
                // for error handle after close bKash Popup
            }
        });

        function createPayment(request) {
            // because of createRequest function finds amount from this request
            request['amount'] = "{{round(\App\CPU\Convert::usdTobdt($amount),2)}}"; // max two decimal points allowed
            $.ajax({
                url: '{{ route('bkash-create-payment') }}',
                data: JSON.stringify(request),
                type: 'POST',
                contentType: 'application/json',
                success: function (data) {
                    $('#loading').hide();
                    if (data && data.paymentID != null) {
                        paymentID = data.paymentID;
                        bKash.create().onSuccess(data);
                    } else {
                        bKash.create().onError();
                    }
                },
                error: function (err) {
                    $('#loading').hide();
                    showErrorMessage(err.responseJSON);
                    bKash.create().onError();
                }
            });
        }

        function BkashSuccess(data) {
            $.post('{{ route('bkash-success') }}', {
                payment_info: data
            }, function (res) {
                @if(session()->has('payment_mode') && session('payment_mode') == 'app')
                    location.href = '{{ route('payment-success')}}';
                @else
                    location.href = '{{route('order-placed')}}';
                @endif
            });
        }

        function showErrorMessage(response) {
            let message = 'Unknown Error';
            if (response.hasOwnProperty('errorMessage')) {
                let errorCode = parseInt(response.errorCode);
                let bkashErrorCode = [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014,
                    2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030,
                    2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046,
                    2047, 2048, 2049, 2050, 2051, 2052, 2053, 2054, 2055, 2056, 2057, 2058, 2059, 2060, 2061, 2062,
                    2063, 2064, 2065, 2066, 2067, 2068, 2069, 503,
                ];
                if (bkashErrorCode.includes(errorCode)) {
                    message = response.errorMessage
                }
            }
            Swal.fire("Payment Failed!", message, "error");
        }
    </script>
@endpush
