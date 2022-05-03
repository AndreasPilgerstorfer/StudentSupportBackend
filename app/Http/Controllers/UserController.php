<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // GET all users
    public function index()
    {
        return User::with("image")->get();
    }

    //GET user by ID
    public function findByID($id)
    {
        $user = User::where("id", $id)->with("image")->first();
        return $user != null ? response()->json($user, 200) : response()->json(null, 200);
    }

    // CREATE new user
    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // User an sich anlegen
            $user = User::create($request->all());

            DB::commit();
            return response()->json($user, 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving user failed: " . $e->getMessage(), 420);
        }
    }

    // UPDATE existing user
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = User::all()->where('id', $id)->first();

            if ($user != null) {
                $user->update($request->all());
                $user->save();
            }

            DB::commit();
            $updated_user = User::all()->where('id', $id)->first();
            return response()->json($updated_user, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating user failed: " . $e->getMessage(), 420);
        }
    }

    // DELETE image by id
    public function delete(string $id): JsonResponse
    {
        $user = Image::where("id", $id)->first();

        if ($user != null) {
            $user->delete();
        } else {
            throw new Exception("User could not be deleted - does not exist.");
        }

        return response()->json("User (" . $id . ") was deleted.", 200);
    }
}
