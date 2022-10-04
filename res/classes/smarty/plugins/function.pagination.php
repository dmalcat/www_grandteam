<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.pagination.php
 * Type:     function
 * Name:     pagination
 * Purpose:  Outputs automaticaly generated pagination with various customization
 * https://weblog.finwe.info/item/smarty-plugin-pagination
 * Author:   Matej Finwe Humpal <finwe@finwe.info>
 * -------------------------------------------------------------
 */

function smarty_function_pagination($params, &$smarty) {
    $count = empty($params['count']) ? 20 : $params['count']; // Number of items per page
    $total = empty($params['total']) ? 0 : $params['total']; // Number of total items
    $url = empty($params['url']) ? '/' : $params['url']; // url to prepend to all anchors
    $linkparam = empty($params['linkparam']) ? '?page=%d' : $params['linkparam']; //string with page param for sprintf.
    $pageCount = (ceil($total / $count)); // number of last page;
    $page = (!isset($params['page']) || $params['page'] <= 0 || $params['page'] > $pageCount) ? 1 : $params['page']; // Page number
    $prevText = empty($params['prevText']) ? '&laquo;' : $params['prevText']; // "Previous" text
    $nextText = empty($params['nextText']) ? '&raquo;' : $params['nextText']; // "Next" text
    //$firstText = empty($params['firstText']) ? '&laquo;&laquo; ' : $params['firstText']; // "First text
    //$lastText = empty($params['lastText']) ? '&raquo;&raquo;' : $params['lastText']; // "Last text
    $firstText = $params['firstText']; // "First text
    $lastText = $params['lastText']; // "Last text
    $separator = empty($params['separator']) ? '' . "\n" : $params['separator'] . "\n"; // item separator
//	$separator = empty($params['separator']) ? ' | ' . "\n" : $params['separator'] . "\n"; // item separator
    $outputStyle = empty($params['output']) ? 'page' : (in_array($params['output'], array('page', 'item'))) ? $params['output'] : $smarty->trigger_error("pagination: 'output' parameter must be 'page' or 'item'");
    // Style of outputting items. Either 'page' (1, 2, 3) or 'item' (1-20, 21-40, 41-60)

    $ommit = ($params['ommit'] == 'no') ? false : true;

    // Ommit Offsets are numbers, that limit omitting of pages using
    // difference between current page and returned page.
    // Below lowOmmitOffset, every page is displayed.
    // Between low and middle, every 5th page is displayed
    // Between middle and high, every 10th page is displayed
    // Above high, every 50th page is displayed
    // First and last page are displayed every time

    $lowOmmitOffset = empty($params['lowOmmitOffset']) ? 3 : (is_numeric($params['lowOmmitOffset']) ? $params['lowOmmitOffset'] : $smarty->trigger_error("pagination: 'lowOmmitOffset' parameter must be numeric"));
    $middleOmmitOffset = empty($params['middleOmmitOffset']) ? 7 : (is_numeric($params['middleOmmitOffset']) ? $params['middleOmmitOffset'] : $smarty->trigger_error("pagination: 'middleOmmitOffset' parameter must be numeric"));
    $highOmmitOffset = empty($params['highOmmitOffset']) ? 50 : (is_numeric($params['highOmmitOffset']) ? $params['highOmmitOffset'] : $smarty->trigger_error("pagination: 'hihgOmmitOffset' parameter must be numeric"));


    $return = '';
    $return .= '<nav><ul class="pagination">';

    if ($firstText) {
        $return .= smarty_function_pagination_url($url, $firstText, 1, $page);
    }
    $return .= $separator;

    if ($page > 1 && $page != 2) {
        $return .= '<li><a href="' . $url . sprintf($linkparam, ($page - 1)) . '">' . $prevText . '</a></li>';
        $return .= $separator;
    }

    for ($i = 1; $i < ($pageCount + 1); $i++) {
        switch ($outputStyle) {
            case 'item':
                if ($i == $pageCount) {
                    $max = $total;
                } else {
                    $max = (string) (($i) * $count);
                }
                $text = (string) (($i - 1) * $count + 1) . '-' . $max;
                break;
            case 'page': // fallthrough
            default: $text = (string) $i;
                break;
        }

        if (($i > $page + $lowOmmitOffset || $i < $page - $lowOmmitOffset) && $i != 1 && $i != $pageCount && $ommit) {

            $offset = (abs($page - $i) < $middleOmmitOffset) ? 5 : ((abs($page - $i) > $highOmmitOffset) ? 50 : 10);

            if ($i % $offset == 0) {
                $return .= smarty_function_pagination_url($url . sprintf($linkparam, $i), $text, $i, $page);
                $return .= $separator;
            }
        } else {
            if ($i == 1) {
                $return .= smarty_function_pagination_url($url, $text, $i, $page);
                $return .= $separator;
            } else {
                $return .= smarty_function_pagination_url($url . sprintf($linkparam, $i), $text, $i, $page);
                $return .= $separator;
            }
        }
    }

    if ($page < $pageCount && ($page + 1) != $pageCount) {
        $return .= '<li><a href="' . $url . sprintf($linkparam, ($page + 1)) . '">' . $nextText . '</a></li>';
        $return .= $separator;
    }
    if ($lastText) {
        $return .= smarty_function_pagination_url($url . sprintf($linkparam, $pageCount), $lastText, $pageCount, $page);
    }

    $return .= '</ul></nav>';

    return $return;
}

function smarty_function_pagination_url($url, $text, $page, $current) {
    if ($page == $current) {
        return '<li class="active"><span>' . $text . '</span></li>';
    } else {
        return '<li><a href="' . $url . '">&nbsp;' . $text . '&nbsp;</a></li>';
    }
}
