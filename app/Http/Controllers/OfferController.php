<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Offer;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    // GET all offers
    public function index()
    {
        return Offer::with("image", "course", "user")->get();
    }

    // Get offers by course id
    public function findByCourseID($id)
    {
        $offers = Offer::where("course_id", $id)->with("image", "course", "user")->get();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }

    // Get offers by offer id
    public function findByOfferID($id)
    {
        $offers = Offer::where("id", $id)->with("image", "course", "user")->first();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }


    //GET all open Offers by CourseID
    public function findByCourseIDOpen($id): JsonResponse
    {
        $offers = Offer::where("course_id", $id)->where("state", "Offen")->with("image", "course", "user")->get();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }

    // Get offers by user id Teacher
    public function findByUserIDTeacher($id): JsonResponse
    {
        $offers = Offer::where("user_id", $id)->with("image", "course", "user")->get();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }

    // Get offers by user id Teacher
    public function findByUserIDStudent($id): JsonResponse
    {
        $offers = Offer::where("associatedStudent", $id)->with("image", "course", "user")->get();
        return $offers != null ? response()->json($offers, 200) : response()->json(null, 200);
    }


    // CREATE new offer
    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Offer an sich anlegen
            $offer = Offer::create($request->all());

            //create image
            if (isset($request['image'])) {
                $requestImage = $request['image'];
                $image = Image::firstOrNew(['url' => $requestImage['url'], 'title' => $requestImage['title']]);
                $image->save();
                $offer->image()->associate($image);
            }

            $offer->save();
            DB::commit();
            return response()->json($offer, 200);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Saving offer failed: " . $e->getMessage(), 420);
        }
    }

    // DELETE offer by id
    public function delete(string $id): JsonResponse
    {
        $offer = Offer::where("id", $id)->first();

        if ($offer != null) {
            $offer->delete();
        } else {
            throw new Exception("Offer could not be deleted - does not exist.");
        }

        return response()->json("Offer (" . $id . ") was deleted.", 200);
    }

    // UPDATE existing offer
    public function update(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();

        try {
            //get offer
            $offer = Offer::all()->where('id', $id)->first();

            if ($offer != null) {
                $offer->update($request->all());

                if (isset($request['image']) &&
                    (($request['image']['url'] != $offer->url) ||
                        ($request['image']['title'] != $offer->title))
                ) {
                    $requestImage = $request['image'];
                    $image = Image::firstOrNew(['url' => $requestImage['url'], 'title' => $requestImage['title']]);
                    $image->save();

                    $offer->update([
                        'image_id' => $image->id
                    ]);
                }

                $offer->save();
            }

            DB::commit();
            $updated_offer = Offer::with(['image'])->where('id', $id)->first();

            return response()->json($updated_offer, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json("Updating Offer failed: " . $e->getMessage(), 420);
        }
    }
}
