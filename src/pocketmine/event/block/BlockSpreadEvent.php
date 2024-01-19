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

namespace pocketmine\event\block;

use pocketmine\block\Block;

class BlockSpreadEvent extends BlockFormEvent{
	public static $handlerList = null;

	/** @var Block */
	private $source;

	public function __construct(Block $block, Block $source, Block $newState){
		parent::__construct($block, $newState);
		$this->source = $source;
	}

	/**
	 * @return Block
	 */
	public function getSource(){
		return $this->source;
	}

}