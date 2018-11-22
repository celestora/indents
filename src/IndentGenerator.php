<?php
namespace Maximizer\Indentations;
include_once "IndentParseException.php";

/**
* Class, that is used to generate indented strings from objects and arrays.
*/
class IndentGenerator
{

    private $tabs;
    
    /**
    * @param boolean $use_tabs - force tabs instead of spaces
    */
    function __construct($use_tabs = false)
    {
        $this->tabs = $use_tabs;
    }

    /**
    * Asserts correct array scheme
    * @param  array $arr - array
    * @throws IndentParseException
    * @return array
    */
    private function assertArrayValidity($arr)
    {
        if(!is_array($arr[0]))
            throw new IndentParseException("Root node must contain children");
        else if(sizeof($arr) > 1)
            throw new IndentParseException("Only one root node may be used!");
            
        return $arr;
    }

    /**
    * Recursive generation function.
    * @param array       $arr - array
    * @param integer     $depth - current tree depth, defaults to 0
    * @param NULL|string $result - pervious result
    * @returns generated string
    */
    function generateFromArray($arr, $depth = 0, $full = true)
    {
        $indents = str_repeat($this->tabs ? "\t" : "    ", $depth);
        $step    = "";

        foreach($arr as $key=>$value)
            $step .= is_integer($key) ? "$indents$value\n" : "$indents$key\n".$this->generateFromArray($value, ($depth + 1), false);
        
        return $full ? substr($step, 0, -1) : $step;
    }

    /**
    * Converts object to array and passes it to generateFromArray
    * @param object $obj - object
    * @see   IndentGenerator->generateFromArray
    * @returns generated string
    */
    function generateFromObject($obj)
    {
        return $this->generateFromArray($this->assertArrayValidity((array) $obj));
    }

    /**
    * Automatically defines strategy for generation, based on source type.
    * @param object|array $source - source
    * @see   IndentGenerator->generateFromObject
    * @see   IndentGenerator->generateFromArray
    * @returns generated string
    */
    function generate($source)
    {
        switch ($type = gettype($source)) {
            case "array":
                return $this->generateFromArray($source);

            case "object":
                return $this->generateFromObject($source);

            default:
                throw new IndentParseException("Source should be either be an array or an object, but not $type.");
        }
    }

}
