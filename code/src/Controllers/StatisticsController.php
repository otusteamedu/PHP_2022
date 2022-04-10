<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\Models\Statistics;

class StatisticsController extends Statistics
{
    /**
     * @param ElasticSearchController $elasticSearchController
     *
     * @return array
     */
    public function getAllChannelsInfo(ElasticSearchController $elasticSearchController): array
    {
        return parent::getAllChannelsInfo($elasticSearchController);
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     * @param int                     $limit
     *
     * @return array
     */
    public function getTopRatedChannels(ElasticSearchController $elasticSearchController, int $limit = 3): array
    {
        return parent::getTopRatedChannels($elasticSearchController, $limit);
    }
}
