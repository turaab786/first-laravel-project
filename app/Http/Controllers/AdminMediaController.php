<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminMediaController extends Controller
{
    public function index(){
        $photos = Photo::paginate(5);
        return view('admin.media.index',compact('photos'));
    }

    public function upload(){
        return view('admin.media.create');
    }

    public function store(Request $request){
        $file = $request->file('file');

        $name = time() . $file->getClientOriginalName();

        $file->move('images',$name);

        Photo::create(['file'=>$name]);
    }

    public function delete(Request $request){
        $input = $request->all();
        if(empty($input['selected'])){
            Session::flash('media_unsuccess','Select Media first to delete.');
            return redirect()->route('admin.media.index');
        }
        DB::table('photos')->whereIn('id',$input['selected'])->delete();
        Session::flash('media_success','Media Deleted');
        return redirect()->route('admin.media.index');
    }
}
