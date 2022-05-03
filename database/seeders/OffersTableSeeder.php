<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Image;
use App\Models\Offer;
use DateTime;
use Illuminate\Database\Seeder;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loremIpsum = "Lorem Ipsum dolor sit amet. Lorem ipsum lorem ispsum lorem ipsum dolor sit amet lorem";

        $this->createOffer("12:00", "13:00", new DateTime("2022-4-5"),
            5, "JavaScript Classes", $loremIpsum, "Offen", 3, 1, "none");
    }

    //create and save new offer
    private function createOffer(string $start_time, string $end_time, DateTime $date,
                                 string $image_id, string $title, string $description,
                                 string $state, int $teacher_id, int $course_id, string $associatedStudent)
    {
        $offer = new Offer();
        $offer->start_time = $start_time;
        $offer->end_time = $end_time;
        $offer->date = $date;

        $image = Image::all()->find($image_id);
        $offer->image()->associate($image);

        $offer->title = $title;
        $offer->description = $description;
        $offer->state = $state;
        $offer->associatedStudent = $associatedStudent;

        $course = Course::all()->find($course_id);
        $offer->course()->associate($course);

        $user = Course::all()->find($teacher_id);
        $offer->user()->associate($user);

        $offer->save();
    }
}
