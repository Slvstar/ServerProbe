<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\CentralProcessingUnit;

class CentralProcessingUnit
{
    private string $AddressWidth;
    private string $Name;
    private string $L3CacheSize;
    private string $CurrentClockSpeed;
    private string $MaxClockSpeed;
    private string $CurrentVoltage;
    private string $ThreadCount;
    private string $NumberOfCores;
    private string $NumberOfEnabledCore;
    private string $NumberOfLogicalProcessors;

    public function __construct(array $centralProcessingUnitInformation)
    {
        foreach ($centralProcessingUnitInformation as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getAddressWidth()
    {
        return $this->AddressWidth;
    }
    public function getName()
    {
        return $this->Name;
    }
    public function getL3CacheSize()
    {
        return $this->L3CacheSize;
    }
    public function getCurrentClockSpeed()
    {
        return $this->CurrentClockSpeed;
    }
    public function getMaxClockSpeed()
    {
        return $this->MaxClockSpeed;
    }
    public function getCurrentVoltage()
    {
        return $this->CurrentVoltage;
    }
    public function getThreadCount()
    {
        return $this->ThreadCount;
    }
    public function getNumberOfCores()
    {
        return $this->NumberOfCores;
    }
    public function getNumberOfEnabledCore()
    {
        return $this->NumberOfEnabledCore;
    }
}