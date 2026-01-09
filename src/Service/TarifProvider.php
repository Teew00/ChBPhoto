<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class TarifProvider
{
    private array $tarifs;

    public function __construct()
    {
        $data = Yaml::parseFile(__DIR__ . '/../../config/tarifs.yaml');
        $this->tarifs = $data['tarifs'] ?? [];
    }

    public function getAll(): array
    {
        return $this->tarifs;
    }

    public function get(string $id): ?array
    {
        return $this->tarifs[$id] ?? null;
    }
}