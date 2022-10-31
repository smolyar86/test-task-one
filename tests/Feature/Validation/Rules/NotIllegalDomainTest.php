<?php

namespace Tests\Feature\Validation\Rules;

use App\Validation\Rules\NotIllegalDomain;
use PHPUnit\Framework\TestCase;

class NotIllegalDomainTest extends TestCase
{
    private NotIllegalDomain $rule;

    public function setUp(): void
    {
        parent::setUp();
        $this->rule = new NotIllegalDomain(['domain.com', 'domain.org']);
    }

    public function testValidate()
    {
        $this->assertFalse($this->rule->validate('mail@domain.com'));
        $this->assertFalse($this->rule->validate('info@domain.org'));
        $this->assertTrue($this->rule->validate('user@domain.en'));
        $this->assertFalse($this->rule->validate('user'));
        $this->assertFalse($this->rule->validate(''));
    }
}
