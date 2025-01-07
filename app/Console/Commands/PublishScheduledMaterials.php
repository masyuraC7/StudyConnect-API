<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Material;

class PublishScheduledMaterials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'materials:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled materials';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $materials = Material::where('scheduled_at', '<=', now())->where('status', 'scheduled')->get();

        foreach ($materials as $material) {
            $material->status = 'published';
            $material->save();
        }

        $this->info('Scheduled materials published successfully!');
    }
}
