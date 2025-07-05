<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Summary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GenerateDailySummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $projects = Project::all();
        $yesterday = now()->subDay()->startOfDay();

        foreach ($projects as $project) {
            $events = $project->events()
                ->whereBetween('occurred_at', [$yesterday, $yesterday->copy()->endOfDay()])
                ->get();

            $summary = $events->groupBy('type')->map(fn($g) => $g->count());

            Summary::create([
                'project_id' => $project->id,
                'date' => $yesterday->toDateString(),
                'data' => $summary,
            ]);

            // // enviar por correo
            // Mail::to('admin@yourdomain.com')->queue(
            //     new DailySummaryMail($project, $summary)
            // );
        }
    }
}
