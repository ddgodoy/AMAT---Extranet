<?php use_helper('Fecha') ?>

<h1>Calendario de Eventos</h1>
<div id="contenedor_calendario">
  <table width="100%" border="0" cellpadding="0" cellspacing="3" class="matriz">
    <tbody>
      <tr>
        <td align="right"><?php echo link_to(image_tag('flechita_left2.gif', array('border' => 0)), $module.mes_anterior($year, $month)) ?></td>
        <td colspan="5" align="center" style="font-weight: bold; font-size: 22px;"><?php echo nombre_mes($month) ?> <?php echo $year ?></td>
        <td><?php echo link_to(image_tag('flechita2.gif', array('border' => 0)), $module.mes_siguiente($year, $month)) ?></td>
      </tr>
      <tr class="cal_nombre_dia">
        <td>D</td><td>L</td><td>M</td><td>M</td><td>J</td><td>V</td><td>S</td>
      </tr>
      <?php 
       $i = 0; foreach (weeks($year, $month) as $week): $i++; ?>
      <tr>
        <?php foreach ($week as $kday => $day): ?>
        <?php
          if ($day == 1 || $day < 10) {
          	$day = '0'.$day;
          }
          $eventDay = array_key_exists($day, $evento_list_array) ? true : false;
        ?>
        <?php
        	if ($eventDay) {
        		$classOnTheFly = 'cal_ocupada';
        	} else {
        		$classOnTheFly = $day ? 'cal_dia' : 'cal_fix';
        	}
        ?>
        <td id="day_<?php echo $day ?>" class="<?php echo $classOnTheFly ?>">
        	<?php
        		$link_day = $day ? link_to($day, 'agenda/index?y='.$year.'&m='.$month.'&d='.dos_digitos($day)) : '';

        		if ($eventDay) {
        			echo link_to($day . '<span>'.$evento_list_array[$day].'</span>', 'agenda/index?y='.$year.'&m='.$month.'&d='.$day, array('class'=>'info'));
        		} else {
        			echo $link_day;
        		}
        	?>
        </td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>