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
use App\User;
use Auth;
use Session;
use Hash;

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
        
        if($req->note == "")
            $req->note = "Không có ghi chú!!";
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

    public function getLogin()
    {
        return view('page.login');
    }

    public function postLogin(Request $req)
    {
        $this->validate($req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email.',
                'password.required'=>'Nhập password',
                'password.min'=>'Mật khẩu quá ngắn! (6 ký tự)'
            ]
        );
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials))
        {
            return redirect()->back()->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else
        {
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);

        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('trang-chu');
    }

    public function getSignUp()
    {
        return view('page.sign_up');
    }

    public function postSignUp(Request $req)
    {
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:6',
                'full_name'=>'required',
                'phone'=>'required|max:11',
                're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email.',
                'email.unique'=>'Email này đã được đăng ký.',
                'full_name'=>'Chưa nhập tên',
                'password.required'=>'Nhập password',
                'password.min'=>'Mật khẩu quá ngắn! (6 ký tự)',
                'phone.required'=>'Vui lòng nhập số điện thoại.',
                'phone.max'=>'Nhập sdt quá 11 số!!',
                're_password.required'=>'Vui lòng nhập lại mật khẩu',
                're_password.same'=>'Password không trùng khớp.'
            ]
        );
        $user = new User();
        $user->full_name = $req->full_name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->isAdmin = 0;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Tạo tài khoản thành công!');
    }

    public function getSearch(Request $req)
    {
        $product = Products::where('name','like','%'.$req->key.'%')->orWhere('unit_price',$req->key)->get();
        return view('page.search',compact('product'));
    }

    public function getUpdateInfo()
    {
        return view('page.update_thongtin');
    }

    public function postUpdateInfo(Request $req)
    {
        // $last_password = Auth::user()->password();
        $this->validate($req,
            [
                'email'=>'required|email',
                // 'password'=>'required|min:6',
                'address'=>'required',
                'full_name'=>'required',
                'phone'=>'required|max:11'
                // 'old_password'=>'required|min:6|same:last_password',
                // 're_password'=>'required|same:password'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email.',
                // 'email.unique'=>'Email này đã được đăng ký.',
                'full_name.required'=>'Chưa nhập tên!!',
                'address.required'=>'Chưa nhập địa chỉ!!',
                // 'password.required'=>'Nhập password',
                // 'password.min'=>'Mật khẩu quá ngắn! (6 ký tự)',
                'phone.required'=>'Vui lòng nhập số điện thoại.',
                'phone.max'=>'Nhập sdt quá 11 số!!'
                // 'old_password.required'=>'Cần nhập mật khẩu cũ',
                // 'old_password.min'=>'Mật khẩu quá ngắn! (6 ký tự)',
                // 'old_password.same'=>'Mật khẩu cũ không trùng khớp',
                // 're_password.required'=>'Vui lòng nhập lại mật khẩu',
                // 're_password.same'=>'Password không trùng khớp.'
            ]
        );
        // $user_email = Auth::user()->email;
        $user = Auth::user();
        $user->full_name = $req->full_name;
        $user->email = $req->email;
        // $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address;
        $user->save();
        return redirect()->back()->with('thanhcong','Sửa tài khoản thành công!');

    }

    public function getChangePass()
    {
        return view('page.changepass');
    }

    public function postChangePass(Request $req)
    {
        $last_password = Auth::user()->password;
        $hash_req_pass = Hash::make($req->last_password);
        if ($hash_req_pass == $last_password) {
        $this->validate($req,
            [
                // 'email'=>'required|email',
                'password'=>'required|min:6',
                // 'address'=>'required',
                // 'full_name'=>'required',
                // 'phone'=>'required|max:11'
                // 'old_password'=>'required|min:6|same:last_password',
                're_password'=>'required|same:password'
            ],
            [
                // 'email.required'=>'Vui lòng nhập email',
                // 'email.email'=>'Không đúng định dạng email.',
                // 'email.unique'=>'Email này đã được đăng ký.',
                // 'full_name.required'=>'Chưa nhập tên!!',
                // 'address.required'=>'Chưa nhập địa chỉ!!',
                'password.required'=>'Nhập password',
                'password.min'=>'Mật khẩu quá ngắn! (6 ký tự)',
                // 'phone.required'=>'Vui lòng nhập số điện thoại.',
                // 'phone.max'=>'Nhập sdt quá 11 số!!'
                // 'old_password.required'=>'Cần nhập mật khẩu cũ',
                // 'old_password.min'=>'Mật khẩu quá ngắn! (6 ký tự)',
                // 'old_password.same'=>'Mật khẩu cũ không trùng khớp',
                're_password.required'=>'Vui lòng nhập lại mật khẩu',
                're_password.same'=>'Password không trùng khớp.'
            ]
        );
        $user = Auth::user();
        $user->password = Hash::make($req->password);
        $user->save();
        return redirect()->back()->with('thanhcong','Sửa mật khẩu thành công!');
        }
        return redirect()->back()->with('baoloi','Mật khẩu cũ không trùng khớp!');
    }
}

