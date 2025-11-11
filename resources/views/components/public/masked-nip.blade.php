@props(['nip'])

@php
    /**
     * Mask NIP for public display.
     * Rules:
     * - Keep only digits for masking logic but preserve original formatting if present.
     * - If digits length >= 18: replace first 8 digits with asterisks and keep the rest.
     * - Otherwise: mask all but last 4 digits (if >=4), or fully mask short values.
     */

    $raw = (string) $nip;
    // Extract digits only for decision, but we'll keep original non-digit separators out of output.
    $digits = preg_replace('/\D+/', '', $raw);

    if (strlen($digits) >= 18) {
        $maskedDigits = str_repeat('*', 8) . substr($digits, 8);
    } elseif (strlen($digits) >= 4) {
        $maskedDigits = str_repeat('*', max(0, strlen($digits) - 4)) . substr($digits, -4);
    } else {
        $maskedDigits = str_repeat('*', strlen($digits));
    }

    // Optionally format masked digits for readability: group in 4s
    $grouped = trim(chunk_split($maskedDigits, 4, ' '));
@endphp

<span class="font-mono" title="NIP disensor untuk melindungi data pribadi">NIP. {{ $grouped }}</span>
