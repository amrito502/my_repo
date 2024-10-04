@extends('layouts.app_auth')

@section('title', 'Login | UMMUN Model Academy')

@section('auth-content')

 <style>
    body {
      margin: 0;
      padding: 0;
    }
    .full-page {
      background-image: url(asssts/images/orange_loginbg.jpg);
      background-repeat: no-repeat;
      background-position: center center;
      background-attachment: fixed;
      background-size: cover;
      height: 100vh;
    }
  </style>


<div class="theme-orange full-page" >
    <div class="authentication">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="mb-2">
                            <img src="{{url ('assets/images/logo.png')}}" width="100" alt="">
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="col-lg-12" >
                        @csrf
                            <h5 class="title">LOGIN</h5>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{old('email')}}" class="form-control email" required>

                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group form-float passwordField">
                                <div class="form-line">
                                    <label class="form-label">Password</label>
                                    <input class="form-control password" name="password" value="{{old('password')}}" type="password" required>

                                    <span class="showPass"><i class="fa fa-eye"></i></span>

                                    @if ($errors->has('password'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-left mb-2">
                                <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-cyan">
                                <label for="rememberme">Remember Me</label>
                            </div>

                            <div class="text-left">
                                <button type="submit" class="btn btn-raised btn-success waves-effect" style="width: 100%;">SIGN IN</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
