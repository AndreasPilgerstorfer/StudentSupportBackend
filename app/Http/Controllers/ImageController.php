<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    // GET all images
    public function index()
    {
        $images = Image::all();
        return $images;
    }

    // DELETE image by id
    public function delete(string $id): JsonResponse
    {
        $image = Image::where("id", $id)->first();

        if ($image != null) {
            $image->delete();
        } else {
            throw new Exception("Image could not be deleted - does not exist.");
        }

        return response()->json("Image (" . $id . ") was deleted.", 200);
    }

    // CREATE new image
    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $image = Image::create($request->all());
            DB::commit();
            return response()->json($image, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving image failed: " . $e->getMessage(), 420);
        }
    }

    // UPDATE existing image
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $image = Image::all()->where('id', $id)->first();

            if ($image != null) {
                $image->update($request->all());
                $image->save();
            }

            DB::commit();
            $updated_image = Image::all()->where('id', $id)->first();
            return response()->json($updated_image, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating image failed: " . $e->getMessage(), 420);
        }
    }
}
