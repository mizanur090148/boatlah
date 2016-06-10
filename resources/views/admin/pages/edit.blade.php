@extends('admin.layout')

@section('header')
    <link rel="stylesheet" href="{{ asset('admin/global/vendor/formvalidation/formValidation.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/examples/css/forms/validation.css') }}">
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea'});</script>
@endsection

@section('content')

    <div class="page-header">
        <h1 class="page-title"><i class="site-menu-icon fa-user" aria-hidden="true"></i> Pages</h1>
        <ol class="breadcrumb">
            <li><a href="/admin/dashboard">Home</a></li>
            <li><a href="{{ url('/admin/pages') }}">All Pages</a></li>
            <li class="active"><a>Create New</a></li>
        </ol>
        <div class="page-header-actions">
            <a class="btn btn-sm btn-primary btn-round" href="{{url('admin/pages/create')}}">
                <i class="icon md-link" aria-hidden="true"></i>
                <span class="hidden-xs">Add New</span>
            </a>
        </div>
        <div class="col-lg-4 col-sm-6">
            <!-- Example Delay -->

            <!-- End Example Delay -->
        </div>
    </div>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Panel Summary Mode -->
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add New</h3>
                    </div>
                    <div class="panel-body">
                        {{Form::open(array('url'=>'/admin/pages/'.$page->id,  'method' => 'PUT','files'=>true,'id'=>'exampleSummaryForm','autocomplete'=>'off','class'=>'form-horizontal'))}}

                        <div class="form-group form-material <?php if($errors->first('title')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" value="{{\Illuminate\Support\Facades\Input::old('title',$page->title)}}"/>
                                <span class="validator_output <?php if($errors->first('title')!=null) echo "help-block"?>">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('url')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">URL</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="url" value="{{\Illuminate\Support\Facades\Input::old('url',$page->url)}}"/>
                                <span class="validator_output <?php if($errors->first('url')!=null) echo "help-block"?>">{{ $errors->first('url') }}</span>
                            </div>
                        </div>

                        <div class="form-group form-material <?php if($errors->first('category')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-9">
                                <select name="category" class="form-control">
                                    <option value="about" @if(\Illuminate\Support\Facades\Input::old('category',$page->category)=='about') selected @endif>About</option>
                                    <option value="resources"  @if(\Illuminate\Support\Facades\Input::old('category',$page->category)=='resources') selected @endif>Resources</option>
                                </select>
                                <span class="validator_output <?php if($errors->first('category')!=null) echo "help-block"?>">{{ $errors->first('category') }}</span>
                            </div>
                        </div>
                        <div class="form-group form-material <?php if($errors->first('content')!=null) echo "has-error"?>">
                            <label class="col-sm-3 control-label">Content</label>
                            <div class="col-sm-9">
                                <textarea name="content" id="textAreaContent">{{\Illuminate\Support\Facades\Input::old('content',$page->content)}}</textarea>
                                <span class="validator_output <?php if($errors->first('content')!=null) echo "help-block"?>">{{ $errors->first('content') }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="validateButton3">Submit</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
                <!-- End Panel Summary Mode -->
            </div>
        </div>

    </div>


@stop