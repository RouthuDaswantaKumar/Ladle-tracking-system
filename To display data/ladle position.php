<?php
$connection = mysqli_connect("sql202.infinityfree.com", "if0_35626087", "ezRJzYe2VdWQ2", "if0_35626087_ladle");

if (!$connection) {
  die("Database connection failed");
}

$query = "SELECT LadleArriveTime, LadleNumber, LadlePosition FROM data ORDER BY S_no DESC LIMIT 1";
$result = mysqli_query($connection, $query);

if (!$result) {
  die("Query failed: " . mysqli_error($connection));
}

// Initialize variables to store data
$LadleArriveTime = "";
$LadleNumber = "";
$LadlePosition = "";

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $LadleArriveTime = $row['LadleArriveTime'];
  $LadleNumber = $row['LadleNumber'];
  $LadlePosition = $row['LadlePosition'];
}

// Function to replace LadlePosition with LadleArriveTime and LadleNumber
function replaceLadlePosition($boxId, $arriveTime, $ladleNumber) {
  echo "<script>";
  echo "document.getElementById('$boxId').innerHTML = '<h2>$arriveTime</h2><h2>$ladleNumber</h2>';";
  echo "</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Box</title>
  <style>
    /* Style the container */
    .container {
      height: 200px;
      width: 95%;
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border: 4px solid #000;
      text-align: center;
      display: flex;
      justify-content: space-between;
    }

    /* Unique styles for each box using their IDs */
    .box {
      width: 140px;
      height: 170px;
      border: 2px solid #000;
      background-color: red;
      text-align: center;
    }

    .box.green {
      background-color: green;
    }

    .box-text {
      padding-top: 40px;
    }

    h2 {
      margin: 0;
    }
    h2 {
      text-align: center; /* Center the text horizontally */
    }
  </style>
</head>
<body>
  <h2>Ladle position</h2>
  <div class="container">
    <div id="Furnace1" class="box">
      <div class="box-text">
        <h2>Furnace1</h2>
      </div>
    </div>
    <div id="Furnace2" class="box">
      <div class="box-text">
        <h2>Furnace2</h2>
      </div>
    </div>
    <div id="ScrapPot1" class="box">
      <div class="box-text">
        <h2>ScrapPot1</h2>
      </div>
    </div>
    <div id="ScrapPot2" class="box">
      <div class="box-text">
        <h2>ScrapPot2</h2>
      </div>
    </div>
    <div id="ChargingPit1" class="box">
      <div class="box-text">
        <h2>ChargingPit1</h2>
      </div>
    </div>
    <div id="ChargingPit2" class="box">
      <div class="box-text">
        <h2>ChargingPit2</h2>
      </div>
    </div>
  </div>

  <?php
  // Check if LadlePosition matches a box ID and replace the box content
  if ($LadlePosition === 'Furnace1') {
    replaceLadlePosition('Furnace1', $LadleArriveTime, $LadleNumber);
  } elseif ($LadlePosition === 'Furnace2') {
    replaceLadlePosition('Furnace2', $LadleArriveTime, $LadleNumber);
  } elseif ($LadlePosition === 'ScrapPot1') {
    replaceLadlePosition('ScrapPot1', $LadleArriveTime, $LadleNumber);
  } elseif ($LadlePosition === 'ScrapPot2') {
    replaceLadlePosition('ScrapPot2', $LadleArriveTime, $LadleNumber);
  } elseif ($LadlePosition === 'ChargingPit1') {
    replaceLadlePosition('ChargingPit1', $LadleArriveTime, $LadleNumber);
  } elseif ($LadlePosition === 'ChargingPit2') {
    replaceLadlePosition('ChargingPit2', $LadleArriveTime, $LadleNumber);
  }
  ?>
   <script>
    // Function to change the color of the box based on its ID
    function changeBoxColor(boxId) {
      var box = document.getElementById(boxId);
      if (box) {
        box.style.backgroundColor = 'green';
      }
    }

    // Call the function to change the box color based on LadlePosition
    changeBoxColor('<?php echo $LadlePosition; ?>');
  </script>
  <!-- Button to redirect to ladle_table.php -->
  <button onclick="window.location.href='ladle table.php'" name="ladle_table">Ladle Table</button>

  <style>
    /* Add the following styles for center alignment of the buttons */
    button {
      display: block;
      margin: 20px auto; /* Center the buttons */
    }
  </style>
</body>
</html>