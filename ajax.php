<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = required_param('id', PARAM_INT); // course_module ID
$action = required_param('action', PARAM_TEXT);
$input = required_param('input', PARAM_RAW);
$input = json_decode(stripslashes($input));

$ouput = array();

if (! $cm = get_coursemodule_from_id('teambuilder', $id)) {
	$output['status'] = 'fail';
    $output['message'] = 'Course Module ID was incorrect';
}

if (! $course = get_record('course', 'id', $cm->course)) {
    $output['status'] = 'fail';
    $output['message'] ='Course is misconfigured';
}

if (! $teambuilder = get_record('teambuilder', 'id', $cm->instance)) {
    $output['status'] = 'fail';
    $output['message'] ='Course module is incorrect';
}

//alright

if($output['status']!='fail')
{
	$ctxt = get_context_instance(CONTEXT_MODULE,$cm->id);
	switch($action)
	{
		case "saveQuestionnaire":
		{
			require_capability('mod/teambuilder:create',$ctxt);
			if($teambuilder->open < time())
			{
				$output['status'] = 'fail';
				$output['message'] = 'You cannot update a team builder instance once it has opened.';
				break; 
			}
			$question_ids = array();
			foreach($input as $ord => $q)
			{
				$q->ordinal = $ord;
				if(isset($q->id))
				{
					update_record("teambuilder_question",$q);
				}
				else
				{
					$q->display = 'field';
					$q->builder = $teambuilder->id;
					$q->id = insert_record("teambuilder_question",$q);
				}
				$question_ids[] = $q->id;
		
				//since we didn't keep references, we need to rebuild the answer base every time
				delete_records("teambuilder_answer","question",$q->id);
				foreach($q->answers as $aord => $atext)
				{
					$a = new Object();
					$a->answer = $atext;
					$a->ordinal = $aord;
					$a->question = $q->id;
					insert_record("teambuilder_answer",$a);
				}
			}
			
			//find deleted questions
			foreach(get_records("teambuilder_question","builder",$teambuilder->id) as $k => $v)
			{
				if(!in_array($k,$question_ids))
				{
					delete_records("teambuilder_question","id",$k);
					delete_records("teambuilder_answer","question",$k);
				}
			}
			$output['status'] = 'success';
			$output['message'] = 'input: ' . print_r($input,true);
			$questionnaire = get_records("teambuilder_question","builder",$teambuilder->id,"","id,question,ordinal");
			$output['questionnaire'] = $questionnaire;
		}
		break;
	}
}

echo json_encode($output);

?>