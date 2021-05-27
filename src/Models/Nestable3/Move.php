<?php
namespace Sina\Shuttle\Models\Nestable;

use \Illuminate\Events\Dispatcher;

/**
 * Move
 */
class Move {


    protected $node = NULL;


    protected $target = NULL;


    protected $position = NULL;


    protected $_bound1 = NULL;


    protected $_bound2 = NULL;


    protected $_boundaries = NULL;


    public function __construct($node, $target, $position) {
        $this->node     = $node;
        $this->target   = $this->resolveNode($target);
        $this->position = $position;
    }


    public static function to($node, $target, $position) {
        $instance = new static($node, $target, $position);

        return $instance->perform();
    }


    public function perform() {

        if ( $this->hasChange() ) {
            $self = $this;

            $this->node->getConnection()->transaction(function() use ($self) {
                $self->updateStructure();
            });

            $this->target->reload();

            $this->node->setDepthWithSubtree();

            $this->node->reload();
        }

        return $this->node;
    }


    public function updateStructure() {
        list($a, $b, $c, $d) = $this->boundaries();

//        dd($a, $b, $c, $d);

        // select the rows between the leftmost & the rightmost boundaries and apply a lock
        $this->applyLockBetween($a, $d);

        $connection = $this->node->getConnection();
        $grammar    = $connection->getQueryGrammar();

        $currentId      = $this->quoteIdentifier($this->node->getKey());
        $parentId       = $this->quoteIdentifier($this->parentId());
        $leftColumn     = $this->node->getLeftColumnName();
        $rightColumn    = $this->node->getRightColumnName();
        $parentColumn   = $this->node->getParentColumnName();
        $wrappedLeft    = $grammar->wrap($leftColumn);
        $wrappedRight   = $grammar->wrap($rightColumn);
        $wrappedParent  = $grammar->wrap($parentColumn);
        $wrappedId      = $grammar->wrap($this->node->getKeyName());

        $lftSql = "CASE
          WHEN $wrappedLeft BETWEEN $a AND $b THEN $wrappedLeft + $d - $b
          WHEN $wrappedLeft BETWEEN $c AND $d THEN $wrappedLeft + $a - $c
          ELSE $wrappedLeft END";

        $rgtSql = "CASE
          WHEN $wrappedRight BETWEEN $a AND $b THEN $wrappedRight + $d - $b
          WHEN $wrappedRight BETWEEN $c AND $d THEN $wrappedRight + $a - $c
          ELSE $wrappedRight END";

        $parentSql = "CASE
          WHEN $wrappedId = $currentId THEN $parentId
          ELSE $wrappedParent END";

        $updateConditions = array(
            $leftColumn   => $connection->raw($lftSql),
            $rightColumn  => $connection->raw($rgtSql),
//            $parentColumn => $connection->raw($parentSql)
        );

//        dd($updateConditions);

        if ( $this->node->timestamps )
            $updateConditions[$this->node->getUpdatedAtColumn()] = $this->node->freshTimestamp();

        return $this->node
            ->newNestedSetQuery()
            ->where(function($query) use ($leftColumn, $rightColumn, $a, $d) {
                $query->whereBetween($leftColumn, array($a, $d))
                    ->orWhereBetween($rightColumn, array($a, $d));
            })
            ->update($updateConditions);
    }


    protected function resolveNode($node) {
        if ( $node instanceof Nestable ) return $node->reload();

        return $node;//$this->node->newNestedSetQuery()->find($node);
    }


    protected function bound1() {
        if ( !is_null($this->_bound1) ) return $this->_bound1;
//        dd($this->target);
        switch ( $this->position ) {
            case 'child':
                $this->_bound1 = $this->target->getRight();
//                dd($this->target->getRight());
                break;

            case 'left':
                $this->_bound1 = $this->target->getLeft();
                break;

            case 'right':
                $this->_bound1 = $this->target->getRight() + 1;
                break;

            case 'root':
                $this->_bound1 = $this->node->newNestedSetQuery()->max($this->node->getRightColumnName()) + 1;
                break;
        }

        $this->_bound1 = (($this->_bound1 > $this->node->getRight()) ? $this->_bound1 - 1 : $this->_bound1);
        return $this->_bound1;
    }

    protected function bound2() {
        if ( !is_null($this->_bound2) ) return $this->_bound2;

        $this->_bound2 = (($this->bound1() > $this->node->getRight()) ? $this->node->getRight() + 1 : $this->node->getLeft() - 1);
        return $this->_bound2;
    }

    protected function boundaries() {
        if ( !is_null($this->_boundaries) ) return $this->_boundaries;

        // we have defined the boundaries of two non-overlapping intervals,
        // so sorting puts both the intervals and their boundaries in order
        $this->_boundaries = array(
            $this->node->getLeft()  ,
            $this->node->getRight() ,
            $this->bound1()         ,
            $this->bound2()
        );
        sort($this->_boundaries);

        dd($this->_boundaries);

        return $this->_boundaries;
    }


    protected function parentId() {
        switch( $this->position ) {
            case 'root':
                return 0;

            case 'child':
                return $this->target->id;

            default:
                return $this->target->getParentId();
        }
    }


    protected function hasChange() {
        return !( $this->bound1() == $this->node->getRight() || $this->bound1() == $this->node->getLeft() );
    }


    protected function promotingToRoot() {
        return ($this->position == 'root');
    }


    protected function quoteIdentifier($value) {
        if ( is_null($value) )
            return 0;

        $connection = $this->node->getConnection();

        $pdo = $connection->getPdo();

        return $pdo->quote($value);
    }


    protected function applyLockBetween($lft, $rgt) {
        $this->node->newQuery()
            ->where($this->node->getLeftColumnName(), '>=', $lft ?? 0)
            ->where($this->node->getRightColumnName(), '<=', $rgt ?? 0)
            ->select($this->node->getKeyName())
            ->lockForUpdate()
            ->get();
    }
}
