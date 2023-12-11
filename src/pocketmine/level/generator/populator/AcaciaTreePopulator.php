<?php

/**
 *      ___                                          _
 *    /   | ____ ___  ______ _____ ___  ____ ______(_)___  ___
 *   / /| |/ __ `/ / / / __ `/ __ `__ \/ __ `/ ___/ / __ \/ _ \
 *  / ___ / /_/ / /_/ / /_/ / / / / / / /_/ / /  / / / / /  __/
 * /_/  |_\__, /\__,_/\__,_/_/ /_/ /_/\__,_/_/  /_/_/ /_/\___/
 *          /_/
 *
 * @author - MaruselPlay
 * @link - https://vk.com/maruselplay
 *
 *
 */

namespace pocketmine\level\generator\populator;

use pocketmine\level\generator\object\AcaciaTree;
use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class AcaciaTreePopulator extends PopulatorCount
{

    private $level;

    private $type;

    public function __construct(int $type = \pocketmine\block\Wood2::ACACIA)
    {
        $this->type = $type;
    }

    public function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random): void
    {
        $this->level = $level;

        $x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
        $z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
        $y = $this->getHighestWorkableBlock($x, $z);
        if ($y === -1) {
            return;
        }
        (new AcaciaTree($this->type))->placeObject($level, $x, $y, $z, $random);
    }

    private function getHighestWorkableBlock(int $x, int $z): int
    {
        for ($y = 254; $y > 0; --$y) {
            $b = $this->level->getBlockIdAt($x, $y, $z);
            if ($b === Block::DIRT || $b === Block::GRASS || $b === Block::TALL_GRASS) {
                break;
            } elseif ($b !== Block::AIR && $b !== Block::SNOW_LAYER) {
                return -1;
            }
        }

        return ++$y;
    }

}
