# monolog-gdpr
Some Monolog processors that will help in relation to the security requirements under GDPR.

WARNING: These processors will json serialise your `$context`. This may cause some undesired side-effects.

## RedactEmailProcessor
Replaces all e-mail addresses by their SHA-1 hash.

## RedactIpProcessor
Replaces all ipv4 addresses by their SHA-1 hash.
