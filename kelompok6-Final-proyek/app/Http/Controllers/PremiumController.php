<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Premium;
use Illuminate\Support\Facades\Auth;
use File;



class PremiumController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $premium = DB::table('premium')->get();
        // return view('premium.index',['premium'=> $premium]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $category = Category::all();
        return view('premium.create', ['category' => $category]);

        
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

    $premium = New premium;

        $premium->judul = $request->input('judul');
        $premium->konten = $request->input('konten');
        $premium->users_id = $Userid;
        $premium->category_id = $request->input('category_id');
        $premium->image = $imageName;

        $premium->save();

        return redirect('/premium');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $premiumData = DB::table('premium')->find($id);

        return view('premium.detail', ['premiumData' => $premiumData]);
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
        $premiumData = DB::table('premium')->find($id);

        return view('premium.edit', ['premiumData' => $premiumData, 'category' => $category]);
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
        $premium = premium::find($id);

        if($request->has('image')) {
            $path = "image/";
            File::delete($path . $premium->image);

            $posterName = time().'.'.$request->poster->extension();

            $request->poster->move(public_path('image'), $posterName);

            $premium->poster = $posterName;
        }

        $premium->judul = $request->input('judul');
        $premium->konten = $request->input('konten');
        $premium->image = $request->input('image');
        $premium->category_id = $request->input('category_id');

        $premium->save();
        // arahkan ke halaman cast
        return redirect('/premium');

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('premium')->where('id', '=', $id)->delete();

        return redirect('/premium');
    }
}
