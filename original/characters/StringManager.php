<?php

namespace CouponURLs\Original\Characters;

use DateTime;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Collections\ArrayGetter;
use CouponURLs\Original\Collections\Mapper\Types;
use Collator;
use JsonSerializable;
use PHPUnit\TestRunner\TestResult\Collector;
use stdClass;
use Stringy\Stringy;

Class StringManager extends Stringy implements JsonSerializable
{
    public static function isStringRepresentation($value)
    {
        return is_string($value) || ($value instanceof static) || (is_object($value) && method_exists($value, '__toString'));
    } 
    
    public function isEmpty()
    {
        return $this->trim()->length() === 0;
    }

    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    public function hasValue()
    {
        return $this->isNotEmpty();
    }

    public function is($text, $caseInsensitive = false)
    {
        if (is_array($text)) {
            return false;
        }

        if ($caseInsensitive) {
            return strtolower($this->get()) === strtolower((string) $text);
        }

        return $this->get() === ((string) $text);
    }

    public function isNot($text, $caseInsensitive = false)
    {
        return !$this->is($text, $caseInsensitive);
    }

    public function isEither(/*ArrayRepresentation*/ $strings)
    {
        $strings = ArrayGetter::getArrayOrThrowExceptionFrom($strings);
        
        (object) $strings = new Collection($strings);
        return $strings->contain((string) $this->toLowerCase()->get());        
    }

    public function isNotEither(/*ArrayRepresentation*/ $strings)
    {
        return !$this->isEither($strings);        
    }

    public function get() : string
    {
        return (string) $this; 
    }

    public function explode($separator, $limit = null) : Collection
    {
        return (new Collection(explode($separator, $this->get())))
                   ->map(function($piece){return new StringManager($piece);})
                   ->filter(
                    function(StringManager $piece){
                        return $piece->trim()->hasValue();
                    }
        );   
    }

    public function getAlphanumeric() : static
    {
        return $this->getOnly('A-Za-z0-9_\s');
    }

    /**
     * todo: recursively convert all inner array matches to collection
     * and recursively convert all strings to StringManager
     * 
     */
    public function allMatches(string|StringManager $pattern) : Collection
    {
        (array) $matches = [];

        preg_match_all(
            pattern: (string) $pattern,
            subject: $this->get(),
            matches: $matches
        );

        return (new Collection($matches))->removeFirst()->getValues();
    }

    public function matches(string|StringManager $pattern) : Collection
    {
        (array) $matches = [];

        preg_match(
            pattern: (string) $pattern,
            subject: $this->get(),
            matches: $matches
        );

        return (new Collection($matches))->removeFirst()->getValues();
    }

    public function matchesRegEx(string|StringManager $pattern) : bool
    {
        $r = preg_match_all($pattern, $this->str);

        return $r > 0; 
    }

    public function replaceRegEx($pattern, /*string|array|callable*/ $replacement) : static
    {
        if (is_callable($replacement)) {
            $result = preg_replace_callback($pattern, $replacement, $this->get());
        } else {
            $result = preg_replace($pattern, $replacement, $this->get());
        }

        return new static($result);   
    }
    
    public function getOnly($pattern) : static
    {
        return $this->replaceRegEx("/[^{$pattern}]/", '');
    }

    public function decodeUrl() : static
    {
        return new static(urldecode($this->get()));   
    }

    public function isDate($format)
    {
         (object) $date = DateTime::createFromFormat($format, $this->get());
    
        return ($date instanceof DateTime) && ($date->format($format) === $this->get());   
    }

    public function import() : static|Collection|stdClass|bool|null
    {
        /*mixed*/ $decodedData = json_decode((string) $this, associative: true);

        return match(gettype($decodedData)) {
            'string' => new static($decodedData),
            'array' => new Collection($decodedData),
            default => $decodedData
        };
    }

    public function jsonSerialize() : mixed
    {
        return $this->str;   
    }

    public static function convertToLowerCase()
    {
        return function($value) {
            if (Types::isString($value)) {
                return strtolower((string) $value);
            }

            return $value;
        };   
    }
 
    public static function stringToNative($value)
    {
        if ($value instanceof StringManager) {
            return (string) $value;
        } elseif (is_array($value) || $value instanceof Collection) {
            (object) $valueCollection = is_array($value)? new Collection($value) : $value;

            (object) $convertedCollection = $valueCollection->map(function($value) {
                return static::stringToNative($value);
            });

            return is_array($value)? $convertedCollection->asArray() : $convertedCollection;
        }
        
        return $value;
    }   

}