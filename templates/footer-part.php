<div class="footer-day-week">

  <!-- get only first 3 letters of day  -->
  <span class="footer-day"><?= substr($schedule['day'], 0, 3); ?>:&nbsp;</span>

  <!-- morning open  -->
  <?php if(($schedule['day'] === 'samedi'  || $schedule['day'] === 'dimanche') && $schedule['morningOpen'] === "00:00"): ?>
  <span>fermé</span>
  <?php elseif($schedule["morningOpen"] !== "00:00"): ?>
  <span class="morning-open"><?= $schedule['morningOpen'] ?></span>
  <span> - </span>
  <?php endif; ?>

  <!-- morning close  -->
  <?php if(($schedule['day'] === 'samedi'  || $schedule['day'] === 'dimanche') && $schedule['morningClose'] === "00:00"): ?>
  <span></span>
  <?php elseif($schedule["morningClose"] !== "00:00"): ?>
  <span class="morning-close"><?= $schedule['morningClose'] ?></span>
  <?php endif; ?>

  <!-- afternoon open  -->
  <?php if(($schedule['day'] === 'samedi'  || $schedule['day'] === 'dimanche') && $schedule['afternoonOpen'] === "00:00"): ?>
  <span></span>
  <?php elseif($schedule["afternoonOpen"] !== "00:00"): ?>
  <span>,</span>
  <span class="afternoon-open"><?= $schedule['afternoonOpen'] ?></span>
  <span> - </span>
  <?php endif; ?>

  <!-- afternoon close  -->
  <?php if(($schedule['day'] === 'samedi'  || $schedule['day'] === 'dimanche') && $schedule['afternoonClose'] === "00:00"): ?>
  <span></span>
  <?php elseif($schedule["afternoonClose"] !== "00:00"): ?>
  <span class="afternoon-close"><?= $schedule['afternoonClose'] ?></span>
  <?php endif; ?>

</div>