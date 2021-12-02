<?php

namespace App\Entities;

class AVLData implements \JsonSerializable
{
    private $timestamp;
    private $priority;
    private $gpsData;
    private $IOData;

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getGpsData()
    {
        return $this->gpsData;
    }

    /**
     * @param mixed $gpsData
     */
    public function setGpsData($gpsData)
    {
        $this->gpsData = $gpsData;
    }

    /**
     * @return mixed
     */
    public function getIOData()
    {
        return $this->IOData;
    }

    /**
     * @param mixed $IOData
     */
    public function setIOData($IOData)
    {
        $this->IOData = $IOData;
    }

    public function jsonSerialize()
    {
        return
            [
                'timestamp' => $this->getTimestamp(),
                'priority' => $this->getPriority(),
                'gpsdata' => $this->getGpsData(),
                'iodata' => $this->getIOData(),
            ];

    }
}
