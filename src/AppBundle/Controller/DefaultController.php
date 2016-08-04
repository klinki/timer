<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Repository\LogEntryRepository;
use AppBundle\Entity\Service\LogEntryService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
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
     * @Route("/start", name="start")
     * @param Request $request
     * @return RedirectResponse|NotFoundHttpException
     */
    public function startAction(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return $this->createNotFoundException('Expecting post');
        }

        $logEntry = $this->getLogEntryService()->createLogEntry($this->getUser());
        $this->getLogEntryService()->startLogEntry($this->getUser(), $logEntry);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/stop", name="stop")
     * @param Request $request
     * @return RedirectResponse|NotFoundHttpException
     */
    public function stopAction(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return $this->createNotFoundException('Expecting post');
        }

        $logEntries = $this->getLogEntryRepository()->getNonCompletedLogEntriesByUser($this->getUser());

        foreach ($logEntries as $logEntry) {
            $this->getLogEntryService()->stopLogEntry($this->getUser(), $logEntry);
        }

        return $this->redirectToRoute('homepage');
    }

    public function formAction(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return $this->createNotFoundException('Expecting post');
        }

        $logEntries = $this->getLogEntryRepository()->getNonCompletedLogEntriesByUser($this->getUser());

        foreach ($logEntries as $logEntry) {
            $this->getLogEntryService()->stopLogEntry($this->getUser(), $logEntry);
        }

        return $this->redirectToRoute('homepage');
    }
}
