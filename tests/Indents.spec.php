<?php

require "../vendor/autoload.php";
use Maximizer\Indentations\Indents;
use Webmozart\Assert\Assert;

describe("Indents", function() {
    beforeEach(function() {
        $this->parser = new Indents;
        $this->CORRECT_FILE     = "files/Animalia.xis";
        $this->INCORRECT_FILE   = "files/Animalia-broken.xis";
        $this->CORRECT_STRING   = file_get_contents($this->CORRECT_FILE);
        $this->INCORRECT_STRING = file_get_contents($this->INCORRECT_FILE);
        $this->CORRECT_RESULT   = require("files/expected/correct.php");
    });
    
    describe("->parseFromString()", function() {
        it("should parse valid string", function() {
            $result = $this->parser->parseFromString($this->CORRECT_STRING, Indents::TO_ASSOC);
            Assert::true($result === $this->CORRECT_RESULT, "expected correct result");
        });
        
        it("should throw exception on invalid strings", function() {
            try {
                $result = $this->parser->parseFromString($this->INCORRECT_STRING, Indents::TO_ASSOC);
            } catch(Exception $e) {
                $thrown = true;
            } finally {
                Assert::true($thrown, "expected IndentParseException");
            } 
        });
    });
    
    describe("->parseFromFile()", function() {
        it("should parse valid file", function() {
            $result = $this->parser->parseFromFile($this->CORRECT_FILE, Indents::TO_ASSOC);
            assert($result == $this->CORRECT_RESULT, "expected correct result");
        });
        
        it("should throw exception on invalid files", function() {
            try {
                $result = $this->parser->parseFromFile($this->INCORRECT_FILE, Indents::TO_ASSOC);
            } catch(Exception $e) {
                $thrown = true;
            } finally {
                Assert::true($thrown, "expected IndentParseException");
            }            
        });
    });
});
