<?php

declare(strict_types=1);

namespace App\Infrastructure\Requests;

use App\Domain\Validator as AssertValidator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderRequest extends BaseRequest
{
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\CardScheme(
     *     schemes={"VISA","MASTERCARD"},
     *     message="Your credit card number is invalid."
     * )
     */
    private string $cardNumber;
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z -]+$/i",
     * )
     */
    private string $cardHolder;
    /**
     * @var string
     * @Assert\NotBlank
     * @AssertValidator\DateCard
     */
    private string $cardExpiration;
    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern = "/^[0-9]{3}$/i",
     * )
     */
    private string $cvv;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(max=16)
     */
    private string $orderNumber;

    /**
     * @var string
     * @Assert\NotBlank
     *  @Assert\Regex(
     *     pattern = "/^[0-9.]*$/i",
     * )
     */
    private string $sum;

    protected ValidatorInterface $validator;

    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $request = $requestStack->getCurrentRequest();

        $this->cardNumber = $request->get('card_number');
        $this->cardHolder = $request->get('card_holder');
        $this->cardExpiration = $request->get('card_expiration');
        $this->cvv = $request->get('cvv');
        $this->orderNumber = $request->get('order_number');
        $this->sum = $request->get('sum');

        $this->validator = $validator;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return OrderRequest
     */
    public function setCardNumber(string $cardNumber): OrderRequest
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    /**
     * @param string $cardHolder
     * @return OrderRequest
     */
    public function setCardHolder(string $cardHolder): OrderRequest
    {
        $this->cardHolder = $cardHolder;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiration(): string
    {
        return $this->cardExpiration;
    }

    /**
     * @param string $cardExpiration
     * @return OrderRequest
     */
    public function setCardExpiration(string $cardExpiration): OrderRequest
    {
        $this->cardExpiration = $cardExpiration;
        return $this;
    }

    /**
     * @return string
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @param int $cvv
     * @return OrderRequest
     */
    public function setCvv(string $cvv): OrderRequest
    {
        $this->cvv = $cvv;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     * @return OrderRequest
     */
    public function setOrderNumber(string $orderNumber): OrderRequest
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return (float) $this->sum;
    }

    /**
     * @param string $sum
     * @return OrderRequest
     */
    public function setSum(string $sum): OrderRequest
    {
        $this->sum = $sum;
        return $this;
    }

}