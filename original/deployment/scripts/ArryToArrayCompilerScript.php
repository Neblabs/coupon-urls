<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;
use CouponURLs\Original\Environment\Env;
use Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Cast;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\ParserFactory;
use PhpParser\PhpParser;
use PhpParser\PrettyPrinter\Standard;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;
use function CouponURLs\Original\Utilities\Text\i;

Class ArryToArrayCompilerScript extends Script
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
        $fileData = file_get_contents($this->data->target);<<<FILEDATA
            <?php

            function kug() {
                return [
                    (a(id:10, names: \$this->getNames([
                        a(name: "rafael"),
                        a() //should -> []
                    ]))),
                    o(
                        id: 10,
                        names: a(
                            o(single: 'rafa', full: 'rafael serna')
                        )
                    )
                ];
            }

        FILEDATA;


        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($fileData);

            $traverser = new NodeTraverser;
            $traverser->addVisitor(new class extends NodeVisitorAbstract {
                public function leaveNode(Node $node) {
                    if ($node instanceof Node\Expr\FuncCall && method_exists($node->name, 'toString') && i($node?->name->toString())->isEither(['a', 'o'])) {
                        //dump('a match is it', $node);
                        ArryToArrayCompilerScript::$replaced = true;
                        // Replace the function call with a new node...
                        (object) $transformedAsArray = new Array_(_($node->args)->map(
                            fn(Arg $arg) => new ArrayItem(
                                value: $arg->value,
                                key: $arg->name? new Node\Scalar\String_($arg->name?->name): null
                            )
                        )->asArray(), attributes: a(kind: Array_::KIND_SHORT));

                        return match($node->name->toString()) {
                            'a' => $transformedAsArray,
                            'o' => new Object_(
                                $transformedAsArray
                            )
                        };
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (ArryToArrayCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dump("replacing Arry: {$this->data->source}", /*$prettyPrinter->prettyPrintFile($ast)*/);
                file_put_contents(
                    filename: $this->data->target, 
                    data: $prettyPrinter->prettyPrintFile($ast),
                );
                ArryToArrayCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}