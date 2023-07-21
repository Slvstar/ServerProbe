<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\GraphicsProcessingUnit;

class GraphicsProcessingUnit
{
    private string $Name;
    private string $AdapterCompatibility;
    private string $AdapterDACType;
    private string $AdapterRAM;
    private string $DriverDate;
    private string $DriverVersion;

    public function __construct(array $graphicsProcessingUnitCardInformation)
    {
        foreach ($graphicsProcessingUnitCardInformation as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getName(): ?string
    {
        return $this->Name ?? null;
    }

    public function getAdapterCompatibility(): ?string
    {
        return $this->AdapterCompatibility ?? null;
    }

    public function getAdapterDACType(): ?string
    {
        return $this->AdapterDACType ?? null;
    }

    public function getAdapterRam(): ?string
    {
        return round($this->AdapterRAM / 1073741824, 2) . ' GB' ?? null;
    }

    public function getDriverDate(): ?string
    {
        return \DateTime::createFromFormat('YmdHis.uP', $this->DriverDate)->format('Y-d-m') ?? null;
    }

    public function getDriverVersion(): ?string
    {
        return $this->DriverVersion ?? null;
    }
}