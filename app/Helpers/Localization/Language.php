<?php

namespace App\Helpers\Localization;

class Language {

    public static $cookieExpiration = 60;
    public $currentLanguageCode;

    public function __construct() {
        $this->currentLanguageCode = '';
        $segment = request()->segment(1);
        $segment_arr = explode('-', $segment);
        if (count($segment_arr) > 0) {
            $this->currentLanguageCode = $segment_arr[0];
        }
    }

    /**
     * Find Language
     *
     * @return @return Language|Collection
     */
    public function find() {
        // Get the Language
        $lang = $this->fromUrl();
        //dd($lang);

        return $lang;
    }

    /**
     * Get Language from URL
     *
     * @return Language|Collection
     */
    public function fromUrl() {
        $lang = collect([]);
        $langCode = $this->currentLanguageCode;
        $languages = config('settings.languages');
        $found_key = array_search($langCode, array_column($languages, 'locale'));

        if ($found_key !== false && isset($languages[$found_key])) {
            $lang = collect(['abbr' => $languages[$found_key]['locale']]);
        }
        return $lang;
    }

    public function getDefaultLanguage() {
        $languages = config('settings.languages');
        $found_key = array_search(0, array_column($languages, 'is_default'));
//        dd($found_key);
        if ($found_key !== false && isset($languages[$found_key])) {
            $lang = collect(['abbr' => $languages[$found_key]['locale']]);
             return $lang;
        }


        return collect([]);
    }

    /**
     * Get Language from Database or Config file
     *
     * @return Language|Collection
     */
    public function fromConfig() {
        $lang = collect(['abbr' => config('app.locale')]);
        return $lang;
    }

    public static function setLanguageToCookie($langCode) {
        if (trim($langCode) == '') {
            return collect([]);
        }
        if (isset($_COOKIE['language_code'])) {
            unset($_COOKIE['language_code']);
        }

        $domain = (getSubDomainName() != '') ? getSubDomainName() . '.' . getDomain() : getDomain();
        setcookie('language_code', $langCode, self::$cookieExpiration, '/', $domain);
    }

}
