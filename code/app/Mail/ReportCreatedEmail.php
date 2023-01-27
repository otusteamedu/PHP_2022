<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ReportCreatedEmail extends Mailable
{
    public function __construct(private int $reportId)
    {
    }

    public function build(): Mailable
    {
        return $this->view('report', [
            'reportId' => $this->reportId
        ]);
    }
}
