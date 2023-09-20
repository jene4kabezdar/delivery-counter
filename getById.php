<?php
    $serviceId = $_GET['id'] ?? 0;
    $source = $_GET['source'] ?? '';
    $target = $_GET['target'] ?? '';
    $weight = $_GET['weight'] ?? 1.;
    $serviceManager = new ServiceManager($source, $target, $weight);
    echo $serviceManager->getByServiceId($serviceId);