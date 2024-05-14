<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = DB::table('category')->get();
 
        return view('category.index', ['category' => $category]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // insert data
        DB::table('category')->insert([
            'name' => $request->input('name'),
            'desciption' => $request->input('description')
        ]);

        // arahkan ke halaman cast
        return redirect('/category');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoryData = DB::table('category')->find($id);

        return view('category.detail', ['categoryData' => $categoryData]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoryData = DB::table('category')->find($id);

        return view('category.edit', ['categoryData' => $categoryData]);
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
        // validation data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        // update data
        DB::table('category')
            ->where('id', $id)
            ->update(
                [
                    'name' => $request->input('name'),
                    'desciption' => $request->input('description')
                ]
                );

        // arahkan ke halaman cast
        return redirect('/category');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('category')->where('id', '=', $id)->delete();

        return redirect('/category');
    }

}
