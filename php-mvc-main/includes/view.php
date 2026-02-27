<?php

declare(strict_types=1);

function renderView(string $tpl, array $data = []): void
{
    if (!empty($data) && is_array($data)) {
        extract($data, EXTR_SKIP);
    }
    include TEMPLATES_DIR . '/' . $tpl . '.php';}