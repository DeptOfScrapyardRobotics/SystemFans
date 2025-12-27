<?php

namespace ScrapyardIO\Actuation\SystemFans\Concerns;

use ScrapyardIO\Transports\PWMTransport;

trait PWMFanMotor
{
    protected ?PWMTransport $fan_motor_pwm = null;
    protected int $fan_motor_pwm_chip = 0;
    protected int $fan_motor_pwm_channel = 0;
    protected int $freq = 25000;

    protected function pwm_fan_motor_chip(?int $chip = null): int
    {
        if($chip)
        {
            $this->fan_motor_pwm_chip = $chip;
        }
        return $this->fan_motor_pwm_chip;
    }

    protected function pwm_fan_motor_channel(?int $channel = null): int
    {
        if($channel)
        {
            $this->fan_motor_pwm_channel = $channel;
        }
        return $this->fan_motor_pwm_channel;
    }

    protected function fan_motor_pwm(): ?PWMTransport
    {
        if(empty($this->fan_motor_pwm))
        {
            $this->fan_motor_pwm = new PWMTransport(
                $this->pwm_fan_motor_channel(),
                $this->pwm_fan_motor_chip()
            );
            $this->fan_motor_pwm->frequency($this->freq);
        }

        return $this->fan_motor_pwm;
    }

    public function motorOn(): void
    {
        $this->fan_motor_pwm()?->enable(true);
    }

    public function motorOff(): void
    {
        $this->fan_motor_pwm()?->enable(false);
    }

    public function speed(?int $speed = null): int
    {
        return $this->fan_motor_pwm()?->level($speed) ?? 0;
    }
}
