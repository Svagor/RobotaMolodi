<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;


class NewsController extends Controller
{
//    const DELETE='delete object';

    public function index()
    {
        $news = News::all();
        return view('newDesign.admin.news.index', ['news' => $news]);
    }

    public function create()
    {
        return view('newDesign.admin.news.form');
    }

    public function store(Request $request)
    {
        $news = new News;
        if ($news->validateForm($request->all())) {
            $this->helperSave($news,$request);
            Session::flash('flash_message', 'news successfully created!');
            return redirect()->route('admin.news.index');
        } else {
            return redirect()->route('admin.news.create')->withInput()->withErrors($news->getErrorsMessages());
        }
    }

    public function show($id)
    {

        $newsOne = News::find($id);
        return view('newDesign.admin.news.one', ['newsOne' => $newsOne]);
    }

    public function edit($id)
    {
        $newsOne = News::find($id);
        return view('newDesign.admin.news.edit', ['newsOne' => $newsOne]);
    }

    public function update(Request $request, $id)
    {
        /**
         * @var News $newsOne
         */
        $newsOne = News::find($id);
        if ($newsOne->validateForm($request->all())) {
            if(Input::file('image')) {
                $newsOne->deletePicture();
            }
            $this->helperSave($newsOne,$request);
            Session::flash('flash_message', 'news successfully added!');
            return redirect()->route('admin.news.index');
        } else {
            return redirect()->route('admin.news.edit', ['newsOne' => $newsOne])->withInput()->withErrors($newsOne->getErrorsMessages());

        }
    }

    public function destroy($id)
    {
        /**
         * @var News $news
         */
        $news = News::find($id);
        $news->deleteNews();
        Session::flash('flash_message', 'news successfully deleted!');
        return redirect()->route('admin.news.index');
    }
    
    public function helperSave($news,$request){
        $news->fill($request->all());
        News::saveImg($news);
        $news->save();
    }



}
