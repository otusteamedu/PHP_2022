<?php

namespace Otus\App\Application\Entity;

use Otus\App\Application\Entity\ActiveRecordEntity;

class Enquiries extends ActiveRecordEntity
{
    protected static $table = 'enquiries';

    public static function allEnquiries(): array
    {
        $array_enquiries = [];
        $k = 0;
        foreach (Enquiries::findAll() as $enquiries) {
            $array_enquiries[$k] = [
                "enquiry_id" => $enquiries['enquiry_id'],
                "enquiry_description" => $enquiries['enquiry_description'],
                "enquiry_status" => $enquiries['enquiry_status']
            ];
            $k++;
        }
        if (!$array_enquiries) {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Enquiries not found"
            ];
            return $not_found_result;
        }
        return $array_enquiries;
    }

    public static function getEnquiriesID($enquiry_id): array
    {
        $enquiries = Enquiries::get('enquiry_id', "$enquiry_id");

        if (!$enquiries) {
            http_response_code(400);
            $not_found_result = [
                "status" => false,
                "message" => "Enquiry not found"
            ];
            return $not_found_result;
        }
        return $enquiries;
    }

    public static function saveEnquiry($enquiry_description)
    {
        $new_enquiry = new Enquiries();
        $new_enquiry->enquiry_description = $enquiry_description;
        $save_result = $new_enquiry->save();
        if ($save_result) {
            http_response_code(201);
            $not_save_result = [
                "status" => true,
                "message" => "Enquiry created",
                "id" => $save_result
            ];
            return $not_save_result;
        } else {
            http_response_code(400);
            $save_result = [
                "status" => false,
                "message" => "Enquiry not save"
            ];
            return $save_result;
        }
    }
}