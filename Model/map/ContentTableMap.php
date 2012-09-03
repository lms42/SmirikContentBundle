<?php

namespace Smirik\ContentBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'content' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Smirik.ContentBundle.Model.map
 */
class ContentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Smirik.ContentBundle.Model.map.ContentTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('content');
        $this->setPhpName('Content');
        $this->setClassname('Smirik\\ContentBundle\\Model\\Content');
        $this->setPackage('src.Smirik.ContentBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('CATEGORY_ID', 'CategoryId', 'INTEGER', 'categories', 'ID', true, null, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 100, null);
        $this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('TEXT', 'Text', 'CLOB', true, null, null);
        $this->addColumn('URLKEY', 'Urlkey', 'VARCHAR', false, 50, null);
        $this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, 1, null);
        $this->addColumn('WEIGHT', 'Weight', 'INTEGER', false, null, null);
        $this->addColumn('FILE', 'File', 'VARCHAR', false, 200, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Category', 'Smirik\\ContentBundle\\Model\\Category', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), null, null);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

} // ContentTableMap
