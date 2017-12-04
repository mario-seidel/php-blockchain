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

namespace Mx\Blockchain\Tests\Entity\TextBlockchain;

use Mx\Blockchain\Entity\TextBlockchain\TextBlockchain;
use Mx\Blockchain\Entity\TextBlockchain\TextBlockData;
use PHPUnit\Framework\TestCase;

/**
 * Class TextBlockchainTest
 *
 * @package Mx\Blockchain\Tests\Entity\TextBlockchain
 * @author Mario Seidel <info@maniox.de>
 */
class TextBlockchainTest extends TestCase
{
    /**
     * @group unit
     */
    public function testCreateBlockchainHasCorrectGenesisBlock()
    {
        $blockchain = new TextBlockChain();

        $blocks = $blockchain->getBlocks();

        $this->assertSame(1, count($blocks));
        $this->assertInstanceOf(TextBlockData::class, $blocks[0]->getData());
        $this->assertSame('Genesis Block', $blocks[0]->getData()->getHashableData());
        $this->assertSame('', $blocks[0]->getPrevBlockHash());
        $this->assertNotEmpty($blocks[0]->getHash());
    }

    /**
     * @group unit
     */
    public function testBlockchainAddBlockCorrect()
    {
        $blockchain = new TextBlockchain();
        $blockchain->addBlock(TextBlockData::getInstance('foo'));

        $block = $blockchain->getBlocks()[1];
        $this->assertSame(2, count($blockchain->getBlocks()));
        $this->assertSame('foo', $block->getData()->getHashableData());
    }

    /**
     * @group unit
     */
    public function testBlockchainAddBlockData()
    {
        $blockchain = new TextBlockchain();
        $blockchain->addTextDataBlock('barbaz');

        $block = $blockchain->getBlocks()[1];
        $this->assertSame(2, count($blockchain->getBlocks()));
        $this->assertSame('barbaz', $block->getData()->getHashableData());
    }

    /**
     * @group unit
     */
    public function testHashChaining()
    {
        $blockchain = new TextBlockchain();
        $blockchain->addBlock(TextBlockData::getInstance('foo'));
        $blockchain->addBlock(TextBlockData::getInstance('bar'));

        $genBlock = $blockchain->getBlocks()[0];
        $block1 = $blockchain->getBlocks()[1];
        $block2 = $blockchain->getBlocks()[2];

        $this->assertSame(3, count($blockchain->getBlocks()));
        $this->assertSame($genBlock->getHash(), $block1->getPrevBlockHash());
        $this->assertSame($block1->getHash(), $block2->getPrevBlockHash());
    }
}
