<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Providers;

class StudentController extends Controller
{
    public function index()
    {
       $data = array("students" => DB::table('students')->orderBy('created_at', 'desc')->simplePaginate(10));
        // access to data
        return view('students.index', $data);
    }

    public function show($id){
        $data = Students::findOrFail($id);
        return view('students.edit', ['student' => $data]);
    }

    public function create(){
        return view('students.create')->with('title', 'Add New');
    }

    public function store(Request $request){
        $validated = $request -> validate([
            "first_name" => ['required', 'min:4'],
            "last_name" => ['required', 'min:4'],
            "gender" => ['required', 'min:4'],
            "age" => ['required'],
            "email" => ['required', 'email', Rule::unique('students', 'email')],
        ]);

        if($request->hasFile('student_image')){
            $request->validate([
                'student_image' => 'mimes:jpeg,png,bmp,tiff |max:4096'
            ]);

            $filenameWithExtension = $request->file('student_image');

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file("student_image")->getClientOriginalExtension();

            $filenameToStore = $filename.'_'.time().'.'.$extension;

            $smallThumbnail = $filename.'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student', $filenameToStore);

            $request->file("student_image")->storeAs('public/student/thumbnail', $smallThumbnail);
        
            $thumbNail = 'storage/student/thumbnail/' .$smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 93);

            $validated['student_image'] = $filenameToStore;
        }

        Students::create($validated);

        return redirect('/')->with('message', 'New Student was added successfully!');
    }

    public function update(Request $request, Students $student){
        $validated = $request -> validate([
            "first_name" => ['required', 'min:3'],
            "last_name" => ['required', 'min:4'],
            "gender" => ['required', 'min:4'],
            "age" => ['required'],
            "email" => ['required', 'email'],
        ]);

        if($request->hasFile('student_image')){
            $request->validate([
                'student_image' => 'mimes:jpeg,png,bmp,tiff |max:4096'
            ]);

            $filenameWithExtension = $request->file('student_image');

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request->file("student_image")->getClientOriginalExtension();

            $filenameToStore = $filename.'_'.time().'.'.$extension;

            $smallThumbnail = $filename.'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student', $filenameToStore);

            $request->file("student_image")->storeAs('public/student/thumbnail', $smallThumbnail);
        
            $thumbNail = 'storage/student/thumbnail/' .$smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 150);

            $validated['student_image'] = $filenameToStore;
        }

        $student -> update($validated);

        return back()->with('message', 'Data was successfully updated');
    }

    public function destroy(Students $student){
        $student -> delete();
        return redirect('/')->with('message', 'Data was successfully deleted');
    }

    public function createThumbnail($path, $width, $height)
    {
        // dd($path);
        $img = Image::read($path)->resize($width, $height, function($constraint){
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}