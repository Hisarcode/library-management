@extends('account.index')

@section('content')

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="module module-login span4 offset4">
				<form class="form-vertical" action="{{ URL::route('account-create-post') }}" method="POST">
					@csrf
					<div class="module-head">
						<h3>Daftar</h3>
					</div>
					<div class="module-body">
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="text" placeholder="Username" name="username" value="{{ Request::old('login') }}">
								@if($errors->has('login'))
								{{ $errors->first('login')}}
								@endif
							</div>
						</div>
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="password" name="password" placeholder="Password">
								@if($errors->has('password'))
								{{ $errors->first('password')}}
								@endif
							</div>
						</div>
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="password" name="password_again" placeholder="Konfirmasi Password">
								@if($errors->has('password_again'))
								{{ $errors->first('password_again')}}
								@endif
							</div>
						</div>
					</div>
					<div class="module-foot">
						<div class="control-group">
							<div class="controls clearfix">
								<button type="submit" class="btn btn-info pull-right">Buat Akun</button>
							</div>
						</div>
						<a href="{{ URL::route('account-sign-in') }}">Sudah Punya Akun?</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@include('account.style')
@stop