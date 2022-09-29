@extends('header')
@section('css-file-and-page-name')
<link rel="stylesheet" href="css/edit-profile.css">
    <title>Edit profile</title>
@endsection
@section('body')

    <div class="edit-profile-container">
        <form action="update" method="POST" enctype="multipart/form-data">
            @csrf
            <table>
                <tr>
                    @if (session()->has('img'))
                    <td class="end"><img src="{{ asset('../storage/app/public/uploads/'.session('img')) }}" alt="" class="profile-image" id="profile-image"></td>
                    @else
                    <td class="end"><img src="{{ asset('img/user.png') }}" alt="" class="profile-image" id="profile-image"></td>
                    @endif

                    <td>
                        <div class="row gutter">
                            <span class="username-span">{{session('username')}}</span>
                        </div>
                        <div class="row gutter">
                            <label for="file" id="upload-btn">Change profile photo</label>
                            <input name="img" id="file" type="file" accept="image/*" class="custom-file-input">
                        </div>

                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Name</span>
                    </td>
                    <td>
                    <input name="name" type="text" value="{{session('name')}}" placeholder="Full name" class="input">
                    </td>
                </tr>

                <tr>
                    <td>
                    </td>
                    <td class="hint">
                        Help people discover your account by using the name that you're known by: either your full name, nickname or business name.
                        You can only change your name twice within 14 days.
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Username</span>
                    </td>
                    <td>
                    <input name="username" type="text" value="{{session('username')}}" placeholder="Username" class="input">
                    </td>
                </tr>

                <tr>
                    <td>
                    </td>
                    <td class="hint">
                        In most cases, you'll be able to change your username back to ahmed1ghobashy for another 14 days.
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Bio</span>
                    </td>
                    <td>
                    <input type="text"  placeholder="Bio" class="input">
                    </td>
                </tr>

                <tr>
                    <td>
                    </td>
                    <td class="hint">
                        Max 150 letters.
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Email address</span>
                    </td>
                    <td>
                    <input name="email" type="email" value="{{session('email')}}" placeholder="Email address" class="input">
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Phone number</span>
                    </td>
                    <td>
                    <input type="text" value="" placeholder="Phone number" class="input">
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Gender</span>
                    </td>
                    <td>
                        @if ($user->gender == 'male')
                        <input id="male" type="radio" name="gender" value="male" checked>
                        <label for="male">Male</label><br>
                        <input id="female" type="radio" name="gender" value="female">
                        <label for="female">female</label>
                        @elseif ($user->gender == 'female')
                        <input id="male" type="radio" name="gender" value="male">
                        <label for="male">Male</label><br>
                        <input id="female" type="radio" name="gender" value="female" checked>
                        <label for="female">female</label>
                        @else
                        <input id="male" type="radio" name="gender" value="male">
                        <label for="male">Male</label><br>
                        <input id="female" type="radio" name="gender" value="female">
                        <label for="female">female</label>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="end">
                        <span class="span">Privacy</span>
                    </td>
                    <td>
                        @if ($user->privacy == 'public')
                        <input id="male" type="radio" name="privacy" value="public" checked>
                        <label for="male">Public</label><br>
                        <input id="female" type="radio" name="privacy" value="private">
                        <label for="female">private</label>
                        @else
                        <input id="male" type="radio" name="privacy" value="public" checked>
                        <label for="male">Public</label><br>
                        <input id="female" type="radio" name="privacy" value="private" checked>
                        <label for="female">private</label>
                        @endif

                    </td>
                </tr>

                <tr>
                    <td>
                    </td>
                    <td class="hint">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </td>
                </tr>

            </table>

    </form>
    </div>
@endsection

@section('script')
<script>
    const file = document.getElementById('file');
    const img = document.getElementById('profile-image');
    file.addEventListener('change', function(){
        const choosedFile = this.files[0];
        if(choosedFile){
            const reader = new FileReader();

            reader.addEventListener('load',function(){
                img.setAttribute('src',reader.result);
            })
            reader.readAsDataURL(choosedFile);
        }
    });
</script>
@endsection
