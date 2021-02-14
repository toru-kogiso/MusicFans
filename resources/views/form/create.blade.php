@extends('layouts.form')

@section('title', 'お問合せ')

@section('content')
    <div class="container"> 
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="page-title">お問合せフォーム</h1>
                <form action="{{ action('FormController@create') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                               <li>{{ $e }}</li>
                            @endforeach    
                        </ul>
                    @endif
                  
                    <div class="form-group row">
                        <label class="col-md-6">タイトル</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>
                  
                    <div class="form-group row">
                        <label class="col-md-6">お問合せ内容</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="body" rows="10">{{ old('body') }}</textarea>
                        </div>
                    </div>
                  
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-dark" value="送信">
                </form>
            </div>
        </div>
    </div>

@endsection   