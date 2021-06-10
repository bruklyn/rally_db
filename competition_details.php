<?php
# load clases
require_once "include/DB.php";
require_once "include/DB_queries.php";
# set new db query instance
$db_queries = new DB_queries();
$competition_id = $_GET['competition'];
$competition = mysqli_fetch_row($db_queries->getCompetitionDetails($competition_id));
$sponsors = mysqli_fetch_all($db_queries->getSponsorsForEvent($competition_id));

?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Rally data table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
    <div class="card">
        <h5 class="card-header"><?php echo $competition[1]?></h5>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"> Norises vieta:<span class="h5"> <?php echo $competition[2] ?></span></li>
                <li class="list-group-item">Sacensību atklāsana: <span class="h5"> <?php echo $competition[3]?></span></li>
                <li class="list-group-item">Sacensību noslēgums:  <span class="h5"> <?php echo $competition[4]?></span></li>
            </ul>
        </div>
    </div>
    <h3 class="mt-3 text-center">Sponsori</h3>
    <div class="card-group">
        <?php
        foreach ($sponsors as $sponsor){
        ?>
            <div class="card">
                <h5 class="card-header"><a href="<?php echo $sponsor[2]?>" target="_blank"><?php echo $sponsor[1]?></a></h5>
                <div class="card-body">
                    <a href="<?php echo $sponsor[2]?>" target="_blank"><img src="images/<?php echo $sponsor[3]?>" class="card-img-top"  style="max-width: 150px" alt=""></a>
                    <p class="card-text"><?php echo $sponsor[4]?></p>
                    <a href="<?php echo $sponsor[2]?>" class="btn btn-primary" target="_blank">Apmeklēt <?php echo $sponsor[1]?></a>
                </div>
            </div>

            <?php
        }
        ?>

        </div>
    <!--


        <div class="card" style="width: 18rem;">
            <h5 class="card-header"></h5>
            <a href="<?php echo $sponsor[2]?>" target="_blank"><img src="images/<?php echo $sponsor[3]?>" class="card-img-top" alt=""></a>
            <div class="card-body">
                <p class="card-text"></p>
                <a href="<?php echo $sponsor[2]?>" class="btn btn-primary" target="_blank">Apmeklēt <?php echo $sponsor[1]?></a
            </div>
        </div>


-->



</body>
</html>


