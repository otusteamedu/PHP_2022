<?

declare(strict_types=1);

namespace Kogarkov\Es\User\Domain\Model;

use Kogarkov\Es\User\Domain\ValueObject\Email;
use Kogarkov\Es\User\Domain\ValueObject\Phone;
use Kogarkov\Es\User\Domain\ValueObject\Age;

class UserModel
{
    private $id;
    private $email;
    private $phone;
    private $age;

    public function __construct(string $email, string $phone, int $age, int $id = null)
    {
        $this->email = new Email($email);
        $this->phone = new Phone($phone);
        $this->age = new Age($age);
        $this->id = $id;
    }

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getAge(): Age
    {
        return $this->age;
    }
}
