<style>
    .brand-slider .owl-carousel .owl-item img{
        max-height: unset;
    }
    .banner-card {
        border-radius: 20px;
        overflow: hidden;
        max-height: 290.89px;
    }
    .brand-slider .owl-theme .owl-dots{
        text-align: left;
    }
    .brand-slider .owl-stage-outer .owl-stage{
        /* margin-left: 200px; */
    }
    .owl-dot.active span {
        background-color: #f15151 !important;
    }
    @media(max-width: 600px){
        .brand-slider .owl-stage-outer .owl-stage{
            margin-left: 0;
        }
        .banner-card {
            border-radius: 8px;
        }
    }
</style>

<div class="row rtl">
    {{-- <div class="col-xl-3 d-none d-xl-block">
        <div class="just-padding"></div>
    </div> --}}

    <div class="col-xl-12 col-md-12" style="margin-top: 20px">
        @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
        <div class="mt-2 mb-3 brand-slider">
            <div class="owl-carousel owl-theme " id="banner-slider-custom">
                @foreach($main_banner as $key=>$banner)
                    <div class="banner-card p-0">
                        <a href="{{$banner['url']}}">
                            <img class="d-block w-100"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset('storage/banner')}}/{{$banner['photo']}}"
                                 alt="">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <!-- Banner group-->
</div>


<script>
    $(function () {
        $('.list-group-item').on('click', function () {
            $('.glyphicon', this)
                .toggleClass('glyphicon-chevron-right')
                .toggleClass('glyphicon-chevron-down');
        });
    });
</script>
