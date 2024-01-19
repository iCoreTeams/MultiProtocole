<?php

declare(strict_types=1);

namespace pocketmine\command\data;

interface CommandParameterType {
    public const string TYPE_STRING = "string";
    public const string TYPE_STRING_ENUM = "stringenum";
    public const string TYPE_BOOL = "bool";
    public const string TYPE_TARGET = "target";
    public const string TYPE_BLOCK_POS = "blockpos";
    public const string TYPE_RAW_TEXT = "rawtext";
    public const string TYPE_INT = "int";
}