<?php
date_default_timezone_set("Asia/Calcutta");
session_start();

$servername = "localhost";
$username = "imsdevuser";
$password = "UjhGFTybCDSr";
$database = "newimsiiithdev";

$conn = new mysqli($servername, $username, $password, $database);
if (!$conn) {
    $err_at_submission = mysqli_error();
    die();
}

function displayQuery($sql, $conn) {
    $result = $conn->query($sql);
    $rs = array();

    while ($row = $result->fetch_assoc()) {
        $rs[] = $row;
    }
    return $rs;
}

$resultset = array();

$sql = "SELECT createdat, exittime, category, visitorname, mobile, vehicleno, hoststatus FROM visitors WHERE DATE(createdat) = CURDATE() AND recordtype IS NULL ORDER BY createdat DESC";

$sqlcount_visitors = "SELECT COUNT(id) as visitorCount FROM visitors WHERE DATE(createdat) = CURDATE() AND category='visitor'";
$sqlcount_cabs = "SELECT COUNT(id) as cabCount FROM visitors WHERE DATE(createdat) = CURDATE() AND category='cab'";
$sqlcount_delivery = "SELECT COUNT(id) as deliveryCount FROM visitors WHERE DATE(createdat) = CURDATE() AND category='delivery'";
$sqlcount_others = "SELECT COUNT(id) as othersCount FROM visitors WHERE DATE(createdat) = CURDATE() AND category='other_services'";

$sqlcount_visitors_out = "SELECT COUNT(id) as visitorCountout FROM visitors WHERE DATE(createdat) = CURDATE() AND category='visitor' AND exittime IS NOT NULL";
$sqlcount_cabs_out = "SELECT COUNT(id) as cabCountout FROM visitors WHERE DATE(createdat) = CURDATE() AND category='cab' AND exittime IS NOT NULL";
$sqlcount_delivery_out = "SELECT COUNT(id) as deliveryCountout FROM visitors WHERE DATE(createdat) = CURDATE() AND category='delivery' AND exittime IS NOT NULL";
$sqlcount_others_out = "SELECT COUNT(id) as othersCountout FROM visitors WHERE DATE(createdat) = CURDATE() AND category='other_services' AND exittime IS NOT NULL";

$result_visitors = $conn->query($sqlcount_visitors);
$result_cabs = $conn->query($sqlcount_cabs);
$result_delivery = $conn->query($sqlcount_delivery);
$result_others = $conn->query($sqlcount_others);

$visitorCount = $result_visitors->fetch_assoc()['visitorCount'];
$cabCount = $result_cabs->fetch_assoc()['cabCount'];
$deliveryCount = $result_delivery->fetch_assoc()['deliveryCount'];
$othersCount = $result_others->fetch_assoc()['othersCount'];

$result_visitors_out = $conn->query($sqlcount_visitors_out);
$result_cabs_out = $conn->query($sqlcount_cabs_out);
$result_delivery_out = $conn->query($sqlcount_delivery_out);
$result_others_out = $conn->query($sqlcount_others_out);

$visitorCount_out = $result_visitors_out->fetch_assoc()['visitorCountout'];
$cabCount_out = $result_cabs_out->fetch_assoc()['cabCountout'];
$deliveryCount_out = $result_delivery_out->fetch_assoc()['deliveryCountout'];
$othersCount_out = $result_others_out->fetch_assoc()['othersCountout'];

$resultset = displayQuery($sql, $conn);
$date = date('m/d/Y h:i:s a', time());
?>

<html>
<head>
    <title>Visitor Summary</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
        }

        #navbar, #count-heading {
            text-align: center;
            background-color: #022f78;
            padding: 10px;
            color: white;
        }

        #export-link, #print-link {
            color: white;
            text-decoration: none;
            padding: 5px;
            margin: auto;
            cursor: pointer;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #022f78;
            color: white;
        }

        @media (max-width: 768px) {
            .table-responsive {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <?php require_once 'top_logo_title_header.php'; ?>
    </div>
    <div id="navbar">
        <h2>Daily Summary</h2>
        <a href="#" id="export-link">CSV Export</a>
        <a href="#" id="print-link">Print</a>
    </div>
    <div class="table-responsive">
        <table id="summary" class="table table-bordered">
            <thead>
                <tr>
                    <th>Date of visit</th>
                    <th>Exit Time</th>
                    <th>Category</th>
                    <th>Visitor Name</th>
                    <th>Mobile</th>
                    <th>Vehicle No</th>
					<th>Approved/Denied</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultset as $rs1): ?>
                    <tr>
                        <?php foreach ($rs1 as $val): ?>
                            <td><?= htmlspecialchars($val) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="count-heading">
        <h2>Visitor Counts</h2>
        <h4><?= $date ?></h4>
    </div>
    <div class="table-responsive">
        <table id="tabcounts" class="table table-bordered">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>IN</th>
                    <th>OUT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Visitors</td>
                    <td><?= $visitorCount ?></td>
                    <td><?= $visitorCount_out ?></td>
                </tr>
                <tr>
                    <td>Cabs</td>
                    <td><?= $cabCount ?></td>
                    <td><?= $cabCount_out ?></td>
                </tr>
                <tr>
                    <td>Delivery</td>
                    <td><?= $deliveryCount ?></td>
                    <td><?= $deliveryCount_out ?></td>
                </tr>
                <tr>
                    <td>Other Services</td>
                    <td><?= $othersCount ?></td>
                    <td><?= $othersCount_out ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><?= $visitorCount + $cabCount + $deliveryCount + $othersCount ?></td>
                    <td><?= $visitorCount_out + $cabCount_out + $deliveryCount_out + $othersCount_out ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('thead th').each(function(index) {
                var columnValues = [];
                $('tbody td:nth-child(' + (index + 1) + ')').each(function() {
                    var value = $(this).text();
                    if (columnValues.indexOf(value) === -1) {
                        columnValues.push(value);
                    }
                });

                var dropdown = $('<select><option value="">*</option></select>')
                    .attr('data-index', index)
                    .on('change', function() {
                        var columnIndex = $(this).data('index');
                        var selectedValue = $(this).val();

                        $('tbody tr').each(function() {
                            var cellValue = $(this).find('td:nth-child(' + (columnIndex + 1) + ')').text();
                            if (selectedValue === "" || selectedValue === cellValue) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    });

                $.each(columnValues, function(i, value) {
                    dropdown.append($('<option></option>').text(value));
                });

                $(this).append(dropdown);
            });
        });

        document.getElementById("print-link").addEventListener("click", function() {
            window.print();
        });

        function downloadCSV() {
            var table = document.getElementById("summary");
            var csvContent = " ";

            var headerRow = [];
            for (var i = 0; i < table.rows[0].cells.length; i++) {
                headerRow.push(table.rows[0].cells[i].textContent);
            }
            csvContent += headerRow.join(",") + "\n";

            for (var j = 1; j < table.rows.length; j++) {
                var dataRow = [];
                for (var k = 0; k < table.rows[j].cells.length; k++) {
                    dataRow.push(table.rows[j].cells[k].textContent);
                }
                csvContent += dataRow.join(",") + "\n";
            }

            var blob = new Blob([csvContent], { type: "text/csv" });
            var url = window.URL.createObjectURL(blob);

            var a = document.createElement("a");
            a.href = url;
            a.download = "table_data.csv";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        document.getElementById("export-link").addEventListener("click", downloadCSV);
    </script>
</body>
</html>
