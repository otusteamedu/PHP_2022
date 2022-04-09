<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\Models\Statistics;

class StatisticsController
{
    /**
     * @var Statistics
     */
    protected Statistics $statistics;

    public function __construct()
    {
        $this->statistics = new Statistics();
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     *
     * @return array
     */
    public function getAllChannelsInfo(ElasticSearchController $elasticSearchController): array
    {
        return $this->statistics->getAllChannelsInfo($elasticSearchController);
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     * @param int                     $limit
     *
     * @return array
     */
    public function getTopRatedChannels(ElasticSearchController $elasticSearchController, int $limit = 3): array
    {
        return $this->statistics->getTopRatedChannels($elasticSearchController, $limit);
    }
}
