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

use pocketmine\level\generator\populator\Flower;
use pocketmine\level\generator\populator\LilyPad;
use pocketmine\level\generator\populator\MushroomPopulator;
use pocketmine\level\generator\populator\SwampTreePopulator;
use pocketmine\block\Block;
use pocketmine\block\Flower as FlowerBlock;

class SwampBiome extends GrassyBiome
{

    public function __construct()
    {
        parent::__construct();

				$lilypad = new LilyPad();
				$lilypad->setBaseAmount(4);
				$this->addPopulator($lilypad);

        $trees = new SwampTreePopulator();
        $trees->setBaseAmount(2);
        $this->addPopulator($trees);

				$flower = new Flower();
				$flower->setBaseAmount(8);
				$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_BLUE_ORCHID]);

        $mushroom = new MushroomPopulator(1);
        $mushroom->setBaseAmount(-10);
        $mushroom->setRandomAmount(11);
        $this->addPopulator($mushroom);

				$this->setElevation(62, 63);

				$this->temperature = 0.8;
				$this->rainfall = 0.9;
    }

    public function getName(): string
    {
        return "Swamp";
    }
}
