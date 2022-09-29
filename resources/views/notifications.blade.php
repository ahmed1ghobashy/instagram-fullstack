
@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
<title>Notifications</title>
@endsection
@section('body')
<div class="body-container">
    <h2 class="follow-h">Notifications</h2>
    @foreach ($users as $key=>$user)
    <div class="row gutter item-container">
        <div class="col-8">
            <a href="" class="link">
                <div class="row gutter">
                    <div class="col-3 col-md-2 center ">
                        @if (isset($profileImages[$key]->name))
                        <img src="{{ asset('../storage/app/public/uploads/'.$profileImages[$key]->name) }}" alt="" class="item-img">
                        @else
                        <img src="{{ asset('img/user.png') }}" alt="" class="item-img">
                        @endif

                    </div>
                    <div class="col">
                        <div class="row">
                            <span class="item-username">{{ $user->username }}</span>
                        </div>
                        <div class="row">
                            <span class="item-name">Requested following you</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col pt-3  end actions-col">
            <a href="{{ url('accept/'.$user->id) }}" class="accept-btn"><i class="fa-solid fa-check"></i></a>
            <a href="{{ url('reject/'.$user->id) }}" class="reject-btn ms-5"><i class="fa-solid fa-xmark"></i></a>
        </div>
    </div>

    @endforeach


</div>

@endsection
