<?php
$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$showsidepre = $hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT);
$showsidepost = $hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT);

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
    <meta name="description" content="<?php p(strip_tags(format_text($SITE->summary, FORMAT_HTML))) ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
    
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

    <div id="page-header" class="clearfix">
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
        <div id="page-header-top-middle"><label for="slider_value"><?php if ($current_language=='de') echo 'Schrift'; else echo 'Font'; ?> </label><input value="" id="slider_value" name="slider_value" /><span id="slider"> </span><div id="save_buttons"><a href="#" id="save_fontsize">speichern</a><a href="#" id="save_default">standard</a></div></div>
        <div id="page-header-top-right"><?php echo $OUTPUT->login_info(); ?></div>
        <div class="cleaner">&nbsp;</div>
        
        

        <div id="page-header-middle-left"><img src="<?php echo $OUTPUT->pix_url('logo', 'theme')?>" alt="Logo" /></div>
        <div id="page-header-middle-right"><h1 class="page-front"><?php echo $PAGE->heading ?></h1></div>
        <div class="headermenu"><?php
            echo $PAGE->headingmenu;
        ?></div>
        <?php if ($hascustommenu) { ?>
        <div id="custommenu"><?php echo $custommenu; ?></div>
         <?php } ?>
    </div>
<!-- END OF HEADER -->
    <div id="page-front">
        <div id="page-front-wrapper" >
            <div id="page-front-right">
                <div><div class="inv"><?php echo $OUTPUT->main_content() ?></div><?php if ($hassidepost) { echo $OUTPUT->blocks_for_region('side-post'); } ?></div>
            </div>
        </div>
        <div id="page-front-left">
            <div><?php echo $OUTPUT->blocks_for_region('side-pre') ?></div>
        </div>
    </div>
    <div id="page-footer" class="clearfix"></div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>