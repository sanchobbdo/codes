Codes
=====

A promotional codes generator and validator.

*Warning:* This package is under heavy development, it's API can change and
it's not fully secured.

Installing
----------

Create a composer.json file in the project root:

```json
{
    "require": {
        "sanchobbdo/codes": "dev-master"
    }
}
```

Then download composer.phar and run the install command:

```bash
curl -s http://getcomposer.org/installer | php && ./composer.phar install
```

Initialize
----------

```php
// Include composer's autoload
require 'vendor/autoload.php';

// Use codes
use SanchoBBDO\Codes\Codes;

// Create a Codes instance using the 'from' factory method
$codes = Codes::from(array(
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

The default coder generates codes composed of a _key_ and a _mac_; the key
helps to identify the code while the mac is the signature which
validates it. The ```mac_length``` and ```key_length``` determine how long the
code will be.

The _mac_ is generated using the
[hash_hmac](http://php.net/manual/en/function.hash-hmac.php) php
function. The algorithm used is determined by ```algo```. To see
available algorithms check the
[hash_algos](http://www.php.net/manual/en/function.hash-algos.php) php
function.

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
# Dump to screen
./vendor/bin/codes dump your/config/file.json

# Dump to txt file
./vendor/bin/codes dump:txt your/config/file.yml dump.txt
```

---

From code:

```php
// Must include some extra classes
use SanchoBBDO\Codes\CodesDumper;
use SanchoBBDO\Codes\DumpWriter\TextDumpWriter;
```

```php
// Init a dump writer
//
// Available writers:
//    Writes to stdout                  StdoutDumpWriter()
//    Writes to symfony console output  ConsoleDumpWriter(OutputInterface $oi)
//    Writes to a text file             TextDumpWriter($filename)
$dumpWriter = new TextDumpWriter('your-file.txt');

// Init a codes dumper passing your codes and dump writer instances
$codesDumper = new CodesDumper($codes, $dumpWriter);

// Dump!
$codesDumper->dump();
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

Lincense
--------

Licensed under the [MIT license](http://opensource.org/licenses/MIT).
