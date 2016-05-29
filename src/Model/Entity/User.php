<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $address
 * @property string $gender
 * @property string $phone
 * @property string $fullname
 * @property string $ip_address
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $role_id
 * @property \App\Model\Entity\Role $role
 */
class User extends Entity {

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password', 'role_id'
    ];

    /**
     * 
     * @param type $datetime
     */
    protected function _getCreated($datetime) {
        if ($datetime) {
            return $datetime->format("Y/m/d H:i:s");
        }
    }

    /**
     * 
     * @param type $datetime
     */
    protected function _getModified($datetime) {
        if ($datetime) {
            return $datetime->format("Y/m/d H:i:s");
        }
    }

}
