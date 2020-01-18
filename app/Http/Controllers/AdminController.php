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

    //San pham
    public function getDanhSachSp()
    {
        $products = Products::all();
        $types = Type_Products::all();
    	return view('admin.sanpham.danhsach',['products'=>$products,'types'=>$types]);
    }

    public function getThemSp()
    {
        $types = Type_Products::all();
    	return view('admin.sanpham.them',['types'=>$types]);
    }

    public function postThemSp(Request $req)
    {
    	$this->validate($req,
    		[
    			'name'=>'required|unique:type_products,name',
    		],
    		[
    			'name.required'=>'Chưa nhập tên sản phẩm!',
    			'name.unique'=>'Tên sản phẩm đã tồn tại.'
    		]
        );
    	$sp = new Products();
    	$sp->name = $req->name;
        $sp->description = $req->description;
        $sp->id_type = $req->type;
        $sp->unit_price = $req->unit_price;
        $sp->promotion_price = $req->promotion_price;
        $sp->unit = $req->unit;
        $sp->new = $req->new;
    	$sp->image = isset($_FILES['image'])?$_FILES['image']['name']:'';
        $sp->save();
        $filepath = public_path('source/image/product/');

        move_uploaded_file($_FILES['image']['tmp_name'], $filepath.$_FILES['image']['name']);


    	return redirect('admin/sanpham/danhsach')->with('thongbao','Thêm thành công!');

    }
    public function getSuaSp($id)
    {
        $types = Type_Products::all();
        $sanpham = Products::find($id);

    	return view('admin.sanpham.sua',['sanpham'=>$sanpham,'types'=>$types]);
    }

    public function postSuaSp(Request $req, $id)
    {
    	$this->validate($req,
    		[
    			'name'=>'required'
    		],
    		[
    			'name.required'=>'Chưa nhập tên loại sản phẩm!'
    		]
    	);
    	
    	$sp = Products::find($id);
    	$sp->name = $req->name;
    	$sp->description = $req->description;
        $sp->id_type = $req->type;
        $sp->unit_price = $req->unit_price;
        $sp->promotion_price = $req->promotion_price;
        $sp->unit = $req->unit;
        $sp->new = $req->new;
        $oldfile = $req->old;
        if($_FILES['image']['name'] != '')
        {
            $sp->image = $_FILES['image']['name'];
            $filepath = public_path('source/image/product/');
            move_uploaded_file($_FILES['image']['tmp_name'], $filepath.$_FILES['image']['name']);
        }
        else
        {
            $sp->image = $oldfile;
        }
        $sp->save();


    	return redirect('admin/sanpham/danhsach')->with('thongbao','Sửa thành công!');
    }
    public function getXoaSp($id)
    {
    	$sp = Products::find($id);
    	$sp->delete();

    	return redirect('admin/sanpham/danhsach')->with('thongbao','Bạn đã xóa thành công!');
    }

}
