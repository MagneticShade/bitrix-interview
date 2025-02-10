<?php
namespace Facebook\WebDriver;

// import the required libraries
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/vendor/autoload.php");



// specify the URL to the local Selenium Server


// function to extract data from the page
function scraper($driver):array {

    // maximize the window
    $driver->manage()->window()->maximize();
    // extract the product container
    $wrapper = $driver->findElement(WebDriverBy::cssSelector(".search-results__wrapper"));
    $news = $wrapper->findElements(WebDriverBy::cssSelector(".search-results__item._news"));
    // loop through the product container to extract names and prices
    $data = array();
    foreach ($news as $el) {
        $title = $el->findElement(WebDriverBy::cssSelector(".card-full-news__title"))->getText();
        $anounce = $el->findElement(WebDriverBy::cssSelector(".card-full-news__announce"))->getText();
        $link = $el->findElement(WebDriverBy::cssSelector(".card-full-news._search"))->getAttribute("href");
       
        $data[]= array("NAME"=> $title,"PREVIEW_TEXT"=> $anounce,);
 
    }
    $driver->quit();
    return $data;
}

function getData():array{

$host = "http://localhost:4444/";

// specify the desired capabilities
$capabilities = DesiredCapabilities::chrome();
$chromeOptions = new ChromeOptions();

// run Chrome in headless mode
$chromeOptions->addArguments(["--headless"]);

// register the Chrome options
$capabilities->setCapability(ChromeOptions::CAPABILITY_W3C, $chromeOptions);

// initialize a driver to control a Chrome instance
$driver = RemoteWebDriver::create($host, $capabilities);

$driver->get("https://lenta.ru/search?query=%D0%BC%D0%B0%D0%BA%D0%B4%D0%BE%D0%BD%D0%B0%D0%BB%D1%8C%D0%B4%D1%81#size=10|sort=2|domain=1|modified,format=yyyy-MM-dd");
sleep(6);

return scraper($driver);



}
?>