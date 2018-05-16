# monolog-gdpr
Some Monolog processors that will help in relation to the security requirements under GDPR.

WARNING: These processors will json serialise your `$context`. This may cause some undesired side-effects.

## RedactEmailProcessor
Replaces all e-mail addresses by their SHA-1 hash.

Usage:

```
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));
$log->pushProcessor(new RedactEmailProcessor());
```

## RedactIpProcessor
Replaces all ipv4 addresses by their SHA-1 hash.

Usage:

```
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));
$log->pushProcessor(new RedactIpProcessor());

$log->log(Logger::DEBUG, 'This is a test for 127.0.0.1', ['foo' => ['bar' => '127.0.0.1']]);
```
