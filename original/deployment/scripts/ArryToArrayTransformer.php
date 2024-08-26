<?php

namespace CouponURLS\Original\Deployment\Scripts;

use CouponURLS\Original\Characters\StringManager;
use CouponURLS\Original\Deployment\Files\FileVersions;
use CouponURLS\Original\Deployment\Transformers\Abilities\Transformable;
use CouponURLS\Original\Deployment\Transformers\Abilities\ValidatableTransformable;
use CouponURLS\Original\Deployment\Transformers\Attributes\NotVendor;
use CouponURLS\Original\Deployment\Transformers\Attributes\OnlyExtensions;
use CouponURLS\Original\Validation\Validator;
use CouponURLS\Original\Validation\Validators;
use CouponURLS\Original\Validation\Validators\ValidWhen;
use Error;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;

use function CouponURLS\Original\Utilities\Collection\{a, _};
use function CouponURLS\Original\Utilities\Text\i;

#[OnlyExtensions(['.php'])]
#[NotVendor]
class ArryToArrayTransformer implements Transformable, ValidatableTransformable
{
    static public bool $replaced = false;

    public function canBeTransformed(StringManager $fileContents, FileVersions $fileVersions): Validator
    {
        return new Validators([
            new ValidWhen(!$fileContents->matchesRegEx('/namespace\s+\w+/i'))
        ]);
    } 

    public function transform(StringManager $fileContents, FileVersions $fileVersions): StringManager
    {
        $fileData = $fileContents;<<<FILEDATA
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
            $ast = $parser->parse((string) $fileData);

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
                return i($prettyPrinter->prettyPrintFile($ast));
                ArryToArrayCompilerScript::$replaced = false;
            }
        } catch (Error $error) {
            dd("Parse error: {$error->getMessage()}\n");
        }

        return $fileContents;
    } 
}