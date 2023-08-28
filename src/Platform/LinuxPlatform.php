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

    class LinuxPlatform implements PlatformInterface
    {
        private static function execute(string $command)
        {
            exec($command, $output);
            return $output[0];
        }

        public function getRandomAccessMemoryUsage(): RandomAccessMemoryUsage
        {
            return new RandomAccessMemoryUsage(
                [
                    'TotalVisibleMemorySize' => preg_replace('/[^0-9]/', '', self::execute('cat /proc/meminfo | grep MemTotal:')),
                    'FreePhysicalMemory' => preg_replace('/[^0-9]/', '', self::execute('cat /proc/meminfo | grep MemFree:'))
                ]
            );
        }

        public function getGraphicsProcessingUnitCard(): GraphicsProcessingUnits
        {
        }

        public function getRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits
        {
        }

        public function getBaseBoard(): BaseBoard
        {
            return new BaseBoard([
                'Product' => self::execute('cat /sys/devices/virtual/dmi/id/board_name'),
                'Manufacturer' => self::execute('cat /sys/devices/virtual/dmi/id/board_vendor'),
                'SMBIOSBIOSVersion' => self::execute('cat /sys/devices/virtual/dmi/id/board_version')
            ]);
        }

        public function getCentralProcessingUnit(): CentralProcessingUnit
        {
        }

        public function getCentralProcessingUnitCores(): CentralProcessingUnitCores
        {
        }
    }
}