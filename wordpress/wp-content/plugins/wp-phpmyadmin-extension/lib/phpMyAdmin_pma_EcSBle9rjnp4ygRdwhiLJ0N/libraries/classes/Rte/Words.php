<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Helper functions for RTE
 *
 * @package PhpMyAdmin
 */
namespace PhpMyAdmin\Rte;

/**
 * PhpMyAdmin\Rte\Words class
 *
 * @package PhpMyAdmin
 */
class Words
{
    /**
     * This function is used to retrieve some language strings that are used
     * in features that are common to routines, triggers and events.
     *
     * @param string $index The index of the string to get
     *
     * @return string The requested string or an empty string, if not available
     */
    public static function get($index)
    {
        global $_PMA_RTE;

        switch ($_PMA_RTE) {
        case 'RTN':
            $words = array(
                'add'       => __PMA_TRANSL('Add routine'),
                'docu'      => 'STORED_ROUTINES',
                'export'    => __PMA_TRANSL('Export of routine %s'),
                'human'     => __PMA_TRANSL('routine'),
                'no_create' => __PMA_TRANSL(
                    'You do not have the necessary privileges to create a routine.'
                ),
                'no_edit'   => __PMA_TRANSL(
                    'No routine with name %1$s found in database %2$s. '
                    . 'You might be lacking the necessary privileges to edit this routine.'
                ),
                'no_view'   => __PMA_TRANSL(
                    'No routine with name %1$s found in database %2$s. '
                    . 'You might be lacking the necessary privileges to view/export this routine.'
                ),
                'not_found' => __PMA_TRANSL('No routine with name %1$s found in database %2$s.'),
                'nothing'   => __PMA_TRANSL('There are no routines to display.'),
                'title'     => __PMA_TRANSL('Routines'),
            );
            break;
        case 'TRI':
            $words = array(
                'add'       => __PMA_TRANSL('Add trigger'),
                'docu'      => 'TRIGGERS',
                'export'    => __PMA_TRANSL('Export of trigger %s'),
                'human'     => __PMA_TRANSL('trigger'),
                'no_create' => __PMA_TRANSL(
                    'You do not have the necessary privileges to create a trigger.'
                ),
                'not_found' => __PMA_TRANSL('No trigger with name %1$s found in database %2$s.'),
                'nothing'   => __PMA_TRANSL('There are no triggers to display.'),
                'title'     => __PMA_TRANSL('Triggers'),
            );
            break;
        case 'EVN':
            $words = array(
                'add'       => __PMA_TRANSL('Add event'),
                'docu'      => 'EVENTS',
                'export'    => __PMA_TRANSL('Export of event %s'),
                'human'     => __PMA_TRANSL('event'),
                'no_create' => __PMA_TRANSL(
                    'You do not have the necessary privileges to create an event.'
                ),
                'not_found' => __PMA_TRANSL('No event with name %1$s found in database %2$s.'),
                'nothing'   => __PMA_TRANSL('There are no events to display.'),
                'title'     => __PMA_TRANSL('Events'),
            );
            break;
        default:
            $words = array();
            break;
        }

        return isset($words[$index]) ? $words[$index] : '';
    } // end self::get()
}
