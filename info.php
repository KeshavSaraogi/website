<?php 
    $dbServerName = "173.255.232.150";
    $dbUsername = "cis4398";
    $dbPassword = "dNC=IK~9)7";
    $dbName = "Questions";

    $conn = new mysqli($dbServerName, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        //echo "Connected successfully";
    }

    $ts_query = "SELECT tsStamp FROM Questions.SingularRecording where exmaID = 9";
    $ts_results = mysqli_query($conn, $ts_query);
    $ts_recordings = mysqli_fetch_all($ts_results, MYSQLI_ASSOC);

    $timestamp_array = array();
    for ($x = 0; $x < sizeof($ts_recordings); $x++){
        array_push($timestamp_array, $ts_recordings[$x]['tsStamp']);
    }
    for ($x = 0; $x < sizeof($timestamp_array); $x++){
        //print($timestamp_array[$x]);
        //print_r('<br>');
    }

    $p_query = "SELECT pulse FROM Questions.SingularRecording where exmaID = 9";
    $p_results = mysqli_query($conn, $p_query);
    $p_recordings = mysqli_fetch_all($p_results, MYSQLI_ASSOC);

    $pulse_array = array();
    for ($x = 0; $x < sizeof($p_recordings); $x++){
        array_push($pulse_array, $p_recordings[$x]['pulse']);
    }
    for ($x = 0; $x < sizeof($pulse_array); $x++){
        //print($pulse_array[$x]);
        //print_r('<br>');
    }

    $sk_query = "SELECT skin_conductivity FROM Questions.SingularRecording where exmaID = 9";
    $sk_results = mysqli_query($conn, $sk_query);
    $sk_recordings = mysqli_fetch_all($sk_results, MYSQLI_ASSOC);

    $skinconductivity_array = array();
    for ($x = 0; $x < sizeof($sk_recordings); $x++){
        array_push($skinconductivity_array, $sk_recordings[$x]['skin_conductivity']);
    }
    for ($x = 0; $x < sizeof($skinconductivity_array); $x++){
        //print($skinconductivity_array[$x]);
        //print_r('<br>');
    }

    $rb_query = "SELECT respiration_belt FROM Questions.SingularRecording where exmaID = 9";
    $rb_results = mysqli_query($conn, $rb_query);
    $rb_recordings = mysqli_fetch_all($rb_results, MYSQLI_ASSOC);

    $respirationbelt_array = array();
    for ($x = 0; $x < sizeof($rb_recordings); $x++){
        array_push($respirationbelt_array, $rb_recordings[$x]['respiration_belt']);
    }
    for ($x = 0; $x < sizeof($respirationbelt_array); $x++){
        //print($respirationbelt_array[$x]);
        //print_r('<br>');
    }

    $bp_query = "SELECT blood_pressure FROM Questions.SingularRecording where exmaID = 9";
    $bp_results = mysqli_query($conn, $bp_query);
    $bp_recordings = mysqli_fetch_all($bp_results, MYSQLI_ASSOC);

    $bloodpressure_array = array();
    for ($x = 0; $x < sizeof($bp_recordings); $x++){
        array_push($bloodpressure_array, $bp_recordings[$x]['blood_pressure']);
    }
    for ($x = 0; $x < sizeof($bloodpressure_array); $x++){
        //print($bloodpressure_array[$x]);
        //print_r('<br>');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include('templates/header.php') ?>
    <br />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://d3js.org/d3.v6.js"></script>
    <title>Document</title>
</head>
<body>
    
    <button onclick="update(data1)">Dataset 1</button>
    <button onclick="update(data2)">Dataset 2</button>
    <button onclick="update(data1)">Dataset 3</button>
    <button onclick="update(data1)">Dataset 4</button>
    <button onclick="update(data1)">Dataset 5</button>
    <button onclick="update(data1)">Dataset 6</button>
    <div id="my_dataviz"></div>
    <script>
        
        const data1 = [
        {ser1: 0.3, ser2: 4},
        {ser1: 2, ser2: 16},
        {ser1: 3, ser2: 8}
        ];

        const data2 = [
        {ser1: 1, ser2: 7},
        {ser1: 4, ser2: 1},
        {ser1: 6, ser2: 8}
        ];

        const data3 = [
        {ser1: 0.3, ser2: 4},
        {ser1: 2, ser2: 16},
        {ser1: 3, ser2: 8}
        ];

        const data4 = [
        {ser1: 4.3, ser2: 4},
        {ser1: 6, ser2: 16},
        {ser1: 3, ser2: 8}
        ];

        const data5 = [
        {ser1: 0.3, ser2: 4},
        {ser1: 2, ser2: 16},
        {ser1: 3, ser2: 8}
        ];

        const data6 = [
        {ser1: 0.3, ser2: 4},
        {ser1: 2, ser2: 16},
        {ser1: 3, ser2: 8}
        ]; 


        // set the dimensions and margins of the graph
        const margin = {top: 10, right: 30, bottom: 30, left: 50},
            width = 460 - margin.left - margin.right,
            height = 400 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        const svg = d3.select("#my_dataviz")
        .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
        .append("g")
            .attr("transform", `translate(${margin.left},${margin.top})`);

        // Initialise a X axis:
        const x = d3.scaleLinear().range([0,width]);
        const xAxis = d3.axisBottom().scale(x);
        svg.append("g")
        .attr("transform", `translate(0, ${height})`)
        .attr("class","myXaxis")

        // Initialize an Y axis
        const y = d3.scaleLinear().range([height, 0]);
        const yAxis = d3.axisLeft().scale(y);
        svg.append("g")
        .attr("class","myYaxis")

        // Create a function that takes a dataset as input and update the plot:
        function update(data) {

        // Create the X axis:
        x.domain([0, d3.max(data, function(d) { return d.ser1 }) ]);
        svg.selectAll(".myXaxis").transition()
            .duration(3000)
            .call(xAxis);

        // create the Y axis
        y.domain([0, d3.max(data, function(d) { return d.ser2  }) ]);
        svg.selectAll(".myYaxis")
            .transition()
            .duration(3000)
            .call(yAxis);

        // Create a update selection: bind to the new data
        const u = svg.selectAll(".lineTest")
            .data([data], function(d){ return d.ser1 });

        // Updata the line
        u
            .join("path")
            .attr("class","lineTest")
            .transition()
            .duration(3000)
            .attr("d", d3.line()
            .x(function(d) { return x(d.ser1); })
            .y(function(d) { return y(d.ser2); }))
            .attr("fill", "none")
            .attr("stroke", "steelblue")
            .attr("stroke-width", 2.5)
        }

        // At the beginning, I run the update function on the first dataset:
        update(data1)
    </script>
    <?php include('templates/footer.php') ?>
</body>
</html>