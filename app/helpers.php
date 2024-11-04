<?php

function truncatePost($text, $limit = 100) {
    // Strip out the HTML tags temporarily
    $plainText = strip_tags($text);

    // Check if the length exceeds the limit
    if (strlen($plainText) <= $limit) {
        return $text; // Return the original text if within limit
    }

    // Truncate the plain text to the specified limit
    $truncatedText = mb_substr($plainText, 0, $limit);

    // Find the last space to avoid cutting words
    $lastSpace = strrpos($truncatedText, ' ');

    // Trim the truncated text to the last space
    $truncatedText = mb_substr($truncatedText, 0, $lastSpace);

    // Return the truncated text with an ellipsis and maintain HTML tags
    return $truncatedText . '...';
}

function isTrunctable($text, $limit = 100)
{
    // Strip out the HTML tags temporarily
    $plainText = strip_tags($text);

    // Check if the length exceeds the limit
    if (strlen($plainText) <= $limit)
        return false;

    return true;
}
function truncatePostAndRemoveImages($text, $limit = 100) {
    $textWithoutFigures = preg_replace('/<figure class="image">.*?<\/figure>/is', '', $text);
    $textWithoutImages = preg_replace('/<img[^>]*>/i', '', $textWithoutFigures);

    return truncatePost($textWithoutImages, $limit);
}