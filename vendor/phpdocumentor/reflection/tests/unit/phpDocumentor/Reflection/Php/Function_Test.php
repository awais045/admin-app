<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link http://phpdoc.org
 */

namespace phpDocumentor\Reflection\Php;

use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Location;
use phpDocumentor\Reflection\Metadata\MetaDataContainer as MetaDataContainerInterface;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

/** @property Function_ $fixture */
#[CoversClass(Function_::class)]
#[UsesClass('\phpDocumentor\Reflection\Php\Argument')]
#[UsesClass('\phpDocumentor\Reflection\DocBlock')]
#[UsesClass('\phpDocumentor\Reflection\Fqsen')]
final class Function_Test extends TestCase
{
    use MetadataContainerTestHelper;

    private Fqsen $fqsen;

    private DocBlock $docBlock;

    /**
     * Creates a new (empty) fixture object.
     */
    protected function setUp(): void
    {
        $this->fqsen = new Fqsen('\space\MyFunction()');
        $this->docBlock = new DocBlock('aa');
        $this->fixture = new Function_($this->fqsen, $this->docBlock);
    }

    private function getFixture(): MetaDataContainerInterface
    {
        return $this->fixture;
    }

    public function testGetName(): void
    {
        $this->assertEquals('MyFunction', $this->fixture->getName());
    }

    public function testAddAndGetArguments(): void
    {
        $argument = new Argument('firstArgument');
        $this->fixture->addArgument($argument);

        $this->assertEquals([$argument], $this->fixture->getArguments());
    }

    public function testGetFqsen(): void
    {
        $this->assertSame($this->fqsen, $this->fixture->getFqsen());
    }

    public function testGetDocblock(): void
    {
        $this->assertSame($this->docBlock, $this->fixture->getDocBlock());
    }

    public function testGetDefaultReturnType(): void
    {
        $function = new Function_($this->fqsen);
        $this->assertEquals(new Mixed_(), $function->getReturnType());
    }

    public function testGetReturnTypeFromConstructor(): void
    {
        $returnType = new String_();
        $function = new Function_($this->fqsen, null, null, null, $returnType);

        $this->assertSame($returnType, $function->getReturnType());
    }

    public function testGetHasReturnByReference(): void
    {
        $function = new Function_($this->fqsen);
        $this->assertSame(false, $function->getHasReturnByReference());
    }

    public function testGetHasReturnByReferenceFromConstructor(): void
    {
        $function = new Function_($this->fqsen, null, null, null, null, true);
        $this->assertSame(true, $function->getHasReturnByReference());
    }

    public function testLineAndColumnNumberIsReturnedWhenALocationIsProvided(): void
    {
        $fixture = new Function_($this->fqsen, $this->docBlock, new Location(100, 20), new Location(101, 20));
        $this->assertLineAndColumnNumberIsReturnedWhenALocationIsProvided($fixture);
    }
}
