<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class CertificateController extends Controller
{
    public function download($course_id)
    {
        $pdf = PDF::loadView('users.certificate.certificate_pdf');
        return $pdf->download('Certificate.pdf');
    }
}
