<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\CentralProcessingUnit;

class CentralProcessingUnitCores
{
    private array $coresInformation;

    public function __construct(CentralProcessingUnitCore ...$coresInformation)
    {
        // Convert the array of cores into an associative array with core names as keys.
        $this->coresInformation = [];
        foreach ($coresInformation as $core) {
            if (is_numeric($core->getName())) {
                $this->coresInformation[$core->getName()] = $core;
            }
        }

        $this->sortCoresByName();
    }

    public function getCoresInformation(): array
    {
        return $this->coresInformation;
    }

    private function sortCoresByName()
    {
        uksort($this->coresInformation, function ($a, $b) {
            if ($a === '_Total') {
                return 1; // Place _Total at the end.
            } elseif ($b === '_Total') {
                return -1; // Place _Total at the end.
            }

            if (is_numeric($a) && is_numeric($b)) {
                return (int) $a <=> (int) $b;
            }

            return strcmp($a, $b);
        });
    }
}