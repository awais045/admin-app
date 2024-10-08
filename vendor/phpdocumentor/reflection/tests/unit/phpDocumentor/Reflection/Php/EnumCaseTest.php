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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumCase::class)]
final class EnumCaseTest extends TestCase
{
    use MetadataContainerTestHelper;

    private EnumCase $fixture;

    private Fqsen $fqsen;

    private DocBlock $docBlock;

    /**
     * Creates a new (emoty) fixture object.
     */
    protected function setUp(): void
    {
        $this->fqsen    = new Fqsen('\Enum::VALUE');
        $this->docBlock = new DocBlock('');

        $this->fixture = new EnumCase($this->fqsen, $this->docBlock);
    }

    private function getFixture(): MetaDataContainerInterface
    {
        return $this->fixture;
    }

    public function testGettingName(): void
    {
        $this->assertSame($this->fqsen->getName(), $this->fixture->getName());
    }

    public function testGettingFqsen(): void
    {
        $this->assertSame($this->fqsen, $this->fixture->getFqsen());
    }

    public function testGettingDocBlock(): void
    {
        $this->assertSame($this->docBlock, $this->fixture->getDocBlock());
    }

    public function testGetValue(): void
    {
        $this->assertNull($this->fixture->getValue());
    }

    public function testGetLocationReturnsDefault(): void
    {
        self::assertEquals(new Location(-1), $this->fixture->getLocation());
    }
}
