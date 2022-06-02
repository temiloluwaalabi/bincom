<?php
include "config/connection.php";
?>
<?php include_once "includes/header.php" ?>

<h1 class="text-center my-4">Polling Unit Result</h1>
<div class="container my-5 d-flex justify-content-center">

   <div class="row section-one bg-light">
        <div class="search col-md-5">
            <form action="" method="POST">
                <div class="row p-3">
                    <div class="col-md-12">
                        <label for="">Polling Unit</label>
                        <select name="votes" class="form-control mb-2 mt-3">
                        <?php
                                //select all rows frim LGA table
                                $sql = "SELECT * FROM lga";
                                $query_run = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $poll) {
                                        $lga_id = $poll['lga_id'];
                                        $lga_name = $poll['lga_name'];
                                        $lga_description = $poll['lga_description']; ?>
                                            <option name = "pollUnit" value="<?php echo $lga_id?>"><?= $lga_name?>---- 
                                            <?= $lga_id?>
                                            </option>

                                        <?php
                                    }
                                } else {
                                    echo " No Record Found";
                                }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-12 pb-3">
                        <button type="submit" class="btn btn-large btn-primary mt-2 w-100" name="total_votes">Total Votes</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-7">
                <?php
                    if (isset($_POST['total_votes'])) {
                        $lgaId = $_POST['votes'];
                        //echo $lgaId;
                        $sql = "SELECT * FROM lga WHERE lga_id = $lgaId";
                        $query_run = mysqli_query($conn, $sql);
                        $idArray = mysqli_fetch_assoc($query_run);
                        if ($idArray) {
                            $lgaName = $idArray['lga_name'];
                        }
                        
                        $query = "SELECT * FROM polling_unit WHERE lga_id = $lgaId";
                        $query1 = mysqli_query($conn, $query); ?>

                        <div class="card">
                            <div class="card-header">
                                <h2>Title</h2>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered w-100">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>LGA ID</th>
                                            <th>LGA Name</th>
                                            <th>Polling Unit UniqueId</th>
                                            <th>Polling Number</th>
                                            <th>Total Count</th>
                                            <th>Polling Unit Name</th>
                                        </tr>
                                    </thead>

                                    <tbody> 
                                    <?php
                                         if (mysqli_num_rows($query1) > 0) {
                                             foreach ($query1 as $row) {
                                                 $uniqueId = $row['uniqueid'];
                                                 $pollingNumber = $row['polling_unit_number'];
                                                 $unitName = $row['polling_unit_name'];
                                                 $totalquery = "SELECT * FROM announced_pu_results WHERE polling_unit_uniqueid = $uniqueId";
                                                 $totalCount = "SELECT SUM(party_score) FROM announced_pu_results WHERE polling_unit_uniqueid = $uniqueId";
                                                 $totalCountQuery = mysqli_query($conn, $totalCount);
                                                 if (mysqli_num_rows($totalCountQuery) > 0) {
                                                     $totalArray = mysqli_fetch_assoc($totalCountQuery);
                                                 }
                                            
                                                 // var_dump($totalArray);
                                                 $totalResult = mysqli_query($conn, $totalquery);
                                                 $myLoop = 0; ?>

                                                <tr>
                                                    <th><?=$lgaId?></th>
                                                    <td><?=$lgaName?></td>
                                                    <td><?=$uniqueId?></td>
                                                    <td><?=$pollingNumber?></td>
                                                    <td><?php foreach ($totalArray as $total) {
                                                     if ($total > 0) {
                                                         echo $total;
                                                     } else {
                                                         echo 0;
                                                     }
                                                 } ?></td>
                                                    <td><?=$unitName?></td>
                                                </tr>
                                    
                                                    <?php
                                             } ?>

                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                                         }
                    }
                        
                        ?>
        </div>
    </div>

    <?php include_once "includes/footer.php" ?>
