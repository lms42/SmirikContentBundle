<?php

namespace Smirik\ContentBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'categories' table.
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
class CategoryTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Smirik.ContentBundle.Model.map.CategoryTableMap';

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
        $this->setName('categories');
        $this->setPhpName('Category');
        $this->setClassname('Smirik\\ContentBundle\\Model\\Category');
        $this->setPackage('src.Smirik.ContentBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('PID', 'Pid', 'INTEGER', 'categories', 'ID', false, null, null);
        $this->addColumn('URLKEY', 'Urlkey', 'VARCHAR', true, 100, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', true, 100, null);
        $this->addColumn('URL', 'Url', 'VARCHAR', false, 200, null);
        $this->addColumn('NAVIGATION', 'Navigation', 'BOOLEAN', false, 1, null);
        $this->addColumn('IS_ACTIVE', 'IsActive', 'BOOLEAN', false, 1, null);
        $this->addColumn('MODE', 'Mode', 'BOOLEAN', false, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CategoryRelatedByPid', 'Smirik\\ContentBundle\\Model\\Category', RelationMap::MANY_TO_ONE, array('pid' => 'id', ), null, null);
        $this->addRelation('CategoryRelatedById', 'Smirik\\ContentBundle\\Model\\Category', RelationMap::ONE_TO_MANY, array('id' => 'pid', ), null, null, 'CategoriesRelatedById');
        $this->addRelation('Content', 'Smirik\\ContentBundle\\Model\\Content', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), null, null, 'Contents');
    } // buildRelations()

} // CategoryTableMap
