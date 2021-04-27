@extends('layout.dashboard')
@section('title', 'Profile')

@section('content')
<section class="section">
  <div class="section-header text-capitalize">
    <h1>@yield('title') Page</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="tda_profile_info">
          @if(auth()->user()->role == 'member')
          <h6>nama <span>{{auth()->user()->member->nama_member}}</span></h6>
          <h6>nomor member <span>{{auth()->user()->member->nomor_member}}</span></h6>
          <h6>nama bisnis <span>{{auth()->user()->member->nama_bisnis}}</span></h6>
          @endif
          <h6>email <span>{{auth()->user()->email}}</span></h6>
          <h6>role <span class="badge badge-info">{{auth()->user()->role}}</span></h6>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h5 class="text-capitalize">change password</h5>
        <form action="{{route('change.password')}}" method="POST">
          @csrf
          <div class="form-group" x-data="{show: false}">
            <label for="text">Password Lama</label>
            <div class="position-relative">
              <input name="old_password" id="old_password" :type="show ? 'text' : 'password'" class="form-control" value="{{old('old_password')}}" placeholder="masukkan password lama..." autofocus>
              <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
              <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            </div>
            @error('old_password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <div class="form-group" x-data="{show: false}">
            <label for="text">Password Baru</label>
            <div class="position-relative">
              <input name="new_password" id="new_password" :type="show ? 'text' : 'password'" class="form-control" value="{{old('new_password')}}" placeholder="masukkan password baru..." autofocus>
              <i @click="show = !show" x-show="show === false" class="fas fa-eye position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
              <i @click="show = !show" x-show="show === true" class="fas fa-eye-slash position-absolute" style="font-size: 18px; bottom: 12px; right: 10px; cursor: pointer;"></i>
            </div>
            @error('new_password')<small class="form-text text-danger text-capitalize">{{$message}}</small>@enderror
          </div>
          <button type="submit" class="btn btn-success">Change Password</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  .tda_profile_info h6 {
    text-transform: capitalize;
    position: relative;
  }

  .tda_profile_info h6::after {
    content: ":";
    position: absolute;
    left: 10rem;
  }

  .tda_profile_info h6 span {
    text-transform: none;
    font-weight: normal;
    position: absolute;
    left: 12rem;
  }
</style>
@endpush