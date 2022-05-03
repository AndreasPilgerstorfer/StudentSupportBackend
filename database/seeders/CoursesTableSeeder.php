<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Image;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loremDescription = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        $this->createCourse("JavaScript", $loremDescription, 1, "LVA111");

        $this->createCourse("Maths", $loremDescription, 2, "LVA222");

        $this->createCourse("English", $loremDescription, 3, "LVA333");

        $this->createCourse("German", $loremDescription, 4, "LVA444");
    }

    //Creates and saves Course
    private function createCourse(string $title, string $description, string $image_id, string $number): void
    {
        $course = new Course();
        $course->title = $title;
        $course->description = $description;
        $course->number = $number;
        $course->image_id = $image_id;

        $image = Image::all()->find($image_id);
        $course->image()->associate($image);

        $course->save();
    }
}
