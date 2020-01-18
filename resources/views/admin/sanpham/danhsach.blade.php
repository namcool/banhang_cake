@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Sản phẩm
                            <small>Danh sách</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Loại sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Giá gốc</th>
                                <th>Giá đã giảm</th>
                                <th>Đơn vị</th>
                                <th>Hình ảnh</th>
                                <th>Mới</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $pr)
                            <tr class="odd gradeX" align="center">
                                <td>{{$pr->id}}</td>
                                <td>{{$pr->name}}</td>
                                {{-- Khong hieu sao -1 nhe --}}
                                <td>{{$types[$pr->id_type-1]->name}}</td>
                                <td>{{$pr->description}}</td>
                                <td>{{$pr->unit_price}}</td>
                                <td>{{$pr->promotion_price}}</td>
                                <td>{{$pr->unit}}</td>
                                <td><img src="source/image/product/{{$pr->image}}" height="40px" width="40px" /></td>
                                <td>{{$pr->new}}</td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/sanpham/xoa/{{$pr->id}}">Delete</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/sanpham/sua/{{$pr->id}}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection