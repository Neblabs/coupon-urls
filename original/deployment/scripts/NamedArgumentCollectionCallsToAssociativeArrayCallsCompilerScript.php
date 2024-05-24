<?php

namespace CouponURLs\Original\Deployment\Scripts;

use CouponURLs\Original\Deployment\Script;
use Error;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

use function CouponURLs\Original\Utilities\Collection\{_, a};
use function CouponURLs\Original\Utilities\Text\i;

Class NamedArgumentCollectionCallsToAssociativeArrayCallsCompilerScript extends Script
{
    public const METHOD_NAMES = [
        'mapUsing',
        'perform',
        'allPass',
        'getThoseThat',
        'getMethodNameAndValueFromVariableParameters',
        'findTheOneThat'
    ];

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
                    (new RandomObjectwithTheSameMethoName)->getThoseThat(
                        areValid: 'yes'
                    ),
                    (new CouponURLs\Original\Collections\Collection([]))->getThoseThat(
                        areValid: 'yes'
                    ),
                    //also case insensitive
                    (new CouponURLs\Original\Collections\Collection([]))->getthosethat(
                        areValid: 'yes'
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
                    if (
                        $node instanceof MethodCall 
                        && 
                        method_exists($node->name, 'toString') 
                        && 
                        i($node?->name->toString())->toLowerCase()->isEither(_(NamedArgumentCollectionCallsToAssociativeArrayCallsCompilerScript::METHOD_NAMES)->map(fn($methodname) => strtolower($methodname))->asArray()) 
                        &&
                        ($node->args[0] ?? false)
                        && 
                        !empty($node->args[0]->name?->name)
                    ) {
                        (string) $functionName = 'neblabs_collection';

                        NamedArgumentCollectionCallsToAssociativeArrayCallsCompilerScript::$replaced = true;

                        $node->args = [
                            new Array_(
                                items: [
                                    new ArrayItem(
                                        value: $node->getArgs()[0]->value,
                                        key: new Node\Scalar\String_($node->getArgs()[0]->name)
                                    )
                                ],
                                attributes: a(
                                    kind: Array_::KIND_SHORT
                                )
                            )
                        ];

                        return $node;
                        //dump($node->args);
                    }
                }
            });

            $ast = $traverser->traverse($ast);

            if (NamedArgumentCollectionCallsToAssociativeArrayCallsCompilerScript::$replaced) {
                $prettyPrinter = new Standard([]);
                //dump("replacing _(): {$this->data->source}", /*$prettyPrinter->prettyPrintFile($ast)*/);
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