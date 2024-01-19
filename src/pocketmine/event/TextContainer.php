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

namespace pocketmine\event;

class TextContainer{

	/** @var string $text */
	protected $text;

	/**
	 * @param string $text
	 */
	public function __construct(string $text){
		$this->text = $text;
	}

	/**
	 * @param string $text
	 */
	public function setText(string $text){
		$this->text = $text;
	}

	/**
	 * @return string
	 */
	public function getText() : string{
		return $this->text;
	}

	/**
	 * @return string
	 */
	public function __toString() : string{
		return $this->getText();
	}
}