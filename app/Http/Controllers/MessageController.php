<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // GET all Messages
    public function index()
    {
        return Message::with("offer", "user")->get();
    }

    // GET all messages by teacher id
    public function findByTeacherID($id)
    {
        $messages = Message::with("offer", "user")
            ->WhereHas("offer", function ($query) use ($id){
                $query->where("user_id", $id);
            })->get();

        return $messages != null ? response()->json($messages, 200) : response()->json(null, 200);
    }

    // DELETE Message by Message id
    public function delete(string $id): JsonResponse
    {
        $message = Message::where("id", $id)->first();

        if ($message != null) {
            $message->delete();
        } else {
            throw new Exception("Message could not be deleted - does not exist.");
        }

        return response()->json("Message (" . $id . ") was deleted.", 200);
    }

    // CREATE new Message
    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $message = Message::create($request->all());

            DB::commit();
            return response()->json($message, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving Message failed: " . $e->getMessage(), 420);
        }
    }

    // UPDATE existing Message
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $message = Message::all()->where('id', $id)->first();

            if ($message != null) {
                $message->update($request->all());
                $message->save();
            }

            DB::commit();
            $updated_message = Message::all()->where('id', $id)->first();
            return response()->json($updated_message, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating message failed: " . $e->getMessage(), 420);
        }
    }
}
