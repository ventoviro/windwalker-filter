<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Filter\Rule;

use Windwalker\Filter\AbstractCallbackFilter;
use Windwalker\Filter\AbstractFilter;
use Windwalker\Utilities\TypeCast;

/**
 * The ToArray class.
 */
class CastTo extends AbstractFilter
{
    protected string $type;

    protected bool $strict;

    /**
     * Type constructor.
     *
     * @param  string  $type
     * @param  bool    $strict
     */
    public function __construct(string $type, bool $strict = false)
    {
        $this->type   = $type;
        $this->strict = $strict;
    }

    /**
     * @inheritDoc
     */
    public function filter($value)
    {
        return TypeCast::try($value, $this->type, $this->strict);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param  string  $type
     *
     * @return  static  Return self to support chaining.
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * @param  bool  $strict
     *
     * @return  static  Return self to support chaining.
     */
    public function setStrict(bool $strict)
    {
        $this->strict = $strict;

        return $this;
    }
}
