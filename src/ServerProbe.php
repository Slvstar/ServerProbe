<?php declare(strict_types=1);
namespace Temant\ServerProbe;

use Temant\ServerProbe\Hardware\BaseBoard\BaseBoard;
use Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnit;
use Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnitCore;
use Temant\ServerProbe\Hardware\CentralProcessingUnit\CentralProcessingUnitCores;
use Temant\ServerProbe\Hardware\GraphicsProcessingUnit\GraphicsProcessingUnit;
use Temant\ServerProbe\Hardware\GraphicsProcessingUnit\GraphicsProcessingUnits;
use Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUnit;
use Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUsage;
use Temant\ServerProbe\Hardware\RandomAccessMemory\RandomAccessMemoryUnits;

class ServerProbe
{
    private RandomAccessMemoryUsage $randomAccessMemoryUsage;

    private BaseBoard $baseBoard;

    private RandomAccessMemoryUnits $randomAccessMemoryCardsCollection;

    private GraphicsProcessingUnits $graphicsProcessingUnitCards;

    private CentralProcessingUnit $centralProcessingUnit;
    private CentralProcessingUnitCores $centralProcessingUnitCores;

    public function __construct()
    {
        $this->randomAccessMemoryUsage = $this->setRandomAccessMemoryUsage();
        $this->graphicsProcessingUnitCards = $this->setGraphicsProcessingUnitCard();
        $this->randomAccessMemoryCardsCollection = $this->setRandomAccessMemoryCardsCollection();
        $this->baseBoard = $this->setBaseBoard();
        $this->centralProcessingUnit = $this->setCentralProcessingUnit();
        $this->centralProcessingUnitCores = $this->setCentralProcessingUnitCores();
    }

    public static function execute(string $class, array $params, string $format = 'list'): array
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


    private function setRandomAccessMemoryUsage(): RandomAccessMemoryUsage
    {
        return new RandomAccessMemoryUsage(self::execute('Win32_OperatingSystem', ['TotalVisibleMemorySize', 'FreePhysicalMemory'])[0]);
    }

    public function getRandomAccessMemoryUsage(): RandomAccessMemoryUsage
    {
        return $this->randomAccessMemoryUsage;
    }

    private function setGraphicsProcessingUnitCard(): GraphicsProcessingUnits
    {
        foreach (self::execute('Win32_VideoController', ['Name', 'AdapterCompatibility', 'AdapterDACType', 'AdapterRAM', 'DriverDate', 'DriverVersion']) as $gpu) {
            $gpus[] = new GraphicsProcessingUnit($gpu);
        }

        return new GraphicsProcessingUnits(...$gpus);
    }

    public function getGraphicsProcessingUnitCard(): GraphicsProcessingUnits
    {
        return $this->graphicsProcessingUnitCards;
    }

    private function setRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits
    {
        foreach (self::execute('Win32_PhysicalMemory', ['PartNumber', 'Manufacturer', 'SMBIOSMemoryType', 'Speed', 'Capacity', 'ConfiguredVoltage', 'DeviceLocator', 'SerialNumber']) as $ram) {
            $rams[] = new RandomAccessMemoryUnit($ram);
        }
        return new RandomAccessMemoryUnits(...$rams);
    }

    public function getRandomAccessMemoryCardsCollection(): RandomAccessMemoryUnits
    {
        return $this->randomAccessMemoryCardsCollection;
    }

    private function setBaseBoard(): BaseBoard
    {
        return new BaseBoard(
            array_merge(
                self::execute('Win32_BaseBoard', ['Product', 'Manufacturer'])[0],
                self::execute('Win32_BIOS', ['SMBIOSBIOSVersion'])[0],
            )
        );
    }

    public function getBaseBoard(): BaseBoard
    {
        return $this->baseBoard;
    }

    private function setCentralProcessingUnit(): CentralProcessingUnit
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
    
    public function getCentralProcessingUnit(): CentralProcessingUnit
    {
        return $this->centralProcessingUnit;
    }

    private function setCentralProcessingUnitCores(): CentralProcessingUnitCores
    {
        foreach (self::execute('Win32_PerfFormattedData_PerfOS_Processor', ['Name', 'PercentProcessorTime']) as $core) {

            $cores[] = new CentralProcessingUnitCore($core);

        }
        return new CentralProcessingUnitCores(...$cores);
    }

    public function getCentralProcessingUnitCores(): CentralProcessingUnitCores
    {
        return $this->centralProcessingUnitCores;
    }
}