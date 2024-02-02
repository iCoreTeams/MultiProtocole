<?php

/*
 *
 *                            __  __ _
 *     /\                    |  \/  (_)
 *    /  \   __ _ _   _  __ _| \  / |_ _ __   ___
 *   / /\ \ / _` | | | |/ _` | |\/| | | '_ \ / _ \
 *  / ____ \ (_| | |_| | (_| | |  | | | | | |  __/
 * /_/    \_\__, |\__,_|\__,_|_|  |_|_|_| |_|\___|
 *             | |
 *             |_|
 *
 * This program is private software. No license required.
 * Publication of this program is forbidden and will be punished.
 *
 * @author GreenWix Project
 * @link https://www.greenwix.fun
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\item\Tool;

class NetherWart extends Solid{

    protected $id = self::NETHER_WART_BLOCK;

    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    public function getName(){
        return "Nether Wart";
    }

    public function getHardness(){
        return 1;
    }

    public function getBlastResistance(): float
    {
        return 5;
    }

    public function getToolType(){
        return Tool::TYPE_HOE;
    }
}