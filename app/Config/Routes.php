<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('test', 'Home::test'); // test
$routes->get('map', 'Home::map'); // map centré sur royal club majunga
$routes->get('map/parc-nationaux', 'Map::parcNationaux'); // TODO fait: Afficheo ao @ carte de Madagascar ireo coordonnées ireo (refa connecte @ postgres) (avec le nom du parc près de chaque marqueur
$routes->get('api/all-parcs', 'Api::allParcs'); // api mi-fetch anle parc rehetra
$routes->get('api/all-especes', 'Api::allEspeces');
$routes->get('api/parcs/espece/(:num)', 'Api::parcsByEspece/$1');
$routes->get('api/routes/espece/(:num)', 'Api::routesLeadingToParcWithEspece/$1');
$routes->get('api/routes', 'Api::toutesLesRoutes');