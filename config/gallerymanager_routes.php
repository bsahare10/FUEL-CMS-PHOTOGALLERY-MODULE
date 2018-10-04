<?php 
    $route[FUEL_ROUTE.'image/gallerymanager'] = 'gallerymanager';

    $route[FUEL_ROUTE.'image/gallerymanager/add_group'] = 'gallerymanager/add_group';
    $route[FUEL_ROUTE.'image/gallerymanager/add_images'] = 'gallerymanager/add_images';

    $route[FUEL_ROUTE.'image/update_status'] = 'gallerymanager/update_status';
    $route[FUEL_ROUTE.'image/insert_group'] = 'gallerymanager/insert_group';
    $route[FUEL_ROUTE.'image/gallerymanager/insert_group'] = 'gallerymanager/insert_group';
    $route[FUEL_ROUTE.'image/gallerymanager/update_image/(:num)'] = 'gallerymanager/update_image/$1';
    $route[FUEL_ROUTE.'image/gallerymanager/update_image/insertImages'] = 'gallerymanager/insertImages';
    $route[FUEL_ROUTE.'image/gallerymanager/insertImages'] = 'gallerymanager/insertImages';

    $route[FUEL_ROUTE.'image/gallerymanager/deleteGroup/(:num)'] = 'gallerymanager/deleteGroup/$1';
    $route[FUEL_ROUTE.'image/gallerymanager/deleteNews/(:num)'] = 'gallerymanager/deleteNews/$1';
    $route[FUEL_ROUTE.'image/gallerymanager/deleteGroup/delete_process'] = 'gallerymanager/delete_process';
    $route[FUEL_ROUTE.'image/gallerymanager/deleteNews/delete_process'] = 'gallerymanager/delete_process';
    $route[FUEL_ROUTE.'image/gallerymanager/delete/(:any)'] = 'gallerymanager/delete/$1';
    $route[FUEL_ROUTE.'image/gallerymanager/delete/delete_process'] = 'gallerymanager/delete_process';
