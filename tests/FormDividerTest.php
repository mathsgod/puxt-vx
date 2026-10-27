<?php

namespace VX\Tests;

use PHPUnit\Framework\TestCase;
use VX;
use VX\UI\Form;

final class FormDividerTest extends TestCase
{
    private function form(): Form
    {
        return new Form((new \ReflectionClass(VX::class))->newInstanceWithoutConstructor());
    }

    public function testDividerWithoutContentRendersAnEmptyElement(): void
    {
        $form = $this->form();
        $divider = $form->addDivider();
        self::assertSame('el-divider', $divider->tagName);
        self::assertSame('', $divider->textContent);
        self::assertSame($form, $divider->parentNode);
        self::assertStringContainsString('<el-divider', (string) $form);
    }

    public function testExplicitNullAndEmptyStringRemainSupported(): void
    {
        $form = $this->form();
        self::assertSame('', $form->addDivider(null)->textContent);
        self::assertSame('', $form->addDivider('')->textContent);
    }

    public function testLabelIsTextAndReturnedDividerCanStillBeConfigured(): void
    {
        $form = $this->form();
        $divider = $form->addDivider('登入 <settings>');
        $divider->setContentPosition('left');
        self::assertSame('登入 <settings>', $divider->textContent);
        self::assertSame('left', $divider->getAttribute('content-position'));
        self::assertStringContainsString('&lt;settings&gt;', (string) $divider);
        self::assertSame(0, $divider->childElementCount);
    }
}
