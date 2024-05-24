<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;
use Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use function CouponURLs\Original\Utilities\Collection\{_, a};
use function CouponURLs\Original\Utilities\Text\i;

Class _ToNewCollectionCompilerScript extends Script
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
            i($this->data->target)->matchesRegEx('/automated-emails[\w0-9]*\/vendor/') ||
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

            function kug() {
                return [
                    _(),
                    _(['one', 'two']),
                    _('one'),
                    _(['one', 'two'], ['three', 'four']), // -> neblabs_collection([ ['one', 'two'], ['three', 'four'] ])
                    _('one', 'two'), // -> neblabs_collection(['one', 'two'])
                    _(one: 1), // ->neblabs_collection(['one' => 1])
                    _(one: ['one', 'two']),
                    _(one: ['one', 'two'], two: 'three'),
                ];
            }

        FILEDATA;


        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileData);

            $traverser = new NodeTraverser;
            $traverser->addVisitor(new class extends NodeVisitorAbstract {
                public function leaveNode(Node $node) {
                    if ($node instanceof Node\Expr\FuncCall && method_exists($node->name, 'toString') && $node?->name->toString() === '_') {
                        (string) $functionName = 'neblabs_collection';

                        _ToNewCollectionCompilerScript::$replaced = true;
                        //dump($node->args);
                        return match(true) {
                            empty($node->args) => new FuncCall(
                                name: new Name($functionName),
                                args: [
                                    new Array_(attributes: a(kind: Array_::KIND_SHORT))    
                                ]
                            ),
                            count($node->args) === 1 && $node->args[0]->name === null && $node->args[0]->value  instanceof Array_ => new FuncCall(
                                name: new Name($functionName),
                                args: [
                                    $node->args[0]->value
                                ]
                            ),
                            default => new FuncCall(
                                name: new Name($functionName),
                                args: [
                                    new Array_(_($node->args)->map(
                                        fn(Arg $arg) => new ArrayItem(
                                            value: $arg->value,
                                            key: $arg->name?->name? new Node\Scalar\String_($arg->name->name) : null
                                        )
                                    )->asArray(), attributes: a(kind: Array_::KIND_SHORT))
                                ]
                            ),
                        };
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (_ToNewCollectionCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dump("replacing _(): {$this->data->source}", /*$prettyPrinter->prettyPrintFile($ast)*/);
                file_put_contents(
                    filename: $this->data->target, 
                    data: $prettyPrinter->prettyPrintFile($ast),
                );
                _ToNewCollectionCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}