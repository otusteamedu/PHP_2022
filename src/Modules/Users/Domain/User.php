<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\Modules\Users\Domain;

use Eliasjump\HwStoragePatterns\App\Exceptions\NoAttributeException;
use Exception;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 */
class User
{
    public function __construct(
        private int    $id = 0,
        private string $name = '',
        private string $email = '',
    )
    {
    }

    /**
     * @throws NoAttributeException
     */
    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new NoAttributeException($name);
        }
        return $this->$name;
    }

    /**
     * @throws NoAttributeException
     * @throws Exception
     */
    public function __set(string $name, mixed $value)
    {
        if ($name === 'id') {
            throw new Exception('You shouldn\'t change user ID directly');
        }

        if (!property_exists($this, $name)) {
            throw new NoAttributeException($name);
        }
        $this->$name = $value;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}