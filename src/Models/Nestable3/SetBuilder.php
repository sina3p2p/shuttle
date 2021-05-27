<?php
namespace Sina\Shuttle\Models\Nestable;

class SetBuilder {

    protected $node = NULL;

    protected $bounds = array();

    protected $conditions = array();

    public function __construct($node) {
        $this->node = $node;
    }

    public function rebuild($force = false, array $conditions = []) {
        $alreadyValid = forward_static_call(array(get_class($this->node), 'isValidNestedSet'));

        if ( !$force && $alreadyValid ) return true;

        $self = $this;

        $this->node->getConnection()->transaction(function() use ($self, $conditions) {
            foreach($self->roots($conditions) as $root)
                $self->rebuildBounds($root, 0);
        });
    }


    public function roots(array $conditions) {
        return $this->node->newQuery()
            ->where($conditions)
            ->where($this->node->getQualifiedParentColumnName(),0)
            ->orderBy($this->node->getQualifiedLeftColumnName())
            ->orderBy($this->node->getQualifiedRightColumnName())
            ->orderBy($this->node->getQualifiedKeyName())
            ->get();
    }

    public function rebuildBounds($node, $depth = 0) {
        $k = $this->scopedKey($node);

        $node->{$node->getLeftColumnName()} = $this->getNextBound($k);
        $node->{$node->getDepthColumnName()} = $depth;

        foreach($this->children($node) as $child)
            $this->rebuildBounds($child, $depth + 1);

        $node->{$node->getRightColumnName()} = $this->getNextBound($k);

        $node->save();
    }

    public function children($node) {
        $query = $this->node->newQuery();

        $query->where($this->node->getQualifiedParentColumnName(), '=', $node->id);


        foreach($this->scopedAttributes($node) as $fld => $value)
            $query->where($this->qualify($fld), '=', $value);

        $query->orderBy($this->node->getQualifiedLeftColumnName());
        $query->orderBy($this->node->getQualifiedRightColumnName());
        $query->orderBy($this->node->getQualifiedKeyName());

        return $query->get();
    }

    protected function scopedAttributes($node) {
        $keys = $this->node->getScopedColumns();

        if ( count($keys) == 0 )
            return array();

        $values = array_map(function($column) use ($node) {
            return $node->getAttribute($column); }, $keys);

        return array_combine($keys, $values);
    }

    protected function scopedKey($node) {
        $attributes = $this->scopedAttributes($node);

        $output = array();

        foreach($attributes as $fld => $value)
            $output[] = $this->qualify($fld).'='.(is_null($value) ? 'NULL' : $value);

        // NOTE: Maybe an md5 or something would be better. Should be unique though.
        return implode(',', $output);
    }

    protected function getNextBound($key) {
        if ( false === array_key_exists($key, $this->bounds) )
            $this->bounds[$key] = 0;

        $this->bounds[$key] = $this->bounds[$key] + 1;

        return $this->bounds[$key];
    }

    protected function qualify($column) {
        return $this->node->getTable() . '.' . $column;
    }

}
