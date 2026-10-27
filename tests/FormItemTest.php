<?php

namespace VX\Tests;

use PHPUnit\Framework\TestCase;
use VX;
use VX\UI\FormItem;

final class FormItemTest extends TestCase
{
    private function item(): FormItem
    {
        return new FormItem((new \ReflectionClass(VX::class))->newInstanceWithoutConstructor());
    }

    public function testAttributeWritesAreCompatibleWithTheParentElement(): void
    {
        $item = $this->item();
        self::assertNull($item->setAttribute('label', 'Username'));
        self::assertSame('Username', $item->getAttribute('label'));
        $item->setAttribute('required', true);
        self::assertTrue($item->hasAttribute('required'));
        $item->setAttribute('required', false);
        self::assertFalse($item->hasAttribute('required'));
    }

    public function testPropWritesStillEmitTheOriginalEvent(): void
    {
        $item = $this->item();
        $events = [];
        $item->addEventListener('prop_added', static function ($event) use (&$events) {
            $events[] = $event->detail['name'];
        });
        $item->setAttribute('label', 'Username');
        $item->setAttribute('prop', 'username');
        self::assertSame(['username'], $events);
        self::assertSame('username', $item->getAttribute('prop'));
    }

    public function testUserFormInputRetainsBindingAndRequiredAttribute(): void
    {
        $item = $this->item();
        $input = $item->input('username');
        self::assertSame('el-input', $input->tagName);
        self::assertSame('scope.form.username', $input->getAttribute('v-model'));
        self::assertSame('username', $item->getAttribute('prop'));
        self::assertSame($input, $input->required());
        self::assertTrue($item->hasAttribute('required'));
        self::assertStringContainsString('<el-input', (string) $item);
    }

    public function testFormItemRequiredRuleRemainsFluent(): void
    {
        $item = $this->item();
        $item->setLabel('Email');
        self::assertSame($item, $item->required());
        self::assertSame([['required' => true, 'message' => 'Email is required']], json_decode($item->getAttribute(':rules'), true));
    }
}
