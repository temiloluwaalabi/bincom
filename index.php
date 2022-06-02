<?php
include "config/connection.php";
?>


<?php include_once "includes/header.php" ?>
    <h1 class="text-center my-4">Polling Unit Result</h1>
    <div class="container my-5 d-flex justify-content-center">

    <div class="row section-one bg-light p-3">
        <div class="search col-md-5">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Polling Unit</label>
                        <select name="unit" class="form-control mb-3">
                    <?php
                        $sql = "SELECT * FROM polling_unit WHERE uniqueid BETWEEN 8 AND 27";
                        $query_run = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $poll){
                                session_start();
                                $idPoll = $poll['uniqueid'];
                                $_SESSION['id'] = $idPoll;
                                ?>
                                    <option name = "pollUnit" value="<?php $id = $poll['uniqueid']; echo $id?>"><?= $poll['polling_unit_number']?>---- 
                                    <?= $poll['polling_unit_name']?>
                                    <?= $poll['uniqueid']?>
                                    </option>

                                <?php
                            }
                        }else{
                            echo " No Record Found";
                        }
                        ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="w-100 btn btn-primary mt-4" name="search_poll">Update
                            Poll Unit</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-7">
        <?php 
            if (isset($_POST['search_poll'])) {
                $id = $_POST['unit'];
                $pollSql = "SELECT * FROM polling_unit WHERE uniqueid = $id";
                $pollQuery = mysqli_query($conn, $pollSql);
                $pollArray = mysqli_fetch_assoc($pollQuery);
                if($pollArray){
                    $pollName = $pollArray['polling_unit_name'];
                    $pollNumber = $pollArray['polling_unit_number'];
                    $pollDesc = $pollArray['polling_unit_description'];
                }

                $sql = "SELECT * FROM announced_pu_results WHERE polling_unit_uniqueid = $id";
                $query = mysqli_query($conn, $sql);

                ?>

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; align-items:center;">
                            <h4 class="card-title name" style="text-transform: uppercase;"><?=$pollName?></h5>
                            <h6 class="name-number"><?=$pollNumber?></h6>
                        </div>
                        
                        <p class="poll-desc"><?=$pollDesc?></p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered w-100">
                            <thead class="table-dark">
                                <tr>
                                            <th scope="col">Party Name</th>
                                            <th scope="col">Party Score</th>
                                        </tr>
                            </thead>
                            <tbody>  
                <?php

                if (mysqli_num_rows($query) > 0) {
                    foreach ($query as $poll) {
                        // $pollingUnitName=
                        // $pollingUnitNumber
                        $partyName = $poll['party_abbreviation'];
                        $partyScore= $poll['party_score']; 
                ?>

                                    <tr>
                                        <th scope="row"><?= $partyName?></th>
                                        <td><?= $partyScore?></td>
                                    </tr>                                                  
                    <?php
                        }
                    ?>

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

    <br><br>
        
        <table class="table table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th scope="col">unique_id</th>
                    <th scope="col">poll_unit_number</th>
                    <th scope="col">polling_unit_name</th>
                    <th scope="col">lga_id</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM polling_unit WHERE uniqueid BETWEEN 8 AND 27";
                $result = mysqli_query($conn, $sql);

                while ($results = mysqli_fetch_assoc($result)) {
                    $unique_id = $results['uniqueid'];
                    $poll_unit_number = $results['polling_unit_number'];
                    $polling_unit_name = $results['polling_unit_name'];
                    $lga_id = $results['lga_id'];

                    echo '
                        
                            <tr>
                                <th scope="row">' . $unique_id . '</th>
                                <td>' . $poll_unit_number . '</td>
                                <td>' . $polling_unit_name . '</td>
                                <td>' . $lga_id . '</td>
                            </tr>

                        ';
                }

                //var_dump($result);
                ?>
            </tbody>
        </table>

        


        
    </div>



<?php include_once "includes/footer.php" ?>



