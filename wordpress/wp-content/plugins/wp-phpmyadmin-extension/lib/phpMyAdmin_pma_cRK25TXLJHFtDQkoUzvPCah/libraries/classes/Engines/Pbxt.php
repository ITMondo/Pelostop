<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * The PBXT storage engine
 *
 * @package PhpMyAdmin-Engines
 */
namespace PhpMyAdmin\Engines;

use PhpMyAdmin\Core;
use PhpMyAdmin\StorageEngine;
use PhpMyAdmin\Util;

/**
 * The PBXT storage engine
 *
 * @package PhpMyAdmin-Engines
 */
class Pbxt extends StorageEngine
{
    /**
     * Returns array with variable names dedicated to PBXT storage engine
     *
     * @return array   variable names
     */
    public function getVariables()
    {
        return array(
            'pbxt_index_cache_size'        => array(
                'title' => __PMA_TRANSL('Index cache size'),
                'desc'  => __PMA_TRANSL(
                    'This is the amount of memory allocated to the'
                    . ' index cache. Default value is 32MB. The memory'
                    . ' allocated here is used only for caching index pages.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_record_cache_size'       => array(
                'title' => __PMA_TRANSL('Record cache size'),
                'desc'  => __PMA_TRANSL(
                    'This is the amount of memory allocated to the'
                    . ' record cache used to cache table data. The default'
                    . ' value is 32MB. This memory is used to cache changes to'
                    . ' the handle data (.xtd) and row pointer (.xtr) files.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_log_cache_size'          => array(
                'title' => __PMA_TRANSL('Log cache size'),
                'desc'  => __PMA_TRANSL(
                    'The amount of memory allocated to the'
                    . ' transaction log cache used to cache on transaction log'
                    . ' data. The default is 16MB.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_log_file_threshold'      => array(
                'title' => __PMA_TRANSL('Log file threshold'),
                'desc'  => __PMA_TRANSL(
                    'The size of a transaction log before rollover,'
                    . ' and a new log is created. The default value is 16MB.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_transaction_buffer_size' => array(
                'title' => __PMA_TRANSL('Transaction buffer size'),
                'desc'  => __PMA_TRANSL(
                    'The size of the global transaction log buffer'
                    . ' (the engine allocates 2 buffers of this size).'
                    . ' The default is 1MB.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_checkpoint_frequency'    => array(
                'title' => __PMA_TRANSL('Checkpoint frequency'),
                'desc'  => __PMA_TRANSL(
                    'The amount of data written to the transaction'
                    . ' log before a checkpoint is performed.'
                    . ' The default value is 24MB.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_data_log_threshold'      => array(
                'title' => __PMA_TRANSL('Data log threshold'),
                'desc'  => __PMA_TRANSL(
                    'The maximum size of a data log file. The default'
                    . ' value is 64MB. PBXT can create a maximum of 32000 data'
                    . ' logs, which are used by all tables. So the value of'
                    . ' this variable can be increased to increase the total'
                    . ' amount of data that can be stored in the database.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_garbage_threshold'       => array(
                'title' => __PMA_TRANSL('Garbage threshold'),
                'desc'  => __PMA_TRANSL(
                    'The percentage of garbage in a data log file'
                    . ' before it is compacted. This is a value between 1 and'
                    . ' 99. The default is 50.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_NUMERIC,
            ),
            'pbxt_log_buffer_size'         => array(
                'title' => __PMA_TRANSL('Log buffer size'),
                'desc'  => __PMA_TRANSL(
                    'The size of the buffer used when writing a data'
                    . ' log. The default is 256MB. The engine allocates one'
                    . ' buffer per thread, but only if the thread is required'
                    . ' to write a data log.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_data_file_grow_size'     => array(
                'title' => __PMA_TRANSL('Data file grow size'),
                'desc'  => __PMA_TRANSL('The grow size of the handle data (.xtd) files.'),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_row_file_grow_size'      => array(
                'title' => __PMA_TRANSL('Row file grow size'),
                'desc'  => __PMA_TRANSL('The grow size of the row pointer (.xtr) files.'),
                'type'  => PMA_ENGINE_DETAILS_TYPE_SIZE,
            ),
            'pbxt_log_file_count'          => array(
                'title' => __PMA_TRANSL('Log file count'),
                'desc'  => __PMA_TRANSL(
                    'This is the number of transaction log files'
                    . ' (pbxt/system/xlog*.xt) the system will maintain. If the'
                    . ' number of logs exceeds this value then old logs will be'
                    . ' deleted, otherwise they are renamed and given the next'
                    . ' highest number.'
                ),
                'type'  => PMA_ENGINE_DETAILS_TYPE_NUMERIC,
            ),
        );
    }

    /**
     * returns the pbxt engine specific handling for
     * PMA_ENGINE_DETAILS_TYPE_SIZE variables.
     *
     * @param string $formatted_size the size expression (for example 8MB)
     *
     * @return string the formatted value and its unit
     */
    public function resolveTypeSize($formatted_size)
    {
        if (preg_match('/^[0-9]+[a-zA-Z]+$/', $formatted_size)) {
            $value = Util::extractValueFromFormattedSize(
                $formatted_size
            );
        } else {
            $value = $formatted_size;
        }

        return Util::formatByteDown($value);
    }

    //--------------------
    /**
     * Get information about pages
     *
     * @return array Information about pages
     */
    public function getInfoPages()
    {
        $pages = array();
        $pages['Documentation'] = __PMA_TRANSL('Documentation');

        return $pages;
    }

    //--------------------
    /**
     * Get content of documentation page
     *
     * @return string
     */
    public function getPageDocumentation()
    {
        $output = '<p>' . sprintf(
            __PMA_TRANSL(
                'Documentation and further information about PBXT'
                . ' can be found on the %sPrimeBase XT Home Page%s.'
            ),
            '<a href="' . Core::linkURL('https://mariadb.com/kb/en/mariadb/about-pbxt/')
            . '" rel="noopener noreferrer" target="_blank">',
            '</a>'
        )
        . '</p>' . "\n";

        return $output;
    }
}
