// Create a YUI instance and request the slider module and its dependencies
YUI().use('node','stylesheet','slider','event-base','cookie', function (Y) {

var xInput;  // input tied to xSlider

// Function to update the input value from the Slider value
function updateInput( e ) {
    this.set( "value", e.newVal );
    //alert('updateInput'+e.newVal);
    // update fontsize
    new Y.StyleSheet("#page { font-size: "+e.newVal+"px; }");
}

function saveValue(){
    var node1 = Y.one('#save_buttons');
    node1.setStyle("display", "block");
}

if (Y.one('#save_fontsize')) {
    var saveFontsize = Y.one( "#save_fontsize" );
    saveFontsize.on("click", function (e) {
        var node = Y.one('#slider_value');
        var fontsize = node.get('value');
        if(fontsize == default_fontsize){
            Y.Cookie.remove("fontsize",{ path : "/" });
        }else{
            Y.Cookie.set("fontsize", fontsize,{ path : "/",expires: new Date("January 12, 2022")});
        }
        var node1 = Y.one('#save_buttons');
        node1.setStyle("display", "none");
    });
}

if (Y.one('#save_default')) {
    var saveDefault = Y.one( "#save_default" );
    saveDefault.on("click", function (e) {
        Y.Cookie.remove("fontsize",{ path : "/" });
        xInput.set("value", default_fontsize);
        // update fontsize
        new Y.StyleSheet("#page { font-size: "+default_fontsize+"px; }");
        var node1 = Y.one('#save_buttons');
        node1.setStyle("display", "none");
    });
}


if (Y.one('#slider_value')) {
    var xSlider = new Y.Slider({
        axis   : 'x',
        length : '60px',
        min    : 10,
        max    : 18,
        value  : cookie_fontsize,
        thumbUrl : M.cfg.wwwroot+'/theme/image.php?theme=simple&amp;image=slider&amp;component=theme'
    });
    // Link the input value to the Slider
    xInput = Y.one( "#slider_value" );
    //xInput.setData( { slider: xSlider } );

    // Pass the input as the third arg to be 'this' inside updateInput
    //xSlider.after( "valueChange", updateInput );
    xSlider.after( "valueChange", updateInput, xInput );

    xSlider.after( "slideEnd", saveValue);

    // Render the Slider next to the input
    xSlider.render('#slider');

    // set input value
    if(cookie_fontsize == undefined){;
        xInput.set("value", default_fontsize);
    }else{
        xInput.set("value", cookie_fontsize);
    }
}


});

// Layout my home

function changeLayout(layout){
YUI().use('node','stylesheet','cookie', function (Y) {
    if(layout == 1){
        // update layout
        new Y.StyleSheet("#page-my-index #region-main .block { float: none; height: auto; width: auto; }");
        changeHeight("auto");
    }else if(layout == 2){
        // update layout
        new Y.StyleSheet("#page-my-index #region-main .block { float: left; width: 48.6%; margin-right: 1%}");
        changeHeight("18em");
    }else if(layout == 3){
        // update layout
        new Y.StyleSheet("#page-my-index #region-main .block { float: left; width: 31.7%; margin-right: 1%}");
        changeHeight("18em");
    }else if(layout == 4){
        // update layout
        new Y.StyleSheet("#page-my-index #region-main .block { float: left; width: 23.6%; margin-right: 1%}");
        changeHeight("18em");
    }
    Y.Cookie.setSub("myhome", "layout", layout,{ path : "/",expires: new Date("January 12, 2022")});
});
}


function changeHeight(height){
YUI().use('node','stylesheet','cookie', function (Y) {
    new Y.StyleSheet("#page-my-index #region-main .block { height: "+height+"; }");
    Y.Cookie.setSub("myhome", "height", height,{ path : "/",expires: new Date("January 12, 2022")});
});
}

function showHeader(){
YUI().use('node','stylesheet', function (Y) {
    new Y.StyleSheet("#show_header{display:none;} .notfrontpage #page-header-top-left, .notfrontpage #page-header-top-middle, .notfrontpage #page-header-top-right, .notfrontpage #page-header-middle-left, .notfrontpage #page-header-middle-middle { display:block !important; }");
});
}