
@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="css/profile.css">
<title>Profile</title>
@endsection
@section('body')

    <div class="body-container">
        <div class="profile-details">
            {{-- <img src="img/profile.jpg" alt=""> --}}
            @if (session()->has('img'))
            <img src="{{ asset('../storage/app/public/uploads/'.session('img')) }}" alt="">
            @else
            <img src="{{ asset('img/user.png') }}" alt="">
            @endif

            <div class="profile-description">
                <div class="container text-center">
                    <div class="row">
                      <div class="col start p-0">
                        <span class="username">{{session('username')}}</span>
                      </div>
                      <div class="col end" style="margin-right: 30px;">
                        <a href="{{url('edit-profile')}}" class="btn edit-btn d-none d-xl-inline-block">Edit profile</a>
                        <a class="btn settings-btn" href="{{url('edit-profile')}}"><i class="fa-sharp fa-solid fa-gear"></i></a>
                      </div>
                    </div>
                  </div>
                  <a href="{{url('edit-profile')}}" class="btn edit-btn d-xl-none" style="width: 85%;">Edit profile</a>

                <div class="container text-center follow-details">
                    <div class="row">
                      <div class="col start">
                        <b>{{ count($images) }}</b> posts
                      </div>
                      <div class="col start">
                        <a href="{{ url('followers') }}/{{session('id')}}" class="follow-details-a"><b>{{$followers}}</b> followers</a>
                      </div>
                      <div class="col start" style="margin-right: 20px;">
                        <a href="{{ url('following') }}/{{session('id')}}" class="follow-details-a"><b>{{$following}}</b> following</a>
                      </div>
                    </div>
                  </div>

            </div>



        </div>
        <div class="highlights">
            <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <div class="highlight">
                        <img src="img/profile.jpg" alt="">
                        <b>Highlight</b>
                    </div>
                  </div>
                  <div class="col">
                    <div class="highlight">
                        <img src="img/facebook-logo-3-1.png" alt="">
                        <b>Highlight</b>
                    </div>
                  </div>
                </div>
              </div>


        </div>

        <div class="posts">


            <div class="row">
                @foreach ($images as $image)
                <div class="col-4 p-1">
                    <a href="{{ url('post/'.$image->id) }}"><img src="{{ asset('../storage/app/public/uploads/'.$image->name) }}" alt=""></a>
                  </div>
                @endforeach
              </div>
        </div>
    </div>
@endsection
