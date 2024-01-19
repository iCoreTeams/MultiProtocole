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

namespace pocketmine\network\bedrock\protocol\types;

use pocketmine\network\mcpe\NetworkBinaryStream;

final class EducationUriResource{
    public $buttonName;
    public $linkUri;

    public function __construct(string $buttonName, string $linkUri){
        $this->buttonName = $buttonName;
        $this->linkUri = $linkUri;
    }

    public function getButtonName() : string{ return $this->buttonName; }

    public function getLinkUri() : string{ return $this->linkUri; }

    public static function read(NetworkBinaryStream $in) : self{
        $buttonName = $in->getString();
        $linkUri = $in->getString();
        return new self($buttonName, $linkUri);
    }

    public function write(NetworkBinaryStream $out) : void{
        $out->putString($this->buttonName);
        $out->putString($this->linkUri);
    }
}