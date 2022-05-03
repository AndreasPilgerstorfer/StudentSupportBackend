<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Request as Request;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as RequestResponse;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    // GET all requests
    public function index()
    {
        return Request::with("offer", "user")->get();
    }

    // Get all pending requests for one teacher
    public function getPendingRequestsTeacher($id)
    {
        $requests = Request::with("offer", "user")
            ->where("state", "pending")
            ->WhereHas("offer", function ($query) use ($id) {
                $query->where("user_id", $id);
            })->get();

        return $requests != null ? response()->json($requests, 200) : response()->json(null, 200);
    }

    // CREATE new Request
    public function save(RequestResponse $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = Request::create($request->all());

            DB::commit();
            return response()->json($request, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving Request failed: " . $e->getMessage(), 420);
        }
    }

    // DELETE Request by Request id
    public function delete(string $id): JsonResponse
    {
        $request = Request::where("id", $id)->first();

        if ($request != null) {
            $request->delete();
        } else {
            throw new Exception("Request could not be deleted - does not exist.");
        }

        return response()->json("Request (" . $id . ") was deleted.", 200);
    }

    // UPDATE existing Message
    public function update(RequestResponse $requestResponse, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $request = Request::all()->where('id', $id)->first();

            if ($request != null) {
                $request->update($requestResponse->all());
                $request->save();
            }

            DB::commit();
            $updated_request = Request::all()->where('id', $id)->first();
            return response()->json($updated_request, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating Request failed: " . $e->getMessage(), 420);
        }
    }

}
