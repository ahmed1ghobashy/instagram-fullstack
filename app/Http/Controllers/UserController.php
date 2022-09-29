<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\follow;
use App\Models\image;
use App\Models\like;
use App\Models\comment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\NullType;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\isEmpty;


class UserController extends Controller
{
    public function createUser(Request $req){
        $user = new user();
        $user->username = $req->username;
        $user->email = $req->email;
        $user->name = $req->name;
        $user->password = $req->password;
        $user->privacy = 'public';
        $user->save();
        return redirect('/');
    }

    public function login(Request $req){
        if (isset($req->username) & isset($req->password)){
            $username = $req->username;
            $password = $req->password;

            if (isset(user::where('username',$username)->get()[0])){
                $user = user::where('username',$username)->get()[0];
                if ($user->password == $req->password){
                    $this->createSession($user->id);
                    $notifications = count(follow::where('followed_id',session('id'))->where('state','Requested')->get());
                    // return $notifications;
                    session()->put('notifications',$notifications);
                    return redirect('home');
                }else{
                    return redirect('/');
                }
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }

    }
    public function logout(){
        if (session()->has('id')){
            session()->pull('id');
            session()->pull('email');
            session()->pull('username');
            session()->pull('name');
            session()->pull('notifications');
            if(session()->has('img')){
                session()->pull('img');
            }

            return redirect('login');
        }
    }

    public function editProfile(){
        $user = user::find(session('id'));
        return view('edit-profile',['user'=>$user]);
    }

    public function update(Request $req){
        $user = user::find(session('id'));
        $user->username = $req->username;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->privacy = $req->privacy;

        if ($req->gender != null){
            $user->gender = $req->gender;
        }
        $user->image_id = $user->image_id;

        if ($req->file('img')!=null){
            $size = $req->file('img')->getSize();
            $name = $req->file('img')->getClientOriginalName();
            $imageName = session('id').date('H-i-s').$name;
            $image = image::where('u_id',session('id'))->where('type','profile')->first();
            if (isset($image)){
                Storage::disk('public')->delete("uploads/" . $image->name);
                $req->file('img')->storeAs('public/uploads/',$imageName);
                $image->delete();
            }
            $req->file('img')->storeAs('public/uploads/',$imageName);
            $image = new image();
            $image->name = $imageName;
            $image->size = $size;
            $image->u_id = session('id');
            $image->username = session('username');
            $image->type = 'profile';
            $image->save();
            $imageId = image::where('u_id',session('id'))->where('type','profile')->first();
            $user->image_id = $imageId->id;
        }


        $user->save();

        if($req->privacy == 'public'){
            $follows = follow::where('followed_id',session('id'))->where('state','Requested')->get();
            foreach($follows as $follow){
                $follow->state = 'Following';
                $follow->save();
                session()->pull('notifications');
                $notifications = count(follow::where('followed_id',session('id'))->where('state','Requested')->get());
                session()->put('notifications',$notifications);
            }
        }

        $this->createSession(session('id'));
        return redirect('profile');
    }

    public function uploadPost(Request $req){
        $size = $req->file('profile-img')->getSize();
        $name = $req->file('profile-img')->getClientOriginalName();
        $imageName = session('id').date('H-i-s').$name;
        $req->file('profile-img')->storeAs('public/uploads/',$imageName);
        $image = new image();
        $image->name = $imageName;
        $image->size = $size;
        $image->u_id = session('id');
        $image->username = session('username');
        $image->type = 'post';
        $image->save();
        return redirect('profile');
    }

    public function search(Request $req){
        $query = $req->search;
        $users = user::where('name','LIKE','%'.$query.'%')->orWhere('username','LIKE',$query.'%')->get();
        $images = array();
        foreach ($users as $user){
            $image = image::where('u_id',$user->id)->where('type','profile')->first();
            $images[] = $image;
        }
        return view('search',['users'=>$users,'images'=>$images]);
    }

    public function visitProfile($profileId){
        $user = user::find($profileId);
        $follow = follow::where('followed_id',$profileId)->where('u_id',session('id'))->first();
        $followersCount = count(follow::where('followed_id',$profileId)->where('state','=','Following')->get());
        $followingCount = count(follow::where('u_id',$profileId)->where('state','=','Following')->get());
        $image = image::where('u_id',$user->id)->where('type','profile')->first();
        $imageName = null;
        if(isset($image)){
            $imageName = $image->name;
        }
        $images = image::where('u_id',$profileId)->where('type','post')->get();

        // $follow = $follow;
        $state = 'Follow';
        if(isset($follow)){
            $state = $follow->state;
        }
        return view('visit-profile',['user'=>$user, 'followers'=>$followersCount, 'following'=>$followingCount,'state'=>$state, 'imageName'=>$imageName,'images'=>$images]);
    }
    public function profile(){
        $followersCount = count(follow::where('followed_id',session('id'))->where('state','=','Following')->get());
        $followingCount = count(follow::where('u_id',session('id'))->where('state','=','Following')->get());
        $images = image::where('u_id',session('id'))->where('type','post')->get();
        return view('profile',['followers'=>$followersCount, 'following'=>$followingCount,'images'=>$images]);
    }
    public function follow($userId){
        $follow = new follow();
        $follow->u_id = session('id');

        $user = user::find($userId);
        if($user->privacy == 'public'){
            $follow->state = 'Following';
        }else{
            $follow->state = 'Requested';
        }

        $follow->followed_id = $userId;
        $follow->save();
        return redirect('visit-profile/'.$userId);
    }
    public function unfollow($userId){
        $follow = follow::where('followed_id',$userId)->where('u_id',session('id'))->first();
        $follow->delete();
        return redirect('visit-profile/'.$userId);
    }

    public function following($userId){
        $follows = follow::where('u_id','=',$userId)->where('state','=','Following')->get('followed_id');
        $users = array();
        foreach ($follows as $followId){
            $user = user::find($followId);
            $users[] = $user;
        }
        $images = array();
        foreach ($users as $user){
            $image = image::where('u_id',$user[0]->id)->where('type','profile')->first();
            $images[] = $image;
        }
        return view('follow',['pageState'=>'Following','users'=>$users,'images'=>$images]);

    }
    public function followers($userId){
        $follows = follow::where('followed_id','=',$userId)->where('state','=','Following')->get('u_id');
        $users = array();
        foreach($follows as $followId){
            $user = user::find($followId);
            $users[] = $user;
        }
        $images = array();
        foreach ($users as $user){
            $image = image::where('u_id',$user[0]->id)->where('type','profile')->first();
            $images[] = $image;
        }
        return view('follow',['pageState'=>'Followers','users'=>$users,'images'=>$images]);
    }
    public function like($imageId){
        $like = like::where('image_id',$imageId)->where('u_id',session('id'))->first();
        if(isset($like)){
            $like->delete();
        }else{
            $like = new like();
            $like->u_username = session('username');
            $like->u_id = session('id');
            $like->image_id = $imageId;
            $like->save();
        }

        return redirect()->back();
    }
    public function likes($imageId){
        $usersId = like::where('image_id',$imageId)->get('u_id');
        $users = DB::table('users')->whereIn('id',$usersId)->get();
        $profileImages = DB::table('images')->whereIn('u_id',$usersId)->where('type','profile')->get('name');
        // return $profileImages;
        return view('likes',['profileImages'=>$profileImages, 'users'=>$users]);
    }

    public function postPage($id){
        $image = image::find($id);
        $user = user::find($image->u_id);
        $username = $user->username;
        $likesCount = count(like::where('image_id',$id)->get());
        $isLiked = like::where('image_id',$id)->where('u_id',session('id'))->first();
        $profilePic = null;
        if(isset(image::find($user->image_id)->name)){
            $profilePic = image::find($user->image_id)->name;
        }

        $comments = comment::where('image_id',$id)->get();
        $usersId = comment::where('image_id',$id)->get('u_id');

        $commentUsers = [];
        foreach($usersId as $userId){
            $commentUsers[] = user::find($userId);
        }
        // return $commentUsers[1][0];
        $commentUsersImages = [];
        foreach ($commentUsers as $userr){
            if ($userr[0]->image_id == null){
                $commentUsersImages[] = null;
            }else{
                // return $userr[0]->image_id;
                $commentUsersImages[] = image::where('id',$userr[0]->image_id)->first();
            }
        }
        // return $commentUsersImages;

        return view('post',['image'=>$image,'profilePic'=>$profilePic,'username'=>$username, 'likesCount'=>$likesCount, 'isLiked'=>$isLiked, 'comments'=>$comments, 'commentUsers'=>$commentUsers, 'commentUsersImages'=>$commentUsersImages]);
    }

    public function addComment(Request $req){
        $comment = new comment();
        $comment->u_id = session('id');
        $comment->image_id = $req->imageId;
        $comment->comment = $req->comment;
        $comment->save();
        return redirect('post/'.$req->imageId);
    }

    public function homePage(){
        $followings = follow::where('u_id',session('id'))->where('state','following')->get();
        $users = [];
        $usersId = [];
        $likesCount = [];
        $isLiked = [];

        foreach($followings as $follow){
            $user = user::find($follow->followed_id);
            $users[] = $user;
            $usersId[] = $user->id;
        }
        $posts = DB::table('images')->whereIn('u_id',$usersId)->where('type','post')->get();
        $profileImages = [];
        foreach ($posts as $post){
            $user = user::find($post->u_id);
            $profileImages[] = image::where('id',$user->image_id)->where('type','profile')->get('name');
            $isLiked[] = like::where('image_id',$post->id)->where('u_id',session('id'))->first();
            $likesCount[] = count(like::where('image_id',$post->id)->get());
        }
        return view('home',['posts'=>$posts, 'profileImages'=>$profileImages, 'likesCount'=>$likesCount, 'isLiked'=>$isLiked]);
    }

    public function notificationsPage(){
        $followReqIds = follow::where('followed_id',session('id'))->where('state','Requested')->get('u_id');
        $users = DB::table('users')->whereIn('id',$followReqIds)->get();
        $usersImagesId = DB::table('users')->whereIn('id',$followReqIds)->get('image_id');
        $profileImages = [];
        foreach ($users as $user){
            $profileImages[] = image::where('id',$user->image_id)->first();
        }
        return view('notifications',['users'=>$users, 'profileImages'=>$profileImages]);
    }
    public function acceptFollow($userId){
        $follow = follow::where('u_id',$userId)->where('followed_id',session('id'))->first();
        // return $follow;
        $follow->u_id = $userId;
        $follow->state = 'Following';
        $follow->followed_id = session('id');
        $follow->save();
        session()->pull('notifications');
        $notifications = count(follow::where('followed_id',session('id'))->where('state','Requested')->get());
        session()->put('notifications',$notifications);
        return redirect('notifications');
    }
    public function rejectFollow($userId){
        $follow = follow::where('u_id',$userId)->where('followed_id',session('id'))->first();
        $follow->delete();
        session()->pull('notifications');
        $notifications = count(follow::where('followed_id',session('id'))->where('state','Requested')->get());
        session()->put('notifications',$notifications);
        return redirect('notifications');
    }

    private function createSession($id){
        $user = user::find($id);
        session()->put('id',$id);
        session()->put('email',$user->email);
        session()->put('username',$user->username);
        session()->put('name',$user->name);
        $profilePic = image::where('u_id',$id)->where('type','profile')->first();
        if (isset($profilePic)){
            session()->put('img',$profilePic->name);
        }
    }


}
