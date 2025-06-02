<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>

                    <div class="carousel-inner">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($slider as $key => $slide)
                            @php
                                $i++;
                            @endphp
                            <div class="item {{ $i == 1 ? 'active' : '' }}">
                                <div class="col-sm-12">
                                    <img alt="{{ $slide->slider_desc }}"
                                         src="{{ asset('uploads/slider/' . $slide->slider_image) }}"
                                         class="img img-responsive img-slider">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section><!--/slider-->

<style type="text/css">
    /* CSS cho slider */
    #slider {
        padding: 20px 0;
        background-color: #f8f9fa; /* Màu nền nhẹ nhàng */
    }

    #slider-carousel {
        position: relative;
        overflow: hidden;
        border-radius: 15px; /* Bo góc cho slider */
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); /* Thêm bóng đổ */
    }

    .carousel-inner {
        transition: all 0.5s ease-in-out; /* Hiệu ứng chuyển slide mượt mà */
    }

    .carousel-inner .item {
        text-align: center;
    }

    .img-slider {
        height: 350px !important; /* Đảm bảo chiều cao cố định */
        width: 100%;
        object-fit: cover; /* Đảm bảo ảnh không bị méo */
        border-radius: 15px; /* Bo góc cho ảnh */
        transition: transform 0.3s ease; /* Hiệu ứng phóng to khi hover */
    }

    .img-slider:hover {
        transform: scale(1.05); /* Phóng to nhẹ khi hover */
    }

    /* CSS cho nút điều hướng */
    .control-carousel {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5); /* Nền nút điều hướng */
        color: #fff;
        font-size: 24px;
        line-height: 50px;
        text-align: center;
        border-radius: 50%; /* Hình tròn */
        transition: background-color 0.3s ease;
    }

    .control-carousel:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Hiệu ứng hover */
    }

    .left.control-carousel {
        left: 15px;
    }

    .right.control-carousel {
        right: 15px;
    }

    /* CSS cho các chấm chỉ báo (indicators) */
    .carousel-indicators {
        bottom: 10px;
    }

    .carousel-indicators li {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #ccc;
        border: none;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .carousel-indicators .active {
        background-color: #ff5733; /* Màu cam nổi bật cho chấm active */
        width: 14px;
        height: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .img-slider {
            height: 200px !important; /* Giảm chiều cao trên mobile */
        }

        .control-carousel {
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 20px;
        }
    }
</style>
