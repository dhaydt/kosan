{{-- @php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews)) --}}
<style>
.ell{
    /* width: 500px !important; */
}
.ell p {
    text-overflow:ellipsis;
    overflow:hidden;
    display: -webkit-box !important;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    white-space: normal;
    font-size: 12px;
}
.search-card{
    display: flex;
    flex-direction: column;
    height: 200px;
    background-color: transparent;
}
.img-box-search{
    background: #999;
    border-radius: 8px;
    display: flex;
    height: 100%;
    overflow: hidden;
    position: relative;
    width: 60px;
    height: 60px;
}
.img-box-search img{
    height: 100%;
    width: 100%;
}
.product-card{
    position: relative;
    background-color: #fff;
}
.product-card .card-body.inline_product_search{
    background-color: #fff;
}
.rc-price__additional-data{
    justify-content: start;
}
.label-kost {
    position: absolute;
    left: 78%;
    top: 15px;
    padding: 3px 10px;
    border-radius: 5px;
    font-weight: 400;
    width: 82px;
    font-size: 13px;
    text-align: center;
    z-index: 5;
}
.job-name{
    font-size: 15px;
    font-weight: 600;
}
@media(max-width: 600px){
    .ell p {
        -webkit-line-clamp: 2;
        font-size: 10px;
    }
    .rc-price__additional-data{
        justify-content: start;
    }
}
</style>
<div class="product-card search-card card {{$product['current_stock']==0?'stock-card':''}}"
    style="margin-bottom: 10px; box-shadow: none;">
    <label class="label-kost text-white text-uppercase" style="background-color: {{ $web_config['primary_color'] }};">{{ $product->status_employe }}</label>

        <div class="card-header px-3 pt-3 inline_product clickable p-0 pb-3 d-flex flex-row" style="cursor: pointer;">
            <div class="d-flex align-items-center justify-content-center d-block img-box-search">
                <a href="{{route('product',$product->id)}}" class="h-100 w-100">
                    <img
                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                        src="{{ asset('storage/jobs').'/'.$p['logo'] }}"
                        >
                </a>
            </div>
            <div class="job-name ml-2 capitalize text-left text-success">
                {{ $product->name }}
            </div>
        </div>

        <div class="card-body d-flex flex-column justify-content-between inline_product_search text-left px-3 p-0 clickable"
        style="cursor: pointer;">
        <div class="rating-show d-flex">
            @if ($product->hide_gaji == '1')
            <div class="rc-overview__label bg-c-label capitalize">{{ \App\CPU\Helpers::currency_converter($product->gaji) }} /{{ $product->satuan_gaji }}</div>
            @endif
            {{-- <div class="rc-overview__label bg-c-label capitalize">{{ \App\CPU\Helpers::currency_converter($product->gaji) }}</div> --}}
            @if ($product->current_stock <= 3)
            <span class="stock-label ml-1 text-danger bg-c-text--label-1">
                {{\App\CPU\translate('Buka_sampai : ')}} {{ Carbon\Carbon::parse($product->expire)->format('3 M, Y') }}
            </span>
            @endif
        </div>
        <div class="kost-rc__info">
            <a href="{{route('product',$product->id)}}">
                <div class="rc-info">
                    @php($city = strtolower($product->city))
                    @php($district = strtolower($product->district))
                    <span class="rc-info__name bg-c-text bg-c-text--body-4 capitalize">
                        {{ $product->name }} - {{ $product->company_name }}
                    </span>
                    <span class="rc-info__location bg-c-text bg-c-text--body-3 capitalize">
                        {{ $district, $city }}
                    </span>
                </div>
            </a>
        </div>
        @php($fas = json_decode($product->fasilitas_id))
        <div class="kost-rc__facilities">
            <div class="ell">
                <p class="mb-0">
                    <span>
                        {{-- <span class="capitalize">{{ App\CPU\Helpers::fasilitas($f) }}</span> --}}
                        <span class="rc-facilities_divider">·</span>
                    </span>
                </p>

            </div>
        </div>
        {{-- <div class="price_landscape d-flex">
            <div class="kost-rc__price h-100">
                <div class="rc-price mt-auto">
                    @if($product->discount > 0)
                    <div class="rc-price__additional-data">
                        <div class="price-discount">
                            <span class="rc-price__discount-icon" aria-hidden="true">{{
                                \App\CPU\translate('Hemat')}}</span>
                            <span class="rc-price__additional-discount bg-c-text bg-c-text--label-1 ">
                                @if ($product->discount_type == 'percent')
                                {{round($product->discount,2)}}%
                                @elseif($product->discount_type =='flat')
                                {{\App\CPU\Helpers::currency_converter($product->discount)}}
                                @endif
                            </span>
                        </div>
                        <span class="rc-price__additional-discount-price bg-c-text bg-c-text--label-2 ">
                            @if($product->discount > 0)
                                <strike style="font-size: 12px!important;color: grey!important;">
                                    {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                </strike><br>
                            @endif
                        </span>
                    </div>
                    @endif
                    <div class="rc-price__section">
                        <div class="rc-price__real d-flex d-md-none">
                            <span class="rc-price__text bg-c-text bg-c-text--body-1 ">
                                {{\App\CPU\Helpers::currency_converter(
                                    $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                    )}}
                            </span>
                            <span class="rc-price__type bg-c-text bg-c-text--body-2 ">
                                / Bulan
                            </span>
                        </div>
                        <div class="rc-price__real d-none d-md-flex">
                            <span class="rc-price__text bg-c-text bg-c-text--body-1 ">
                                {{\App\CPU\Helpers::currency_converter(
                                    $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                    )}}
                            </span>
                            <span class="rc-price__type bg-c-text bg-c-text--body-2 ">
                                / Bulan
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
