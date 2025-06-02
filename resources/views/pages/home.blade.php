@extends('layout')

@section('slider')
    @include('pages.include.slider')
@endsection

@section('sidebar')
    @include('pages.include.sidebar')
@endsection

@section('content')
    <div class="features_items">
        <p></p>
        <h2 class="title text-center">Sản phẩm mới nhất</h2>

        @foreach($all_product as $pro)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a href="{{ url('chi-tiet/'.$pro->product_slug) }}">
                                <img src="{{ url('uploads/product/'.$pro->product_image) }}" alt="{{ $pro->product_name }}" />
                                <h2>{{ number_format($pro->product_price, 0, ',', '.') }} VNĐ</h2>
                                <p>{{ $pro->product_name }}</p>
                            </a>
                            <input type="hidden" class="cart_product_id_attribute" value="0">
                            <input type="hidden" class="product_id" value="{{ $pro->product_id }}">
                            <!-- Thêm các trường ẩn để lưu thông tin sản phẩm -->
                            <input type="hidden" id="wishlist_productname{{ $pro->product_id }}" value="{{ $pro->product_name }}">
                            <input type="hidden" id="wishlist_productprice{{ $pro->product_id }}" value="{{ number_format($pro->product_price, 0, ',', '.') }} VNĐ">
                            <input type="hidden" id="wishlist_productimage{{ $pro->product_id }}" value="{{ url('uploads/product/'.$pro->product_image) }}">
                            <input type="hidden" id="wishlist_producturl{{ $pro->product_id }}" value="{{ url('chi-tiet/'.$pro->product_slug) }}">

                            <button class="btn btn-default home_cart_{{ $pro->product_id }}" id="{{ $pro->product_id }}" onclick="Addtocart(this.id);"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
                            <button style="display:none" class="btn btn-danger rm_home_cart_{{ $pro->product_id }}" id="{{ $pro->product_id }}" onclick="Deletecart(this.id);"><i class="fa fa-shopping-cart"></i>Bỏ đã thêm</button>

                            <input type="button" data-toggle="modal" data-target="#xemnhanh" onclick="XemNhanh(this.id);" value="Xem nhanh" class="btn btn-default" id="{{ $pro->product_id }}" name="add-to-cart">
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li>
                                        <i class="fa fa-plus-square"></i>
                                        <button class="button_wishlist" id="{{ $pro->product_id }}" onclick="add_wistlist(this.id);"><span>Yêu thích</span></button>
                                    </li>
                                    <li><a style="cursor: pointer;" onclick="add_compare({{ $pro->product_id }})"><i class="fa fa-plus-square"></i>So sánh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-sm-12 mt-3">
            <div class="text-center">
                {{ $all_product->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div id="all_product"></div>
    <div id="cart_session"></div>

    <!-- Modal giỏ hàng -->
    <div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Giỏ hàng của bạn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="show_quick_cart_alert"></div>
                    <div id="show_quick_cart"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal so sánh -->
    <div class="modal fade" id="sosanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">So sánh sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="row_compare">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Image</th>
                            <th scope="col">View</th>
                            <th scope="col">Management</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xem nhanh -->
    <div class="modal fade" style="margin-top:50px" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title product_quickview_title">
                        <span id="product_quickview_title"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <style type="text/css">
                        span#product_quickview_content img {
                            width: 100%;
                        }

                        @media screen and (min-width: 768px) {
                            .modal-dialog {
                                width: 700px;
                            }
                            .modal-sm {
                                width: 350px;
                            }
                        }

                        @media screen and (min-width: 992px) {
                            .modal-lg {
                                width: 1200px;
                            }
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-5">
                            <span id="product_quickview_image"></span>
                            <span id="product_quickview_gallery"></span>
                        </div>
                        <form>
                            @csrf
                            <div id="product_quickview_value"></div>
                            <div class="col-md-7">
                                <h2><span id="product_quickview_title"></span></h2>
                                <p>Mã ID: <span id="product_quickview_id"></span></p>
                                <p style="font-size: 20px; color: brown;font-weight: bold;">Giá sản phẩm: <span id="product_quickview_price"></span></p>
                                <label>Số lượng:</label>
                                <input name="qty" type="number" min="1" class="cart_product_qty_" value="1" />
                                <h4 style="font-size: 20px; color: brown;font-weight: bold;">Mô tả sản phẩm</h4>
                                <hr>
                                <p><span id="product_quickview_desc"></span></p>
                                <p><span id="product_quickview_content"></span></p>
                                <div id="product_quickview_button"></div>
                                <div id="beforesend_quickview"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-default redirect-cart">Đi tới giỏ hàng</button>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        div#quick-cart {
            margin-top: 60px;
        }

        #row_wishlist {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .info_wishlist p {
            margin: 1px 0;
        }

        .info_wishlist a {
            color: #007bff;
            text-decoration: none;
        }

        .info_wishlist a:hover {
            text-decoration: underline;
        }
    </style>
@endsection
