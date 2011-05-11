<?php  // $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $

/**
 * This page prints a particular instance of teambuilder
 *
 * @author  Your Name <your@email.address>
 * @version $Id: view.php,v 1.6.2.3 2009/04/17 22:06:25 skodak Exp $
 * @package mod/teambuilder
 */

/// (Replace teambuilder with the name of your module and remove this line)

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

require_js($CFG->wwwroot."/mod/teambuilder/js/jquery.js");
require_js($CFG->wwwroot."/mod/teambuilder/js/jquery.ui.js");
require_js($CFG->wwwroot."/mod/teambuilder/js/json2.js");
require_js($CFG->wwwroot."/mod/teambuilder/js/build.js");

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$a  = optional_param('a', 0, PARAM_INT);  // teambuilder instance ID
$preview = optional_param('preview', 0, PARAM_INT);
$action = optional_param('action', null, PARAM_TEXT);

if ($id) {
    if (! $cm = get_coursemodule_from_id('teambuilder', $id)) {
        error('Course Module ID was incorrect');
    }

    if (! $course = get_record('course', 'id', $cm->course)) {
        error('Course is misconfigured');
    }

    if (! $teambuilder = get_record('teambuilder', 'id', $cm->instance)) {
        error('Course module is incorrect');
    }

} else if ($a) {
    if (! $teambuilder = get_record('teambuilder', 'id', $a)) {
        error('Course module is incorrect');
    }
    if (! $course = get_record('course', 'id', $teambuilder->course)) {
        error('Course is misconfigured');
    }
    if (! $cm = get_coursemodule_from_instance('teambuilder', $teambuilder->id, $course->id)) {
        error('Course Module ID was incorrect');
    }

} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$ctxt = get_context_instance(CONTEXT_MODULE,$cm->id);
require_capability("mod/teambuilder:build",$ctxt);

$strteambuilders = get_string('modulenameplural', 'teambuilder');
$strteambuilder  = get_string('modulename', 'teambuilder');

$navlinks = array();
$navlinks[] = array('name' => $strteambuilders, 'link' => "index.php?id=$course->id", 'type' => 'activity');
$navlinks[] = array('name' => format_string($teambuilder->name), 'link' => '', 'type' => 'activityinstance');

$navigation = build_navigation($navlinks);

print_header_simple(format_string($teambuilder->name), '', $navigation, '', '<link rel="stylesheet" href="css/custom-theme/jquery.ui.css" type="text/css" media="screen" title="no title" charset="utf-8" />', true,
              update_module_button($cm->id, $course->id, $strteambuilder), navmenu($course, $cm));

if(isset($_POST['action']) && ($_POST["action"]=="create-groups"))
{
	
	$groupingName = trim($_POST['groupingName']);
	if (strlen($groupingName) > 0)
		$grouping = groups_create_grouping(array("courseid" => $COURSE->id, "name" => $groupingName));
	else
	{
		$grouping = groups_get_grouping((int)$_POST['groupingID']);
		$groupingName = $grouping->name;
		$grouping = $grouping->id;
	}
	
	foreach($_POST['teams'] as $name => $team)
	{
		$oname = empty($_POST['inheritGroupingName']) ? "$groupingName $name" : $name;
		$groupdata = array(
			"courseid" => $COURSE->id,
			"name" => $oname
		);
		$group = groups_create_group($groupdata);
		foreach($team as $user)
		{
			groups_add_member($group,$user);
		}
		groups_assign_grouping($grouping,$group);
	}
	
	$feedback = "Your groups were successfully created.";
}
else
{
	if($teambuilder->groupid)
		$group = $teambuilder->groupid;
	else
		$group = '';
	$students = get_users_by_capability($ctxt,'mod/teambuilder:respond','id,firstname,lastname','','','',$group,'',false);
	$responses = teambuilder_get_responses($teambuilder->id);
	$questions = teambuilder_get_questions($teambuilder->id);

	echo '<script type="text/javascript">';
	echo 'var students = ' . json_encode($students) . ';';
	echo 'var responses = ' . json_encode($responses) . ';';
	echo 'var questions = ' . json_encode($questions) . ';';
	echo '</script>';
}

$tabs = array();
$tabs[] = new tabobject("questionnaire","view.php?f=1&id=$id",get_string('questionnaire','teambuilder'));
$tabs[] = new tabobject("preview","view.php?id=$id&preview=1",get_string('preview','teambuilder'));
$tabs[] = new tabobject("build","build.php?id=$id",get_string('buildteams','teambuilder'));
print_tabs(array($tabs), "build");

if(!empty($feedback)):
	echo '<div class="ui-widget" style="text-align:center;"><div style="display:inline-block; padding-left:10px; padding-right:10px;" class="ui-state-highlight ui-corner-all"><p>'.$feedback.'</p></div></div>';
else:

echo <<<HTML
<div id="predicate">
</div>
<div style="text-align:center;margin:10px;"><button type="button" onclick="addNewCriterion();">Add New Criterion</button>&nbsp;<button type="button" onclick="buildTeams();"><strong>Build Teams</strong></button>&nbsp;<button type="button" onclick="resetTeams();">Reset Teams</button></div>
<div style="text-align:center;margin:10px;">Number of teams: <span class="stepper">2</span></div>
<div id="unassigned"><h2>Unassigned to teams</h2><button type="button" onclick="assignRandomly();">Assign Randomly</button><div class="sortable">
HTML;

foreach($students as $s)
{
	echo "<div id=\"student-$s->id\" class=\"student ui-state-default\">$s->firstname&nbsp;$s->lastname</div>";
}

$groupings = "";
foreach(groups_get_all_groupings($COURSE->id) as $grping)
{
	$groupings .= "<option value=\"$grping->id\">$grping->name</option>";
}

echo <<<HTML
</div></div><div id="teams"></div>
<div style="text-align:center;margin:15px 50px 0px;border-top:1px solid black;padding-top:15px;">
	<button type="button" onclick="$('#createGroupsForm').slideDown(300);" style="font-size:1.5em;font-weight:bold;">Create Groups</button>
	<div style="display:none" id="createGroupsForm"><p>Are you sure you want to create your groups now? This action cannot be undone.</p>
		<table style="margin:auto;">
			<tr><th scope="row"><label for="groupingName">Grouping Name</label></th><td><input type="text" id="groupingName"></td></tr>
			<tr><td colspan="2" style="text-align:center;font-size:0.8em">or...</td></tr>
			<tr><th scope="row"><label for="groupingSelect">Add To Grouping</label></th><td><select id="groupingSelect">$groupings</select></td></tr>
			<tr><th scope="row"><label for="inheritGroupingName">Prefix Team Names with Grouping Name</label></th><td style="text-align:left;"><input type="checkbox" checked="checked" name="inheritGroupingName" id="inheritGroupingName" value="1" /></td></tr>
		</table>
		<button type="button" onclick="$('#createGroupsForm').slideUp(300);">Cancel</button>&nbsp;<button type="button" onclick="createGroups();">OK</button>
	</div>
</div>
<div id="debug"></div>
HTML;

endif; //if($feedback)

print_footer($course);
