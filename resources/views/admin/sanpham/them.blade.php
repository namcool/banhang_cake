@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Sản phẩm
                            <small>Thêm</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{session('thongbao')}}
                            </div>
                        @endif
                        
                        <form action="admin/sanpham/them" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <div class="form-group">
                                <label>Tên Sản phẩm</label>
                                <input class="form-control" name="name" placeholder="Nhập tên sản phẩm" />
                            </div>
                            <div class="form-group">
                                <label>Loại sản phẩm</label>
                                <select class="form-control" name="type">
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                  </select>
                            </div>
                            <div class="form-group">
                                <label>Mô tả</label>
                                <input class="form-control" name="description" placeholder="Mô tả" />
                            </div>
                            <div class="form-group">
                                <label>Giá gốc</label>
                                <input class="form-control" name="unit_price" placeholder="Nhập giá gốc" />
                            </div>
                            <div class="form-group">
                                <label>Giá đã giảm</label>
                                <input class="form-control" name="promotion_price" placeholder="Nhập giá giảm" />
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <input type="file" name="image"/>
                            </div>
                            <div class="form-group">
                                <label>Đơn vị</label>
                                <input class="form-control" name="unit" placeholder="Nhập đơn vị" />
                            </div>
                            <div class="form-group">
                                <label>Là sản phẩm mới</label>
                                <select class="form-control" name="new">
                                    <option value="1">Có</option>
                                    <option value="0">Không</option>
                                  </select>
                            </div>
                            <button type="submit" class="btn btn-default">Thêm</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection