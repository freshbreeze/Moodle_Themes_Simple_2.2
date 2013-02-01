<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if (!$showsidepre) {
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
        <div class="headermenu"></div>
        <?php } ?>
    </div>
<?php } ?>
<!-- END OF HEADER -->

    <div id="page-content" class="clearfix">
        <div id="report-main-content">
            <div class="region-content">
                <?php echo $OUTPUT->main_content() ?>
            </div>
        </div>
        <?php if ($hassidepre) { ?>
        <div id="report-region-wrap">
            <div id="report-region-pre" class="block-region">
                <div class="region-content">
                    <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div id="page-footer" class="clearfix"></div>
</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>