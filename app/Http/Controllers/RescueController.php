<?php

namespace App\Http\Controllers;

use App\Http\ImageUpload;
use Illuminate\Http\Request;
use App\Models\Model\Rescue;
use Illuminate\Support\Str;
use Validator;

class RescueController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rescue = Rescue::select("rescue.*")->get()->toArray();

        return response()->json($rescue);
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'animalName' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png,gig',
            'category' => 'required|string',
            'year' => 'integer',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'postedBy' => 'required|string',
            //'description' => 'text'
        ]);

        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }

        $rescue = new Rescue();


        // Check if a profile image has been uploaded
        if ($request->has('image')) {
            // Get image file
            $image = $request->file('image');
            // Make a image name based on user name and current timestamp
            $name = Str::slug($request->input('name')).'_'.time();
            // Define folder path
            $folder = '/uploads/images/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $rescue->image = $filePath;

            $rescue->animalName = $request->animalName;
            $rescue->category = $request->category;
            $rescue->year = $request->year;
            $rescue->gender = $request->gender;
            $rescue->address = $request->address;
            $rescue->phone = $request->phone;
            $rescue->postedBy = $request->postedBy;
            $rescue->description = $request->description;
            $rescue->user_id = $request->user_id;
              $rescue->save();
        }

        return  response()->json([
            "ok" => true,
            "data" => $rescue,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rescue = Rescue::select("rescue.*")
            ->where("rescue.user_id", $id)
            ->get()->toArray();
        return  response()->json([
            "ok" => true,
            "data" => $rescue,
        ]);
    }

    public function deleteImage($id){
        $userData=Rescue::findOrFail($id);
        $imageName=$userData->image;
        $deletePath=public_path('images/'.$imageName);
        if(file_exists($deletePath)){
            return unlink($deletePath);
        }
        return true;
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
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'animalName' => 'required|string',
            //'image' => 'required|mimes:jpeg,jpg,png,gig',
            'category' => 'required|string',
            'year' => 'integer',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'postedBy' => 'required|string',
            //'description' => 'text'
        ]);
        if ($validator->fails()){
            return response()->json([
                'ok' => false,
                'error' => $validator->messages(),
            ]);
        }

        if ($request->hasFile('image')){
            $image=$request->file('image');
            $ext=$image->getClientOriginalExtension();
            $imageName=Str::random(18).'.'.$ext;
            $uploadPath=public_path('images/');
            if($this->deleteImage($id) && $image->move($uploadPath,$imageName)){
                $data['images']=$imageName;
            }
        }
        try {
            $rescue = Rescue::find($id);
            if ($rescue == false) {
                return response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $rescue->update($input);
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
            $rescue = Rescue::find($id);
            if ($rescue == false) {
                return  response()->json([
                    "ok" => false,
                    "error" => "No data is found",
                ]);
            }
            $this->deleteImage($id);
            $rescue->delete([
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
