var infiniteNewsPage = 1;
var loading = false;
var left = true;
var end = false;
jQuery(function () {

    // Check if news has to be loaded at the end of the page
    jQuery(window).scroll(function () {
        if (!end && !loading && document.getElementById("infinite-news").getBoundingClientRect().bottom < jQuery(window).height()) { //end of news container in View
            appendNewsBlock(infiniteNewsPage++);
        }
    });

    // Scroll down to article saved in anchor
    var anchor = window.location.hash.substr(1);
    if (anchor) {

        //Check if anchor is in view, if not append
        function anchorOrAppend() {
            var anchoredElements = jQuery("#" + anchor);
            if (anchoredElements.length === 0) {
                window.scrollTo(0, document.body.scrollHeight);
                appendNewsBlock(infiniteNewsPage++, anchorOrAppend)
            } else {
                //var current_item = document.getElementById(anchor);
                var top = document.getElementById(anchor).offsetTop; //Getting Y of target element
                window.scrollTo(0, top);                        //Go there directly or some transition


                var og_title = jQuery("h2");
                var og_description = jQuery(".infinite-article-content");
                var og_image = jQuery("img");
                var current_item_title =  anchoredElements.find(og_title).get(0).innerText;
                var current_og_description = anchoredElements.find(og_description).get(0).innerText;
                var current_og_image = anchoredElements.find(og_image).get(0).src;

                var m=document.getElementsByTagName('meta');

                for(var c=0;c<m.length;c++) {
                    if(m[c].name === 'og:title' || m[c].name === 'twitter:title') {
                        m[c].content = current_item_title;
                    }
                    if(m[c].name === 'og:description' || m[c].name === 'twitter:description') {
                        m[c].content = current_og_description;
                    }
                }

                var meta_og_image = document.createElement('meta');
                meta_og_image.name = "og:image";
                meta_og_image.property = "og:image";
                meta_og_image.content = current_og_image;
                document.getElementsByTagName('head')[0].appendChild(meta_og_image);

                var meta_twitter_image = document.createElement('meta');
                meta_twitter_image.name = "twitter:image";
                meta_twitter_image.property = "twitter:image";
                meta_twitter_image.content = current_og_image;
                document.getElementsByTagName('head')[0].appendChild(meta_twitter_image);
            }
        }

        appendNewsBlock(infiniteNewsPage++, anchorOrAppend)
    } else {
        appendNewsBlock(infiniteNewsPage++);
    }
});

function appendNewsBlock(page, callback) {
    loading = true;
    callback = typeof callback !== 'undefined' ? callback : null;
    jQuery.ajax({
        method: 'GET',
        url: '<?= $this->url ?>?page_n<?= $this->moduleId ?>=' + page + (page === 1 ? "&sticky=1" : ""),
        data: {
            ajax_reload_element: 'mod::<?= $this->moduleId ?>',
        }
    }).done(function (response, status, xhr) {
        loading = false;
        if (response.status === 'ok') {
            if (response.html == null) {
                end = true;
                return;
            }

            // Data is quite a lot escaped
            response.html = JSON.parse(response.html);

            // Replace the DOM
            for (i = 0; i < response.html.articles.length; i++) {
                var item = JSON.parse(response.html.articles[i]);
                if (item != null) {
                    jQuery("#infinite-news").append(createNewsElement(item.id, item.headline, item.subheadline, item.meta, item.content, item.image, item.wide_article, item.featured));
                    left = !left;
                }
            }

            jQuery('a[data-lightbox]').map(function () {
                jQuery(this).colorbox({
                    // Put custom options here
                    loop: false,
                    rel: jQuery(this).attr('data-lightbox'),
                    maxWidth: '95%',
                    maxHeight: '95%'
                });
                if (jQuery(this).hasClass('colorbox_content')) {
                    jQuery(this).colorbox({inline: true, width: '50%'});
                } else {
                    jQuery(this).colorbox({inline: false});
                }
            });

            if (callback) {
                callback();
            }
        }
        else {
            // Reload the page as fallback
            // location.reload();
        }
    });
}

function createNewsElement(id, headline, subtitle, meta, text, image, wide, featured) {
    image = typeof image !== 'undefined' ? image : "";
    wide = typeof wide !== 'undefined' ? wide : false;
    featured = typeof featured !== 'undefined' ? featured : false;

    var cssClass = "", subheadline;
    if (featured) {
        cssClass = "infinite-article-featured";
    }

    if (subtitle) {
        subheadline = "<h3 class='infinte-news-article-subheadline'>" + subtitle + "</h3>";
    } else {
        subheadline = "";
    }

    var cols = 6;
    if (wide) {
        cols = 12;
        cssClass += " infinite-article-wide";
    }
    var obj = jQuery("<div class='small-12 medium-" + cols + " columns infinite-news-article " + cssClass + "' id='infinite-news-article-" + id + "'>" +
        "<div class='infinite-news-article-header'><p class='infinite-article-meta'>" + meta + "</p><h2 class='infinite-news-article-headline'>" + headline + "</h2></div>" +
        subheadline + image + "<div class='infinite-article-content'>" + text + "</div></div>");

    obj.click(function() {
        location.hash = "infinite-news-article-" + id;
    });
    return obj;
}
