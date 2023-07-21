<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\RandomAccessMemory;

class RandomAccessMemoryUnits
{
    private array $randomAccessMemoryUnits;

    public function __construct(RandomAccessMemoryUnit ...$randomAccessMemoryUnits)
    {
        $this->randomAccessMemoryUnits = $randomAccessMemoryUnits;
    }

    public function getRandomAccessMemoryCardsInformation(): array
    {
        return $this->randomAccessMemoryUnits;
    }
}