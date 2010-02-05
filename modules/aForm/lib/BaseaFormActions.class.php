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
    foreach ($fields as $a_form_field)
    {
      $a_form_field_form = $a_form_field->getForm();
      
      if (count($a_form_field_form) == 1)
      {
        $headers[] = $a_form_field->getLabel();
      }
      else
      {
        foreach ($a_form_field_form as $key => $field)
        {
          $headers[] = $a_form_field->getLabel().': '.$key;
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
  
  public function executeNew(sfWebRequest $request)
  {
    $this->a_form = Doctrine::getTable('aForm')->createQuery()->fetchOne();
    $this->form = new aFormBuilder(array(), array('a_form' => $this->a_form));
    if($request->isMethod('POST'))
    {
      $this->form->bind($request->getParameter('form'));
      if($this->form->isValid())
        $this->form->save();
    }
    $this->setTemplate('edit');
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->a_form = Doctrine::getTable('aForm')->createQuery()->fetchOne();
    $this->a_form_submission = Doctrine::getTable('aFormSubmission')->find($request->getParameter('id'));

    $this->form = new aFormBuilder($this->a_form_submission, array('a_form' => $this->a_form));
    if($request->isMethod('POST'))
    {
      $this->form->bind($request->getParameter('form'));
      if($this->form->isValid())
        $this->form->save();
    }
  }
}
