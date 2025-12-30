<?php

namespace ScrapyardIO\Actuation\SystemFans\Adapters;

use ScrapyardIO\Actuation\SystemFans\Concerns\GPIOTachometer;
use ScrapyardIO\Actuation\Contracts\Actuation\ScrapyardActuator;

abstract class SystemFanAdapter extends ScrapyardActuator
{
    use GPIOTachometer;

    abstract public function on(): void;
    abstract public function off(): void;
    abstract public function chip(int $chip): static;

    public function tach(int $chip, int $line): static
    {
        $this->tachometer_chip($chip);
        $this->tachometer_line($line);
        $this->tachometer_gpio();

        return $this;
    }

    public function rpm(float $duration = 2.0, int $pulsesPerRev = 2): int
    {
        if (is_null($this->tachometer_gpio)) {
            return -1;
        }

        $pulseCount = 0;
        $lastState = $this->tachometer_read();
        $startTime = microtime(true);

        while ((microtime(true) - $startTime) < $duration) {
            $currentState = $this->tachometer_read();

            // Detect falling edge
            if ($lastState === 1 && $currentState === 0) {
                $pulseCount++;
            }

            $lastState = $currentState;
            usleep(100); // 100 microsecond delay
        }

        return (int)(($pulseCount * 60) / ($duration * $pulsesPerRev));
    }
}
