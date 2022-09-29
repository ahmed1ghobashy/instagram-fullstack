@if (!session()->has('id'))
    <script>window.location = "{{ url('login') }}";</script>
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('css-file-and-page-name')
</head>
<body>
    <div class="header">
        <div class="header-container">
            <div class="container text-center">
                <div class="row">
                  <div class="col start">
                    <img src="{{ asset('img/instagram-logo.png') }}" alt="" class="header-logo">
                  </div>
                  <div class="col d-none d-lg-block">

                    <form class="d-flex" role="search" method="POST" action="{{url('search')}}">
                      @csrf
                        <input name="search" class="form-control me-2 header-search" type="search" placeholder="Search" aria-label="Search" >
                    </form>

                  </div>
                  <div class="col header-icons end">
                    <a href="{{url('home')}}" class="header-a"><i class="fa-solid fa-house"></i></a>
                    <a href="messages.html" class="header-a"><i class="fa-brands fa-facebook-messenger"></i></a>
                    <button class="header-btn" id="header-add"><i class="fa-regular fa-square-plus"></i></button>
                    <a href="{{ url('notifications') }}" class="header-a position-relative" style="text-decoration: none;"><i class="fa-solid fa-heart"></i>
                        @if (session('notifications') != 0)
                        <span class="position-absolute start-100 top-0 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                            {{session('notifications')}}

                        @endif

                    </a>



                    <div class="dropdown-center">
                        <button class="header-profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                            @if (session()->has('img'))
                            <img src="{{ asset('../storage/app/public/uploads/'.session('img')) }}" alt="">
                            @else
                            <img src="{{ asset('img/user.png') }}" alt="">
                            @endif

                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{url('profile')}}"><i class="fa-regular fa-user"></i> Profile</a></li>
                            {{-- <li><a class="dropdown-item" href="#"><i class="fa-regular fa-bookmark"></i> Saved</a></li> --}}
                            <li><a class="dropdown-item" href="{{url('edit-profile')}}"><i class="fa-sharp fa-solid fa-gear"></i> Settings</a></li>
                            <li><a class="dropdown-item" href="{{url('logout')}}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="add-post-background">
      <div class="add-post-container text-center pt-2">
          <div class="container text-center">
              <div class="row">
                <div class="col">

                </div>
                <div class="col">
                  <span>Create new post</span>
                </div>
                <div class="col end">
                  <button type="button" class="btn-close" aria-label="Close" id="add-post-close-btn"></button>
                </div>
              </div>
            </div>

            <div class="line"></div>
            <i class="fa-sharp fa-solid fa-images add-post-icon"></i>
            <span class="add-posts-span">Add photos and videos here</span>
            <form action="{{ url('uploadPost') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="post-file" id="header-upload-btn">Choose photo</label>
                <input id="post-file" type="file" accept="image/*" name="profile-img">
                <button type="submit" class="btn btn-primary add-post-btn">Post</button>
              </form>

      </div>
  </div>

  @yield('comments-section')

    <div class="margin"></div>
    @yield('body')
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    @yield('script')
</body>
</html>
