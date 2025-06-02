<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use App\Models\CatePost;
use App\Models\CategoryProductModel;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Icons;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

session_start();

class HomeController extends Controller
{
    public function error_page()
    {
        return view('errors.404');
    }
    public function load_more_product(Request $request)
    {
        $page = $request->input('page', 1);

        $all_product = Product::where('product_status', '0')
            ->orderBy('product_id', 'DESC')
            ->paginate(6, ['*'], 'page', $page);

        $output = '';

        if (!$all_product->isEmpty()) {
            foreach ($all_product as $pro) {
                $output .= '<div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <a href="' . url('chi-tiet/' . $pro->product_slug) . '">
                                <img src="' . url('uploads/product/' . $pro->product_image) . '" alt="' . $pro->product_name . '" />
                                <h2>' . number_format($pro->product_price, 0, ',', '.') . ' VNĐ</h2>
                                <p>' . $pro->product_name . '</p>
                            </a>
                            <button class="btn btn-default" onclick="Addtocart(' . $pro->product_id . ')">Thêm giỏ hàng</button>
                        </div>
                    </div>
                </div>
            </div>';
            }

            // Phân trang
            $output .= '<div class="pagination-wrapper mt-3">
            <ul class="pagination justify-content-center">';

            if ($all_product->onFirstPage()) {
                $output .= '<li class="page-item disabled"><span class="page-link">«</span></li>';
            } else {
                $output .= '<li class="page-item"><a href="#" class="page-link" data-page="' . ($all_product->currentPage() - 1) . '">«</a></li>';
            }

            for ($i = 1; $i <= $all_product->lastPage(); $i++) {
                if ($i == $all_product->currentPage()) {
                    $output .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                } else {
                    $output .= '<li class="page-item"><a href="#" class="page-link" data-page="' . $i . '">' . $i . '</a></li>';
                }
            }

            if ($all_product->hasMorePages()) {
                $output .= '<li class="page-item"><a href="#" class="page-link" data-page="' . ($all_product->currentPage() + 1) . '">»</a></li>';
            } else {
                $output .= '<li class="page-item disabled"><span class="page-link">»</span></li>';
            }

            $output .= '</ul></div>';
        } else {
            $output .= '<p class="text-center">Không có sản phẩm nào để hiển thị.</p>';
        }

        return response()->json($output);
    }
    public function index(Request $request)
    {
        $icons = Icons::orderBy('id_icons', 'DESC')->get();
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(3)->get();

        $meta_desc = "Chuyên bán những phụ kiện ,thiết bị game";
        $meta_keywords = "thiet bi game,phu kien game,game phu kien,game giai tri";
        $meta_title = "Phụ kiện,máy chơi game chính hãng";
        $url_canonical = $request->url();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_parent', 'desc')->orderby('category_order', 'ASC')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        $cate_pro_tabs = CategoryProductModel::where('category_parent', 0)->orderBy('category_id', 'DESC')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby('product_id','DESC')->paginate(6);

        return view('pages.home')
            ->with('category', $cate_product)
            ->with('brand', $brand_product)
            ->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)
            ->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)
            ->with('slider', $slider)
            ->with('category_post', $category_post)
            ->with('cate_pro_tabs', $cate_pro_tabs)
            ->with('icons', $icons);
    }


    public function yeu_thich(Request $request)
    {
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();

        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo
        $meta_desc = "Yêu thích";
        $meta_keywords = "Yêu thích";
        $meta_title = "Yêu thích";
        $url_canonical = $request->url();
        //--seo

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_parent', 'desc')->orderby('category_order', 'ASC')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby(DB::raw('RAND()'))->paginate(6);

        return view('pages.yeuthich.yeuthich')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post); //1

    }
    public function search(Request $request)
    {
        //category post
        $category_post = CatePost::orderBy('cate_post_id', 'DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        //seo
        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();


        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post);
    }

    public function autocomplete_ajax(Request $request)
    {
        $data = $request->all();

        if ($data['query']) {

            $product = Product::where('product_status', 0)->where('product_name', 'LIKE', '%' . $data['query'] . '%')->get();

            $output = '
            <ul class="dropdown-menu" style="display:block; position:relative">';

            foreach ($product as $key => $val) {
                $output .= '
             <li class="li_search_ajax"><a href="#">' . $val->product_name . '</a></li>
             ';
            }

            $output .= '</ul>';
            echo $output;
        }
    }
}
