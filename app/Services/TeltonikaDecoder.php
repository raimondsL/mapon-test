<?php

namespace App\Services;


use App\Models\AVLData;
use App\Entities\GPSData;
use App\Entities\IOData;

class TeltonikaDecoder
{
    const HEX_DATA_HEADER = 20;
    const CODEC8 = 8;

    const TIMESTAMP_HEX_LENGTH = 16;
    const PRIORITY_HEX_LENGTH = 2;

    const LONGITUDE_HEX_LENGTH = 8;
    const LATITUDE_HEX_LENGTH = 8;
    const ALTITUDE_HEX_LENGTH = 4;
    const ANGLE_HEX_LENGTH = 4;
    const SATELLITES_HEX_LENGTH = 2;
    const SPEED_HEX_LENGTH = 4;

    const IO_ID_HEX_LENGTH = 2;
    const IO_COUNT_HEX_LENGTH = 2;
    const VALUE_N1_HEX_LENGTH = 2;
    const VALUE_N2_HEX_LENGTH = 4;
    const VALUE_N4_HEX_LENGTH = 8;
    const VALUE_N8_HEX_LENGTH = 16;

    private $currentPosition = 0;

    public function __construct(
        private string $dataFromDevice,
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

    public function decodeAndSaveData()
    {
        $AVLArray = [];

        foreach ($this->getArrayOfAllData() as $item) {
            $AVLArray[] = AVLData::create($item->jsonSerialize());
        }

        return $AVLArray;
    }

    public function getArrayOfAllData(): array
    {
        $codecType = $this->getCodecType();
        $AVLArray = [];

        if ($codecType == self::CODEC8) {
            $dataCount = $this->getNumberOfElements();
            $this->currentPosition = self::HEX_DATA_HEADER;

            for ($i = 0; $i < $dataCount; $i++) {
                $AVLArray[] = $this->codec8Decode($this->dataFromDevice);
            }
        }

        return $AVLArray;
    }

    private function codec8Decode(string $hexDataOfElement) :AVLData {

        $AVLData = new AVLData();

        $timestamp = substr(hexdec(substr($hexDataOfElement, $this->currentPosition, self::TIMESTAMP_HEX_LENGTH)), 0, 10);
        $AVLData->timestamp = $timestamp;
        $this->currentPosition += self::TIMESTAMP_HEX_LENGTH;

        $priority = hexdec(substr($hexDataOfElement, $this->currentPosition, self::PRIORITY_HEX_LENGTH));
        $AVLData->priority = $priority;
        $this->currentPosition += self::PRIORITY_HEX_LENGTH;

        $longitudeValueOnArrayTwoComplement = unpack("l", pack("l", hexdec(substr($hexDataOfElement, $this->currentPosition, self::LONGITUDE_HEX_LENGTH))));
        $longitude = (float) (reset($longitudeValueOnArrayTwoComplement) / 10000000);
        $this->currentPosition += self::LONGITUDE_HEX_LENGTH;
        $latitudeValueOnArrayTwoComplement = unpack("l", pack("l", hexdec(substr($hexDataOfElement, $this->currentPosition, self::LATITUDE_HEX_LENGTH))));
        $latitude = (float) (reset($latitudeValueOnArrayTwoComplement) / 10000000);
        $this->currentPosition += self::LATITUDE_HEX_LENGTH;

        $altitude = hexdec(substr($hexDataOfElement, $this->currentPosition, self::ALTITUDE_HEX_LENGTH));
        $this->currentPosition += self::ALTITUDE_HEX_LENGTH;

        $angle = hexdec(substr($hexDataOfElement, $this->currentPosition, self::ANGLE_HEX_LENGTH));
        $this->currentPosition += self::ANGLE_HEX_LENGTH;

        $satellites = hexdec(substr($hexDataOfElement, $this->currentPosition, self::SATELLITES_HEX_LENGTH));
        $this->currentPosition += self::SATELLITES_HEX_LENGTH;

        $speed = hexdec(substr($hexDataOfElement, $this->currentPosition, self::SPEED_HEX_LENGTH));
        $this->currentPosition += self::SPEED_HEX_LENGTH;

        $GPSData = new GPSData($longitude, $latitude, $altitude, $angle, $satellites, $speed);
        $AVLData->gps_data = $GPSData;

        $this->currentPosition += self::IO_ID_HEX_LENGTH;
        $nCount = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_COUNT_HEX_LENGTH));
        $this->currentPosition += self::IO_COUNT_HEX_LENGTH;
        $array = [];

        $n1Count = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_COUNT_HEX_LENGTH));
        $this->currentPosition += self::IO_COUNT_HEX_LENGTH;

        for ($i = 0; $i < $n1Count; $i++) {
            $id = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_ID_HEX_LENGTH));
            $this->currentPosition += self::IO_ID_HEX_LENGTH;
            $value = hexdec(substr($hexDataOfElement, $this->currentPosition, self::VALUE_N1_HEX_LENGTH));
            $this->currentPosition += self::VALUE_N1_HEX_LENGTH;
            $array[] = [
                'IO{'.$id.'}' => $value
            ];
        }

        $n2Count = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_COUNT_HEX_LENGTH));
        $this->currentPosition += self::IO_COUNT_HEX_LENGTH;

        for ($i = 0; $i < $n2Count; $i++) {
            $id = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_ID_HEX_LENGTH));
            $this->currentPosition += self::IO_ID_HEX_LENGTH;
            $value = hexdec(substr($hexDataOfElement, $this->currentPosition, self::VALUE_N2_HEX_LENGTH));
            $this->currentPosition += self::VALUE_N2_HEX_LENGTH;
            $array[] = [
                'IO{'.$id.'}' => $value
            ];
        }

        $n4Count = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_COUNT_HEX_LENGTH));
        $this->currentPosition += self::IO_COUNT_HEX_LENGTH;

        for ($i = 0; $i < $n4Count; $i++) {
            $id = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_ID_HEX_LENGTH));
            $this->currentPosition += self::IO_ID_HEX_LENGTH;
            $value = hexdec(substr($hexDataOfElement, $this->currentPosition, self::VALUE_N4_HEX_LENGTH));
            $this->currentPosition += self::VALUE_N4_HEX_LENGTH;
            $array[] = [
                'IO{'.$id.'}' => $value
            ];
        }

        $n8Count = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_COUNT_HEX_LENGTH));
        $this->currentPosition += self::IO_COUNT_HEX_LENGTH;

        for ($i = 0; $i < $n8Count; $i++) {
            $id = hexdec(substr($hexDataOfElement, $this->currentPosition, self::IO_ID_HEX_LENGTH));
            $this->currentPosition += self::IO_ID_HEX_LENGTH;
            $value = hexdec(substr($hexDataOfElement, $this->currentPosition, self::VALUE_N8_HEX_LENGTH));
            $this->currentPosition += self::VALUE_N8_HEX_LENGTH;
            $array[] = [
                'IO{'.$id.'}' => $value
            ];
        }

        if ($nCount != $n1Count + $n2Count + $n4Count + $n8Count) {
            // Warning!
        }

        $IOData = new IOData($array);
        $AVLData->io_data = $IOData;

        return $AVLData;
    }
}
