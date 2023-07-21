<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\RandomAccessMemory;

class RandomAccessMemoryUnit
{
    private string $PartNumber;
    private string $Manufacturer;
    private string $SMBIOSMemoryType;
    private string $Speed;
    private string $Capacity;
    private string $ConfiguredVoltage;
    private string $DeviceLocator;
    private string $SerialNumber;

    public function __construct(array $randomAccessMemoryUnit)
    {
        foreach ($randomAccessMemoryUnit as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getManufacturer(): ?string
    {
        return $this->Manufacturer ?? null;
    }

    public function getPartNumber(): ?string
    {
        return $this->PartNumber ?? null;
    }

    public function getCapacity(): ?string
    {
        return number_format($this->Capacity / pow(1024, 3), 2) . ' GB' ?? null;
    }

    public function getSMBIOSMemoryType(): ?string
    {
        return MemoryTypeEnum::getByValue(intval($this->SMBIOSMemoryType)) ?? null;
    }

    public function getSpeed(): ?string
    {
        return $this->Speed . ' MHz' ?? null;
    }

    public function getConfiguredVoltage(): ?string
    {
        return number_format($this->ConfiguredVoltage / 1000, 2) . ' V' ?? null;
    }

    public function getDeviceLocator(): ?string
    {
        return $this->DeviceLocator ?? null;
    }

    public function getSerialNumber(): ?string
    {
        return $this->SerialNumber ?? null;
    }
}