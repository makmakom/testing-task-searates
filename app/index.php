<?php

require_once '../vendor/autoload.php';
require_once 'class/Tracker.php';


$track_numbers = [
    'MSKU6874333',
    'PONU7468920',
    'MRKU0922406',
    'MRKU8730863',
    'TRLU6974015',
    'MNBU0354158',
    'SUDU5711295'
];

$tracker = new Tracker();

foreach ($track_numbers as $number):
    $container = $tracker->getByNumber($number);
    ?>


    <h4><?php echo $number ?></h4>

    <?php if (isset($container['error'])): ?>
        <span style="color: red">Error found: <?php echo $container['error'] ?></span>
    <?php continue; endif; ?>


    <span>Type: <b><?php echo $container['container_type'] ?></b></span><br>
    <span>Estimated Arrival Date: <b><?php echo $container['final_delivery'] ?></b></span><br>


    <?php foreach ($container['events'] as $event): ?>
    <ul>
        <li>Location: <?php echo $event['location'] ?></li>
        <li>Country: <?php echo $event['country'] ?></li>
        <li>Expected time: <?php echo $event['expected_time'] ?></li>

        <?php if (!is_null($event['actual_time'])): ?>
            <li>Actual time: <?php echo $event['actual_time'] ?></li>
        <?php endif; ?>

        <li>Activity: <?php echo $event['activity'] ?></li>

        <?php if ($event['is_current']): ?>
            <li style="color: green">Current</li>
        <?php endif; ?>

        <?php if ($event['is_cancelled']): ?>
            <li style="color: red">Cancelled</li>
        <?php endif; ?>
    </ul>
    <?php endforeach; ?>

<?php
endforeach;
