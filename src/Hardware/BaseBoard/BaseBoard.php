<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\BaseBoard;

class BaseBoard
{
    private ?string $Manufacturer = null;
    private ?string $Product = null;
    private ?string $SMBIOSBIOSVersion = null;

    public function __construct(array $basboardInformation)
    {
        foreach ($basboardInformation as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getManufacturer(): ?string
    {
        return $this->Manufacturer ?? null;
    }

    public function getProduct(): ?string
    {
        return $this->Product ?? null;
    }
    
    public function getSMBIOSBIOSVersion(): ?string
    {
        return $this->SMBIOSBIOSVersion ?? null;
    }
}