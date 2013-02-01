<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?> notfrontpage">
<?php echo $OUTPUT->standard_top_of_body_html() ?>
<div id="page">
<?php if ($hasheading || $hasnavbar) { ?>
    <div id="page-header">
        <?php if ($hasheading) {
        if(current_language()=='de'){
            $showheader = 'Header einblenden';
        }else{
            $showheader = 'Show Header';
        }
        ?>
        <div id="show_header"><a href="javascript:showHeader();"><?php echo $showheader; ?></a></div>
        <div id="page-header-top-left"><?php
            $languages = get_string_manager()->get_list_of_translations();
            $current_language = current_language();
            $home = array('de'=>'Startseite','en'=>'Home','es'=>'P&aacute;gina Principal','fr'=>'Accueil','it'=>'Home');
            $s = '<ul id="TOOLREF"><li><a href="'.$CFG->wwwroot.'/">'.$home[$current_language].'</a></li>';
            foreach ($languages as $key => $v) {
                if($key==$current_language){
                    $s .= '<li>'.$key.'</li>';
                }else{
                    $s .= '<li><a href="'.$CFG->wwwroot.'/?lang='.$key.'" title="'.$v.'">'.$key.'</a></li>';
                }
            }
            $s .= '</ul>';
            echo $s; ?></div>
        <div id="page-header-top-middle"><label for="slider_value"><?php if ($current_language=='de') echo 'Schrift'; else echo 'Font'; ?> </label>
            <input value="" id="slider_value" name="slider_value" />
            <span id="slider"> </span><div id="save_buttons"><a href="#" id="save_fontsize">speichern</a><a href="#" id="save_default">standard</a></div>
        </div>
        <div id="page-header-top-right"><?php echo $OUTPUT->login_info(); ?></div>

        <div class="cleaner">&nbsp;</div>
        <div id="page-header-middle-left"><a href="/?redirect=0"><img src="<?php echo $OUTPUT->pix_url('logo', 'theme')?>" alt="Logo" border="0" /></a></div>
        <div id="page-header-middle-right"><h1><?php echo $PAGE->heading ?></h1></div>
        <?php } ?>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
        <?php } ?>
        <?php if ($hasnavbar) { ?>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                <div class="navbutton"> <?php echo $PAGE->button; ?></div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<!-- END OF HEADER -->

    <div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">

                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
                            <?php echo $OUTPUT->main_content() ?>
                        </div>
                    </div>
                </div>

                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
                        
                    <?php
                        // set Layout editing Box in "my home"
                        if(strripos($_SERVER['SCRIPT_NAME'],"my/index.php")){
                            if($_SESSION['USER']->editing==1){
                                $cookie_layout = '';
                                $cookie_height = '';
                                if (isset($_COOKIE['myhome'])) {
                                    $array=explode("&",$_COOKIE['myhome']);
                                    foreach ($array as $v) {
                                        $a=explode("=",$v);
                                        if($a[0] == 'layout'){
                                            $cookie_layout = $a[1];
                                        }else if($a[0] == 'height'){
                                            $cookie_height = $a[1];
                                        }else{
                                            // not possible
                                        }
                                    }
                                }

                                $a_layout = array(1,2,3,4);
                                $a_height = array('auto','12em','18em','24em','30em','36em','42em','48em');
                                if(current_language()=='de'){
                                    $blockheight = 'Block H&ouml;he';
                                    $column      = 'Spalte';
                                    $columns      = 'Spalten';
                                }else{
                                    $blockheight = 'Block height';
                                    $column      = 'column';
                                    $columns      = 'columns';
                                }
                                
                                
                                $html = '';

$html .= '
<div class="block_settings block">
<div class="header"><div class="title"><div class="block_action"></div><h2>Layout</h2></div></div>
<div class="content">
<form action="">';

foreach($a_layout as $v){
    if($v==1){
        $col = $column;
    }else{
        $col = $columns;
    }
    if($cookie_layout == $v){
        $html .= '<input checked="checked" onclick="changeLayout('.$v.');" type="radio" class="layoutoption" id="edit_this_tab_selected_layout'.$v.'" name="edit_this_tab_selected_layout" /><label for="edit_this_tab_selected_layout'.$v.'"> <img style="padding-right:8px" id="edit_this_tab_layoutimg_'.$v.'" src="'.$OUTPUT->pix_url('layout_'.$v.'column', 'theme').'">'.$v.' '.$col.'</label><br />';
    } else {
        $html .= '<input onclick="changeLayout('.$v.');" type="radio" class="layoutoption" id="edit_this_tab_selected_layout'.$v.'" name="edit_this_tab_selected_layout" /><label for="edit_this_tab_selected_layout'.$v.'"> <img style="padding-right:8px" id="edit_this_tab_layoutimg_'.$v.'" src="'.$OUTPUT->pix_url('layout_'.$v.'column', 'theme').'">'.$v.' '.$col.'</label><br />';    
    }
}

$html .= '<br />'.$blockheight.': <select class="selectinput" id="layoutHeight" onchange="changeHeight(this.options[this.selectedIndex].value);" >';

foreach($a_height as $v){
    if($cookie_height == $v){
        $html .= '<option selected="selected" value="'.$v.'">'.$v.'</option>';
    }else{
        $html .= '<option value="'.$v.'">'.$v.'</option>';
    }
}

$html .= '
</select>
</form>
</div>
</div>
';

                                echo $html;  
                            }
                        }
                        ?>
                        
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>

                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div id="page-footer" class="clearfix"></div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>