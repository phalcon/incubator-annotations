<?php

declare(strict_types=1);

use Dotenv\Dotenv;

Dotenv::createImmutable(codecept_root_dir('tests'))->load();
