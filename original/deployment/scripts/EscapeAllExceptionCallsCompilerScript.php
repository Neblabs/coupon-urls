<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Deployment\Script;
use CouponURLS\Original\Environment\Env;
use Error;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

use function CouponURLS\Original\Utilities\Collection\{_, a};
use function CouponURLS\Original\Utilities\Text\i;

Class EscapeAllExceptionCallsCompilerScript extends Script
{
    public const METHOD_NAMES = [
    ];

    static protected array $filesToExclude = [
        // strings with the file names ENDING IN, like: 'utilities/collection/collection.php'
    ];

    static public bool $replaced = false;

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

        $fileData = file_get_contents($this->data->target);<<<FILEDATA
            <?php

            use CouponURLS\Original\Exceptions\MyCustomException;

            function kug() {
                return [
                    'ignored' =>    new Exception,
                    'ignored x2' => new Exception(),
                    'Global' =>     new Exception(message: 'This is an exception!'),
                    'Custom' =>     new MyCustomException('This is an exception!')
                ];
            }

        FILEDATA;


        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {

            $ast = $parser->parse($fileData);

            $traverser = new NodeTraverser;
            $traverser->addVisitor(new class extends NodeVisitorAbstract {
                public function leaveNode(Node $node) {
                    if ($node instanceof Node\Expr\New_ && method_exists($node->class, 'toString') && i((string) $node->class)->endsWith('Exception', caseSensitive: false) && $node->args) {
                        EscapeAllExceptionCallsCompilerScript::$replaced = true;
                        $node->args = [
                            new FuncCall(
                                name: new Name('\esc_html'),
                                args: [
                                    // this is the string given to the exception constructor
                                    new Arg(
                                        value: $node->args[0]->value
                                    ),
                                ]
                            )
                        ];

                        return $node;
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (EscapeAllExceptionCallsCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dd("replacing _(): {$this->data->source}", $prettyPrinter->prettyPrintFile($ast));
                file_put_contents(
                    filename: $this->data->target, 
                    data: $prettyPrinter->prettyPrintFile($ast),
                );
                NamedArgumentCollectionCallsToAssociativeArrayCallsCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }
    }
    
}