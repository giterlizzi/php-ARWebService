<?php

namespace giterlizzi\ARWebService;

/**
 * ARWebService: Qualifier
 *
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2013-2022, Giuseppe Di Terlizzi
 */
class Qualifier
{

    public function __construct()
    {}

    public static function andx($predicates)
    {
        return array('AND' => func_get_args());
    }

    public static function orx($predicates)
    {
        return array('OR' => $predicates);
    }

    public static function eq($field, $value)
    {
        return array($field, '=', $value);
    }

    public static function ne($field, $value)
    {
        return array($field, '!=', $value);
    }

    public static function gt($field, $value)
    {
        return array($field, '>', $value);
    }

    public static function lt($field, $value)
    {
        return array($field, '<', $value);
    }

    public static function ge($field, $value)
    {
        return array($field, '>=', $value);
    }

    public static function le($field, $value)
    {
        return array($field, '<=', $value);
    }

    public static function like($field, $value)
    {
        return array($field, 'LIKE', $value);
    }

    public static function isNull($field, $value)
    {
        return array($field, '=', '$NULL$');
    }

    public static function notNull($field, $value)
    {
        return array($field, '!=', '$NULL$');
    }

    public static function parse($qualifier)
    {

        $qualification = '';

        foreach (func_get_args() as $items) {
            foreach ($items as $logic => $item) {
                foreach ($item as $predicates) {
                    list($field, $operator, $value) = $predicates;
                    $qualification .= sprintf("%s (%s %s %s) ",
                        $logic, (is_int($field) ? $field : "'$field'"),
                        $operator, (is_int($value) ? $value : "\"$value\""));
                }
            }
        }

        return trim(preg_replace('/^(AND|OR)/', '', $qualification));

    }

}
