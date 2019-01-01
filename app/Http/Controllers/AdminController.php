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

class AdminController extends Controller
{
    function getAdmin()
    {
    	return view('admin.layout.index');
    }

    public function getdangnhapAdmin()
    {
        if(Auth::check()){
            return redirect('admin/loaisanpham/danhsach')->with('thongbao','Bạn đã đăng nhập rồi');
        }
        else
            return view('admin.login');
    }

    public function postdangnhapAdmin(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required|min:3|max:32'
        ],[
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập password',
            'password.min'=>'Password không được < 3 kí tự',
            'password.max'=>'Password không được > 32 kí tự'
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'isAdmin'=>1]))
            {
                return redirect('admin/loaisanpham/danhsach');
            }
        else
        {
            return redirect('admin/dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }
    public function getDangxuatAdmin()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }

    //Quản lý sp

    public function getDanhSachLoaiSp()
    {
    	$types = Type_Products::all();
    	return view('admin.loaisanpham.danhsach',['types'=>$types]);
    }

    public function getThemLoaiSp()
    {
    	return view('admin.loaisanpham.them');
    }

    public function postThemLoaiSp(Request $req)
    {
    	$this->validate($req,
    		[
    			'name'=>'required|unique:type_products,name',
    		],
    		[
    			'name.required'=>'Chưa nhập tên loại sản phẩm!',
    			'name.unique'=>'Tên loại đã tồn tại.'
    		]
    	);

    	$loaisp = new Type_Products();
    	$loaisp->name = $req->name;
    	$loaisp->description = $req->description;
    	$loaisp->image = '';
    	$loaisp->save();

    	return redirect()->back()->with('thongbao','Thêm thành công!');

    }

    public function getSuaLoaiSp($id)
    {
    	$loaisanpham = Type_Products::find($id);
    	return view('admin.loaisanpham.sua',['loaisanpham'=>$loaisanpham]);
    }

    public function postSuaLoaiSp(Request $req, $id)
    {
    	$this->validate($req,
    		[
    			'name'=>'required'
    		],
    		[
    			'name.required'=>'Chưa nhập tên loại sản phẩm!'
    		]
    	);
    	
    	$loaisanpham = Type_Products::find($id);
    	$loaisanpham->name = $req->name;
    	$loaisanpham->description = $req->description;
    	$loaisanpham->save();

    	return redirect()->back()->with('thongbao','Sửa thành công!');
    }

    public function getXoaLoaiSp($id)
    {
    	$loaisanpham = Type_Products::find($id);
    	$loaisanpham->delete();

    	return redirect('admin/loaisanpham/danhsach')->with('thongbao','Bạn đã xóa thành công!');
    }
}
