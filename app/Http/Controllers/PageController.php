<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Products;

class PageController extends Controller
{
    public function getIndex()
    {
        $slide = Slide::all();
        //return view('page.trangchu',['slide'=>slide]);
        $new_product = Products::where('new',1)->paginate(4,['*'], 'pag');
        $promotion_product = Products::where('promotion_price','<>',0)->paginate(8);
        return view('page.trangchu',compact('slide','new_product','promotion_product'));
    }

    public function getLoaiSp()
    {
        return view('page.loai_sanpham');
    }

    public function getChitietSp()
    {
        return view('page.chitiet_sanpham');
    }

    public function getLienhe()
    {
        return view('page.lienhe');
    }

    public function getThongtin()
    {
        return view('page.thongtin');
    }
}
