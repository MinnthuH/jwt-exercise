<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    // COURSE ENROLLMENT - POST
    public function courseEnrollment(Request $request)
    {
        // validate
        $request->validate([
            'title' => 'required',
            'description'=>'required',
            'total_videos'=>'required'
        ]);

        // create course

        $course = new Course();

        $course->user_id = auth()->user()->id;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->total_videos = $request->total_videos;

        $course->save();

        // response data
        return response()->json([

            'status' =>1,
            'message' => 'Course created successfully'
        ],200);

    }

    // TOTAL COURSES - GET
    public function totalCourses()
    {

        $id = auth()->user()->id;

        $courses = User::find($id)->courses;

        return response()->json([

            'status' =>1,
            'message' => 'Total Courses',
            'data' => $courses
        ]);
    }

    // DELETE COURSE - GET
    public function deleteCourse($id)
    {
       $user_id = auth()->user()->id;

        if(Course::where([
            'id'=>$id,
            'user_id'=>$user_id
        ])->exists()){
            Course::find($id)->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Course deleted successfully'
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'message' => 'Course not found'
            ],404);
        }



    }

}
