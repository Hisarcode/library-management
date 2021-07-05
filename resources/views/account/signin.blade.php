@extends('account.index')

@section('content')

<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="module module-login span4 offset1">
				<form class="form-vertical" action="{{ URL::route('account-sign-in-post') }}" method="POST">
					@csrf
					<div class="module-head">
						<h3>Login Pustakawan</h3>
					</div>
					<div class="module-body">
						<div class="control-group">
							<div class="controls row-fluid">
								<input class="span12" type="text" name="username" placeholder="Username" value="{{ Request::old('login') }}" autofocus>
								@if($errors->has('user_login'))
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
					</div>
					<div class="module-foot">
						<div class="control-group">
							<div class="controls clearfix">
								<button type="submit" class="btn btn-primary pull-right">Login</button>
								<label class="checkbox">
									<input type="checkbox" name="remember" id="remember"> Ingat saya
								</label>
							</div>
						</div>
						<a href="{{ URL::route('account-create') }}">Pustakawan baru? Daftar disini</a>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
@include('account.style')
@stop