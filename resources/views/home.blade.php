@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="css/home.css">
<title>home</title>
@endsection

@section('body')
    <div class="body-container">
        @foreach ($posts as $key=>$post)
        <div class="post-card">
            <div class="container text-center">
                <div class="row">
                  <div class="col start p-0">
                    @if (isset($profileImages[$key][0]))
                    <img src="{{ asset('../storage/app/public/uploads/'.$profileImages[$key][0]->name) }}" alt="" class="publisher-profile-pic">
                    @else
                    <img src="{{ asset('img/user.png') }}" alt="" class="publisher-profile-pic">
                    @endif

                    <a href="{{ url('visit-profile/'.$post->u_id) }}" class="publisher-username">{{ $post->username }}</a>
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
              <img class="post-img" src="{{ asset('../storage/app/public/uploads/'.$post->name) }}" alt="">
              <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <div class="container text-center">
                        <div class="row min">
                          <div class="col start p-0">
                            @if ($isLiked[$key] != null)
                            <a href="{{ url('like/'.$post->id) }}" class="post-buttons"><i class="fa-solid fa-heart"></i></a>
                            @else
                            <a href="{{ url('like/'.$post->id) }}" class="post-buttons"><i class="fa-regular fa-heart"></i></a>
                            @endif



                          </div>
                          <div class="col start p-0">
                            <a href="{{ url('post/'.$post->id) }}" class="post-buttons"><i class="fa-regular fa-comment"></i></a>

                          </div>
                          <div class="col start p-0">
                            <button class="post-buttons"><i class="fa-regular fa-paper-plane"></i></button>

                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="col end">
                    <button class="post-buttons"><i class="fa-regular fa-bookmark"></i></button>

                  </div>
                </div>
              </div>

              <span class="liked-by">Liked by <b><a href="{{ url('likes/'.$post->id) }}" style="text-decoration: none; color: black;">{{ $likesCount[$key] }}</a></b> others</span><br>
              <span class="post-description"><b>ahmed1ghobashy</b> Limited edition</span>
              <span class="post-time">11 hours ago</span>
              <div class="line"></div>
              <form action="{{ url('addComment') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-9">
                        <input type="hidden" value="{{ $post->id }}" name="imageId">
                        <input name="comment" type="text" class="comment-input mx-3" placeholder="Add a comment" >
                    </div>
                    <div class="col-3 end">
                        <button type="submit" class="mx-3 comment-btn">Post</button>
                    </div>
                  </div>
              </form>


        </div>

        @endforeach
    </div>

@endsection
