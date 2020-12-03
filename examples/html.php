<?php

declare(strict_types=1);

function asLink(?string $title = null, array $attributes = []): callable
{
    return function (string $link) use ($title, $attributes): string {
        return sprintf(
            '<a href="%s" %s>%s</a>',
            $link,
            ! empty($attributes) ? parseAttributeArray($attributes) : '',
            $title ?? $link
        );
    };
}

function parseAttributeArray(array $attributes): string
{
    return array_reduce(
        array_keys($attributes),
        function ($string, $attributeKey) use ($attributes): string {
            return sprintf(
                "%s %s='%s' ",
                $string,
                (string) $attributeKey,
                $attributes[$attributeKey]
            );
        },
        ''
    );
}
