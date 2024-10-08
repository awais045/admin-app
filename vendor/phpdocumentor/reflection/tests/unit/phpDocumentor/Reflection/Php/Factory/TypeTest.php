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

namespace phpDocumentor\Reflection\Php\Factory;

use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Intersection;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\String_;
use PhpParser\Node\Identifier;
use PhpParser\Node\IntersectionType;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\UnionType;
use PHPUnit\Framework\Attributes\CoversClass;
use PhpUnit\Framework\TestCase as PhpUnitTestCase;

#[CoversClass(Type::class)]
final class TypeTest extends PhpUnitTestCase
{
    public function testReturnsNullWhenNoTypeIsPassed(): void
    {
        $factory = new Type();

        $result = $factory->fromPhpParser(null);

        $this->assertNull($result);
    }

    public function testReturnsReflectedType(): void
    {
        $factory = new Type();
        $given = new Name('integer');
        $expected = new Integer();

        $result = $factory->fromPhpParser($given);

        $this->assertEquals($expected, $result);
    }

    public function testReturnsNullableTypeWhenPassedAPhpParserNullable(): void
    {
        $factory = new Type();
        $given = new NullableType(new Identifier('integer'));
        $expected = new Nullable(new Integer());

        $result = $factory->fromPhpParser($given);

        $this->assertEquals($expected, $result);
    }

    public function testReturnsUnion(): void
    {
        $factory = new Type();
        $given = new UnionType([new Identifier('integer'), new Identifier('string')]);
        $expected = new Compound([new Integer(), new String_()]);

        $result = $factory->fromPhpParser($given);

        $this->assertEquals($expected, $result);
    }

    public function testReturnsUnionGivenVariousTypes(): void
    {
        $factory = new Type();
        $given = new UnionType(['integer', new Name('string'), new Identifier('float')]);
        $expected = new Compound([new Integer(), new String_(), new Float_()]);

        $result = $factory->fromPhpParser($given);

        $this->assertEquals($expected, $result);
    }

    public function testReturnsInterseptionType(): void
    {
        $factory = new Type();
        $given = new IntersectionType(['integer', new Name('string')]);
        $expected = new Intersection([new Integer(), new String_()]);

        $result = $factory->fromPhpParser($given);

        self::assertEquals($expected, $result);
    }
}
