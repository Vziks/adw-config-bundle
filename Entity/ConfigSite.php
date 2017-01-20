<?php


namespace ADW\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ConfigSite.
 * Project ConfigBundle.
 * @author Anton Prokhorov
 *
 * @ORM\Entity()
 * @ORM\Table(name="adw_config_site")
 */
class ConfigSite
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;


    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $turn_off = false;

    /**
     * @var array
     * @ORM\Column(name="allowips", type="array", nullable=true)
     *
     */
    protected $allowips;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_at", type="datetime")
     */
    private $startAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stop_at", type="datetime")
     */
    private $stopAt;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ConfigSite
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ConfigSite
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTurnOff()
    {
        return $this->turn_off;
    }

    /**
     * @param mixed $turn_off
     * @return ConfigSite
     */
    public function setTurnOff($turn_off)
    {
        $this->turn_off = $turn_off;
        return $this;
    }


    /**
     * @param AllowIp $allowip
     * @return $this
     */
    public function addAllowIp(AllowIp $allowip)
    {
        $this->allowips[] = $allowip;

        return $this;
    }

    /**
     * @param $allowip
     * @return $this
     */
    public function removeAllowIp($allowip)
    {
        if (false !== $key = array_search($allowip, $this->allowips, true)) {
            unset($this->allowips[$key]);
            $this->events = array_values($this->allowips);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAllowIps()
    {
        return $this->allowips;
    }

    /**
     * @param $allowips
     */
    public function setAllowIps($allowips)
    {
        if (!empty($allowips) && $allowips === $this->allowips) {
            reset($allowips);
            $key = key($allowips);
            $allowips[$key] = clone $allowips[$key];
        }
        $this->allowips = $allowips;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param \DateTime $startAt
     * @return ConfigSite
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStopAt()
    {
        return $this->stopAt;
    }

    /**
     * @param \DateTime $stopAt
     * @return ConfigSite
     */
    public function setStopAt($stopAt)
    {
        $this->stopAt = $stopAt;
        return $this;
    }


}