1.0 First Version

Simple template extends the standard theme
Key Features
- Simple design
- Multi device optimized: "Simple" follows the best practice of using responsive web design, namely serving the same HTML for devices and using only CSS media queries to decide the rendering on each device
- Easy to change the template color (possible to use different colors for different departments)
- The front-page design uses blocks in the content area and displaying them as boxes
- Changeable columns and height in "My home" for each user
- Changeable font size for each user




How to change the default template color?
Substitute #0164A7 with your hex color in style/simple.css



How to use different colors for different departments?
a) create folder new templat folder e.g. name: xyz, color: #E0922E

b) create xyz/config.php
$THEME->name = 'xyz';
$THEME->parents = array('simple','standard','base');
$THEME->sheets = array('skin');
$THEME->enable_dock = true;

c) create xyz/style/skin.css
.color_dept,
.header,
#page-mod-quiz-edit .questionbankwindow div.header,
#page-header-middle-right,
#dockeditempanel .dockeditempanel_hd,
h2.main{
    background-color: #E0922E !important;
}

d) create xyz/pix/logo.png

e) create xyz/pix/screenshot.png

More infos about Moodle Themes: http://docs.moodle.org/dev/Themes_2.0
