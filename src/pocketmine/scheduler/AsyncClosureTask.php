<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use Closure;
use pocketmine\Server;
use pocketmine\thread\NonThreadSafeValue;

class AsyncClosureTask extends AsyncTask{

    protected NonThreadSafeValue $parameters;

    public function __construct(
        protected Closure $fn,
        array $parameters = [],
        protected ?Closure $onComplete = null,
    ) {
        $this->parameters = new NonThreadSafeValue($parameters);
    }

    public function onRun() : void{
        ($this->fn)(...$this->parameters->deserialize());
    }

    public function onCompletion(Server $server) : void{
        if ($this->onComplete !== NULL) {
            ($this->onComplete)();
        }
    }
}