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

namespace pocketmine\level\generator\normal\biome;

use pocketmine\block\Block;
use pocketmine\block\Flower as FlowerBlock;
use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\MushroomPopulator;
use pocketmine\level\generator\populator\DarkOakTreePopulator;

class RoofedForestBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

				$flower = new Flower();
        $flower->setBaseAmount(2);
        $this->addPopulator($flower);

        $mushroom = new MushroomPopulator();
        $mushroom->setBaseAmount(0);
        $mushroom->setRandomAmount(1);
        $this->addPopulator($mushroom);


        $tree = new DarkOakTreePopulator();
        $tree->setBaseAmount(20);
        $tree->setRandomAmount(10);
        $this->addPopulator($tree);
				
				$this->setElevation(63, 68);
    }

    public function getName(): string
    {
        return "Roofed Forest";
    }
}
