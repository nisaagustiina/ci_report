<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Filter Form -->
    <div class="container">
        <form action="<?= base_url('/'); ?>" method="post">
            <div class="form-group">
                <label for="area">Select Area</label>
                <select class="form-control" id="area" name="area">
                    <option value="">All</option>
                    <?php foreach ($areas as $area) { ?>
                        <option value="<?= $area->area_name; ?>" <?= ($selected_area == $area->area_name) ? 'selected' : '' ?>>
                            <?= $area->area_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_from">Select Date From</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="<?= $date_from ?>">
            </div>
            <div class="form-group">
                <label for="date_to">Select Date To</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="<?= $date_to ?>">
            </div>
            <button type="submit" class="btn btn-primary">View</button>
        </form>
    </div>

    <!-- Chart -->
    <div class="container mt-5" style="width:50%">
        <h3>Chart Report Product by Area</h3>
        <canvas id="chart"></canvas>
    </div>

    <!-- Tabel Data -->
    <div class="container mt-5">
        <h3>Product</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <?php
                    if ($selected_area != null) {
                        echo '<th>' . $selected_area . '</th>';
                    } else {
                        foreach ($areas as $area) { ?>
                            <th>
                                <?= $selected_area != null ? $areas[$selected_area]['area_name'] : $area->area_name ?>
                            </th>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report_data as $k => $value) { ?>
                    <tr>
                        <td>
                            <?= $value['brand_name'] ?>
                        </td>
                        <?php
                        foreach ($value['area'] as $item) { ?>
                            <td>
                                <?= $item['nilai'] . '%' ?>
                            </td>
                            <?php
                        } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Script Chart -->
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    <?php foreach ($chart_data as $row) {
                        echo "'" . $row->area_name . "',";
                    } ?>
                ],
                datasets: [{
                    label: 'Nilai',
                    data: [
                        <?php foreach ($chart_data as $row) {
                            echo "'" . $row->nilai . "',";
                        } ?>
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>