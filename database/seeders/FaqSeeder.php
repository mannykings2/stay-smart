<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question' => 'How do I check into my apartment?',
                'answer' => 'Digital check-in is available through your dashboard 24 hours before arrival. Once completed, you will receive your access codes via email and SMS.',
                'order' => 1
            ],
            [
                'question' => 'Is WiFi included in the stay?',
                'answer' => 'Yes, high-speed WiFi is provided in all Stay Smart apartments. Login details are located in the welcome booklet inside your apartment.',
                'order' => 2
            ],
            [
                'question' => 'Can I request a late check-out?',
                'answer' => 'Late check-outs are subject to availability and may incur an additional fee. Please contact support at least 12 hours in advance to request one.',
                'order' => 3
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
