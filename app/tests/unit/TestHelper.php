<?php

use Zizaco\FactoryMuff\FactoryMuff;

/**
 * Class TestHelper contains some helper methods for tests
 */
class TestHelper {

    /**
     * This function uses factory muff to put entries in the DB.
     * @param string $modelName name of model class you'd like to insert
     * @param int $num number of records to seed in DB
     * @param array $fixedAttributes array of associative arrays of attribtues to manually set for DB entries.
     */
    public static function seedDB($modelName, $num, array $fixedAttributes = array()) {
        $factory = new FactoryMuff();
        for ($i = 0; $i < $num; $i++) {
            if (isset($fixedAttributes[$i])) {
                $factory->create($modelName, $fixedAttributes[$i]);
            } else {
                $factory->create($modelName);
            }
        }
    }
}