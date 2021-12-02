<?php

namespace App\Services;


use App\Entities\AVLData;
use App\Entities\GPSData;
use App\Entities\IOData;
use Illuminate\Support\Str;

class TeltonikaDecoder
{

    const HEX_DATA_HEADER = 20;

    const CODEC8 = 8;

    const TIMESTAMP_HEX_LENGTH = 16;
    const PRIORITY_HEX_LENGTH = 2;
    const GPSDATA_HEX_LENGTH = 30;

    const LONGITUDE_HEX_LENGTH = 8;
    const LATITUDE_HEX_LENGTH = 8;
    const ALTITUDE_HEX_LENGTH = 4;
    const ANGLE_HEX_LENGTH = 4;
    const SATELLITES_HEX_LENGTH = 2;
    const SPEED_HEX_LENGTH = 4;

    const IO_ID_HEX_LENGTH = 2;
    const IO_COUNT_HEX_LENGTH = 2;
    const VALUE_1B_HEX_LENGTH = 2;
    const VALUE_2B_HEX_LENGTH = 4;
    const VALUE_4B_HEX_LENGTH = 8;
    const VALUE_8B_HEX_LENGTH = 16;

    public function __construct(
        private string $dataFromDevice,
        private array $AVLData = []
    )
    {
        //
    }

    public function getNumberOfElements(): int
    {
        $dataCountHex = substr($this->dataFromDevice,18,2);

        return hexdec($dataCountHex);
    }

    public function getCodecType(): int
    {
        $codecTypeHex = substr($this->dataFromDevice,16,2);

        return hexdec($codecTypeHex);
    }

    public function decodeAVLData(string $hexDataOfElement) :AVLData
    {
        $codecType = $this->getCodecType();

        if($codecType == self::CODEC8) {
            return $this->codec8Decode($hexDataOfElement);
        }
    }

    public function getArrayOfAllData(): array
    {
        $AVLArray = [];

        $hexDataWithoutCRC = substr($this->dataFromDevice, 0, -8);

        $dataCount = $this->getNumberOfElements();

        $startPosition = self::HEX_DATA_HEADER;

        for ($i = 0; $i < $dataCount; $i++) {
            $hexAVLData = $this->getHexAVLData(substr($hexDataWithoutCRC, $startPosition));

            $AVLArray[] = $this->decodeAVLData($hexAVLData);

            $startPosition += Str::length($hexAVLData);
        }

        return $AVLArray;
    }

    private function codec8Decode(string $hexDataOfElement) :AVLData {

        $AVLData = new AVLData();

        //We only get first 10 characters to get timestamp up to seconds.
        $timestamp = substr(hexdec(substr($hexDataOfElement, 0, self::TIMESTAMP_HEX_LENGTH)), 0, 10);
        $AVLData->setTimestamp($timestamp);

        $currentPosition = self::TIMESTAMP_HEX_LENGTH;

        $priority = hexdec(substr($hexDataOfElement, $currentPosition, self::PRIORITY_HEX_LENGTH));
        $AVLData->setPriority($priority);
        $currentPosition += self::PRIORITY_HEX_LENGTH;

        $longitude = hexdec(substr($hexDataOfElement, $currentPosition, self::LONGITUDE_HEX_LENGTH));
        $currentPosition += self::LONGITUDE_HEX_LENGTH;
        $latitude = hexdec(substr($hexDataOfElement, $currentPosition, self::LATITUDE_HEX_LENGTH));
        $currentPosition += self::LATITUDE_HEX_LENGTH;
        $altitude = hexdec(substr($hexDataOfElement, $currentPosition, self::ALTITUDE_HEX_LENGTH));
        $currentPosition += self::ALTITUDE_HEX_LENGTH;
        $angle = hexdec(substr($hexDataOfElement, $currentPosition, self::ANGLE_HEX_LENGTH));
        $currentPosition += self::ANGLE_HEX_LENGTH;
        $satellites = hexdec(substr($hexDataOfElement, $currentPosition, self::SATELLITES_HEX_LENGTH));
        $currentPosition += self::SATELLITES_HEX_LENGTH;
        $speed = hexdec(substr($hexDataOfElement, $currentPosition, self::SPEED_HEX_LENGTH));
        $currentPosition += self::SPEED_HEX_LENGTH;

        $GPSData = new GPSData($longitude, $latitude, $altitude, $angle, $satellites, $speed);

        $AVLData->setGpsData($GPSData);

        //

        $IOData = new IOData();

        $AVLData->setIOData($IOData);

        return $AVLData;

    }
}
