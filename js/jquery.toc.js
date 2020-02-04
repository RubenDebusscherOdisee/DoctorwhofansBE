

(function ($) {
    "use strict";

  
    var toc = function (options) {
        return this.each(function () {
            var root = $(this),
                data = root.data(),
                thisOptions,
                stack = [root],
                listTag = this.tagName,
                currentLevel = 0,
                headingSelectors;

            thisOptions = $.extend(
                {content: "body", headings: "h1,h2,h3"},
                {content: data.toc || undefined, headings: data.tocHeadings || undefined},
                options
            );
            headingSelectors = thisOptions.headings.split(",");

            $(thisOptions.content).find(thisOptions.headings).attr("id", function (index, attr) {
                
                var generateUniqueId = function (text) {
                    
                    if (text.length === 0) {
                        text = "?";
                    }

                    var baseId = text.replace(/\s+/g, "_"), suffix = "", count = 1;

                    while (document.getElementById(baseId + suffix) !== null) {
                        suffix = "_" + count++;
                    }

                    return baseId + suffix;
                };

                return attr || generateUniqueId($(this).text());
            }).each(function () {
                var elem = $(this), level = $.map(headingSelectors, function (selector, index) {
                    return elem.is(selector) ? index : undefined;
                })[0];

                if (level > currentLevel) {

                    var parentItem = stack[0].children("li:last")[0];
                    if (parentItem) {
                        stack.unshift($("<" + listTag + "/>").appendTo(parentItem));
                    }
                } else {
                
                    stack.splice(0, Math.min(currentLevel - level, Math.max(stack.length - 1, 0)));
                }

                $("<li/>").appendTo(stack[0]).append(
                    $("<a/>").text(elem.text()).attr("href", "#" + elem.attr("id"))
                );

                currentLevel = level;
            });
        });
    }, old = $.fn.toc;

    $.fn.toc = toc;

    $.fn.toc.noConflict = function () {
        $.fn.toc = old;
        return this;
    };

    $(function () {
        toc.call($("[data-toc]"));
    });
}(window.jQuery));
