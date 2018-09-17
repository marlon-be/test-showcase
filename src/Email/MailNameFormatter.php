<?php

namespace App\Email;

final class MailNameFormatter
{
    public static function formatName(string $name) : string
    {
        $lower = \strtolower($name);
        $spaced = \str_replace(['.', '-', '_'], ' ', $lower);
        $parts = \explode(' ', $spaced);
        $capitalized = \array_map(
            function (string $part) : string {
                return \ucfirst($part);
            },
            \array_filter($parts)
        );

        return \implode(' ', $capitalized);
    }
}
