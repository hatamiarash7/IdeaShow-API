@extends('layouts.app')
@section('title')
    ایده جدید
@endsection
@section('content')
    <form action="/new-idea" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <input required="required" style="text-align: center; direction: rtl;" value="{{ old('title') }}"
                   placeholder="عنوان"
                   type="text" autocomplete="off"
                   name="title" class="form-control my_font"/>
        </div>
        <div class="form-group">
            <textarea name='body' style="text-align: center; direction: rtl;" placeholder="متن"
                      class="form-control my_font">{{ old('body') }}</textarea>
        </div>
        <input type="submit" name='publish' class="btn btn-success my_font" value="انتشار"/>
    </form>
@endsection
