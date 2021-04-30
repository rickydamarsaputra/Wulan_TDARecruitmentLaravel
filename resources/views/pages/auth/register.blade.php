@extends('layout.auth')
@section('title', 'Register')

@section('content')
<div class="col-lg-10">
  <div class="login-brand">
    <img src="{{asset('assets/img/logo-tdasurabaya.png')}}" alt="logo" width="100">
  </div>

  <div class="card card-primary">
    <div class="card-header">
      <h4>Register For Member TDA</h4>
    </div>

    <div class="card-body">
      <form action="{{route('register.process')}}" method="POST">
        @csrf
        <div class="row">
          <div class="form-group col-6">
            <label for="nama_member">Nama Member</label>
            <input id="nama_member" type="text" class="form-control" name="nama_member" value="{{old('nama_member')}}" placeholder="masukkan nama member...">
            @error('nama_member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group col-6">
            <label for="nomor_member">Nomor Member</label>
            <input id="nomor_member" type="text" class="form-control" name="nomor_member" value="{{old('nomor_member')}}" placeholder="masukkan nomor member...">
            @error('nomor_member')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>
        <div class="row">
          <div class="form-group col-6">
            <label for="nama_bisnis">Nama Bisnis</label>
            <input id="nama_bisnis" type="text" class="form-control" name="nama_bisnis" value="{{old('nama_bisnis')}}" placeholder="masukkan nama bisnis...">
            @error('nama_bisnis')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group col-6">
            <label for="kode_member">Kode Member</label>
            <input id="kode_member" type="text" class="form-control" name="kode_member" placeholder="masukkan kode member..." readonly>
          </div>
        </div>
        <div class="form-group">
          <label for="text">Email</label>
          <input name="email" id="email" type="text" class="form-control" value="{{old('email')}}" placeholder="masukkan email...">
          @error('email')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
        </div>

        <h6 class="card-subtitle text-primary text-capitalize mb-3">account for login</h6>
        <div class="row">
          <div class="form-group col-6">
            <label for="username">Username</label>
            <input id="username" type="text" class="form-control" name="username" value="{{old('username')}}" placeholder="masukkan username untuk login...">
            @error('username')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group col-6">
            <label for="password">Password</label>
            <div class="position-relative" x-data="{show: false}">
              <input id="password" :type="show ? 'text' : 'password'" class="form-control" name="password" value="{{old('password')}}" placeholder="enter your password...">
              <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
              <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            </div>
            @error('password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
        </div>

        <div class="row">
          <div class="col-lg">
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                Register
              </button>
            </div>
          </div>
          <div class="col-lg">
            <div class="form-group">
              <button type="button" class="btn btn-success btn-lg btn-block" id="generate__password__button">
                <i class="fas fa-random"></i>
                Generate Password
              </button>
            </div>
          </div>
        </div>
      </form>
      <div class="text-muted text-center text-capitalize">
        sudah punya akun? <a href="{{route('login.view')}}">login</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(() => {
    // create slug
    $("#nama_bisnis").on("keyup", async (e) => {
      if (e.target.value) {
        let requestURL = "{{route('helpers.generate.slug', ':slug')}}";
        requestURL = requestURL.replace(":slug", e.target.value);
        const {
          slug
        } = await fetch(requestURL).then(res => res.json());
        $("#kode_member").val(slug);
      } else {
        $("#kode_member").val("");
      }
    });

    // generate password
    $("#generate__password__button").on("click", async (e) => {
      const requestURL = "{{route('helpers.generate.password')}}";
      const {
        password
      } = await fetch(requestURL).then(res => res.json());
      $("#password").val(password);
    });
  });
</script>
@endpush