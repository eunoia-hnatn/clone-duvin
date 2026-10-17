<?php

declare(strict_types=1);

/** Escape plain fixture values at the HTML output boundary. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function money(int $amount): string
{
    return number_format($amount, 0, ',', '.');
}


/** Attributes originate from trusted local presentation fixtures. */
function htmlAttributes(array $attributes): string
{
    $html = [];
    foreach ($attributes as $name => $value) {
        if (!preg_match('/^[a-zA-Z_:][a-zA-Z0-9_:.-]*$/D', (string) $name)) {
            throw new InvalidArgumentException('Invalid HTML attribute name.');
        }
        $html[] = $value === null ? e($name) : e($name) . '="' . e($value) . '"';
    }
    return implode(' ', $html);
}
