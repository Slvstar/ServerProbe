<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\GraphicsProcessingUnit;

class GraphicsProcessingUnits
{
    private array $graphicsProcessingUnits;

    public function __construct(GraphicsProcessingUnit ...$graphicsProcessingUnit)
    {
        $this->graphicsProcessingUnits = $graphicsProcessingUnit;
    }

    public function getGraphicsProcessingUnits(): array
    {
        return $this->graphicsProcessingUnits;
    }
}