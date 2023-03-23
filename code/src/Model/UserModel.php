<?

declare(strict_types=1);

namespace Kogarkov\Es\Model;

class UserModel implements \JsonSerializable
{
    private $id;
    private $email;
    private $phone;
    private $age;

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAge(): int
    {
        return (int)$this->age;
    }

    public function setId($id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email): UserModel
    {
        $this->email = $email;
        return $this;
    }

    public function setPhone($phone): UserModel
    {
        $this->phone = $phone;
        return $this;
    }

    public function setAge($age): UserModel
    {
        $this->age = $age;
        return $this;
    }

    public function fromJson(string $data): UserModel
    {
        $user = json_decode($data, true);
        if (empty($user['email'])) {
            throw new \Exception('email is empty');
        }
        if (empty($user['phone'])) {
            throw new \Exception('phone is empty');
        }
        if (empty($user['age'])) {
            throw new \Exception('age is empty');
        }
        $this->id = $user['id'];
        $this->email = $user['email'];
        $this->phone = $user['phone'];
        $this->age = $user['age'];

        return $this;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'age' => $this->age
        ];
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
