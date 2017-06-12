<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers;

use App\Idea;
use App\Like;
use App\Services\v1\IdeaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    protected $Ideas;

    public function __construct(IdeaService $service)
    {
        $this->Ideas = $service;
    }

    public function index()
    {
        //fetch 5 posts from database which are active and latest
        $ideas = Idea::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);
        $title = 'آخرین ایده ها';
        return view('home', compact('ideas', 'title'));
    }

    public function create(Request $request)
    {
        // if user can post i.e. user is admin or author
        if ($request->user()->can_post())
            return view('ideas.create');
        else
            return redirect('/')->withErrors('دسترسی غیرمجاز');
    }


    public function store(Request $request)
    {
        $idea = new Idea();

        $idea->title = $request->get('title');
        $idea->body = $request->get('body');
        $idea->slug = uniqid('', false);
        $idea->user_id = Auth::user()->id;
        $idea->user_name = Auth::user()->name;
        $idea->date = $this->getDate($this->getCurrentTime());
        $idea->time = $this->getTime($this->getCurrentTime());
        $message = 'ایده منتشر شد';

        $idea->save();
        return redirect('edit/' . $idea->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $idea = Idea::where('slug', $slug)->first();

        if (!$idea)
            return redirect('/')->withErrors('صفحه مورد نظر یافت نشد');

        return view('ideas.show')->withIdea($idea);
    }

    public function edit(Request $request, $slug)
    {
        $idea = Idea::where('slug', $slug)->first();
        if ($idea && ($request->user()->id == $idea->user_id || Auth::user()->is_admin()))
            return view('ideas.edit')->with('idea', $idea);
        return redirect('/')->withErrors('دسترسی غیرمجاز');
    }

    public function update(Request $request)
    {
        $idea_id = $request->input('idea_id');
        $idea = Idea::find($idea_id);
        if ($idea && ($idea->user_id == Auth::user()->id || Auth::user()->is_admin())) {
            $title = $request->input('title');
            $idea->title = $title;
            $idea->body = $request->input('body');
            $idea->save();
            return redirect($idea->slug)->withMessage('ایده به روزرسانی شد');
        } else {
            return redirect('/')->withErrors('دسترسی غیرمجاز');
        }
    }

    public function destroy($id)
    {
        $idea = Idea::find($id);
        if ($idea && ($idea->user_id == Auth::user()->id || Auth::user()->is_admin())) {
            $idea->delete();
            $data['message'] = 'ایده حذف شد';
        } else {
            $data['errors'] = 'دسترسی غیرمجاز';
        }
        return redirect('/')->with($data);
    }

    public function like(Request $request)
    {

        $idea_id = $request->input('idea_id');
        $idea = Idea::find($idea_id);
        $idea->like = $idea->like + 1;
        $idea->save();

        $like = Like::where([
            'user_id' => $request->get('user_id'),
            'idea_id' => $request->get('idea_id'),
            'type' => 0
        ])->first();
        if (!$like) {
            $like = new Like();
            $like->user_id = $request->get('user_id');
            $like->idea_id = $request->get('idea_id');
            $like->type = 0;
            $like->save();
        }

        return "committed";
    }

    public function dislike(Request $request)
    {

        $idea_id = $request->input('idea_id');
        $idea = Idea::find($idea_id);
        $idea->dislike = $idea->dislike + 1;
        $idea->save();

        $like = Like::where([
            'user_id' => $request->get('user_id'),
            'idea_id' => $request->get('idea_id'),
            'type' => 0
        ])->first();
        if ($like) {
            $like->delete();

            $idea_id = $request->input('idea_id');
            $idea = Idea::find($idea_id);
            $idea->like = $idea->like - 1;
            $idea->save();
        }

        $dislike = Like::where([
            'user_id' => $request->get('user_id'),
            'idea_id' => $request->get('idea_id'),
            'type' => 1
        ])->first();
        if (!$dislike) {
            $dislike = new Like();
            $dislike->user_id = $request->get('user_id');
            $dislike->idea_id = $request->get('idea_id');
            $dislike->type = 1;
            $dislike->save();
        }

        return "committed";
    }

    protected function getCurrentTime()
    {
        $now = date("Y-m-d", time());
        $time = date("H:i:s", time());
        return $now . ' ' . $time;
    }

    protected function getDate($date)
    {
        $now = explode(" ", $date)[0];
        $time = explode(" ", $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jdate("Y/m/d", $timestamp);
        return $date;
    }

    protected function getTime($date)
    {
        $now = explode(" ", $date)[0];
        $time = explode(" ", $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jdate("H:i", $timestamp);
        return $date;
    }

}