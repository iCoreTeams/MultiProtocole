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

use pocketmine\level\generator\populator\TreePopulator;
use pocketmine\level\generator\populator\AcaciaTreePopulator;


class SavannaBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

        $tree = new AcaciaTreePopulator();
        $tree->setBaseAmount(2);
        $this->addPopulator($tree);

        $this->setElevation(60, 67);
    }

    public function getName(): string
    {
        return "Savanna";
    }
}
