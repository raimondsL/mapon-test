<?php

namespace App\Http\Livewire;

use App\Models\AVLData;
use App\Services\TeltonikaDecoder;
use Livewire\Component;

class ShowData extends Component
{
    public $decodedData;
    public $rawData;

    public function mount()
    {
        $this->decodedData = AVLData::all();
        $this->rawData = file(storage_path('app\txt_raw.log', FILE_IGNORE_NEW_LINES));
    }

    public function render()
    {
        return view('livewire.show-data', [
            'rawData' => $this->rawData,
            'decodedData' => $this->decodedData
        ]);
    }

    public function decode($index)
    {
        $decoder = new TeltonikaDecoder($this->rawData[$index]);

        foreach ($decoder->getArrayOfAllData() as $data) {
            $this->decodedData->push($data);
        }
    }


    public function decodeAndSave($index)
    {
        $decoder = new TeltonikaDecoder($this->rawData[$index]);

        foreach ($decoder->decodeAndSaveData() as $data) {
            $this->decodedData->push($data);
        }
    }
}
