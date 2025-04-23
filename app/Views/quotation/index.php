<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบพิมพ์ใบเสนอราคา</title>
    <!-- เรียกใช้ CSS ของ CodeIgniter -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .item-row input {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ใบเสนอราคา</h1>
        
        <div class="form-group">
            <label for="customerName">ชื่อลูกค้า:</label>
            <input type="text" id="customerName" name="customerName">
        </div>
        
        <div class="form-group">
            <label for="customerAddress">ที่อยู่:</label>
            <textarea id="customerAddress" name="customerAddress" rows="3"></textarea>
        </div>
        
        <div class="form-group">
            <label for="quotationDate">วันที่:</label>
            <input type="date" id="quotationDate" name="quotationDate">
        </div>
        
        <div class="form-group">
            <label for="quotationNumber">เลขที่ใบเสนอราคา:</label>
            <input type="text" id="quotationNumber" name="quotationNumber">
        </div>
        
        <h3>รายการสินค้า</h3>
        <table id="itemsTable">
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
                <tr class="item-row">
                    <td>1</td>
                    <td><input type="text" name="itemName[]"></td>
                    <td><input type="number" name="quantity[]" class="quantity" min="1" value="1"></td>
                    <td><input type="number" name="unitPrice[]" class="unit-price" min="0" value="0"></td>
                    <td><input type="number" name="amount[]" class="amount" readonly></td>
                </tr>
            </tbody>
        </table>
        
        <button type="button" id="addItemBtn">เพิ่มรายการ</button>
        
        <div class="form-group" style="text-align: right; margin-top: 20px;">
            <label for="totalAmount">ยอดรวมทั้งสิ้น:</label>
            <input type="number" id="totalAmount" name="totalAmount" readonly>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <button type="button" id="printBtn">พิมพ์ใบเสนอราคา</button>
        </div>
    </div>

    <!-- เรียกใช้ JavaScript ของ CodeIgniter -->
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    
    <!-- เพิ่ม jsPDF และ print-js จาก CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ตั้งค่าวันที่ปัจจุบัน
            const today = new Date();
            const formattedDate = today.toISOString().substr(0, 10);
            document.getElementById('quotationDate').value = formattedDate;
            
            // เพิ่มรายการสินค้า
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const tbody = document.querySelector('#itemsTable tbody');
                const rowCount = tbody.querySelectorAll('tr').length;
                
                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
                    <td>${rowCount + 1}</td>
                    <td><input type="text" name="itemName[]"></td>
                    <td><input type="number" name="quantity[]" class="quantity" min="1" value="1"></td>
                    <td><input type="number" name="unitPrice[]" class="unit-price" min="0" value="0"></td>
                    <td><input type="number" name="amount[]" class="amount" readonly></td>
                `;
                
                tbody.appendChild(newRow);
                setupCalculation();
            });
            
            // คำนวณราคา
            function setupCalculation() {
                const rows = document.querySelectorAll('.item-row');
                
                rows.forEach(row => {
                    const quantityInput = row.querySelector('.quantity');
                    const unitPriceInput = row.querySelector('.unit-price');
                    const amountInput = row.querySelector('.amount');
                    
                    function calculateAmount() {
                        const quantity = parseFloat(quantityInput.value) || 0;
                        const unitPrice = parseFloat(unitPriceInput.value) || 0;
                        const amount = quantity * unitPrice;
                        amountInput.value = amount.toFixed(2);
                        calculateTotal();
                    }
                    
                    quantityInput.addEventListener('input', calculateAmount);
                    unitPriceInput.addEventListener('input', calculateAmount);
                    
                    // คำนวณครั้งแรก
                    calculateAmount();
                });
            }
            
            // คำนวณยอดรวม
            function calculateTotal() {
                const amountInputs = document.querySelectorAll('.amount');
                let total = 0;
                
                amountInputs.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                
                document.getElementById('totalAmount').value = total.toFixed(2);
            }
            
            // ตั้งค่าการคำนวณเริ่มต้น
            setupCalculation();
            
            // การพิมพ์ใบเสนอราคา
            document.getElementById('printBtn').addEventListener('click', function() {
                generatePDF();
            });
            
            // สร้างไฟล์ PDF และสั่งพิมพ์
            function generatePDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                
                // ข้อมูลบริษัท
                doc.setFontSize(18);
                doc.text('ใบเสนอราคา', 105, 20, { align: 'center' });
                
                doc.setFontSize(12);
                doc.text('บริษัท ตัวอย่าง จำกัด', 20, 30);
                doc.text('123 ถนนตัวอย่าง แขวงตัวอย่าง เขตตัวอย่าง กรุงเทพฯ 10000', 20, 35);
                doc.text('โทร: 02-123-4567', 20, 40);
                
                // ข้อมูลลูกค้า
                const customerName = document.getElementById('customerName').value;
                const customerAddress = document.getElementById('customerAddress').value;
                const quotationDate = document.getElementById('quotationDate').value;
                const quotationNumber = document.getElementById('quotationNumber').value;
                
                doc.text('เลขที่: ' + quotationNumber, 150, 30, { align: 'right' });
                doc.text('วันที่: ' + quotationDate, 150, 35, { align: 'right' });
                
                doc.text('ลูกค้า:', 20, 50);
                doc.text(customerName, 40, 50);
                
                // แบ่งที่อยู่เป็นบรรทัด
                const addressLines = customerAddress.split('\n');
                addressLines.forEach((line, index) => {
                    doc.text(line, 40, 55 + (index * 5));
                });
                
                // หัวตาราง
                doc.line(20, 70, 190, 70);
                doc.text('ลำดับ', 25, 75);
                doc.text('รายการ', 50, 75);
                doc.text('จำนวน', 110, 75);
                doc.text('ราคาต่อหน่วย', 135, 75);
                doc.text('จำนวนเงิน', 170, 75);
                doc.line(20, 80, 190, 80);
                
                // รายการสินค้า
                const rows = document.querySelectorAll('.item-row');
                let yPos = 85;
                
                rows.forEach((row, index) => {
                    const itemName = row.querySelector('input[name="itemName[]"]').value;
                    const quantity = row.querySelector('input[name="quantity[]"]').value;
                    const unitPrice = row.querySelector('input[name="unitPrice[]"]').value;
                    const amount = row.querySelector('input[name="amount[]"]').value;
                    
                    doc.text((index + 1).toString(), 25, yPos);
                    doc.text(itemName, 50, yPos);
                    doc.text(quantity, 110, yPos);
                    doc.text(unitPrice, 135, yPos);
                    doc.text(amount, 170, yPos);
                    
                    yPos += 10;
                });
                
                // เส้นปิดตาราง
                doc.line(20, yPos, 190, yPos);
                
                // ยอดรวม
                const totalAmount = document.getElementById('totalAmount').value;
                doc.text('ยอดรวมทั้งสิ้น:', 135, yPos + 10);
                doc.text(totalAmount + ' บาท', 170, yPos + 10);
                
                // บันทึกไฟล์ PDF เป็น blob
                const pdfBlob = doc.output('blob');
                const pdfUrl = URL.createObjectURL(pdfBlob);
                
                // สั่งพิมพ์โดยตรงไปยังเครื่องพิมพ์ที่ตั้งค่าเป็นค่าเริ่มต้น
                printJS({
                    printable: pdfUrl,
                    type: 'pdf',
                    showModal: false,
                    silent: true
                });
            }
        });
    </script>
</body>
</html>