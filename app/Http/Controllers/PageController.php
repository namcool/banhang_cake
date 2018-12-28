<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use App\Products;
use App\Type_products;
use App\Cart;
use App\Customer;
use App\Bills;
use App\Bill_detail;
use Session;

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

    public function getLoaiSp($type)
    {
        $sp_theoloai = Products::where('id_type',$type)->get();
        $sp_khac = Products::where('id_type','<>',$type)->paginate(3);
        $all_loai = Type_products::all();
        $current_loai = Type_products::where('id',$type)->first();        return view('page.loai_sanpham',compact('sp_theoloai','sp_khac','all_loai','current_loai'));
    }

    public function getChitietSp(Request $req)
    {
        $sanpham = Products::where('id',$req->id)->first();
        $sp_tuongtu = Products::where('id_type',$sanpham->id_type)->paginate(3);
        return view('page.chitiet_sanpham',compact('sanpham','sp_tuongtu'));
    }

    public function getLienhe()
    {
        return view('page.lienhe');
    }

    public function getThongtin()
    {
        return view('page.thongtin');
    }

    public function getAddtoCart(Request $req, $id)
    {
        $product = Products::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product,$id);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function getAddtoCartwithQty(Request $req)
    {
        return redirect()->back();
    }

    public function postAddtoCartwithQty(Request $req)
    {
        $product = Products::find($req->id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add_qty($product,$req->id,$req->select);
        $req->session()->put('cart',$cart);
        return redirect()->back();
    }

    public function getDelItemCart($id)
    {
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items) > 0)
        {
            Session::put('cart',$cart);
        }
        else
        {
            Session::forget('cart');
        }
        return redirect()->back();
    }

    public function getThanhtoan()
    {
        return view('page.thanhtoan');
    }

    public function postThanhtoan(Request $req){
        $cart = Session::get('cart');
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->note = $req->note;
        $customer->save();

        $bill = new Bills();
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $req->payment_method;
        $bill->note = $req->note;
        $bill->save();

        foreach ($cart->items as $key => $value) {
        $bill_detail = new Bill_detail;
        $bill_detail->id_bill = $bill->id;
        $bill_detail->id_product = $key;
        $bill_detail->quantity = $value['qty'];
        $bill_detail->unit_price = ($value['price']/$value['qty']);
        $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('thongbao','Đặt hàng thành công!!!');
    }
}
