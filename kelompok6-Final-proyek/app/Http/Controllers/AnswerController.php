<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Auth;
use File;
class AnswerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jawaban = DB::table('jawaban')->get();
        return view('jawaban.index',['jawaban'=> $jawaban]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $pertanyaan = Pertanyaan::all();
        return view('jawaban.create', ['pertanyaan' => $pertanyaan]);

        
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
        'pertanyaan_id' => 'required'
    ]);

    $imageName = time().'.'. $request->image->getClientOriginalExtension();
    $request->file('image')->move(public_path('image'), $imageName);

    $jawaban = New Answer;

        $jawaban->judul = $request->input('judul');
        $jawaban->konten = $request->input('konten');
        $jawaban->users_id = $Userid;
        $jawaban->pertanyaan_id = $request->input('pertanyaan_id');
        $jawaban->image = $imageName;

        $jawaban->save();

        return redirect('/jawaban');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jawabanData = DB::table('jawaban')->find($id);

        return view('jawaban.detail', ['jawabanData' => $jawabanData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pertanyaan = Pertanyaan::all();
        $jawabanData = DB::table('jawaban')->find($id);

        return view('jawaban.edit', ['jawabanData' => $jawabanData, 'pertanyaan' => $pertanyaan]);
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
            'pertanyaan_id' => 'required'
        ]);

        // update data
        $jawaban = Answer::find($id);

        // if($request->has('image')) {
        //     $path = "image/";
        //     File::delete($path . $jawaban->image);

        //     $posterName = time().'.'.$request->poster->extension();

        //     $request->poster->move(public_path('image'), $posterName);

        //     $jawaban->poster = $posterName;
        // }

        if ($request->hasFile('image')) {
            $path = "image/";
            File::delete($path . $jawaban->image);
        
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->file('image')->move(public_path('image'), $imageName);
        
            $jawaban->image = $imageName;
        }
        

        $jawaban->judul = $request->input('judul');
        $jawaban->konten = $request->input('konten');
        $jawaban->image = $request->input('image');
        $jawaban->pertanyaan_id = $request->input('pertanyaan_id');

        $jawaban->save();
        // arahkan ke halaman cast
        return redirect('/jawaban');

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('jawaban')->where('id', '=', $id)->delete();

        return redirect('/jawaban');
    }
}
