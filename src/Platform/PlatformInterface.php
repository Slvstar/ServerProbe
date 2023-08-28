<?php
namespace Temant\ServerProbe\Platform {
    use Temant\ServerProbe\Hardware\{
        BaseBoard\BaseBoard,
        CentralProcessingUnit\CentralProcessingUnit,
        CentralProcessingUnit\CentralProcessingUnitCores,
        GraphicsProcessingUnit\GraphicsProcessingUnits,
        RandomAccessMemory\RandomAccessMemoryUnits,
        RandomAccessMemory\RandomAccessMemoryUsage
    };

    interface PlatformInterface
    {
        public function getRandomAccessMemoryUsage(): RandomAccessMemoryUsage;

        public function getGraphicsProcessingUnitCard(): GraphicsProcessingUnits;

        public function getRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits;

        public function getBaseBoard(): BaseBoard;

        public function getCentralProcessingUnit(): CentralProcessingUnit;

        public function getCentralProcessingUnitCores(): CentralProcessingUnitCores;
    }
}