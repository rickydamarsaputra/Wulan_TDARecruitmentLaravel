@extends('layout.auth')

@section('content')
<div class="col-lg-4">
  <div class="login-brand">
    <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
  </div>

  <div class="card card-primary">
    <div class="card-header">
      <h4>Login For Member Or Admin TDA</h4>
    </div>

    <div class="card-body">
      <form action="{{route('login.process')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="text">Username</label>
          <input name="username" id="username" type="text" class="form-control" value="{{old('username')}}" placeholder="masukkan username...">
          @error('username')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>

        <div class="form-group" x-data="{show: false}">
          <label for="password">Password</label>
          <div class="position-relative">
            <input name="password" id="password" :type="show ? 'text' : 'password'" class="form-control" value="{{old('password')}}" placeholder="masukkan password...">
            <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
          </div>
          @error('password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Login
          </button>
        </div>
      </form>
      <div class="text-muted text-center text-capitalize">
        belum punya akun? <a href="{{route('register.view')}}">registrasi</a>
      </div>

    </div>
  </div>
</div>
@endsection