@extends('layouts.app')
@section('title')
    ویرایش ایده
@endsection
@section('content')
    <form method="post" action='{{ url("/update") }}'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="idea_id" value="{{ $idea->id }}{{ old('idea_id') }}">
        <div class="form-group">
            <input required="required" style="text-align: center; direction: rtl;" placeholder="Enter title here"
                   type="text" name="title" class="form-control my_font" autocomplete="off"
                   value="@if(!old('title')){{$idea->title}}@endif{{ old('title') }}"/>
        </div>
        <div class="form-group">
            <textarea name='body' style="text-align: center; direction: rtl;" placeholder="متن"
                      class="form-control my_font">@if(!old('body')){!! $idea->body !!}@endif{!! old('body') !!}</textarea>
        </div>
        <a href="{{  url('delete/'.$idea->id.'?_token='.csrf_token()) }}" class="btn btn-danger my_font">حذف</a>
        <input type="submit" name='publish' class="btn btn-success my_font" value="ثبت"/>
    </form>
@endsection
