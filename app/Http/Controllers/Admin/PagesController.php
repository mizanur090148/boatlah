<?php

namespace App\Http\Controllers\Admin;

use App\Pages;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Sentinel;


class PagesController extends Controller
{

    public function index()
    {
        $pages = Pages::all();
        return view('admin.pages.index')->with('pages',$pages);
    }

    public function create()
    {
        return view('admin.pages.create');
    }


    public function store(Request $request)
    {
        //return Input::all();
        $rules = [
            'title' => 'required',
            'url' => 'required|unique:pages',
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $page = new Pages();
        $page->title = Input::get('title');
        $page->url = Input::get('url');
        $page->category = Input::get('category');
        $page->content = Input::get('content');
        $page->save();

        return redirect('admin/pages')->with('success','pages created successfully');
    }


    public function show($id)
    {
        $page = Pages::find($id);
        return $page;
    }

    public function edit($id)
    {
        $page = Pages::find($id);
        return view('admin.pages.edit')->with('page',$page);
    }

    public function update(Request $request, $id)
    {
        //return Input::all();
        $rules = [
            'url' => 'required|unique:pages,url,'.$id,
            'title' => 'required'
        ];

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $page = Pages::find($id);
        $page->title = Input::get('title');
        $page->url = Input::get('url');
        $page->category = Input::get('category');
        $page->content = Input::get('content');
        $page->save();

        return redirect('admin/pages')->with('success','pages updated successfully');
    }

    public function destroy($id)
    {
        $page = Pages::find($id);
        $page->delete();
        return redirect('admin/pages')->with('success','pages deleted successfully');
    }
}
