<?php

namespace Patterns\Observer;

class HeadHunter implements ObservablesInterface
{

    public array $vacancies;

    public array $subscribes;

    public function addVacancy(string $vacancy)
    {
        $this->vacancies[] = $vacancy;

        if (!empty($this->subscribes)) {
            $this->notifyObservers();
        }
    }

    public function addObserver(ObserverInterface $observer): void
    {
        $this->subscribes[] = $observer;
    }

    public function removeObserver(ObserverInterface $observer): void
    {
        while (($i = array_search($observer, $this->subscribes)) !== false) {
            unset($this->subscribes[$i]);
        }
    }

    public function notifyObservers(): void
    {
        /** @var Subscriber $subscriber */
        foreach ($this->subscribes as $subscriber) {
            $subscriber->handleEvent($this->vacancies);
        }
    }
}
