<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Thread;
use App\Post;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/')->with('error', 'No thread specified!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $forumsRaw = Forum::where('type', 'f')->get();
        $forums = [];
        foreach ($forumsRaw as $forum) {
            $forums[$forum->id] = $forum->name;
        }

        $data = [
            'forums' => $forums,
        ];
        $default = $request->input('forum');
        if ($default != null)
            $data['default'] = $default;

        return view('pages.threads.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'forum' => 'required|integer|min:0',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $forum = Forum::find($request->input('forum'));
        if ($forum == null)
            return back()->withInput()->with('error', 'Invalid forum specified');

        $user = auth()->user();

        $post = new Post;
        $post->thread_id = 0;
        $post->forum_id = $forum->id;
        $post->user_id = $user->id;
        $post->user_name = $user->name;
        $post->subject = $request->input('subject');
        $post->message = $request->input('message');
        $post->save();

        $thread = new Thread;
        $thread->forum_id = $forum->id;
        $thread->user_id = auth()->user()->id;
        $thread->user_name = auth()->user()->name;
        $thread->subject = $request->input('subject');
        $thread->first_post_id = $post->id;
        $thread->last_poster_id = $user->id;
        $thread->last_poster_name = $user->name;
        $thread->closed = 0;
        $thread->save();

        $post->thread_id = $thread->id;
        $post->save();

        $forum->last_poster_id = auth()->user()->id;
        $forum->last_poster_name = auth()->user()->name;
        $forum->last_post_id = $post->id;
        $forum->save();

        $cat = $forum->parent;
        $cat->last_poster_id = auth()->user()->id;
        $cat->last_poster_name = auth()->user()->name;
        $cat->last_post_id = $post->id;
        $cat->save();

        return redirect('/thread/' . $thread->id)->with('success', 'Your thread has been created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = Thread::find($id);
        if ($thread == null) {
            return redirect('/')->with('error', 'The specified thread could not be found!');
        }

        $forum = $thread->forum;
        $data = [
            'thread' => $thread,
            'category' => $forum->parent,
            'forum' => $forum,
            'posts' => $thread->posts()->orderBy('created_at', 'ASC')->paginate(10),
        ];

        return view('pages.threads.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
