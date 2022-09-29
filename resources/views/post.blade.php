@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<title>Post</title>
@endsection

@section('comments-section')
<div class="comments-whole-container">
    <div class="comments-container p-3">
      <div class="row gutter pt-1 comments-header">
        <div class="col-4 center"></div>
        <div class="col-4 center">
          <span class="comments-header-span">Comments</span>
        </div>
        <div class="col-4 end"><button id="close-comments" type="button" class="btn-close" aria-label="Close"></button></div>
      </div>

      <div class="comments-section mt-3">

        @foreach ($comments as $key=>$comment)
        <div class="comment-card">
            <div class="row gutter">
              <div class="col-2">
                @if ($commentUsersImages[$key] == null)
                <img src="{{ asset('img/user.png') }}" alt="" class="comment-img">
                @else
                <img src="{{ asset('../storage/app/public/uploads/'.$commentUsersImages[$key]->name) }}" alt="" class="comment-img">
                @endif

              </div>
              <div class="col">
                <div class="row gutter start">
                  <b>{{ $commentUsers[$key][0]->username }}</b>

                </div>
                <div class="row gutter start">
                  {{$comment->comment}}
                </div>
              </div>
            </div>
          </div>
        @endforeach



      </div>
    </div>
  </div>
@endsection

@section('body')
    <div class="body-container">
        <div class="post-card">
            <div class="container text-center">
                <div class="row">
                  <div class="col start p-0">
                    @if (isset($profilePic))
                    <img src="{{ asset('../storage/app/public/uploads/'.$profilePic) }}" alt="" class="publisher-profile-pic">
                    @else
                    <img src="{{ asset('img/user.png') }}" alt="" class="publisher-profile-pic">
                    @endif

                    <a href="" class="publisher-username">{{ $username }}</a>
                  </div>
                  <div class="col end">
                    <!-- <button class="post-options-btn"><i class="fa-sharp fa-solid fa-ellipsis"></i></button> -->
                    <div class="dropdown-center">
                        <button class="post-options-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-sharp fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="#">Action</a></li>
                          <li><a class="dropdown-item" href="#">Action two</a></li>
                          <li><a class="dropdown-item" href="#">Action three</a></li>
                        </ul>
                      </div>
                  </div>
                </div>
              </div>
              <img class="post-img" src="{{ asset('../storage/app/public/uploads/'.$image->name) }}" alt="">
              <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <div class="container text-center">
                        <div class="row min">
                          <div class="col start p-0">
                            @if ($isLiked != null)
                            <a href="{{ url('like/'.$image->id) }}" class="post-buttons"><i class="fa-solid fa-heart"></i></a>
                            @else
                            <a href="{{ url('like/'.$image->id) }}" class="post-buttons"><i class="fa-regular fa-heart"></i></a>
                            @endif



                          </div>
                          <div class="col start p-0">
                            <button id="comment-btn" class="post-buttons"><i class="fa-regular fa-comment"></i></button>

                          </div>
                          <div class="col start p-0">
                            <a href="" class="post-buttons"><i class="fa-regular fa-paper-plane"></i></a>

                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col end">
                    <button class="post-buttons"><i class="fa-regular fa-bookmark"></i></button>

                  </div>
                </div>
              </div>

              <span class="liked-by">Liked by <b><a href="{{ url('likes/'.$image->id) }}" style="text-decoration: none; color: black">{{ $likesCount }}</a></b> others</span><br>
              <span class="post-description"><b>ahmed1ghobashy</b> Limited edition</span>
              <span class="post-time">11 hours ago</span>
              <div class="line"></div>
              <form action="{{ url('addComment') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <input type="hidden" value="{{ $image->id }}" name="imageId">
                        <input name="comment" type="text" class="comment-input mx-3" placeholder="Add a comment" >
                    </div>
                    <div class="col-3 end">
                        <button type="submit" class="mx-3 comment-btn">Post</button>
                    </div>
                  </div>
              </form>



        </div>
    </div>

@endsection
@section('script')
<script>
    $('#close-comments').click(function(){
      $('.comments-whole-container').hide()
    })
    $('#comment-btn').click(function(){
      $('.comments-whole-container').show()
    })
  </script>
@endsection
