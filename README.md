Codes
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
        "sanchobbdo/codes": "~1.0"
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

Generating codes
----------------

From the command line:

Install [symfony/console][symfony_console] and
[sonata-project/exporter][sp_exporter] packages using composer:

```bash
composer require symfony/console:2.2.* sonata-project/exporter:1.2.*
```

Create a config file somewhere in your project:

```yaml
# /path/to/your/project/codes.yml

offset: 0,
limit: 1000,
coder:
    secret_key: your-secret-key,
    key_length: 4,
    mac_length: 6
```

From your project root:

```bash
# Dump to csv
./vendor/bin/codes dump:csv file.csv your/config/file.yml

# Dump to xls
./vendor/bin/codes dump:xls file.xls your/config/file.yml
```

---

From code:

Here is an example using the [sonata-project/exporter][sp_exporter] (you can
roll you're own implementation):

```php
// On top of your file include required classes
use Exporter\Handler;
use Exporter\Writer\CsvWriter;
use SanchoBBDO\Codes\CodesSource;
```

```php
$codesSource = new CodesSource($codes);
$writer = new CsvWriter('your-file.csv');
Handler::create($codesSource, $writer)->export();
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
[symfony_console]: http://symfony.com/doc/current/components/console/index.html
[sp_exporter]: https://github.com/sonata-project/exporter
