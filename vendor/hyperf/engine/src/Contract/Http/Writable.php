<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Engine\Contract\Http;

interface Writable
{
    public function getSocket(): mixed;

    public function write(string $data): bool;

    public function end(?string $content = null): bool;
}
