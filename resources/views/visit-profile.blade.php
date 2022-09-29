
@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<title>Profile</title>
@endsection
@section('body')

    <div class="body-container">
        <div class="profile-details">
            {{-- <img src="{{ asset('img/profile.jpg') }}" alt=""> --}}
            @if (isset($imageName))
            <img src="{{ asset('../storage/app/public/uploads/'.$imageName) }}" alt="">
            @else
            <img src="{{ asset('img/user.png') }}" alt="">
            @endif
            <div class="profile-description">
                <div class="container text-center">
                    <div class="row">
                      <div class="col start p-0">
                        <span class="username">{{ $user->username }}</span>
                      </div>
                    </div>
                  </div>
                <div class="container text-center follow-details">
                    <div class="row">
                      <div class="col start">
                        <b>{{ count($images) }}</b> posts
                      </div>
                      <div class="col start">
                        <a href="{{ url('followers') }}/{{$user->id}}" class="follow-details-a"><b>{{$followers}}</b> followers</a>
                      </div>
                      <div class="col start" style="margin-right: 20px;">
                        <a href="{{ url('following') }}/{{$user->id}}" class="follow-details-a"><b>{{$following}}</b> following</a>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col">
                        @if ($state == 'Follow')
                        <a class="btn btn-primary w-100" href="{{ url('follow') }}/{{$user->id}}" role="button">Follow</a>
                        @elseif ($state == 'Requested')
                        <a class="btn btn-primary w-100" href="{{ url('unfollow') }}/{{$user->id}}" role="button">Requested</a>
                        @else
                        <a class="btn btn-primary w-100" href="{{ url('unfollow') }}/{{$user->id}}" role="button">Unfollow</a>
                        @endif


                    </div>
                    <div class="col">
                        <a class="btn message-btn w-100" href="#" role="button">Message</a></div>
                  </div>
            </div>



        </div>
        <div class="highlights">
            <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <div class="highlight">
                        <img src="{{ asset('img/profile.jpg') }}" alt="">
                        <b>Highlight</b>
                    </div>
                  </div>
                  <div class="col">
                    <div class="highlight">
                        <img src="{{ asset('img/facebook-logo-3-1.png') }}" alt="">
                        <b>Highlight</b>
                    </div>
                  </div>
                </div>
              </div>


        </div>

        <div class="posts">
            @if ($state == 'Following')
            <div class="row">
                @foreach ($images as $image)
                <div class="col-4 p-1">
                    <a href="{{ url('post/'.$image->id) }}"><img src="{{ asset('../storage/app/public/uploads/'.$image->name) }}" alt=""></a>
                  </div>
                @endforeach
            </div>
            @else
            <span class="private-span"><i class="fa-solid fa-lock"></i> This account is private</span>
            @endif



        </div>
    </div>
@endsection
