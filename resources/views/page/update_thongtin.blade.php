@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Sửa thông tin</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Home</a> / <span>Sửa thông tin</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			
			<form action="{{route('update_info')}}" method="post" class="beta-form-checkout">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<h4>Sửa thông tin</h4>
						<div class="space20">&nbsp;</div>

						
						<div class="space20">&nbsp;</div>
						@if(count($errors)>0)
							<div class="alert alert-danger">
								@foreach($errors->all() as $err)
									{{$err}}
								@endforeach
							</div>
						@endif
						@if(Session::has('thanhcong'))
						<div class="alert alert-success">{{Session::get('thanhcong')}}</div>
						@endif
						<div class="form-block">
							<label for="email">Email address*</label>
							<input type="email" name="email" value="{{Auth::user()->email}}" required>
						</div>

						<div class="form-block">
							<label for="your_last_name">Fullname*</label>
							<input type="text" name="full_name" value="{{Auth::user()->full_name}}" required>
						</div>

						<div class="form-block">
							<label for="adress">Address*</label>
							<input type="text" name="address" value="{{Auth::user()->address}}" required>
						</div>


						<div class="form-block">
							<label for="phone">Phone*</label>
							<input type="text" name="phone" value="{{Auth::user()->phone}}" required>
						</div>
						{{-- <div class="form-block">
							<label for="phone">Password cũ*</label>
							<input type="password" name="old_password" required>
						</div>
						<div class="form-block">
							<label for="phone">Password mới*</label>
							<input type="password" name="password" required>
						</div>
						<div class="form-block">
							<label for="phone">Re password*</label>
							<input type="password" name="re_password" required>
						</div> --}}
						<div class="form-block">
							<button type="submit"  style="margin: 9px; padding: 15px;" class="btn btn-primary">Lưu</button>
							<div>
							<a href="{{route('changepass')}}"  style="margin: 9px; padding: 15px;" class="btn btn-default">Đổi mật khẩu</a>
							</div>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
			
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection