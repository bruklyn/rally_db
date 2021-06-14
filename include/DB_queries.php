<?php


class DB_queries extends DB
{
    public function getAllCompetitions(){
        $query = "select * from competitions";
        return $this->selectQuery($query);
    }

    public function getCompetitionYears(){
        $query = "select distinct YEAR(`from`) from competitions order by `from` desc";
        return $this->selectQuery($query);
    }

    public function getCompetitionsByYear($year){
        $query = "select * from competitions where YEAR(`from`) = {$year} order by `from` asc";
        return $this->selectQuery($query);
    }

    public function getCompetitionDetails($id){
        $query = "select * from competitions where id = {$id}";
        return $this->selectQuery($query);
    }

    public function getSponsorsForEvent($competition_id){
        $query = "select * from sponsors where id in(select sponsor_id from sponsor_competition_maping where competition_id = {$competition_id})";
        return $this->selectQuery($query);
    }


    // inset data to db
    public function setSponsorToDb($name, $url, $logo, $notes){
        $query = "insert into sponsors (`name`, url, logo, notes) values ('{$name}', '{$url}', '{$logo}', '{$notes}')";
        return $this->insertQueryGetId($query);
    }

    public function setCompetitionToDb($name, $location, $from, $to){
        $query = "insert into competitions (`name`, location, `from`, `to`) values ('{$name}', '{$location}', '{$from}', '{$to}')";
        return $this->insertQuery($query);
    }

    public function setMapping($id_competition, $id_sponsor){
        $query = "insert into sponsor_competition_maping (competition_id, sponsor_id) values({$id_competition}, {$id_sponsor})";
        return $this->insertQuery($query);
    }

}