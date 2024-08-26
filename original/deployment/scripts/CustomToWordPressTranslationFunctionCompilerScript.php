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

Class CustomToWordPressTranslationFunctionCompilerScript extends Script
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
                    'name' => __(\$name),
                    'abither' => __('my name')
                ];
            }

        FILEDATA; 


        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileData);

            $traverser = new NodeTraverser;
            $traverser->addVisitor(new class extends NodeVisitorAbstract {
                public function leaveNode(Node $node) {
                    if ($node instanceof Node\Expr\FuncCall && method_exists($node->name, 'toString') && $node?->name->toString() === '__' && count($node->args) <= 1) {

                        CustomToWordPressTranslationFunctionCompilerScript::$replaced = true;
                        //dump($node->args);
                        return match(true) {
                            empty($node->args) => new String_(''),
                            count($node->args) === 1 => new FuncCall(
                                name: new Name('\__'),
                                args: [
                                    $node->args[0]->value,
                                    new String_(Env::textDomain())
                                ]
                            ),
                        };
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (CustomToWordPressTranslationFunctionCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dd("replacing _(): {$this->data->source}", $prettyPrinter->prettyPrintFile($ast));
                file_put_contents(
                    filename: $this->data->target, 
                    data: $prettyPrinter->prettyPrintFile($ast),
                );
                CustomToWordPressTranslationFunctionCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}