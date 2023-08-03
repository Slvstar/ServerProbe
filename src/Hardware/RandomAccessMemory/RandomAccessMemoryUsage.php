<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\RandomAccessMemory;

use Temant\ServerProbe\ServerProbe;

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

    public function getTotalVisibleMemorySize(bool $formatted = false): mixed
    {
        if ($formatted) {
            return number_format($this->TotalVisibleMemorySize * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
        }
        return $this->TotalVisibleMemorySize;
    }

    public function getFreePhysicalMemory(bool $formatted = false): mixed
    {
        if ($formatted) {
            return number_format($this->FreePhysicalMemory * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
        }
        return $this->FreePhysicalMemory;
    }

    public function getUsedPhysicalMemory(bool $formatted = false): mixed
    {
        if ($formatted) {
            return number_format($this->UsedPhysicalMemory * 1024 / pow(1024, 3), 2) . ' GB' ?? null;
        }
        return $this->UsedPhysicalMemory;
    }

    public function getMemoryUsagePercent()
    {
        return round($this->UsedPhysicalMemory * 100 / $this->TotalVisibleMemorySize);
    }

    public function listProcesses(): array
    {
        exec('tasklist /fo csv /nh', $output, $returnCode);

        foreach ($output as $line) {
            $processInfo = str_getcsv($line);
            $processName = $processInfo[0];
            $pid = $processInfo[1];
            $memoryUsage = (int) preg_replace('/[^0-9]/', '', $processInfo[4]);

            if (isset($processes[$processName])) {
                $processes[$processName]['memoryUsage'] += $memoryUsage;
            } else {
                $processes[$processName] = [
                    'processName' => $processName,
                    'pid' => $pid,
                    'memoryUsage' => $memoryUsage
                ];
            }
        }

        usort($processes, function ($a, $b) {
            return $b['memoryUsage'] - $a['memoryUsage'];
        });
        return $processes;
    }
}