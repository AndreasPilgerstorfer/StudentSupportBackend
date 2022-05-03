<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Students:
        $this->createUser("Andreas", "König", "123abc", "+43690 119875411",
            "andi.koenig@gmail.com", 6, "Student", true);

        $this->createUser("Anna", "Djokovic", "123anna", "+43690 229875422",
            "anna.djoker@gmail.com", 7, "Student", true);

        // Teachers:
        $this->createUser("Michael", "Muster", "123abc", "+43690 339875423",
            "michael.muster@gmail.com", 8, "Wirtschaftsinformatik MSc", false);

        $this->createUser("Jürgen", "Maier", "123justus", "+43690 445575412",
            "justus.jahn@gmx.com", 9, "Management MA", false);
    }

    //Creates and saves a new User
    private function createUser(string $firstname, string $lastname, string $password, string $phone_number,
                                string $email, string $image_id, string $education, bool $is_student): void
    {
        $user = new User();
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->password = bcrypt($password);
        $user->phone_number = $phone_number;
        $user->email = $email;

        $image = Image::all()->find($image_id);
        $user->image()->associate($image);

        $user->education = $education;
        $user->is_student = $is_student;
        $user->save();
    }
}
