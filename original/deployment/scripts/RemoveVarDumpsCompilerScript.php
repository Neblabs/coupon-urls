<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Deployment\Script;
use CouponURLS\Original\Environment\Env;
use Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use function CouponURLS\Original\Utilities\Collection\{_, a};
use function CouponURLS\Original\Utilities\Text\i;

Class RemoveVarDumpsCompilerScript extends Script
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

            use CouponURLS\Original\Exceptions\MyCustomException;

            function kug() {
                return [
                    'name' => var_dump(\$data),
                ];
            }

        FILEDATA; 


        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileData);

            $traverser = new NodeTraverser;
            $traverser->addVisitor(new class extends NodeVisitorAbstract {
                public function leaveNode(Node $node) {
                    if ($node instanceof Node\Expr\FuncCall && method_exists($node->name, 'toString') && i($node?->name->toString())->isEither(['var_dump', 'dump'])) {

                        RemoveVarDumpsCompilerScript::$replaced = true;
                        return new String_('');
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (RemoveVarDumpsCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dd("replacing _(): {$this->data->source}", $prettyPrinter->prettyPrintFile($ast));
                file_put_contents(
                    filename: $this->data->target, 
                    data: $prettyPrinter->prettyPrintFile($ast),
                );
                RemoveVarDumpsCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}