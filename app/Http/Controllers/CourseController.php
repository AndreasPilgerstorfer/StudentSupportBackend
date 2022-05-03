<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    // GET all courses
    public function index()
    {
        $courses = Course::with("image")->get();
        return $courses;
    }

    //GET Book by ID
    public function findByID($id)
    {
        $course = Course::where("id", $id)->with(["image"])->first();
        return $course != null ? response()->json($course, 200) : response()->json(null, 200);
    }

    // DELETE course by id
    public function deleteById(string $id): JsonResponse
    {
        $course = Course::where("id", $id)->first();

        if ($course != null) {
            $course->delete();
        } else {
            throw new Exception("Course could not be deleted - does not exist.");
        }

        return response()->json("Course (" . $id . ") was deleted.", 200);
    }

    // DELETE course by number
    public function deleteByNumber(string $number): JsonResponse
    {
        $course = Course::where("number", $number)->first();

        if ($course != null) {
            $course->delete();
        } else {
            throw new Exception("Course could not be deleted - does not exist.");
        }

        return response()->json("Course (" . $number . ") was deleted.", 200);
    }

    // CREATE new course
    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Course an sich anlegen
            $course = Course::create($request->all());

            DB::commit();
            return response()->json($course, 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving course failed: " . $e->getMessage(), 420);
        }
    }

    // UPDATE existing course
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $course = Course::all()->where('id', $id)->first();

            if ($course != null) {
                $course->update($request->all());
                $course->save();
            }

            DB::commit();
            $updated_curse = Course::all()->where('id', $id)->first();

            return response()->json($updated_curse, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating course failed: " . $e->getMessage(), 420);
        }
    }
}
