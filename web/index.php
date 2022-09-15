<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mb_internal_encoding("UTF-8");

require_once('vendors/parsedown/Parsedown.php');

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

function stripAccents($str){
    $trans = array(
        'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Ç'=>'C','È'=>'E',
        'É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N',
        'Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U',
        'Û'=>'U','Ü'=>'U','Ý'=>'Y','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a',
        'å'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i',
        'î'=>'i','ï'=>'i','ñ'=>'n','ò'=>'o','ó'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
        'ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ü'=>'u','ý'=>'y','ÿ'=>'y','Ā'=>'A',
        'ā'=>'a','Ă'=>'A','ă'=>'a','Ą'=>'A','ą'=>'a','Ć'=>'C','ć'=>'c','Ĉ'=>'C',
        'ĉ'=>'c','Ċ'=>'C','ċ'=>'c','Č'=>'C','č'=>'c','Ď'=>'D','ď'=>'d','Đ'=>'D',
        'đ'=>'d','Ē'=>'E','ē'=>'e','Ĕ'=>'E','ĕ'=>'e','Ė'=>'E','ė'=>'e','Ę'=>'E',
        'ę'=>'e','Ě'=>'E','ě'=>'e','Ĝ'=>'G','ĝ'=>'g','Ğ'=>'G','ğ'=>'g','Ġ'=>'G',
        'ġ'=>'g','Ģ'=>'G','ģ'=>'g','Ĥ'=>'H','ĥ'=>'h','Ħ'=>'H','ħ'=>'h','Ĩ'=>'I',
        'ĩ'=>'i','Ī'=>'I','ī'=>'i','Ĭ'=>'I','ĭ'=>'i','Į'=>'I','į'=>'i','İ'=>'I',
        'ı'=>'i','Ĵ'=>'J','ĵ'=>'j','Ķ'=>'K','ķ'=>'k','Ĺ'=>'L','ĺ'=>'l','Ļ'=>'L',
        'ļ'=>'l','Ľ'=>'L','ľ'=>'l','Ŀ'=>'L','ŀ'=>'l','Ł'=>'L','ł'=>'l','Ń'=>'N',
        'ń'=>'n','Ņ'=>'N','ņ'=>'n','Ň'=>'N','ň'=>'n','ŉ'=>'n','Ō'=>'O','ō'=>'o',
        'Ŏ'=>'O','ŏ'=>'o','Ő'=>'O','ő'=>'o','Ŕ'=>'R','ŕ'=>'r','Ŗ'=>'R','ŗ'=>'r',
        'Ř'=>'R','ř'=>'r','Ś'=>'S','ś'=>'s','Ŝ'=>'S','ŝ'=>'s','Ş'=>'S','ş'=>'s',
        'Š'=>'S','š'=>'s','Ţ'=>'T','ţ'=>'t','Ť'=>'T','ť'=>'t','Ŧ'=>'T','ŧ'=>'t',
        'Ũ'=>'U','ũ'=>'u','Ū'=>'U','ū'=>'u','Ŭ'=>'U','ŭ'=>'u','Ů'=>'U','ů'=>'u',
        'Ű'=>'U','ű'=>'u','Ų'=>'U','ų'=>'u','Ŵ'=>'W','ŵ'=>'w','Ŷ'=>'Y','ŷ'=>'y',
        'Ÿ'=>'Y','Ź'=>'Z','ź'=>'z','Ż'=>'Z','ż'=>'z','Ž'=>'Z','ž'=>'z','ƀ'=>'b',
        'Ɓ'=>'B','Ƃ'=>'B','ƃ'=>'b','Ƈ'=>'C','ƈ'=>'c','Ɗ'=>'D','Ƌ'=>'D','ƌ'=>'d',
        'Ƒ'=>'F','ƒ'=>'f','Ɠ'=>'G','Ɨ'=>'I','Ƙ'=>'K','ƙ'=>'k','ƚ'=>'l','Ɲ'=>'N',
        'ƞ'=>'n','Ɵ'=>'O','Ơ'=>'O','ơ'=>'o','Ƥ'=>'P','ƥ'=>'p','ƫ'=>'t','Ƭ'=>'T',
        'ƭ'=>'t','Ʈ'=>'T','Ư'=>'U','ư'=>'u','Ʋ'=>'V','Ƴ'=>'Y','ƴ'=>'y','Ƶ'=>'Z',
        'ƶ'=>'z','ǅ'=>'D','ǈ'=>'L','ǋ'=>'N','Ǎ'=>'A','ǎ'=>'a','Ǐ'=>'I','ǐ'=>'i',
        'Ǒ'=>'O','ǒ'=>'o','Ǔ'=>'U','ǔ'=>'u','Ǖ'=>'U','ǖ'=>'u','Ǘ'=>'U','ǘ'=>'u',
        'Ǚ'=>'U','ǚ'=>'u','Ǜ'=>'U','ǜ'=>'u','Ǟ'=>'A','ǟ'=>'a','Ǡ'=>'A','ǡ'=>'a',
        'Ǥ'=>'G','ǥ'=>'g','Ǧ'=>'G','ǧ'=>'g','Ǩ'=>'K','ǩ'=>'k','Ǫ'=>'O','ǫ'=>'o',
        'Ǭ'=>'O','ǭ'=>'o','ǰ'=>'j','ǲ'=>'D','Ǵ'=>'G','ǵ'=>'g','Ǹ'=>'N','ǹ'=>'n',
        'Ǻ'=>'A','ǻ'=>'a','Ǿ'=>'O','ǿ'=>'o','Ȁ'=>'A','ȁ'=>'a','Ȃ'=>'A','ȃ'=>'a',
        'Ȅ'=>'E','ȅ'=>'e','Ȇ'=>'E','ȇ'=>'e','Ȉ'=>'I','ȉ'=>'i','Ȋ'=>'I','ȋ'=>'i',
        'Ȍ'=>'O','ȍ'=>'o','Ȏ'=>'O','ȏ'=>'o','Ȑ'=>'R','ȑ'=>'r','Ȓ'=>'R','ȓ'=>'r',
        'Ȕ'=>'U','ȕ'=>'u','Ȗ'=>'U','ȗ'=>'u','Ș'=>'S','ș'=>'s','Ț'=>'T','ț'=>'t',
        'Ȟ'=>'H','ȟ'=>'h','Ƞ'=>'N','ȡ'=>'d','Ȥ'=>'Z','ȥ'=>'z','Ȧ'=>'A','ȧ'=>'a',
        'Ȩ'=>'E','ȩ'=>'e','Ȫ'=>'O','ȫ'=>'o','Ȭ'=>'O','ȭ'=>'o','Ȯ'=>'O','ȯ'=>'o',
        'Ȱ'=>'O','ȱ'=>'o','Ȳ'=>'Y','ȳ'=>'y','ȴ'=>'l','ȵ'=>'n','ȶ'=>'t','ȷ'=>'j',
        'Ⱥ'=>'A','Ȼ'=>'C','ȼ'=>'c','Ƚ'=>'L','Ⱦ'=>'T','ȿ'=>'s','ɀ'=>'z','Ƀ'=>'B',
        'Ʉ'=>'U','Ɇ'=>'E','ɇ'=>'e','Ɉ'=>'J','ɉ'=>'j','ɋ'=>'q','Ɍ'=>'R','ɍ'=>'r',
        'Ɏ'=>'Y','ɏ'=>'y','ɓ'=>'b','ɕ'=>'c','ɖ'=>'d','ɗ'=>'d','ɟ'=>'j','ɠ'=>'g',
        'ɦ'=>'h','ɨ'=>'i','ɫ'=>'l','ɬ'=>'l','ɭ'=>'l','ɱ'=>'m','ɲ'=>'n','ɳ'=>'n',
        'ɵ'=>'o','ɼ'=>'r','ɽ'=>'r','ɾ'=>'r','ʂ'=>'s','ʄ'=>'j','ʈ'=>'t','ʉ'=>'u',
        'ʋ'=>'v','ʐ'=>'z','ʑ'=>'z','ʝ'=>'j','ʠ'=>'q','ͣ'=>'a','ͤ'=>'e','ͥ'=>'i',
        'ͦ'=>'o','ͧ'=>'u','ͨ'=>'c','ͩ'=>'d','ͪ'=>'h','ͫ'=>'m','ͬ'=>'r','ͭ'=>'t',
        'ͮ'=>'v','ͯ'=>'x','ᵢ'=>'i','ᵣ'=>'r','ᵤ'=>'u','ᵥ'=>'v','ᵬ'=>'b','ᵭ'=>'d',
        'ᵮ'=>'f','ᵯ'=>'m','ᵰ'=>'n','ᵱ'=>'p','ᵲ'=>'r','ᵳ'=>'r','ᵴ'=>'s','ᵵ'=>'t',
        'ᵶ'=>'z','ᵻ'=>'i','ᵽ'=>'p','ᵾ'=>'u','ᶀ'=>'b','ᶁ'=>'d','ᶂ'=>'f','ᶃ'=>'g',
        'ᶄ'=>'k','ᶅ'=>'l','ᶆ'=>'m','ᶇ'=>'n','ᶈ'=>'p','ᶉ'=>'r','ᶊ'=>'s','ᶌ'=>'v',
        'ᶍ'=>'x','ᶎ'=>'z','ᶏ'=>'a','ᶑ'=>'d','ᶒ'=>'e','ᶖ'=>'i','ᶙ'=>'u','᷊'=>'r',
        'ᷗ'=>'c','ᷚ'=>'g','ᷜ'=>'k','ᷝ'=>'l','ᷠ'=>'n','ᷣ'=>'r','ᷤ'=>'s','ᷦ'=>'z',
        'Ḁ'=>'A','ḁ'=>'a','Ḃ'=>'B','ḃ'=>'b','Ḅ'=>'B','ḅ'=>'b','Ḇ'=>'B','ḇ'=>'b',
        'Ḉ'=>'C','ḉ'=>'c','Ḋ'=>'D','ḋ'=>'d','Ḍ'=>'D','ḍ'=>'d','Ḏ'=>'D','ḏ'=>'d',
        'Ḑ'=>'D','ḑ'=>'d','Ḓ'=>'D','ḓ'=>'d','Ḕ'=>'E','ḕ'=>'e','Ḗ'=>'E','ḗ'=>'e',
        'Ḙ'=>'E','ḙ'=>'e','Ḛ'=>'E','ḛ'=>'e','Ḝ'=>'E','ḝ'=>'e','Ḟ'=>'F','ḟ'=>'f',
        'Ḡ'=>'G','ḡ'=>'g','Ḣ'=>'H','ḣ'=>'h','Ḥ'=>'H','ḥ'=>'h','Ḧ'=>'H','ḧ'=>'h',
        'Ḩ'=>'H','ḩ'=>'h','Ḫ'=>'H','ḫ'=>'h','Ḭ'=>'I','ḭ'=>'i','Ḯ'=>'I','ḯ'=>'i',
        'Ḱ'=>'K','ḱ'=>'k','Ḳ'=>'K','ḳ'=>'k','Ḵ'=>'K','ḵ'=>'k','Ḷ'=>'L','ḷ'=>'l',
        'Ḹ'=>'L','ḹ'=>'l','Ḻ'=>'L','ḻ'=>'l','Ḽ'=>'L','ḽ'=>'l','Ḿ'=>'M','ḿ'=>'m',
        'Ṁ'=>'M','ṁ'=>'m','Ṃ'=>'M','ṃ'=>'m','Ṅ'=>'N','ṅ'=>'n','Ṇ'=>'N','ṇ'=>'n',
        'Ṉ'=>'N','ṉ'=>'n','Ṋ'=>'N','ṋ'=>'n','Ṍ'=>'O','ṍ'=>'o','Ṏ'=>'O','ṏ'=>'o',
        'Ṑ'=>'O','ṑ'=>'o','Ṓ'=>'O','ṓ'=>'o','Ṕ'=>'P','ṕ'=>'p','Ṗ'=>'P','ṗ'=>'p',
        'Ṙ'=>'R','ṙ'=>'r','Ṛ'=>'R','ṛ'=>'r','Ṝ'=>'R','ṝ'=>'r','Ṟ'=>'R','ṟ'=>'r',
        'Ṡ'=>'S','ṡ'=>'s','Ṣ'=>'S','ṣ'=>'s','Ṥ'=>'S','ṥ'=>'s','Ṧ'=>'S','ṧ'=>'s',
        'Ṩ'=>'S','ṩ'=>'s','Ṫ'=>'T','ṫ'=>'t','Ṭ'=>'T','ṭ'=>'t','Ṯ'=>'T','ṯ'=>'t',
        'Ṱ'=>'T','ṱ'=>'t','Ṳ'=>'U','ṳ'=>'u','Ṵ'=>'U','ṵ'=>'u','Ṷ'=>'U','ṷ'=>'u',
        'Ṹ'=>'U','ṹ'=>'u','Ṻ'=>'U','ṻ'=>'u','Ṽ'=>'V','ṽ'=>'v','Ṿ'=>'V','ṿ'=>'v',
        'Ẁ'=>'W','ẁ'=>'w','Ẃ'=>'W','ẃ'=>'w','Ẅ'=>'W','ẅ'=>'w','Ẇ'=>'W','ẇ'=>'w',
        'Ẉ'=>'W','ẉ'=>'w','Ẋ'=>'X','ẋ'=>'x','Ẍ'=>'X','ẍ'=>'x','Ẏ'=>'Y','ẏ'=>'y',
        'Ẑ'=>'Z','ẑ'=>'z','Ẓ'=>'Z','ẓ'=>'z','Ẕ'=>'Z','ẕ'=>'z','ẖ'=>'h','ẗ'=>'t',
        'ẘ'=>'w','ẙ'=>'y','ẚ'=>'a','Ạ'=>'A','ạ'=>'a','Ả'=>'A','ả'=>'a','Ấ'=>'A',
        'ấ'=>'a','Ầ'=>'A','ầ'=>'a','Ẩ'=>'A','ẩ'=>'a','Ẫ'=>'A','ẫ'=>'a','Ậ'=>'A',
        'ậ'=>'a','Ắ'=>'A','ắ'=>'a','Ằ'=>'A','ằ'=>'a','Ẳ'=>'A','ẳ'=>'a','Ẵ'=>'A',
        'ẵ'=>'a','Ặ'=>'A','ặ'=>'a','Ẹ'=>'E','ẹ'=>'e','Ẻ'=>'E','ẻ'=>'e','Ẽ'=>'E',
        'ẽ'=>'e','Ế'=>'E','ế'=>'e','Ề'=>'E','ề'=>'e','Ể'=>'E','ể'=>'e','Ễ'=>'E',
        'ễ'=>'e','Ệ'=>'E','ệ'=>'e','Ỉ'=>'I','ỉ'=>'i','Ị'=>'I','ị'=>'i','Ọ'=>'O',
        'ọ'=>'o','Ỏ'=>'O','ỏ'=>'o','Ố'=>'O','ố'=>'o','Ồ'=>'O','ồ'=>'o','Ổ'=>'O',
        'ổ'=>'o','Ỗ'=>'O','ỗ'=>'o','Ộ'=>'O','ộ'=>'o','Ớ'=>'O','ớ'=>'o','Ờ'=>'O',
        'ờ'=>'o','Ở'=>'O','ở'=>'o','Ỡ'=>'O','ỡ'=>'o','Ợ'=>'O','ợ'=>'o','Ụ'=>'U',
        'ụ'=>'u','Ủ'=>'U','ủ'=>'u','Ứ'=>'U','ứ'=>'u','Ừ'=>'U','ừ'=>'u','Ử'=>'U',
        'ử'=>'u','Ữ'=>'U','ữ'=>'u','Ự'=>'U','ự'=>'u','Ỳ'=>'Y','ỳ'=>'y','Ỵ'=>'Y',
        'ỵ'=>'y','Ỷ'=>'Y','ỷ'=>'y','Ỹ'=>'Y','ỹ'=>'y','Ỿ'=>'Y','ỿ'=>'y','ⁱ'=>'i',
        'ⁿ'=>'n','ₐ'=>'a','ₑ'=>'e','ₒ'=>'o','ₓ'=>'x','⒜'=>'a','⒝'=>'b','⒞'=>'c',
        '⒟'=>'d','⒠'=>'e','⒡'=>'f','⒢'=>'g','⒣'=>'h','⒤'=>'i','⒥'=>'j','⒦'=>'k',
        '⒧'=>'l','⒨'=>'m','⒩'=>'n','⒪'=>'o','⒫'=>'p','⒬'=>'q','⒭'=>'r','⒮'=>'s',
        '⒯'=>'t','⒰'=>'u','⒱'=>'v','⒲'=>'w','⒳'=>'x','⒴'=>'y','⒵'=>'z','Ⓐ'=>'A',
        'Ⓑ'=>'B','Ⓒ'=>'C','Ⓓ'=>'D','Ⓔ'=>'E','Ⓕ'=>'F','Ⓖ'=>'G','Ⓗ'=>'H','Ⓘ'=>'I',
        'Ⓙ'=>'J','Ⓚ'=>'K','Ⓛ'=>'L','Ⓜ'=>'M','Ⓝ'=>'N','Ⓞ'=>'O','Ⓟ'=>'P','Ⓠ'=>'Q',
        'Ⓡ'=>'R','Ⓢ'=>'S','Ⓣ'=>'T','Ⓤ'=>'U','Ⓥ'=>'V','Ⓦ'=>'W','Ⓧ'=>'X','Ⓨ'=>'Y',
        'Ⓩ'=>'Z','ⓐ'=>'a','ⓑ'=>'b','ⓒ'=>'c','ⓓ'=>'d','ⓔ'=>'e','ⓕ'=>'f','ⓖ'=>'g',
        'ⓗ'=>'h','ⓘ'=>'i','ⓙ'=>'j','ⓚ'=>'k','ⓛ'=>'l','ⓜ'=>'m','ⓝ'=>'n','ⓞ'=>'o',
        'ⓟ'=>'p','ⓠ'=>'q','ⓡ'=>'r','ⓢ'=>'s','ⓣ'=>'t','ⓤ'=>'u','ⓥ'=>'v','ⓦ'=>'w',
        'ⓧ'=>'x','ⓨ'=>'y','ⓩ'=>'z','Ⱡ'=>'L','ⱡ'=>'l','Ɫ'=>'L','Ᵽ'=>'P','Ɽ'=>'R',
        'ⱥ'=>'a','ⱦ'=>'t','Ⱨ'=>'H','ⱨ'=>'h','Ⱪ'=>'K','ⱪ'=>'k','Ⱬ'=>'Z','ⱬ'=>'z',
        'Ɱ'=>'M','ⱱ'=>'v','Ⱳ'=>'W','ⱳ'=>'w','ⱴ'=>'v','ⱸ'=>'e','ⱺ'=>'o','ⱼ'=>'j',
        'Ꝁ'=>'K','ꝁ'=>'k','Ꝃ'=>'K','ꝃ'=>'k','Ꝅ'=>'K','ꝅ'=>'k','Ꝉ'=>'L','ꝉ'=>'l',
        'Ꝋ'=>'O','ꝋ'=>'o','Ꝍ'=>'O','ꝍ'=>'o','Ꝑ'=>'P','ꝑ'=>'p','Ꝓ'=>'P','ꝓ'=>'p',
        'Ꝕ'=>'P','ꝕ'=>'p','Ꝗ'=>'Q','ꝗ'=>'q','Ꝙ'=>'Q','ꝙ'=>'q','Ꝛ'=>'R','ꝛ'=>'r',
        'Ꝟ'=>'V','ꝟ'=>'v','Ａ'=>'A','Ｂ'=>'B','Ｃ'=>'C','Ｄ'=>'D','Ｅ'=>'E','Ｆ'=>'F',
        'Ｇ'=>'G','Ｈ'=>'H','Ｉ'=>'I','Ｊ'=>'J','Ｋ'=>'K','Ｌ'=>'L','Ｍ'=>'M','Ｎ'=>'N',
        'Ｏ'=>'O','Ｐ'=>'P','Ｑ'=>'Q','Ｒ'=>'R','Ｓ'=>'S','Ｔ'=>'T','Ｕ'=>'U','Ｖ'=>'V',
        'Ｗ'=>'W','Ｘ'=>'X','Ｙ'=>'Y','Ｚ'=>'Z','ａ'=>'a','ｂ'=>'b','ｃ'=>'c','ｄ'=>'d',
        'ｅ'=>'e','ｆ'=>'f','ｇ'=>'g','ｈ'=>'h','ｉ'=>'i','ｊ'=>'j','ｋ'=>'k','ｌ'=>'l',
        'ｍ'=>'m','ｎ'=>'n','ｏ'=>'o','ｐ'=>'p','ｑ'=>'q','ｒ'=>'r','ｓ'=>'s','ｔ'=>'t',
        'ｕ'=>'u','ｖ'=>'v','ｗ'=>'w','ｘ'=>'x','ｙ'=>'y','ｚ'=>'z',);
    return strtr( $str, $trans);
}

$API_HOST = "https://cms.drevo-interier.sk";
$Parsedown = new Parsedown();

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$json = file_get_contents($API_HOST.'/kontakt', false, stream_context_create($arrContextOptions));
$kontakt = json_decode($json);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>drevo-interier.sk</title>

    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--    fonts-->
    <link href='https://fonts.googleapis.com/css?family=Raleway:800,700,500,400,600' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,300italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Serif:400,400italic,700' rel='stylesheet' type='text/css'>

    <link href='https://fonts.googleapis.com/css?family=Alegreya:400,700,700italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">

    <link href="/css/strock-icon.css" rel="stylesheet">
    <!--    owl-carousel-->
    <link rel="stylesheet" href="/vendors/owlcarousel/owl.carousel.css">
    <link href="/vendors/rs-plugin/css/settings.css" rel="stylesheet">
    <link href="/vendors/magnific/magnific-popup.css" rel="stylesheet">
    <!--    css-->
    <link rel="stylesheet" href="/css/style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php
    $target = "onas";
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    if (sizeof($uri) == 2) {
        if (empty($uri[1])) {
            $target = "onas";
        } else {
            $target = $uri[1];
        }
    } else {
        // var_dump($uri);
    }
    if (!file_exists($target . ".php")) {
        include("404.php");
        die();
    } else {
    ?>
        <header class="row header navbar-static-top" id="main_navbar">
            <div class="container">
                <div class="row m0 social-info">
                    <ul class="social-icon">
                        <li class="tel"><i class="fa fa-phone"></i> 
                            <?php 
                            $first = true;
                            foreach ($kontakt->kontaktna_osoba as $kontaktna_osoba) {
                                echo $first ? '' : ' / ';
                                echo "0".chunk_split($kontaktna_osoba->telefon, 3, ' ');
                                $first = false;
                            }
                            ?>
                        </li>
                        <li class="email"><a href="#"><i class="fa fa-envelope-o"></i> <?php echo $kontakt->email;?></a></li>
                    </ul>
                </div>
            </div>
            <div class="logo_part">
                <div class="logo">
                    <a href="/" class="brand_logo">
                        <img src="/images/logo.png" alt="logo image">
                    </a>
                </div>
            </div>
            <div class="main-menu">
                <nav class="navbar navbar-default">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_nav" aria-expanded="false">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->

                    <div class="menu row m0">
                        <ul class="nav navbar-nav navbar-right visible-sm">
                        </ul>
                        <div class="collapse navbar-collapse" id="main_nav">
                            <ul class="nav navbar-nav">
                                <li><a href="/onas">O NÁS<Small></Small></a></li>
                                <li><a href="/eurookna">EUROOKNÁ</a></li>
                                <li><a href="/plastoveokna">PLASTOVÉ OKNÁ</a></li>
                                <li><a href="/zakazkovestolarstvo">ZÁKAZKOVÉ STOLÁRSTVO</a></li>
                                <li><a href="/servis">SERVIS</a></li>
                                <li><a href="/galeria">GALÉRIA</a></li>
                                <li><a href="/kontakt">KONTAKT</a></li>
                            </ul>
                        </div>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>
        </header>
        <!--rv-slider-->

        <?php
        include($target . ".php");
        ?>

        <!--footer-->
        <footer class="row">

            <div class="row m0 footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            Copyright &copy; <a href="/">drevo-interier.sk</a> <?php echo date("Y"); ?>. <br class="visible-xs"> Všetky práva vyhradené.
                        </div>
                        <div class="right col-sm-4">
                            Vytvorilo dizajnové štúdio: <a href="https://www.selfmade.site">Selfmade</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    <?php } ?>
    <script src="/js/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <!--RS-->
    <script src="/vendors/rs-plugin/js/jquery.themepunch.tools.min.js"></script> <!-- Revolution Slider Tools -->
    <script src="/vendors/rs-plugin/js/jquery.themepunch.revolution.min.js"></script> <!-- Revolution Slider -->
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.carousel.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="/vendors/rs-plugin/js/extensions/revolution.extension.video.min.js"></script>
    <script src="https://kit.fontawesome.com/a0bc337480.js" crossorigin="anonymous"></script>
    <script src="/vendors/isotope/isotope.min.js"></script>
    <script src="/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="/vendors/owlcarousel/owl.carousel.min.js"></script>
    <script src="/vendors/magnific/jquery.magnific-popup.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyArzizn5ohoJnQaP3YsZ6zDJs6tOhlwPw8"></script>
    <script src="/js/gmaps.min.js"></script>
    <script src="/js/theme.js"></script>
    <script>
        var url = document.URL;
        if (url.endsWith("/")) {
            url = url.substring(0, url.length - 1);
        }
        var uri = url.split("/");
        var target = uri[uri.length - 1];
        if (target.length == 0) {
            target = 'onas';
        }
        $('ul.nav li').each(function(navItem) {
            if (removeAccents($(this).children().text()).replace(/ /g, '').toLowerCase() == target) {
                $(this).addClass('active');
            }
        });

        function removeAccents(strAccents) {
            var strAccents = strAccents.split('');
            var strAccentsOut = new Array();
            var strAccentsLen = strAccents.length;
            var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
            var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
            for (var y = 0; y < strAccentsLen; y++) {
                if (accents.indexOf(strAccents[y]) != -1) {
                    strAccentsOut[y] = accentsOut.substr(accents.indexOf(strAccents[y]), 1);
                } else
                    strAccentsOut[y] = strAccents[y];
            }
            strAccentsOut = strAccentsOut.join('');
            return strAccentsOut;
        }


        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: false,
                margin: 20,
                nav: false,
                dots: false,
                lazyLoad: true,
                responsiveClass: true,
                autoplay: true,
                autoplayHoverPause: true,
                autoplayTimeout: 2000,
                autoplaySpeed: 700,
                responsive: {
                    0: {
                        items: 2,
                    },
                    600: {
                        items: 3,
                    },
                    1000: {
                        items: 5,
                    }
                }
            });
        });

        $(document).ready(function() {
            // Configure/customize these variables.

            var moretext = "Zobraziť viac";
            var lesstext = "Zobraziť menej";

            $('.eurookna-description p').each(function() {
                var content = $(this).html();
                var showChar = 240; // How many characters are shown by default
                if (content.length > showChar) {
                    while (content.charAt(showChar) != ' ') {
                        showChar -= 1;
                    }
                    var visibleText = content.substr(0, showChar);
                    var hiddenText = content.substr(showChar, content.length - showChar);
                    var html = visibleText + '<span class="moreellipses">...</span><span class="morecontent"><span>' + hiddenText + '</span><a href="" class="read-more submit morelink">' + moretext + '</a>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function() {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
                return false;
            });

            if(window.location.pathname.substr(1) == 'zakazkovestolarstvo'){
                target = window.location.hash.substr(1);
                if(!target.trim()){
                    $('.tab-pane').first().addClass('active');
                    $('.nav-tabs li').first().addClass('active');
                }else{
                    $('.tab-pane').each(function(){
                        if($(this).is('#' + target)){
                            $(this).addClass('active');
                        }    
                    });

                    $('.nav-tabs li').each(function(){
                        if($(this).is('#sidebar-' + target)){
                            $(this).addClass('active');
                        }    
                    });
                }
            }
        });
    </script>
</body>

</html>