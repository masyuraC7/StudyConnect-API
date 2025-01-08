<?php

namespace App\Console\Commands;

use App\Models\Material;
use Illuminate\Console\Command;

class PublishScheduledData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $materials = Material::where('scheduled_at', '<=', now())->where('status', 'scheduled')->get();

        foreach ($materials as $material) {
            $material->status = 'published';
            $material->save();
        }

        $assignments = \App\Models\Assignment::where('scheduled_at', '<=', now())->where('status', 'scheduled')->get();

        foreach ($assignments as $assignment) {
            $assignment->status = 'published';
            $assignment->save();
        }

        $this->info('Scheduled data published successfully!');
    }
}
