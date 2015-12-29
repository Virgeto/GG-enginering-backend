<?php

/**
 * Get pagination per_page default value.
 *
 * @return integer
 */
function getPerPage()
{
    return app()['config']->get('pagination.per_page');
}

