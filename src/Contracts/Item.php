<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Make\Postman\Contracts;

/**
 * \Playground\Make\Postman\Contracts\e
 */
interface Item
{
    public function name(): string;

    /**
     * @return array<int, Item>
     */
    public function item(): array;
}
