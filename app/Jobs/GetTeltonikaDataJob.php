<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetTeltonikaDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hexDataService = new \App\Services\HexDataService();

        $lastOffset = \App\Models\SchedulerLog::lastOffset();

        $hexDataService->getEndpointData('https://mapon.com/integration/', '6BD030BBB9E0E34C63672757DC065B8B', $lastOffset >= 99 ? 0 : $lastOffset + 1);
    }
}
