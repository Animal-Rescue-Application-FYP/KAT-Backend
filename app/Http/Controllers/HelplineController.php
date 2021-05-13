<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model\Helpline;
use Validator;

class HelplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $helpline = Helpline::select("helpline.*")->get()->toArray();

            return response()->json($helpline);
    }

    /**
     * Show the form for creating a new resource.
     *
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
            'name' => 'required|unique:helpline|max:60',
            'address' => 'required|string',
            'phone' => 'required|string'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try{
            Helpline::create($input);
            return response()->json([
                "ok" => true,
                "message" => "helpline number is successfully created",
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
        $helpline = Helpline::select("helpline.*")
            ->where("helpline.id", $id)
            ->first();
        return  response()->json([
            "ok" => true,
            "data" => $helpline,
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
           'name' => 'required|max:60',
           'address' => 'required|string',
            'phone' => 'required|string',
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }
        try {
            $helpline = Helpline::find($id);
            if ($helpline == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $helpline->update($input);
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
            $helpline = Helpline::find($id);
            if ($helpline == false) {
                return  response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $helpline->delete([

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
