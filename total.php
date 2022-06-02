<?php
include "config/connection.php";
?>
<?php include_once "includes/header.php" ?>


    <!-- <h1 class="text-center my-4">Polling Unit Result</h1> -->
    <div class="container my-5 d-flex justify-content-center">


        <div class="card">
            <div class="card-header" style="display: flex; align-items:center; justify-content:center;">
                <h2 class="">Political Party Total Votes</h2>
            </div>
            <div class="card-body" style="display: flex; align-items:center; justify-content:center;">
                <table class="table table-bordered w-50">
                    <thead class="table-dark">
                        <tr>
                            <th>Party Name</th>
                            <th>Total Votes</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
        $partyName = ['PDP','DPP','ACN','PPA','CDC','JP'];
        foreach($partyName as $name){
            // echo $name.'</br>';

            $sql = "SELECT SUM(party_score) FROM announced_pu_results WHERE party_abbreviation = '$name'";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                $totalPartyVote = mysqli_fetch_assoc($query);
            }?>
                        <tr>
                            <th><?=$name?></th>
                            <td><?php foreach($totalPartyVote as $total){ if($total > 0){echo $total;}else{echo 0;} }?>
                            </td>
                        </tr>


                        <?php
        
        }?>
                    </tbody>
                </table>
            </div>
        </div>


    <br><br>
    <hr>
    <br><br>

        <table class="table table-bordered w-60">
            <thead class="table-dark">
                <tr>
                    <th scope="col">polling_unit_uniqueid</th>
                    <th scope="col">party_score</th>
                    <th scope="col">party_abbreviation</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM announced_pu_results";
                $result = mysqli_query($conn, $sql);

                while ($results = mysqli_fetch_assoc($result)) {
                    $result_id = $results['result_id'];
                    $poll_unit_id = $results['polling_unit_uniqueid'];
                    $party_score = $results['party_score'];
                    $partyName = $results['party_abbreviation'];

                    echo '
                        
                            <tr>
                                <td>' . $poll_unit_id . '</td>
                                <td>' . $party_score . '</td>
                                <td>' . $partyName . '</td>
                            </tr>

                        ';
                }
                ?>
            </tbody>
        </table>
<?php include_once "includes/footer.php" ?>
