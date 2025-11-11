<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generateReport($id)
    {
        // Ambil data pembayaran berdasarkan ID
        $payment = Payment::with('enrollment.student')->findOrFail($id);

        // Buat HTML untuk isi PDF
        $html = "
        <div style='margin:20px; padding:20px; font-family: Arial, sans-serif;'>
            <h1 style='text-align:center;'>Payment Receipt</h1>
            <hr>
            <p><b>Receipt No:</b> {$payment->id}</p>
            <p><b>Paid Date:</b> {$payment->paid_date}</p>
            <p><b>Enrollment No:</b> {$payment->enrollment->enroll_no}</p>
            <p><b>Student Name:</b> {$payment->enrollment->student->name}</p>
            <hr>
            <table width='100%' border='1' cellspacing='0' cellpadding='5'>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$payment->description}</td>
                        <td>{$payment->amount}</td>
                    </tr>
                </tbody>
            </table>
            <p style='text-align:right; margin-top:20px;'><b>Total:</b> {$payment->amount}</p>
        </div>
        ";

        // Generate PDF dari HTML di atas
        $pdf = Pdf::loadHTML($html);

        // Unduh file PDF
        return $pdf->stream("payment_receipt_{$payment->id}.pdf");
    }
}
