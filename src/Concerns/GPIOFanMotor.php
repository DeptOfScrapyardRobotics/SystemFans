<?php

namespace ScrapyardIO\Actuation\SystemFans\Concerns;

use ScrapyardIO\Transports\GPIOTransport;

trait GPIOFanMotor
{
    protected ?GPIOTransport $fan_motor_gpio  = null;
    protected int $fan_motor_gpio_chip = 0;
    protected int $fan_motor_gpio_line = 0;

    protected function gpio_fan_motor_chip(?int $chip = null): int
    {
        if($chip)
        {
            $this->fan_motor_gpio_chip = $chip;
        }
        return $this->fan_motor_gpio_chip;
    }

    protected function gpio_fan_motor_line(?int $line = null): int
    {
        if($line)
        {
            $this->fan_motor_gpio_line = $line;
        }
        return $this->fan_motor_gpio_line;
    }

    protected function fan_motor_gpio(): ?GPIOTransport
    {
        if(empty($this->fan_motor_gpio))
        {
            $this->fan_motor_gpio = new GPIOTransport(
                $this->gpio_fan_motor_line(),
                $this->gpio_fan_motor_chip()
            );
        }

        return $this->fan_motor_gpio;
    }

    public function motorOn(): void
    {
        $this->fan_motor_gpio()?->high();
    }

    public function motorOff(): void
    {
        $this->fan_motor_gpio()?->low();
    }
}
