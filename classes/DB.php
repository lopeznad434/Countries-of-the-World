<?php
class DB {

  private $db;

  // https://www.w3schools.com/php/php_oop_constructor.asp
  function __construct(){
    $hostname = "localhost";
    $username = "ixd1734_citizen";
    $password = "CHjq_Lngu0}T";
    $database = "ixd1734_world";
    $this->db = new mysqli($hostname, $username, $password, $database);
    $this->db->set_charset("utf8");
    if ($this->db->connect_error) {  die("Error: " . $db->connect_error);   }
  }

  // get a list of all possible continents
  function getContinents(){
    $result = $this->db->query("SELECT DISTINCT `Continent` FROM `country`")->fetch_all();
    $this->continents = array_column($result, 0);
    return $this->continents;
  }

  // get countries and capitals based on the user's Request
  function getCountries($userContinent, $userSort){

    //Build a WHERE clause. Leave blank when no continent is specified.
    $where = ($userContinent != '') ?
      ' WHERE `country`.`Continent` = "'.$userContinent.'" ' :
      '';
    //Build an ORDER BY clause. Leave blank if no sort is specified.
    switch($userSort) {
      case 'Population':      $order = ' ORDER BY `country`.`Population` DESC '; break;
      case 'Name':            $order = ' ORDER BY `country`.`Name` ASC '; break;
      case 'LifeExpectancy':  $order = ' ORDER BY `country`.`LifeExpectancy` DESC '; break;
      default:                $order = '';
    }
    /// Assemble the SQL parts
    $sql = "SELECT `country`.*, `city`.`Name`
      AS `Capital`
      FROM `country`
      JOIN `city`
      ON `city`.`id` = `country`.`capital` ".
      $where.
      $order;
    // Run the query
    $result = $this->db->query($sql);
    while($row = $result->fetch_array()){
      $this->countries[] = new Country($row);
    }
    return $this->countries;
  }

  // If the world is ending:
  // be sure to close your database connection ;)
  function end(){   $this->db->close();   }
}
?>
