<?php

namespace App\Entities;


class GPSData implements \JsonSerializable
{

    public function __construct(
        private $longitude,
        private $latitude,
        private $altitude,
        private $angle,
        private $satellites,
        private $speed
    )
    {
        //
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param mixed $altitude
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
    }

    /**
     * @return mixed
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * @param mixed $angle
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;
    }

    /**
     * @return mixed
     */
    public function getSatellites()
    {
        return $this->satellites;
    }

    /**
     * @param mixed $satellites
     */
    public function setSatellites($satellites)
    {
        $this->satellites = $satellites;
    }

    /**
     * @return mixed
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @param mixed $speed
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function jsonSerialize()
    {
        return
            [
                'longitude' => $this->getLongitude(),
                'latitude' => $this->getLatitude(),
                'altitude' => $this->getAltitude(),
                'angle' => $this->getAngle(),
                'satellites' => $this->getSatellites(),
                'speed' => $this->getSpeed(),
            ];
    }
}
