<?php

// Every page starts with this: it starts the session and loads the helpers.
// Keep it at the very top of the page, before any HTML or blank lines,
// because sessions cannot start once output has been sent.

require_once __DIR__ . '/session.php';
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/site.php';

?>
