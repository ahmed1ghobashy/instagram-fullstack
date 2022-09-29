
@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="{{asset('css/search.css')}}">
<title>{{$pageState}}</title>
@endsection
@section('body')
<div class="body-container">
    <h2 class="follow-h">{{ $pageState }}</h2>
    {{-- <h1>{{ $users[0][0]->username }}</h1> --}}
    @if (isset($users[0][0]))
    @foreach ($users as $key=>$user)
    @if ($user[0]->id == session('id'))
    <a href="{{ url('profile') }}" class="search-item">
    @else
    <a href="{{url('visit-profile')}}/{{$user[0]->id}}" class="search-item">

    @endif


    {{-- <a href="{{url('visit-profile')}}/{{$user[0]->id}}" class="search-item"> --}}
    <div class="row gutter item-container">
        <div class="col-2">
            @if (isset($images[$key]->name))
            <img src="{{asset('../storage/app/public/uploads/'. $images[$key]->name)}}" alt="" class="item-img ">
            @else
            <img src="{{asset('img/user.png')}}" alt="" class="item-img ">
            @endif

        </div>
        <div class="col">
            <div class="row gutter ">
                <div class="col start"><span class="item-username">{{ $user[0]->username }}</span></div>
            </div>
            <div class="row gutter ">
                <div class="col "><span class="item-name">{{ $user[0]->name }}</span></div>
            </div>
        </div>
    </div>
    </a>
    @endforeach
    @else
    <div class="no-results-container">
        <span class="no-results">
            <i class="fa-solid fa-magnifying-glass"></i>
            Nothing here!
        </span>
    </div>
    @endif

    </div>


@endsection
