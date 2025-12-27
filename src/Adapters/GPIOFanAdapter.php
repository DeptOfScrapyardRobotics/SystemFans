<?php

namespace ScrapyardIO\Actuation\SystemFans\Adapters;

use ScrapyardIO\Actuation\SystemFans\Concerns\GPIOFanMotor;

class GPIOFanAdapter extends SystemFanAdapter
{
    use GPIOFanMotor;

    public function chip(int $chip): static
    {
        $this->gpio_fan_motor_chip($chip);
        return $this;
    }

    public function line(int $line): static
    {
        $this->gpio_fan_motor_line($line);
        return $this;
    }

    public function on(): void
    {
        $this->motorOn();
    }

    public function off(): void
    {
        $this->motorOff();
    }
}
