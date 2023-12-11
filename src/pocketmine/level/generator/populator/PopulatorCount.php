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

use pocketmine\level\ChunkManager;
use pocketmine\level\generator\populator\Populator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

abstract class PopulatorCount extends Populator
{

    protected $randomAmount = 1;
    protected $baseAmount;
    protected $spreadChance = 0;

    public function setRandomAmount(int $randomAmount): void
    {
        $this->randomAmount = $randomAmount + 1;
    }

    public function setBaseAmount(int $baseAmount): void
    {
        $this->baseAmount = $baseAmount;
    }

    public function setSpreadChance(float $chance): void
    {
        $this->spreadChance = $chance;
    }

    public function getAmount(Random $random): int{
      return $this->baseAmount + $random->nextRange(0, $this->randomAmount + 1);
    }

    public function populate(ChunkManager $level, $chunkX, $chunkZ, Random $random)
    {
        $count = $this->baseAmount + $random->nextBoundedInt($this->randomAmount);
        for ($i = 0; $i < $count; $i++) {
            $this->populateCount($level, $chunkX, $chunkZ, $random);
        }
    }

    protected abstract function populateCount(ChunkManager $level, int $chunkX, int $chunkZ, Random $random): void;

    protected function spread(int $x, int $y, int $z, ChunkManager $level): ?Vector3
    {
        return null;
    }

}
