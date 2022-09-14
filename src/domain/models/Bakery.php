<?php

namespace Mselyatin\Patterns\domain\models;

use Mselyatin\Patterns\Application;
use Mselyatin\Patterns\domain\collections\valueObjects\CompositionBakeryCollection;
use Mselyatin\Patterns\domain\constants\ReadinessStatusConstants;
use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\interfaces\observer\PublisherInterface;
use Mselyatin\Patterns\domain\traits\observer\ObserverTrait;
use Mselyatin\Patterns\domain\valueObjects\bakery\BakeryTypeValue;
use Mselyatin\Patterns\domain\valueObjects\bakery\BunValueObject;
use Mselyatin\Patterns\domain\valueObjects\products\ReadinessStatusValue;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Bakery implements BakeryInterface, PublisherInterface
{
    use ObserverTrait;

    /**
     * Тип хлебобулочного изделия
     * @var BakeryTypeValue
     */
    protected BakeryTypeValue $type;

    /**
     * Статус готовности
     * @var ReadinessStatusValue
     */
    protected ReadinessStatusValue $status;

    /** @var CollectionInterface  */
    protected CollectionInterface $compositionBakeryCollection;

    /**
     * @param BakeryTypeValue $type
     * @param ReadinessStatusValue $status
     * @param CollectionInterface $compositionBakeryCollection
     */
    public function __construct(
        BakeryTypeValue $type,
        ReadinessStatusValue $status = new ReadinessStatusValue(ReadinessStatusConstants::WAIT),
        CollectionInterface $compositionBakeryCollection = new CompositionBakeryCollection()
    ) {
        $this->type = $type;
        $this->status = $status;
        $this->compositionBakeryCollection = $compositionBakeryCollection;
        $this->initDefaultComposition();
        $this->initListeners();
    }

    /**
     * @return BakeryTypeValue
     */
    public function getType(): BakeryTypeValue
    {
       return $this->type;
    }

    /**
     * @return CollectionInterface
     */
    public function getComposition(): CollectionInterface
    {
        return $this->compositionBakeryCollection;
    }

    /**
     * @param BakeryTypeValue $type
     * @param CollectionInterface $compositionBakeryCollection
     * @return Bakery
     */
    public static function make(
        BakeryTypeValue $type,
        ReadinessStatusValue $status = new ReadinessStatusValue(ReadinessStatusConstants::WAIT),
        CollectionInterface $compositionBakeryCollection = new CompositionBakeryCollection()
    ): self {
        return new self(
            $type,
            $status,
            $compositionBakeryCollection
        );
    }

    /**
     * @param ReadinessStatusValue $readinessStatusValue
     * @return void
     */
    public function setStatus(ReadinessStatusValue $readinessStatusValue): void
    {
        if ($readinessStatusValue->getValue() !== $this->status->getValue()) {
            $this->status = $readinessStatusValue;
            $this->notifySubscribers($this);
        }
    }

    /**
     * @return ReadinessStatusValue
     */
    public function getStatus(): ReadinessStatusValue
    {
        return $this->status;
    }

    /**
     * Добавляем в состав по умолчанию обязательные продукты
     * @return void
     */
    protected function initDefaultComposition(): void
    {
        $item = BunValueObject::make();
        if (!$this->compositionBakeryCollection->hasItem($item)) {
            $this->compositionBakeryCollection->add($item);
        }
    }

    /**
     * Подгрузка слушателей на события
     *
     * @todo Очень долго думал над тем, как весить события, это пришло самое оптимальное решение, но оно мне не нравится.
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function initListeners(): void
    {
        /** @var CollectionInterface $listeners */
        $listeners = Application::$container->get('bakeryListeners');
        $subscriber = $listeners->current();
        do {
            $this->subscribe($subscriber);
        } while($subscriber = $listeners->next());
    }
}