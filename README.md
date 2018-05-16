# monolog-gdpr
Some Monolog processors that will help in relation to the security requirements under GDPR.
These processors will replace data with their SHA-1 equivalent, allowing you still to search 
logs

WARNING: These processors will json serialise your `$context`. This may cause some undesired side-effects.

## Installation
Install the latest version with

```
$ composer require andriesss/monolog-gdpr
```

## Salted hashes
This library supports salted hashes using `processor->setSalt(<salt>)`. To compute your hashed 
value you could use the following bash command:

```bash
$ echo -n 'foo@bar.com<YourSalt>' | openssl sha1
```

## RedactEmailProcessor
Replaces all e-mail addresses by their SHA-1 hash.

Usage:

```PHP
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Anse\Monolog\Gdpr\Processor\RedactEmailProcessor;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

$processor = new RedactEmailProcessor();
// optionally you may configure a salt:
$processor->setSalt('h@tsefl@ts!');
$log->pushProcessor($processor);

$log->log(Logger::DEBUG, 'This is a test for foo@bar.com', ['foo' => ['bar' => 'foo@bar.com']]);
```

## RedactIpProcessor
Replaces all ipv4 addresses by their SHA-1 hash.

Usage:

```PHP
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Anse\Monolog\Gdpr\Processor\RedactIpProcessor;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

$processor = new RedactIpProcessor();

// optionally you may configure a salt:
$processor->setSalt('h@tsefl@ts!');
$log->pushProcessor($processor);

$log->log(Logger::DEBUG, 'This is a test for 127.0.0.1', ['foo' => ['bar' => '127.0.0.1']]);
```

## License
Package is licensed under the MIT License - see the LICENSE file for details
