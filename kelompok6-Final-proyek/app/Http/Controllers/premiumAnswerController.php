<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\premiumAnswer;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Auth;
use File;

class premiumAnswerController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jawabanPremium = DB::table('jawabanPremium')->get();
        return view('jawabanPremium.index',['jawabanPremium'=> $jawabanPremium]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $pertanyaan = Pertanyaan::all();
        return view('jawabanPremium.create', ['pertanyaan' => $pertanyaan]);

        
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

    $jawabanPremium = New premiumAnswer;

        $jawabanPremium->judul = $request->input('judul');
        $jawabanPremium->konten = $request->input('konten');
        $jawabanPremium->users_id = $Userid;
        $jawabanPremium->pertanyaan_id = $request->input('pertanyaan_id');
        $jawabanPremium->image = $imageName;

        $jawabanPremium->save();

        return redirect('/jawabanPremium');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jawabanPremiumData = DB::table('jawabanPremium')->find($id);

        return view('jawabanPremium.detail', ['jawabanPremiumData' => $jawabanPremiumData]);
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
        $jawabanPremiumData = DB::table('jawabanPremium')->find($id);

        return view('jawabanPremium.edit', ['jawabanPremiumData' => $jawabanPremiumData, 'pertanyaan' => $pertanyaan]);
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
        $jawabanPremium = premiumAnswer::find($id);

        // if($request->has('image')) {
        //     $path = "image/";
        //     File::delete($path . $jawabanPremium->image);

        //     $posterName = time().'.'.$request->poster->extension();

        //     $request->poster->move(public_path('image'), $posterName);

        //     $jawabanPremium->poster = $posterName;
        // }

        if ($request->hasFile('image')) {
            $path = "image/";
            File::delete($path . $jawabanPremium->image);
        
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->file('image')->move(public_path('image'), $imageName);
        
            $jawabanPremium->image = $imageName;
        }
        

        $jawabanPremium->judul = $request->input('judul');
        $jawabanPremium->konten = $request->input('konten');
        $jawabanPremium->image = $request->input('image');
        $jawabanPremium->pertanyaan_id = $request->input('pertanyaan_id');

        $jawabanPremium->save();
        // arahkan ke halaman cast
        return redirect('/jawabanPremium');

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('jawabanPremium')->where('id', '=', $id)->delete();

        return redirect('/jawabanPremium');
    }
}
