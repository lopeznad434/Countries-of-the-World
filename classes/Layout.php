<?php
class Layout{

  // to build a page we need to pass in the content and user options.
  function __construct($continents, $countries, $userContinent, $userSort){
    $this->continents = $continents;
    $this->countries = $countries;
    $this->userContinent = $userContinent;
    $this->userSort = $userSort;
  }

  // The head section is fairly static. It includes bootstrap and fontawesome.
  function header(){

    $title = ($this->userContinent != "") ? $this->userContinent : "Countries of the World";

    ?>
    <!doctype html>
    <html lang="en">
    <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
      <title><?= $title ?></title>

      <!-- Bootstrap  https://v5.getbootstrap.com/ -->
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js" integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">

      <link rel="stylesheet" href="styles.css">

      <!-- FontAwesome (get your own "Kit" at https://fontawesome.com )-->
      <script src="https://kit.fontawesome.com/5535203e19.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php
  }

  // Navbar based on https://v5.getbootstrap.com/docs/5.0/components/navbar/#nav
  function navigation(){ ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarToggler">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <?php
          $active = ($this->userContinent != '' )? $this->userContinent : "World";
          $this->menuItem('World', $active, $sortBy);
          foreach ($this->continents as $name){
            $this->menuItem($name, $active, $sortBy);
          }
        ?>
        </ul>
      </div>
      </div>
    </nav>
    <?php
  }

  // Link Markup Based on https://v5.getbootstrap.com/docs/5.0/components/navbar/#nav
  function menuItem($name, $active, $sortBy){
    $style = ($name == $active)? 'class="nav-link active"' : 'class="nav-link"';
    $url = '?Continent='.$name.'&Sort='.$sortBy;
    echo '<li class="nav-item" >
        <a '.$style.' href="'.$url.'">'.$name.'</a>
      </li>';
  }

  // Banner typography based on Bootstrap markup:
  // https://v5.getbootstrap.com/docs/5.0/content/typography/#display-headings
  // https://v5.getbootstrap.com/docs/5.0/content/typography/#lead
  // See also: Spacing utilities
  // https://v5.getbootstrap.com/docs/5.0/utilities/spacing/
  function banner(){
    $rowCount = ($this->countries)? count($this->countries) : 0;
    $bannerText = ($this->userContinent != "") ? $this->userContinent : "Countries of the World";
    ?>
    <div id="banner" class="container-fluid py-5">
      <div class="container">
        <h1 class="display-4 text-white"><?= $bannerText ?></h1>
        <p class="lead text-white">Listing <?= $rowCount ?> Countries</p>
      </div>
    </div>
    <?php
  }

  // Form layout via Bootstrap Input Group.
  // https://v5.getbootstrap.com/docs/5.0/forms/input-group/#custom-select
  function sortUI(){ ?>
    <div class="container">
      <form class="col-4 mb-4 mt-4 pl-0" method="get">
        <div class="input-group">
          <input type="hidden" name="Continent" value="<?=$this->userContinent?>" />
          <select name="Sort" class="form-select">
            <option selected>Sort by...</option>
            <?php
              $sortOptions = [
                'Name' => 'Name (A-Z)',
                'Population' => 'Population',
                'LifeExpectancy' => 'Life Expectancy'
              ];
              // loop through the options array; create options
              foreach ($sortOptions as $columnName => $humanFriendly){
                $status = ($this->userSort == $columnName ) ? 'selected': '';
                echo '<option value="'.$columnName.'" '.$status.'>'.
                      $humanFriendly.
                  '</option>';
              }
            ?>
          </select>
          <div class="input-group-append">
            <input type="submit" class="btn btn-outline-secondary" value="Sort"></input>
          </div>
        </div>
      </form>
    </div>
    <?php
  }

  // Use CSS grid to layout the bootstrap cards.
  // for details check out #grid in styles.css
  function grid(){
    if (! $this->countries){ return; }
    ?>
    <div class="container">
      <div id="grid" class="mb-4">
        <?php foreach($this->countries as $country) { $country->card(); } ?>
      </div>
    </div>
    <?php
  }

  function footer(){ ?>
    <footer class="footer text-white bg-dark p-5 text-muted">
       <div class="container">
         Created with <a class="text-muted" href="https://v5.getbootstrap.com/">Bootstrap</a> by <a class="text-muted" href="https://www.nsitu.ca">Harold Sikkema</a>. Data: MySQL <a class="text-muted" href="https://dev.mysql.com/doc/world-setup/en/">World</a> database, &copy; <a class="text-muted" href="http://www.stat.fi/worldinfigures">Statistics Finland</a>. Flags: <a class="text-muted" href="https://github.com/hjnilsson/country-flags/">Hampus Joakim Nilsson</a>. Photo by <a class="text-muted" href="https://unsplash.com/photos/-gmNizU6ZCE">Serkan Turk</a>.
       </div>
     </footer>
    </body>
    </html>
    <?php
  }

}  // end of Layout Class.
?>
