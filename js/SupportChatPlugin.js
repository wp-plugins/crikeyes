var pluginURL = passURL.plugin_url;
function MinimizeChatBox() {

    var origHeight = jQuery("#Crikeyes_ChatBox").css('height');

    if (origHeight == '325px') {
        jQuery("#Crikeyes_ChatBox").animate({ height: '38px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/up_Arrow.png');
    }
    if (origHeight == '38px') {
        jQuery("#Crikeyes_ChatBox").animate({ height: '325px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/down_Arrow.png');
    }
}

function MinimizeChatBoxLeft() {

    var origHeight = jQuery(".Crikeyes_leftside").css('left');

    if (origHeight == '-3px') {
        jQuery(".Crikeyes_leftside").animate({ left: '-234px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/down_Arrow.png');
    }
    if (origHeight == '-234px') {
        jQuery(".Crikeyes_leftside").animate({ left: '-3px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/up_Arrow.png');
    }
}

function MinimizeChatBoxRight() {

    var origHeight = jQuery(".Crikeyes_rightside").css('right');

    if (origHeight == '-65px') {
        jQuery(".Crikeyes_rightside").animate({ right: '-302px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/down_Arrow.png');
    }
    if (origHeight == '-302px') {
        jQuery(".Crikeyes_rightside").animate({ right: '-65px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/up_Arrow.png');
    }
}

function MinimizeChatBoxLeftBottom() {

    var origHeight = jQuery("#Crikeyes_ChatBox").css('height');

    if (origHeight == '325px') {
        jQuery("#Crikeyes_ChatBox").animate({ height: '38px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/up_Arrow.png');
    }
    if (origHeight == '38px') {
        jQuery("#Crikeyes_ChatBox").animate({ height: '325px' });
        jQuery("#Crikeyes_minImage").attr("src", pluginURL+'/crikeyes/images/down_Arrow.png');
    }
}