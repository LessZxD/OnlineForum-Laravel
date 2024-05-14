<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Auth;
use File;



class QuestionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pertanyaan = DB::table('pertanyaan')->get();
        return view('pertanyaan.index',['pertanyaan'=> $pertanyaan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $category = Category::all();
        return view('pertanyaan.create', ['category' => $category]);

        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $Userid = Auth::id();
    
    $request->validate([
        'judul' => 'required',
        'konten' => 'required',
        'image' => 'required|mimes:jpg,jpeg,png|max:2048',
        'category_id' => 'required'
    ]);

    $imageName = time().'.'. $request->image->getClientOriginalExtension();
    $request->file('image')->move(public_path('image'), $imageName);

    $pertanyaan = New Pertanyaan;

        $pertanyaan->judul = $request->input('judul');
        $pertanyaan->konten = $request->input('konten');
        $pertanyaan->users_id = $Userid;
        $pertanyaan->category_id = $request->input('category_id');
        $pertanyaan->image = $imageName;

        $pertanyaan->save();

        return redirect('/pertanyaan');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pertanyaanData = DB::table('pertanyaan')->find($id);

        return view('pertanyaan.detail', ['pertanyaanData' => $pertanyaanData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $pertanyaanData = DB::table('pertanyaan')->find($id);

        return view('pertanyaan.edit', ['pertanyaanData' => $pertanyaanData, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required'
        ]);

        // update data
        $pertanyaan = Pertanyaan::find($id);

        if($request->has('image')) {
            $path = "image/";
            File::delete($path . $pertanyaan->image);

            $posterName = time().'.'.$request->poster->extension();

            $request->poster->move(public_path('image'), $posterName);

            $pertanyaan->poster = $posterName;
        }

        $pertanyaan->judul = $request->input('judul');
        $pertanyaan->konten = $request->input('konten');
        $pertanyaan->image = $request->input('image');
        $pertanyaan->category_id = $request->input('category_id');

        $pertanyaan->save();
        // arahkan ke halaman cast
        return redirect('/pertanyaan');

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pertanyaan')->where('id', '=', $id)->delete();

        return redirect('/pertanyaan');
    }
}
