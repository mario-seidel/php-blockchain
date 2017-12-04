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

namespace Mx\Blockchain\Entity;


use Mx\Blockchain\Service\Sha256HashGenerator;
use Mx\Blockchain\Worker\ProofOfWork;

/**
 * Class Block
 *
 * @package Mx\Blockchain\Entity
 * @author Mario Seidel <info@maniox.de>
 */
class Block implements BlockInterface
{
    use Sha256HashGenerator;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var HashableBlockData
     */
    private $data;

    /**
     * @var string
     */
    private $prevBlockHash;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var int
     */
    private $nonce;

    /**
     * @param HashableBlockData $data
     * @param string            $prevBlockHash
     *
     * @return BlockInterface
     */
    public static function generateBlock(
        HashableBlockData $data, string $prevBlockHash): BlockInterface
    {
        $block = new self(
            time(),
            $data,
            $prevBlockHash
        );

        $proofOfWork = ProofOfWork::getInstance($block);
        list($nonce, $hash) = $proofOfWork->run();

        $block->nonce = $nonce;
        $block->hash = $hash;

        return $block;
    }

    /**
     * Block constructor.
     *
     * @param int $timestamp
     * @param HashableBlockData $data
     * @param string $prevBlockHash
     * @param string $hash
     * @param int $nonce
     */
    private function __construct(
        int $timestamp,
        HashableBlockData $data,
        string $prevBlockHash,
        string $hash = '',
        int $nonce = 0
    )
    {
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->prevBlockHash = $prevBlockHash;
        $this->hash = $hash;
        $this->nonce = $nonce;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return HashableBlockData
     */
    public function getData(): HashableBlockData
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getPrevBlockHash(): string
    {
        return $this->prevBlockHash;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}