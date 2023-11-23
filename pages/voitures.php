<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../templates/header-navigation.php";

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

  <!-- Back to top button -->
  <a href="#" id="button"></a>

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs">
    <ul class="breadcrumb">
      <li><a href="/">Accueil</a></li>
      <li><a href="/voitures.php" class="isDisabled">Voitures d'occasion</a></li>
    </ul>
    <div class="go-back-list">
      <a href="javascript:history.back(1)">Revenir à la page précédente</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- CARS  -->
  <section id="cars" class="used-cars sections filtering">
    <h2 class="header-titles">Nos voitures d'occasions</h2>

    <?php if ($cars) : ?>
      <div class="filter-cars">


        <?php if (count($cars) > 1) : ?>
          <article class="filters">

            <div class="filter-group">
              <p class="filter-group-title">Kilométrage</p>
              <input type="hidden" id="hidden_mininum_kilometer" value="<?= $carMinKilometer ?>" />
              <input type="hidden" id="hidden_maximum_kilometer" value="<?= $carMaxKilometer ?>" />
              <p id="kilometer_show" class="mb-2"><?= $carMinKilometer . "km" . " - " . $carMaxKilometer . "km" ?></p>
              <div id="kilometer_range"></div>
              <button type="button" id="reset-button-k" class="btn-wire mt-3">Réinitialiser</button>
            </div>
            <div class="filter-group">
              <p class="filter-group-title">Prix</p>
              <input type="hidden" id="hidden_mininum_price" value="<?= $carMinPrice ?>" />
              <input type="hidden" id="hidden_maximum_price" value="<?= $carMaxPrice ?>" />
              <p id="price_show" class="mb-2"><?= $carMinPrice . "€" . " - " . $carMaxPrice . "€" ?></p>
              <div id="price_range"></div>
              <button type="button" id="reset-button-p" class="btn-wire mt-3">Réinitialiser</button>
            </div>
            <div class="filter-group">
              <p class="filter-group-title">Année</p>
              <input type="hidden" id="hidden_mininum_year" value="<?= $carMinYear ?>" />
              <input type="hidden" id="hidden_maximum_year" value="<?= $carMaxYear ?>" />
              <p id="year_show" class="mb-2"><?= $carMinYear . " - " . $carMaxYear ?></p>
              <div id="year_range"></div>
              <button type="button" id="reset-button-y" class="btn-wire mt-3">Réinitialiser</button>
            </div>
          </article>
        <?php endif ?>
        <!-- list cars  -->
        <article class="filter_data cards"></article>
      </div>
    <?php else : ?>
      <article class="cards">
        <h3 class="message my-5">Aucune voiture disponsible pour le moment.</h3>
      </article>
    <?php endif ?>
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
      let action = '/fetch/fetch_data.php';
      // get val of mininum and maximum  from sliders
      let mininum_kilometer = $('#hidden_mininum_kilometer').val();
      let maximum_kilometer = $('#hidden_maximum_kilometer').val();
      let mininum_price = $('#hidden_mininum_price').val();
      let maximum_price = $('#hidden_maximum_price').val();
      let mininum_year = $('#hidden_mininum_year').val();
      let maximum_year = $('#hidden_maximum_year').val();

      $.ajax({
        url: "/fetch/fetch_data.php",
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
      min: <?= $carMinKilometer ?>,
      max: <?= $carMaxKilometer ?>,
      //array of min and max value of slider
      values: [<?= $carMinKilometer ?>, <?= $carMaxKilometer ?>],

      //it will trigger when mouse's moves stop
      stop: function(event, ui) {

        //current of minimum and maximum kilometer
        $('#kilometer_show').html(ui.values[0] + "km" + ' - ' + ui.values[1] + "km");

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
      min: <?= $carMinPrice ?>,
      max: <?= $carMaxPrice ?>,
      //array of min and max value of slider
      values: [<?= $carMinPrice ?>, <?= $carMaxPrice ?>],

      //it will trigger when mouse's moves stop
      stop: function(event, ui) {

        //current of minimum and maximum price
        $('#price_show').html(ui.values[0] + "€" + ' - ' + ui.values[1] + "€");

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
      min: <?= $carMinYear ?>,
      max: <?= $carMaxYear ?>,
      //array of min and max value of slider
      values: [<?= $carMinYear ?>, <?= $carMaxYear ?>],

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

    // RESET VALUES OF SLIDERS 

    //reset slider for kilometer
    var reset_slider_kilometer = function(slider_selector) {
      // Reset the sliders to their original min/max values for kilometer
      $(slider_selector).each(function() {
        var options = $(this).slider("option");
        $(this).slider("values", [options.min, options.max]);
      });
    };

    $(function() {
      $('#kilometer_range').slider({
        range: true,
        min: <?= $carMinKilometer ?>,
        max: <?= $carMaxKilometer ?>,
        values: [<?= $carMinKilometer ?>, <?= $carMaxKilometer ?>],
        slide: function(event, ui) {
          $('#kilometer_show').html(ui.values[0] + "km" + ' - ' + ui.values[1] + "km");
        }
      });

      $("#kilometer_show").val(
        $("#kilometer_range").slider("values", 0) +
        $("#kilometer_range").slider("values", 1)
      );

      //reset values of slider to min/max from database
      $("#reset-button-k").on("click", () => {

        //current of minimum and maximum kilometer
        $('#kilometer_show').html(<?= $carMinKilometer ?> + "km" + ' - ' + <?= $carMaxKilometer ?> + "km");

        //store the minimum and maximum values
        $('#hidden_mininum_kilometer').val(<?= $carMinKilometer ?>);
        $('#hidden_maximum_kilometer').val(<?= $carMaxKilometer ?>);

        reset_slider_kilometer("#kilometer_range");

        //fetch minimum and maximum price
        filter_data();
      });
    });


    //reset slider for price
    var reset_slider_price = function(slider_selector) {
      // Reset the sliders to their original min/max values for price
      $(slider_selector).each(function() {
        var options = $(this).slider("option");
        $(this).slider("values", [options.min, options.max]);
      });
    };

    $(function() {
      $('#price_range').slider({
        range: true,
        min: <?= $carMinPrice ?>,
        max: <?= $carMaxPrice ?>,
        values: [<?= $carMinPrice ?>, <?= $carMaxPrice ?>],
        slide: function(event, ui) {
          $('#price_show').html(ui.values[0] + "€" + ' - ' + ui.values[1] + "€");
        }
      });

      $("#price_show").val(
        $("#price_range").slider("values", 0) +
        $("#price_range").slider("values", 1)
      );

      //reset values of slider to min/max from database
      $("#reset-button-p").on("click", () => {
        //current of minimum and maximum price
        $('#price_show').html(<?= $carMinPrice ?> + "€" + ' - ' + <?= $carMaxPrice ?> + "€");

        //store the minimum and maximum values
        $('#hidden_mininum_price').val(<?= $carMinPrice ?>);
        $('#hidden_maximum_price').val(<?= $carMaxPrice ?>);

        reset_slider_price("#price_range");

        //fetch minimum and maximum price
        filter_data();
      });
    });

    //reset slider for year
    var reset_slider_year = function(slider_selector) {
      // Reset the sliders to their original min/max values for year
      $(slider_selector).each(function() {
        var options = $(this).slider("option");
        $(this).slider("values", [options.min, options.max]);
      });
    };

    $(function() {
      $('#year_range').slider({
        range: true,
        min: <?= $carMinYear ?>,
        max: <?= $carMaxYear ?>,
        values: [<?= $carMinYear ?>, <?= $carMaxYear ?>],
        slide: function(event, ui) {
          $('#year_show').html(ui.values[0] + ' - ' + ui.values[1]);
        }
      });

      $("#year_show").val(
        $("#year_range").slider("values", 0) +
        $("#year_range").slider("values", 1)
      );

      //reset values of slider to min/max from database
      $("#reset-button-y").on("click", () => {
        //current of minimum and maximum year
        $('#year_show').html(<?= $carMinYear ?> + ' - ' + <?= $carMaxYear ?>);

        //store the minimum and maximum values
        $('#hidden_mininum_year').val(<?= $carMinYear ?>);
        $('#hidden_maximum_year').val(<?= $carMaxYear ?>);

        reset_slider_year("#year_range");

        //fetch minimum and maximum price
        filter_data();
      });
    });
  })
</script>

<?php
require_once __DIR__ . "/../templates/footer.php";
?>