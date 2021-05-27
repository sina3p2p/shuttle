<?php

namespace Sina\Shuttle\Models;

use stdClass;

class QueryBuilder {

    protected $fields;

    protected $route;

    protected $request;

    public function __construct(array $fields = null, array $routes = null, array $request = null)
    {
        $this->fields = $fields;
        $this->route = $routes;
        $this->request = $request;
    }

    public function parse($json, $querybuilder)
    {
        $query = json_decode($json);

        if (!isset($query->rules) || !is_array($query->rules)) {
            return $querybuilder;
        }

        if (count($query->rules) < 1) {
            return $querybuilder;
        }

        return $this->loopThroughRules($query->rules, $querybuilder, $query->condition);
    }


    protected function loopThroughRules(array $rules,  $querybuilder, $queryCondition = 'AND')
    {
        foreach ($rules as $rule) {
            $querybuilder = $this->makeQuery($querybuilder, $rule, $queryCondition);

            if ($this->isNested($rule)) {
                $querybuilder = $this->createNestedQuery($querybuilder, $rule, $queryCondition);
            }
        }

        return $querybuilder;
    }


    protected function isNested($rule)
    {
        if (isset($rule->rules) && is_array($rule->rules) && count($rule->rules) > 0) {
            return true;
        }

        return false;
    }


    protected function createNestedQuery( $querybuilder, stdClass $rule, $condition = null)
    {
        if ($condition === null) {
            $condition = $rule->condition;
        }

        $condition = $this->validateCondition($condition);

        return $querybuilder->whereNested(function ($query) use (&$rule, &$querybuilder, &$condition) {
            foreach ($rule->rules as $loopRule) {
                $function = 'makeQuery';

                if ($this->isNested($loopRule)) {
                    $function = 'createNestedQuery';
                }

                $querybuilder = $this->{$function}($query, $loopRule, $rule->condition);
            }

        }, $condition);
    }


    protected function checkRuleCorrect(stdClass $rule)
    {
        if (!isset($rule->operator, $rule->id, $rule->field, $rule->type)) {
            return false;
        }

        if (!isset($this->operators[$rule->operator])) {
            return false;
        }

        return true;
    }


    protected function operatorValueWhenNotAcceptingOne(stdClass $rule)
    {
        if ($rule->operator == 'is_empty' || $rule->operator == 'is_not_empty') {
            return '';
        }

        return null;
    }


    protected function getCorrectValue($operator, stdClass $rule, $value)
    {
        $field = $rule->field;
        $sqlOperator = $this->operator_sql[$rule->operator];
        $requireArray = $this->operatorRequiresArray($operator);

        $value = $this->enforceArrayOrString($requireArray, $value, $field);

        /*
        *  Turn datetime into Carbon object so that it works with "between" operators etc.
        */
        if ($rule->type == 'date') {
            $value = $this->convertDatetimeToCarbon($value);
        }

        return $this->appendOperatorIfRequired($requireArray, $value, $sqlOperator);
    }


    protected function makeQuery( $query, stdClass $rule, $queryCondition = 'AND')
    {
        try {
            $value = $this->getValueForQueryFromRule($rule);
        } catch (\Exception $e) {
            return $query;
        }

        return $this->convertIncomingQBtoQuery($query, $rule, $value, $queryCondition);
    }


    protected function convertIncomingQBtoQuery( $query, stdClass $rule, $value, $queryCondition = 'AND')
    {
        /*
         * Convert the Operator (LIKE/NOT LIKE/GREATER THAN) given to us by QueryBuilder
         * into on one that we can use inside the SQL query
         */
        $sqlOperator = $this->operator_sql[$rule->operator];
        $operator = $sqlOperator['operator'];
        $condition = strtolower($queryCondition);


        if ($this->operatorRequiresArray($operator)) {
            return $this->makeQueryWhenArray($query, $rule, $sqlOperator, $value, $condition);
        } elseif ($this->operatorIsNull($operator)) {
            return $this->makeQueryWhenNull($query, $rule, $sqlOperator, $condition);
        }

        return $query->where($rule->field, $sqlOperator['operator'], $value, $condition);
    }


    protected function getValueForQueryFromRule(stdClass $rule)
    {

        $value = ($rule->valueType == 'static') ? $rule->value : $this->{$rule->valueType}[$rule->value];

        if ($this->operators[$rule->operator]['accept_values'] === false) {
            return $this->operatorValueWhenNotAcceptingOne($rule);
        }

        /*
         * Convert the Operator (LIKE/NOT LIKE/GREATER THAN) given to us by QueryBuilder
         * into on one that we can use inside the SQL query
         */
        $sqlOperator = $this->operator_sql[$rule->operator];
        $operator = $sqlOperator['operator'];

        /*
         * \o/ Ensure that the value is an array only if it should be.
         */
        $value = $this->getCorrectValue($operator, $rule, $value);

        return $value;
    }

//    abstract protected function checkRuleCorrect(stdClass $rule);

    protected $operators = array (
        'equal'            => array ('accept_values' => true,  'apply_to' => ['string', 'number', 'datetime']),
        'not_equal'        => array ('accept_values' => true,  'apply_to' => ['string', 'number', 'datetime']),
        'in'               => array ('accept_values' => true,  'apply_to' => ['string', 'number', 'datetime']),
        'not_in'           => array ('accept_values' => true,  'apply_to' => ['string', 'number', 'datetime']),
        'less'             => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'less_or_equal'    => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'greater'          => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'greater_or_equal' => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'between'          => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'not_between'      => array ('accept_values' => true,  'apply_to' => ['number', 'datetime']),
        'begins_with'      => array ('accept_values' => true,  'apply_to' => ['string']),
        'not_begins_with'  => array ('accept_values' => true,  'apply_to' => ['string']),
        'contains'         => array ('accept_values' => true,  'apply_to' => ['string']),
        'not_contains'     => array ('accept_values' => true,  'apply_to' => ['string']),
        'ends_with'        => array ('accept_values' => true,  'apply_to' => ['string']),
        'not_ends_with'    => array ('accept_values' => true,  'apply_to' => ['string']),
        'is_empty'         => array ('accept_values' => false, 'apply_to' => ['string']),
        'is_not_empty'     => array ('accept_values' => false, 'apply_to' => ['string']),
        'is_null'          => array ('accept_values' => false, 'apply_to' => ['string', 'number', 'datetime']),
        'is_not_null'      => array ('accept_values' => false, 'apply_to' => ['string', 'number', 'datetime'])
    );

    protected $operator_sql = array (
        'equal'            => array ('operator' => '='),
        'not_equal'        => array ('operator' => '!='),
        'in'               => array ('operator' => 'IN'),
        'not_in'           => array ('operator' => 'NOT IN'),
        'less'             => array ('operator' => '<'),
        'less_or_equal'    => array ('operator' => '<='),
        'greater'          => array ('operator' => '>'),
        'greater_or_equal' => array ('operator' => '>='),
        'between'          => array ('operator' => 'BETWEEN'),
        'not_between'      => array ('operator' => 'NOT BETWEEN'),
        'begins_with'      => array ('operator' => 'LIKE',     'prepend'  => '%'),
        'not_begins_with'  => array ('operator' => 'NOT LIKE', 'prepend'  => '%'),
        'contains'         => array ('operator' => 'LIKE',     'append'  => '%', 'prepend' => '%'),
        'not_contains'     => array ('operator' => 'NOT LIKE', 'append'  => '%', 'prepend' => '%'),
        'ends_with'        => array ('operator' => 'LIKE',     'append' => '%'),
        'not_ends_with'    => array ('operator' => 'NOT LIKE', 'append' => '%'),
        'is_empty'         => array ('operator' => '='),
        'is_not_empty'     => array ('operator' => '!='),
        'is_null'          => array ('operator' => 'NULL'),
        'is_not_null'      => array ('operator' => 'NOT NULL')
    );

    protected $needs_array = array(
        'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN',
    );

    protected $types = array(
        'static', 'route', 'request',
    );

    protected function operatorRequiresArray($operator)
    {
        return in_array($operator, $this->needs_array);
    }

    protected function operatorIsNull($operator)
    {
        return ($operator == 'NULL' || $operator == 'NOT NULL') ? true : false;
    }

    protected function validateCondition($condition)
    {
        $condition = trim(strtolower($condition));

        if ($condition !== 'and' && $condition !== 'or') {
            throw new QBParseException("Condition can only be one of: 'and', 'or'.");
        }

        return $condition;
    }

    protected function enforceArrayOrString($requireArray, $value, $field)
    {
        $this->checkFieldIsAnArray($requireArray, $value, $field);

        if (!$requireArray && is_array($value)) {
            return $this->convertArrayToFlatValue($field, $value);
        }

        return $value;
    }

    protected function checkFieldIsAnArray($requireArray, $value, $field)
    {
        if ($requireArray && !is_array($value)) {
            throw new QBParseException("Field ($field) should be an array, but it isn't.");
        }
    }

    protected function convertArrayToFlatValue($field, $value)
    {
        if (count($value) !== 1) {
            throw new QBParseException("Field ($field) should not be an array, but it is.");
        }

        return $value[0];
    }

    protected function convertDatetimeToCarbon($value)
    {
        if (is_array($value)) {
            return array_map(function ($v) {
                return new Carbon($v);
            }, $value);
        }

        return new Carbon($value);
    }

    protected function appendOperatorIfRequired($requireArray, $value, $sqlOperator)
    {
        if (!$requireArray) {
            if (isset($sqlOperator['append'])) {
                $value = $sqlOperator['append'].$value;
            }

            if (isset($sqlOperator['prepend'])) {
                $value = $value.$sqlOperator['prepend'];
            }
        }

        return $value;
    }

    protected function makeQueryWhenArray( $query, stdClass $rule, array $sqlOperator, array $value, $condition)
    {
        if ($sqlOperator['operator'] == 'IN' || $sqlOperator['operator'] == 'NOT IN') {
            return $this->makeArrayQueryIn($query, $rule, $sqlOperator['operator'], $value, $condition);
        } elseif ($sqlOperator['operator'] == 'BETWEEN' || $sqlOperator['operator'] == 'NOT BETWEEN') {
            return $this->makeArrayQueryBetween($query, $rule, $sqlOperator['operator'], $value, $condition);
        }

        throw new QBParseException('makeQueryWhenArray could not return a value');
    }

    protected function makeQueryWhenNull( $query, stdClass $rule, array $sqlOperator, $condition)
    {
        if ($sqlOperator['operator'] == 'NULL') {
            return $query->whereNull($rule->field, $condition);
        } elseif ($sqlOperator['operator'] == 'NOT NULL') {
            return $query->whereNotNull($rule->field, $condition);
        }

        throw new QBParseException('makeQueryWhenNull was called on an SQL operator that is not null');
    }

    private function makeArrayQueryIn( $query, stdClass $rule, $operator, array $value, $condition)
    {
        if(count($value) == 0){
            return $query;
        }

        if ($operator == 'NOT IN') {
            return $query->whereNotIn($rule->field, $value, $condition);
        }

        return $query->whereIn($rule->field, $value, $condition);
    }

    private function makeArrayQueryBetween( $query, stdClass $rule, $operator, array $value, $condition)
    {
        if (count($value) !== 2) {
            return $query;
//            throw new QBParseException("{$rule->field} should be an array with only two items.");
        }

        if ( $operator == 'NOT BETWEEN' ) {
            return $query->whereNotBetween( $rule->field, $value, $condition );
        }

        return $query->whereBetween($rule->field, $value, $condition);
    }
}
