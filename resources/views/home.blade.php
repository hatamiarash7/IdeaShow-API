@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    @if ( !$ideas->count() )
        There is no post till now. Login and write a new post now!!!
    @else
        <div class="">
            @foreach( $ideas as $idea )
                <div class="list-group">
                    <div class="list-group-item">
                        <h3><a href="{{ url('/'.$idea->slug) }}">{{ $idea->title }}</a>
                            @if(!Auth::guest() && ($idea->author_id == Auth::user()->id || Auth::user()->is_admin()))
                                @if($idea->active == '1')
                                    <button class="btn" style="float: right"><a href="{{ url('edit/'.$idea->slug)}}">Edit
                                            Post</a></button>
                                @else
                                    <button class="btn" style="float: right"><a href="{{ url('edit/'.$idea->slug)}}">Edit
                                            Draft</a></button>
                                @endif
                            @endif
                        </h3>
                        <p>{{ $idea->created_at->format('M d,Y \a\t h:i a') }} By <a
                                    href="{{ url('/user/'.$idea->user_id)}}">{{ $idea->user_name }}</a></p>
                    </div>
                    <div class="list-group-item">
                        <article>
                            {!! str_limit($idea->body, $limit = 1500, $end = '....... <a href='.url("/".$idea->slug).'>Read More</a>') !!}
                        </article>
                    </div>
                </div>
            @endforeach
            {!! $ideas->render() !!}
        </div>
    @endif
@endsection
