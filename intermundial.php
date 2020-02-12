<?php

$url = "https://ws.intermundial.es/travelio-soaTIO/CommonsWSSessionBean?wsdl";
$options = array(
  'trace' => 1,
  'location' => 'https://ws.intermundial.es/travelio-soaTIO/CommonsWSSessionBean',
  'cache_wsdl' => WSDL_CACHE_NONE,
  'soap_action' => 'show',
  'soap_version'   => SOAP_1_1,
  "stream_context" => stream_context_create(
    [
      'ssl' => [
        'verify_peer'      => false,
        'verify_peer_name' => false,
      ]
    ]
  )
);

switch ($_POST['type']) {
    case 'getPrices':
        _getPrices($url, $options);
        break;
    case 'confirm':
        _confirm($url, $options);
        break;
    case 'history':
        _history($url, $options);
        break;
}

function _getPrices($url, $options){
  try {
    $client = new SoapClient($url, $options );
    $result = $client->getAvailabilityV2(
      [ "authenticationData" =>
        [
          "user" => "pruebas_mex",
          "password" => "pruebas_mex",
          "locale" => "es_ES", "domain" =>
          "intermundial-soaMexico"
        ],
        "excludedInfo" => "PRODUCT_DESCRIPTION",
        "availabilitySearchParams" => [
          "adultNumber" => 1,
          "cheaperAvailability" => false,
          "childNumber" => 0,
          "confirmedAvailability" => true,
          "type" => "SERVICE",
          "varietyNumber" =>1,
          "productId" => "d4d366db-eb0f-4456",
          "arrivalDate" => $_POST['init'],
          "departureDate" => $_POST['end']
        ]
      ]
    );
    $ret = array('success' => true, 'msg' => $result);
    echo json_encode($ret);
    exit;
  } catch (Exception $ex) {
    exit("soap error: " . $ex->getMessage());
  }
}

function _confirm($url, $options){
  try {
    $client = new SoapClient($url, $options );
    $result = $client->bookV2([
      "authenticationData" => ["user" => "pruebas_mex", "password" => "pruebas_mex", "locale" => "es_ES", "domain" => "intermundial-soaMexico"],
      "bookingParams" => [
        "bookingLines" => [
          "futureBookingState" => "IN_AGREEMENT",
          "product" => $_POST['product'],
          "arrivalDate" => $_POST['init'],
          "departureDate" => $_POST['end'],
          "sellContract" => $_POST['sellContract'],
          "sellTariff" => $_POST['sellTariff'],
          "sellPriceSheet" => $_POST['sellPriceSheet'],
          "sellCurrency" => $_POST['sellCurrency'],
          "productVariety" => "default",
          "modality" => $_POST['modality'],
          "adultNumber" => $_POST['adultNumber'],
          "passengers" => ["name" => $_POST['name'], "surname" => $_POST['surname'], "age" => $_POST['age']]
        ],
        "holder" => [
          "type" => "NATURAL",
          "pid" => "336412492X",
          "name" => "ADRIAN",
          "surname" => "CORTES",
          "locale" => "es_ES",
        ],
        "onTheFly" => false,
        "thirdReference" => "34661RT",

    ]
      ]
    );
    $ret = array('success' => true, 'msg' => $result);
    echo json_encode($ret);
    exit;
  } catch (Exception $ex) {
    exit("soap error: " . $ex->getMessage());
  }
}

function _history($url, $options){
  // falta ver cual es
}









/*
$url = "https://ws.intermundial.es/travelio-soaTIO/CommonsWSSessionBean?wsdl";

$options = array(
// Stuff for development.
  'trace' => 1,
  'location' => 'https://ws.intermundial.es/travelio-soaTIO/CommonsWSSessionBean',
  'cache_wsdl' => WSDL_CACHE_NONE,
  'soap_action' => 'show',
  'soap_version'   => SOAP_1_1,
  "stream_context" => stream_context_create(
    [
      'ssl' => [
        'verify_peer'      => false,
        'verify_peer_name' => false,
      ]
    ]
  )
);

try {
  $client = new SoapClient($url, $options );

    $types = $client->__getTypes ();
    $functions = $client->__getFunctions ();

    //echo '############################### TIPOS ###############################';
    //echo "<pre/>";print_r($types);

    //echo '############################### FUNCIONES ###############################';
    //echo "<pre/>";print_r($functions);

    $result = $client->getProduct( [ "authenticationData" => ["user" => "pruebas_mex", "password" => "pruebas_mex", "locale" => "es_ES", "domain" => "intermundial-soaMexico"], "shortName" => "YMX123" ] );
    print_r($result);
    echo '--------------------------------- 01 ---------------------------------';
    print_r($result->product->code);


//echo '############################### TIPOS DE PRODUCTOS ###############################';
//$result = $client->getProductTypes();
//print_r($result);
//echo '------------------------------------------------------------------';*

/*echo '############################### CATEGORIAS DE PRODUCTO ###############################';
$resultt = $client->getProductTypeCategorizations([ "authenticationData" => ["user" => "pruebas_mex", "password" => "pruebas_mex", "locale" => "es_ES", "domain" => "intermundial-soaMexico"], "productType" => "SERVICE" ]);
print_r($resultt); // [code] => 004 [shortName] => INSURANCE [longName] => 004 [description] => 004 [locale] => es_ES [typeID] => SERVICE
echo '------------------------------------------------------------------';*

/*echo '############################### 1 ###############################'; // NO JALA, MANDA ERROR EN EL ID
$result = $client->getProduct( [ "authenticationData" => ["user" => "pruebas_mex", "password" => "pruebas_mex", "locale" => "es_ES", "domain" => "intermundial-soaMexico"], "shortName" => "Seguros" ] );
print_r($result);
echo '------------------------------------------------------------------';*

echo '############################### 2 ###############################'; // NO TRAE DATOS
$resultc = $client->getProductContents( [ "authenticationData" => ["user" => "pruebas_mex", "password" => "pruebas_mex", "locale" => "es_ES", "domain" => "intermundial-soaMexico"], "productCode" => "d4d366db-eb0f-4456", "productType" => "SERVICE" ] );
print_r($resultc);
echo '------------------------------------------------------------------';







} catch (Exception $ex) {
  exit("soap error: " . $ex->getMessage());
}
*/

?>
