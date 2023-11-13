<?php
session_start();
include('server.php');
include('admin_navbar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="your-icon-url.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Report dataset</title>
    <style>
        /* เพิ่ม CSS เพื่อสวยงามตามต้องการ */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <h1 class="text-center">Report detail</h1>

        <form id="reportForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="datasetID">Enter Dataset ID:</label>
                    <input type="text" id="datasetID" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="selectedMonth">Select Month:</label>
                    <select id="selectedMonth" class="form-select">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary mt-4" onclick="showReport()">Submit</button>
                </div>
            </div>
        </form>

        <!-- Summary Table -->
        <table id="reportTable" style="display:none;">
            <tr>
                <th>Category</th>
                <th>Count</th>
            </tr>
            <tr>
                <td>Downloads</td>
                <td id="downloadCount">0</td>
            </tr>
            <tr>
                <td>Visitors</td>
                <td id="visitorCount">0</td>
            </tr>
        </table>

    </div>
<<!-- Chart -->
<div class="container mt-4">
    <canvas id="chartDownloads" width="400" height="200"></canvas>
    <canvas id="chartVisitors" width="400" height="200"></canvas>
</div>

<!-- Create a chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function showReport() {
        var datasetID = document.getElementById("datasetID").value;
        var selectedMonth = document.getElementById("selectedMonth").value;
        var reportTable = document.getElementById("reportTable");

        // Simulating data retrieval with JavaScript (replace with actual AJAX call)
        var data = {
            downloads: Math.floor(Math.random() * 100),
            visitors: Math.floor(Math.random() * 100)
        };

        // Display data in the table
        document.getElementById("downloadCount").innerHTML = data.downloads;
        document.getElementById("visitorCount").innerHTML = data.visitors;

        // Display the table
        reportTable.style.display = "block";

        // Log dataset details (you can replace this with actual usage)
        console.log("Dataset ID:", datasetID);
        console.log("Selected Month:", selectedMonth);

        // Add the following lines to display dataset details in the table
        var table = document.getElementById("reportTable");
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = "Dataset ID";
        cell2.innerHTML = datasetID;
        row = table.insertRow(-1);
        cell1 = row.insertCell(0);
        cell2 = row.insertCell(1);
        cell1.innerHTML = "Selected Month";
        cell2.innerHTML = selectedMonth;

        // Create a chart for Downloads and Visitors
        var ctx = document.getElementById('chartDownloads').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['สรุป'],
                datasets: [
                    {
                        label: 'Downloads',
                        data: [data.downloads],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Visitors',
                        data: [data.visitors],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>






</body>

</html>
