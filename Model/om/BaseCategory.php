<?php

namespace Smirik\ContentBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Smirik\ContentBundle\Model\Category;
use Smirik\ContentBundle\Model\CategoryPeer;
use Smirik\ContentBundle\Model\CategoryQuery;
use Smirik\ContentBundle\Model\Content;
use Smirik\ContentBundle\Model\ContentQuery;

abstract class BaseCategory extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Smirik\\ContentBundle\\Model\\CategoryPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CategoryPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the pid field.
     * @var        int
     */
    protected $pid;

    /**
     * The value for the urlkey field.
     * @var        string
     */
    protected $urlkey;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the url field.
     * @var        string
     */
    protected $url;

    /**
     * The value for the navigation field.
     * @var        boolean
     */
    protected $navigation;

    /**
     * The value for the is_active field.
     * @var        boolean
     */
    protected $is_active;

    /**
     * The value for the mode field.
     * @var        boolean
     */
    protected $mode;

    /**
     * @var        Category
     */
    protected $aCategoryRelatedByPid;

    /**
     * @var        PropelObjectCollection|Category[] Collection to store aggregation of Category objects.
     */
    protected $collCategoriesRelatedById;
    protected $collCategoriesRelatedByIdPartial;

    /**
     * @var        PropelObjectCollection|Content[] Collection to store aggregation of Content objects.
     */
    protected $collContents;
    protected $collContentsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $categoriesRelatedByIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentsScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [pid] column value.
     *
     * @return int
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Get the [urlkey] column value.
     *
     * @return string
     */
    public function getUrlkey()
    {
        return $this->urlkey;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [navigation] column value.
     *
     * @return boolean
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Get the [mode] column value.
     *
     * @return boolean
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CategoryPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [pid] column.
     *
     * @param int $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setPid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->pid !== $v) {
            $this->pid = $v;
            $this->modifiedColumns[] = CategoryPeer::PID;
        }

        if ($this->aCategoryRelatedByPid !== null && $this->aCategoryRelatedByPid->getId() !== $v) {
            $this->aCategoryRelatedByPid = null;
        }


        return $this;
    } // setPid()

    /**
     * Set the value of [urlkey] column.
     *
     * @param string $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setUrlkey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->urlkey !== $v) {
            $this->urlkey = $v;
            $this->modifiedColumns[] = CategoryPeer::URLKEY;
        }


        return $this;
    } // setUrlkey()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = CategoryPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return Category The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[] = CategoryPeer::URL;
        }


        return $this;
    } // setUrl()

    /**
     * Sets the value of the [navigation] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Category The current object (for fluent API support)
     */
    public function setNavigation($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->navigation !== $v) {
            $this->navigation = $v;
            $this->modifiedColumns[] = CategoryPeer::NAVIGATION;
        }


        return $this;
    } // setNavigation()

    /**
     * Sets the value of the [is_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Category The current object (for fluent API support)
     */
    public function setIsActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_active !== $v) {
            $this->is_active = $v;
            $this->modifiedColumns[] = CategoryPeer::IS_ACTIVE;
        }


        return $this;
    } // setIsActive()

    /**
     * Sets the value of the [mode] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Category The current object (for fluent API support)
     */
    public function setMode($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->mode !== $v) {
            $this->mode = $v;
            $this->modifiedColumns[] = CategoryPeer::MODE;
        }


        return $this;
    } // setMode()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->pid = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->urlkey = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->title = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->url = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->navigation = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
            $this->is_active = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->mode = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = CategoryPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Category object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCategoryRelatedByPid !== null && $this->pid !== $this->aCategoryRelatedByPid->getId()) {
            $this->aCategoryRelatedByPid = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CategoryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCategoryRelatedByPid = null;
            $this->collCategoriesRelatedById = null;

            $this->collContents = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CategoryQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CategoryPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCategoryRelatedByPid !== null) {
                if ($this->aCategoryRelatedByPid->isModified() || $this->aCategoryRelatedByPid->isNew()) {
                    $affectedRows += $this->aCategoryRelatedByPid->save($con);
                }
                $this->setCategoryRelatedByPid($this->aCategoryRelatedByPid);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->categoriesRelatedByIdScheduledForDeletion !== null) {
                if (!$this->categoriesRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->categoriesRelatedByIdScheduledForDeletion as $categoryRelatedById) {
                        // need to save related object because we set the relation to null
                        $categoryRelatedById->save($con);
                    }
                    $this->categoriesRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collCategoriesRelatedById !== null) {
                foreach ($this->collCategoriesRelatedById as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentsScheduledForDeletion !== null) {
                if (!$this->contentsScheduledForDeletion->isEmpty()) {
                    ContentQuery::create()
                        ->filterByPrimaryKeys($this->contentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentsScheduledForDeletion = null;
                }
            }

            if ($this->collContents !== null) {
                foreach ($this->collContents as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CategoryPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CategoryPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CategoryPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(CategoryPeer::PID)) {
            $modifiedColumns[':p' . $index++]  = '`PID`';
        }
        if ($this->isColumnModified(CategoryPeer::URLKEY)) {
            $modifiedColumns[':p' . $index++]  = '`URLKEY`';
        }
        if ($this->isColumnModified(CategoryPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`TITLE`';
        }
        if ($this->isColumnModified(CategoryPeer::URL)) {
            $modifiedColumns[':p' . $index++]  = '`URL`';
        }
        if ($this->isColumnModified(CategoryPeer::NAVIGATION)) {
            $modifiedColumns[':p' . $index++]  = '`NAVIGATION`';
        }
        if ($this->isColumnModified(CategoryPeer::IS_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`IS_ACTIVE`';
        }
        if ($this->isColumnModified(CategoryPeer::MODE)) {
            $modifiedColumns[':p' . $index++]  = '`MODE`';
        }

        $sql = sprintf(
            'INSERT INTO `categories` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`PID`':
                        $stmt->bindValue($identifier, $this->pid, PDO::PARAM_INT);
                        break;
                    case '`URLKEY`':
                        $stmt->bindValue($identifier, $this->urlkey, PDO::PARAM_STR);
                        break;
                    case '`TITLE`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`URL`':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case '`NAVIGATION`':
                        $stmt->bindValue($identifier, (int) $this->navigation, PDO::PARAM_INT);
                        break;
                    case '`IS_ACTIVE`':
                        $stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
                        break;
                    case '`MODE`':
                        $stmt->bindValue($identifier, (int) $this->mode, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        } else {
            $this->validationFailures = $res;

            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCategoryRelatedByPid !== null) {
                if (!$this->aCategoryRelatedByPid->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCategoryRelatedByPid->getValidationFailures());
                }
            }


            if (($retval = CategoryPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collCategoriesRelatedById !== null) {
                    foreach ($this->collCategoriesRelatedById as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContents !== null) {
                    foreach ($this->collContents as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPid();
                break;
            case 2:
                return $this->getUrlkey();
                break;
            case 3:
                return $this->getTitle();
                break;
            case 4:
                return $this->getUrl();
                break;
            case 5:
                return $this->getNavigation();
                break;
            case 6:
                return $this->getIsActive();
                break;
            case 7:
                return $this->getMode();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Category'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Category'][$this->getPrimaryKey()] = true;
        $keys = CategoryPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPid(),
            $keys[2] => $this->getUrlkey(),
            $keys[3] => $this->getTitle(),
            $keys[4] => $this->getUrl(),
            $keys[5] => $this->getNavigation(),
            $keys[6] => $this->getIsActive(),
            $keys[7] => $this->getMode(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCategoryRelatedByPid) {
                $result['CategoryRelatedByPid'] = $this->aCategoryRelatedByPid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCategoriesRelatedById) {
                $result['CategoriesRelatedById'] = $this->collCategoriesRelatedById->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContents) {
                $result['Contents'] = $this->collContents->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPid($value);
                break;
            case 2:
                $this->setUrlkey($value);
                break;
            case 3:
                $this->setTitle($value);
                break;
            case 4:
                $this->setUrl($value);
                break;
            case 5:
                $this->setNavigation($value);
                break;
            case 6:
                $this->setIsActive($value);
                break;
            case 7:
                $this->setMode($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CategoryPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPid($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUrlkey($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTitle($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUrl($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setNavigation($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsActive($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setMode($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CategoryPeer::DATABASE_NAME);

        if ($this->isColumnModified(CategoryPeer::ID)) $criteria->add(CategoryPeer::ID, $this->id);
        if ($this->isColumnModified(CategoryPeer::PID)) $criteria->add(CategoryPeer::PID, $this->pid);
        if ($this->isColumnModified(CategoryPeer::URLKEY)) $criteria->add(CategoryPeer::URLKEY, $this->urlkey);
        if ($this->isColumnModified(CategoryPeer::TITLE)) $criteria->add(CategoryPeer::TITLE, $this->title);
        if ($this->isColumnModified(CategoryPeer::URL)) $criteria->add(CategoryPeer::URL, $this->url);
        if ($this->isColumnModified(CategoryPeer::NAVIGATION)) $criteria->add(CategoryPeer::NAVIGATION, $this->navigation);
        if ($this->isColumnModified(CategoryPeer::IS_ACTIVE)) $criteria->add(CategoryPeer::IS_ACTIVE, $this->is_active);
        if ($this->isColumnModified(CategoryPeer::MODE)) $criteria->add(CategoryPeer::MODE, $this->mode);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CategoryPeer::DATABASE_NAME);
        $criteria->add(CategoryPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Category (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPid($this->getPid());
        $copyObj->setUrlkey($this->getUrlkey());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setNavigation($this->getNavigation());
        $copyObj->setIsActive($this->getIsActive());
        $copyObj->setMode($this->getMode());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getCategoriesRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCategoryRelatedById($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContent($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Category Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CategoryPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CategoryPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Category object.
     *
     * @param             Category $v
     * @return Category The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCategoryRelatedByPid(Category $v = null)
    {
        if ($v === null) {
            $this->setPid(NULL);
        } else {
            $this->setPid($v->getId());
        }

        $this->aCategoryRelatedByPid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Category object, it will not be re-added.
        if ($v !== null) {
            $v->addCategoryRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated Category object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Category The associated Category object.
     * @throws PropelException
     */
    public function getCategoryRelatedByPid(PropelPDO $con = null)
    {
        if ($this->aCategoryRelatedByPid === null && ($this->pid !== null)) {
            $this->aCategoryRelatedByPid = CategoryQuery::create()->findPk($this->pid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCategoryRelatedByPid->addCategoriesRelatedById($this);
             */
        }

        return $this->aCategoryRelatedByPid;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CategoryRelatedById' == $relationName) {
            $this->initCategoriesRelatedById();
        }
        if ('Content' == $relationName) {
            $this->initContents();
        }
    }

    /**
     * Clears out the collCategoriesRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCategoriesRelatedById()
     */
    public function clearCategoriesRelatedById()
    {
        $this->collCategoriesRelatedById = null; // important to set this to null since that means it is uninitialized
        $this->collCategoriesRelatedByIdPartial = null;
    }

    /**
     * reset is the collCategoriesRelatedById collection loaded partially
     *
     * @return void
     */
    public function resetPartialCategoriesRelatedById($v = true)
    {
        $this->collCategoriesRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collCategoriesRelatedById collection.
     *
     * By default this just sets the collCategoriesRelatedById collection to an empty array (like clearcollCategoriesRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCategoriesRelatedById($overrideExisting = true)
    {
        if (null !== $this->collCategoriesRelatedById && !$overrideExisting) {
            return;
        }
        $this->collCategoriesRelatedById = new PropelObjectCollection();
        $this->collCategoriesRelatedById->setModel('Category');
    }

    /**
     * Gets an array of Category objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Category is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Category[] List of Category objects
     * @throws PropelException
     */
    public function getCategoriesRelatedById($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCategoriesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCategoriesRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCategoriesRelatedById) {
                // return empty collection
                $this->initCategoriesRelatedById();
            } else {
                $collCategoriesRelatedById = CategoryQuery::create(null, $criteria)
                    ->filterByCategoryRelatedByPid($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCategoriesRelatedByIdPartial && count($collCategoriesRelatedById)) {
                      $this->initCategoriesRelatedById(false);

                      foreach($collCategoriesRelatedById as $obj) {
                        if (false == $this->collCategoriesRelatedById->contains($obj)) {
                          $this->collCategoriesRelatedById->append($obj);
                        }
                      }

                      $this->collCategoriesRelatedByIdPartial = true;
                    }

                    return $collCategoriesRelatedById;
                }

                if($partial && $this->collCategoriesRelatedById) {
                    foreach($this->collCategoriesRelatedById as $obj) {
                        if($obj->isNew()) {
                            $collCategoriesRelatedById[] = $obj;
                        }
                    }
                }

                $this->collCategoriesRelatedById = $collCategoriesRelatedById;
                $this->collCategoriesRelatedByIdPartial = false;
            }
        }

        return $this->collCategoriesRelatedById;
    }

    /**
     * Sets a collection of CategoryRelatedById objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $categoriesRelatedById A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setCategoriesRelatedById(PropelCollection $categoriesRelatedById, PropelPDO $con = null)
    {
        $this->categoriesRelatedByIdScheduledForDeletion = $this->getCategoriesRelatedById(new Criteria(), $con)->diff($categoriesRelatedById);

        foreach ($this->categoriesRelatedByIdScheduledForDeletion as $categoryRelatedByIdRemoved) {
            $categoryRelatedByIdRemoved->setCategoryRelatedByPid(null);
        }

        $this->collCategoriesRelatedById = null;
        foreach ($categoriesRelatedById as $categoryRelatedById) {
            $this->addCategoryRelatedById($categoryRelatedById);
        }

        $this->collCategoriesRelatedById = $categoriesRelatedById;
        $this->collCategoriesRelatedByIdPartial = false;
    }

    /**
     * Returns the number of related Category objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Category objects.
     * @throws PropelException
     */
    public function countCategoriesRelatedById(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCategoriesRelatedByIdPartial && !$this->isNew();
        if (null === $this->collCategoriesRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCategoriesRelatedById) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getCategoriesRelatedById());
                }
                $query = CategoryQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByCategoryRelatedByPid($this)
                    ->count($con);
            }
        } else {
            return count($this->collCategoriesRelatedById);
        }
    }

    /**
     * Method called to associate a Category object to this object
     * through the Category foreign key attribute.
     *
     * @param    Category $l Category
     * @return Category The current object (for fluent API support)
     */
    public function addCategoryRelatedById(Category $l)
    {
        if ($this->collCategoriesRelatedById === null) {
            $this->initCategoriesRelatedById();
            $this->collCategoriesRelatedByIdPartial = true;
        }
        if (!in_array($l, $this->collCategoriesRelatedById->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCategoryRelatedById($l);
        }

        return $this;
    }

    /**
     * @param	CategoryRelatedById $categoryRelatedById The categoryRelatedById object to add.
     */
    protected function doAddCategoryRelatedById($categoryRelatedById)
    {
        $this->collCategoriesRelatedById[]= $categoryRelatedById;
        $categoryRelatedById->setCategoryRelatedByPid($this);
    }

    /**
     * @param	CategoryRelatedById $categoryRelatedById The categoryRelatedById object to remove.
     */
    public function removeCategoryRelatedById($categoryRelatedById)
    {
        if ($this->getCategoriesRelatedById()->contains($categoryRelatedById)) {
            $this->collCategoriesRelatedById->remove($this->collCategoriesRelatedById->search($categoryRelatedById));
            if (null === $this->categoriesRelatedByIdScheduledForDeletion) {
                $this->categoriesRelatedByIdScheduledForDeletion = clone $this->collCategoriesRelatedById;
                $this->categoriesRelatedByIdScheduledForDeletion->clear();
            }
            $this->categoriesRelatedByIdScheduledForDeletion[]= $categoryRelatedById;
            $categoryRelatedById->setCategoryRelatedByPid(null);
        }
    }

    /**
     * Clears out the collContents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContents()
     */
    public function clearContents()
    {
        $this->collContents = null; // important to set this to null since that means it is uninitialized
        $this->collContentsPartial = null;
    }

    /**
     * reset is the collContents collection loaded partially
     *
     * @return void
     */
    public function resetPartialContents($v = true)
    {
        $this->collContentsPartial = $v;
    }

    /**
     * Initializes the collContents collection.
     *
     * By default this just sets the collContents collection to an empty array (like clearcollContents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContents($overrideExisting = true)
    {
        if (null !== $this->collContents && !$overrideExisting) {
            return;
        }
        $this->collContents = new PropelObjectCollection();
        $this->collContents->setModel('Content');
    }

    /**
     * Gets an array of Content objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Category is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Content[] List of Content objects
     * @throws PropelException
     */
    public function getContents($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentsPartial && !$this->isNew();
        if (null === $this->collContents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContents) {
                // return empty collection
                $this->initContents();
            } else {
                $collContents = ContentQuery::create(null, $criteria)
                    ->filterByCategory($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentsPartial && count($collContents)) {
                      $this->initContents(false);

                      foreach($collContents as $obj) {
                        if (false == $this->collContents->contains($obj)) {
                          $this->collContents->append($obj);
                        }
                      }

                      $this->collContentsPartial = true;
                    }

                    return $collContents;
                }

                if($partial && $this->collContents) {
                    foreach($this->collContents as $obj) {
                        if($obj->isNew()) {
                            $collContents[] = $obj;
                        }
                    }
                }

                $this->collContents = $collContents;
                $this->collContentsPartial = false;
            }
        }

        return $this->collContents;
    }

    /**
     * Sets a collection of Content objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contents A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setContents(PropelCollection $contents, PropelPDO $con = null)
    {
        $this->contentsScheduledForDeletion = $this->getContents(new Criteria(), $con)->diff($contents);

        foreach ($this->contentsScheduledForDeletion as $contentRemoved) {
            $contentRemoved->setCategory(null);
        }

        $this->collContents = null;
        foreach ($contents as $content) {
            $this->addContent($content);
        }

        $this->collContents = $contents;
        $this->collContentsPartial = false;
    }

    /**
     * Returns the number of related Content objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Content objects.
     * @throws PropelException
     */
    public function countContents(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentsPartial && !$this->isNew();
        if (null === $this->collContents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContents) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getContents());
                }
                $query = ContentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByCategory($this)
                    ->count($con);
            }
        } else {
            return count($this->collContents);
        }
    }

    /**
     * Method called to associate a Content object to this object
     * through the Content foreign key attribute.
     *
     * @param    Content $l Content
     * @return Category The current object (for fluent API support)
     */
    public function addContent(Content $l)
    {
        if ($this->collContents === null) {
            $this->initContents();
            $this->collContentsPartial = true;
        }
        if (!in_array($l, $this->collContents->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContent($l);
        }

        return $this;
    }

    /**
     * @param	Content $content The content object to add.
     */
    protected function doAddContent($content)
    {
        $this->collContents[]= $content;
        $content->setCategory($this);
    }

    /**
     * @param	Content $content The content object to remove.
     */
    public function removeContent($content)
    {
        if ($this->getContents()->contains($content)) {
            $this->collContents->remove($this->collContents->search($content));
            if (null === $this->contentsScheduledForDeletion) {
                $this->contentsScheduledForDeletion = clone $this->collContents;
                $this->contentsScheduledForDeletion->clear();
            }
            $this->contentsScheduledForDeletion[]= $content;
            $content->setCategory(null);
        }
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->pid = null;
        $this->urlkey = null;
        $this->title = null;
        $this->url = null;
        $this->navigation = null;
        $this->is_active = null;
        $this->mode = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCategoriesRelatedById) {
                foreach ($this->collCategoriesRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContents) {
                foreach ($this->collContents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collCategoriesRelatedById instanceof PropelCollection) {
            $this->collCategoriesRelatedById->clearIterator();
        }
        $this->collCategoriesRelatedById = null;
        if ($this->collContents instanceof PropelCollection) {
            $this->collContents->clearIterator();
        }
        $this->collContents = null;
        $this->aCategoryRelatedByPid = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CategoryPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
