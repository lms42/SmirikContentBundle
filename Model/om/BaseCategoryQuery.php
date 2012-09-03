<?php

namespace Smirik\ContentBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Smirik\ContentBundle\Model\Category;
use Smirik\ContentBundle\Model\CategoryPeer;
use Smirik\ContentBundle\Model\CategoryQuery;
use Smirik\ContentBundle\Model\Content;

/**
 * @method CategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CategoryQuery orderByPid($order = Criteria::ASC) Order by the pid column
 * @method CategoryQuery orderByUrlkey($order = Criteria::ASC) Order by the urlkey column
 * @method CategoryQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method CategoryQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method CategoryQuery orderByNavigation($order = Criteria::ASC) Order by the navigation column
 * @method CategoryQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method CategoryQuery orderByMode($order = Criteria::ASC) Order by the mode column
 *
 * @method CategoryQuery groupById() Group by the id column
 * @method CategoryQuery groupByPid() Group by the pid column
 * @method CategoryQuery groupByUrlkey() Group by the urlkey column
 * @method CategoryQuery groupByTitle() Group by the title column
 * @method CategoryQuery groupByUrl() Group by the url column
 * @method CategoryQuery groupByNavigation() Group by the navigation column
 * @method CategoryQuery groupByIsActive() Group by the is_active column
 * @method CategoryQuery groupByMode() Group by the mode column
 *
 * @method CategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CategoryQuery leftJoinCategoryRelatedByPid($relationAlias = null) Adds a LEFT JOIN clause to the query using the CategoryRelatedByPid relation
 * @method CategoryQuery rightJoinCategoryRelatedByPid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CategoryRelatedByPid relation
 * @method CategoryQuery innerJoinCategoryRelatedByPid($relationAlias = null) Adds a INNER JOIN clause to the query using the CategoryRelatedByPid relation
 *
 * @method CategoryQuery leftJoinCategoryRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the CategoryRelatedById relation
 * @method CategoryQuery rightJoinCategoryRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CategoryRelatedById relation
 * @method CategoryQuery innerJoinCategoryRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the CategoryRelatedById relation
 *
 * @method CategoryQuery leftJoinContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Content relation
 * @method CategoryQuery rightJoinContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Content relation
 * @method CategoryQuery innerJoinContent($relationAlias = null) Adds a INNER JOIN clause to the query using the Content relation
 *
 * @method Category findOne(PropelPDO $con = null) Return the first Category matching the query
 * @method Category findOneOrCreate(PropelPDO $con = null) Return the first Category matching the query, or a new Category object populated from the query conditions when no match is found
 *
 * @method Category findOneByPid(int $pid) Return the first Category filtered by the pid column
 * @method Category findOneByUrlkey(string $urlkey) Return the first Category filtered by the urlkey column
 * @method Category findOneByTitle(string $title) Return the first Category filtered by the title column
 * @method Category findOneByUrl(string $url) Return the first Category filtered by the url column
 * @method Category findOneByNavigation(boolean $navigation) Return the first Category filtered by the navigation column
 * @method Category findOneByIsActive(boolean $is_active) Return the first Category filtered by the is_active column
 * @method Category findOneByMode(boolean $mode) Return the first Category filtered by the mode column
 *
 * @method array findById(int $id) Return Category objects filtered by the id column
 * @method array findByPid(int $pid) Return Category objects filtered by the pid column
 * @method array findByUrlkey(string $urlkey) Return Category objects filtered by the urlkey column
 * @method array findByTitle(string $title) Return Category objects filtered by the title column
 * @method array findByUrl(string $url) Return Category objects filtered by the url column
 * @method array findByNavigation(boolean $navigation) Return Category objects filtered by the navigation column
 * @method array findByIsActive(boolean $is_active) Return Category objects filtered by the is_active column
 * @method array findByMode(boolean $mode) Return Category objects filtered by the mode column
 */
abstract class BaseCategoryQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCategoryQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'Smirik\\ContentBundle\\Model\\Category', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     CategoryQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CategoryQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CategoryQuery) {
            return $criteria;
        }
        $query = new CategoryQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Category|Category[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CategoryPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   Category A model object, or null if the key is not found
     * @throws   PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return   Category A model object, or null if the key is not found
     * @throws   PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `ID`, `PID`, `URLKEY`, `TITLE`, `URL`, `NAVIGATION`, `IS_ACTIVE`, `MODE` FROM `categories` WHERE `ID` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Category();
            $obj->hydrate($row);
            CategoryPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Category|Category[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Category[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CategoryPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CategoryPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id) && null === $comparison) {
            $comparison = Criteria::IN;
        }

        return $this->addUsingAlias(CategoryPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the pid column
     *
     * Example usage:
     * <code>
     * $query->filterByPid(1234); // WHERE pid = 1234
     * $query->filterByPid(array(12, 34)); // WHERE pid IN (12, 34)
     * $query->filterByPid(array('min' => 12)); // WHERE pid > 12
     * </code>
     *
     * @see       filterByCategoryRelatedByPid()
     *
     * @param     mixed $pid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByPid($pid = null, $comparison = null)
    {
        if (is_array($pid)) {
            $useMinMax = false;
            if (isset($pid['min'])) {
                $this->addUsingAlias(CategoryPeer::PID, $pid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pid['max'])) {
                $this->addUsingAlias(CategoryPeer::PID, $pid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategoryPeer::PID, $pid, $comparison);
    }

    /**
     * Filter the query on the urlkey column
     *
     * Example usage:
     * <code>
     * $query->filterByUrlkey('fooValue');   // WHERE urlkey = 'fooValue'
     * $query->filterByUrlkey('%fooValue%'); // WHERE urlkey LIKE '%fooValue%'
     * </code>
     *
     * @param     string $urlkey The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByUrlkey($urlkey = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($urlkey)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $urlkey)) {
                $urlkey = str_replace('*', '%', $urlkey);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategoryPeer::URLKEY, $urlkey, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategoryPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CategoryPeer::URL, $url, $comparison);
    }

    /**
     * Filter the query on the navigation column
     *
     * Example usage:
     * <code>
     * $query->filterByNavigation(true); // WHERE navigation = true
     * $query->filterByNavigation('yes'); // WHERE navigation = true
     * </code>
     *
     * @param     boolean|string $navigation The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByNavigation($navigation = null, $comparison = null)
    {
        if (is_string($navigation)) {
            $navigation = in_array(strtolower($navigation), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CategoryPeer::NAVIGATION, $navigation, $comparison);
    }

    /**
     * Filter the query on the is_active column
     *
     * Example usage:
     * <code>
     * $query->filterByIsActive(true); // WHERE is_active = true
     * $query->filterByIsActive('yes'); // WHERE is_active = true
     * </code>
     *
     * @param     boolean|string $isActive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_string($isActive)) {
            $is_active = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CategoryPeer::IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query on the mode column
     *
     * Example usage:
     * <code>
     * $query->filterByMode(true); // WHERE mode = true
     * $query->filterByMode('yes'); // WHERE mode = true
     * </code>
     *
     * @param     boolean|string $mode The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function filterByMode($mode = null, $comparison = null)
    {
        if (is_string($mode)) {
            $mode = in_array(strtolower($mode), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CategoryPeer::MODE, $mode, $comparison);
    }

    /**
     * Filter the query by a related Category object
     *
     * @param   Category|PropelObjectCollection $category The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   CategoryQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByCategoryRelatedByPid($category, $comparison = null)
    {
        if ($category instanceof Category) {
            return $this
                ->addUsingAlias(CategoryPeer::PID, $category->getId(), $comparison);
        } elseif ($category instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CategoryPeer::PID, $category->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategoryRelatedByPid() only accepts arguments of type Category or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CategoryRelatedByPid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function joinCategoryRelatedByPid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CategoryRelatedByPid');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CategoryRelatedByPid');
        }

        return $this;
    }

    /**
     * Use the CategoryRelatedByPid relation Category object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Smirik\ContentBundle\Model\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryRelatedByPidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategoryRelatedByPid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CategoryRelatedByPid', '\Smirik\ContentBundle\Model\CategoryQuery');
    }

    /**
     * Filter the query by a related Category object
     *
     * @param   Category|PropelObjectCollection $category  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   CategoryQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByCategoryRelatedById($category, $comparison = null)
    {
        if ($category instanceof Category) {
            return $this
                ->addUsingAlias(CategoryPeer::ID, $category->getPid(), $comparison);
        } elseif ($category instanceof PropelObjectCollection) {
            return $this
                ->useCategoryRelatedByIdQuery()
                ->filterByPrimaryKeys($category->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCategoryRelatedById() only accepts arguments of type Category or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CategoryRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function joinCategoryRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CategoryRelatedById');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CategoryRelatedById');
        }

        return $this;
    }

    /**
     * Use the CategoryRelatedById relation Category object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Smirik\ContentBundle\Model\CategoryQuery A secondary query class using the current class as primary query
     */
    public function useCategoryRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCategoryRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CategoryRelatedById', '\Smirik\ContentBundle\Model\CategoryQuery');
    }

    /**
     * Filter the query by a related Content object
     *
     * @param   Content|PropelObjectCollection $content  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   CategoryQuery The current query, for fluid interface
     * @throws   PropelException - if the provided filter is invalid.
     */
    public function filterByContent($content, $comparison = null)
    {
        if ($content instanceof Content) {
            return $this
                ->addUsingAlias(CategoryPeer::ID, $content->getCategoryId(), $comparison);
        } elseif ($content instanceof PropelObjectCollection) {
            return $this
                ->useContentQuery()
                ->filterByPrimaryKeys($content->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContent() only accepts arguments of type Content or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Content relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function joinContent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Content');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Content');
        }

        return $this;
    }

    /**
     * Use the Content relation Content object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Smirik\ContentBundle\Model\ContentQuery A secondary query class using the current class as primary query
     */
    public function useContentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Content', '\Smirik\ContentBundle\Model\ContentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Category $category Object to remove from the list of results
     *
     * @return CategoryQuery The current query, for fluid interface
     */
    public function prune($category = null)
    {
        if ($category) {
            $this->addUsingAlias(CategoryPeer::ID, $category->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
