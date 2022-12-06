<?php

namespace App\Adapter;

interface FileGeneratorAdapterInterface
{
    public function createDownloadFile(string $storage, array $reportData): string;

    public function getFilePath(string $storage, string $directory, string $file): string;
}
