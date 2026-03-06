<?php
/**
 * URL Helper Functions
 */

// Redirect to a page
function redirect($page)
{
    header('location: ' . URLROOT . '/' . $page);
}
