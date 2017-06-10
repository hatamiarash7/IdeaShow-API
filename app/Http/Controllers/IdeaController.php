<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers;

use App\Idea;
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
        $title = 'Latest Posts';
        return view('home', compact('ideas', 'title'));
        //return view('home')->withTitle('arash')->withIdeas($ideas);
    }

    public function create(Request $request)
    {
        // if user can post i.e. user is admin or author
        if ($request->user()->can_post())
            return view('ideas.create');
        else
            return redirect('/')->withErrors('You have not sufficient permissions for writing post');
    }


    public function store(Request $request)
    {
        $idea = new Idea();

        $idea->title = $request->get('title');
        $idea->body = $request->get('body');
        $idea->slug = str_slug($idea->title);
        $idea->user_id = Auth::user()->id;
        $idea->user_name = Auth::user()->name;
        $message = 'Idea published successfully';

        $idea->save();
        return redirect('edit/' . $idea->slug)->withMessage($message);
    }

    public function show($slug)
    {
        $idea = Idea::where('slug', $slug)->first();

        if (!$idea)
            return redirect('/')->withErrors('Requested page not found');

        return view('ideas.show')->withIdea($idea);
    }

    public function edit(Request $request, $slug)
    {
        $idea = Idea::where('slug', $slug)->first();
        if ($idea && ($request->user()->id == $idea->user_id || Auth::user()->is_admin()))
            return view('ideas.edit')->with('idea', $idea);
        return redirect('/')->withErrors('you have not sufficient permissions');
    }

    public function update(Request $request)
    {
        $idea_id = $request->input('idea_id');
        $idea = Idea::find($idea_id);
        if ($idea && ($idea->user_id == Auth::user()->id || Auth::user()->is_admin())) {
            $title = $request->input('title');
            $slug = str_slug($title);
            $duplicate = Idea::where('slug', $slug)->first();
            if ($duplicate) {
                if ($duplicate->id != $idea_id)
                    return redirect('edit/' . $idea->slug)->withErrors('Title already exists.')->withInput();
                else
                    $idea->slug = $slug;
            }
            $idea->title = $title;
            $idea->body = $request->input('body');
            $idea->save();
            return redirect($idea->slug)->withMessage('Post updated successfully');
        } else {
            return redirect('/')->withErrors('you have not sufficient permissions');
        }
    }
}