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

use pocketmine\utils\Random;

class CustomRandom extends Random
{

    public function nextLong(): int
    {
        return $this->nextSignedInt();
    }

}
