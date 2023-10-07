# Chapaar | flexible way to send SMS through various SMS providers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/TookanTech/chapaar.svg?style=flat-square)](https://packagist.org/packages/TookanTech/chapaar)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/TookanTech/chapaar/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/TookanTech/chapaar/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/TookanTech/chapaar/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/TookanTech/chapaar/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/TookanTech/chapaar.svg?style=flat-square)](https://packagist.org/packages/TookanTech/chapaar)

Chapaar offers flexible message sending and verification through multiple SMS providers, with easy integration and no lock-in to any specific provider.

## Available Drivers
* [kavenegar.com](https://kavenegar.com/) (tested)
* [sms.ir](https://sms.ir/) (tested)
* [ghasedak.me](https://ghasedak.me/) (tested)
* Farapayamk (coming soon)
* Twillo (coming soon)


## Installation

You can install the package via Composer:

```bash
composer require tookantech/chapaar
```


## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="chapaar-config"
```
This will create a chapaar.php configuration file in your config directory, where you can set the default driver and configure driver-specific settings.

This is the contents of the published config file:
```php
return [
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    'drivers' => [
        'kavenegar' => [
            'url' => 'https://api.kavenegar.com/v1/',
            'api_key' => '',
            'line_number' => ''
        ],
        'smsir' => [
            'url' => 'https://api.sms.ir/v1/',
            'api_key' => '',
            'line_number' => '',
        ],
        'ghasedak' => [
            'url'         => 'https://api.ghasedak.me/v2/',
            'api_key'     => '',
            'line_number' => '',
        ],
    ],
];

```

## Usage
Using the Chapaar Facade

If you want to use the Chapaar package without Laravel's built-in notification system, you can utilize the Chapaar facade directly. This allows you to send and verify messages using different SMS providers.

Sending a Simple Message
```php
use TookanTech\Chapaar\Facades\Chapaar;
use TookanTech\Chapaar\SmsMessage;

$message = (new SmsMessage())->driver()
    ->setFrom('12345678')
    ->setTo('0912111111')
    ->setContent('Hello, this is a test message.');

$response = Chapaar::send($message);

```
Sending With Template Message
```php
use TookanTech\Chapaar\Facades\Chapaar;
use TookanTech\Chapaar\SmsMessage;

#Kavenegar
$message =(new SmsMessage())
    ->driver()
    ->setTemplate("invoice-paid")
    ->setTo('09121111111')
    ->setTokens([
        '123', // token
        '456', // token2
        '789', // token3
        '111', // token10, with 4 space
        '222', // token20, with 8 space
    ]);
    
# SmsIr
$message =(new SmsMessage())
    ->driver()
    ->setTemplate('invoice-paid')
    ->setTo('09121111111')
    ->setTokens([
        'code' => '123' // 'variable_name' => 'value'
    ]);
    
# Ghasedak
$message =(new SmsMessage())
    ->driver()
    ->setTemplate("invoice-paid")
    ->setTo('09121111111')
    ->setTokens([
        'test1', // param1
        'test2'  // param2
    ]);

$response = Chapaar::verify($message);

```

Get Latest Outbox messages
it automatically get the latest sent messages for default driver
```php
$response = Chapaar::outbox(100);
```

## Using In Notifications
Please review [laravel notifications](https://laravel.com/docs/10.x/notifications) on how use notifications in laravel.

```php
use TookanTech\Chapaar\SmsChannel;
class InvoicePaid extends KavenegarBaseNotification
{
    public function via($notifiable): array
    {
        return [SmsChannel::class];
    }
    public function toSms($notifiable)
    {
        return (new SmsMessage)->driver()
        ->setTemplate('verify')
        ->setTokens([123],[456])
    }
}

class User extends Authenticatable
{
    use Notifiable;

    public function routeNotificationForSms($driver, $notification = null)
    {
        return $this->mobile;
    }

}
``` 

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [tookantech](https://github.com/TookanTech)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
