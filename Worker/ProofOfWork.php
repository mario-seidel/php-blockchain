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

namespace Mx\Blockchain\Worker;


use Mx\Blockchain\Entity\Block;
use Mx\Blockchain\Service\Sha256HashGenerator;

/**
 * Class ProofOfWork
 *
 * @package Mx\Blockchain\Worker
 * @author Mario Seidel <info@maniox.de>
 */
class ProofOfWork
{
    use Sha256HashGenerator;

    const targetBits = 20;
    const maxNonce = PHP_INT_MAX;

    /**
     * @var Block
     */
    protected $block;

    /**
     * @var int
     */
    protected $target;

    /**
     * ProofOfWork constructor.
     *
     * @param Block $block
     * @param float $target
     */
    private function __construct(Block $block, float $target)
    {
        $this->block = $block;
        $this->target = $target;
    }

    /**
     * @param Block $block
     *
     * @return ProofOfWork
     */
    public static function getInstance(Block $block): self
    {
        $target = 1;
        $target = bcmul($target, bcpow(2, 256 - self::targetBits));

//        $target = $target << (256 - self::targetBits);

        return new self($block, (float)$target);
    }

    /**
     * @return array
     */
    public function run(): array
    {
        $nonce = 0;

        echo 'Mining the block containing data: ' . $this->block->getData();
        while ($nonce < self::maxNonce) {
            $data = $this->prepareData($nonce);
            $hash = $this->generateSha256Hash($data);
//            echo "\r $hash\n";
            $hashInt = hexdec($hash);
            if ($hashInt < $this->target) {
                break;
            } else {
                $nonce++;
            }
        }
        $data = $this->prepareData($nonce);
        $hash = $this->generateSha256Hash($data);
        echo "\n\n";

        return [$nonce, $hash];
    }

    /**
     * @param int $nonce
     *
     * @return string
     */
    protected function prepareData(int $nonce): string
    {
        $data = implode('', [
            $this->block->getPrevBlockHash(),
            $this->block->getData()->getHashableData(),
            dechex($this->block->getTimestamp()),
            dechex(self::targetBits),
            dechex($nonce)
        ]);

        return $data;
    }

}