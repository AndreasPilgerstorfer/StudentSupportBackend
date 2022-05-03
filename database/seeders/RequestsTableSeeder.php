<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Seeder;

class RequestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRequest(1, 1, "pending");
    }

    //creates and saves a new Request
    private function createRequest(string $offer_id, string $student_id, string $state)
    {
        $request = new Request();
        $request->state = $state;

        $offer = Offer::all()->find($offer_id);
        $request->offer()->associate($offer);

        $user = User::all()->find($student_id);
        $request->user()->associate($user);

        $request->save();
    }
}
