<?php

namespace KonstantinDmitrienko\App\Interfaces;

interface StorageInterface
{
    /**
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array;

    /**
     * @param array $data
     *
     * @return array
     */
    public function add(array $data): array;

    /**
     * @param string $index
     * @param string $id
     *
     * @return array
     */
    public function delete(string $index, string $id): array;
}
