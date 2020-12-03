<?php

/**
 * PinkCrab :: FunctionConstructors
 *
 *   EXAMPLES Serialised data destructuring.
 *
 * A few basic examples of using this libary to unpack and map JSON/Serialised
 * data into a more useable format.
 *
 */

include_once 'vendor/autoload.php';
include_once 'html.php';

use PinkCrab\FunctionConstructors\Arrays as Arr;
use PinkCrab\FunctionConstructors\Strings as Str;
use PinkCrab\FunctionConstructors\Comparisons as C;
use PinkCrab\FunctionConstructors\GeneralFunctions as F;

$dump = function (...$data): void {
    print('<pre>');
    var_dump(...$data);
    print('</pre>');
};

$apiResponse = \file_get_contents('./fixtures/spaceflightnewsapi.json');
// $dump(C\not(C\isEmpty())([]), $apiResponse, date_create('2020-11-12T16:51:51.000Z'));

// Our DTO object for articles.
class ArticleDTO extends stdClass
{
}

// Custom function formatting a date.
$formatDate = function (DateTimeInterface $date) {
    return $date->format('D jS F Y');
};


$articleDTOSeed = F\recordEncoder(new ArticleDTO());
$htmlSeed = F\recordEncoder([]);

// DTO mapper
$articleFromApiEncoder = array(
    F\encodeProperty('title', F\getProperty('title')),
    F\encodeProperty('image', F\getProperty('imageUrl')),
    F\encodeProperty('url', F\getProperty('url')),
    F\encodeProperty('source', F\getProperty('newsSite')),
    F\encodeProperty('excerpt', F\pipeR(
        Str\append('..'),
        Str\slice(0, 100),
        F\getProperty('summary')
    )),
    F\encodeProperty('date', F\pipeR(
        $formatDate,
        'date_create',
        F\getProperty('publishedAt')
    )),
    F\encodeProperty('hasLaunch', F\pipeR(
        C\not(C\isEmpty()),
        F\getProperty('launches')
    )),
);

// Formats as HTML
// $formatSideArticle =
$ArstechnicaArticles = F\pipe(
    'json_decode',
    Arr\filter(F\propertyEquals('newsSite', 'Arstechnica')),
    Arr\Map($articleDTOSeed(...$articleFromApiEncoder))
)($apiResponse);


$link = asLink('TIT', ['class' => 'apple tree']);
 $dump(
     $link('https://arstechnica.com/science/2020/11/europes-challenger-to-the-falcon-9-rocket-runs-into-more-delays/'),
     $ArstechnicaArticles
 );


    ?>
<div>
    <div>
        <img src="" alt="">
    </div>
    <div>
        <h2> TITLE </h2>

    </div>
</div>