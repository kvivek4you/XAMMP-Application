<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Analytical Operation - Drill Up</title>
    <link rel="stylesheet" href="./css/style_reset.css" type="text/css">
        <link rel="stylesheet" href="./css/help.css" type="text/css">
        <link rel="stylesheet" href="./css/openflights.css" type="text/css">
        <style type="text/css"></style>
        <style>
            table, th, td {
            border: 1px solid black;
            }
        </style> 
</head>

<body>
    <div id="mainContainer">
      <div id="sideBarContentWrapper">
      
    <div id="contentContainer">
      <div id="nonmap">

         <h1>Airlines Reservation System</h1>

        <a href="Home.php">
        Home</a> | <a href="view.php">
        View Reservation</a> |<a href="Airport.php">
        Airport</a> | <a href="Airline.php">
        Airline</a> | <a href="Route.php">
        Route</a> | <a href="Analytical.php">
        Analytical Operations</a>

        <a name="airport"></a>
        <h2>Analytical Operations - Drill Up</h2>  
    <?php
    function constructTable($data)
        {
            // We're going to construct an HTML table.
            echo '<table style="width:50%">'; 
                
            // Construct the HTML table row by row.
            $doHeader = true;
            foreach ($data as $row) {
                    
                // The header row before the first data row.
                if ($doHeader) {
                    print "        <tr>\n";
                    foreach ($row as $name => $value) {
                        print "            <th>$name</th>\n";
                    }
                    print "        </tr>\n";
                    $doHeader = false;
                }
                    
                // Data row.
                print "        <tr>\n";
                foreach ($row as $name => $value) {
                    print "            <td>$value</td>\n";
                }
                print "        </tr>\n";
            }
            
            print "    </table>\n";
        }

        $first = $_POST['year'];
        $second = $_POST['month'];
        $id = filter_input(INPUT_GET, "id");
        $con = new PDO("mysql:host=localhost;dbname=projectinclude",
                           "root", "");
            $con->setAttribute(PDO::ATTR_ERRMODE,
                               PDO::ERRMODE_EXCEPTION);
         print "<h3>Drill Up and Drill Down Operations</h3>\n";

            
            print "<h1>Drill Operations</h1>\n";

    try {

                if($second=="month")
                {
                   //echo "harsha";
                   $query = "Select employee.Name, calender.month, sum(sales_fact_table.DollarsSold) as Revenue_Generated FROM calender, sales_fact_table, employee where calender.calenderKey = sales_fact_table.CalenderKey and sales_fact_table.EmployeeKey = employee.EmployeeKey and calender.year= '$first' group by calender.month"; 
                }
                else
                {
                    $query = "Select employee.Name, calender.Quarter, sum(sales_fact_table.DollarsSold) as Revenue_Generated FROM calender, sales_fact_table, employee where calender.calenderKey = sales_fact_table.CalenderKey and sales_fact_table.EmployeeKey = employee.EmployeeKey and calender.year= '$first' group by calender.quarter";  
                }
            
          $ps = $con->prepare($query);

            // Fetch the matching row.
            $ps->execute(array(':id' => $id));
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
                        
            // $data is an array.
            if (count($data) > 0) {
                constructTable($data);
                echo "<br>";
            }
            else {
                print "<h3>(No match.)</h3>\n";
            }
        }
        catch(PDOException $ex) {
            echo 'ERROR: '.$ex->getMessage();
        }    
    ?>
    <br><button onclick="location.href='drill.php'">Go Back</button>
    </div> 
       </div> 
       </div> 
    </div>
</body>
</html>