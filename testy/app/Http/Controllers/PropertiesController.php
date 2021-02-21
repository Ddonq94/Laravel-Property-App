<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

use Intervention\Image\ImageManagerStatic as Image;

use GuzzleHttp\Client;


class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //load landing page showing properties paginated

        $properties = Property::orderBy('created_at', 'desc')->paginate(50);
        return view('properties.index')->with('properties',$properties);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // go to create form
        return view('properties.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate and store properties
        $request->validate([
            'county'=> 'required',
            'country'=> 'required',
            'town'=> 'required',
            'description'=> 'required',
            'address'=> 'required',
            'image_full' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'num_bedrooms' => 'required|integer|min:1|not_in:0',
            'num_bathrooms' => 'required|integer|min:1|not_in:0',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'property_type_id' => 'required|integer|min:1|not_in:0',
            'type'=> 'required',

        ]);

       

        // image manipulate
        if($request->hasFile('image_full')) {
           
            //get filename and extension
            $filename = pathinfo($request->file('image_full')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $request->file('image_full')->getClientOriginalExtension();
      
            //filename
            $imageName = $filename.'_'.time().'.'.$ext;
     
            //thumb
            $thumbnail = $filename.'_thumb_'.time().'.'.$ext;
     
            
            //Upload Files
            $request->file('image_full')->storeAs('public'. DIRECTORY_SEPARATOR .'profile_images', $imageName);
            $request->file('image_full')->storeAs('public'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .'thumbnail', $thumbnail);
           
      
            //resize thumbnail
            $thumbnailpath = public_path('storage'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .'thumbnail'. DIRECTORY_SEPARATOR .''.$thumbnail);
            $this->createThumbnail($thumbnailpath, 100, 100);
     
            $fullPath = public_path('storage'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .''.$imageName);
    
            $request->merge(['image_thumbnail' => $thumbnailpath]);
            $request->merge(['image_full' => $fullPath]);
        }

        // dd($request);
        
        $property = Property::create($request->all());

        return redirect('/properties')->with('success', 'Property Saved Successfully');

    }



    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //load selected property
        $property = Property::find($id);
        // return $task;
        return view('properties.edit')->with('property',$property);
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
        $request->validate([
            'county'=> 'required',
            'country'=> 'required',
            'town'=> 'required',
            'description'=> 'required',
            'address'=> 'required',
            // 'image_full' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'num_bedrooms' => 'required|integer|min:1|not_in:0',
            'num_bathrooms' => 'required|integer|min:1|not_in:0',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'property_type_id' => 'required|integer|min:1|not_in:0',
            'type'=> 'required',

        ]);


        $prop = Property::find($id);

        if($request->hasFile('image_full')) {
           
            //get filename and extension
            $filename = pathinfo($request->file('image_full')->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $request->file('image_full')->getClientOriginalExtension();
      
            //filename
            $imageName = $filename.'_'.time().'.'.$ext;
     
            //thumb
            $thumbnail = $filename.'_thumb_'.time().'.'.$ext;
     
            
            //Upload Files
            $request->file('image_full')->storeAs('public'. DIRECTORY_SEPARATOR .'profile_images', $imageName);
            $request->file('image_full')->storeAs('public'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .'thumbnail', $thumbnail);
           
      
            //resize thumbnail
            $thumbnailpath = public_path('storage'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .'thumbnail'. DIRECTORY_SEPARATOR .''.$thumbnail);
            $this->createThumbnail($thumbnailpath, 100, 100);
     
            $fullPath = public_path('storage'. DIRECTORY_SEPARATOR .'profile_images'. DIRECTORY_SEPARATOR .''.$imageName);
    
            $request->merge(['image_thumbnail' => $thumbnailpath]);
            $request->merge(['image_full' => $fullPath]);
        }
        else{
            $request->merge(['image_thumbnail' => $prop->image_thumbnail]);
            $request->merge(['image_full' => $prop->image_full]);
        }


        // dd($request);



        $prop->update($request->all());

        return redirect('/properties')->with('success', 'Property Updated Successfully');
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
        Property::find($id)->delete();

        return redirect('/properties')->with('success', 'Property Deleted Successfully');
    }



    public function apiLoad($next = null)
    {

        ini_set('max_execution_time', 600); //10 minutes
        // dd("stew");
        $client = new Client();

        if($next== null){

            $url = "https://trialapi.craig.mtcdevserver.com/api/properties?api_key=2S7rhsaq9X1cnfkMCPHX64YsWYyfe1he&page[number]=1&page[size]=100";
        }
        else{
            $url = $next;
        }

       

        $response = $client->request('GET', $url, [
            // 'json' => $params,
            // 'headers' => $headers,
            'verify'  => false,
        ]);

        $responseBody = json_decode($response->getBody());

        // dd($responseBody);
        $resData = array_map(array($this, 'filt'), $responseBody->data);
        // $resData = $responseBody->data->map();;

        $res = Property::insert($resData);


        if($res && $responseBody->next_page_url != null ){
            $this->apiLoad($responseBody->next_page_url);
        }

        return redirect('/properties')->with('success', 'All API Properties Saved Successfully');
    }



    function filt ($val)  {

        // $val->get()->toArray();
        $val = (array)$val;

        unset($val['uuid']);
        unset($val['property_type']);
    
        return $val;
    
    }



}
