<?php

namespace App\Services;

use App\Models\SchedulerLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class HexDataService
{
    public function getEndpointData(string $url, string $key, int $offset = 0)
    {
        $response = Http::get($url, [ 'key' => $key, 'offset' => $offset ]);

        SchedulerLog::create([
            'offset' => $offset,
            'url' => $url,
            'status' => $response->successful()
        ]);

        if ($json = $response->json()) {
            foreach ($json['data'] as $data) {
                Storage::append('txt_raw.log', $data);
            }
        }

        return $json['success']
            ? $json['data']
            : [];
    }
}
