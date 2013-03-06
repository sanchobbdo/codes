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

Validating codes
----------------

```php
// Include composer's autoload
require 'vendor/autoload.php';

// Init a coder instance providing a secret key
$coder = new SanchoBBDO\Codes\Coder('your-ultra-secret-key');

// Validate the given code
if ($coder->isValid($_POST['code'])) {
    // Do something on success
} else {
    // Do something on failure
}
```

Generating codes
----------------

From the command line:

```bash
# Dump to screen
./vendor/bin/codes dump \
    --secret-key=your-secret-key \
    --offset=0 \
    --limit=1000

# Dump to txt file
./vendor/bin/codes dump:txt your-codes-file.txt \
    --secret-key=your-secret-key \
    --offset=0 \
    --limit=1000
```

From code:

```php
// Include composer's autoload
require 'vendor/autoload.php';

// Init a codes instance using th codes factory build method
$codes = SanchoBBDO\Codes\CodesFactory::build(array(
    'offset'     => 100,         // Start from
    'limit'      => 1000,        // How many codes to generate
    'secret_key' => 'secret-key' // Coder secret key
));

// Init a dump writer
// Available writers:
//    Writes to stdout                  StdoutDumpWriter()
//    Writes to symphony console output ConsoleDumpWriter(OutputInterface $oi)
//    Writes to a text file             TextDumpWriter($filename)
$dumpWriter = new SanchoBBDO\Codes\DumpWriter\TextDumpWriter('your-file.txt');

// Init a codes dumper passing your codes and dump writer instances
$codesDumper = new SanchoBBDO\Codes\CodesDumper($codes, $dumpWriter);

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

Licensed under the [MIT lincense](http://opensource.org/licenses/MIT).
