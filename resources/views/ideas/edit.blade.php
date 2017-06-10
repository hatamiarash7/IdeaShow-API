@extends('layouts.app')
@section('title')
    ویرایش ایده
@endsection
@section('content')
    <form method="post" action='{{ url("/update") }}'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="idea_id" value="{{ $idea->id }}{{ old('idea_id') }}">
        <div class="form-group">
            <input required="required" placeholder="Enter title here" type="text" name="title" class="form-control"
                   value="@if(!old('title')){{$idea->title}}@endif{{ old('title') }}"/>
        </div>
        <div class="form-group">
            <textarea name='body'
                      class="form-control">@if(!old('body')){!! $idea->body !!}@endif{!! old('body') !!}</textarea>
        </div>
        <a href="{{  url('delete/'.$idea->id.'?_token='.csrf_token()) }}" class="btn btn-danger my_font">حذف</a>
        <input type="submit" name='publish' class="btn btn-success my_font" value="ثبت"/>
    </form>
@endsection
