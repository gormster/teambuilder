.mod-teambuilder th {
	text-align:left;
	vertical-align:text-bottom;
	padding-right:10px;
}

.mod-teambuilder form.addNewCriterion input.text,
.mod-teambuilder form.addNewCriterion select {
	width:200px;
}

.mod-teambuilder .description {
	padding:10px;
	border:1px solid black;
	margin:15px 10px;
}

#newQuestionForm {
	background-color:#F9F9F9;
	border:1px solid #999;
	padding:5px;
	margin:auto;
	display:inline-block;
	text-align:left;
}

.question {
	border:1px solid #CCC;
	padding:10px;
	margin:10px;
	background-color:#FFF;
}

.question table {
	border-collapse:collapse;
	width:100%;
}

.question ul {
	margin:0px;
}

.question .handle {
	background-image:url('../../mod/teambuilder/css/handle.png');
	background-position: center center;
	width:23px;
	padding:3px;
	background-repeat: no-repeat;
}

.question .edit {
	text-align:right;
}

.question .edit a {
	cursor:pointer;
}

.question .type {
	font-size:0.9em;
	color:#999;
}

.question .questionText {
	font-weight:bold;
	font-size:1.1em;
}

#savingIndicator {
	color:#F00;
}

.question .response {
	display:inline-block;
	margin-right:5px;
	margin-top:2px;
	margin-bottom:2px;
}

.ui-state-error .type {
	color:#FC0;
	font-weight:bold;
}

.ui-state-error .type strong {
	text-decoration:underline;
}

/* Build Teams page */

#unassigned {
	border:1px solid #CCC;
	background-color:#F9F9F9;
	margin:5px;
	padding:5px;
	position:relative;
}

#unassigned h2 {
	margin:2px;
	margin-left:25px;
}

#unassigned button {
	position:absolute;
	right: 5px;
	top: 5px;
}

.student {
	display:inline-block;
	padding:10px;
	margin:5px;
	cursor:default;
}

.team {
	margin:5px;
	padding:5px;
	border:1px solid #CCC;
	background-color:#F9F9F9;
	display:inline-block;
	vertical-align:top;
}

.team h2 {
	margin:2px;
}

.sortable {
	min-height:20px;
}

.criterionWrapper {
	text-align:center;
	margin:3px 10px;
	display:none;
}

.criterion {
	display:inline-block;
	border:1px solid #CCC;
	margin:auto;
	width:800px;
	padding:5px;
	padding-bottom:16px;
	position:relative;
}

.criterionDelete {
	display:none;
	position:absolute;
	right:-10px;
	top:-10px;
	background-image:url('../../mod/teambuilder/css/close.png');
	background-repeat:no-repeat;
	background-attachment:right top;
	width:24px;
	height:24px;
	cursor:pointer;
}

.criterion ul {
	text-align:left;
	list-style-type:none;
	padding:0px;
	margin:0px 10px 5px;
}

.subcriterionWrapper {
	position:relative;
}

.boolOper { 
	background-image:url('../../mod/teambuilder/css/bool.png');
	background-position: center bottom;
	background-repeat:no-repeat;
	color:#000;
	font-weight:bold;
	font-size:12px;
	cursor:pointer;
	height:18px;
	margin:auto;
	margin-bottom:0px;
	text-align:center;
}

.selected {
	color:#008000;
}

#createGroupsForm {
	border: 1px solid #A00;
	padding:5px;
	background-color: #FEE;
	width:50%;
	margin:5px auto;
}

#createGroupsForm p {
	margin:2px;
	font-size:1.1em;
	font-weight:bold;
}

#createGroupsForm button {
	width:85px;
	font-size:1em;
}

.runningCounter {
	position:absolute;
	right:5px;
	bottom:5px;
	color:#AAA;
	font-weight:bold;
	font-size:1.5em;
}

.studentResponse {
	position:absolute;
	background-image:url('../../mod/teambuilder/css/b75.png');
	border:1px single white;
	padding:10px;
	color:#FFF;
}

.studentResponse table {
	border-collapse:collapse;
}

.studentResponse table td, .studentResponse table th {
	border-top:1px solid white;
	border-bottom:1px solid white;
}

.studentResponse table th {
	vertical-align:middle;
}

.add_sub {
	position:absolute;
	left:0px;
	bottom:0px;
	width:16px;
	height:16px;
	padding:5px;
}

/* Stepper */

.stepper > span {
	border:1px solid #BBB;
	background-color:#EEE;
	width:17px;
}

.stepper > span > span {
	border-width:0px 1px;
	border-color:#CCB;
	border-style:solid;
	padding:0px 5px;
	background-color:#FAFAEE;
}

.ui-stepper-up {
	background-image:url('../../mod/teambuilder/css/up.png');
	background-color:#EEE;
	background-position: center center;
	background-repeat: no-repeat;
	width:17px;
	height:8px;
	cursor:pointer;
	display:inline-block;
}

.ui-stepper-down {
	background-image:url('../../mod/teambuilder/css/down.png');
	background-position: center center;
	background-repeat: no-repeat;
	width:17px;
	height:8px;
	cursor:pointer;
	display:inline-block;
}