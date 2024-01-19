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

namespace pocketmine\network\mcpe\protocol\types;

use function strlen;

class Skin{

	/** @var string */
	private $skinId;
	/** @var string */
	private $skinData;

	public function __construct(string $skinId, string $skinData){
		$this->skinId = $skinId;
		$this->skinData = $skinData;
	}

	/**
	 * @return bool
	 */
	public function isValid() : bool{
		return strlen($this->skinData) === 64 * 64 * 4 or strlen($this->skinData) === 64 * 32 * 4;
	}

	/**
	 * @return string
	 */
	public function getSkinId() : string{
		return $this->skinId;
	}

	/**
	 * @return string
	 */
	public function getSkinData() : string{
		return $this->skinData;
	}
}