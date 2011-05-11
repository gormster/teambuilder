<?php

$mod_teambuilder_capabilities = array(
	
	//create survey
	'mod/teambuilder:create' => array(
			'captype' => 'write',
			'contextlevel' => CONTEXT_MODULE,
			'legacy' => array(
	            'teacher' => CAP_ALLOW,
	            'editingteacher' => CAP_ALLOW,
	            'admin' => CAP_ALLOW
	        )
		),
	
	//respond to survey
	'mod/teambuilder:respond' => array(
        'riskbitmask' => RISK_SPAM,
        'captype' => 'write',
        'contextlevel' => CONTEXT_MODULE,
        'legacy' => array(
            'student' => CAP_ALLOW
        	)
    	),
	
	//build teams from survey response
	'mod/teambuilder:build' => array(
		'captype' => 'read',
		'contextlevel' => CONTEXT_MODULE,
		'legacy' => array(
			'teacher' => CAP_ALLOW,
			'editingteacher' => CAP_ALLOW,
			'admin' => CAP_ALLOW
			)
		)
	
	);
	
?>