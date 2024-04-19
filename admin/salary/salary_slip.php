<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 640px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: auto;
            border: 4px solid #000;
            /* Black border around the container */
        }

        .logo {
            width: 120px;
            /* Increased logo size */
            height: auto;
            margin-bottom: 20px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 1.5em;
            /* Larger font size for company name */
            font-weight: bold;
            color: #4caf50;
            /* Light green color */
        }

        h2.heading {
            font-size: 1.8em;
            /* Larger font size for heading */
            font-weight: bold;
            color: #6e3c07;
            /* Dark brown color */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #383523;
            /* Dark brown header */
            color: #fff;
            /* White text */
        }

        .total {
            font-weight: bold;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
</head>

<body>

    <script>
        function getPDF() {

            let reportName = 'salary_slip';
            reportName = reportName.replace(/[\s.]/g, '');
            if (reportName === '') {
                reportName = 'randomName_' + Math.floor(Math.random() * 1000);
            }
            $("#downloadbtn").hide();
            $("#genmsg").show();
            var HTML_Width = $(".canvas_div_pdf").width();
            var HTML_Height = $(".canvas_div_pdf").height();
            var top_left_margin = 1;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.2) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;
            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;
            html2canvas($(".canvas_div_pdf")[0], {
                allowTaint: true
            }).then(function(canvas) {
                canvas.getContext('2d');
                // console.log(canvas.height + "  " + canvas.width);
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4), canvas_image_width, canvas_image_height);
                }

                pdf.save(`${reportName}.pdf`);
                setTimeout(function() {
                    $("#downloadbtn").show();
                    $("#genmsg").hide();
                }, 0);

            });
        };
    </script>

    <div class="row" style="align-items: center;">
        <div class="col-md-12 text-center">
            <button onclick="getPDF()" id="downloadbtn" style="display: inline-block;"><b>Click to Download Report as PDF</b></button>
            <span id="genmsg" style="display: none;">Generating ...</span>
        </div>
    </div>


    <div class="container canvas_div_pdf">
        <img src="<?php echo SITEPATH; ?>upload/logo.png" alt="Company Logo" class="logo">
        <div class="company-info">
            <div class="company-name">ATHANG SOLUTIONS PRIVATE LIMITED</div>
            <p>SWAMI SAMARTH APPT NEAR SBI UMARSARA<br>YAVATMAL 445001</p>
        </div>

        <table>
            <tr>
                <th align="center" colspan="2">SALARY SLIP FOR APRIL 2024</th>
            </tr>
            <tr>
                <td><strong>Name of Employee:</strong></td>
                <td>Mr. ABC</td>
            </tr>
            <tr>
                <td><strong>Designation:</strong></td>
                <td>Marketing Executive/Clerk/BM</td>
            </tr>
        </table>

        <table>
            <tr>
                <th>Earning</th>
                <th>Amount</th>
                <th>Deduction</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>BASIC</td>
                <td>*****</td>
                <td>LEAVE</td>
                <td>*****</td>
            </tr>
            <tr>
                <td>PETROL ALLOWANCE</td>
                <td>*****</td>
                <td>OTHER DEDUCTION</td>
                <td>*****</td>
            </tr>
            <tr>
                <td>MOBILE RECHARGE</td>
                <td>*****</td>
                <td>ADVANCE</td>
                <td>*****</td>
            </tr>
            <tr>
                <td>INCENTIVE</td>
                <td>*****</td>
                <td></td>
                <td></td>
            </tr>
            <tr class="total">
                <td>Total Earnings</td>
                <td>*****</td>
                <td>Total Deductions</td>
                <td>*****</td>
            </tr>
            <tr>
                <td colspan="2" class="total">NET PAYABLE</td>
                <td colspan="2" class="total">*****</td>
            </tr>
        </table>

        <p style="margin-top: 20px;"><strong>In words:</strong> [Amount in words]</p>
    </div>
</body>

</html>