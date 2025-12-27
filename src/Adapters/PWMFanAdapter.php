<?php

namespace ScrapyardIO\Actuation\SystemFans\Adapters;

use ScrapyardIO\Actuation\SystemFans\Concerns\PWMFanMotor;

class PWMFanAdapter extends SystemFanAdapter
{
    use PWMFanMotor;

    public function chip(int $chip):static
    {
        $this->pwm_fan_motor_chip($chip);
        return $this;
    }

    public function channel(int $channel): static
    {
        $this->pwm_fan_motor_channel($channel);
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
