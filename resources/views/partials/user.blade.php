@extends('layouts.admin')
@section('content')
<div class="module">
    <div class="module-head">
    <h3>New User Registration</h3>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="module-body">    

                    <form method="POST" class="form-horizontal row-fluid" action="{{ route('register') }}">
                        @csrf

                        <div class="control-group">
                            <label for="name" class="control-label">{{ __('Name') }}</label>
                                <div class="controls">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                      <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                      </span>
                                     @enderror
                                </div>
                        </div>
<!--*********************************************************************************-->
                        <div class="control-group">
                            <label for="email" class="control-label">{{ __('E-Mail Address') }}</label>

                            <div class="controls">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<!--************************************************************************************-->
                        <div class="control-group">
                            <label for="password" class="control-label">{{ __('Password') }}</label>

                            <div class="controls">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
<!--***************************************************************************************-->

                        <div class="control-group">
                            <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>

                            <div class="controls">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
<!--*****************************************************************************************-->
                        <div class="control-group">
<label for=”type” class="control-label" >User Type:</label>
<div class="controls">
<select class=”form-control” name="usertype" id="usertype">
<option value=1>Admin</option>
<option value=0>Member</option>
</select>
</div>
</div>

                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
</div>
@endsection