
@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="css/search.css">
<title>Search</title>
@endsection
@section('body')
<div class="body-container">
    @if (isset($users))
    @foreach ($users as $key=>$user)
    @if ($user->id == session('id'))
    <a href="{{ url('profile') }}" class="search-item">
        <div class="row gutter item-container">
            <div class="col-2">
                @if (session()->has('img'))
                <img src="{{ asset('../storage/app/public/uploads/'. session('img'))}}" alt="" class="item-img ">
                @else
                <img src="{{ asset('img/user.png')}}" alt="" class="item-img ">
                @endif

            </div>
            <div class="col">
                <div class="row gutter ">
                    <div class="col start"><span class="item-username">{{$user->username}}</span></div>
                </div>
                <div class="row gutter ">
                    <div class="col "><span class="item-name">{{$user->name}}</span></div>
                </div>
            </div>
            {{-- <div class="col end pe-3 pt-2">
                <span class="is-follow">Following</span>
            </div> --}}
        </div>
    </a>
    @else
    <a href="visit-profile/{{$user->id}}" class="search-item">
        <div class="row gutter item-container">
            <div class="col-2">
                @if (isset($images[$key]->name))
                <img src="{{ asset('../storage/app/public/uploads/'. $images[$key]->name)}}" alt="" class="item-img ">
                @else
                <img src="{{ asset('img/user.png')}}" alt="" class="item-img ">
                @endif
            </div>
            <div class="col">
                <div class="row gutter ">
                    <div class="col start"><span class="item-username">{{$user->username}}</span></div>
                </div>
                <div class="row gutter ">
                    <div class="col "><span class="item-name">{{$user->name}}</span></div>
                </div>
            </div>
            {{-- <div class="col end pe-3 pt-2">
                <span class="is-follow">Following</span>
            </div> --}}
        </div>
    </a>
    @endif

    @endforeach
    @else
    <div class="no-results-container">
        <span class="no-results">
            <i class="fa-solid fa-magnifying-glass"></i>
            No search results
        </span>
    </div>
    @endif


    </div>


@endsection
