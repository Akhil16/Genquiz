@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 ">
           <div class="shadow padding_25">
               <h1 class="text-center">Login</h1>
               <hr class="hr-red">            
               <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                   {{ csrf_field() }}

                   <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                       <label for="username" class="col-md-6 control-label">Username / E-Mail Address</label>

                       <div class="col-md-6">
                           <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                           @if ($errors->has('username'))
                               <span class="help-block">
                                   <strong>{{ $errors->first('username') }}</strong>
                               </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                       <label for="password" class="col-md-6 control-label">Password</label>

                       <div class="col-md-6">
                           <input id="password" type="password" class="form-control" name="password" required>

                           @if ($errors->has('password'))
                               <span class="help-block">
                                   <strong>{{ $errors->first('password') }}</strong>
                               </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group">
                       <div class="col-md-12">
                           <div class="checkbox">
                               <label>
                                   <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                               </label>
                           </div>
                       </div>
                   </div>

                   <div class="form-group">
                       <div class="col-md-12">
                           <button type="submit" class="btn button-custom btn-block btn-custom-blue">
                               Login
                           </button>
                       </div>
                   </div>
               </form>
                   Not Signed Up yet ? Do not Worry and <a href="{{ url('/register') }}">Signup</a> 
           </div>
                
        </div>
    </div>
</div>
@endsection
