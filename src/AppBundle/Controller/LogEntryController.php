<?php

namespace AppBundle\Controller;

use AppBundle\Entity\LogEntry;
use AppBundle\Entity\Repository\LogEntryRepository;
use AppBundle\Entity\Repository\TaskRepository;
use AppBundle\Entity\Service\LogEntryService;
use AppBundle\Entity\Service\TaskService;
use AppBundle\Form\CompleteLogEntryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Log Entry controller
 *
 * @Route("/log-entry")
 */
class LogEntryController extends Controller
{
    /**
     * Gets TaskRepository
     *
     * @return TaskRepository
     */
    protected function getTaskRepository()
    {
        return $this->get('app.entity.repository.task_repository');
    }

    /**
     * Gets TaskService
     *
     * @return TaskService
     */
    protected function getTaskService()
    {
        return $this->get('app.entity_service.task_service');
    }

    /**
     * Gets LogEntryRepository
     *
     * @return LogEntryRepository
     */
    protected function getLogEntryRepository()
    {
        return $this->get('app.entity.repository.log_entry_repository');
    }

    /**
     * Gets LogEntryService
     *
     * @return LogEntryService
     */
    protected function getLogEntryService()
    {
        return $this->get('app.entity_service.log_entry_service');
    }

    public function indexAction()
    {
        return $this->render('', []);
    }

    public function startAction()
    {
        $user = $this->getUser();
        $logEntry = $this->getLogEntryService()->createLogEntry($user);
        $this->getLogEntryService()->startLogEntry($user, $logEntry);
    }

    public function stopAction()
    {

    }

    /**
     * @Route("/{id}/complete", name="log-entry-complete")
     *
     * @param Request $request
     * @param LogEntry $logEntry
     * @return RedirectResponse|Response
     */
    public function completeFormAction(Request $request, LogEntry $logEntry)
    {
        $completeForm = $this->createForm(CompleteLogEntryType::class, $logEntry);
        $completeForm->handleRequest($request);

        if ($completeForm->isSubmitted() && $completeForm->isValid()) {
             $task = $logEntry->getTask();

            $extraData = $completeForm->getExtraData();
            if ($extraData['finish']) {

                $task->setIsFinished(true);
            }

            $this->getLogEntryRepository()->save($logEntry);
            $this->getTaskRepository()->save($logEntry->getTask());

            return $this->redirectToRoute('homepage');
        }

        return $this->render('log_entry/complete_form.html.twig', [
            'log_entry' => $logEntry,
            'skip_form' => $this->createSkipForm($logEntry)->createView(),
            'complete_form' => $completeForm->createView()
        ]);
    }

    /**
     * Creates a form to skip complete a LogEntry entity.
     *
     * @param LogEntry $logEntry The LogEntry entity
     * @return Form The form
     *
     */
    private function createSkipForm(LogEntry $logEntry)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stop', ['id' => $logEntry->getId()]))
            ->setMethod('POST')
            ->getForm();
    }

    /**
     * Deletes a LogEntry entity.
     *
     * @Route("/{id}", name="log_entry_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param LogEntry $logEntry
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, LogEntry $logEntry)
    {
        $form = $this->createDeleteForm($logEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $logEntry->getTask();
            $task->removeLogEntry($logEntry);
            $this->getTaskRepository()->save($task);
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a LogEntry entity.
     *
     * @param LogEntry $logEntry The LogEntry entity
     *
     * @return Form The form
     */
    private function createDeleteForm(LogEntry $logEntry)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('log_entry_delete', ['id' => $logEntry->getId()]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
