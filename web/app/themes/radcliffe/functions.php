<?php

/* ---------------------------------------------------------------------------------------------
   THEME UTILITY FUNCTIONS
   --------------------------------------------------------------------------------------------- */

function getCommonExcerptLength()
{
    return 30;
}

function getCustomPostTypesArray()
{
    return ['annual-reports', 'published-reviews', 'newsletters', 'publications', 'news', 'meeting-notes', 'policies'];
}

function getPublicationPostTypesArray()
{
    return ['annual-reports', 'published-reviews', 'newsletters', 'publications'];
}

function getPostTypesWithFeaturedImage()
{
    return ['post', 'news'];
}

require 'inc/setup.php';

require 'inc/general.php';

require 'inc/gutenberg.php';

require 'inc/acf-options.php';

require 'inc/media.php';

require 'inc/custom-post-types.php';

/* ---------------------------------------------------------------------------------------------
   SHORTCODES
   --------------------------------------------------------------------------------------------- */

require get_template_directory() . '/inc/sc/accordion-preview.php';
require get_template_directory() . '/inc/sc/latest-news.php';
