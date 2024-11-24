<!DOCTYPE html>
<?php
 include 'header.php';
 ?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 550px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
        
    /* On small screens, set height to 'auto' for the grid */
    @media screen and (max-width: 767px) {
      .row.content {height: auto;} 
    }
  
  </style>
</head>
<body>

<nav class="navbar navbar-inverse visible-xs">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">HOME</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav hidden-xs">
      <br>
      <ul class="nav nav-pills nav-stacked">
      
      </ul><br>
    </div>
    <br>
    
    <div class="col-sm-9">
      <div class="well">
        <h4 style="text-align: center;">Dashboard</h4>
        <p style="text-align: center;">WELCOME TO EXCUTIVE DASHABOARD OF NIBOYE SECTOR EXCUTIVE</p>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <h4>Users</h4>
            <?php
            // Include the database connection file
            include 'conn.php';

            $staffCount = 0;

            try {
                // Query to count the number of rows in the 'sectorstaff' table
                $stmt = $conn->query("SELECT COUNT(*) FROM sectorstaff");
                
                // Fetch the result
                $staffCount = $stmt->fetchColumn();
            } catch (PDOException $e) {
                // If there's an error, display it
                echo "Error: " . $e->getMessage();
            }
            ?>
            <!-- Display the number of staff -->
            <p><?php echo $staffCount; ?> Users</p>
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="well">
            <h4>Question & Answers</h4>
          </div>
          <table class="table table-bordered">
  <?php
  try {
      // Prepare the SQL query to join citizen_feedback and sectorstaff tables
      $stmt = $conn->prepare("SELECT cf.id AS feedback_id, CONCAT(cf.first_name, ' ', cf.last_name) AS citizen_name, cf.message AS question,r.reply_text,s.staff_reader_name AS staff_name 
      FROM citizen_feedback cf 
      JOIN sectorstaff s ON cf.staff_id = s.id
      LEFT JOIN 
      replies r ON r.feedback_id = cf.id
      ");
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);       
  } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  ?>
  <thead>
    <tr>
      <th>No</th>
      <th>Citizen</th>
      <th>Question</th>
      <th>Staff</th>
      <th>Answer</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($results) > 0): ?>
      <?php foreach ($results as $index => $row): 
        if($row['reply_text'] == ""){
          $reply = "-";
        }else{
          $reply = $row['reply_text'];
        }
        
        ?>
        <tr>
          <td><?php echo $index + 1; ?></td>
          <td><?php echo htmlspecialchars($row['citizen_name']); ?></td>
          <td><?php echo htmlspecialchars($row['question']); ?></td>
          <td><?php echo htmlspecialchars($row['staff_name']); ?></td>
          <td><?php echo $reply; ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="5" class="text-center">No feedback available.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

        </div>
        
      </div>
    </div>
  </div>
</div>

</body>
</html>
