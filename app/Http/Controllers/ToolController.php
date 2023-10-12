<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /*
        $tools = [
            (object) [
                "name" => "Marteau",
                "description" => "pour frapper et enfoncer des clous dans du bois ou d'autres matériaux.",
                "price" => "23.99",
            ],
            (object) [
                "name" => "Tournevis",
                "description" => "pour serrer ou desserrer les vis.",
                "price" => "15.99",
            ],
            (object) [
                "name" => "Scie",
                "description" => "pour couper le bois, le métal ou d'autres matériaux.",
                "price" => "56.33",
            ],
        ];*/
        $tools = Tool::all();
        dd($tools);

        return view('tools/index', compact('tools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Tool $tool
     * @return Response
     */
    public function show(Tool $tool)
    {
        dd($tool->price);

        return view('tools/show', [
            'tool' => $tool
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
