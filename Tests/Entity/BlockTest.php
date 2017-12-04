<?php
/**
 * Copyright (c) 2017 Mario Seidel
 * Permission is hereby granted, free of charge, to any person obtaininga copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace Mx\Blockchain\Test\Entity;

use Mx\Blockchain\Entity\Block;
use Mx\Blockchain\Entity\TextBlockchain\TextBlockData;
use PHPUnit\Framework\TestCase;

/**
 * Class BlockTest
 *
 * @package Mx\Blockchain\Test\Entity
 * @author Mario Seidel <info@maniox.de>
 */
class BlockTest extends TestCase
{

    public function testGenerateBlock()
    {
        $textBlock = TextBlockData::getInstance('foobar');
        $time = time();
        $block = Block::generateBlock($textBlock, '123456');

        $this->assertSame('123456', $block->getPrevBlockHash());
        $this->assertSame($textBlock, $block->getData());
        $this->assertEquals($time, $block->getTimestamp());
        $this->assertStringStartsWith('00000', $block->getHash());
        $this->assertSame(64, strlen($block->getHash()));
    }

}
