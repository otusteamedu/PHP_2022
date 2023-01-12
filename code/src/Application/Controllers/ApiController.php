<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Services\EnquiriesServices;
use Otus\App\Application\Viewer\View;

class ApiController
{
    public static function getAllEnquiries()
    {
        EnquiriesServices::allEnquiriesServ();
    }

    public static function getEnquiryId($enquiry_id)
    {
        EnquiriesServices::getEnquiryIdServ($enquiry_id);
    }

    public static function saveEnquiry($user_data)
    {
        EnquiriesServices::saveEnquiryServ($user_data);
    }

}