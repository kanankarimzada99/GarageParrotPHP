<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/templates/header-navigation.php";

$cars = getCars($pdo);

//get info for filters
$carMinKilometer = implode(getCarMinKilometer($pdo));
$carMaxKilometer = implode(getCarMaxKilometer($pdo));
$carMinPrice = implode(getCarMinPrice($pdo));
$carMaxPrice = implode(getCarMaxPrice($pdo));
$carMinYear = implode(getCarMinYear($pdo));
$carMaxYear = implode(getCarMaxYear($pdo));
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs">
    <ul class="breadcrumb">
      <li><a href="/">Accueil</a></li>
      <li><a href="#" class="isDisabled">Voitures d'occasion</a></li>
    </ul>
    <div class="go-back-list">
      <a href="#">Revenir liste</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- CARS  -->
  <section id="cars" class="used-cars sections filtering">
    <h2 class="header-titles">Nos voitures d'occasions</h2>
    <div class="filter-cars">
      <article class="filters">

        <div class="filter-group">
          <h3 class="filter-group-title">Kilométrage</h3>
          <input type="hidden" id="hidden_mininum_kilometer" value="<?=$carMinKilometer ?>" />
          <input type="hidden" id="hidden_maximum_kilometer" value="<?=$carMaxKilometer ?>" />
          <p id="kilometer_show" class="mb-2"><?=$carMinKilometer." - ".$carMaxKilometer ?></p>
          <div id="kilometer_range"></div>
        </div>
        <div class="filter-group">
          <h3 class="filter-group-title">Prix</h3>
          <input type="hidden" id="hidden_mininum_price" value="<?=$carMinPrice ?>" />
          <input type="hidden" id="hidden_maximum_price" value="<?=$carMaxPrice ?>" />
          <p id="price_show" class="mb-2"><?=$carMinPrice." - ".$carMaxPrice ?></p>
          <div id="price_range"></div>
        </div>
        <div class="filter-group">
          <h3 class="filter-group-title">Année</h3>
          <input type="hidden" id="hidden_mininum_year" value="<?=$carMinYear ?>" />
          <input type="hidden" id="hidden_maximum_year" value="<?=$carMaxYear ?>" />
          <p id="year_show" class="mb-2"><?=$carMinYear." - ".$carMaxYear ?></p>
          <div id="year_range"></div>
        </div>
      </article>

      <!-- list cars  -->
      <article class="filter_data cards"></article>
    </div>
  </section>
  <!-- END CARS  -->
</div>


<!-- script to filter cars  -->
<script>
$(document).ready(function() {

  filter_data();

  //fetch data from cars table and display on web page
  function filter_data() {

    //loading animation while the product doesnt appear on web page
    $('.filter_data').html('<div id="loading"></div>');
    let action = 'fetch_data';


    // get val of mininum and maximum  from sliders
    let mininum_kilometer = $('#hidden_mininum_kilometer').val();
    let maximum_kilometer = $('#hidden_maximum_kilometer').val();
    let mininum_price = $('#hidden_mininum_price').val();
    let maximum_price = $('#hidden_maximum_price').val();
    let mininum_year = $('#hidden_mininum_year').val();
    let maximum_year = $('#hidden_maximum_year').val();


    $.ajax({
      url: "fetch_data.php",
      method: "POST",

      //DEFINE WITH DATA WE WANT TO SEND
      data: {
        action: action,
        mininum_kilometer: mininum_kilometer,
        maximum_kilometer: maximum_kilometer,
        mininum_price: mininum_price,
        maximum_price: maximum_price,
        mininum_year: mininum_year,
        maximum_year: maximum_year
      },

      //if ajax request success, il will receive data from server
      success: function(data) {
        $('.filter_data').html(data);
      }
    })
  }

  function get_filter(class_name) {
    let filter = [];

    //get access all attribute of selected checkbox of particular class
    $('.' + class_name).each(function() {

      //push values to the array filter
      filter.push($(this).val());

    });
    return filter;
  }

  //slider kilometers
  $('#kilometer_range').slider({
    //range of the slider
    range: true,
    //minimum and max values of slider
    min: <?= $carMinKilometer?>,
    max: <?= $carMaxKilometer?>,
    //array of min and max value of slider
    values: [<?= $carMinKilometer?>, <?= $carMaxKilometer?>],
    //step of slider on left or right
    step: 1,

    //it will trigger when mouse's moves stop
    stop: function(event, ui) {

      //current of minimum and maximum kilometer
      $('#kilometer_show').html(ui.values[0] + ' - ' + ui.values[1]);

      //store the minimum and maximum values
      $('#hidden_mininum_kilometer').val(ui.values[0]);
      $('#hidden_maximum_kilometer').val(ui.values[1]);

      //fetch minimum and maximum price
      filter_data();
    }
  })

  //slider price
  $('#price_range').slider({
    //range of the slider
    range: true,
    //minimum and max values of slider
    min: <?= $carMinPrice?>,
    max: <?= $carMaxPrice?>,
    //array of min and max value of slider
    values: [<?= $carMinPrice?>, <?= $carMaxPrice?>],
    //step of slider on left or right
    step: 1,

    //it will trigger when mouse's moves stop
    stop: function(event, ui) {

      //current of minimum and maximum price
      $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);

      //store the minimum and maximum values
      $('#hidden_mininum_price').val(ui.values[0]);
      $('#hidden_maximum_price').val(ui.values[1]);

      //fetch minimum and maximum price
      filter_data();
    }
  })

  //slider year
  $('#year_range').slider({
    //range of the slider
    range: true,
    //minimum and max values of slider
    min: <?= $carMinYear?>,
    max: <?= $carMaxYear?>,
    //array of min and max value of slider
    values: [<?= $carMinYear?>, <?= $carMaxYear?>],
    //step of slider on left or right
    step: 1,

    //it will trigger when mouse's moves stop
    stop: function(event, ui) {

      //current of minimum and maximum year
      $('#year_show').html(ui.values[0] + ' - ' + ui.values[1]);

      //store the minimum and maximum values
      $('#hidden_mininum_year').val(ui.values[0]);
      $('#hidden_maximum_year').val(ui.values[1]);

      //fetch minimum and maximum price
      filter_data();
    }
  })
})
</script>

<?php
 require_once __DIR__."/templates/footer.php";
?>