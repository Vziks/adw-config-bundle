<?php

namespace ADW\ConfigBundle\Entity;

/**
 * Class AllowIp.
 * Project ConfigBundle.
 * @author Anton Prokhorov
 */

class AllowIp
{
    /**
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}