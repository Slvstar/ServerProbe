<?php declare(strict_types=1);
namespace Temant\ServerProbe {
    use Temant\ServerProbe\Hardware\BaseBoard\BaseBoard,
    Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnit,
    Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnitCore,
    Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnitCores,
    Temant\ServerProbe\Hardware\GraphicsProcessingUnit\GraphicsProcessingUnit,
    Temant\ServerProbe\Hardware\GraphicsProcessingUnit\GraphicsProcessingUnits,
    Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUnit,
    Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUsage,
    Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUnits;
    use Temant\ServerProbe\Platform\PlatformInterface;

    class ServerProbe
    {
        public function __construct(
            private PlatformInterface $platform
            )
        {
        }

        public function getRandomAccessMemoryUsage(): RandomAccessMemoryUsage
        {
            return $this->platform->getRandomAccessMemoryUsage();
        }

        public function getGraphicsProcessingUnitCard(): GraphicsProcessingUnits
        {
            return $this->platform->getGraphicsProcessingUnitCard();
        }

        public function getRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits
        {
            return $this->platform->getRandomAccessMemoryCardsCollection();
        }

        public function getBaseBoard(): BaseBoard
        {
            return $this->platform->getBaseBoard();
        }

        public function getCentralProcessingUnit(): CentralProcessingUnit
        {
            return $this->platform->getCentralProcessingUnit();
        }

        public function getCentralProcessingUnitCores(): CentralProcessingUnitCores
        {
            return $this->platform->getCentralProcessingUnitCores();
        }
    }
}