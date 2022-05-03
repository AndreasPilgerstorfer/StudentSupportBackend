<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createMessage(1, 1, "Neue Uhrzeit",
            "Hallo, wäre es möglich den Termin um eine halbe Stunde später straten zu lassen ? Wenn jan hätte ich Interesse.");
    }

    //creates and saves a new message
    private function createMessage(int $student_id, int $offer_id, string $title, string $text)
    {
        $message = new Message();
        $message->title = $title;
        $message->text = $text;

        $user = User::all()->find($student_id);
        $message->user()->associate($user);

        $offer = User::all()->find($offer_id);
        $message->offer()->associate($offer);

        $message->save();
    }
}
