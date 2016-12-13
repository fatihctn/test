<?php 
 public function pagination($total, $per_page, $template)
 {
    $pt = $template['template'];
    $total_pages = ceil($total / $per_page);

    if ($total_pages == 1) {
        return array('start' => ($current_page - 1) * $per_page, 'item' => $per_page, 'pagination' => NULL);
    }

    $list_current_item = isset($template['current_list']) ? $template['current_list'] : 3;

    $start_number = $current_page - ceil(($list_current_item - 1)/2);
    $plus_number = $start_number < 1 ? abs($start_number - 1) : 0;
    $start_number = $plus_number > 0 ? 1 : $start_number;

    $end_number = $current_page + (floor(($list_current_item - 1)/2)) + $plus_number;
    $minus_number = $end_number > $total_pages ? $total_pages - $end_number : 0;
    $end_number = $minus_number > 0 ? $end_number - $minus_number : $end_number;

    $start_number = ($start_number - $minus_number) > 0 ? $start_number - $minus_number : $start_number;

    $loop_number = ($end_number - $start_number) + 1;

    $link = array();
    for ($i=$start_number; $i <= $end_number; $i++) { 
        $link[$i] = $i;
    }

    if ($start_number > 1) {
        $link[1] = 1;
        if ($start_number - 1 > 1) {
            $link[2] = '...';
        }
    }
    if ($end_number < $total_pages) {
        $link[$total_pages] = $total_pages;
        if ($total_pages - $end_number > 1) {
            $link[$total_pages - 1] = '...';
        }
    }
    
    $counter = 0;
    $item_list = array();
    parse_str($_SERVER['QUERY_STRING'], $qs);
    if (isset($pt['prev']) && $current_page != 1) {
        $item_list[$counter]['paginate_url'] = get_pagination_url(1, $qs);
        $item_list[$counter]['paginate_item'] = isset($pt['prev_string']) ? $pt['prev_string'] : '&lt;';
        $counter++;
    }

    ksort($link);
    foreach ($link as $l) {
        $item_list[$counter]['paginate_item', $l);
        if ($l == $current_page) {
            // code...
        }
        elseif ($l == '...') {
            // code...
        }
        else{
            $item_list[$counter]['paginate_url'] = get_pagination_url($l, $qs);
        }
        $counter++;
    }

    if (isset($pt['next']) && $current_page != $total_pages) {
        $item_list[$counter]['paginate_url'] = get_pagination_url($total_pages, $qs);
        $item_list[$counter]['paginate_item'] = isset($pt['next_string']) ? $pt['next_string'] : '&lt;';
    }

    return array('start' => ($current_page - 1) * $per_page, 'item' => $per_page, 'pagination' => $item_list);
 }
 
 public function get_pagination_url($page, $uri = array())
 {
    if ($uri == array()) {
        parse_str($_SERVER['QUERY_STRING'], $uri);
    }
    $uri['page'] = $page;

    $url = str_replace($_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']);
    $url = preg_replace('/^\//', '', $url);

    return $this->RootDir.$url.http_build_query($uri);
 }

?>
