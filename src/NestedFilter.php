<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Filter;

use Windwalker\Filter\Exception\ValidateException;
use Windwalker\Utilities\Arr;
use Windwalker\Utilities\TypeCast;

use function DI\create;

/**
 * The NestedFilter class.
 */
class NestedFilter extends AbstractFilter
{
    protected array $map = [];

    /**
     * NestedFilter constructor.
     *
     * @param  array  $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @inheritDoc
     */
    public function filter($value)
    {
        $paths = \Windwalker\collect(TypeCast::toArray($value))
            ->flatten()
            ->keys();

        foreach ($paths as $path) {
            if (Arr::has($this->map, $path)) {
                /** @var FilterInterface $filter */
                $filter = Arr::get($this->map, $path);

                $v = &Arr::get($value, $path);

                $v = $filter->filter($v);
            }
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function test($value, bool $strict = false): bool
    {
        $paths = \Windwalker\collect(TypeCast::toArray($value))
            ->flatten()
            ->keys();

        foreach ($paths as $path) {
            try {
                if (Arr::has($this->map, $path)) {
                    /** @var ValidatorInterface $filter */
                    $filter = Arr::get($this->map, $path);

                    if (!$filter->test(Arr::get($value, $path))) {
                        throw ValidateException::create(
                            $filter,
                            'Validator: ' . $filter::class . ' returns false, value is: ' . get_debug_type($value)
                        );
                    }
                }
            } catch (ValidateException $e) {
                throw ValidateException::create(
                    $e->getValidator(),
                    sprintf('Field "%s" not match - %s', $path, $e->getMessage()),
                    $e->getCode(),
                    $e
                );
            }
        }

        return true;
    }
}
