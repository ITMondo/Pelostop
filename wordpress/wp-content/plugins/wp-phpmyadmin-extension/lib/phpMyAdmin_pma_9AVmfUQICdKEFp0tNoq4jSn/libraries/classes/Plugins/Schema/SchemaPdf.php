<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * PDF schema export code
 *
 * @package    PhpMyAdmin-Schema
 * @subpackage PDF
 */
namespace PhpMyAdmin\Plugins\Schema;

use PhpMyAdmin\Properties\Options\Items\BoolPropertyItem;
use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyMainGroup;
use PhpMyAdmin\Properties\Options\Groups\OptionsPropertyRootGroup;
use PhpMyAdmin\Plugins\Schema\Pdf\PdfRelationSchema;
use PhpMyAdmin\Plugins\SchemaPlugin;
use PhpMyAdmin\Properties\Plugins\SchemaPluginProperties;
use PhpMyAdmin\Properties\Options\Items\SelectPropertyItem;

/**
 * Handles the schema export for the PDF format
 *
 * @package    PhpMyAdmin-Schema
 * @subpackage PDF
 */
class SchemaPdf extends SchemaPlugin
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setProperties();
    }

    /**
     * Sets the schema export PDF properties
     *
     * @return void
     */
    protected function setProperties()
    {
        $schemaPluginProperties = new SchemaPluginProperties();
        $schemaPluginProperties->setText('PDF');
        $schemaPluginProperties->setExtension('pdf');
        $schemaPluginProperties->setMimeType('application/pdf');

        // create the root group that will be the options field for
        // $schemaPluginProperties
        // this will be shown as "Format specific options"
        $exportSpecificOptions = new OptionsPropertyRootGroup(
            "Format Specific Options"
        );

        // specific options main group
        $specificOptions = new OptionsPropertyMainGroup("general_opts");
        // add options common to all plugins
        $this->addCommonOptions($specificOptions);

        // create leaf items and add them to the group
        $leaf = new BoolPropertyItem(
            'all_tables_same_width',
            __PMA_TRANSL('Same width for all tables')
        );
        $specificOptions->addProperty($leaf);

        $leaf = new SelectPropertyItem(
            "orientation",
            __PMA_TRANSL('Orientation')
        );
        $leaf->setValues(
            array(
                'L' => __PMA_TRANSL('Landscape'),
                'P' => __PMA_TRANSL('Portrait'),
            )
        );
        $specificOptions->addProperty($leaf);

        $leaf = new SelectPropertyItem(
            "paper",
            __PMA_TRANSL('Paper size')
        );
        $leaf->setValues($this->getPaperSizeArray());
        $specificOptions->addProperty($leaf);

        $leaf = new BoolPropertyItem(
            'show_grid',
            __PMA_TRANSL('Show grid')
        );
        $specificOptions->addProperty($leaf);

        $leaf = new BoolPropertyItem(
            'with_doc',
            __PMA_TRANSL('Data dictionary')
        );
        $specificOptions->addProperty($leaf);

        $leaf = new SelectPropertyItem(
            "table_order",
            __PMA_TRANSL('Order of the tables')
        );
        $leaf->setValues(
            array(
                ''          => __PMA_TRANSL('None'),
                'name_asc'  => __PMA_TRANSL('Name (Ascending)'),
                'name_desc' => __PMA_TRANSL('Name (Descending)'),
            )
        );
        $specificOptions->addProperty($leaf);

        // add the main group to the root group
        $exportSpecificOptions->addProperty($specificOptions);

        // set the options for the schema export plugin property item
        $schemaPluginProperties->setOptions($exportSpecificOptions);
        $this->properties = $schemaPluginProperties;
    }

    /**
     * Exports the schema into PDF format.
     *
     * @param string $db database name
     *
     * @return bool Whether it succeeded
     */
    public function exportSchema($db)
    {
        $export = new PdfRelationSchema($db);
        $export->showOutput();
    }
}
