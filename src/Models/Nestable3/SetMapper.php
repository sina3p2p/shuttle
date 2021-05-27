<?php
namespace Sina\Shuttle\Models\Nestable;

use \Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Contracts\ArrayableInterface;

class SetMapper {

    protected $node = NULL;

    protected $childrenKeyName = 'children';

    public function __construct($node, $childrenKeyName = 'children') {
        $this->node = $node;

        $this->childrenKeyName = $childrenKeyName;
    }


    public function map($nodeList) {
        $self = $this;

        return $this->wrapInTransaction(function() use ($self, $nodeList) {
            forward_static_call(array(get_class($self->node), 'unguard'));

            $result = $self->mapTree($nodeList);

            forward_static_call(array(get_class($self->node), 'reguard'));

            return $result;
        });
    }


    public function mapTree($nodeList) {
        $tree = $nodeList instanceof ArrayableInterface ? $nodeList->toArray() : $nodeList;

        $affectedKeys = array();

        $result = $this->mapTreeRecursive($tree, 0, $affectedKeys);

//        if ( $result && count($affectedKeys) > 0 )
//            $this->deleteUnaffected($affectedKeys);

        return $result;
    }


    public function getChildrenKeyName() {
        return $this->childrenKeyName;
    }


    protected function mapTreeRecursive(array $tree, $parentKey = 0, &$affectedKeys = array()) {

        $i = 0;
        foreach($tree as $attributes) {
            $node = $this->firstOrNew($this->getSearchAttributes($attributes));

            $node->{$node->getParentColumnName()} = $parentKey;
            $node->{$node->getOrdColumnName()} = $i;

            $result = $node->save();
            $i++;

            if ( ! $result ) return false;

            $affectedKeys[] = $node->getKey();

            if ( array_key_exists($this->getChildrenKeyName(), $attributes) ) {
                $children = $attributes[$this->getChildrenKeyName()];

                if ( count($children) > 0 ) {
                    $result = $this->mapTreeRecursive($children, $node->id, $affectedKeys);

                    if ( ! $result ) return false;
                }
            }
        }

        return true;
    }

    protected function getSearchAttributes($attributes) {
        $searchable = array($this->node->getKeyName());

        return Arr::only($attributes, $searchable);
    }

    protected function getDataAttributes($attributes) {
        $exceptions = array($this->node->getKeyName(), $this->getChildrenKeyName());

        return Arr::except($attributes, $exceptions);
    }

    protected function firstOrNew($attributes) {
        $className = get_class($this->node);

        if ( count($attributes) === 0 )
            return new $className;

        return forward_static_call(array($className, 'firstOrNew'), $attributes);
    }

    protected function pruneScope() {
        if ( $this->node->exists )
            return $this->node->descendants();

        return $this->node->newNestedSetQuery();
    }

    protected function deleteUnaffected($keys = array()) {
        return $this->pruneScope()->whereNotIn($this->node->getKeyName(), $keys)->delete();
    }

    protected function wrapInTransaction(Closure $callback) {
        return $this->node->getConnection()->transaction($callback);
    }

}
