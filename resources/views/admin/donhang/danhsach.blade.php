@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Loại sản phẩm
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
                                <th>Tên khách hàng</th>
                                <th>Phương thức thanh toán</th>
                                <th>Thời gian đặt hàng</th>
                                <th>Thời gian cập nhật</th>
                                <th>Địa chỉ</th>
                                <th>Sđt</th>
                                <th>Ghi chú</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                            <tr class="odd gradeX" align="center">
                                <td>{{$bill->id}}</td>
                                <td>{{$bill->name}}</td>
                                <td>{{$bill->payment}}</td>
                                <td>{{$bill->created_at}}</td>
                                <td>{{$bill->updated_at}}</td>
                                <td>{{$bill->address}}</td>
                                <td>{{$bill->phone_number}}</td>
                                <td>{{$bill->note}}</td>
                                <td>{{$bill->total}} VNĐ</td>
                            <td><select class="form-control" id="status_{{$bill->id}}" name="new" onChange="change({{$bill->id}})">
                                    <option value="1" 
                                    @if (1 == $bill->status)
                                        selected="selected"
                                    @endif>Đã thanh toán</option>
                                    <option value="0" 
                                    @if (0 == $bill->status)
                                        selected="selected"
                                    @endif>Chưa thanh toán</option>
                                    <option value="2" 
                                    @if (2 == $bill->status)
                                        selected="selected"
                                    @endif>Đã hủy</option>
                                  </select></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/loaisanpham/xoa/">Delete</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/loaisanpham/sua/">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <script type="text/javascript">
        function change(id)
        {
            var status = $('#status_'+id).val();
            // $.ajaxSetup({
            //       headers: {
            //           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //       }
            //   });
            jQuery.ajax({
                url: 'admin/donhang/ajaxRequest',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    status: status,
                    id: id
                },
                success: function(result){
                    alert(result.success);
                    location.reload(true); 
                }});
        }
        </script>
        <!-- /#page-wrapper -->
@endsection 