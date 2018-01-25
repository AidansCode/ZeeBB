<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Forum;
use App\User;
use App\Post;
use App\Ban;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index() {
        $allForums = Forum::all();
        return view('pages.index')->with('forums', $allForums);
    }

    public function user($id) {
        $user = User::find($id);
        if ($user == null)
            return redirect('/')->with('error', 'The specified user could not be found!');

        return view('pages.users.show')->with('user', $user);
    }

    public function search(Request $request, $id) {
        $type = $request->input('type');

        if ($type == null)
            return redirect('/')->with('error', 'No search type specified!');

        $user = User::find($id);
        $results = null;
        if ($type == 'thread')
            $results = $user->threads()->orderBy('created_at', 'DESC')->paginate(10);
        else
            $results = $user->posts()->orderBy('created_at', 'DESC')->paginate(10);

        $data = [
            'results' => $results,
            'user' => $user,
            'type' => $type == 'thread' ? 'Threads' : 'Posts',
        ];

        return view('pages.search')->with($data);
    }

    public function textSearch(Request $request) {
        if ($request->input('message') != null) {
            $posts = Post::where('message', 'LIKE', '%' . $request->input('message') . '%')->orderBy('id', 'DESC')->paginate(10);
            return view('pages.search_text_result')->with(['posts' => $posts, 'msg' => $request->input('message')]);
        } else { //no message given
            return view('pages.search_text_form');
        }
    }

    public function banned() {
        $ban = Ban::where('user_id', Auth::id())->get();
        if (isUserBanned(Auth::user())) //insure user should still be banned
            return view('pages.banned')->with('ban', $ban[0]);
        else
            return redirect('/')->with('error', 'You are not currently banned!');
    }
}
