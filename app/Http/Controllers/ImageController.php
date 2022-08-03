<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Image;
  
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imageUpload');
    }
      
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
      
        $images = [];
        if ($request->images){
            foreach($request->images as $key => $image)
            {
                $imageName = time().rand(1,99).'.'.$image->extension();  
                $image->move(public_path('images'), $imageName);
  
                $images[]['name'] = $imageName;
            }
        }
  
        foreach ($images as $key => $image) {
            Image::create($image);
        }
        // $image->move(public_path('images'), $imageName);
        // public/images/file.png
        return back()
                ->with('success','You have successfully upload image.')
                ->with('images', $images); 
    }
}