@extends('layouts.profile')

@section('title', 'プロフィール登録')

@section('content')
    <div class="container"> 
        <div class="row">
            <h1 class="page-title col-md-12">プロフィール作成</h1>
        </div>
        <form action="{{ action('ProfileController@create') }}" method="post" enctype="multipart/form-data">
            @if (count($errors) > 0)
               <ul>
                    @foreach($errors->all() as $error)
                       <li>{{ $error }}</li>
                    @endforeach    
               </ul>
            @endif
            <div class="form-group row">
                <label class="col-md-6">性別</label>
            　  <div class="col-md-9">
              　    <div class="form-check">
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="男性" {{ is_array(old('gender')) && in_array("男性", old('gender'), true)? 'checked="checked"' : '' }}> 男性
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="女性" {{ is_array(old('gender')) && in_array("女性", old('gender'), true)? 'checked="checked"' : '' }}> 女性
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="非公開" {{ is_array(old('gender')) && in_array("非公開", old('gender'), true)?' checked="checked"' : '' }}> 非公開
                        </label>
                    </div>
                </div>
            </div>
          
            <div class="form-group row">
                <label class="col-md-6">年齢</label>
                <div class="col-md-9">
                    <div class="form-check">
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="generation" value="１０代" {{ is_array(old('generation')) && in_array("１０代", old('generation'), true)? 'checked="checked"' : '' }}> １０代以下
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="generation" value="２０代" {{ is_array(old('generation')) && in_array("２０代", old('generation'), true)? 'checked="checked"' : '' }}> ２０代
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="generation" value="３０代" {{ is_array(old('generation')) && in_array("３０代", old('generation'), true)? 'checked="checked"' : '' }}> ３０代
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="generation" value="４０代" {{ is_array(old('generation')) && in_array("４０代", old('generation'), true)? 'checked="checked"' : '' }}> ４０代
                        </label>
                        <label class="form-check-inline">
                            <input class="form-check-input" type="radio" name="generation" value="５０代以上" {{ is_array(old('generation')) && in_array("５０代以上", old('generation'), true)? 'checked="checked"' : '' }}> ５０代以上
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-6">好きなアーティスト</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="artist" rows="5">{{ old('artist') }}</textarea>
                </div>
            </div>
          
            <div class="form-group row">
                <label class="col-md-6">自己紹介</label>
                <div class="col-md-9">
                    <textarea class="form-control" name="introduction" rows="10">{{ old('introduction') }}</textarea>
                </div>
            </div>
            {{ csrf_field() }}
            <input type="submit" class="btn btn-dark" value="登録">
        </form>   
    </div>
@endsection   