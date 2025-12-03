<?php

use App\Models\Frontend;
use Illuminate\Support\Facades\Session;

function admin_lang(){
    return 'en';
}

function front_lang(){
    return Session::get('front_lang');
}

function html_decode($text){
    if (is_array($text)) {
        return $text;
    }
    if (!is_string($text)) {
        return $text;
    }
    $decode_text = htmlspecialchars_decode($text, ENT_QUOTES);
    return $decode_text;
}

function currency($amount){

    // currency information will be loaded from session value

    $currency_icon = Session::get('currency_icon');
    $currency_code = Session::get('currency_code');
    $currency_rate = Session::get('currency_rate');
    $currency_position = Session::get('currency_position');

    $amount = $amount * $currency_rate;
    $amount = number_format($amount, 2, '.', ',');

    if($currency_position == 'before_price'){
        $amount = $currency_icon. $amount;
    }elseif($currency_position == 'before_price_with_space'){
        $amount = $currency_icon.' '. $amount;
    }elseif($currency_position == 'after_price'){
        $amount = $amount.$currency_icon;
    }elseif($currency_position == 'after_price_with_space'){
        $amount = $amount.' '.$currency_icon;
    }else{
        $amount = $currency_icon. $amount;
    }

    return $amount;
}

function getAllResourceFiles($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = $dir ."/". $value;
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getAllResourceFiles($path, $results);
        }
    }
    return $results;
}

function getRegexBetween($content) {

    preg_match_all("%\{{ __\(['|\"](.*?)['\"]\) }}%i", $content, $matches1, PREG_PATTERN_ORDER);
    preg_match_all("%\@lang\(['|\"](.*?)['\"]\)%i", $content, $matches2, PREG_PATTERN_ORDER);
    preg_match_all("%trans\(['|\"](.*?)['\"]\)%i", $content, $matches3, PREG_PATTERN_ORDER);
    $Alldata = [$matches1[1], $matches2[1], $matches3[1]];
    $data = [];
    foreach ($Alldata as  $value) {
        if(!empty($value)){
            foreach ($value as $val) {
                $data[$val] = $val;
            }
        }
    }
    return $data;
}

function generateLang($path = ''){

    // user panel
    $paths = getAllResourceFiles(resource_path('views'));

    $paths = array_merge($paths, getAllResourceFiles(app_path()));

    $paths = array_merge($paths, getAllResourceFiles(base_path('Modules')));

    // end user panel

    $AllData= [];
    foreach ($paths as $key => $path) {
    $AllData[] = getRegexBetween(file_get_contents($path));
    }
    $modifiedData = [];
    foreach ($AllData as  $value) {
        if(!empty($value)){
            foreach ($value as $val) {
                $modifiedData[$val] = $val;
            }
        }
    }

    $modifiedData = var_export($modifiedData, true);

    file_put_contents('lang/en/translate.php', "<?php\n return {$modifiedData};\n ?>");

}

function checkModule($module_name){
    $json_module_data = file_get_contents(base_path('modules_statuses.json'));
    $module_status = json_decode($json_module_data);

    if(isset($module_status->$module_name) && $module_status->$module_name && File::exists(base_path('Modules').'/'.$module_name)){
        return true;
    }

    return false;

}


function getPageSections($arr = false)
{
    $jsonUrl = resource_path('views\admin'). '\settings.json';
    $sections = json_decode(file_get_contents($jsonUrl));
    if ($arr) {
        $sections = json_decode(file_get_contents($jsonUrl), true);
        ksort($sections);
    }
    return $sections;
}

function getImage($content, $key){
    return isset($content->data_values['images'][$key]) ? $content->data_values['images'][$key] : '';
}

function getContent($dataKeys, $singleQuery = false, $limit = null, $orderById = false) {
    $query = Frontend::query();

    if ($singleQuery) {
        $content = $query->where('data_keys', $dataKeys)
            ->orderBy('id', 'desc')
            ->first();
    } else {
        if ($limit != null) {
            $query->limit($limit);
        }

        if ($orderById) {
            $query->orderBy('id');
        } else {
            $query->orderBy('id', 'desc');
        }

        $content = $query->where('data_keys', $dataKeys)->get();
    }

    return $content;
}

function getTranslatedValue($content, $key, $lang = 'en') {
    if (!$content) {
        return '';
    }

    // Handle nested keys (e.g., "package_information")
    $keys = explode('.', $key);

    // If translations exist and language is not English
    if ($lang !== 'en') {
        $translations = json_decode($content->data_translations, true);

        // Loop through the translations to find the matching language code
        if (is_array($translations)) {
            foreach ($translations as $translation) {
                if (isset($translation['language_code']) && $translation['language_code'] === $lang) {
                    // Handle nested keys
                    $value = $translation['values'] ?? [];
                    
                    // If key is simple (not nested), get directly
                    if (count($keys) === 1) {
                        $value = isset($value[$key]) ? $value[$key] : '';
                    } else {
                        // Handle nested keys
                        foreach ($keys as $k) {
                            if (is_array($value) && isset($value[$k])) {
                                $value = $value[$k];
                            } else {
                                $value = '';
                                break;
                            }
                        }
                    }
                    
                    // Return value if it exists (check if key exists in values array)
                    if (count($keys) === 1 && isset($translation['values'][$key])) {
                        // Key exists, return the value
                        $result = is_array($value) ? $value : html_decode($value);
                        return $result;
                    } elseif ($value !== null && $value !== '') {
                        // Return any non-empty value for nested keys
                        return is_array($value) ? $value : html_decode($value);
                    }
                }
            }
        }

        // If no translation found for requested language, return default string
        $decode_value = $content->data_values ?? [];
        if (count($keys) === 1) {
            $decode_value = isset($decode_value[$key]) ? $decode_value[$key] : '';
        } else {
            foreach ($keys as $k) {
                if (is_array($decode_value) && isset($decode_value[$k])) {
                    $decode_value = $decode_value[$k];
                } else {
                    $decode_value = '';
                    break;
                }
            }
        }

        return is_array($decode_value) ? $decode_value : html_decode($decode_value);
    }

    // Fallback to English content
    $decode_value = $content->data_values ?? [];
    if (count($keys) === 1) {
        $decode_value = isset($decode_value[$key]) ? $decode_value[$key] : '';
    } else {
        foreach ($keys as $k) {
            if (is_array($decode_value) && isset($decode_value[$k])) {
                $decode_value = $decode_value[$k];
            } else {
                $decode_value = '';
                break;
            }
        }
    }

    return is_array($decode_value) ? $decode_value : html_decode($decode_value);
}

function randomNumber($length = 10) {
    $random = '';
    $possible = '0123456789';

    for ($i = 0; $i < $length; $i++) {
        $random .= $possible[rand(0, strlen($possible) - 1)];
    }

    return $random;
}


if (!function_exists('getImageOrPlaceholder')) {
    function getImageOrPlaceholder(?string $imagePath, string $size = '800x600'): string
    {
        if ($imagePath && file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }

        return "https://placehold.co/{$size}?text={$size}";
    }
}
