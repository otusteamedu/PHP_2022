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
        return $array_enquiries;
    }

    public static function getEnquiriesID($enquiry_id): array
    {
        $enquiries = Enquiries::get('enquiry_id', "$enquiry_id");
        return $enquiries;
    }

    public static function saveEnquiry($enquiry_description)
    {
        $new_enquiry = new Enquiries();
        $new_enquiry->enquiry_description = $enquiry_description;
        $save_result = $new_enquiry->save();
        return $save_result;
    }
}