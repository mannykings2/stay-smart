<?php

namespace Database\Seeders;

use App\Models\ChefService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChefServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Private Dining',
            'Meal Prep',
            'Event Catering',
            'Cooking Class',
            'In-Home Dinner Party Chef',
            'Weekly Family Meals',
            'Vegan / Vegetarian Cuisine',
            'Specialty Cuisine (e.g. Italian, Thai)',
            'Dessert & Pastry Creation',
            'BBQ / Grill Chef',
            'Romantic Dinner Setup',
            'Child-Friendly Meal Plans',
            'Dietary-Specific Services',
            'Breakfast / Brunch Services',
            'Corporate Meal Service',
        ];

        foreach ($services as $service) {
            ChefService::updateOrCreate(['name' => $service]);
        }
    }
}
