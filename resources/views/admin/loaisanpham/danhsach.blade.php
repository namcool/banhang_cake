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
                                <th>Tên loại sản phẩm</th>
                                <th>Mô tả</th>
                                <th>Hình ảnh</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($types as $tp)
                            <tr class="odd gradeX" align="center">
                                <td>{{$tp->id}}</td>
                                <td>{{$tp->name}}</td>
                                <td>{{$tp->description}}</td>
                                <td>{{$tp->image}}</td>
                                {{-- <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/loaisanpham/xoa/{{$tp->id}}">Delete</a></td> --}}
                                <td><select class="form-control" id="status_{{$tp->id}}" name="new" onChange="change({{$tp->id}})">
                                    <option value="1" 
                                    @if (1 == $tp->status)
                                        selected="selected"
                                    @endif>Enabled</option>
                                    <option value="0" 
                                    @if (0 == $tp->status)
                                        selected="selected"
                                    @endif>Disabled</option>
                                  </select></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/loaisanpham/sua/{{$tp->id}}">Edit</a></td>
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
                    url: 'admin/loaisanpham/ajaxLoaisanpham',
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