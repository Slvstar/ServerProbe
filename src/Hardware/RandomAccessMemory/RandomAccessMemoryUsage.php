<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\RandomAccessMemory;

class RandomAccessMemoryUsage
{
    private ?int $TotalVisibleMemorySize = null;
    private ?int $FreePhysicalMemory = null;
    private ?int $UsedPhysicalMemory = null;

    public function __construct(array $ramUsageInformation)
    {
        foreach ($ramUsageInformation as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = intval($value);
            }
        }

        $this->UsedPhysicalMemory = $this->TotalVisibleMemorySize - $this->FreePhysicalMemory;
    }

    public function getTotalVisibleMemorySize(): ?string
    {
        return number_format($this->TotalVisibleMemorySize * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
    }

    public function getFreePhysicalMemory(): ?string
    {
        return number_format($this->FreePhysicalMemory * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
    }

    public function getUsedPhysicalMemory(): ?string
    {
        return number_format($this->UsedPhysicalMemory * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
    }
}