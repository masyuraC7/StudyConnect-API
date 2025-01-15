<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\Material;
use Illuminate\Console\Command;

class PublishScheduledData extends Command
{
    protected $signature = 'app:publish-scheduled-data';
    protected $description = 'Publish scheduled data';

    public function handle()
    {
        // Publish scheduled materials
        Material::where('scheduled_at', '<=', now())
            ->where('status', 'scheduled')
            ->update(['status' => 'published']);

        // Publish scheduled assignments
        Assignment::where('scheduled_at', '<=', now())
            ->where('status', 'scheduled')
            ->update(['status' => 'published']);
        
        // Publish scheduled announcement
        Announcement::where('scheduled_at', '<=', now())
            ->where('status', 'scheduled')
            ->update(['status' => 'published']);

        $this->info('Scheduled data published successfully!');
    }
}