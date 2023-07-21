<?php declare(strict_types=1);

namespace Temant\ServerProbe\Hardware\RandomAccessMemory;

enum MemoryTypeEnum: int
{
    case DRAM = 3;
    case EDRAM = 4;
    case VRAM = 5;
    case SRAM = 6;
    case RAM = 7;
    case ROM = 8;
    case FLASH = 9;
    case EEPROM = 10;
    case FEPROM = 11;
    case EPROM = 12;
    case CDRAM = 13;
    case THREE_DRAM = 14;
    case SDRAM = 15;
    case SGRAM = 16;
    case RDRAM = 17;
    case DDR = 18;
    case DDR2 = 19;
    case DDR2_FB_DIMM = 20;
    case DDR3 = 24;
    case FBD2 = 25;
    case DDR4 = 26;
    case LPDDR = 27;
    case LPDDR2 = 28;
    case LPDDR3 = 29;
    case DDR3_NEW = 30;
    case FBD2_NEW = 31;
    case LOGICAL_NON_VOLATILE_DEVICE = 32;
    case HBM2 = 33;
    case DDR5 = 34;
    case LPDDR5 = 35;

    public static function getByValue(int $value): ?string
    {
        foreach (self::cases() as $constant) {
            if ($constant->value === $value) {
                return $constant->name ?? null;
            }
        }
    }
}