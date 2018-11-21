<?php

require "../vendor/autoload.php";
use Maximizer\Indentations\IndentGenerator;
use Webmozart\Assert\Assert;

describe("IndentGenerator", function() {
    beforeEach(function() {
        $this->generator        = new IndentGenerator(false);
        $this->CORRECT_FILE     = "files/Animalia.xis";
        $this->CORRECT_STRING   = substr(file_get_contents($this->CORRECT_FILE), 0, -1);
        $this->CORRECT_SOURCE   = require("files/expected/correct.php");
    });

    describe("->generate()", function() {
        it("should correctly generate indented string from array", function() {
            $result = $this->generator->generate($this->CORRECT_SOURCE);
            Assert::true($result === $this->CORRECT_STRING, "expected correct result");
        });
    });
});
