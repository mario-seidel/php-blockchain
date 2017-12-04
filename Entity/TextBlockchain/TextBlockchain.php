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

namespace Mx\Blockchain\Entity\TextBlockchain;


use Mx\Blockchain\Entity\AbstractBlockchain;
use Mx\Blockchain\Entity\Block;
use Mx\Blockchain\Entity\BlockInterface;

/**
 * Class TextBlockchain
 *
 * @package Mx\Blockchain\Entity\TextBlockchain
 * @author Mario Seidel <info@maniox.de>
 */
class TextBlockchain extends AbstractBlockchain
{
    /**
     * @param string $textData
     *
     * @return bool
     */
    public function addTextDataBlock(string $textData): bool
    {
        return $this->addBlock(TextBlockData::getInstance($textData));
    }

    /**
     * @return BlockInterface
     */
    protected function generateGenesisBlock(): BlockInterface
    {
        return Block::generateBlock(
            TextBlockData::getInstance('Genesis Block'),
            ''
        );
    }
}