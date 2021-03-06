<?php
# load clases
require_once "include/DB.php";
require_once "include/DB_queries.php";
# set new db query instance
$db_queries = new DB_queries();

$available_competitions = $db_queries->getAllCompetitions();
$available_sponsors = $db_queries->getAllSponsors();

$message = "";
$OK_message = "";
if (isset($_POST['submit-button-sponsor'])) {
    $sponsor_name = $_POST['sponsorName'];
    $sponsor_url = $_POST['sponsorURL'];
    $sponsor_notes = $_POST['sponsorNotes'];
    $competitions = $_POST['sonsorForCompetiton'];
    if($_FILES["sponsorLogo"]["error"] > 0){
        $message .= "Return Code: " . $_FILES["sponsorLogo"]["error"] . "<br />";
    }
    else
    {
        if (file_exists("images/" . $_FILES["sponsorLogo"]["name"]))
        {
            $message .= $_FILES["sponsorLogo"]["name"] . " already exists. <br/>";
        }
        else
        {
            move_uploaded_file($_FILES["sponsorLogo"]["tmp_name"],
                "images/" . $_FILES["sponsorLogo"]["name"]);
            $OK_message .= "Stored in: " . "images/" . $_FILES["sponsorLogo"]["name"] . "<br/>";

            $result =  $db_queries->setSponsorToDb($sponsor_name, $sponsor_url, $_FILES["sponsorLogo"]["name"], $sponsor_notes);
            if($result > 0){
                $OK_message .= "Success!<br/>";
                // set mapping
                foreach ($competitions as $competition_id){
                    $res = $db_queries->setMapping($competition_id, $result);
                    if($res > 0 ){
                        $OK_message .= "Sponsors pievienots sacensibam <br/>";
                    }else{
                        $message .= "Sponsor maping FAILED!!!";
                    }
                }

            }else {
                $message .= "INSERT FAILED!!!";
            }
        }
    }
}

if (isset($_POST['submit-button-competition'])) {
    $competition_name = $_POST['competitionName'];
    $competition_location = $_POST['competitionLocation'];
    $competition_start = $_POST['competitionStart'];
    $competition_end = $_POST['competitionEnd'];

    $sponsor_list = $_POST['competitonSponsors'];

    if($competition_start > $competition_end){
        $message .= "Competition start date cannot be higher than end date";
    }else{
        $result =  $db_queries->setCompetitionToDb($competition_name, $competition_location, $competition_start, $competition_end);
        if($result > 0){
            $OK_message .= "Success!<br/> ";

            // set mapping
            foreach ($sponsor_list as $sponsor_id){
                $res = $db_queries->setMapping($result, $sponsor_id);
                if($res > 0 ){
                    $OK_message .= "Sponsors pievienots sacensibam <br/>";
                }else{
                    $message .= "Sponsor maping FAILED!!!";
                }
            }

        }else {
            $message .= "INSERT FAILED!!! " . $result;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Rally data insert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>
<nav class="nav">
    <a class="nav-link " href="index.php">S??kums</a>
    <a class="nav-link active" href="#">Datu ievade</a>
</nav>

<?php
if(strlen($message) > 0){
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
    <?php
}
?>
<?php
if(strlen($OK_message) > 0){
    ?>
    <div class="alert alert-success" role="alert">
        <?php echo $OK_message; ?>
    </div>
    <?php
}
?>
<div class="card bg-light">
    <h5 class="card-header">Sponsora datu ievade</h5>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sponsorName">Sponsora nosaukums</label>
                <input type="text" maxlength="75" class="form-control" id="sponsorName" name="sponsorName" placeholder="..." required>
            </div>
            <div class="form-group">
                <label for="sponsorURL">Sponsora majas lapas adrese</label>
                <input type="url" maxlength="150" class="form-control" id="sponsorURL" name="sponsorURL" placeholder="http://www.sponsor.com" required>
            </div>

            <div class="form-group">
                <label for="sponsorNotes">Piez??mes</label>
                <textarea maxlength="500" class="form-control" id="sponsorNotes" name="sponsorNotes" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="sponsorLogo">Sponsora logo</label>
                <input type="file" class="form-control-file" id="sponsorLogo" name="sponsorLogo" required>
            </div>

            <div class="form-group">
                <label for="sonsorForCompetiton">Pievienot sponsoru sacens??b??m</label>
                <select multiple class="form-control" id="sonsorForCompetiton" name="sonsorForCompetiton[]">
                    <?php foreach ($available_competitions as $comp) {?>
                    <option value="<?php echo $comp['id'] ?>">"<?php echo $comp['name'] ?>"</option>
                    <?php }?>
                </select>
            </div>

            <button name="submit-button-sponsor" type="submit" class="btn btn-primary mt-3">Saglab??t</button>
        </form>
    </div>
</div>

<div class="card mt-4 bg-light">
    <h5 class="card-header">Sacens??bu datu ievade</h5>
    <div class="card-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="competitionName">Sacens??bu nosaukums</label>
                <input type="text" maxlength="150" class="form-control" id="competitionName" name="competitionName" placeholder="..." required>
            </div>

            <div class="form-group">
                <label for="competitionLocation">Norises vieta</label>
                <textarea maxlength="250" class="form-control" id="competitionLocation" name="competitionLocation" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="competitionStart">Norisin??s no</label>
                <input class="form-control" type="date" id="competitionStart" name="competitionStart" value="2021-01-01">
            </div>

            <div class="form-group">
                <label for="competitionEnd">Norisin??s l??dz</label>
                <input class="form-control" type="date" id="competitionEnd" name="competitionEnd" value="2021-01-01">
            </div>

            <div class="form-group">
                <label for="competitonSponsors">Pievienot sponsoru sacens??b??m</label>
                <select multiple class="form-control" id="competitonSponsors" name="competitonSponsors[]">
                    <?php foreach ($available_sponsors as $sponsor) {?>
                        <option value="<?php echo $sponsor['id'] ?>">"<?php echo $sponsor['name'] ?>"</option>
                    <?php }?>
                </select>
            </div>

            <button name="submit-button-competition" type="submit" class="btn btn-primary mt-3">Saglab??t</button>
        </form>
    </div>
</div>
</body>
</html>