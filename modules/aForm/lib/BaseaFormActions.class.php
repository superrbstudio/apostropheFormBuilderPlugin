<?php

/**
 * Base actions for the apostropheFormBuilderPlugin aForm module.
 * 
 * @package     apostropheFormBuilderPlugin
 * @subpackage  aForm
 * @author      Alex Gilbert
 * @version     SVN: $Id: BaseActions.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
abstract class BaseaFormActions extends sfActions
{
  public function executeExport(sfRequest $request)
  {
    $a_form = Doctrine::getTable('aForm')->find($request->getParameter('id'));

    $out = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

    $fields = $a_form->getAllFieldsByRank();
    // generate headers
    $headers = array();
    foreach ($fields as $a_form_layout)
    {
      $a_form_layout_form = $a_form_layout->getForm();
      
      if (count($a_form_layout_form) == 1)
      {
        $headers[] = $a_form_layout->getLabel();
      }
      else
      {
        foreach ($a_form_layout_form as $key => $field)
        {
          $headers[] = $a_form_layout->getLabel().': '.$key;
        }
      }
    }
    $headers[] = 'Timestamp';
    $headers[] = 'IP Address';
    fputcsv($out, $headers);
    
    foreach ($a_form->getpkFormSubmissions() as $submission)
    {
      $row = array();
      foreach ($submission->getpkFormFieldSubmissions() as $fieldSubmission)
      {
        $row[] = $fieldSubmission->getValue();
      }
      $row[] = $submission->getCreatedAt();
      $row[] = $submission->getIpAddress();
      fputcsv($out, $row);
    }

    rewind($out);

    $this->getResponse()->setContentType('text/plain');
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename='.urlencode($a_form->getName()).'.csv');

    $this->csv = stream_get_contents($out);
  }
  
  public function executeEdit(sfRequest $request)
  {
    if($request->isXmlHttpRequest())
    {
      $this->setLayout(false);
    }
    
    $this->aForm = $this->getObject();
    $this->aFormForm = new aFormForm($this->aForm);
  }
  
  public function executeEditLayout(sfRequest $request)
  {
    $this->a_form_layout = Doctrine::getTable('aFormLayout')->find($request->getParameter('layout_id'));
    
    $this->form = new aFormLayoutForm($this->a_form_layout);

    return $this->renderPartial('aForm/aFormLayoutForm', array('a_form_layout' => $this->a_form_layout, 'a_form_layout_form' => $this->form));
  }
  
  
  public function executeShow(sfWebRequest $request)
  {
    $this->a_form = $this->getObject();
  }
  
  public function executeAddLayout(sfWebRequest $request)
  {
    $aForm = $this->getObject();
    
    $aFormLayoutForm = new aFormLayoutForm();
    
    $aFormLayoutForm->bind($request->getParameter($aFormLayoutForm->getName()));
    if($aFormLayoutForm->isValid())
    {
      $aFormLayoutForm->save();
    }
    
    return $this->renderComponent('aForm', 'aFormEdit', array('a_form' => $this->a_form, 'a_form_layout_form' => $this->form));
  }
  

  /**
   * getObject 
   * helper method to retrieve a form object from the routing class and check if
   * the user has permission to access the object.
   * @return 
   */
  public function getObject()
  {
    $object = $this->getRoute()->getObject();
    if(true)
      return $object;
    else
      $this->forward404(); 
  }
  
  
  
}
