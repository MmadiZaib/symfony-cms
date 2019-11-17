<?php


namespace AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseAdminController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_SHOW);
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
        $fields = $this->entity['show']['fields'];

        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            unset($fields['created']);
        }

        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        return $this->render($this->entity['templates']['show'], [
            'entity'      => $entity,
            'fields'      => $fields,
            'delete_form' => $deleteForm->createView(),
        ]);
    }


    public function editAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);
        $id = $this->request->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property')) {
            $newValue = 'true' === strtolower($this->request->query->get('newValue'));

            $fieldsMetadata = $this->entity['list']['fields'];

            if(!isset($fieldsMetada[$property]) || 'toggle' != $fieldsMetadata[$property]['dataType']) {
                throw new \RuntimeException(sprintf('The type of %s property is not "toogle". ', $property));
            }

            $this->updateEntityProperty($entity, $property, $newValue);

            return new Response((string) $newValue);
        }

        $fields = $this->entity['edit']['fields'];

        $editForm = $this->createEditForm($entity, $fields);
        if(!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $editForm->remove('enabled');
            $editForm->remove('roles');
        }

        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $editForm->handleRequest($this->request);
        if ($editForm->isValid()) {
            $this->preUpdateEntity($entity);
            $this->em->flush();

            $refererUrl = $this->request->query->get('referer', '');

            return !empty($refererUrl) ? $this->redirect(urldecode($refererUrl)) : $this->redirect($this->generateUrl('easyadmin', array(
                'action' => 'show',
                'entity' => $this->entity['name'],
                'id'     => $id,
            )));
        }

        return $this->render($this->entity['templates']['edit'], array(
            'form'          => $editForm->createView(),
            'entity_fields' => $fields,
            'entity'        => $entity,
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/dashboard", name="dashboard")
     * @param Request $request
     * @return Response
     */
    public function dashboardAction(Request $request)
    {
        return $this->render("@EasyAdmin/default/dashboard.html.twig");
    }

    public function createNewEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistEntity($user)
    {
        return $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    public function preUpdateEntity($user)
    {
        return $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}