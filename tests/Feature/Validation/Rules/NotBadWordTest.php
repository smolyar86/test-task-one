<?php

namespace Tests\Feature\Validation\Rules;

use App\Validation\Rules\NotBadWord;
use PHPUnit\Framework\TestCase;

class NotBadWordTest extends TestCase
{
    private NotBadWord $rule;

    public function setUp(): void
    {
        parent::setUp();
        $this->rule = new NotBadWord(['foo', 'baz']);
    }

    public function testValidate()
    {
        $this->assertFalse($this->rule->validate('word FoO'));
        $this->assertFalse($this->rule->validate('BaZword'));
        $this->assertTrue($this->rule->validate('word'));
        $this->assertTrue($this->rule->validate(''));
    }
}
