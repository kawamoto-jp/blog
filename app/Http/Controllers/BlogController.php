<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    //ブログ一覧を表示する
    public function showList()
    {
        $blogs = Blog::all();

        return view('Blog.list', ['blogs' => $blogs]);
    }

    //ブログ詳細を表示する
    public function showDetail($id)
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        return view('Blog.detail', ['blog' => $blog]);
    }

    //ブログ登録画面を表示する
    public function showCreate() {
        return view('Blog.form');
    }

    //ブログ登録する
    public function exeStore(BlogRequest $request) {

        // ブログのデータを受け取る
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            Blog::create($inputs);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollBack();
            abort(500);
        }
        
        \Session::flash('err_msg', 'ブログを登録しました');
        return redirect(route('blogs'));
    }

    //ブログ編集フォームを表示する
    public function showEdit($id) {

        $blog = Blog::find($id);

        if (is_null($blog)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        return view('Blog.edit', ['blog' => $blog]);
    }

    //ブログを更新する
    public function exeUpdate(BlogRequest $request) {

        // ブログのデータを受け取る
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $blog = Blog::find($inputs['id']);
            $blog->fill([
                'title' => $inputs['title'],
                'content' => $inputs['content']
            ]);
            $blog->save();
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollBack();
            abort(500);
        }
        
        \Session::flash('err_msg', 'ブログを更新しました');
        return redirect(route('blogs'));
    }

    //ブログ削除
    public function exeDelete($id) {

        if (empty($id)) {
            \Session::flash('err_msg', 'データがありません');
            return redirect(route('blogs'));
        }

        try {
            Blog::destroy($id);
        } catch(\Throwable $e) {
            abort(500);
        }

        \Session::flash('err_msg', '削除しました。');
        return redirect(route('blogs'));
    }
}
