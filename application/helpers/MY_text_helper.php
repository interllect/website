<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('is_assoc'))
{
    function is_assoc($array)
    {
        if (!is_array($array))
        {
            return FALSE;
        }

        foreach (array_keys($array) as $key => $value)
        {
            if ($key !== $value)
            {
                return TRUE;
            }
        }

        return FALSE;
    }
}

if ( ! function_exists('word_censor'))
{
    function word_censor($str, $censored, $replacement = '')
    {
        if ( ! is_array($censored))
        {
            return $str;
        }

        if (is_assoc($censored))
        {
            foreach ($censored as $key => $value)
            {
                if (is_numeric($key))
                {
                    $censored[$value] = $replacement;
                    unset($censored[$key]);
                }
            }
        }
        else
        {
            $censored = array_fill_keys($censored, $replacement);
        }

        $str = ' '.$str.' ';
        foreach ($censored as $badword => $replacement)
        {
            if ($replacement != '')
            {
                $str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/i", '<span class="censor">'.$badword.'</span>', $str);
            }
            else
            {
                $str = preg_replace("/\b(".str_replace('\*', '\w*?', preg_quote($badword)).")\b/ie", "str_repeat('#', strlen('\\1'))", $str);
            }
        }
    
        return trim($str);
    }
} 

/* End of file word_censor_helper.php */
/* Location: ./system/application/helpers/word_censor_helper.php */