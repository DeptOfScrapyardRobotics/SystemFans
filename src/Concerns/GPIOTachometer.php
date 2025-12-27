<?php

namespace ScrapyardIO\Actuation\SystemFans\Concerns;

use ScrapyardIO\Transports\Enums\GPIODirection;
use ScrapyardIO\Transports\GPIOTransport;

trait GPIOTachometer
{
    protected ?GPIOTransport $tachometer_gpio  = null;
    protected int $tachometer_gpio_chip = 0;
    protected int $tachometer_gpio_line = 0;

    public function tachometer_chip(?int $chip = null): int
    {
        if($chip)
        {
            $this->tachometer_gpio_chip = $chip;
        }
        return $this->tachometer_gpio_chip;
    }

    public function tachometer_line(?int $line = null): int
    {
        if($line)
        {
            $this->tachometer_gpio_line = $line;
        }
        return $this->tachometer_gpio_line;
    }

    public function tachometer_gpio(): ?GPIOTransport
    {
        if(empty($this->tachometer_gpio))
        {
            $this->tachometer_gpio = new GPIOTransport(
                $this->tachometer_line(),
                $this->tachometer_chip(),
                GPIODirection::INPUT
            );
        }

        return $this->tachometer_gpio;
    }

    public function tachometer_read(): int
    {
        return $this->tachometer_gpio()?->read() ?? 0;
    }
}
