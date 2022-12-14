<?php

namespace app\actions;

use app\EsSearcher;

class StatsAction extends Action {

    public function execute()
    {
        $searcher = new EsSearcher($this->index, $this->params);
        return $this->pretty($searcher->stats());
    }

    public function pretty($result): string
    {
        return 'В индексе '.$result['count'].' документов.'.PHP_EOL;
    }
}
