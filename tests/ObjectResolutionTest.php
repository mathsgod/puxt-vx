<?php

namespace VX\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use VX;
use VX\Model;
use VX\Module;

final class ObjectResolutionModel extends Model
{
    public mixed $constructedWith;

    public function __construct($id = null)
    {
        $this->constructedWith = $id;
    }
}

final class UnrelatedModuleClass
{
    public function __construct()
    {
        throw new \LogicException('An unrelated class must never be instantiated as a model.');
    }
}

final class ObjectResolutionTest extends TestCase
{
    private function vx(string $class): VX
    {
        $vx = (new ReflectionClass(VX::class))->newInstanceWithoutConstructor();
        $module = (new ReflectionClass(Module::class))->newInstanceWithoutConstructor();
        $module->class = $class;
        $vx->module = $module;
        $vx->object_id = 123;
        return $vx;
    }

    public function testUnrelatedClassWithMatchingModuleNameIsIgnored(): void
    {
        self::assertNull($this->vx(UnrelatedModuleClass::class)->object());
    }

    public function testUnknownClassIsIgnored(): void
    {
        self::assertNull($this->vx('MissingModuleClassForRegressionTest')->object());
    }

    public function testModelStillReceivesRequestedObjectId(): void
    {
        $model = $this->vx(ObjectResolutionModel::class)->object();
        self::assertInstanceOf(ObjectResolutionModel::class, $model);
        self::assertSame(123, $model->constructedWith);
    }
}
