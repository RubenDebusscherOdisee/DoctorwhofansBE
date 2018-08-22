var aantalrecords;
var img;
var eerdermenu;
var taal;
var menu;
var status;
var currentTopic;
var user;
var UID = 0;
var toon = "false";
var slideIndex = 1;
var ip;
var session;
var CONTENTID;
if (jQuery) {
    (function($) {
        $(document).ready(function() {
            $('.megamenu').accessibleMegaMenu();
            setTimeout(function() {
                $('body').removeClass('init');
            }, 100);
        });
    }(jQuery));
}
(function($, window, document) {
    "use strict";
    var pluginName = "accessibleMegaMenu",
        defaults = {
            uuidPrefix: "accessible-megamenu",
            menuClass: "accessible-megamenu",
            topNavItemClass: "accessible-megamenu-top-nav-item",
            panelClass: "accessible-megamenu-panel",
            panelGroupClass: "accessible-megamenu-panel-group",
            hoverClass: "hover",
            focusClass: "focus",
            openClass: "open",
            openDelay: 0,
            closeDelay: 250
        },
        Keyboard = {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38,
            keyMap: {
                48: "0",
                49: "1",
                50: "2",
                51: "3",
                52: "4",
                53: "5",
                54: "6",
                55: "7",
                56: "8",
                57: "9",
                59: ";",
                65: "a",
                66: "b",
                67: "c",
                68: "d",
                69: "e",
                70: "f",
                71: "g",
                72: "h",
                73: "i",
                74: "j",
                75: "k",
                76: "l",
                77: "m",
                78: "n",
                79: "o",
                80: "p",
                81: "q",
                82: "r",
                83: "s",
                84: "t",
                85: "u",
                86: "v",
                87: "w",
                88: "x",
                89: "y",
                90: "z",
                96: "0",
                97: "1",
                98: "2",
                99: "3",
                100: "4",
                101: "5",
                102: "6",
                103: "7",
                104: "8",
                105: "9",
                190: "."
            }
        };
    function AccessibleMegaMenu(element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.mouseTimeoutID = null;
        this.focusTimeoutID = null;
        this.mouseFocused = false;
        this.justFocused = false;
        this.init();
    }
    AccessibleMegaMenu.prototype = (function() {
        var uuid = 0,
            keydownTimeoutDuration = 1000,
            keydownSearchString = "",
            isTouch = typeof window.hasOwnProperty === "function" && !!window.hasOwnProperty("ontouchstart"),
            _getPlugin, _addUniqueId, _togglePanel, _clickHandler, _clickOutsideHandler, _DOMAttrModifiedHandler, _focusInHandler, _focusOutHandler, _keyDownHandler, _mouseDownHandler, _mouseOverHandler, _mouseOutHandler, _toggleExpandedEventHandlers;
        _getPlugin = function(element) {
            return $(element).closest(':data(plugin_' + pluginName + ')').data("plugin_" + pluginName);
        };
        _addUniqueId = function(element) {
            element = $(element);
            var settings = this.settings;
            if (!element.attr("id")) {
                element.attr("id", settings.uuidPrefix + "-" + new Date().getTime() + "-" + (++uuid));
            }
        };
        _togglePanel = function(event, hide) {
            var target = $(event.target),
                that = this,
                settings = this.settings,
                menu = this.menu,
                topli = target.closest('.' + settings.topNavItemClass),
                panel = target.hasClass(settings.panelClass) ? target : target.closest('.' + settings.panelClass),
                newfocus;
            _toggleExpandedEventHandlers.call(this, true);
            if (hide) {
                topli = menu.find('.' + settings.topNavItemClass + ' .' + settings.openClass + ':first').closest('.' + settings.topNavItemClass);
                if (!(topli.is(event.relatedTarget) || topli.has(event.relatedTarget).length > 0)) {
                    if ((event.type === 'mouseout' || event.type === 'focusout') && topli.has(document.activeElement).length > 0) {
                        return;
                    }
                    topli.find('[aria-expanded]').attr('aria-expanded', 'false').removeClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'true');
                    if ((event.type === 'keydown' && event.keyCode === Keyboard.ESCAPE) || event.type === 'DOMAttrModified') {
                        newfocus = topli.find(':tabbable:first');
                        setTimeout(function() {
                            menu.find('[aria-expanded].' + that.settings.panelClass).off('DOMAttrModified.accessible-megamenu');
                            newfocus.focus();
                            that.justFocused = false;
                        }, 99);
                    }
                } else if (topli.length === 0) {
                    menu.find('[aria-expanded=true]').attr('aria-expanded', 'false').removeClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'true');
                }
            } else {
                clearTimeout(that.focusTimeoutID);
                topli.siblings().find('[aria-expanded]').attr('aria-expanded', 'false').removeClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'true');
                topli.find('[aria-expanded]').attr('aria-expanded', 'true').addClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'false');
                if (event.type === 'mouseover' && target.is(':tabbable') && topli.length === 1 && panel.length === 0 && menu.has(document.activeElement).length > 0) {
                    target.focus();
                    that.justFocused = false;
                }
                _toggleExpandedEventHandlers.call(that);
            }
        };
        _clickHandler = function(event) {
            var target = $(event.target).closest(':tabbable'),
                topli = target.closest('.' + this.settings.topNavItemClass),
                panel = target.closest('.' + this.settings.panelClass);
            if (topli.length === 1 && panel.length === 0 && topli.find('.' + this.settings.panelClass).length === 1) {
                if (!target.hasClass(this.settings.openClass)) {
                    //event.preventDefault();
                    //event.stopPropagation();
                    _togglePanel.call(this, event);
                    this.justFocused = false;
                } else {
                    if (this.justFocused) {
                        event.preventDefault();
                        event.stopPropagation();
                        this.justFocused = false;
                    } else if (isTouch && !target.is("a")) {
                        event.preventDefault();
                        event.stopPropagation();
                        _togglePanel.call(this, event, target.hasClass(this.settings.openClass));
                    }
                }
            }
        };
        _clickOutsideHandler = function(event) {
            if ($(event.target).closest(this.menu).length === 0) {
                event.preventDefault();
                event.stopPropagation();
                _togglePanel.call(this, event, true);
            }
        };
        _DOMAttrModifiedHandler = function(event) {
            if (event.originalEvent.attrName === 'aria-expanded' && event.originalEvent.newValue === 'false' && $(event.target).hasClass(this.settings.openClass)) {
                event.preventDefault();
                event.stopPropagation();
                _togglePanel.call(this, event, true);
            }
        };
        _focusInHandler = function(event) {
            clearTimeout(this.focusTimeoutID);
            var target = $(event.target),panel = target.closest('.' + this.settings.panelClass);
            target.addClass(this.settings.focusClass).on('click.accessible-megamenu', $.proxy(_clickHandler, this));
            this.justFocused = !this.mouseFocused;
            this.mouseFocused = false;
            if (this.panels.not(panel).filter('.' + this.settings.openClass).length) {
                _togglePanel.call(this, event);
            }
        };
        _focusOutHandler = function(event) {
            this.justFocused = false;
            var that = this,
                target = $(event.target),
                topli = target.closest('.' + this.settings.topNavItemClass),
                keepOpen = false;
            target.removeClass(this.settings.focusClass).off('click.accessible-megamenu');
            if (window.cvox) {
                that.focusTimeoutID = setTimeout(function() {
                    window.cvox.Api.getCurrentNode(function(node) {
                        if (topli.has(node).length) {
                            clearTimeout(that.focusTimeoutID);
                        } else {
                            that.focusTimeoutID = setTimeout(function(scope, event, hide) {
                                _togglePanel.call(scope, event, hide);
                            }, 275, that, event, true);
                        }
                    });
                }, 25);
            } else {
                that.focusTimeoutID = setTimeout(function() {
                    _togglePanel.call(that, event, true);
                }, 300);
            }
        };
        _keyDownHandler = function(event) {
            var that = (this.constructor === AccessibleMegaMenu) ? this : _getPlugin(this),
                settings = that.settings,
                target = $($(this).is('.' + settings.hoverClass + ':tabbable') ? this : event.target),
                menu = that.menu,
                topnavitems = that.topnavitems,
                topli = target.closest('.' + settings.topNavItemClass),
                tabbables = menu.find(':tabbable'),
                panel = target.hasClass(settings.panelClass) ? target : target.closest('.' + settings.panelClass),
                panelGroups = panel.find('.' + settings.panelGroupClass),
                currentPanelGroup = target.closest('.' + settings.panelGroupClass),
                next, keycode = event.keyCode || event.which,
                start, i, o, label, found = false,
                newString = Keyboard.keyMap[event.keyCode] || '',
                regex, isTopNavItem = (topli.length === 1 && panel.length === 0);
            if (target.is("input:focus, select:focus, textarea:focus, button:focus")) {
                return;
            }
            if (target.is('.' + settings.hoverClass + ':tabbable')) {
                $('html').off('keydown.accessible-megamenu');
            }
            switch (keycode) {
                case Keyboard.ESCAPE:
                    _togglePanel.call(that, event, true);
                    break;
                case Keyboard.DOWN:
                    event.preventDefault();
                    if (isTopNavItem) {
                        _togglePanel.call(that, event);
                        found = (topli.find('.' + settings.panelClass + ' :tabbable:first').focus().length === 1);
                    } else {
                        found = (tabbables.filter(':gt(' + tabbables.index(target) + '):first').focus().length === 1);
                    }
                    if (!found && window.opera && opera.toString() === "[object Opera]" && (event.ctrlKey || event.metaKey)) {
                        tabbables = $(':tabbable');
                        i = tabbables.index(target);
                        found = ($(':tabbable:gt(' + $(':tabbable').index(target) + '):first').focus().length === 1);
                    }
                    break;
                case Keyboard.UP:
                    event.preventDefault();
                    if (isTopNavItem && target.hasClass(settings.openClass)) {
                        _togglePanel.call(that, event, true);
                        next = topnavitems.filter(':lt(' + topnavitems.index(topli) + '):last');
                        if (next.children('.' + settings.panelClass).length) {
                            found = (next.children().attr('aria-expanded', 'true').addClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'false').find(':tabbable:last').focus() === 1);
                        }
                    } else if (!isTopNavItem) {
                        found = (tabbables.filter(':lt(' + tabbables.index(target) + '):last').focus().length === 1);
                    }
                    if (!found && window.opera && opera.toString() === "[object Opera]" && (event.ctrlKey || event.metaKey)) {
                        tabbables = $(':tabbable');
                        i = tabbables.index(target);
                        found = ($(':tabbable:lt(' + $(':tabbable').index(target) + '):first').focus().length === 1);

                    }
                    break;
                case Keyboard.RIGHT:
                    event.preventDefault();
                    if (isTopNavItem) {
                        found = (topnavitems.filter(':gt(' + topnavitems.index(topli) + '):first').find(':tabbable:first').focus().length === 1);
                    } else {
                        if (panelGroups.length && currentPanelGroup.length) {
                            found = (panelGroups.filter(':gt(' + panelGroups.index(currentPanelGroup) + '):first').find(':tabbable:first').focus().length === 1);
                        }

                        if (!found) {

                            found = (topli.find(':tabbable:first').focus().length === 1);

                        }

                    }

                    break;

                case Keyboard.LEFT:

                    event.preventDefault();

                    if (isTopNavItem) {

                        found = (topnavitems.filter(':lt(' + topnavitems.index(topli) + '):last').find(':tabbable:first').focus().length === 1);

                    } else {

                        if (panelGroups.length && currentPanelGroup.length) {

                            found = (panelGroups.filter(':lt(' + panelGroups.index(currentPanelGroup) + '):last').find(':tabbable:first').focus().length === 1);

                        }

                        if (!found) {

                            found = (topli.find(':tabbable:first').focus().length === 1);

                        }

                    }

                    break;

                case Keyboard.TAB:

                    i = tabbables.index(target);

                    if (event.shiftKey && isTopNavItem && target.hasClass(settings.openClass)) {

                        _togglePanel.call(that, event, true);

                        next = topnavitems.filter(':lt(' + topnavitems.index(topli) + '):last');

                        if (next.children('.' + settings.panelClass).length) {

                            found = next.children().attr('aria-expanded', 'true').addClass(settings.openClass).filter('.' + settings.panelClass).attr('aria-hidden', 'false').find(':tabbable:last').focus();

                        }

                    } else if (event.shiftKey && i > 0) {

                        found = (tabbables.filter(':lt(' + i + '):last').focus().length === 1);

                    } else if (!event.shiftKey && i < tabbables.length - 1) {

                        found = (tabbables.filter(':gt(' + i + '):first').focus().length === 1);

                    } else if (window.opera && opera.toString() === "[object Opera]") {

                        tabbables = $(':tabbable');

                        i = tabbables.index(target);

                        if (event.shiftKey) {

                            found = ($(':tabbable:lt(' + $(':tabbable').index(target) + '):last').focus().length === 1);

                        } else {

                            found = ($(':tabbable:gt(' + $(':tabbable').index(target) + '):first').focus().length === 1);

                        }

                    }

                    if (found) {

                        event.preventDefault();

                    }

                    break;

                case Keyboard.SPACE:

                    if (isTopNavItem) {

                        event.preventDefault();

                        _clickHandler.call(that, event);

                    } else {

                        return true;

                    }

                    break;

                case Keyboard.ENTER:

                    return true;

                    break;

                default:

                    clearTimeout(this.keydownTimeoutID);

                    keydownSearchString += newString !== keydownSearchString ? newString : '';

                    if (keydownSearchString.length === 0) {

                        return;

                    }

                    this.keydownTimeoutID = setTimeout(function() {

                        keydownSearchString = '';

                    }, keydownTimeoutDuration);

                    if (isTopNavItem && !target.hasClass(settings.openClass)) {

                        tabbables = tabbables.filter(':not(.' + settings.panelClass + ' :tabbable)');

                    } else {

                        tabbables = topli.find(':tabbable');

                    }

                    if (event.shiftKey) {

                        tabbables = $(tabbables.get().reverse());

                    }

                    for (i = 0; i < tabbables.length; i++) {

                        o = tabbables.eq(i);

                        if (o.is(target)) {

                            start = (keydownSearchString.length === 1) ? i + 1 : i;

                            break;

                        }

                    }

                    regex = new RegExp('^' + keydownSearchString.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&'), 'i');

                    for (i = start; i < tabbables.length; i++) {

                        o = tabbables.eq(i);

                        label = $.trim(o.text());

                        if (regex.test(label)) {

                            found = true;

                            o.focus();

                            break;

                        }

                    }

                    if (!found) {

                        for (i = 0; i < start; i++) {

                            o = tabbables.eq(i);

                            label = $.trim(o.text());

                            if (regex.test(label)) {

                                o.focus();

                                break;

                            }

                        }

                    }

                    break;

            }

            that.justFocused = false;

        };

        _mouseDownHandler = function(event) {

            if ($(event.target).is(this.settings.panelClass) || $(event.target).closest(":focusable").length) {

                this.mouseFocused = true;

            }

            clearTimeout(this.mouseTimeoutID);

            this.mouseTimeoutID = setTimeout(function() {

                clearTimeout(this.focusTimeoutID);

            }, 1);

        };

        _mouseOverHandler = function(event) {

            clearTimeout(this.mouseTimeoutID);

            var that = this;

            this.mouseTimeoutID = setTimeout(function() {

                $(event.target).addClass(that.settings.hoverClass);

                _togglePanel.call(that, event);

                if ($(event.target).is(':tabbable')) {

                    $('html').on('keydown.accessible-megamenu', $.proxy(_keyDownHandler, event.target));

                }

            }, this.settings.openDelay);

        };

        _mouseOutHandler = function(event) {

            clearTimeout(this.mouseTimeoutID);

            var that = this;

            $(event.target).removeClass(that.settings.hoverClass);

            that.mouseTimeoutID = setTimeout(function() {

                _togglePanel.call(that, event, true);

            }, this.settings.closeDelay);

            if ($(event.target).is(':tabbable')) {

                $('html').off('keydown.accessible-megamenu');

            }

        };

        _toggleExpandedEventHandlers = function(hide) {

            var menu = this.menu;

            if (hide) {

                $('html').off('mouseup.outside-accessible-megamenu, touchend.outside-accessible-megamenu, mspointerup.outside-accessible-megamenu,  pointerup.outside-accessible-megamenu');

                menu.find('[aria-expanded].' + this.settings.panelClass).off('DOMAttrModified.accessible-megamenu');

            } else {

                $('html').on('mouseup.outside-accessible-megamenu, touchend.outside-accessible-megamenu, mspointerup.outside-accessible-megamenu,  pointerup.outside-accessible-megamenu', $.proxy(_clickOutsideHandler, this));

                menu.find('[aria-expanded=true].' + this.settings.panelClass).on('DOMAttrModified.accessible-megamenu', $.proxy(_DOMAttrModifiedHandler, this));

            }

        };

        return {

            constructor: AccessibleMegaMenu,

            init: function() {

                var settings = this.settings,

                    nav = $(this.element),

                    menu = nav.children().first(),

                    topnavitems = menu.children();

                this.start(settings, nav, menu, topnavitems);

            },

            start: function(settings, nav, menu, topnavitems) {

                var that = this;

                this.settings = settings;

                this.menu = menu;

                this.topnavitems = topnavitems;

                nav.attr("role", "navigation");

                menu.addClass(settings.menuClass);

                topnavitems.each(function(i, topnavitem) {

                    var topnavitemlink, topnavitempanel;

                    topnavitem = $(topnavitem);

                    topnavitem.addClass(settings.topNavItemClass);

                    topnavitemlink = topnavitem.find(":tabbable:first");

                    topnavitempanel = topnavitem.children(":not(:tabbable):last");

                    _addUniqueId.call(that, topnavitemlink);

                    if (topnavitempanel.length) {

                        _addUniqueId.call(that, topnavitempanel);

                        topnavitemlink.attr({

                            "aria-controls": topnavitempanel.attr("id"),

                            "aria-expanded": false

                        });

                        topnavitempanel.attr({

                            "role": "region",

                            "aria-expanded": false,

                            "aria-hidden": true

                        }).addClass(settings.panelClass).not("[aria-labelledby]").attr("aria-labelledby", topnavitemlink.attr("id"));

                    }

                });

                this.panels = menu.find("." + settings.panelClass);

                menu.on("focusin.accessible-megamenu", ":focusable, ." + settings.panelClass, $.proxy(_focusInHandler, this)).on("focusout.accessible-megamenu", ":focusable, ." + settings.panelClass, $.proxy(_focusOutHandler, this)).on("keydown.accessible-megamenu", $.proxy(_keyDownHandler, this)).on("mouseover.accessible-megamenu", $.proxy(_mouseOverHandler, this)).on("mouseout.accessible-megamenu", $.proxy(_mouseOutHandler, this)).on("mousedown.accessible-megamenu", $.proxy(_mouseDownHandler, this));

                if (isTouch) {

                    menu.on("touchstart.accessible-megamenu", $.proxy(_clickHandler, this));

                }

                menu.find("hr").attr("role", "separator");

                if ($(document.activeElement).closest(menu).length) {

                    $(document.activeElement).trigger("focusin.accessible-megamenu");

                }

            },

            getDefaults: function() {

                return this._defaults;

            },

            getOption: function(opt) {

                return this.settings[opt];

            },

            getAllOptions: function() {

                return this.settings;

            },

            setOption: function(opt, value, reinitialize) {

                this.settings[opt] = value;

                if (reinitialize) {

                    this.init();

                }

            }

        };

    }());

    $.fn[pluginName] = function(options) {

        return this.each(function() {

            if (!$.data(this, "plugin_" + pluginName)) {

                $.data(this, "plugin_" + pluginName, new $.fn[pluginName].AccessibleMegaMenu(this, options));

            }

        });

    };

    $.fn[pluginName].AccessibleMegaMenu = AccessibleMegaMenu;



    function visible(element) {

        return $.expr.filters.visible(element) && !$(element).parents().addBack().filter(function() {

            return $.css(this, "visibility") === "hidden";

        }).length;

    }



    function focusable(element, isTabIndexNotNaN) {

        var map, mapName, img, nodeName = element.nodeName.toLowerCase();

        if ("area" === nodeName) {

            map = element.parentNode;

            mapName = map.name;

            if (!element.href || !mapName || map.nodeName.toLowerCase() !== "map") {

                return false;

            }

            img = $("img[usemap=#" + mapName + "]")[0];

            return !!img && visible(img);

        }

        return (/input|select|textarea|button|object/.test(nodeName) ? !element.disabled : "a" === nodeName ? element.href || isTabIndexNotNaN : isTabIndexNotNaN) && visible(element);

    }

    $.extend($.expr[":"], {

        data: $.expr.createPseudo ? $.expr.createPseudo(function(dataName) {

            return function(elem) {

                return !!$.data(elem, dataName);

            };

        }) : function(elem, i, match) {

            return !!$.data(elem, match[3]);

        },

        focusable: function(element) {

            return focusable(element, !isNaN($.attr(element, "tabindex")));

        },

        tabbable: function(element) {

            var tabIndex = $.attr(element, "tabindex"),

                isTabIndexNaN = isNaN(tabIndex);

            return (isTabIndexNaN || tabIndex >= 0) && focusable(element, !isTabIndexNaN);

        }

    });

}(jQuery, window, document))
function ip_callback() {

    $.get("/php/getIp.php", function(data) {
        ip = data;
    })

}
function checkmenu(menu) {

    ip_callback();

    $.ajax({

        type: "GET",

        url: "/php/checkmenu.php?menu=" + menu,

        dataType: 'json',
        cache: false

    }).done(

        function(resultaat) {

            if (menu === "Profiel") {

                Userophalen(taal, menu, UID);

            } else if (resultaat === false) {

                window.location.href = "https://www.doctorwhofans.be/notfound.html";

            } else {

                var interval = setInterval(function() {

                    $.ajax({

                        type: "GET",

                        url: "/php/alles.php?taal=" + taal + "&menu=" + menu,

                        dataType: 'json',
                        cache: false

                    }).done(function(resultaat) {

                        if (aantalrecords == resultaat.data.length) {

                        } else {

                            if (confirm("Wilt u de nieuwe content ophalen?")) {

                                window.location.reload();

                            } else {

                                clearInterval(interval);

                            }

                        }

                    }).fail(function(response, statusText, xhr) {

                    }).always(function() {

                    });

                }, 10000);





            }



        }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function zoeken(taal, menu, id, parent, child, zoekterm, ip, UID) {

    $.ajax({

        type: "GET",

        url: "/php/zoeken.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,

        dataType: 'json',
        cache: false

    }).done(

        function(resultaat) {

            $("#resultset1").append("<div class ='result slide' id='resultcontent'></div>");

            var i;

            for (i = 0; i < resultaat.data.length; i += 1) {

                if (resultaat.data[i].link.indexOf("Forum") >= 0) {

                    $("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + " (Forum)</h3></a>");

                } else {

                    $("#resultcontent").append("<a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a>");

                }







            }

        }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function getpad(menu) {

    $.ajax({

        type: "GET",

        url: "/php/pad.php?menu=" + menu,

        dataType: 'json',

        crossDomain: true,
        cache: false

    }).done(

        function(resultaat) {

            $(".path").prepend("<span>" + resultaat.data[0].pad + "</span>");

            $(".path a").addClass("link");



            if (menu === "Video" || resultaat.data[0].pad.search("Video") > 0) {

                videosophalen(menu);



            }

            if (menu === "Quotes" || resultaat.data[0].pad.search("Quotes") > 0) {

                quotesophalen(menu, id);

            }



        }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function random() {
    $.ajax({
        type: "GET",

        url: "/php/random.php",

        dataType: 'json',

        crossDomain: true,

        cache: false,

    }).done(

        function(resultaat) {

            for (i = 0; i < resultaat.data.length; i += 1) {

                $("#links").append("<a href='../" + resultaat.data[i].link + "/' >" + resultaat.data[i].topic + "</a></br>");



            }



        }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function getchildren(menu) {

    $.ajax({

        type: "GET",

        url: "/php/children.php?menu=" + menu,

        dataType: 'json',

        crossDomain: true,

        cache: false

    }).done(

        function(resultaat) {

            var i;

            for (i = 0; i < resultaat.data.length; i += 1) {

                if (resultaat.data[i].direct_children > 0) {

                    $(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3> <span>(Pages: " + resultaat.data[i].direct_children + ")</span></a></div>");

                } else {

                    $(".topics").append("<div class='OverzichtItem'><a href='../" + resultaat.data[i].link + "/'  ><h3>" + resultaat.data[i].topic + "</h3></a></div>");

                }



            }

        }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function videozoeken(taal, menu, id, parent, child, zoekterm) {

    $.ajax({

        type: "GET",

        url: "/php/zoekenvideo.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,

        dataType: 'json'

    }).done(function(resultaat) {

        $("#resultset2").append("<div class ='result slide' id='resultvideo'></div>");

        var i;

        for (i = 0; i < resultaat.data.length; i += 1) {

            $("#resultvideo").append("<a href='../Video/' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ")  ><h3>" + resultaat.data[i].Video_Name + "</h3</a>");

            $("#resultvideo").append("<p>" + resultaat.data[i].Video_Beschrijving + "...</p>");

        }

    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function quotezoeken(taal, menu, id, parent, child, zoekterm) {

    $.ajax({

        type: "GET",

        url: "/php/zoekenquote.php?taal=" + taal + "&menu=" + menu + "&zoekterm=" + zoekterm,

        dataType: 'json'

    }).done(function(resultaat) {

        $("#resultset3").append("<div class ='result slide' id='resultQuote'></div>");

        var i;

        for (i = 0; i < resultaat.data.length; i += 1) {

            $("#resultQuote").append("<a href='../Quotes/' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")><h3>" + resultaat.data[i].Aflevering + "</h3</a>");

            $("#resultQuote").append("<p>" + resultaat.data[i].Quote + "...</p>");

        }

    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function companionsophalen(taal, menu, id, parent, child) {

    $.ajax({

        type: "GET",

        url: "/php/companionsophalen.php?taal=" + taal + "&menu=" + menu,

        dataType: 'json'

    }).done(function(resultaat) {

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D1'>");

        $("#D1").append("<div class='header'><a class='opner' href='#'>First Doctor<img class='upDown' src='../images/up_down.png'alt='up-down First Doctor'/></a></div>");

        $("#D1").append("<div class ='result companion slide' id='resultD1'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D2'>");

        $("#D2").append("<div class='header'><a class='opner' href='#'>Second Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Second Doctor'/></a></div>");

        $("#D2").append("<div class ='result companion slide' id='resultD2'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D3'>");

        $("#D3").append("<div class='header'><a class='opner' href='#'>Third Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Third Doctor'/></a></div>");

        $("#D3").append("<div class ='result companion slide' id='resultD3'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D4'>");

        $("#D4").append("<div class='header'><a class='opner' href='#'>Fourth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Fourth Doctor'/></a></div>");

        $("#D4").append("<div class ='result companion slide' id='resultD4'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D5'>");

        $("#D5").append("<div class='header'><a class='opner' href='#'>Fifth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Fifth Doctor'/></a></div>");

        $("#D5").append("<div class ='result companion slide' id='resultD5'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D6'>");

        $("#D6").append("<div class='header'><a class='opner' href='#'>Sixth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Sixth Doctor'/></a></div>");

        $("#D6").append("<div class ='result companion slide' id='resultD6'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D7'>");

        $("#D7").append("<div class='header'><a class='opner' href='#'>Seventh Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Seventh Doctor'/></a></div>");

        $("#D7").append("<div class ='result companion slide' id='resultD7'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D8'>");

        $("#D8").append("<div class='header'><a class='opner' href='#'>Eighth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Eighth Doctor'/></a></div>");

        $("#D8").append("<div class ='result companion slide' id='resultD8'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='DW'>");

        $("#DW").append("<div class='header'><a class='opner' href='#'>War Doctor<img class='upDown' src='../images/up_down.png'alt='up-down War Doctor'/></a></div>");

        $("#DW").append("<div class ='result companion slide' id='resultDW'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D9'>");

        $("#D9").append("<div class='header'><a class='opner' href='#'>Ninth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Ninth Doctor'/></a></div>");

        $("#D9").append("<div class ='result companion slide' id='resultD9'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D10'>");

        $("#D10").append("<div class='header'><a class='opner' href='#'>Tenth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Tenth Doctor'/></a></div>");

        $("#D10").append("<div class ='result companion slide' id='resultD10'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D11'>");

        $("#D11").append("<div class='header'><a class='opner' href='#'>Eleventh Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Eleventh Doctor'/></a></div>");

        $("#D11").append("<div class ='result companion slide' id='resultD11'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D12'>");

        $("#D12").append("<div class='header'><a class='opner' href='#'>Twelfth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Twelfth Doctor'/></a></div>");

        $("#D12").append("<div class ='result companion slide' id='resultD12'></div>");

        $(".open-close").append("<div class='resultset holder' style='border:1px solid yelllow' id='D13'>");

        $("#D13").append("<div class='header'><a class='opner' href='#'>Thirteenth Doctor<img class='upDown' src='../images/up_down.png'alt='up-down Thirteenth Doctor'/></a></div>");

        $("#D13").append("<div class ='result companion slide' id='resultD13'></div>");

        var i;

        for (i = 0; i < resultaat.data.length; i += 1) {

            if (resultaat.data[i].Doctor == "1" || resultaat.data[i].Doctor2 == "1" || resultaat.data[i].Doctor3 == "1" || resultaat.data[i].Doctor4 == "1") {

                $("#resultD1").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "2" || resultaat.data[i].Doctor2 == "2" || resultaat.data[i].Doctor3 == "2" || resultaat.data[i].Doctor4 == "2") {

                $("#resultD2").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "3" || resultaat.data[i].Doctor2 == "3" || resultaat.data[i].Doctor3 == "3" || resultaat.data[i].Doctor4 == "3") {

                $("#resultD3").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/'  ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "4" || resultaat.data[i].Doctor2 == "4" || resultaat.data[i].Doctor3 == "4" || resultaat.data[i].Doctor4 == "4") {

                $("#resultD4").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "5" || resultaat.data[i].Doctor2 == "5" || resultaat.data[i].Doctor3 == "5" || resultaat.data[i].Doctor4 == "5") {

                $("#resultD5").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "6" || resultaat.data[i].Doctor2 == "6" || resultaat.data[i].Doctor3 == "6" || resultaat.data[i].Doctor4 == "6") {

                $("#resultD6").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "7" || resultaat.data[i].Doctor2 == "7" || resultaat.data[i].Doctor3 == "7" || resultaat.data[i].Doctor4 == "7") {

                $("#resultD7").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "8" || resultaat.data[i].Doctor2 == "8" || resultaat.data[i].Doctor3 == "8" || resultaat.data[i].Doctor4 == "8") {

                $("#resultD8").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "9" || resultaat.data[i].Doctor2 == "9" || resultaat.data[i].Doctor3 == "9" || resultaat.data[i].Doctor4 == "9") {

                $("#resultDW").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "10" || resultaat.data[i].Doctor2 == "10" || resultaat.data[i].Doctor3 == "10" || resultaat.data[i].Doctor4 == "10") {

                $("#resultD9").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "11" || resultaat.data[i].Doctor2 == "11" || resultaat.data[i].Doctor3 == "11" || resultaat.data[i].Doctor4 == "11") {

                $("#resultD10").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "12" || resultaat.data[i].Doctor2 == "12" || resultaat.data[i].Doctor3 == "12" || resultaat.data[i].Doctor4 == "12") {

                $("#resultD11").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "13" || resultaat.data[i].Doctor2 == "13" || resultaat.data[i].Doctor3 == "13" || resultaat.data[i].Doctor4 == "13") {

                $("#resultD12").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

            if (resultaat.data[i].Doctor == "14" || resultaat.data[i].Doctor2 == "14" || resultaat.data[i].Doctor3 == "14" || resultaat.data[i].Doctor4 == "14") {

                $("#resultD13").append("<div><a href='../" + resultaat.data[i].Pagina_Naam + "/' ><h3>" + resultaat.data[i].Naam + "</h3></a></div>");

            }

        }

    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function videosophalen(menu, id) {

    $.ajax({

        type: "GET",

        url: "/php/videosophalen.php?menu=" + menu + "&id=" + id,

        dataType: 'json',
        cache: false

    }).done(function(resultaat) {

        $(".col-6").append("<div class='main_vid'></div>");

        $(".col-6").append("<div class='vid_choice'></div>");

        if (id === "0" || id == null) {

            id = Math.floor((Math.random() * resultaat.data.length) + 1);

        } else {
            id = id;
        }

        for (i = 0; i < resultaat.data.length; i++) {

            if (id === resultaat.data[i].id) {

                if (resultaat.data[i].Video_Type === "Youtube") {

                    $(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>");

                    $(".main_vid").append("<iframe width='853' height='480' src='" + resultaat.data[i].Video_URL + "' frameborder='0' allowfullscreen></iframe>");

                } else {

                    $(".main_vid").append("<h2>" + resultaat.data[i].Video_Name + "</h2>")

                    $(".main_vid").append("<video width='480' controls controlsList='nodownload'><source src='../" + resultaat.data[i].Video_URL + "' type='video/mp4'></video>");

                }

            } else {

                if (resultaat.data[i].SPOILER === 1) {

                    $(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img src='../" + resultaat.data[i].Video_Image + "' class='thumbnail' style='display:inline;background-color:red' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");

                } else {

                    $(".vid_choice").append("<a href='#' title='" + resultaat.data[i].Video_Name + "' onclick=event.preventDefault();$('.col-6').html('');videosophalen('Video'," + resultaat.data[i].id + ") class='inline_vid' ><div class=keuze><div><img src='../" + resultaat.data[i].Video_Image + "' class='thumbnail' style='display:inline;' alt='" + resultaat.data[i].Video_Name + "'></div><p title='" + resultaat.data[i].Video_Name + "'>" + resultaat.data[i].Video_Name.substr(0, 13) + "...</p></div></a>");

                }





            }



        }



    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function quotesophalen(menu, id) {

    $.ajax({
        type: "GET",
        url: "/php/quotesophalen.php?menu=" + menu + "&id=" + id,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        $(".col-6").append("<div class='main_quote' style=''></div>");
        $(".col-6").append("<div class='selectie'></div>");
        $(".selectie").append("<div class='linkerquote'></div>");
        $(".selectie").append("<div class='rechterquote'></div>");
        if (id === "0") {
            id = Math.floor((Math.random() * resultaat.data.length) + 1);
        } else {
            id = id;
        }
        for (i = 0; i < resultaat.data.length; i++) {
            //populeer zoekvelden om snel een selectie te maken op basis van personage/aflevering
            if (id === resultaat.data[i].id) {
                $(".main_quote").append("<h1>" + resultaat.data[i].Aflevering + "</h1>");
                $(".main_quote").append("<div><img class='quote_picture' src='" + resultaat.data[i].QuotePic + "'/><p class='quotetext'>" + resultaat.data[i].Quote + "</p><p>" + resultaat.data[i].Personage + "</p><div>");
            } else {
                var quote = resultaat.data[i].Quote;
                var quote_short = quote.substring(0, 60);
                if (quote_short.indexOf('<br>') >= 0) {
                    var quote_short_zonder_enter = quote_short.substring(0, quote_short.indexOf('<br'));
                } else {
                    var quote_short_zonder_enter = quote_short;
                }
                if (i % 2 === 0) {
                    $(".linkerquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote_short_zonder_enter + "</a></div>");
                } else {
                    $(".rechterquote").append("<div><a href='#' onclick=event.preventDefault();$('.col-6').html('');quotesophalen('Quotes'," + resultaat.data[i].id + ")>" + quote_short_zonder_enter + "</a></div>");
                }
            }
        }
    }).fail(function(response, statusText, xhr) {}).always(function() {});
}
function GetNews() {

    $.ajax({

        type: "GET",

        url: "/php/GetNews.php",

        dataType: 'json',
        cache: false

    }).done(function(resultaat) {

        $(".col-6").append("<div class='news' style=''></div>");

        for (i = 0; i < resultaat.data.length; i++) {

            $(".news").append("<div class='newsitem' id='" + resultaat.data[i].id + "'></div>");

            $("#" + resultaat.data[i].id).append("<h2>" + resultaat.data[i].Titel + "</h2>");

            $("#" + resultaat.data[i].id).append("<h3>" + resultaat.data[i].Datum + "</h3>");

            $("#" + resultaat.data[i].id).append("<img src='" + resultaat.data[i].Foto + "' alt='" + resultaat.data[i].alt + "' class='" + resultaat.data[i].Class + "'/><span class='" + resultaat.data[i].Class_Text + "'>" + resultaat.data[i].Bericht + "</span>");





        }



    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}
function GetQuotesByCharacter(Character) {
    console.log(Character);
    Character = Character.trim();
    $.ajax({
        type: "GET",
        url: "/php/quotesophalenbyCharacter.php?Character=" + Character,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        if (resultaat.data.length === 0) {
            $("#Quotes").append("<p>Er werden voor dit personage nog geen quotes gevonden.</p>");

        } else {
            for (i = 0; i < resultaat.data.length; i++) {
                $("#Quotes").append("<p class='quoteitem'>" + resultaat.data[i].Quote + "</p>");
            }

        }


    }).fail(function(response, statusText, xhr) {
        $("#Quotes").append("<p>Er werden voor dit personage nog geen quotes gevonden.</p>");
    }).always(function() {});
}
function GetQuotesByEpisode(Episode) {
    console.log(Episode);
    Episode = Episode.trim();
    $.ajax({
        type: "GET",
        url: "/php/quotesophalenbyEpisode.php?Episode=" + Episode,
        dataType: 'json',
        cache: false
    }).done(function(resultaat) {
        if (resultaat.data.length === 0) {
            $("#Quotes").append("<p>Er werden voor deze aflevering nog geen quotes gevonden.</p>");

        } else {
            for (i = 0; i < resultaat.data.length; i++) {
                $("#Quotes").append("<p class='quoteitem'>" + resultaat.data[i].Quote + "</p>");
            }

        }


    }).fail(function(response, statusText, xhr) {
        $("#Quotes").append("<p>Er werden voor deze aflevering nog geen quotes gevonden.</p>");
    }).always(function() {});
}

function GetOneRandomQuote() {

    $.ajax({

        type: "GET",

        url: "/php/GetOneRandomQuote.php",

        dataType: 'json',
        cache: false

    }).done(function(resultaat) {

        $('.quote').append("<p>" + resultaat.data[0].Quote + " ...</p>")

        if (taal == "NL") {

            $('.quote').append("<a href='../Quotes/'>Lees meer</a>");

        } else {

            $('.quote').append("<a href='../Quotes/'> Read More</a>");

        }

        $('.quote').append("<p>" + resultaat.data[0].Personage + " - " + resultaat.data[0].Aflevering + "</p>")



    }).fail(function(response, statusText, xhr) {

    }).always(function() {

    });

}

function contentophalen(taal, menu, id, parent, child) {

    $.ajax({

        type: "GET",

        url: "/php/alles.php?taal=" + taal + "&menu=" + menu,

        dataType: 'json',
        cache: false

    }).done(function(resultaat) {

        aantalrecords = resultaat.data.length;

        var i;

        for (i = 0; i < resultaat.data.length; i += 1) {

            if (resultaat.data[i].A_Pagina_Type === "Slider") {

                $(".col-6").append("<div class='slideshow-container'><a class='prev' onclick='plusSlides(-1)'>&#10094;</a><a class='next' onclick='plusSlides(1)'>&#10095;</a></div>");

            }

            if (resultaat.data[i].A_Pagina_Type === "WikiPagina") {

                $(".col-6").append("<div id='WikiDetails'></div>");

                $(".under").append("<div id='Voetnoot'><h2>Voetnoten</h2><ul></ul></div>");

                $("#WikiDetails").append("<div id='Items'></div>");
            }
            if (resultaat.data[i].A_Type === "Titel" || resultaat.data[i].A_Type === "EpisodeTitel"||resultaat.data[i].A_Type === "CharacterTitel") {
                $(".col-6").prepend("<h1>" + resultaat.data[i].A_Waarde + "</h1>");
                if (resultaat.data[i].A_Type === "EpisodeTitel") {
                    $(".under").prepend("<div id='Under_Upper'>")
                    $("#Under_Upper").append("<div id='Quotes'></div>");
                    $("#Under_Upper").append("<div id='Downloads'><h2>Downloads</h2></div>");
                    $("#Quotes").append("<h2>Quotes</h2>");
                    var Episode = resultaat.data[i].A_Waarde;
                    GetQuotesByEpisode(Episode);
                    if (taal === "NL") {
                        $("#Downloads").append('<p>Hier komen extra bronnen, zoals de transcripts en download voor oa. de ondertitels.');
                    } else {
                        $("#Downloads").append('<p>You can find a variety of downloads here for this episode, like subtitbles and transcripts, as soon as they are available.</p>');
                    }
                }
                if (resultaat.data[i].A_Type === "CharacterTitel") {
                    $(".under").prepend("<div id='Under_Upper'>")
                    $("#Under_Upper").append("<div id='Quotes'></div>");
                    $("#Quotes").append("<h2>Quotes</h2>");
                    var Character = resultaat.data[i].A_Waarde;
                    GetQuotesByCharacter(Character);
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeStatus") {
                $("#Items").prepend("<div class='WikiItemTitel " + resultaat.data[i].A_Klasse + "'>Status: " + resultaat.data[i].A_Waarde + "</div>");
            }
            if (resultaat.data[i].A_Type === "EpisodeDoctorList") {
                $("#Items").append("<div class=WikiItemTitel>Cast</div>");
                $("#Items").append("<span class=WikiRule>Doctor: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if (resultaat.data[i].A_Type === "EpisodeCompanionList") {
                $("#Items").append("<span class=WikiRule>Companions: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
            }
            if (resultaat.data[i].A_Type === "EpisodeOtherList") {
                if (taal === "NL") {
                    $("#Items").append("<span class=WikiRule>Anderen: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
                } else {
                    $("#Items").append("<span class=WikiRule>Others: <ul>" + resultaat.data[i].A_Waarde + "</ul></span>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeDirectorList") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiItemTitel>Productie</div>");
                    $("#Items").append("<div class=WikiRule>Geregisseerd door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class=WikiItemTitel>Production</div>");
                    $("#Items").append("<div class=WikiRule>Directed by: <ul class='singular_list_item>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodePrevious") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiItemTitel'>Chronologie</div>");
                    $("#Items").append("<div class='Chronologie'></div>");
                    $(".Chronologie").append("<div class='Half'>Vorige aflevering:<br>" + resultaat.data[i].A_Waarde + "</div>");
                } else {
                    $("#Items").append("<div class='WikiItemTitel'>Chronology</div>");
                    $("#Items").append("<div class='Chronologie'></div>");
                    $(".Chronologie").append("<div class='Half'>Previous episode:<br>" + resultaat.data[i].A_Waarde + "</div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeNext") {
                if (taal === "NL") {
                    $(".Chronologie").append("<div class='Half Rechts'>Volgende aflevering:<br>" + resultaat.data[i].A_Waarde + "</div>");
                } else {
                    $(".Chronologie").append("<div class='Half Rechts'>Next episode:<br>" + resultaat.data[i].A_Waarde + "</div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeWriterList") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Geschreven door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Written by: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeEditorList") {
                $("#Items").append("<div class=WikiRule>Script editor: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
            }
            if (resultaat.data[i].A_Type === "EpisodeProducerList") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Geproduced door: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Produced by: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeComposerList") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Incidentele componist : <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Incidental music composer: <ul>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeProductionCode") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Productiecode : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Production Code : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeSeries") {
                $("#Items").append("<div class=WikiRule>Series : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
            }
            if (resultaat.data[i].A_Type === "EpisodeLength") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Lengte : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Length : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeDateStarted") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Startdatum : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Date Started : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "EpisodeDateEnded") {
                if (taal === "NL") {
                    $("#Items").append("<div class=WikiRule>Einddatum : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class=WikiRule>Date Ended : <span>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "Inleiding") {
                $(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");
                $(".col-6").append("<div id='Inhoud'>Inhoudstafel<ul></ul><ol></ol></div>");
                if ($('.under').text().indexOf('Quotes') != -1) {
                    $("#Inhoud ol").append("<li><a href='#Quotes'>Quotes</a></li>");
                }
                if ($('.under').text().indexOf('Downloads') != -1) {
                    $("#Inhoud ol").append("<li><a href='#Downloads'>Downloads</a></li>");
                }
                $("#Inhoud ol").append("<li><a href='#Voetnoot'>Voetnoten</a></li>");
            }
            if (resultaat.data[i].A_Type === "Tekst") {
                $(".col-6").append("<div class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</div>");
            }
            if (resultaat.data[i].A_Type === "Losse_Code") {
                $(".col-6").append(resultaat.data[i].A_Waarde);
            }
            if (resultaat.data[i].A_Type === "Voetnoot") {
                $("#Voetnoot").append("<p class='" + resultaat.data[i].A_Klasse + "'>" + resultaat.data[i].A_Waarde + "</p>");
            }
            if (resultaat.data[i].A_Type === "Kop2") {
                if (resultaat.data[i].A_Pagina_Type === "Wikititel") {
                    $("#Inhoud ul").append("<li><a href='#" + resultaat.data[i].A_Waarde + "' >" + resultaat.data[i].A_Waarde + "</a></li>");
                }
                $(".col-6").append("<h2 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h2>");
            }
            if (resultaat.data[i].A_Type === "Kop3") {
                $(".col-6").append("<h3 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h3>");
            }
            if (resultaat.data[i].A_Type === "Kop4") {
                $(".col-6").append("<h4 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h4>");
            }
            if (resultaat.data[i].A_Type === "Kop5") {
                $(".col-6").append("<h5 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h5>");
            }
            if (resultaat.data[i].A_Type === "Kop6") {
                $(".col-6").append("<h6 class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h6>");
            }
            if (resultaat.data[i].A_Type === "Lijst") {
                $(".col-6").append("<hli class='" + resultaat.data[i].A_Klasse + "' id='" + resultaat.data[i].A_ID + "'>" + resultaat.data[i].A_Waarde + "</h6>");
            }
            if (resultaat.data[i].A_Pagina_Type === "Overzicht") {
                $(".col-6").append("<div class='topics'></div>");
                getchildren(menu);
            }
            if (resultaat.data[i].A_Type === "Afbeelding") {
                if (resultaat.data[i].A_Pagina_Type === "Wiki") {
                    var j;
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if (resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Bijschrijft" || resultaat.data[j].A_Type === "Alt")) {
                            $("#WikiDetails").prepend("<div><img src='" + resultaat.data[i].A_Waarde + "' class='Wiki_Foto " + resultaat.data[i].A_Klasse + "' title='" + resultaat.data[j].A_Waarde + " ' alt='" + resultaat.data[j].A_Waarde + "'></div>");
                        }
                    }
                } else if (resultaat.data[i].A_Pagina_Type === "Slide") {
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if (resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Alt" || resultaat.data[j].A_Type === "Bijschrift")) {
                            $(".slideshow-container").append("<div class='mySlides fade'><img src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + " tile='" + resultaat.data[j].A_Waarde + "'style='80%;padding-left:6em;'><div class='text'>" + resultaat.data[j].A_Waarde + "</div></div>");
                        }
                    }
                    setTimeout(function() {
                        showSlides(slideIndex);
                    }, 1000);
                } else {
                    var j;
                    for (j = 0; j < resultaat.data.length; j += 1) {
                        if (resultaat.data[j].A_Hoort_Bij === resultaat.data[i].A_ID && (resultaat.data[j].A_Type === "Alt" || resultaat.data[j].A_Type === "Bijschrift")) {
                            $(".col-6").append("<div id='" + resultaat.data[i].A_ID + "' class='foto_met_text " + resultaat.data[i].A_Klasse + "'></div>");
                            $("#" + resultaat.data[i].A_ID).append("<img src='" + resultaat.data[i].A_Waarde + "' alt='" + resultaat.data[j].A_Waarde + " title='" + resultaat.data[j].A_Waarde + "'>");
                            $("#" + resultaat.data[i].A_ID).append("<p class='" + resultaat.data[j].A_Klasse + "'>" + resultaat.data[j].A_Waarde + "</p>");
                        }
                    }
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemPlayedBy") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Gespeeld door:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Played by:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemPlayedByList") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Gespeeld door:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Played by:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "AantalSeizoenen") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Aantal seizoenen:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Number of Seasons</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "Verschijningen") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Aantal <br>verschijningen:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Number of<br>appearances:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "Periode") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Periode: </span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Tenure:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemFirstEpisode") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Eerste Aflevering:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>First Episode:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemLastEpisode") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Laatste Aflevering:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Last Episode:</span><span class='WikiItem content'>" + resultaat.data[i].A_Waarde + "</span></div>");
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemFirstEpisodeList") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Eerste Aflevering:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>First Episode:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "WikiItemLastEpisodeList") {
                if (taal === "NL") {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Laatste Aflevering:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                } else {
                    $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Last Episode:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
                }
            }
            if (resultaat.data[i].A_Type === "CompanionList") {
                $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Companions:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
            }
            if (resultaat.data[i].A_Type === "SeriesList") {
                $("#Items").append("<div class='WikiRule'><span class='WikiItem'>Series:</span><ul class='WikiItem content List'>" + resultaat.data[i].A_Waarde + "</ul></div>");
            }
            if (resultaat.data[i].A_Type === "Form") {
                $(".col-6").append(resultaat.data[i].A_Waarde);
            }
        }
    }).fail(function(response, statusText, xhr) {
    }).always(function() {
    });
}
(function($) {
    'use strict';
    $.fn.fitVids = function(options) {
        var settings = {
            customSelector: null,
            ignore: null
        };
        if (!document.getElementById('fit-vids-style')) {
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }
        if (options) {
            $.extend(settings, options);
        }
        return this.each(function() {
            var selectors = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', 'object', 'embed'];
            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }
            var ignoreList = '.fitvidsignore';
            if (settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }
            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('object object');
            $allVideos = $allVideos.not(ignoreList);
            $allVideos.each(function() {
                var $this = $(this);
                if ($this.parents(ignoreList).length > 0) {
                    return;
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
                    return;
                }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if (!$this.attr('name')) {
                    var videoName = 'fitvid' + $.fn.fitVids._count;
                    $this.attr('name', videoName);
                    $.fn.fitVids._count++;
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + '%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
    $.fn.fitVids._count = 0;
})(window.jQuery || window.Zepto)
$(function() {
    jQuery(".SitemapButton").click(function() {
        jQuery(this).parent().next().toggle();
        if (jQuery(this).parent().next().attr('display') === 'none' || jQuery(this).text() == "+") {
            jQuery(this).text("-");
        } else if (jQuery(this).parent().next().attr('display') === 'block' || jQuery(this).text() == "-") {
            jQuery(this).text("+");
        }
    });
    $('input[type="checkbox"]').click(function() {
        if (this.className == "show_menu_checkbox") {
            if ($(this).is(":checked")) {
                $('.megamenu').show();
            } else {
                $('.megamenu').hide();
            }
        }
    });
})
$(document).ready(function() {
    $('.open-close').on('click', '.opner', function(event) {
        $(this).closest('.holder').find('.opner').toggleClass('active');
        $(this).closest('.holder').find('.slide').slideToggle(20);
        event.preventDefault();
    });
    $('.active').closest('.holder').find('.slide').slideDown(20);
})
function Spoilertonen(content) {
    stopVideos();
    $('#' + content).toggle();
}
function stopVideos() {
    $("iframe").each(function() {
        var src = $(this).attr('src');
        $(this).attr('src', src);
    });
}
function on() {
    document.getElementById("overlay_Afbeelding").style.display = "block";
}
function off() {
    document.getElementById("overlay_Afbeelding").style.display = "none";
}
function plusSlides(n) {
    showSlides(slideIndex += n);
}
function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    if (n > slides.length) {
       slideIndex = 1
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex - 1].style.display = "block";
}