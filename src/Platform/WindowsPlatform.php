<?php
namespace Temant\ServerProbe\Platform {
    use Temant\ServerProbe\Hardware\{
        BaseBoard\BaseBoard,
        CentralProcessingUnit\CentralProcessingUnit,
        CentralProcessingUnit\CentralProcessingUnitCores,
        GraphicsProcessingUnit\GraphicsProcessingUnits,
        RandomAccessMemory\RandomAccessMemoryUnits,
        RandomAccessMemory\RandomAccessMemoryUsage,
        CentralProcessingUnit\CentralProcessingUnitCore,
        RandomAccessMemory\RandomAccessMemoryUnit,
        GraphicsProcessingUnit\GraphicsProcessingUnit
    };

    class WindowsPlatform implements PlatformInterface
    {
        private static function execute(string $class, array $params, string $format = 'list'): array
        {
            $paramsCount = count($params);

            exec(sprintf("wmic path %s get %s /format:%s", $class, implode(', ', $params), $format), $output);

            $output = array_filter($output, function ($line) {
                return trim($line) !== '';
            }, FILTER_FLAG_STRIP_LOW);

            $return = [];
            foreach ($output as $line) {
                [$key, $value] = array_map('trim', explode('=', $line));
                $return[][$key] = $value;
            }

            if ($paramsCount > 0) {
                $return = array_chunk($return, $paramsCount);
            }

            return self::flattenArray($return);
        }

        private static function flattenArray(array $array): array
        {
            foreach ($array as $subArray) {
                $result[] = array_merge(...$subArray);
            }
            return $result;
        }


        public function getRandomAccessMemoryUsage(): RandomAccessMemoryUsage
        {
            return new RandomAccessMemoryUsage(
                self::execute('Win32_OperatingSystem', ['TotalVisibleMemorySize', 'FreePhysicalMemory'])[0]
            );
        }

        public function getGraphicsProcessingUnitCard(): GraphicsProcessingUnits
        {
            foreach (self::execute('Win32_VideoController', ['Name', 'AdapterCompatibility', 'AdapterDACType', 'AdapterRAM', 'DriverDate', 'DriverVersion']) as $gpu) {
                $gpus[] = new GraphicsProcessingUnit($gpu);
            }

            return new GraphicsProcessingUnits(...$gpus);
        }

        public function getRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits
        {
            foreach (self::execute('Win32_PhysicalMemory', ['PartNumber', 'Manufacturer', 'SMBIOSMemoryType', 'Speed', 'Capacity', 'ConfiguredVoltage', 'DeviceLocator', 'SerialNumber']) as $ram) {
                $rams[] = new RandomAccessMemoryUnit($ram);
            }
            return new RandomAccessMemoryUnits(...$rams);
        }

        public function getBaseBoard(): BaseBoard
        {
            return new BaseBoard(
                array_merge(
                    self::execute('Win32_BaseBoard', ['Product', 'Manufacturer'])[0],
                    self::execute('Win32_BIOS', ['SMBIOSBIOSVersion'])[0],
                )
            );
        }

        public function getCentralProcessingUnit(): CentralProcessingUnit
        {
            return new CentralProcessingUnit(
                self::execute('Win32_Processor', [
                    'Name',
                    'AddressWidth',
                    'L3CacheSize',
                    'CurrentClockSpeed',
                    'MaxClockSpeed',
                    'CurrentVoltage',
                    'ThreadCount',
                    'NumberOfCores',
                    'NumberOfEnabledCore',
                    'NumberOfLogicalProcessors'])[0]
            );
        }

        public function getCentralProcessingUnitCores(): CentralProcessingUnitCores
        {
            foreach (self::execute('Win32_PerfFormattedData_PerfOS_Processor', ['Name', 'PercentProcessorTime']) as $core) {

                $cores[] = new CentralProcessingUnitCore($core);

            }
            return new CentralProcessingUnitCores(...$cores);
        }
    }
}