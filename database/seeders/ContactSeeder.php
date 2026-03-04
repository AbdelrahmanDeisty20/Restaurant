<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Ahmed Ali',
                'email' => 'ahmed.ali@example.com',
                'phone' => '01098765432',
                'subject' => 'Inquiry about family catering',
                'message' => 'I would like to inquire about catering services for a 50-person family gathering. Do you offer special menus for this?',
            ],
            [
                'name' => 'Mona Hassan',
                'email' => 'mona.hassan@example.com',
                'phone' => '01211223344',
                'subject' => 'Feedback on last order',
                'message' => 'The food was great! Just wanted to suggest adding more spicy options to the Yemeni section.',
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '01512345678',
                'subject' => 'Issue with delivery time',
                'message' => 'My last order took almost 90 minutes. I hope this was just a one-time thing.',
            ],
        ];

        foreach ($messages as $msg) {
            Contact::create($msg);
        }
    }
}
