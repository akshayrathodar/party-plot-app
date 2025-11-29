<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('uploadFile')) {
    function uploadFile($file, $fileName, $folderName, $platform = 'admin', $oldName = null)
    {
        $fileName = preg_replace('/[^a-z0-9\_\-\.]/i', '', $fileName);
        $filename =
            $fileName . '-' . rand(999999, 10000000) . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/' . $platform . '/' . $folderName;
        // Delete old file if it exists
        if (isset($oldName)) {
            if (gettype($oldName) == 'array') {
                foreach ($oldName as $key => $value) {
                    $filePath = public_path($path . '/' . $value);
                    if (isset($value) && file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            } else {
                $filePath = public_path($path . '/' . $oldName);
                if (isset($oldName) && file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $file->move(public_path($path), $filename);
        return $filename;
    }
}

if (!function_exists('unlinkFile')) {
    function unlinkFile($fileName, $folderName, $platform = 'admin')
    {
        $path = 'uploads/' . $platform . '/' . $folderName;
        if (isset($fileName)) {
            $filePath = public_path($path . '/' . $fileName);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        return true;
    }
}

if (!function_exists('getFile')) {
    function getFile($fileName, $folderName, $platform = 'admin')
    {
        $filePath = null;
        $path = 'uploads/' . $platform . '/' . $folderName;
        if (isset($fileName)) {
            if (file_exists(public_path($path . '/' . $fileName))) {
                $filePath = asset($path . '/' . $fileName);
            }
        }

        return $filePath;
    }
}

if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}

if (!function_exists('getSettingId')) {
    function getSettingId($key, $default = null)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        return $setting ? $setting->id : $default;
    }
}

if (!function_exists('getCompanyLogo')) {
    function getCompanyLogo($defaultLogo = 'assets/admin/images/logo/logo.png')
    {
        $logo = getSetting('company_logo');

        if ($logo && file_exists(public_path('uploads/admin/settings/' . $logo))) {
            return asset('uploads/admin/settings/' . $logo);
        }

        return asset($defaultLogo);
    }
}

if (!function_exists('getThemeColor')) {
    function getThemeColor()
    {
        return getSetting('theme_color', 'color-1');
    }
}

if (!function_exists('getPrimaryColor')) {
    function getPrimaryColor()
    {
        return getSetting('primary_color', '#2B5F60');
    }
}

if (!function_exists('getSecondaryColor')) {
    function getSecondaryColor()
    {
        return getSetting('secondary_color', '#C06240');
    }
}

if (!function_exists('getLayoutType')) {
    function getLayoutType()
    {
        return getSetting('layout_type', 'ltr');
    }
}

if (!function_exists('getSidebarType')) {
    function getSidebarType()
    {
        return getSetting('sidebar_type', 'compact-sidebar');
    }
}

if (!function_exists('getSidebarIcon')) {
    function getSidebarIcon()
    {
        return getSetting('sidebar_icon', 'stroke-svg');
    }
}

if (!function_exists('getDarkMode')) {
    function getDarkMode()
    {
        return getSetting('dark_mode', 'light');
    }
}

if (!function_exists('applyThemeSettings')) {
    function applyThemeSettings()
    {
        $themeColor = getThemeColor();
        $primaryColor = getPrimaryColor();
        $secondaryColor = getSecondaryColor();
        $layoutType = getLayoutType();
        $sidebarType = getSidebarType();
        $sidebarIcon = getSidebarIcon();
        $darkMode = getDarkMode();

        // Apply theme color CSS
        if ($themeColor && $themeColor !== 'color-1') {
            echo '<link id="color" rel="stylesheet" href="' .
                asset('assets/admin/css/' . $themeColor . '.css') .
                '" media="screen">';
        }

        // Apply custom colors via CSS variables
        echo '<style>
            :root {
                --theme-primary: ' .
            $primaryColor .
            ';
                --theme-secondary: ' .
            $secondaryColor .
            ';
            }
        </style>';

        // Apply layout classes
        $bodyClasses = [];

        if ($darkMode === 'dark-only') {
            $bodyClasses[] = 'dark-only';
        } elseif ($darkMode === 'dark-sidebar') {
            $bodyClasses[] = 'dark-sidebar';
        }

        if ($layoutType === 'rtl') {
            $bodyClasses[] = 'rtl';
        } elseif ($layoutType === 'box-layout') {
            $bodyClasses[] = 'box-layout';
        }

        return implode(' ', $bodyClasses);
    }
}

/**
 * Admin Helper Functions
 */

if (!function_exists('toastSuccess')) {
    function toastSuccess($message)
    {
        return redirect()
            ->back()
            ->with('toast', [
                'type' => 'success',
                'message' => $message,
            ]);
    }
}

if (!function_exists('toastError')) {
    function toastError($message)
    {
        return redirect()
            ->back()
            ->with('toast', [
                'type' => 'error',
                'message' => $message,
            ]);
    }
}

if (!function_exists('toastWarning')) {
    function toastWarning($message)
    {
        return redirect()
            ->back()
            ->with('toast', [
                'type' => 'warning',
                'message' => $message,
            ]);
    }
}

if (!function_exists('toastInfo')) {
    function toastInfo($message)
    {
        return redirect()
            ->back()
            ->with('toast', [
                'type' => 'info',
                'message' => $message,
            ]);
    }
}

if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
        ];

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            return false;
        }

        if ($number < 0) {
            return $negative . convertNumberToWord(abs($number));
        }

        $string = $fraction = null;

        if (strpos((string) $number, '.') !== false) {
            [$number, $fraction] = explode('.', (string) $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = (int) ($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convertNumberToWord($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convertNumberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                }
                $string .= $remainder ? convertNumberToWord($remainder) : '';
                break;
        }

        if ($fraction !== null) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $digit) {
                $words[] = $dictionary[$digit];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
}
