<?php

namespace App\Controllers;

class QuotationController extends BaseController
{
    public function index()
    {
        // แสดงหน้าใบเสนอราคา
        return view('quotation/index');
    }

    public function print()
    {
        // ตั้งค่า header สำหรับ UTF-8
        header('Content-Type: text/html; charset=utf-8');
        
        // ข้อมูลตัวอย่างสำหรับใบเสนอราคา
        $quotationData = [
            'customerName' => 'บริษัท ลูกค้า จำกัด',
            'customerAddress' => '456 ถนนลูกค้า แขวงลูกค้า เขตลูกค้า กรุงเทพฯ 10000',
            'quotationDate' => date('Y-m-d'),
            'quotationNumber' => 'QT-' . date('Ymd') . '-001',
            'items' => [
                [
                    'name' => 'สินค้า A',
                    'quantity' => 2,
                    'unitPrice' => 1000,
                    'amount' => 2000
                ],
                [
                    'name' => 'สินค้า B',
                    'quantity' => 1,
                    'unitPrice' => 500,
                    'amount' => 500
                ]
            ],
            'totalAmount' => 2500
        ];
        
        return view('quotation/print', ['quotationData' => $quotationData]);
    }
}