<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\CentralProcessingUnit;

class CentralProcessingUnitCore
{
    private string $Name;

    private string $PercentProcessorTime;

    public function __construct(array $centralProcessingUnitInformation)
    {
        foreach ($centralProcessingUnitInformation as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

    }
    
    public function getName(): string
    {
        return $this->Name;
    }
}