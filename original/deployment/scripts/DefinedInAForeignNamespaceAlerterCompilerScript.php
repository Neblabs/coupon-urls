<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Deployment\Script;
use CouponURLS\Original\Environment\Env;
use Error;
use Exception;

use function CouponURLS\Original\Utilities\Collection\_;
use function CouponURLS\Original\Utilities\Text\i;

Class DefinedInAForeignNamespaceAlerterCompilerScript extends Script
{
    static protected array $filesToExclude = [
        // strings with the file names ENDING IN, like: 'utilities/collection/collection.php'
    ];

    static public bool $replaced = false;


    static public function withFilesToExclude(array $filesToExclude) : string
    {
        static::$filesToExclude = array_merge(static::$filesToExclude, $filesToExclude);

        return self::class;
    }

    public function run()
    {
        if (
            !i($this->data->target)->endsWith('.php') ||
            i($this->data->target)->matchesRegEx('/coupon-urls[A-Za-z0-9_-]*\/vendor/') ||
            _(static::$filesToExclude)->have(
                fn(string $fileEndingIn) => i($this->data->target)->endsWith($fileEndingIn)
            )
        ) {
            return;
        }

        //_() -> new collection([])
        //_(['one', 'two']) -> new collection(['one', 'two'])
        //_('one', 'two') -> new collection (['one', 'two'])
        //_(one: 'one') -> new collection(['one' => 'one'])
        //_(one: ['one', 'two']) -> new collection(['one' => ['one', 'two']])

        $fileData = file_get_contents($this->data->target);<<<FILEDATA
            <?php

            namespace WTEOptions\options\emails;

            use CouponURLS\Original\Exceptions\MyCustomException;

            function kug() {
                return [
                    'name' => __(\$name),
                    'abither' => __('my name')
                ];
            }

        FILEDATA; 


        try {
            (object) $namespaceMatches = i($fileData)->matches('/namespace (\w+)/');
            (string) $ourNamespace = Env::settings()->app->namespace;

            if ($namespaceMatches->haveAny() && i($namespaceMatches->first())->isNot($ourNamespace, caseInsensitive: false))  {
                throw new Exception("File is defined in a foreign namespace: {$this->data->target}");
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}