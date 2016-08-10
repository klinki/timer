<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\LogEntryRepository;
use AppBundle\Entity\Service\LogEntryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 *
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class DefaultController extends BaseController
{
    /** @var  LogEntryService */
    protected $logEntryService;

    public function getLogEntryService()
    {
        return $this->get('app.entity_service.log_entry_service');
    }

    /**
     * @return LogEntryRepository
     */
    public function getLogEntryRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('AppBundle:LogEntry');
    }

    /**
     * @Route("/", name="homepage")
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     *
     * @return Response
     */
    public function indexAction()
    {
        $repository = $this->getLogEntryRepository();
        $logEntries = $repository->getNonCompletedLogEntriesByUser($this->getUser());
        $hasActiveTask = !empty($logEntries);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'hasActiveTask' => $hasActiveTask,
            'activeTask' => $hasActiveTask ? $logEntries[0] : null,
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/start", name="start", methods={"POST"})
     * @return RedirectResponse
     */
    public function startAction()
    {
        $logEntry = $this->getLogEntryService()->createLogEntry($this->getUser());
        $this->getLogEntryService()->startLogEntry($this->getUser(), $logEntry);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/stop", name="stop", methods={"POST"})
     * @return RedirectResponse
     */
    public function stopAction()
    {
        $logEntries = $this->getLogEntryRepository()->getNonCompletedLogEntriesByUser($this->getUser());

        foreach ($logEntries as $logEntry) {
            $this->getLogEntryService()->stopLogEntry($this->getUser(), $logEntry);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Method(methods={"POST"})
     * @return RedirectResponse
     */
    public function formAction()
    {
        $logEntries = $this->getLogEntryRepository()->getNonCompletedLogEntriesByUser($this->getUser());

        foreach ($logEntries as $logEntry) {
            $this->getLogEntryService()->stopLogEntry($this->getUser(), $logEntry);
        }

        return $this->redirectToRoute('homepage');
    }
}
