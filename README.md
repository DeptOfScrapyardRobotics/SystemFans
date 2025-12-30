
# ScrapyardIO SystemFans

Control your PWM or GPIO-driven SystemFans on your Embedded Linux enabled Device.

## Requirements

- PHP 8.3 or greater
- Scrapyard's [LinuxSystem](https://github.com/DeptOfScrapyardRobotics/LinuxSystem) Extension
- [ScrapyardIO](https://github.com/DeptOfScrapyardRobotics/ScrapyardIO) Package

## Tested Devices
- Raspberry Pi 4 and 4
- Raspberry Pi Zero 2W
- Jetson Orin Nano

## To Be Tested
- Arduino Uno Q
- BananaPi
- OrangePi
- BigTreeTech Pi4B

## Installation

After installing Zephir, the Scrapyard LinuxSystem extension, and the ScrapyardIO package you can install the framework via composer:
```bash
composer require dept-of-scrapyard-robotics/system-fans
```

## Usage

### GPIO Fans

GPIO Fans are fans with 3-pins - 
- (+) Voltage - 5V, 12V or 24V usually
- (-) Ground
- Data

When you plug the data pin into an available GPIO pin, you can turn the on at Full Speed or shut it off completely.

```php
use ScrapyardIO\Actuation\SystemFans\Adapters\GPIOFanAdapter;

// On RPi 4, 5 and Zero2, the main PWM Chip is 4. This fan is plugged into GPIO 6 which maps to \
// physical pin 31.
$fan = (new GPIOFanAdapter())->chip(4)->line(6);


// Turn on the fan
$fan->motorOn();

// Turn off the fan
$fan->motorOff();


```


### PWM Fans

PWM Fans are fans with 3, sometimes 4-pins -
- (+) Voltage - 5V, 12V or 24V usually
- (-) Ground
- Data
- (Optional) Tachometer (like Noctua fans)


When you plug the data pin into an available PWM-controlled pin, you can do various things to the fan
 - Toggle On/off
 - Set the speed

```php

use ScrapyardIO\Actuation\SystemFans\Adapters\PWMFanAdapter;

// This fan is plugged into PWMChip 0 broadcasting on Channel 0 which maps to
// physical pin 32 on an RPi 4, 5 and Zero2
$fan = (new PWMFanAdapter())->chip(0)->channel(0);

// Sets the speed to 80% and turns the fan on
$fan->speed(80)->on();

$fan->off()



```

### Using a Tachometer

If the systems fan plugged into PWM also contains a 4th Pin, you can plug that pin into an available GPIO pin
and set it as an input to read the fan's spinning RPMs.

```php

use ScrapyardIO\Actuation\SystemFans\Adapters\PWMFanAdapter;

// This fan is plugged into PWMChip 0 broadcasting on Channel 0 which maps to
// physical pin 32 on an RPi 4, 5 and Zero2
// This tachometer is plugged into PWMChip 0 broadcasting on Channel 0 which maps to
// physical pin 32 on an RPi 4, 5 and Zero2

$noctua_fan = (new PWMFanAdapter())->chip(0)->channel(0)->tach(4, 6);

// Blocks by default for 2 seconds, and sets PPR to 2
$rpm = $noctua_fan->rpm();


```


### Extending

You can build you own fan implementation which will give you PWM access to 

- Set the oscillation frequency

```php

use ScrapyardIO\Actuation\SystemFans\Adapters\SystemFanAdapter;
use ScrapyardIO\Actuation\SystemFans\Concerns\PWMFanMotor;

class CustomFan extends SystemFanAdapter
{
    use PWMFanMotor;
    
    public function getOscillationFrequency(): int
    {
        return $this->fan_motor_pwm()->frequency();
    }
}

```

## Credits

- [Angel Gonzalez](https://github.com/projectsaturnstudios)