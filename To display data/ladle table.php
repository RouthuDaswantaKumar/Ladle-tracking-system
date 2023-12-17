<!DOCTYPE html>
<html>
<head>
  <title>Ladle Data Table</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid black;
      padding: 5px;
    }

    th {
      background-color: #ccc;
    }
  </style>
</head>
<body>
  <table>
    <thead>
      <tr>
        <th>S_no</th>
        <th>Ladle Arrive Time</th>
        <th>Ladle Number</th>
        <th>Ladle Position</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $connection = mysqli_connect("sql202.infinityfree.com", "if0_35626087", "ezRJzYe2VdWQ2", "if0_35626087_ladle");

        if (!$connection) {
          die("Database connection failed");
        }

        $query = "SELECT * FROM data";

        $result = mysqli_query($connection, $query);

        if (!$result) {
          echo ("query failed " . mysqli_error($connection));
        } else {
          while ($row = mysqli_fetch_assoc($result)) {
            $S_no = $row['S_no'];
            $LadleArriveTime = $row['LadleArriveTime'];
            $LadleNumber = $row['LadleNumber'];
            $LadlePosition = $row['LadlePosition'];

            echo "<tr>";
            echo "<td>$S_no</td>";
            echo "<td>$LadleArriveTime</td>";
            echo "<td>$LadleNumber</td>";
            echo "<td>$LadlePosition</td>";
            echo "</tr>";
          }
        }
      ?>
    </tbody>
  </table>

  <script>
    // Function to refresh the table data
    function refreshTable() {
      var xhr = new XMLHttpRequest();

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Update the table body content, preserving the headers
          document.getElementById('table-body').innerHTML = xhr.responseText;
        }
      };

      xhr.open('GET', 'get_latest_data.php', true);
      xhr.send();
    }

    refreshTable(); // Call the function initially

    setInterval(refreshTable, 5000); // Set an interval to refresh the table data
  </script>
  <!-- Button to redirect to ladle_table.php -->
  <button onclick="window.location.href='index.php'" name="ladle_table">Ladle position</button>

  <style>
    /* Add the following styles for center alignment of the buttons */
    button {
      display: block;
      margin: 20px auto; /* Center the buttons */
    }
  </style>
</body>
</html>