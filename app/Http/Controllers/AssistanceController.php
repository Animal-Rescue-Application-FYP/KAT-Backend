<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Model\Assistance;
use Validator;

class AssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assistance = Assistance::select("assistance.*")->get()->toArray();

        return response()->json($assistance);
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'query' => 'required|string',
            'url' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try{
            Assistance::create($input);
            return response()->json([
                "ok" => true,
                "message" => "medical assistance url is successfully added",
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assistance = Assistance::select("assistance.*")
            ->where("assistance.id", $id)
            ->first();
        return  response()->json([
            "ok" => true,
            "data" => $assistance,
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'query' => 'required|string',
            'url' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try {
            $assistance = Assistance::find($id);
            if ($assistance == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $assistance->update($input);
            return response()->json([
                "ok" => true,
                "message" => "successfully modified"
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $assistance = Assistance::find($id);
            if ($assistance == false) {
                return  response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $assistance->delete([

            ]);
            return response()->json([
                "ok" => true,
                "message" => "successfully modified",
            ]);
        }catch (\Exception $ex) {
            return response()->json([
                "ok" => false,
                "error" => $ex->getMessage(),
            ]);
        }
    }
}
