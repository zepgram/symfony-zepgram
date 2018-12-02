<?php
/**
 * This file is part of App\Entity for code
 *
 * @package    App\Entity
 * @file       Hydrator.php
 * @date       02 12 2018 03:10
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2018 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace App\Entity;

class ContactHydrator
{
    /**
     * @var array
     */
    private $mapping = [
        Contact::ID => 'Id',
        Contact::EMAIL => 'Email',
        Contact::NAME => 'Name',
        Contact::MESSAGE => 'Message'
    ];

    /**
     * Extract data from object
     *
     * @param object $entity
     *
     * @return array
     */
    public function extract($entity)
    {
        $data = [];
        foreach ($this->mapping as $key => $method) {
            if (method_exists($entity, 'get' . $method)) {
                $data[$key] = $entity->{'get' . $this->mapping[$key]}();
            }
        }

        return $data;
    }

    /**
     * Populate entity with data
     *
     * @param object $entity
     * @param array  $data
     *
     * @return object
     */
    public function hydrate($entity, array $data)
    {
        foreach ($this->mapping as $key => $method) {
            if (method_exists($entity, 'set' . $method)) {
                if (array_key_exists($key, $data)) {
                    $entity->{'set' . $this->mapping[$key]}($data[$key]);
                }
            }
        }

        return $entity;
    }
}
