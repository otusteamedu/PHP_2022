<?php
namespace Rs\Rs\Dto;

class initFilterDto
{
    private ?string $title;
    private ?string $sku;
    private ?string $category;
    private ?int $low;
    private ?int $high;

    public function __construct()
    {
        $params=getopt("t:s:c:l:h:");
        $this->setTitle($params['t']);
        $this->setSku($params['s']);
        $this->setCategory($params['c']);
        $this->setLow($params['l']);
        $this->setHigh($params['h']);
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int|null
     */
    public function getLow(): ?int
    {
        return $this->low;
    }

    /**
     * @param int|null $low
     */
    public function setLow(?int $low): void
    {
        $this->low = $low;
    }

    /**
     * @return int|null
     */
    public function getHigh(): ?int
    {
        return $this->high;
    }

    /**
     * @param int|null $high
     */
    public function setHigh(?int $high): void
    {
        $this->high = $high;
    }
}