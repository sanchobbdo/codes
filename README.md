Codes [![Build Status](https://travis-ci.org/sanchobbdo/codes.png)](https://travis-ci.org/sanchobbdo/codes)
=====

A PHP code generator and validator. Can be use for promotions, sweepstakes,
coupons or any other application which needs to validate codes provided by
users.

Installing
----------

Create a ```composer.json``` file in the project root:

```json
{
    "require": {
        "sanchobbdo/codes": "~1.1"
    }
}
```

Then download ```composer.phar``` and run the install command:

```bash
curl -s http://getcomposer.org/installer | php && ./composer.phar install
```

Initialize
----------

```php
// Include composer's autoload
require 'vendor/autoload.php';

// Include codes builder
use SanchoBBDO\Codes\CodesBuilder;

// Create a Codes instance using the CodesBuilder.
$codes = CodesBuilder::buildCodes(array(
    'offset'     => 100,         // Start from
    'limit'      => 1000,        // How many codes to generate
    'coder'      => array(       // Coder settings
        'secret_key' => 'secret-key',    // Coder secret key
        'key_length' => 4,               // Code's key length
        'mac_length' => 6,               // Code's mac length
        'algo'       => 'sha1'           // Hash hmac algorithm
    )
));
```

The default coder generates codes composed of a **key** and a **mac**; the
**key** identifies codes while the **mac** is used to validate them. The
```mac_length``` and ```key_length``` determine how long the code will be.

The **mac** is generated using the [hash_hmac][hash_hmac] php function. The
algorithm used is determined by ```algo```. To see available algorithms check
the [hash_algos][hash_algos] php function.

Validating codes
----------------

```php
// Validate the given code using the coder
if ($codes->getCoder()->isValid($_POST['code'])) {
    // Do something on success
} else {
    // Do something on failure
}
```

Iterating over codes
--------------------

```php
foreach ($codes as $code) {
    // Do something with $code
}
```

CLI Application
---------------

The package comes with a built-in CLI application to validate and dump codes.

To use it you must install the required packages and create a ```config.yml```
file somewhere in your project:

```bash
composer require symfony/console:2.3.* \
                 symfony/yaml:2.2.3
```

```yaml
# /path/to/your/project/codes.yml

offset: 0
limit: 1000
coder:
    secret_key: your-secret-key
    key_length: 4
    mac_length: 6
```

Usage:

```bash
# Validate codes
./bin/vendor/codes validate code1 code2 code3 --config path/to/config.yml

# Dump codes
./bin/vendor/codes dump --config path/to/config.yml
```

Disclaimer
----------

The software is provided "as is", without warranty of any kind, express or
implied, including but not limited to the warranties of merchantability,
fitness for a particular purpose and noninfringement. In no event shall the
authors or copyright holders be liable for any claim, damages or other
liability, whether in an action of contract, tort or otherwise, arising from,
out of or in connection with the software or the use or other dealings in the
software.

License
--------

Licensed under the [MIT license](http://opensource.org/licenses/MIT).

[hash_hmac]: http://php.net/manual/en/function.hash-hmac.php
[hash_algos]: http://www.php.net/manual/en/function.hash-algos.php
