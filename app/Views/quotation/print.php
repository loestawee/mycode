<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พิมพ์ใบเสนอราคา</title>
    
    <!-- ใช้ฟอนต์ที่มีในระบบแทนการโหลดจาก Google Fonts -->
    <style>
        /* ใช้ฟอนต์ที่รองรับภาษาไทยที่มีในระบบ */
        body {
            font-family: 'TH Sarabun New', 'Sarabun', 'Tahoma', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        /* สไตล์อื่นๆ สำหรับใบเสนอราคา */
        .quotation-content {
            width: 210mm;
            padding: 10mm;
            margin: 0 auto;
            background: white;
        }
        .quotation-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-info {
            margin-bottom: 20px;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        
        /* สไตล์สำหรับการพิมพ์ */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .quotation-content {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div id="printContent">
        <div class="quotation-content">
            <div class="quotation-header">
                <h1>ใบเสนอราคา</h1>
            </div>
            
            <div class="company-info">
                <p>บริษัท ตัวอย่าง จำกัด</p>
                <p>123 ถนนตัวอย่าง แขวงตัวอย่าง เขตตัวอย่าง กรุงเทพฯ 10000</p>
                <p>โทร: 02-123-4567</p>
            </div>
            
            <div class="customer-info">
                <p><strong>ลูกค้า:</strong> <span id="customerName"><?= $quotationData['customerName'] ?? '' ?></span></p>
                <p><strong>ที่อยู่:</strong> <span id="customerAddress"><?= $quotationData['customerAddress'] ?? '' ?></span></p>
                <p><strong>วันที่:</strong> <span id="quotationDate"><?= $quotationData['quotationDate'] ?? date('Y-m-d') ?></span></p>
                <p><strong>เลขที่:</strong> <span id="quotationNumber"><?= $quotationData['quotationNumber'] ?? '' ?></span></p>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รายการ</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>จำนวนเงิน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($quotationData['items']) && is_array($quotationData['items'])): ?>
                        <?php foreach ($quotationData['items'] as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $item['name'] ?? '' ?></td>
                                <td><?= $item['quantity'] ?? '' ?></td>
                                <td><?= $item['unitPrice'] ?? '' ?></td>
                                <td><?= $item['amount'] ?? '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">ไม่มีรายการสินค้า</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="total-section">
                <p><strong>ยอดรวมทั้งสิ้น:</strong> <span id="totalAmount"><?= $quotationData['totalAmount'] ?? '0.00' ?></span> บาท</p>
            </div>
        </div>
    </div>

    <script>
        // พิมพ์ทันทีเมื่อโหลดหน้าเสร็จ โดยไม่ต้องรอฟอนต์
        window.onload = function() {
            // พิมพ์ทันที
            window.print();
            
            // หากต้องการกลับไปหน้าก่อนหน้าหลังจากพิมพ์เสร็จ
            window.onafterprint = function() {
                // window.history.back(); // ถ้าต้องการกลับไปหน้าก่อนหน้า
            };
        };
    </script>
</body>
</html>