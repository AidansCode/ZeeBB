<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Group;
use App\Forum;
use App\Post;
use App\Thread;
use App\Setting;
use App\Ban;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('staff');

        $this->middleware('manage_users', ['only' =>
            ['userIndex', 'userCreate', 'userStore', 'userEdit', 'userUpdate', 'userDestroy', 'userCreateBan', 'userBan']
        ]);

        $this->middleware('manage_groups', ['only' =>
            ['groupIndex', 'groupCreate', 'groupStore', 'groupEdit', 'groupUpdate', 'groupDestroy']
        ]);

        $this->middleware('manage_forums', ['only' =>
            ['forumIndex', 'forumCreate', 'forumStore', 'forumEdit', 'forumUpdate', 'forumDestroy']
        ]);

        $this->middleware('manage_settings', ['only' =>
            ['settingIndex', 'settingUpdate']
        ]);
    }

    public function index() {
        return view('pages.admin.home')->with('adminNotes', Setting::where('name', 'adminnotes')->get()[0]);
    }

    public function userIndex() {
        $users = User::orderBy('name', 'ASC')->paginate(20);

        return view('pages.admin.users.index')->with('users', $users);
    }

    public function userCreate() {
        $rawGroups = Group::all();
        $groups = [];
        foreach ($rawGroups as $group)
            $groups[$group->id] = $group->name;

        return view('pages.admin.users.create')->with('groups', $groups);
    }

    public function userStore(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'group' => 'required|integer',
            'password' => 'required',
            'password2' => 'required|same:password',
        ]);

        $group = Group::find($request->input('group'));
        if ($group == null) { //If specified group does not exist
            return back()->withInput()->with('error', 'An illegal group was specified!');
        }

        if ($request->input('password') !== $request->input('password2')) { //If passwords don't match
            return back()->withInput()->with('error', 'The provided passwords did not match!');
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->group_id = $request->input('group');
        $user->remember_token = null;
        $user->save();

        return redirect('/admin/users')->with('success', 'You have successfully created a user with ID: ' . $user->id);
    }

    public function userEdit($id) {
        $user = User::find($id);

        if ($user == null)
            return redirect('/admin/users')->with('error', 'The specified user does not exist!');

        $rawGroups = Group::all();
        $groups = [];
        foreach ($rawGroups as $group)
            $groups[$group->id] = $group->name;

        $data = [
            'user' => $user,
            'groups' => $groups,
        ];

        isUserBanned($user); //update ban status for viewing
        return view('pages.admin.users.edit')->with($data);
    }

    public function userUpdate(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'group' => 'required|integer',
            'password2' => 'required_with:password|same:password',
        ]);

        $user = User::find($id);
        if ($user == null)
            return redirect('/admin')->with('error', 'The specified user does not exist!');

        if ($request->input('name') != $user->name) { //If name changed
            //Update all references to old name
            Forum::where('last_poster_id', '=', $user->id)
                ->update(['last_poster_name' => $request->input('name')]);

            Post::where('user_id', '=', $user->id)
                ->update(['user_name' => $request->input('name')]);


            Thread::where('user_id', '=', $user->id)
                ->update(['user_name' => $request->input('name')]);


            Thread::where('last_poster_id', '=', $user->id)
                ->update(['last_poster_name' => $request->input('name')]);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->group_id = $request->input('group');
        if ($request->input('password') != null) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect('/admin/users/edit/' . $user->id)->with('success', 'Your changes have been saved!');
    }

    public function userDestroy($id) {
        if(!userHasPermission('pl_delete_user')) {
            return redirect('/admin')->with('error', 'You do not have permission to delete users!');
        }

        User::destroy($id);

        return redirect('/admin/users/')->with('success', 'You have successfully deleted user ID: ' . $id);
    }

    public function userCreateBan($id) {
        if (!userHasPermission('pl_ban')) {
            return redirect('/admin/users/')->with('error', 'You do not have permission to ban players!');
        }

        $user = User::find($id);
        if ($user == null) {
            return redirect('/admin/users/')->with('error', 'The specified user does not exist!');
        }

        return view('pages.admin.users.create_ban')->with('user', $user);
    }

    public function userBan(Request $request, $id) {
        if (!userHasPermission('pl_ban')) {
            return redirect('/admin/users/')->with('error', 'You do not have permission to ban players!');
        }

        $user = User::find($id);
        if ($user == null) {
            return redirect('/admin/users/')->with('error', 'The specified user does not exist!');
        }

        $this->validate($request, [
            'reason' => 'required',
            'length' => 'required|integer|in:' . implode(',', array_keys(getBanLengths()))
            //last bit of ^ checks if given length is an allowed ban length
            //checks if given length is a key in getBanLengths array
        ]);

        $ban = new Ban;
        $ban->user_id = $user->id;
        $ban->group_id = $user->group_id;
        $ban->length = $request->input('length');
        $ban->reason = $request->input('reason');
        $ban->save();

        $user->group_id = Group::where('is_banned_group', '1')->get()[0]->id;
        $user->save();

        return redirect('/admin/users/edit/' . $user->id)->with('success', 'You have successfully banned user: ' . $user->name);
    }

    public function groupIndex() {
        $groups = Group::orderBy('power_level', 'DESC')->paginate(20);

        return view('pages.admin.groups.index')->with('groups', $groups);
    }

    public function groupCreate() {
        return view('pages.admin.groups.create');
    }

    public function groupStore(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:groups',
            'power_level' => 'required|integer|min:0',
            'is_staff_group' => 'sometimes|required|integer|min:0|max:1',
            'is_banned_group' => 'sometimes|required|integer|min:0|max:1',
        ]);

        $group = new Group;
        $group->name = $request->input('name');
        $group->power_level = $request->input('power_level');
        $group->is_staff_group = ($request->input('is_staff_group') ? true : false);
        $group->is_banned_group = ($request->input('is_banned_group') ? true : false);
        $group->save();

        return redirect('/admin/groups')->with('success', 'You have successfully created a group with ID: ' . $group->id);
    }

    public function groupEdit($id) {
        $group = Group::find($id);
        if ($group == null)
            return redirect('/admin/groups')->with('error', 'The specified group does not exist!');

        return view('pages.admin.groups.edit')->with('group', $group);
    }

    public function groupUpdate(Request $request, $id) {
        $group = Group::find($id);
        if ($group == null) {
            return redirect('/admin/groups')->with('error', 'The specified group does not exist!');
        }

        $this->validate($request, [
            'name' => 'required|unique:groups,name,' . $id,
            'power_level' => 'required|integer|min:0',
            'is_staff_group' => 'sometimes|required|integer|min:0|max:1',
            'is_banned_group' => 'sometimes|required|integer|min:0|max:1',
        ]);

        $group->name = $request->input('name');
        $group->power_level = $request->input('power_level');
        $group->is_staff_group = ($request->input('is_staff_group') ? true : false);
        $group->is_banned_group = ($request->input('is_banned_group') ? true : false);
        $group->save();

        return redirect('/admin/groups/edit/' . $id)->with('success', 'Your changes have been saved!');

    }

    public function groupDestroy($id) {
        $group = Group::find($id);
        $count = $group->users()->count();
        if ($count > 0) {
            return back()->withInput()->with('error', 'This group can not be deleted as ' . $count . ' user(s) are currently assigned to it. Move those users to delete the group.');
        }

        $group->delete();

        return redirect('/admin/groups/')->with('success', 'You have successfully deleted group ID: ' . $id);
    }

    public function forumIndex() {
        $data = [
            'categories' => Forum::where('type', 'c')->get(),
            'forums' => Forum::where('type', 'f')->get(),
        ];

        return view('pages.admin.forums.index')->with($data);
    }

    public function forumCreate() {
        $rawCategories = Forum::where('type', 'c')->get();
        $categories = [];
        foreach($rawCategories as $category) {
            $categories[$category->id] = $category->name;
        }
        return view('pages.admin.forums.create')->with('categories', $categories);
    }

    public function forumStore(Request $request) {
        $this->validate($request, [
            'type' => 'required|in:c,f',
            'parent_id' => 'required_if:type,==,f',
            'name' => 'required',
            'description' => 'required',
            'closed' => 'sometimes|required|integer|min:0|max:1',
        ]);

        if ($request->input('type') == 'f') { //If is type forum
            $parent = Forum::find($request->input('parent_id'));
            if ($parent == null || $parent->type == 'f') { //If specified parent does not exist or is also a forum
                return back()->withInput()->with('error', 'Illegal parent specified');
            }
        }

        $forum = new Forum;
        $forum->type = $request->input('type');
        $forum->parent_id = $forum->type == 'f' ? $request->input('parent_id') : 0;
        $forum->name = $request->input('name');
        $forum->description = $request->input('description');
        $forum->last_poster_id = 0;
        $forum->last_poster_name = '';
        $forum->last_post_id = 0;
        $forum->closed = $request->input('closed') ? true : false;
        $forum->save();

        return redirect('/admin/forums')->with('success', 'You have successfully created a forum with ID: ' . $forum->id);
    }

    public function forumEdit($id) {
        $forum = Forum::find($id);

        if ($forum == null) {
            return redirect('/admin/forums')->with('error', 'The specified forum does not exist!');
        }

        $categories = [];

        if ($forum->type == 'f') {
            $rawCategories = Forum::where('type', 'c')->get();
            foreach($rawCategories as $category) {
                $categories[$category->id] = $category->name;
            }
        }

        $data = [
            'forum' => $forum,
            'categories' => $categories,
        ];

        return view('pages.admin.forums.edit')->with($data);
    }

    public function forumUpdate(Request $request, $id) {
        $forum = Forum::find($id);
        if ($forum == null) {
            return redirect('/admin/forums')->with('error', 'The specified forum does not exist!');
        }

        $this->validate($request, [
            'type' => 'required|in:c,f',
            'parent_id' => 'sometimes|required_if:type,==,f',
            'name' => 'required',
            'description' => 'required',
            'closed' => 'sometimes|required|integer|min:0|max:1',
        ]);

        if ($forum->type == 'f') {
            $parent = Forum::find($request->input('parent_id'));
            if ($parent == null || $parent->type == 'f') { //If specified parent does not exist or is also a forum
                return back()->withInput()->with('error', 'Illegal parent specified');
            }
            $forum->parent_id = $request->input('parent_id');
        }
        $forum->name = $request->input('name');
        $forum->description = $request->input('description');
        $forum->closed = $request->input('closed') ? true : false;
        $forum->save();

        return redirect('/admin/forums/edit/' . $forum->id)->with('success', 'Your changes have been saved!');
    }

    public function forumDestroy($id) {
        $forum = Forum::find($id);
        if ($forum == null) {
            return redirect('/admin/forums')->with('error', 'The specified forum does not exist!');
        }

        if ($forum->type == 'c') { //is category
            foreach ($forum->children as $child) {
                foreach($child->threads as $thread) {
                    foreach ($thread->posts as $post) {
                        $post->delete();
                    }
                    $thread->delete();
                }
                $child->delete();
            }
            $forum->delete();
        } else { //is forum
            foreach($forum->threads as $thread) {
                foreach($thread->posts as $post) {
                    $post->delete();
                }
                $thread->delete();
            }
            $forum->delete();

            $lastPost = null;
            $parent = $forum->parent;
            foreach($parent->children as $child) { //Loop through all children to find latest 'last post'
                if ($child->posts()->count() == 0) continue;

                $childLastPost = $child->lastPost;
                if ($lastPost == null || $childLastPost->id > $lastPost->id)
                    $lastPost = $childLastPost;
            }

            if ($lastPost == null) {
                $parent->last_poster_id = 0;
                $parent->last_poster_name = '';
                $parent->last_post_id = 0;
            } else {
                $user = $lastPost->user;
                $parent->last_poster_id = $user->id;
                $parent->last_poster_name = $user->name;
                $parent->last_post_id = $lastPost->id;
            }
            $parent->save();
        }

        return redirect('/admin/forums')->with('success', 'You have successfully deleted forum id ' . $id . '!');
    }

    public function settingIndex() {
        $settings = Setting::where('name', '!=', 'adminnotes')->paginate(10);

        return view('pages.admin.settings.index')->with('settings', $settings);
    }

    public function settingUpdate(Request $request, $id) {
        $setting = Setting::find($id);
        if ($setting == null) {
            return redirect('/admin')->with('error', 'The specified setting does not exist!');
        }

        $type = $setting->type;
        if ($type == 'textarea' || $type == 'text') {
            $val = $request->input('value');
            $setting->value = $val != null ? $val : ''; //If value is specified, use value, otherwise use empty string
        } else if ($type == 'number') {
            $val = intval($request->input('value'));
            if ($val < 0) {
                return back()->withInput()->with('error', 'Value has a minimum of 0.');
            }
            $setting->value = $val;
        }
        $setting->save();

        return back()->with('success', 'Your changes have been saved!');
    }
}
