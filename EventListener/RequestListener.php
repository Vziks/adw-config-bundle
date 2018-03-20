<?php

namespace ADW\ConfigBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use ADW\ConfigBundle\Entity\ConfigSite;

/**
 * Class RequestListener.
 * Project ConfigBundle.
 *
 * @author Anton Prokhorov
 */
class RequestListener
{
    /**
     * @var array
     */
    protected $firewallMap;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var string
     */
    private $currentEnv;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * RequestListener constructor.
     *
     * @param $firewallMap
     * @param ContainerInterface    $container
     * @param EntityManager         $em
     * @param \Twig_Environment     $twig
     * @param TokenStorageInterface $tokenStorage
     * @param $currentEnv
     * @param array $configuration
     */
    public function __construct($firewallMap, ContainerInterface $container, EntityManager $em, \Twig_Environment $twig, TokenStorageInterface $tokenStorage, $currentEnv, array $configuration)
    {
        $this->firewallMap = $firewallMap;
        $this->container = $container;
        $this->em = $em;
        $this->twig = $twig;
        $this->tokenStorage = $tokenStorage;
        $this->currentEnv = $currentEnv;
        $this->configuration = $configuration;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if (in_array($this->currentEnv, ['dev', 'test'])) {
            return;
        }

        $request = $event->getRequest();

        $matcher = new RequestMatcher();

        // Get rules
        $rules = isset($this->configuration['rules']) ? $this->configuration['rules'] : [];

        $include = false;

        $currentDate = new \DateTime('now');

        /**
         * @var ConfigSite
         */
        $statusSite = $this->em->getRepository(ConfigSite::class)->createQueryBuilder('c')
            ->where('c.turn_off=:turnOff')
            ->andWhere('c.startAt <= :currentDate')
            ->andWhere('c.stopAt >= :currentDate')
            ->setParameters(
                [
                    'currentDate' => $currentDate->format('Y-m-d H:m:s'),
                    'turnOff' => 1,
                ]
            )
            ->getQuery()
            ->getOneOrNullResult();

        foreach ($this->firewallMap as $firewall => $key) {
            $matcher->matchPath($key);

            foreach ($rules as $rule) {
                if ('-' == $rule['rule'] and $matcher->matches($request) and in_array($firewall, $rule['firewalls'])) {
                    $include = true;
                }
            }
        }

        if (!$include and $statusSite) {
            if (!in_array($request->getClientIp(), $statusSite->getAllowIps())) {
                $response = new Response($this->twig->render('ADWConfigBundle:SplashScreen:index.html.twig', []), 403);

                $event->setResponse($response);
            }
        }
    }
}
