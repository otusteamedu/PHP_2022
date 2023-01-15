<?php

namespace Otus\App\Application\Services;

use Otus\App\Application\Entity\Enquiries;
use Otus\App\Application\Entity\Producer\ApiQueue;

class EnquiriesServices
{
    public static function allEnquiriesServ()
    {
        $array_enquiries = Enquiries::allEnquiries();

        if ($array_enquiries) {
            http_response_code(200);
            $result = json_encode($array_enquiries, JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Enquiries not found"
            ];
            $result = json_encode($not_found_result, JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }

    public static function getEnquiryIdServ($enquiry_id)
    {
        $array_info_enquiry = Enquiries::getEnquiriesID($enquiry_id);

        if ($array_info_enquiry) {
            http_response_code(200);
            $result = json_encode($array_info_enquiry, JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Enquiry not found"
            ];
            $result = json_encode($not_found_result, JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }

    public static function saveEnquiryServ($user_data)
    {
        $enquiry_description = $user_data['enquiry_description'];
        $new_enquiry = Enquiries::saveEnquiry($enquiry_description);

        if ($new_enquiry) {
            new ApiQueue($new_enquiry);
            http_response_code(201);
            $save_result = [
                "status" => true,
                "message" => "Enquiry created",
                "id" => $new_enquiry
            ];
            $result = json_encode($save_result,JSON_UNESCAPED_UNICODE);
            echo $result;
        } else {
            http_response_code(400);
            $not_save_result = [
                "status" => false,
                "message" => "Enquiry not save"
            ];
            $result = json_encode($not_save_result,JSON_UNESCAPED_UNICODE);
            echo $result;
        }
    }
}