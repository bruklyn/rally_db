<?php
# load clases
require_once "include/DB.php";
require_once "include/DB_queries.php";
# set new db query instance
$db_queries = new DB_queries();
# fetch competition years
$years = mysqli_fetch_all($db_queries->getCompetitionYears());
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Rally data table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>

<nav class="nav">
    <a class="nav-link active" href="#">Sākums</a>
    <a class="nav-link " href="forms.php">Datu ievade</a>
</nav>

<?php
foreach ($years as $year){
    # get data by year and show in table
    $competitions = mysqli_fetch_all($db_queries->getCompetitionsByYear($year[0]));
?>
<div class="card">
    <h5 class="card-header"><?php echo $year[0]?></h5>
    <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nosaukums</th>
                    <th scope="col">Norises vieta</th>
                    <th scope="col">Datums no</th>
                    <th scope="col">Datums līdz</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // output data as table row
                $i = 1;
                foreach ($competitions as $competition){
                    ?>
                    <tr>
                        <th scope="row"><?php echo $i ?></th>
                        <td><a href="competition_details.php?competition=<?php echo $competition[0]?>"><?php echo "{$competition[1]}"?></td>
                        <td><?php echo "{$competition[2]}"?></td>
                        <td><?php echo "{$competition[3]}"?></td>
                        <td><?php echo "{$competition[4]}"?></td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>
    </div>
</div>
<?php }?>
</body>
</html>

