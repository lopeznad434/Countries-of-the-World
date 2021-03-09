<?php
class Country{

  // In order to build a country, we will need some data.
  // That's why we pass along a $row to the constructor.
  // https://www.w3schools.com/php/php_oop_constructor.asp
  function __construct($row){

    // Import results from a database row into this particular instance
    $this->exp   =  $row["LifeExpectancy"];
    $this->name  =  $row["Name"];
    $this->cap   =  $row["Capital"];
    $this->code  =  $row["Code"];
    $this->govt  =  $row["GovernmentForm"];
    $this->cont  =  $row["Continent"];
    $this->reg   =  $row["Region"];
    $this->head  =  $row["HeadOfState"];
    $this->pop   =  $row["Population"];
    $this->indep =  $row["IndepYear"];

    // flags use the country code in lowercase form
    $this->code2 =  strtolower($row["Code2"]);
    $this->flag  =  'svg/'.$this->code2.'.svg';

  }

  function card(){
    // Render a Bootstrap "card" with progress bars
    // https://v5.getbootstrap.com/docs/5.0/components/card/#example
    // https://v5.getbootstrap.com/docs/5.0/components/progress/#backgrounds
    // Icons via fontawesome:
    // https://fontawesome.com/how-to-use/
  ?>
   <div class="card text-white bg-dark" >
       <img src="<?=$this->flag?>" class="card-img-top" alt="flag">
       <div class="card-body">
         <h4 class="card-title mb-0">
           <?=$this->name?>
         </h4>
         <p class="card-text">
            <small class="text-muted"><?=$this->govt?></small>
         </p>
         <p class="card-text">
           <i class="fas fa-crown"></i> <?=$this->head?>
         </p>
         <p class="card-text">
           <i class="fas fa-landmark"></i> <?=$this->cap?>
         </p>
         <p class="card-text">
           <i class="fas fa-globe"></i> <?=$this->cont?> / <?=$this->reg?>
         </p>

       </div>
       <!-- see: https://v5.getbootstrap.com/docs/5.0/components/list-group/#basic-example -->
       <ul class="list-group list-group-flush">
        <li class="list-group-item bg-secondary">
          <h6>
            <i class="fas fa-heartbeat"></i> Life Expectancy
          </h6>
          <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: <?=$this->exp?>%" ><?=$this->exp?> years</div>
          </div>
        </li>
        <li class="list-group-item bg-secondary">
          <h6>
            <i class="fas fa-users"></i> Population
          </h6>
          <div class="progress">
            <div class="progress-bar" role="progressbar"
              style="width: <?=$this->populationScore()?>%">
              <?=$this->pop?>
            </div>
          </div>
        </li>
      </ul>
      <div class="card-footer">
        <?=$this->independence()?>
      </div>
   </div>
   <?
 }  // end card()


  function independence(){
    // Some counties are not yet independent.
    // In this case we want to show the form of gov't instead.
    if ( $this->indep != ''){
      return
        '<small class="text-success">'.
          '<i class="fas fa-flag"></i> Independent Since: '.
          '<b>'.$this->indep.'</b>'.
        '</small>';
    }
    else{
      return '<small class="text-warning">'.$this->govt.'</small>';
    }
  }


  function populationScore(){
    // generate a population Score to fit nicely in a 0-100 range.
    // India and China get a really high score.
    // Every other country is on a different scale.
    if ( $this->pop > 1000000000){  return 98;  }
    else{ return 20 + (80 / 400000000) * $this->pop;  }
  }

} /* end country class */

?>
