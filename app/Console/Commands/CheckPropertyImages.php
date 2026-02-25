<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckPropertyImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:property-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify database image paths against physical storage and public visibility';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $property = Property::latest()->first();

        if (!$property) {
            $this->error("No properties found in the database.");
            return Command::FAILURE;
        }

        $this->info("Checking Property: " . $property->name);
        $this->line("Database Path: " . $property->image_path);
        $this->newLine();

        // 1. Check in storage/app/public
        if (Storage::disk('public')->exists($property->image_path)) {
            $this->info("✓ File exists in storage/app/public");
        } else {
            $this->error("✗ File NOT found in storage/app/public");
        }

        // 2. Check in public/storage
        $publicPath = public_path('storage/' . $property->image_path);

        if (file_exists($publicPath)) {
            $this->info("✓ File exists in public/storage (Symbolic link is working)");
        } else {
            $this->warn("✗ File NOT found in public/storage");
            $this->line("Tip: Run 'php artisan storage:link' to create the symbolic link.");
        }

        $this->newLine();
        $this->line("Complete.");

        return Command::SUCCESS;
    }
}
