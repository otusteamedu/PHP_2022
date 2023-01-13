<?php

namespace Otus\App\Application\Services;

use Otus\App\Application\Entity\Enquiries;
use Otus\App\Application\Entity\Producer\ApiQueue;

class EnquiriesServices
{
    public static function allEnquiriesServ()
    {
        $massif_enquiries = Enquiries::allEnquiries();
        $result = json_encode($massif_enquiries, JSON_UNESCAPED_UNICODE);
        echo $result;
    }

    public static function getEnquiryIdServ($enquiry_id)
    {
        $massif_enquiries = Enquiries::getEnquiriesID($enquiry_id);
        $result = json_encode($massif_enquiries, JSON_UNESCAPED_UNICODE);
        echo $result;
    }

    public static function saveEnquiryServ($user_data)
    {
        $enquiry_description = $user_data['enquiry_description'];
        $save_result = Enquiries::saveEnquiry($enquiry_description);
        if (isset($save_result['id'])) {
            $new_id = $save_result['id'];
            new ApiQueue($new_id);
        }
        $result = json_encode($save_result,JSON_UNESCAPED_UNICODE);
        echo $result;
    }
}