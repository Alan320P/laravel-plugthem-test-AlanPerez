<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeactivateInactiveSurveys extends Command
{
    protected $signature = 'survey:deactivate-inactive';
    protected $description = 'Desactivar encuestas sin respuestas últimos 30 días';
    public function handle()
    {
        $limitDate = Carbon::now()->subDays(30);

        $inactiveCount = Survey::where('status', 'active')
            ->whereDoesntHave('questions.answers', function ($query) use ($limitDate) {
                $query->where('created_at', '>=', $limitDate);
            })
            ->update(['status' => 'inactive']);

        Log::info("Encuestas desactivadas automáticamente: {$inactiveCount}");
        $this->info("Encuestas desactivadas: {$inactiveCount}");

        return 0;
    }
}
