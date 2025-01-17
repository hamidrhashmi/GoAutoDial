<?php
# vdc_db_query.php
# 
# Copyright (C) 2018  Matt Florell <vicidial@gmail.com>    LICENSE: AGPLv2
#
# This script is designed to exchange information between vicidial.php and the database server for various actions
# 
# required variables:
#  - $server_ip
#  - $session_name
#  - $user
#  - $pass
# optional variables:
#  - $format - ('text','debug')
#  - $ACTION - ('regCLOSER','regTERRITORY','manDiaLnextCALL','manDiaLskip','manDiaLonly','manDiaLlookCaLL','manDiaLlogCALL','userLOGout','updateDISPO','updateLEAD','VDADpause','VDADready','VDADcheckINCOMING','UpdatEFavoritEs','CalLBacKLisT','CalLBacKCounT','PauseCodeSubmit','LogiNCamPaigns','alt_phone_change','AlertControl','AGENTSview','CALLSINQUEUEview','CALLSINQUEUEgrab','DiaLableLeaDsCounT','UpdateFields','CALLLOGview','LEADINFOview','customer_3way_hangup_process')
#  - $stage - ('start','finish','lookup','new')
#  - $closer_choice - ('CL_TESTCAMP_L CL_OUT123_L -')
#  - $conf_exten - ('8600011',...)
#  - $exten - ('123test',...)
#  - $ext_context - ('default','demo',...)
#  - $ext_priority - ('1','2',...)
#  - $campaign - ('testcamp',...)
#  - $dial_timeout - ('60','26',...)
#  - $dial_prefix - ('9','8',...)
#  - $campaign_cid - ('3125551212','0000000000',...)
#  - $MDnextCID - ('M06301413000000002',...)
#  - $uniqueid - ('1120232758.2406800',...)
#  - $lead_id - ('36524',...)
#  - $list_id - ('101','123456',...)
#  - $length_in_sec - ('12',...)
#  - $phone_code - ('1',...)
#  - $phone_number - ('3125551212',...)
#  - $channel - ('Zap/12-1',...)
#  - $start_epoch - ('1120236911',...)
#  - $vendor_lead_code - ('1234test',...)
#  - $title - ('Mr.',...)
#  - $first_name - ('Bob',...)
#  - $middle_initial - ('L',...)
#  - $last_name - ('Wilson',...)
#  - $address1 - ('1324 Main St.',...)
#  - $address2 - ('Apt. 12',...)
#  - $address3 - ('co Robert Wilson',...)
#  - $city - ('Chicago',...)
#  - $state - ('IL',...)
#  - $province - ('NA',...)
#  - $postal_code - ('60054',...)
#  - $country_code - ('USA',...)
#  - $gender - ('M',...)
#  - $date_of_birth - ('1970-01-01',...)
#  - $alt_phone - ('3125551213',...)
#  - $email - ('bob@bob.com',...)
#  - $security_phrase - ('Hello',...)
#  - $comments - ('Good Customer',...)
#  - $auto_dial_level - ('0','1','1.2',...)
#  - $VDstop_rec_after_each_call - ('0','1')
#  - $conf_silent_prefix - ('7','8','5',...)
#  - $extension - ('123','user123','25-1',...)
#  - $protocol - ('Zap','SIP','IAX2',...)
#  - $user_abb - ('1234','6666',...)
#  - $preview - ('YES','NO',...)
#  - $called_count - ('0','1','2',...)
#  - $agent_log_id - ('123456',...)
#  - $agent_log - ('NO',...)
#  - $favorites_list - (",'cc160','cc100'",...)
#  - $CallBackDatETimE - ('2006-04-21 14:30:00',...)
#  - $recipient - ('ANYONE,'USERONLY')
#  - $callback_id - ('12345','12346',...)
#  - $use_internal_dnc - ('Y','N')
#  - $use_campaign_dnc - ('Y','N')
#  - $omit_phone_code - ('Y','N')
#  - $no_delete_sessions - ('0','1')
#  - $LogouTKicKAlL - ('0','1');
#  - $closer_blended = ('0','1');
#  - $inOUT = ('IN','OUT');
#  - $manual_dial_filter = ('NONE','CAMPLISTS','DNC','CAMPLISTS_DNC')
#  - $agentchannel = ('Zap/1-1','SIP/testing-6ry4i3',...)
#  - $conf_dialed = ('0','1')
#  - $leaving_threeway = ('0','1')
#  - $blind_transfer = ('0','1')
#  - $usegroupalias - ('0','1')
#  - $account - ('DEFAULT',...)
#  - $agent_dialed_number - ('1','')
#  - $agent_dialed_type - ('MANUAL_OVERRIDE','MANUAL_DIALNOW','MANUAL_PREVIEW',...)
#  - $wrapup - ('WRAPUP','')
#  - $vtiger_callback_id - ('16534'...)
#  - $nodeletevdac - ('0','1')
#  - $agent_territories - ('ABC001','ABC002'...)
#  - $alt_num_status - ('0','1')
#  - $DiaL_SecondS - ('0','1','2',...)
#  - $date - ('2010-02-19')
#  - $custom_field_names - ('|start_date|finish_date|favorite_color|')
#  - $call_notes
#  - $disable_alter_custphone = ('N','Y','HIDE')
#  - $old_CID = ('M06301413000000002',...)
#  - $qm_dispo_code
#  - $dial_ingroup
#  - $nocall_dial_flag
#  - $cid_lock = ('0','1')
#  - $pause_trigger = ('','PAUSE')
#
#
# CHANGELOG:
# 50629-1044 - First build of script
# 50630-1422 - Added manual dial action and MD channel lookup
# 50701-1451 - Added dial log for start and end of vicidial calls
# 50705-1239 - Added call disposition update
# 50804-1627 - Fixed updateDispo to update vicidial_log entry
# 50816-1605 - Added VDADpause/ready for auto dialing
# 50816-1811 - Added basic autodial call pickup functions
# 50817-1005 - Altered logging functions to accomodate auto_dialing
# 50818-1305 - Added stop-all-recordings-after-each-vicidial-call option
# 50818-1411 - Added hangup of agent phone after Logout
# 50901-1315 - Fixed CLOSER IN-GROUP Web Form bug
# 50902-1507 - Fixed CLOSER log length_in_sec bug
# 50902-1730 - Added functions for manual preview dialing and revert
# 50913-1214 - Added agent random update to leadupdate
# 51020-1421 - Added agent_log_id framework for detailed agent activity logging
# 51021-1717 - Allows for multi-line comments (changes \n to !N in database)
# 51111-1046 - Added vicidial_agent_log lead_id earlier for manual dial
# 51121-1445 - Altered echo statements for several small PHP speed optimizations
# 51122-1328 - Fixed UserLogout issue not removing conference reservation
# 51129-1012 - Added ability to accept calls from other VICIDIAL servers
# 51129-1729 - Changed manual dial to use the '/n' flag for calls
# 51221-1154 - Added SCRIPT id lookup and sending to vicidial.php for display
# 60105-1059 - Added Updating of astguiclient favorites in the DB
# 60208-1617 - Added dtmf buttons output per call
# 60213-1521 - Added closer_campaigns update to vicidial_users
# 60215-1036 - Added Callback date-time entry into vicidial_callbacks table
# 60413-1541 - Added USERONLY Callback listings output - CalLBacKLisT
#            - Added USERONLY Callback count output - CalLBacKCounT
# 60414-1140 - Added Callback lead lookup for manual dialing
# 60419-1517 - After CALLBK is sent to agent, update callback record to INACTIVE
# 60421-1419 - Check GET/POST vars lines with isset to not trigger PHP NOTICES
# 60427-1236 - Fixed closer_choice error for CLOSER campaigns
# 60609-1148 - Added ability to check for manual dial numbers in DNC
# 60619-1117 - Added variable filters to close security holes for login form
# 60623-1414 - Fixed variable filter for phone_code and fixed manual dial logic
# 60821-1600 - Added ability to omit the phone code on vicidial lead dialing
# 60821-1647 - Added ability to not delete sessions at logout
# 60906-1124 - Added lookup and sending of callback data for CALLBK calls
# 61128-2229 - Added vicidial_live_agents and vicidial_auto_calls manual dial entries
# 70111-1600 - Added ability to use BLEND/INBND/*_C/*_B/*_I as closer campaigns
# 70115-1733 - Added alt_dial functionality in auto-dial modes
# 70118-1501 - Added user_group to vicidial_log,_agent_log,_closer_log,_callbacks
# 70123-1357 - Fixed bug that would not update vicidial_closer_log status to dispo
# 70202-1438 - Added pause code submit function
# 70203-0930 - Added dialed_number to lead info output
# 70203-1030 - Added dialed_label to lead info output
# 70206-1126 - Added INBOUND status for inbound/closer calls in vicidial_live_agents
# 70212-1253 - Fixed small issue with CXFER
# 70213-1431 - Added QueueMetrics PAUSE/UNPAUSE/AGENTLOGIN/AGENTLOGOFF actions
# 70214-1231 - Added queuemetrics_log_id field for server_id in queue_log
# 70215-1210 - Added queuemetrics COMPLETEAGENT action
# 70216-1051 - Fixed double call complete queuemetrics logging
# 70222-1616 - Changed queue_log PAUSE/UNPAUSE to PAUSEALL/UNPAUSEALL
# 70309-1034 - Allow amphersands and questions marks in comments to pass through
# 70313-1052 - Allow pound signs(hash) in comments to pass through
# 70319-1544 - Added agent disable update customer data function
# 70322-1545 - Added sipsak display ability
# 70413-1253 - Fixed bug for outbound call time in CLOSER-type blended campaigns
# 70424-1100 - Fixed bug for fronter/closer calls that would delete vdac records
# 70802-1729 - Fixed bugs with pause_sec and wait_sec under certain call handling 
# 70828-1443 - Added source_id to output of SCRIPTtab-IFRAME and WEBFORM
# 71029-1855 - removed campaign_id naming restrictions for CLOSER-type campaigns
# 71030-2047 - added hopper priority for auto alt dial entries
# 71116-1011 - added calls_today count updating of the vicidial_live_agents upon INCALL
# 71120-1520 - added LogiNCamPaigns to show only allowed campaigns for agents upon login
# 71125-1751 - Added inbound-group default inbound group sending to vicidial.php
# 71129-2025 - restricted callbacks count and list to campaign only
# 71223-0318 - changed logging of closer calls
# 71226-1117 - added option to kick all calls from conference upon logout
# 80116-1032 - added user_closer_log logging in regCLOSER
# 80125-1213 - fixed vicidial_log bug when call is from closer
# 80317-2051 - Added in-group recording settings
# 80402-0121 - Fixes for manual dial transfers on some systems, removed /n persist flag
# 80424-0442 - Added non_latin lookup from system_settings
# 80430-1006 - Added term_reason for vicidial_log and vicidial_closer_log
# 80430-1957 - Changed to leave lead_id in vicidial_live_agents record until after dispo
# 80630-2153 - Added queue_log logging for Manual dial calls
# 80703-0139 - Added alter customer phone permissions
# 80707-2325 - Added vicidial_id to recording_log for tracking of vicidial or closer log to recording
# 80713-0624 - Added vicidial_list.last_local_call_time field
# 80717-1604 - Modified logging function to use inOUT to determine call direction and place to log
# 80719-1147 - Changed recording conf prefix
# 80815-1019 - Added manual dial list restriction option
# 80831-0545 - Added extended alt dial number info display support
# 80909-1710 - Added support for campaign-specific DNC lists
# 81010-1048 - Added support for hangup of all channels except for agent channel after attempting a 3way call
# 81011-1404 - Fixed bugs in leave3way when transferring a manual dial call
# 81020-1459 - Fixed bugs in queue_log logging
# 81104-0134 - Added mysql error logging capability
# 81104-1617 - Added multi-retry for some vicidial_live_agents table MySQL queries
# 81106-0410 - Added force_timeclock_login option to LoginCampaigns function
# 81107-0424 - Added carryover of script and presets for in-group calls from campaign settings
# 81110-0058 - Changed Pause time to start new vicidial_agent_log on every pause
# 81110-1512 - Added hangup_all_non_reserved to fix non-Hangup bug
# 81111-1630 - Added another hangup fix for non-hangup
# 81114-0126 - More vicidial_agent_log bug fixes
# 81119-1809 - webform backslash fix
# 81124-2212 - Fixes blind transfer bug
# 81126-1522 - Fixed callback comments bug
# 81211-0420 - Fixed Manual dial agent_log bug
# 90120-1718 - Added external pause and dial option
# 90126-1759 - Fixed QM section that wasn't qualified and added agent alert option
# 90128-0231 - Added vendor_lead_code to manual dial lead lookup
# 90304-1335 - Added support for group aliases and agent-specific variables for campaigns and in-groups
# 90305-1041 - Added agent_dialed_number and type for user_call_log feature
# 90307-1735 - Added Shift enforcement and manager override features
# 90320-0306 - Fixed agent log bug when using wrapup time
# 90323-2013 - Added function to put phone numbers in the DNC lists if they were set to status type dnc=Y
# 90324-1316 - Added functions to log calls to Vtiger accounts and update status to siccode
# 90327-1348 - Changed Vtiger status populate to use status name
# 90408-0021 - Added API vtiger specific callback activity record ability
# 90508-0726 - Changed to PHP long tags
# 90511-0923 - Added agentonly_callback_campaign_lock option
# 90519-0634 - Fixed manual dial status and logging bug
# 90611-1423 - Fixed agent log and vicidial log bugs
# 90705-2008 - Added AGENTSview function
# 90706-1431 - Added Agent view transfer selection
# 90712-2303 - Added view calls in queue, grab call from queue
# 90717-0638 - Fixed alt dial on overflow in-group calls
# 90722-1542 - Added no hopper dialing
# 90729-0637 - Added DiaLableLeaDsCounT
# 90808-0221 - Added last_state_change to vicidial_live_agents
# 90904-1622 - Added timezone sort options for no hopper dialing
# 90908-1037 - Added DEAD call logging
# 90916-1839 - Added nodeletevdac
# 90917-2246 - Fixed auto-alt-dial DNC check bug
# 90924-1544 - Added List callerid override option
# 90930-1638 - Added agent_territories feature
# 91012-0535 - Fixed User territory no-hopper dial bug
# 91019-1224 - Fixed auto-alt-dial DNC issues
# 91026-1101 - Added AREACODE DNC option
# 91108-2120 - Fixed QM log issue with PAUSEREASON entries
# 91112-1107 - Changed ENTERQUEUE to CALLOUTBOUND for QM logging
# 91123-1801 - Added outbound_autodial field
# 91204-1937 - Added logging of agent grab calls
# 91213-0946 - Added queue_position to queue_log COMPLETE... records
# 91228-1340 - Added API fields update functions
# 100103-1254 - Added 3 more conf-presets, list ID override presets and call start/dispo URLs
# 100104-1509 - Fixed vicidial_log duplicate check to allow update if dup and logging update
# 100109-0745 - Added alt_num_status for ALTNUM dialing status
# 100109-1336 - Fixed Manual dial live call detection
# 100113-1949 - Fixed dispo_choice bug and added dispo_status to dispo URL call
# 100122-0757 - Added NOT-LOGGED-IN-AGENTS option for sidebar view and transfer view
# 100202-2305 - Fixed logging issues related to INBOUND_MAN dial_method
# 100207-1104 - Changed Pause Codes function to allow for multiple pause codes per pause period
# 100219-1437 - Added agent_dispo_log file option
# 100220-1041 - Added CALLLOGview and LEADINFOview functions
# 100221-1105 - Added custom CID use compatibility
# 100301-1342 - Changed Available agents output for AGENTDIRECT selection
# 100309-0535 - Added queuemetrics_loginout option
# 100311-1559 - Added callcard logging to startcallurl and dispourl functions
# 100331-1217 - Added human-readable hangup codes for manual dial
# 100405-1430 - Added queuemetrics_callstatus option
# 100413-1341 - Fixes for extended alt-dial
# 100420-1006 - Added option for LIVE-only callback count
# 100424-1630 - Added uniqueid display options
# 100622-2217 - Added field labels
# 100624-1401 - Fix for dispo call url bug related to dialed number and label
# 100625-0915 - Fix for auto-dial bug for presets and timer actions
# 100712-1447 - Added entry_list_id field to vicidial_list to preserve link to custom fields if any
# 100803-0822 - Added CAMPLISTS_ALL for manual_dial_filter(issue #369)
# 100823-1612 - Added DID variables on inbound calls
# 100902-1348 - Added closecallid and xfercallid variables
# 100903-0041 - Changed lead_id max length to 10 digits
# 100908-1102 - Added customer_3way_hangup_process function
# 100916-2144 - Added custom list names export with lead data
# 100927-1618 - Added ability to use custom fields in web form and dispo_call_url
# 101001-1451 - Added full name display to Call Log functionality
# 101022-1243 - Fixed missing variables from start and dispo call urls
# 101108-0115 - Added ADDMEMBER option for queue_log
# 101111-1556 - Added source to vicidial_hopper inserts
# 101124-1033 - Added require for functions.php and manual dial call time check campaign option
# 101128-0108 - Added list override for webforms
# 101208-0414 - Fixed Call Log dial bug (issue 393)
# 110103-1343 - Added queuemetrics_loginout NONE option
# 110124-1134 - Small query fix for large queue_log tables
# 110124-1456 - Fixed AREACODE DNC manual dial bug
# 110212-2103 - Added support for custom scheduled callback statuses
# 110214-2320 - Added support for lead_order_secondary option
# 110215-1125 - Added support for call_notes
# 110218-1519 - Added support for agent lead search
# 110222-2228 - Added owner restriction to agent lead search
# 110224-1712 - Added compatibility with QM phone environment logging and QM pause code last call logging
# 110225-1237 - Added scheduled callback lead info display to the lead info view function
# 110303-1616 - Added vicidial_log_extended logging for manual dial calls
# 110304-1207 - Changed lead search with territory restriction to work with agents that cannot select territories
# 110310-0546 - Added ability to set a pause code at the same time of a pause
# 110310-1628 - removed callslogview, extended lead info function to be used instead
# 110317-0222 - Logging bug fixes
# 110413-1245 - Added ALT dialing from scheduled callback list
# 110430-1925 - Added post_phone_time_diff_alert campaign feature
# 110625-0814 - Added screen_labels and label hide functions
# 110626-0127 - Added queuemetrics_pe_phone_append
# 110718-1158 - Added logging of skipped leads
# 110723-2256 - Added disable_alter_custphone HIDE option for call logs display
# 110731-2318 - Added dispo/start call url logging to DB table
# 110901-1117 - Added areacode custom cid function
# 111006-1425 - Added call_count_limit campaign option
# 111015-2104 - Added SEARCHCONTACTSRESULTSview function
# 111018-1529 - Added more fields to contact search
# 111021-1549 - Added old_CID variable to help clear alt-dial-old calls
# 111021-1707 - Added callback_hours_block feature
# 111024-1238 - Added callback_list_calltime option
# 111114-0035 - Added qm-dispo-code field to updatedispo function
# 111201-1443 - Added group_grade option
# 120104-2031 - Fixed missing fullname variable before dispo and start URLs
# 120213-1700 - Added vendor_lead_code to all vicidial_hopper inserts
# 120221-2125 - Manual dials update lastcalldate, and other small changes
# 120427-1717 - Fixed 3-way logging issue
# 120513-0045 - Added Dial In-group and No-Dial compatibility
# 120514-0934 - Added Dial In-group cid-override
# 120619-0616 - Corrected xfer_log logging of manual preview dialed calls
# 120731-1205 - Small fix for vendor_lead_code population on new lead during manual dial
# 120831-1438 - Added vicidial_dial_log logging of outbound phone calls
# 121018-2320 - Added blank option to owner only dialing
# 121029-0159 - Added owner_populate campaign option
# 121114-1749 - Fixed manual dial lead preview script variable issue
# 121116-1409 - Added QC functionality
# 121120-0838 - Added QM socket-send functionality
# 121124-2357 - Added Other Campaign DNC option
# 121130-0740 - Added call notes option to dispo call url
# 121205-1620 - Added parentheses around filter SQL when in SQL queries
# 121206-0635 - Added inbound lead search feature
# 121214-2208 - Added inbound email features
# 121223-1627 - Fixed issue with manual alt dial manual dial filter
# 130328-0009 - Converted ereg to preg functions
# 130328-1015 - Added validation for agent manual dial permission on DIAL links
# 130402-2242 - Added user_group variable to _call_url functions
# 130412-1348 - Added SIP cause code display on failed calls
# 130414-2142 - Small fix for multi-server inbound setups and did options in url functions
# 130508-2221 - Cleanup for other language builds
# 130603-2207 - Added login lockout for 15 minutes after 10 failed logins, and other security fixes
# 130615-1126 - Added recording_id to dispo url
# 130617-0805 - Fixed issue with scheduled callbacks and campaign presets
# 130705-1512 - Added optional encrypted passwords compatibility
# 130718-0737 - Added recording_filename to dispo url
# 130802-1039 - Changed to PHP mysqli functions
# 130925-2108 - Fixed issue with List webform overrides
# 131208-2157 - Added user log TIMEOUTLOGOUT event status
# 131209-1522 - Added called_count to log and closer log tables, fixed unanswered call logging issue
# 131210-1400 - Fixed manual dial CID choice issue with AC-CID settings
# 140124-1209 - Added error catching for start/dispo call URL logging
# 140126-0727 - Added pause_code API code
# 140207-0208 - Manager selected in-groups are now restricted to allowed campaign in-groups
# 140214-1852 - Added preview_dial_action API function
# 140215-2051 - Added several variable options for QM socket URL
# 140217-0803 - Small fix for campaigns with no lists
# 140301-2348 - Small change for new API MANUALNEXT option
# 140402-1750 - Formatting cleanup and MySQL logging cleanup
# 140407-1923 - Fixed call notes logging bug when call is not answered
# 140417-0931 - Added max inbound calls feature
# 140418-1536 - Added flagging of preview dialing in vicidial_live_agents
# 140423-2055 - Added hide_call_log_info campaign option
# 140427-1058 - Added pause_type
# 140520-1957 - Fixed security_phrase variable label issues, fixed owner only dialing SQL inefficiency
# 140610-1519 - Fixed issue with manual dial wait_sec being inflated in Asterisk 1.8
# 140617-1044 - Fixed issue with non-latin, issue #773
# 140621-1544 - Added update_settings function
# 140703-1659 - Several logging fixes, mostly related to manual dial calls
# 140810-2046 - Changed to use QXZ function for echoing text
# 140908-1031 - Fixed issues with logging of non-answered calls, user_group and call notes
# 141024-0851 - Fixed issues with filtering of manual dial calls from call log or callbacks
# 141111-0658 - Removed several AJAX text outputs from QXZ output
# 141118-1231 - Formatting changes for QXZ output
# 141123-0933 - Added dispo_comments option input
# 141124-1136 - Added cbcomment_comments option input
# 141125-0059 - Added parked_hangup code
# 141128-0849 - Code cleanup for QXZ functions
# 141207-1056 - Added pause_trigger to logout to force pause before running logout process
# 141216-1900 - Added agent choose language option
# 141229-1428 - Changed single-quote QXZ arguments to double-quotes
# 150111-1544 - Added lists option: local call time(Issue #812) and added manual_dial_search_filter feature
# 150114-2051 - Added list_name web url variable
# 150117-1412 - Added list local call time validation
# 150312-1501 - Allow for single quotes in vicidial_list data fields
# 150428-1722 - Added web form three
# 150512-0616 - Fix for non-latin customer data
# 150608-1051 - Added alt and addr3 options for manual dial search and filtering
# 150609-1400 - Added script color
# 150609-1857 - Added list_description web url variable
# 150701-1205 - Modified mysqli_error() to mysqli_connect_error() where appropriate
# 150706-0903 - Added user lead filter option for no-hopper dialing
# 150711-0815 - Changed to allow for multiple Dispo Call URLs
# 150723-1705 - Added ajax logging
# 150725-1613 - Added entry_date as a variable
# 150727-0910 - Added default_language
# 150728-1049 - Added option for secondary sorting by vendor_lead_code, Issue #833
# 150814-1057 - Added compatibility for custom fields data option
# 150923-2013 - Added DID custom variables to call data transmission
# 150928-1818 - Added dnc logging
# 151006-0939 - Changed campaign_cid_areacodes to operate with 2-5 digit areacodes
# 151026-1710 - Added function for Status Groups lookups and delivery to agent screen
# 151119-1931 - Fixed issue with outbound CID in some cases during dial-only function
# 151209-1615 - Fixed issue with possible data loss using callback or dispo comments
# 151212-0916 - Added chat-related functions for the agent interface
# 151220-1109 - Improved logging of chats, emails, inbound calls
# 151229-2316 - Added manual_dial_timeout campaign setting
# 160108-2300 - Changed some mysqli_query to mysql_to_mysqli for consistency
# 160109-0747 - Added manual_dial_hopper_check campaign setting
# 160120-2226 - Fixed issue where non-phone leads were not updating, and lead_info issue
# 160303-0049 - Fixed issue with did script variables, added code for chat transfers
# 160326-0940 - Fixed issue #933, variables
# 160326-1002 - Fixed issue #934, phone_login
# 160331-2130 - Fixed missing start and dispo call url variables, issue #938
# 160414-0944 - Added default_phone_code value instead of hard-coded '1'
# 160510-0840 - Added callback_lead_status as dispo_call_url variable
# 160706-1437 - Added font styles to text in many places
# 160714-1503 - Added called_count as a dispo_call_url variable
# 160801-0717 - Added lists option to ALT dispo call url functions
# 160901-1714 - Added last_local_call_time sent to agent screen with lead info
# 160926-1053 - Fix for inbound call notes display
# 161013-2226 - Added user_new_lead_limit option code
# 161029-1026 - Added more agent debug logging details
# 161101-2103 - Added user overall new lead limit
# 161102-1044 - Fixed QM partition problem
# 161117-0622 - Fixes for rare vicidial_log and recording_log issues
# 161222-0728 - Fixed issue with Scheduled Callbacks with tilde'~' in text fields
# 161231-1250 - Fixed issue #985, inbound dispo call url
# 170201-2214 - Fix for receiving call just after a pause
# 170207-1315 - Added user option api_only_user
# 170221-0143 - Fix for rare missed agent log insert trigger
# 170221-1314 - Added more DNC options for campaign setting, manual dial filter
# 170228-1625 - Fix to prevent double-logging when emergency logout happens
# 170309-0704 - Small fix for INBOUND_MAN agent logging issue
# 170309-1550 - Added campaign agent_xfer_validation option
# 170327-1656 - Added USER_CUSTOM_ options to campaign custom callerID setting
# 170401-1437 - Added translation of callbacks statuses, issue #1006
# 170429-0835 - Added callback_display_days option
# 170504-1056 - Added start_call_url to manual-dial calls
# 170526-2327 - Added additional variable filtering
# 170527-2208 - Added more additional variable filtering, fixed rare inbound logging issue #1017
# 170605-1633 - Added vendor_lead_code to agent lead search results screen
# 170609-1710 - Small debug addition
# 170712-1548 - Changed agents view to use last_state_change for time
# 170816-2334 - Added ask post-call survey feature for in-group calls
# 170912-1618 - Fix for no-hopper dnc dialing issue
# 171018-1310 - Added code for campaign scheduled callback email alerts
# 171026-0107 - Added optional queue_log logging
# 171116-2334 - Added code for duplicate fields
# 171124-1158 - Added max_inbound_calls_outcome options
# 171130-0314 - Added agent_screen_time_display option
# 171204-1528 - Fixes for custom field duplicate fields
# 171224-1222 - Added List default_xfer_group override
# 180108-2048 - Added next_dial_my_callbacks feature
# 180131-1116 - Fixed ereg issue
# 180204-1651 - Added update for inbound callback queue functionality
# 180210-0707 - Fix for callback list issue #1062
# 180212-0654 - Added callback_datetime as dispo call url variable
# 180214-1553 - Added CID Group functionality
# 180216-1350 - Fix for callback alt dial isssue #1066
# 180228-0726 - Fix for LogiNCamPaigns function, removed unnecesary onfocus trigger, issue #1074
# 180410-1630 - Added Pause Code manager approval feature, Added switch_lead logging
# 180411-1833 - Added Dispo URL Filter feature
#

$version = '2.14-347';
$build = '180411-1833';
$php_script = 'vdc_db_query.php';
$mel=1;					# Mysql Error Log enabled = 1
$mysql_log_count=719;
$one_mysql_log=0;
$DB=0;
$VD_login=0;
$SSagent_debug_logging=0;
$pause_to_code_jump=0;
$startMS = microtime();

require_once("dbconnect_mysqli.php");
require_once("functions.php");

### If you have globals turned off uncomment these lines
if (isset($_GET["user"]))						{$user=$_GET["user"];}
	elseif (isset($_POST["user"]))				{$user=$_POST["user"];}
if (isset($_GET["pass"]))						{$pass=$_GET["pass"];}
	elseif (isset($_POST["pass"]))				{$pass=$_POST["pass"];}
if (isset($_GET["server_ip"]))					{$server_ip=$_GET["server_ip"];}
	elseif (isset($_POST["server_ip"]))			{$server_ip=$_POST["server_ip"];}
if (isset($_GET["session_name"]))				{$session_name=$_GET["session_name"];}
	elseif (isset($_POST["session_name"]))		{$session_name=$_POST["session_name"];}
if (isset($_GET["format"]))						{$format=$_GET["format"];}
	elseif (isset($_POST["format"]))			{$format=$_POST["format"];}
if (isset($_GET["ACTION"]))						{$ACTION=$_GET["ACTION"];}
	elseif (isset($_POST["ACTION"]))			{$ACTION=$_POST["ACTION"];}
if (isset($_GET["stage"]))						{$stage=$_GET["stage"];}
	elseif (isset($_POST["stage"]))				{$stage=$_POST["stage"];}
if (isset($_GET["closer_choice"]))				{$closer_choice=$_GET["closer_choice"];}
	elseif (isset($_POST["closer_choice"]))		{$closer_choice=$_POST["closer_choice"];}
if (isset($_GET["conf_exten"]))					{$conf_exten=$_GET["conf_exten"];}
	elseif (isset($_POST["conf_exten"]))		{$conf_exten=$_POST["conf_exten"];}
if (isset($_GET["exten"]))						{$exten=$_GET["exten"];}
	elseif (isset($_POST["exten"]))				{$exten=$_POST["exten"];}
if (isset($_GET["ext_context"]))				{$ext_context=$_GET["ext_context"];}
	elseif (isset($_POST["ext_context"]))		{$ext_context=$_POST["ext_context"];}
if (isset($_GET["ext_priority"]))				{$ext_priority=$_GET["ext_priority"];}
	elseif (isset($_POST["ext_priority"]))		{$ext_priority=$_POST["ext_priority"];}
if (isset($_GET["campaign"]))					{$campaign=$_GET["campaign"];}
	elseif (isset($_POST["campaign"]))			{$campaign=$_POST["campaign"];}
if (isset($_GET["dial_timeout"]))				{$dial_timeout=$_GET["dial_timeout"];}
	elseif (isset($_POST["dial_timeout"]))		{$dial_timeout=$_POST["dial_timeout"];}
if (isset($_GET["dial_prefix"]))				{$dial_prefix=$_GET["dial_prefix"];}
	elseif (isset($_POST["dial_prefix"]))		{$dial_prefix=$_POST["dial_prefix"];}
if (isset($_GET["campaign_cid"]))				{$campaign_cid=$_GET["campaign_cid"];}
	elseif (isset($_POST["campaign_cid"]))		{$campaign_cid=$_POST["campaign_cid"];}
if (isset($_GET["MDnextCID"]))					{$MDnextCID=$_GET["MDnextCID"];}
	elseif (isset($_POST["MDnextCID"]))			{$MDnextCID=$_POST["MDnextCID"];}
if (isset($_GET["uniqueid"]))					{$uniqueid=$_GET["uniqueid"];}
	elseif (isset($_POST["uniqueid"]))			{$uniqueid=$_POST["uniqueid"];}
if (isset($_GET["lead_id"]))					{$lead_id=$_GET["lead_id"];}
	elseif (isset($_POST["lead_id"]))			{$lead_id=$_POST["lead_id"];}
if (isset($_GET["list_id"]))					{$list_id=$_GET["list_id"];}
	elseif (isset($_POST["list_id"]))			{$list_id=$_POST["list_id"];}
if (isset($_GET["length_in_sec"]))				{$length_in_sec=$_GET["length_in_sec"];}
	elseif (isset($_POST["length_in_sec"]))		{$length_in_sec=$_POST["length_in_sec"];}
if (isset($_GET["phone_code"]))					{$phone_code=$_GET["phone_code"];}
	elseif (isset($_POST["phone_code"]))		{$phone_code=$_POST["phone_code"];}
if (isset($_GET["phone_number"]))				{$phone_number=$_GET["phone_number"];}
	elseif (isset($_POST["phone_number"]))		{$phone_number=$_POST["phone_number"];}
if (isset($_GET["channel"]))					{$channel=$_GET["channel"];}
	elseif (isset($_POST["channel"]))			{$channel=$_POST["channel"];}
if (isset($_GET["start_epoch"]))				{$start_epoch=$_GET["start_epoch"];}
	elseif (isset($_POST["start_epoch"]))		{$start_epoch=$_POST["start_epoch"];}
if (isset($_GET["dispo_choice"]))				{$dispo_choice=$_GET["dispo_choice"];}
	elseif (isset($_POST["dispo_choice"]))		{$dispo_choice=$_POST["dispo_choice"];}
if (isset($_GET["vendor_lead_code"]))			{$vendor_lead_code=$_GET["vendor_lead_code"];}
	elseif (isset($_POST["vendor_lead_code"]))	{$vendor_lead_code=$_POST["vendor_lead_code"];}
if (isset($_GET["title"]))						{$title=$_GET["title"];}
	elseif (isset($_POST["title"]))				{$title=$_POST["title"];}
if (isset($_GET["first_name"]))					{$first_name=$_GET["first_name"];}
	elseif (isset($_POST["first_name"]))		{$first_name=$_POST["first_name"];}
if (isset($_GET["middle_initial"]))				{$middle_initial=$_GET["middle_initial"];}
	elseif (isset($_POST["middle_initial"]))	{$middle_initial=$_POST["middle_initial"];}
if (isset($_GET["last_name"]))					{$last_name=$_GET["last_name"];}
	elseif (isset($_POST["last_name"]))			{$last_name=$_POST["last_name"];}
if (isset($_GET["address1"]))					{$address1=$_GET["address1"];}
	elseif (isset($_POST["address1"]))			{$address1=$_POST["address1"];}
if (isset($_GET["address2"]))					{$address2=$_GET["address2"];}
	elseif (isset($_POST["address2"]))			{$address2=$_POST["address2"];}
if (isset($_GET["address3"]))					{$address3=$_GET["address3"];}
	elseif (isset($_POST["address3"]))			{$address3=$_POST["address3"];}
if (isset($_GET["city"]))						{$city=$_GET["city"];}
	elseif (isset($_POST["city"]))				{$city=$_POST["city"];}
if (isset($_GET["state"]))						{$state=$_GET["state"];}
	elseif (isset($_POST["state"]))				{$state=$_POST["state"];}
if (isset($_GET["province"]))					{$province=$_GET["province"];}
	elseif (isset($_POST["province"]))			{$province=$_POST["province"];}
if (isset($_GET["postal_code"]))				{$postal_code=$_GET["postal_code"];}
	elseif (isset($_POST["postal_code"]))		{$postal_code=$_POST["postal_code"];}
if (isset($_GET["country_code"]))				{$country_code=$_GET["country_code"];}
	elseif (isset($_POST["country_code"]))		{$country_code=$_POST["country_code"];}
if (isset($_GET["gender"]))						{$gender=$_GET["gender"];}
	elseif (isset($_POST["gender"]))			{$gender=$_POST["gender"];}
if (isset($_GET["date_of_birth"]))				{$date_of_birth=$_GET["date_of_birth"];}
	elseif (isset($_POST["date_of_birth"]))		{$date_of_birth=$_POST["date_of_birth"];}
if (isset($_GET["alt_phone"]))					{$alt_phone=$_GET["alt_phone"];}
	elseif (isset($_POST["alt_phone"]))			{$alt_phone=$_POST["alt_phone"];}
if (isset($_GET["email"]))						{$email=$_GET["email"];}
	elseif (isset($_POST["email"]))				{$email=$_POST["email"];}
if (isset($_GET["security_phrase"]))			{$security_phrase=$_GET["security_phrase"];}
	elseif (isset($_POST["security_phrase"]))	{$security_phrase=$_POST["security_phrase"];}
if (isset($_GET["comments"]))					{$comments=$_GET["comments"];}
	elseif (isset($_POST["comments"]))			{$comments=$_POST["comments"];}
if (isset($_GET["auto_dial_level"]))			{$auto_dial_level=$_GET["auto_dial_level"];}
	elseif (isset($_POST["auto_dial_level"]))	{$auto_dial_level=$_POST["auto_dial_level"];}
if (isset($_GET["VDstop_rec_after_each_call"]))				{$VDstop_rec_after_each_call=$_GET["VDstop_rec_after_each_call"];}
	elseif (isset($_POST["VDstop_rec_after_each_call"]))		{$VDstop_rec_after_each_call=$_POST["VDstop_rec_after_each_call"];}
if (isset($_GET["conf_silent_prefix"]))				{$conf_silent_prefix=$_GET["conf_silent_prefix"];}
	elseif (isset($_POST["conf_silent_prefix"]))	{$conf_silent_prefix=$_POST["conf_silent_prefix"];}
if (isset($_GET["extension"]))					{$extension=$_GET["extension"];}
	elseif (isset($_POST["extension"]))			{$extension=$_POST["extension"];}
if (isset($_GET["protocol"]))					{$protocol=$_GET["protocol"];}
	elseif (isset($_POST["protocol"]))			{$protocol=$_POST["protocol"];}
if (isset($_GET["user_abb"]))					{$user_abb=$_GET["user_abb"];}
	elseif (isset($_POST["user_abb"]))			{$user_abb=$_POST["user_abb"];}
if (isset($_GET["preview"]))					{$preview=$_GET["preview"];}
	elseif (isset($_POST["preview"]))			{$preview=$_POST["preview"];}
if (isset($_GET["called_count"]))				{$called_count=$_GET["called_count"];}
	elseif (isset($_POST["called_count"]))		{$called_count=$_POST["called_count"];}
if (isset($_GET["agent_log_id"]))				{$agent_log_id=$_GET["agent_log_id"];}
	elseif (isset($_POST["agent_log_id"]))		{$agent_log_id=$_POST["agent_log_id"];}
if (isset($_GET["agent_log"]))					{$agent_log=$_GET["agent_log"];}
	elseif (isset($_POST["agent_log"]))			{$agent_log=$_POST["agent_log"];}
if (isset($_GET["favorites_list"]))				{$favorites_list=$_GET["favorites_list"];}
	elseif (isset($_POST["favorites_list"]))	{$favorites_list=$_POST["favorites_list"];}
if (isset($_GET["CallBackDatETimE"]))			{$CallBackDatETimE=$_GET["CallBackDatETimE"];}
	elseif (isset($_POST["CallBackDatETimE"]))	{$CallBackDatETimE=$_POST["CallBackDatETimE"];}
if (isset($_GET["recipient"]))					{$recipient=$_GET["recipient"];}
	elseif (isset($_POST["recipient"]))			{$recipient=$_POST["recipient"];}
if (isset($_GET["callback_id"]))				{$callback_id=$_GET["callback_id"];}
	elseif (isset($_POST["callback_id"]))		{$callback_id=$_POST["callback_id"];}
if (isset($_GET["use_internal_dnc"]))			{$use_internal_dnc=$_GET["use_internal_dnc"];}
	elseif (isset($_POST["use_internal_dnc"]))	{$use_internal_dnc=$_POST["use_internal_dnc"];}
if (isset($_GET["use_campaign_dnc"]))			{$use_campaign_dnc=$_GET["use_campaign_dnc"];}
	elseif (isset($_POST["use_campaign_dnc"]))	{$use_campaign_dnc=$_POST["use_campaign_dnc"];}
if (isset($_GET["omit_phone_code"]))			{$omit_phone_code=$_GET["omit_phone_code"];}
	elseif (isset($_POST["omit_phone_code"]))	{$omit_phone_code=$_POST["omit_phone_code"];}
if (isset($_GET["phone_ip"]))				{$phone_ip=$_GET["phone_ip"];}
	elseif (isset($_POST["phone_ip"]))		{$phone_ip=$_POST["phone_ip"];}
if (isset($_GET["enable_sipsak_messages"]))				{$enable_sipsak_messages=$_GET["enable_sipsak_messages"];}
	elseif (isset($_POST["enable_sipsak_messages"]))	{$enable_sipsak_messages=$_POST["enable_sipsak_messages"];}
if (isset($_GET["status"]))						{$status=$_GET["status"];}
	elseif (isset($_POST["status"]))			{$status=$_POST["status"];}
if (isset($_GET["LogouTKicKAlL"]))				{$LogouTKicKAlL=$_GET["LogouTKicKAlL"];}
	elseif (isset($_POST["LogouTKicKAlL"]))		{$LogouTKicKAlL=$_POST["LogouTKicKAlL"];}
if (isset($_GET["closer_blended"]))				{$closer_blended=$_GET["closer_blended"];}
	elseif (isset($_POST["closer_blended"]))	{$closer_blended=$_POST["closer_blended"];}
if (isset($_GET["inOUT"]))						{$inOUT=$_GET["inOUT"];}
	elseif (isset($_POST["inOUT"]))				{$inOUT=$_POST["inOUT"];}
if (isset($_GET["manual_dial_filter"]))				{$manual_dial_filter=$_GET["manual_dial_filter"];}
	elseif (isset($_POST["manual_dial_filter"]))	{$manual_dial_filter=$_POST["manual_dial_filter"];}
if (isset($_GET["alt_dial"]))					{$alt_dial=$_GET["alt_dial"];}
	elseif (isset($_POST["alt_dial"]))			{$alt_dial=$_POST["alt_dial"];}
if (isset($_GET["agentchannel"]))				{$agentchannel=$_GET["agentchannel"];}
	elseif (isset($_POST["agentchannel"]))		{$agentchannel=$_POST["agentchannel"];}
if (isset($_GET["conf_dialed"]))				{$conf_dialed=$_GET["conf_dialed"];}
	elseif (isset($_POST["conf_dialed"]))		{$conf_dialed=$_POST["conf_dialed"];}
if (isset($_GET["leaving_threeway"]))			{$leaving_threeway=$_GET["leaving_threeway"];}
	elseif (isset($_POST["leaving_threeway"]))	{$leaving_threeway=$_POST["leaving_threeway"];}
if (isset($_GET["hangup_all_non_reserved"]))			{$hangup_all_non_reserved=$_GET["hangup_all_non_reserved"];}
	elseif (isset($_POST["hangup_all_non_reserved"]))	{$hangup_all_non_reserved=$_POST["hangup_all_non_reserved"];}
if (isset($_GET["blind_transfer"]))				{$blind_transfer=$_GET["blind_transfer"];}
	elseif (isset($_POST["blind_transfer"]))	{$blind_transfer=$_POST["blind_transfer"];}
if (isset($_GET["usegroupalias"]))			{$usegroupalias=$_GET["usegroupalias"];}
	elseif (isset($_POST["usegroupalias"]))	{$usegroupalias=$_POST["usegroupalias"];}
if (isset($_GET["account"]))				{$account=$_GET["account"];}
	elseif (isset($_POST["account"]))		{$account=$_POST["account"];}
if (isset($_GET["agent_dialed_number"]))			{$agent_dialed_number=$_GET["agent_dialed_number"];}
	elseif (isset($_POST["agent_dialed_number"]))	{$agent_dialed_number=$_POST["agent_dialed_number"];}
if (isset($_GET["agent_dialed_type"]))				{$agent_dialed_type=$_GET["agent_dialed_type"];}
	elseif (isset($_POST["agent_dialed_type"]))		{$agent_dialed_type=$_POST["agent_dialed_type"];}
if (isset($_GET["wrapup"]))					{$wrapup=$_GET["wrapup"];}
	elseif (isset($_POST["wrapup"]))		{$wrapup=$_POST["wrapup"];}
if (isset($_GET["vtiger_callback_id"]))				{$vtiger_callback_id=$_GET["vtiger_callback_id"];}
	elseif (isset($_POST["vtiger_callback_id"]))	{$vtiger_callback_id=$_POST["vtiger_callback_id"];}
if (isset($_GET["dial_method"]))				{$dial_method=$_GET["dial_method"];}
	elseif (isset($_POST["dial_method"]))		{$dial_method=$_POST["dial_method"];}
if (isset($_GET["no_delete_sessions"]))				{$no_delete_sessions=$_GET["no_delete_sessions"];}
	elseif (isset($_POST["no_delete_sessions"]))	{$no_delete_sessions=$_POST["no_delete_sessions"];}
if (isset($_GET["nodeletevdac"]))				{$nodeletevdac=$_GET["nodeletevdac"];}
	elseif (isset($_POST["nodeletevdac"]))		{$nodeletevdac=$_POST["nodeletevdac"];}
if (isset($_GET["agent_territories"]))			{$agent_territories=$_GET["agent_territories"];}
	elseif (isset($_POST["agent_territories"]))	{$agent_territories=$_POST["agent_territories"];}
if (isset($_GET["alt_num_status"]))				{$alt_num_status=$_GET["alt_num_status"];}
	elseif (isset($_POST["alt_num_status"]))	{$alt_num_status=$_POST["alt_num_status"];}
if (isset($_GET["DiaL_SecondS"]))				{$DiaL_SecondS=$_GET["DiaL_SecondS"];}
	elseif (isset($_POST["DiaL_SecondS"]))		{$DiaL_SecondS=$_POST["DiaL_SecondS"];}
if (isset($_GET["date"]))						{$date=$_GET["date"];}
	elseif (isset($_POST["date"]))				{$date=$_POST["date"];}
if (isset($_GET["custom_field_names"]))				{$FORMcustom_field_names=$_GET["custom_field_names"];}
	elseif (isset($_POST["custom_field_names"]))	{$FORMcustom_field_names=$_POST["custom_field_names"];}
if (isset($_GET["qm_phone"]))			{$qm_phone=$_GET["qm_phone"];}
	elseif (isset($_POST["qm_phone"]))	{$qm_phone=$_POST["qm_phone"];}
if (isset($_GET["manual_dial_call_time_check"]))			{$manual_dial_call_time_check=$_GET["manual_dial_call_time_check"];}
	elseif (isset($_POST["manual_dial_call_time_check"]))	{$manual_dial_call_time_check=$_POST["manual_dial_call_time_check"];}
if (isset($_GET["CallBackLeadStatus"]))				{$CallBackLeadStatus=$_GET["CallBackLeadStatus"];}
	elseif (isset($_POST["CallBackLeadStatus"]))	{$CallBackLeadStatus=$_POST["CallBackLeadStatus"];}
if (isset($_GET["call_notes"]))				{$call_notes=$_GET["call_notes"];}
	elseif (isset($_POST["call_notes"]))	{$call_notes=$_POST["call_notes"];}
if (isset($_GET["search"]))				{$search=$_GET["search"];}
	elseif (isset($_POST["search"]))	{$search=$_POST["search"];}
if (isset($_GET["sub_status"]))				{$sub_status=$_GET["sub_status"];}
	elseif (isset($_POST["sub_status"]))	{$sub_status=$_POST["sub_status"];}
if (isset($_GET["qm_extension"]))			{$qm_extension=$_GET["qm_extension"];}
	elseif (isset($_POST["qm_extension"]))	{$qm_extension=$_POST["qm_extension"];}
if (isset($_GET["disable_alter_custphone"]))			{$disable_alter_custphone=$_GET["disable_alter_custphone"];}
	elseif (isset($_POST["disable_alter_custphone"]))	{$disable_alter_custphone=$_POST["disable_alter_custphone"];}
if (isset($_GET["bu_name"]))			{$bu_name=$_GET["bu_name"];}
	elseif (isset($_POST["bu_name"]))	{$bu_name=$_POST["bu_name"];}
if (isset($_GET["department"]))				{$department=$_GET["department"];}
	elseif (isset($_POST["department"]))	{$department=$_POST["department"];}
if (isset($_GET["group_name"]))				{$group_name=$_GET["group_name"];}
	elseif (isset($_POST["group_name"]))	{$group_name=$_POST["group_name"];}
if (isset($_GET["job_title"]))			{$job_title=$_GET["job_title"];}
	elseif (isset($_POST["job_title"]))	{$job_title=$_POST["job_title"];}
if (isset($_GET["location"]))			{$location=$_GET["location"];}
	elseif (isset($_POST["location"]))	{$location=$_POST["location"];}
if (isset($_GET["old_CID"]))			{$old_CID=$_GET["old_CID"];}
	elseif (isset($_POST["old_CID"]))	{$old_CID=$_POST["old_CID"];}
if (isset($_GET["qm_dispo_code"]))			{$qm_dispo_code=$_GET["qm_dispo_code"];}
	elseif (isset($_POST["qm_dispo_code"]))	{$qm_dispo_code=$_POST["qm_dispo_code"];}
if (isset($_GET["dial_ingroup"]))			{$dial_ingroup=$_GET["dial_ingroup"];}
	elseif (isset($_POST["dial_ingroup"]))	{$dial_ingroup=$_POST["dial_ingroup"];}
if (isset($_GET["nocall_dial_flag"]))			{$nocall_dial_flag=$_GET["nocall_dial_flag"];}
	elseif (isset($_POST["nocall_dial_flag"]))	{$nocall_dial_flag=$_POST["nocall_dial_flag"];}
if (isset($_GET["inbound_lead_search"]))			{$inbound_lead_search=$_GET["inbound_lead_search"];}
	elseif (isset($_POST["inbound_lead_search"]))	{$inbound_lead_search=$_POST["inbound_lead_search"];}
if (isset($_GET["email_enabled"]))			{$email_enabled=$_GET["email_enabled"];}
	elseif (isset($_POST["email_enabled"]))	{$email_enabled=$_POST["email_enabled"];}
if (isset($_GET["email_row_id"]))			{$email_row_id=$_GET["email_row_id"];}
	elseif (isset($_POST["email_row_id"]))	{$email_row_id=$_POST["email_row_id"];}
if (isset($_GET["inbound_email_groups"]))			{$inbound_email_groups=$_GET["inbound_email_groups"];}
	elseif (isset($_POST["inbound_email_groups"]))	{$inbound_email_groups=$_POST["inbound_email_groups"];}
if (isset($_GET["inbound_chat_groups"]))			{$inbound_chat_groups=$_GET["inbound_chat_groups"];}
	elseif (isset($_POST["inbound_chat_groups"]))	{$inbound_chat_groups=$_POST["inbound_chat_groups"];}
if (isset($_GET["recording_id"]))			{$recording_id=$_GET["recording_id"];}
	elseif (isset($_POST["recording_id"]))	{$recording_id=$_POST["recording_id"];}
if (isset($_GET["recording_filename"]))				{$recording_filename=$_GET["recording_filename"];}
	elseif (isset($_POST["recording_filename"]))	{$recording_filename=$_POST["recording_filename"];}
if (isset($_GET["orig_pass"]))			{$orig_pass=$_GET["orig_pass"];}
	elseif (isset($_POST["orig_pass"]))	{$orig_pass=$_POST["orig_pass"];}
if (isset($_GET["cid_lock"]))			{$cid_lock=$_GET["cid_lock"];}
	elseif (isset($_POST["cid_lock"]))	{$cid_lock=$_POST["cid_lock"];}
if (isset($_GET["dispo_comments"]))				{$dispo_comments=$_GET["dispo_comments"];}
	elseif (isset($_POST["dispo_comments"]))	{$dispo_comments=$_POST["dispo_comments"];}
if (isset($_GET["cbcomment_comments"]))				{$cbcomment_comments=$_GET["cbcomment_comments"];}
	elseif (isset($_POST["cbcomment_comments"]))	{$cbcomment_comments=$_POST["cbcomment_comments"];}
if (isset($_GET["parked_hangup"]))			{$parked_hangup=$_GET["parked_hangup"];}
	elseif (isset($_POST["parked_hangup"]))	{$parked_hangup=$_POST["parked_hangup"];}
if (isset($_GET["pause_trigger"]))			{$pause_trigger=$_GET["pause_trigger"];}
	elseif (isset($_POST["pause_trigger"]))	{$pause_trigger=$_POST["pause_trigger"];}
if (isset($_GET["DB"]))					{$DB=$_GET["DB"];}
	elseif (isset($_POST["DB"]))		{$DB=$_POST["DB"];}
if (isset($_GET["in_script"]))			{$in_script=$_GET["in_script"];}
	elseif (isset($_POST["in_script"]))	{$in_script=$_POST["in_script"];}
if (isset($_GET["camp_script"]))			{$camp_script=$_GET["camp_script"];}
	elseif (isset($_POST["camp_script"]))	{$camp_script=$_POST["camp_script"];}
if (isset($_GET["manual_dial_search_filter"]))			{$manual_dial_search_filter=$_GET["manual_dial_search_filter"];}
	elseif (isset($_POST["manual_dial_search_filter"]))	{$manual_dial_search_filter=$_POST["manual_dial_search_filter"];}
if (isset($_GET["url_ids"]))			{$url_ids=$_GET["url_ids"];}
	elseif (isset($_POST["url_ids"]))	{$url_ids=$_POST["url_ids"];}
if (isset($_GET["phone_login"]))			{$phone_login=$_GET["phone_login"];}
	elseif (isset($_POST["phone_login"]))	{$phone_login=$_POST["phone_login"];}
if (isset($_GET["agent_email"]))	{$agent_email=$_GET["agent_email"];}
	elseif (isset($_POST["agent_email"]))	{$agent_email=$_POST["agent_email"];}
if (isset($_GET["original_phone_login"]))	{$original_phone_login=$_GET["original_phone_login"];}
	elseif (isset($_POST["original_phone_login"]))	{$original_phone_login=$_POST["original_phone_login"];}
if (isset($_GET["customer_zap_channel"]))	{$customer_zap_channel=$_GET["customer_zap_channel"];}
	elseif (isset($_POST["customer_zap_channel"]))	{$customer_zap_channel=$_POST["customer_zap_channel"];}
if (isset($_GET["customer_server_ip"]))	{$customer_server_ip=$_GET["customer_server_ip"];}
	elseif (isset($_POST["customer_server_ip"]))	{$customer_server_ip=$_POST["customer_server_ip"];}
if (isset($_GET["phone_pass"]))	{$phone_pass=$_GET["phone_pass"];}
	elseif (isset($_POST["phone_pass"]))	{$phone_pass=$_POST["phone_pass"];}
if (isset($_GET["VDRP_stage"]))	{$VDRP_stage=$_GET["VDRP_stage"];}
	elseif (isset($_POST["VDRP_stage"]))	{$VDRP_stage=$_POST["VDRP_stage"];}
if (isset($_GET["previous_agent_log_id"]))	{$previous_agent_log_id=$_GET["previous_agent_log_id"];}
	elseif (isset($_POST["previous_agent_log_id"]))	{$previous_agent_log_id=$_POST["previous_agent_log_id"];}
if (isset($_GET["last_VDRP_stage"]))	{$last_VDRP_stage=$_GET["last_VDRP_stage"];}
	elseif (isset($_POST["last_VDRP_stage"]))	{$last_VDRP_stage=$_POST["last_VDRP_stage"];}
if (isset($_GET["url_link"]))			{$url_link=$_GET["url_link"];}
	elseif (isset($_POST["url_link"]))	{$url_link=$_POST["url_link"];}
if (isset($_GET["user_group"]))				{$user_group=$_GET["user_group"];}
	elseif (isset($_POST["user_group"]))	{$user_group=$_POST["user_group"];}
if (isset($_GET["MgrApr_user"]))			{$MgrApr_user=$_GET["MgrApr_user"];}
	elseif (isset($_POST["MgrApr_user"]))	{$MgrApr_user=$_POST["MgrApr_user"];}
if (isset($_GET["MgrApr_pass"]))			{$MgrApr_pass=$_GET["MgrApr_pass"];}
	elseif (isset($_POST["MgrApr_pass"]))	{$MgrApr_pass=$_POST["MgrApr_pass"];}


header ("Content-type: text/html; charset=utf-8");
header ("Cache-Control: no-cache, must-revalidate");  // HTTP/1.1
header ("Pragma: no-cache");                          // HTTP/1.0

$txt = '.txt';
$StarTtime = date("U");
$NOW_DATE = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s");
$SQLdate = $NOW_TIME;
$CIDdate = date("mdHis");
$ENTRYdate = date("YmdHis");
$MT[0]='';
$agents='@agents';
$US='_';
while (strlen($CIDdate) > 9) {$CIDdate = substr("$CIDdate", 1);}
$check_time = ($StarTtime - 86400);

$secX = date("U");
$epoch = $secX;
$hour = date("H");
$min = date("i");
$sec = date("s");
$mon = date("m");
$mday = date("d");
$year = date("Y");
$isdst = date("I");
$Shour = date("H");
$Smin = date("i");
$Ssec = date("s");
$Smon = date("m");
$Smday = date("d");
$Syear = date("Y");

### Grab Server GMT value from the database
$stmt="SELECT local_gmt FROM servers where active='Y' limit 1;";
$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00545',$user,$server_ip,$session_name,$one_mysql_log);}
$gmt_recs = mysqli_num_rows($rslt);
if ($gmt_recs > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$DBSERVER_GMT		=		$row[0];
	if (strlen($DBSERVER_GMT)>0)	{$SERVER_GMT = $DBSERVER_GMT;}
	if ($isdst) {$SERVER_GMT++;} 
	}
else
	{
	$SERVER_GMT = date("O");
	$SERVER_GMT = preg_replace("/\+/i","",$SERVER_GMT);
	$SERVER_GMT = ($SERVER_GMT + 0);
	$SERVER_GMT = ($SERVER_GMT / 100);
	}

$LOCAL_GMT_OFF = $SERVER_GMT;
$LOCAL_GMT_OFF_STD = $SERVER_GMT;

##### Hangup Cause Dictionary #####
$hangup_cause_dictionary = array(
0 => "Unspecified. No other cause codes applicable.",
1 => "Unallocated (unassigned) number.",
2 => "No route to specified transit network (national use).",
3 => "No route to destination.",
6 => "Channel unacceptable.",
7 => "Call awarded, being delivered in an established channel.",
16 => "Normal call clearing.",
17 => "User busy.",
18 => "No user responding.",
19 => "No answer from user (user alerted).",
20 => "Subscriber absent.",
21 => "Call rejected.",
22 => "Number changed.",
23 => "Redirection to new destination.",
25 => "Exchange routing error.",
27 => "Destination out of order.",
28 => "Invalid number format (address incomplete).",
29 => "Facilities rejected.",
30 => "Response to STATUS INQUIRY.",
31 => "Normal, unspecified.",
34 => "No circuit/channel available.",
38 => "Network out of order.",
41 => "Temporary failure.",
42 => "Switching equipment congestion.",
43 => "Access information discarded.",
44 => "Requested circuit/channel not available.",
50 => "Requested facility not subscribed.",
52 => "Outgoing calls barred.",
54 => "Incoming calls barred.",
57 => "Bearer capability not authorized.",
58 => "Bearer capability not presently available.",
63 => "Service or option not available, unspecified.",
65 => "Bearer capability not implemented.",
66 => "Channel type not implemented.",
69 => "Requested facility not implemented.",
79 => "Service or option not implemented, unspecified.",
81 => "Invalid call reference value.",
88 => "Incompatible destination.",
95 => "Invalid message, unspecified.",
96 => "Mandatory information element is missing.",
97 => "Message type non-existent or not implemented.",
98 => "Message not compatible with call state or message type non-existent or not implemented.",
99 => "Information element / parameter non-existent or not implemented.",
100 => "Invalid information element contents.",
101 => "Message not compatible with call state.",
102 => "Recovery on timer expiry.",
103 => "Parameter non-existent or not implemented - passed on (national use).",
111 => "Protocol error, unspecified.",
127 => "Interworking, unspecified."
);

##### SIP Hangup Cause Dictionary #####
$sip_hangup_cause_dictionary = array(
400 => "Bad Request.",
401 => "Unauthorized.",
402 => "Payment Required.",
403 => "Forbidden.",
404 => "Not Found.",
405 => "Method Not Allowed.",
406 => "Not Acceptable.",
407 => "Proxy Authentication Required.",
408 => "Request Timeout.",
409 => "Conflict.",
410 => "Gone.",
411 => "Length Required.",
412 => "Conditional Request Failed.",
413 => "Request Entity Too Large.",
414 => "Request-URI Too Long.",
415 => "Unsupported Media Type.",
416 => "Unsupported URI Scheme.",
417 => "Unknown Resource-Priority.",
420 => "Bad Extension.",
421 => "Extension Required.",
422 => "Session Interval Too Small.",
423 => "Interval Too Brief.",
424 => "Bad Location Information.",
428 => "Use Identity Header.",
429 => "Provide Referrer Identity.",
433 => "Anonymity Disallowed.",
436 => "Bad Identity-Info.",
437 => "Unsupported Certificate.",
438 => "Invalid Identity Header.",
470 => "Consent Needed.",
480 => "Temporarily Unavailable.",
481 => "Call/Transaction Does Not Exist.",
482 => "Loop Detected..",
483 => "Too Many Hops.",
484 => "Address Incomplete.",
485 => "Ambiguous.",
486 => "Busy Here.",
487 => "Request Terminated.",
488 => "Not Acceptable Here.",
489 => "Bad Event.",
491 => "Request Pending.",
493 => "Undecipherable.",
494 => "Security Agreement Required.",
500 => "Server Internal Error.",
501 => "Not Implemented.",
502 => "Bad Gateway.",
503 => "Service Unavailable.",
504 => "Server Time-out.",
505 => "Version Not Supported.",
513 => "Message Too Large.",
580 => "Precondition Failure.",
600 => "Busy Everywhere.",
603 => "Decline.",
604 => "Does Not Exist Anywhere.",
606 => "Not Acceptable."
);


#############################################
##### START SYSTEM_SETTINGS LOOKUP #####
$stmt = "SELECT use_non_latin,timeclock_end_of_day,agentonly_callback_campaign_lock,alt_log_server_ip,alt_log_dbname,alt_log_login,alt_log_pass,tables_use_alt_log_db,qc_features_active,allow_emails,callback_time_24hour,enable_languages,language_method,agent_debug_logging,default_language,active_modules,allow_chats,default_phone_code,user_new_lead_limit FROM system_settings;";
$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00001',$user,$server_ip,$session_name,$one_mysql_log);}
if ($DB) {echo "$stmt\n";}
$qm_conf_ct = mysqli_num_rows($rslt);
if ($qm_conf_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$non_latin =							$row[0];
	$timeclock_end_of_day =					$row[1];
	$agentonly_callback_campaign_lock =		$row[2];
	$alt_log_server_ip =					$row[3];
	$alt_log_dbname =						$row[4];
	$alt_log_login =						$row[5];
	$alt_log_pass =							$row[6];
	$tables_use_alt_log_db =				$row[7];
	$qc_features_active =					$row[8];
	$allow_emails =							$row[9];
	$callback_time_24hour =					$row[10];
	$SSenable_languages =					$row[11];
	$SSlanguage_method =					$row[12];
	$SSagent_debug_logging =				$row[13];
	$SSdefault_language =					$row[14];
	$active_modules =						$row[15];
	$allow_chats =							$row[16];
	$default_phone_code =					$row[17];
	$SSuser_new_lead_limit =				$row[18];
	}
##### END SETTINGS LOOKUP #####
###########################################

if ($non_latin < 1)
	{
	$user=preg_replace("/[^-_0-9a-zA-Z]/","",$user);
	$pass=preg_replace("/\'|\"|\\\\|;| /","",$pass);
	$orig_pass=preg_replace("/[^-_0-9a-zA-Z]/","",$orig_pass);
	$phone_code = preg_replace("/[^0-9a-zA-Z]/","",$phone_code);
	$phone_number = preg_replace("/[^0-9a-zA-Z]/","",$phone_number);
	$status = preg_replace("/[^-_0-9a-zA-Z]/","",$status);
	$MgrApr_user = preg_replace("/[^-_0-9a-zA-Z]/","",$MgrApr_user);
	$MgrApr_pass = preg_replace("/[^-_0-9a-zA-Z]/","",$MgrApr_pass);
	}
else
	{
	$user = preg_replace("/\'|\"|\\\\|;/","",$user);
	$pass=preg_replace("/\'|\"|\\\\|;| /","",$pass);
	$orig_pass = preg_replace("/\'|\"|\\\\|;/","",$orig_pass);
	$status = preg_replace("/\'|\"|\\\\|;/","",$status);
	$MgrApr_user = preg_replace("/\'|\"|\\\\|;/","",$MgrApr_user);
	$MgrApr_pass = preg_replace("/\'|\"|\\\\|;/","",$MgrApr_pass);
	}

$session_name = preg_replace("/\'|\"|\\\\|;/","",$session_name);
$server_ip = preg_replace("/\'|\"|\\\\|;/","",$server_ip);
$alt_phone = preg_replace("/\s/","",$alt_phone);
$phone_code = preg_replace("/\s/","",$phone_code);
$phone_number = preg_replace("/\s/","",$phone_number);
$campaign = preg_replace("/\'|\"|\\\\|;/","",$campaign);
$closer_choice = preg_replace("/\'|\"|\\\\|;/","",$closer_choice);
$lead_id = preg_replace('/[^0-9]/','',$lead_id);
$list_id = preg_replace('/[^0-9]/','',$list_id);
$conf_exten = preg_replace('/[^-_\.0-9a-zA-Z]/','',$conf_exten);
$uniqueid = preg_replace('/[^-_\.0-9a-zA-Z]/','',$uniqueid);
$length_in_sec = preg_replace('/[^0-9]/','',$length_in_sec);
$CallBackDatETimE = preg_replace('/[^- \:_0-9a-zA-Z]/','',$CallBackDatETimE);
$CallBackLeadStatus = preg_replace('/[^-_0-9a-zA-Z]/','',$CallBackLeadStatus);
$DB = preg_replace('/[^0-9]/','',$DB);
$DiaL_SecondS = preg_replace('/[^0-9]/','',$DiaL_SecondS);
$LogouTKicKAlL = preg_replace('/[^0-9]/','',$LogouTKicKAlL);
$MDnextCID = preg_replace('/[^- _0-9a-zA-Z]/','',$MDnextCID);
$VDRP_stage = preg_replace('/[^-_0-9a-zA-Z]/','',$VDRP_stage);
$VDstop_rec_after_each_call = preg_replace('/[^-_0-9a-zA-Z]/','',$VDstop_rec_after_each_call);
$account = preg_replace('/[^-_0-9a-zA-Z]/','',$account);
$agent_dialed_number = preg_replace('/[^-_0-9a-zA-Z]/','',$agent_dialed_number);
$agent_dialed_type = preg_replace('/[^-_0-9a-zA-Z]/','',$agent_dialed_type);
$agent_email = preg_replace("/\'|\"|\\\\|;/","",$agent_email);
$agent_log = preg_replace('/[^-_0-9a-zA-Z]/','',$agent_log);
$agent_log_id = preg_replace('/[^-_0-9a-zA-Z]/','',$agent_log_id);
$agent_territories = preg_replace('/[^- _0-9a-zA-Z]/','',$agent_territories);
$agentchannel = preg_replace("/\'|\"|\\\\/","",$agentchannel);
$alt_dial = preg_replace('/[^-_0-9a-zA-Z]/','',$alt_dial);
$alt_num_status = preg_replace('/[^-_0-9a-zA-Z]/','',$alt_num_status);
$auto_dial_level = preg_replace('/[^-\._0-9a-zA-Z]/','',$auto_dial_level);
$blind_transfer = preg_replace('/[^-_0-9a-zA-Z]/','',$blind_transfer);
$callback_id = preg_replace('/[^-_0-9a-zA-Z]/','',$callback_id);
$called_count = preg_replace('/[^0-9]/','',$called_count);
$camp_script = preg_replace('/[^-_0-9a-zA-Z]/','',$camp_script);
$campaign_cid = preg_replace('/[^-_0-9a-zA-Z]/','',$campaign_cid);
$channel = preg_replace("/\'|\"|\\\\/","",$channel);
$cid_lock = preg_replace('/[^0-9]/','',$cid_lock);
$closer_blended = preg_replace('/[^-_0-9a-zA-Z]/','',$closer_blended);
$conf_dialed = preg_replace('/[^-_0-9a-zA-Z]/','',$conf_dialed);
$conf_silent_prefix = preg_replace('/[^-_0-9a-zA-Z]/','',$conf_silent_prefix);
$custom_field_names = preg_replace("/\'|\"|\\\\|;/","",$custom_field_names);
$customer_server_ip = preg_replace("/\'|\"|\\\\|;/","",$customer_server_ip);
$customer_zap_channel = preg_replace("/\'|\"|\\\\/","",$customer_zap_channel);
$date = preg_replace('/[^-_0-9]/','',$date);
$dial_ingroup = preg_replace('/[^-_0-9a-zA-Z]/','',$dial_ingroup);
$dial_method = preg_replace('/[^-_0-9a-zA-Z]/','',$dial_method);
$dial_prefix = preg_replace('/[^-_0-9a-zA-Z]/','',$dial_prefix);
$dial_timeout = preg_replace('/[^0-9]/','',$dial_timeout);
$disable_alter_custphone = preg_replace('/[^-_0-9a-zA-Z]/','',$disable_alter_custphone);
$dispo_choice = preg_replace('/[^-_0-9a-zA-Z]/','',$dispo_choice);
$email_enabled = preg_replace('/[^0-9]/','',$email_enabled);
$email_row_id = preg_replace('/[^-_0-9a-zA-Z]/','',$email_row_id);
$enable_sipsak_messages = preg_replace('/[^0-9]/','',$enable_sipsak_messages);
$ext_context = preg_replace('/[^-_0-9a-zA-Z]/','',$ext_context);
$ext_priority = preg_replace('/[^-_0-9a-zA-Z]/','',$ext_priority);
$exten = preg_replace("/\'|\"|\\\\|;/","",$exten);
$extension = preg_replace("/\'|\"|\\\\|;/","",$extension);
$favorites_list = preg_replace("/\"|\\\\|;/","",$favorites_list);
$format = preg_replace('/[^-_0-9a-zA-Z]/','',$format);
$gender = preg_replace('/[^-_0-9a-zA-Z]/','',$gender);
$group_name = preg_replace("/\'|\"|\\\\|;/","",$group_name);
$hangup_all_non_reserved = preg_replace('/[^0-9]/','',$hangup_all_non_reserved);
$inOUT = preg_replace('/[^-_0-9a-zA-Z]/','',$inOUT);
$in_script = preg_replace('/[^-_0-9a-zA-Z]/','',$in_script);
$inbound_lead_search = preg_replace('/[^0-9]/','',$inbound_lead_search);
$last_VDRP_stage = preg_replace('/[^-_0-9a-zA-Z]/','',$last_VDRP_stage);
$leaving_threeway = preg_replace('/[^0-9]/','',$leaving_threeway);
$manual_dial_call_time_check = preg_replace('/[^-_0-9a-zA-Z]/','',$manual_dial_call_time_check);
$manual_dial_filter = preg_replace('/[^-_0-9a-zA-Z]/','',$manual_dial_filter);
$manual_dial_search_filter = preg_replace('/[^-_0-9a-zA-Z]/','',$manual_dial_search_filter);
$no_delete_sessions = preg_replace('/[^0-9]/','',$no_delete_sessions);
$nocall_dial_flag = preg_replace('/[^-_0-9a-zA-Z]/','',$nocall_dial_flag);
$nodeletevdac = preg_replace('/[^0-9]/','',$nodeletevdac);
$old_CID = preg_replace('/[^- _0-9a-zA-Z]/','',$old_CID);
$omit_phone_code = preg_replace('/[^-_0-9a-zA-Z]/','',$omit_phone_code);
$original_phone_login = preg_replace("/\'|\"|\\\\|;/","",$original_phone_login);
$parked_hangup = preg_replace('/[^-_0-9a-zA-Z]/','',$parked_hangup);
$pause_trigger = preg_replace('/[^-_0-9a-zA-Z]/','',$pause_trigger);
$phone_login = preg_replace("/\'|\"|\\\\|;/","",$phone_login);
$phone_pass = preg_replace("/\'|\"|\\\\|;/","",$phone_pass);
$preview = preg_replace('/[^-_0-9a-zA-Z]/','',$preview);
$previous_agent_log_id = preg_replace('/[^-_0-9a-zA-Z]/','',$previous_agent_log_id);
$protocol = preg_replace('/[^-_0-9a-zA-Z]/','',$protocol);
$qm_dispo_code = preg_replace('/[^-_0-9a-zA-Z]/','',$qm_dispo_code);
$qm_extension = preg_replace("/\'|\"|\\\\|;/","",$qm_extension);
$qm_phone = preg_replace("/\'|\"|\\\\|;/","",$qm_phone);
$recipient = preg_replace('/[^-_0-9a-zA-Z]/','',$recipient);
$recording_filename = preg_replace("/\'|\"|\\\\|;/","",$recording_filename);
$recording_id = preg_replace('/[^0-9]/','',$recording_id);
$search = preg_replace('/[^-_0-9a-zA-Z]/','',$search);
$stage = preg_replace("/\'|\"|\\\\|;/","",$stage);
$start_epoch = preg_replace("/\'|\"|\\\\|;/","",$start_epoch);
$sub_status = preg_replace('/[^-_0-9a-zA-Z]/','',$sub_status);
$url_ids = preg_replace("/\'|\"|\\\\|;/","",$url_ids);
$use_campaign_dnc = preg_replace('/[^-_0-9a-zA-Z]/','',$use_campaign_dnc);
$use_internal_dnc = preg_replace('/[^-_0-9a-zA-Z]/','',$use_internal_dnc);
$usegroupalias = preg_replace('/[^0-9]/','',$usegroupalias);
$user_abb = preg_replace("/\'|\"|\\\\|;/","",$user_abb);
$vtiger_callback_id = preg_replace("/\'|\"|\\\\|;/","",$vtiger_callback_id);
$wrapup = preg_replace("/\'|\"|\\\\|;/","",$wrapup);
$url_link = preg_replace("/\'|\"|\\\\|;/","",$url_link);
$user_group = preg_replace('/[^-_0-9a-zA-Z]/','',$user_group);


# default optional vars if not set
if (!isset($format))   {$format="text";}
	if ($format == 'debug')	{$DB=1;}
if (!isset($ACTION))   {$ACTION="refresh";}
if (!isset($query_date)) {$query_date = $NOW_DATE;}
if (strlen($SSagent_debug_logging) > 1)
	{
	if ($SSagent_debug_logging == "$user")
		{$SSagent_debug_logging=1;}
	else
		{$SSagent_debug_logging=0;}
	}

$VUselected_language = $SSdefault_language;
$VUuser_new_lead_limit='-1';
$stmt="SELECT selected_language,user_new_lead_limit from vicidial_users where user='$user';";
if ($DB) {echo "|$stmt|\n";}
$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00598',$user,$server_ip,$session_name,$one_mysql_log);}
$sl_ct = mysqli_num_rows($rslt);
if ($sl_ct > 0)
	{
	$row=mysqli_fetch_row($rslt);
	$VUselected_language =		$row[0];
	$VUuser_new_lead_limit =	$row[1];
	}

if ($ACTION == 'LogiNCamPaigns')
	{
	$skip_user_validation=1;
	}
else
	{
	$auth=0;
	$auth_message = user_authorization($user,$pass,'',0,1,0,0);
	if ($auth_message == 'GOOD')
		{$auth=1;}

	if( (strlen($user)<2) or (strlen($pass)<2) or ($auth==0))
		{
		echo _QXZ("Invalid Username/Password:")." |$user|$pass|$auth_message|\n";
		exit;
		}
	else
		{
		if( (strlen($server_ip)<6) or (!isset($server_ip)) or ( (strlen($session_name)<12) or (!isset($session_name)) ) )
			{
			echo _QXZ("Invalid server_ip: %1s or Invalid session_name: %2s",0,'',$server_ip,$session_name)."\n";
			exit;
			}
		else
			{
			$stmt="SELECT count(*) from web_client_sessions where session_name='$session_name' and server_ip='$server_ip';";
			if ($DB) {echo "|$stmt|\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00003',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$SNauth=$row[0];
			  if($SNauth==0)
				{
				echo _QXZ("Invalid session_name:")." |$session_name|$server_ip|\n";
				exit;
				}
			  else
				{
				# do nothing for now
				}
			}
		}
	}

if ($format=='debug')
	{
	echo "<html>\n";
	echo "<head>\n";
	echo "<!-- VERSION: $version     BUILD: $build    USER: $user   server_ip: $server_ip-->\n";
	echo "<title>"._QXZ("VICIDiaL Database Query Script");
	echo "</title>\n";
	echo "</head>\n";
	echo "<BODY BGCOLOR=white marginheight=0 marginwidth=0 leftmargin=0 topmargin=0>\n";
	}



################################################################################
### LogiNCamPaigns - generates an HTML SELECT list of allowed campaigns for a 
###                  specific agent on the login screen
################################################################################
if ($ACTION == 'LogiNCamPaigns')
	{
	if ( (strlen($user)<1) )
		{
		echo "<select size=1 name=VD_campaign id=VD_campaign>\n";
		echo "<option value=\"\">-- ERROR --</option>\n";
		echo "</select>\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt="SELECT user_group,user_level,agent_shift_enforcement_override,shift_override_flag,user_choose_language from vicidial_users where user='$user' and api_only_user != '1';";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00004',$user,$server_ip,$session_name,$one_mysql_log);}
		$cl_user_ct = mysqli_num_rows($rslt);
		if ($cl_user_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$VU_user_group =						$row[0];
			$VU_user_level =						$row[1];
			$VU_agent_shift_enforcement_override =	$row[2];
			$VU_shift_override_flag =				$row[3];
			$VU_user_choose_language =				$row[4];

			$LOGallowed_campaignsSQL='';

			$stmt="SELECT allowed_campaigns,forced_timeclock_login,shift_enforcement,group_shifts,admin_viewable_groups from vicidial_user_groups where user_group='$VU_user_group';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00005',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$forced_timeclock_login =	$row[1];
			$shift_enforcement =		$row[2];
			$group_shifts =				$row[3];
			$admin_viewable_groups =	$row[4];
			$LOGgroup_shiftsSQL = preg_replace('/\s\s/','',$group_shifts);
			$LOGgroup_shiftsSQL = preg_replace('/\s/',"','",$LOGgroup_shiftsSQL);
			$LOGgroup_shiftsSQL = "shift_id IN('$LOGgroup_shiftsSQL')";
			if ( (!preg_match("/ALL-CAMPAIGNS/i",$row[0])) )
				{
				$LOGallowed_campaignsSQL = preg_replace('/\s-/i','',$row[0]);
				$LOGallowed_campaignsSQL = preg_replace('/\s/i',"','",$LOGallowed_campaignsSQL);
				$LOGallowed_campaignsSQL = "and campaign_id IN('$LOGallowed_campaignsSQL')";
				}
			$admin_viewable_groupsALL=0;
			$LOGadmin_viewable_groupsSQL='';
			$whereLOGadmin_viewable_groupsSQL='';
			$valLOGadmin_viewable_groupsSQL='';
			$vmLOGadmin_viewable_groupsSQL='';
			if ( (!preg_match('/\-\-ALL\-\-/i',$admin_viewable_groups)) and (strlen($admin_viewable_groups) > 3) )
				{
				$rawLOGadmin_viewable_groupsSQL = preg_replace("/ -/",'',$admin_viewable_groups);
				$rawLOGadmin_viewable_groupsSQL = preg_replace("/ /","','",$rawLOGadmin_viewable_groupsSQL);
				$LOGadmin_viewable_groupsSQL = "and user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
				$whereLOGadmin_viewable_groupsSQL = "where user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
				$valLOGadmin_viewable_groupsSQL = "and val.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
				$vmLOGadmin_viewable_groupsSQL = "and vm.user_group IN('---ALL---','$rawLOGadmin_viewable_groupsSQL')";
				}
			else 
				{$admin_viewable_groupsALL=1;}

			$show_campaign_list=1;
			### CHECK TO SEE IF AGENT IS LOGGED IN TO TIMECLOCK, IF NOT, OUTPUT ERROR
			if ( (preg_match('/Y/',$forced_timeclock_login)) or ( (preg_match('/ADMIN_EXEMPT/',$forced_timeclock_login)) and ($VU_user_level < 8) ) )
				{
				$last_agent_event='';
				$HHMM = date("Hi");
				$HHteod = substr($timeclock_end_of_day,0,2);
				$MMteod = substr($timeclock_end_of_day,2,2);

				if ($HHMM < $timeclock_end_of_day)
					{$EoD = mktime($HHteod, $MMteod, 10, date("m"), date("d")-1, date("Y"));}
				else
					{$EoD = mktime($HHteod, $MMteod, 10, date("m"), date("d"), date("Y"));}

				$EoDdate = date("Y-m-d H:i:s", $EoD);

				##### grab timeclock logged-in time for each user #####
				$stmt="SELECT event from vicidial_timeclock_log where user='$user' and event_epoch >= '$EoD' order by timeclock_id desc limit 1;";
				if ($DB>0) {echo "|$stmt|";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00184',$user,$server_ip,$session_name,$one_mysql_log);}
				$events_to_parse = mysqli_num_rows($rslt);
				if ($events_to_parse > 0)
					{
					$rowx=mysqli_fetch_row($rslt);
					$last_agent_event = $rowx[0];
					}
				if ( (strlen($last_agent_event)<2) or (preg_match('/LOGOUT/',$last_agent_event)) )
					{$show_campaign_list=0;}
				}
			### CHECK TO SEE IF LANGUAGES ARE ENABLED AND IF AGENT CAN CHOOSE THEM
			$show_language_list=0;

			if ($SSenable_languages == '1')
				{
				if ($SSlanguage_method != 'DISABLED')
					{
					if ($VU_user_choose_language == '1')
						{
						$show_language_list=1;
						}
					}
				}
			}
		else
			{
			echo "<select size=1 name=VD_campaign id=VD_campaign>\n";
			echo "<option value=\"\">-- "._QXZ("USER LOGIN ERROR")." --</option>\n";
			echo "</select>\n";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		}

	### CHECK TO SEE IF AGENT IS WITHIN THEIR SHIFT IF RESTRICTED, IF NOT, OUTPUT ERROR
	if ( ( (preg_match("/START|ALL/",$shift_enforcement)) and (!preg_match("/OFF/",$VU_agent_shift_enforcement_override)) ) or (preg_match("/START|ALL/",$VU_agent_shift_enforcement_override)) )
		{
		$shift_ok=0;
		if ( (strlen($LOGgroup_shiftsSQL) < 3) and ($VU_shift_override_flag < 1) )
			{
			$VDdisplayMESSAGE = "<B>ERROR: "._QXZ("There are no Shifts enabled for your user group")."</B>\n";
			$VDloginDISPLAY=1;
			}
		else
			{
			$HHMM = date("Hi");
			$wday = date("w");

			$stmt="SELECT shift_id,shift_start_time,shift_length,shift_weekdays from vicidial_shifts where $LOGgroup_shiftsSQL order by shift_id";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00193',$user,$server_ip,$session_name,$one_mysql_log);}
			$shifts_to_print = mysqli_num_rows($rslt);

			$o=0;
			while ( ($shifts_to_print > $o) and ($shift_ok < 1) )
				{
				$rowx=mysqli_fetch_row($rslt);
				$shift_id =			$rowx[0];
				$shift_start_time =	$rowx[1];
				$shift_length =		$rowx[2];
				$shift_weekdays =	$rowx[3];

				if (preg_match("/$wday/i",$shift_weekdays))
					{
					$HHshift_length = substr($shift_length,0,2);
					$MMshift_length = substr($shift_length,3,2);
					$HHshift_start_time = substr($shift_start_time,0,2);
					$MMshift_start_time = substr($shift_start_time,2,2);
					$HHshift_end_time = ($HHshift_length + $HHshift_start_time);
					$MMshift_end_time = ($MMshift_length + $MMshift_start_time);
					if ($MMshift_end_time > 59)
						{
						$MMshift_end_time = ($MMshift_end_time - 60);
						$HHshift_end_time++;
						}
					if ($HHshift_end_time > 23)
						{$HHshift_end_time = ($HHshift_end_time - 24);}
					$HHshift_end_time = sprintf("%02s", $HHshift_end_time);	
					$MMshift_end_time = sprintf("%02s", $MMshift_end_time);	
					$shift_end_time = "$HHshift_end_time$MMshift_end_time";

					if ( 
						( ($HHMM >= $shift_start_time) and ($HHMM < $shift_end_time) ) or
						( ($HHMM < $shift_start_time) and ($HHMM < $shift_end_time) and ($shift_end_time <= $shift_start_time) ) or
						( ($HHMM >= $shift_start_time) and ($HHMM >= $shift_end_time) and ($shift_end_time <= $shift_start_time) )
					   )
						{$shift_ok++;}
					}
				$o++;
				}

			if ( ($shift_ok < 1) and ($VU_shift_override_flag < 1) )
				{
				$VDdisplayMESSAGE = "<B>ERROR: "._QXZ("You are not allowed to log in outside of your shift")."</B>\n";
				$VDloginDISPLAY=1;
				}
			}
		if ($VDloginDISPLAY > 0)
			{
			$loginDATE = date("Ymd");
			$VDdisplayMESSAGE.= "<BR><BR>"._QXZ("MANAGER OVERRIDE:")."<BR>\n";
			$VDdisplayMESSAGE.= "<FORM ACTION=\"$PHP_SELF\" METHOD=POST>\n";
			$VDdisplayMESSAGE.= "<INPUT TYPE=HIDDEN NAME=MGR_override VALUE=\"1\">\n";
			$VDdisplayMESSAGE.= "<INPUT TYPE=HIDDEN NAME=relogin VALUE=\"YES\">\n";
			$VDdisplayMESSAGE.= "<INPUT TYPE=HIDDEN NAME=VD_login VALUE=\"$user\">\n";
			$VDdisplayMESSAGE.= "<INPUT TYPE=HIDDEN NAME=VD_pass VALUE=\"$pass\">\n";
			$VDdisplayMESSAGE.= _QXZ("Manager Login:")." <INPUT TYPE=TEXT NAME=\"MGR_login$loginDATE\" SIZE=10 MAXLENGTH=20><br>\n";
			$VDdisplayMESSAGE.= _QXZ("Manager Password:")." <INPUT TYPE=PASSWORD NAME=\"MGR_pass$loginDATE\" SIZE=10 MAXLENGTH=20><br>\n";
			$VDdisplayMESSAGE.= "<INPUT TYPE=submit NAME=SUBMIT VALUE="._QXZ("SUBMIT")."></FORM><BR><BR><BR><BR>\n";
			echo "$VDdisplayMESSAGE";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		}

	if ($show_campaign_list > 0)
		{
		$stmt="SELECT campaign_id,campaign_name from vicidial_campaigns where active='Y' $LOGallowed_campaignsSQL order by campaign_id";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00006',$user,$server_ip,$session_name,$one_mysql_log);}
		$camps_to_print = mysqli_num_rows($rslt);

		echo "<select size=1 name=VD_campaign id=VD_campaign>\n";
		echo "<option value=\"\">-- "._QXZ("PLEASE SELECT A CAMPAIGN")." --</option>\n";

		$o=0;
		$campSELECTED=0;
		while ($camps_to_print > $o) 
			{
			$rowx=mysqli_fetch_row($rslt);
			echo "<option value=\"$rowx[0]\"";
			if ($VD_campaign == "$rowx[0]") {echo " SELECTED"; $campSELECTED++;}
			echo ">$rowx[0] - $rowx[1]</option>\n";
			$o++;
			}
		echo "</select>\n";
		if ($show_language_list > 0)
			{
			echo "<BR> &nbsp; &nbsp; &nbsp; "._QXZ("Language").":<BR>\n";
			$stmt="SELECT language_id,language_description from vicidial_languages where active='Y' $LOGadmin_viewable_groupsSQL order by language_id";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00599',$user,$server_ip,$session_name,$one_mysql_log);}
			$langs_to_print = mysqli_num_rows($rslt);

			echo "<select size=1 name=VD_language id=VD_language>\n";
			echo "<option value=\"\">-- "._QXZ("PLEASE SELECT A LANGUAGE")." --</option>\n";

			$o=0;
			$langSELECTED=0;
			while ($langs_to_print > $o) 
				{
				$rowx=mysqli_fetch_row($rslt);
				echo "<option value=\"$rowx[0]\"";
				if ($VUselected_language == "$rowx[0]") {echo " SELECTED"; $langSELECTED++;}
				echo ">$rowx[0] - $rowx[1]</option>\n";
				$o++;
				}
			echo "<option value=\"default English\"";
			if ($langSELECTED < 1) {echo " SELECTED"; $langSELECTED++;}
			echo ">default English</option>\n";
			echo "</select>\n";
			}
		}
	else
		{
		echo "<select size=1 name=VD_campaign id=VD_campaign>\n";
		echo "<option value=\"\">-- "._QXZ("YOU MUST LOG IN TO THE TIMECLOCK FIRST")." --</option>\n";
		echo "</select>\n";
		}
	if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
	exit;
	}



################################################################################
### regCLOSER - update the vicidial_live_agents table to reflect the closer
###             inbound choices made upon login
################################################################################
if ($ACTION == 'regCLOSER')
	{
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($closer_choice)<1) || (strlen($user)<1) )
		{
		$channel_live=0;
		echo _QXZ("Group Choice is not valid").": $closer_choice\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$orig_closer_choice = $closer_choice;
		$stmt = "SELECT max_inbound_calls FROM vicidial_users where user='$user';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00587',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($format=='debug') {echo "\n<!-- $rowx[0]|$stmt -->";}
		$vumic_ct = mysqli_num_rows($rslt);
		if ($vumic_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$VU_max_inbound_calls =		$row[0];
			}
		$stmt = "SELECT max_inbound_calls,max_inbound_calls_outcome FROM vicidial_campaigns where campaign_id='$campaign';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00589',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($format=='debug') {echo "\n<!-- $rowx[0]|$stmt -->";}
		$vcmic_ct = mysqli_num_rows($rslt);
		if ($vcmic_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$CP_max_inbound_calls =			$row[0];
			$max_inbound_calls_outcome =	$row[1];
			}

		if ( ($VU_max_inbound_calls > 0) or ($CP_max_inbound_calls > 0) )
			{
			$max_inbound_calls = $CP_max_inbound_calls;
			if ($VU_max_inbound_calls > 0)
				{$max_inbound_calls = $VU_max_inbound_calls;}

			$stmt = "SELECT sum(calls_today) FROM vicidial_inbound_group_agents where user='$user' and group_type='C';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00588',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($format=='debug') {echo "\n<!-- $rowx[0]|$stmt -->";}
			$vigagt_ct = mysqli_num_rows($rslt);
			if ($vigagt_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$max_inbound_count =		$row[0];

				if ($max_inbound_count >= $max_inbound_calls)
					{$closer_choice = "MAXLOCK-";}
				}
			}

		if ($closer_blended > 0)
			{$vla_autodial = 'Y';}
		else
			{$vla_autodial = 'N';}
		if (preg_match('/INBOUND_MAN|MANUAL/',$dial_method))
			{$vla_autodial = 'N';}

		$standard_closer_update=1;
		if ( ($closer_choice == "MGRLOCK-") or ($closer_choice == "MAXLOCK-") )
			{
			$standard_closer_update=0;
			if ($closer_choice == "MAXLOCK-")
				{
				if (preg_match("/ALLOW_AGENTDIRECT/",$max_inbound_calls_outcome))
					{
					$standard_closer_update=1;
					
					$ADcloser_campaigns = preg_replace("/^ | -$/",'',$orig_closer_choice);
					$ADcloser_campaignsARY = explode(" ",$ADcloser_campaigns);
					$ADcloser_campaignsARYct = count($ADcloser_campaignsARY);
					$ADc=0;
					$ADcloser_campaigns='';
					while ($ADc < $ADcloser_campaignsARYct)
						{
						if (preg_match("/AGENTDIRECT/i",$ADcloser_campaignsARY[$ADc]))
							{$ADcloser_campaigns .= "$ADcloser_campaignsARY[$ADc] ";}
						$ADc++;
						}
					if (strlen($ADcloser_campaigns) > 3)
						{$ADcloser_campaigns = " ".$ADcloser_campaigns."-";}
					else
						{$ADcloser_campaigns = " -";}
					$closer_choice = $ADcloser_campaigns;
					}
				else
					{$closer_choice = " -";}
				}
			else
				{
				$stmt="SELECT closer_campaigns FROM vicidial_users where user='$user' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00007',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$user_choice =$row[0];
				$user_choice = preg_replace("/ -$|^ /","",$user_choice);
				$user_choice = preg_replace("/ /","','",$user_choice);
				$user_choice = "'$user_choice'";

				$stmt="SELECT closer_campaigns FROM vicidial_campaigns where campaign_id='$campaign' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00536',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$camp_choice =$row[0];
				$camp_choice = preg_replace("/ -$|^ /","",$camp_choice);
				$camp_choice = preg_replace("/ /","','",$camp_choice);
				$camp_choice = "'$camp_choice'";

				$stmt = "SELECT group_id FROM vicidial_inbound_groups where group_id IN($user_choice) and group_id IN($camp_choice) and active='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00537',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$gid_ct = mysqli_num_rows($rslt);
				$i=0;
				$closer_choice='';
				while ($i < $gid_ct)
					{
					$row=mysqli_fetch_row($rslt);
					$closer_choice .=	" $row[0]";
					$i++;
					}
				$closer_choice .=	" -";
				}

			$stmt="UPDATE vicidial_live_agents set closer_campaigns='$closer_choice',last_state_change='$NOW_TIME',outbound_autodial='$vla_autodial' where user='$user' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00008',$user,$server_ip,$session_name,$one_mysql_log);}
			}
		if ($standard_closer_update > 0)
			{
			$stmt="UPDATE vicidial_live_agents set closer_campaigns='$closer_choice',last_state_change='$NOW_TIME',outbound_autodial='$vla_autodial' where user='$user' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00009',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmt="UPDATE vicidial_users set closer_campaigns='$closer_choice' where user='$user';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00010',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		$stmt="INSERT INTO vicidial_user_closer_log set user='$user',campaign_id='$campaign',event_date='$NOW_TIME',blended='$closer_blended',closer_campaigns='$closer_choice';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00011',$user,$server_ip,$session_name,$one_mysql_log);}

		$stmt="DELETE FROM vicidial_live_inbound_agents where user='$user';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00012',$user,$server_ip,$session_name,$one_mysql_log);}

		#############################################
		##### START QUEUEMETRICS LOGGING LOOKUP #####
		$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_addmember_enabled,queuemetrics_dispo_pause,queuemetrics_pe_phone_append,queuemetrics_pause_type FROM system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00349',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($format=='debug') {echo "\n<!-- $rowx[0]|$stmt -->";}
		$qm_conf_ct = mysqli_num_rows($rslt);
		$i=0;
		while ($i < $qm_conf_ct)
			{
			$row=mysqli_fetch_row($rslt);
			$enable_queuemetrics_logging =		$row[0];
			$queuemetrics_server_ip	=			$row[1];
			$queuemetrics_dbname =				$row[2];
			$queuemetrics_login	=				$row[3];
			$queuemetrics_pass =				$row[4];
			$queuemetrics_log_id =				$row[5];
			$queuemetrics_addmember_enabled =	$row[6];
			$queuemetrics_dispo_pause =			$row[7];
			$queuemetrics_pe_phone_append =		$row[8];
			$queuemetrics_pause_type =			$row[9];
			$i++;
			}
		##### END QUEUEMETRICS LOGGING LOOKUP #####
		###########################################
		if ( ($enable_queuemetrics_logging > 0) and ($queuemetrics_addmember_enabled > 0) )
			{
			$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
			if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
			mysqli_select_db($linkB, "$queuemetrics_dbname");
			}

		$in_groups_pre = preg_replace('/-$/','',$closer_choice);
		$in_groups = explode(" ",$in_groups_pre);
		$in_groups_ct = count($in_groups);
		$k=1;
		while ($k < $in_groups_ct)
			{
			if (strlen($in_groups[$k])>1)
				{
				$stmt="SELECT group_weight,calls_today,group_grade FROM vicidial_inbound_group_agents where user='$user' and group_id='$in_groups[$k]';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00013',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$viga_ct = mysqli_num_rows($rslt);
				if ($viga_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$group_weight =	$row[0];
					$calls_today =	$row[1];
					$group_grade =	$row[2];
					}
				else
					{
					$group_weight = 0;
					$calls_today =	0;
					$group_grade = 1;
					}
				$stmt="INSERT INTO vicidial_live_inbound_agents set user='$user',group_id='$in_groups[$k]',group_weight='$group_weight',calls_today='$calls_today',last_call_time='$NOW_TIME',last_call_finish='$NOW_TIME',group_grade='$group_grade';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00014',$user,$server_ip,$session_name,$one_mysql_log);}

				if ( ($enable_queuemetrics_logging > 0) and ($queuemetrics_addmember_enabled > 0) )
					{
					$data4SQL='';
					$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00388',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cqpe_ct = mysqli_num_rows($rslt);
					if ($cqpe_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$pe_append='';
						if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
							{$pe_append = "-$qm_extension";}
						$data4SQL = ",data4='$row[0]$pe_append'";
						}

					$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='$in_groups[$k]',agent='Agent/$user',verb='ADDMEMBER2',data1='$qm_phone',serverid='$queuemetrics_log_id' $data4SQL;";
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00350',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($linkB);
					if ($format=='debug') {echo "\n<!-- $affected_rows|$stmt -->";}
					}

				}
			$k++;
			}

		}
	echo _QXZ("Closer In Group Choice %1s has been registered to user %2s",0,'',$closer_choice,$user)."\n";
	$stage = "$vla_autodial|$closer_choice";
	}





#################################################################################
### regTERRITORY - update the vicidial_live_agents table to reflect the territory
###                choices made upon login or while paused  (agent_territories)
#################################################################################
if ($ACTION == 'regTERRITORY')
	{
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($agent_territories)<1) || (strlen($user)<1) )
		{
		$channel_live=0;
		echo _QXZ("Territory Choice is not valid")."$agent_territories\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		if (preg_match("/^MGRLOCK/",$agent_territories))
			{
			$stmt="SELECT territory FROM vicidial_user_territories where user='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00253',$user,$server_ip,$session_name,$one_mysql_log);}
			$territories_ct = mysqli_num_rows($rslt);
			if ($DB) {echo "$territories_ct|$stmt\n";}
			$k=0;
			$agent_territories='';
			while ($territories_ct > $k)
				{
				$row=mysqli_fetch_row($rslt);
				$agent_territories .=	" $row[0]";
				$k++;
				}
			$agent_territories .= " -";

			$stmt="UPDATE vicidial_live_agents set agent_territories='$agent_territories',last_state_change='$NOW_TIME' where user='$user' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00254',$user,$server_ip,$session_name,$one_mysql_log);}
			}
		else
			{
			$stmt="UPDATE vicidial_live_agents set agent_territories='$agent_territories',last_state_change='$NOW_TIME' where user='$user' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00255',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		$stmt="INSERT INTO vicidial_user_territory_log set user='$user',campaign_id='$campaign',event_date='$NOW_TIME',agent_territories='$agent_territories';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00256',$user,$server_ip,$session_name,$one_mysql_log);}
		}
	echo _QXZ("Territory Choice %1s has been registered to user %2s",0,'',$agent_territories,$user)."\n";
	$stage = $agent_territories;
	}





################################################################################
### For every process below, lookup the current agent_log_id for the user
################################################################################
$stmt="SELECT agent_log_id from vicidial_live_agents where user='$user';";
$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00222',$user,$server_ip,$session_name,$one_mysql_log);}
$users_to_parse = mysqli_num_rows($rslt);
if ($users_to_parse > 0) 
	{
	$rowx=mysqli_fetch_row($rslt);
	if ($rowx[0] > 0) {$agent_log_id = $rowx[0];}
	}



################################################################################
### UpdateFields - sends current vicidial_list values for fields
################################################################################
if ($ACTION == 'UpdateFields')
	{
	$stmt="UPDATE vicidial_live_agents set external_update_fields='0',external_update_fields_data='' where user='$user';";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00276',$user,$server_ip,$session_name,$one_mysql_log);}

	$stmt="SELECT lead_id from vicidial_live_agents where user='$user';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00274',$user,$server_ip,$session_name,$one_mysql_log);}
	$vla_records = mysqli_num_rows($rslt);
	if ($vla_records > 0) 
		{
		$rowx=mysqli_fetch_row($rslt);
		if ($rowx[0] > 0) {$lead_id = $rowx[0];}
                ### ADDED BY POUNDTEAM FOR AUDITED COMMENTS! acquire audited comment count for this lead
		$stmt="SELECT count(comment_id) as comment_count FROM vicidial_comments where lead_id='$lead_id' and hidden is null";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00275',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$row=mysqli_fetch_row($rslt);
                $lead_comment_count		= trim("$row[0]");

		##### grab the data from vicidial_list for the lead_id
		$stmt="SELECT vendor_lead_code,source_id,gmt_offset_now,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,rank,owner,entry_date FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00546',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$list_lead_ct = mysqli_num_rows($rslt);
		if ($list_lead_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$vendor_id		= trim("$row[0]");
			$source_id		= trim("$row[1]");
			$gmt_offset_now	= trim("$row[2]");
			$phone_code		= trim("$row[3]");
			$phone_number	= trim("$row[4]");
			$title			= trim("$row[5]");
			$first_name		= trim("$row[6]");
			$middle_initial	= trim("$row[7]");
			$last_name		= trim("$row[8]");
			$address1		= trim("$row[9]");
			$address2		= trim("$row[10]");
			$address3		= trim("$row[11]");
			$city			= trim("$row[12]");
			$state			= trim("$row[13]");
			$province		= trim("$row[14]");
			$postal_code	= trim("$row[15]");
			$country_code	= trim("$row[16]");
			$gender			= trim("$row[17]");
			$date_of_birth	= trim("$row[18]");
			$alt_phone		= trim("$row[19]");
			$email			= trim("$row[20]");
			$security_phrase	= trim("$row[21]");
			$comments		= stripslashes(trim("$row[22]"));
			$rank			= trim("$row[23]");
			$owner			= trim("$row[24]");
			$entry_date		= trim("$row[25]");

			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);

			$LeaD_InfO  =	"GOOD\n";
			$LeaD_InfO .=	$vendor_id . "\n";
			$LeaD_InfO .=	$source_id . "\n";
			$LeaD_InfO .=	$gmt_offset_now . "\n";
			$LeaD_InfO .=	$phone_code . "\n";
			$LeaD_InfO .=	$phone_number . "\n";
			$LeaD_InfO .=	$title . "\n";
			$LeaD_InfO .=	$first_name . "\n";
			$LeaD_InfO .=	$middle_initial . "\n";
			$LeaD_InfO .=	$last_name . "\n";
			$LeaD_InfO .=	$address1 . "\n";
			$LeaD_InfO .=	$address2 . "\n";
			$LeaD_InfO .=	$address3 . "\n";
			$LeaD_InfO .=	$city . "\n";
			$LeaD_InfO .=	$state . "\n";
			$LeaD_InfO .=	$province . "\n";
			$LeaD_InfO .=	$postal_code . "\n";
			$LeaD_InfO .=	$country_code . "\n";
			$LeaD_InfO .=	$gender . "\n";
			$LeaD_InfO .=	$date_of_birth . "\n";
			$LeaD_InfO .=	$alt_phone . "\n";
			$LeaD_InfO .=	$email . "\n";
			$LeaD_InfO .=	$security_phrase . "\n";
			$LeaD_InfO .=	$comments . "\n";
			$LeaD_InfO .=	$rank . "\n";
			$LeaD_InfO .=	$owner . "\n";
			$LeaD_InfO .=	$lead_comment_count . "\n";
			$LeaD_InfO .=	"\n";

			echo $LeaD_InfO;
			}
		else
			{
			echo "ERROR: "._QXZ("no lead info in system:")." $lead_id\n";
			}
		}
	else
		{
		echo "ERROR: "._QXZ("no lead active for this agent")."\n";
		}
	}


################################################################################
### update_settings - sends current vicidial_user and vicidial_campaigns settings
################################################################################
if ($ACTION == 'update_settings')
	{
	$SettingS_InfO='';
	$stmt="SELECT count(*) from vicidial_live_agents where user='$user';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00592',$user,$server_ip,$session_name,$one_mysql_log);}
	$vla_records = mysqli_num_rows($rslt);
	if ($vla_records > 0) 
		{
		$rowx=mysqli_fetch_row($rslt);
		$agent_count = $rowx[0];
		$SettingS_InfO .=	"Agent Session: $agent_count\n";

		##### grab the data from vicidial_users for the user
		$stmt="SELECT wrapup_seconds_override FROM vicidial_users where user='$user' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00593',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$user_set_ct = mysqli_num_rows($rslt);
		if ($user_set_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$wrapup_seconds_override =		trim("$row[0]");


			##### grab the data from vicidial_campaigns for the campaign
			$stmt="SELECT wrapup_seconds,dead_max,dispo_max,pause_max,dead_max_dispo,dispo_max_dispo,dial_timeout,wrapup_bypass,wrapup_message,wrapup_after_hotkey,manual_dial_timeout FROM vicidial_campaigns where campaign_id='$campaign' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00594',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$camp_set_ct = mysqli_num_rows($rslt);
			if ($camp_set_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$wrapup_seconds =		trim("$row[0]");
				$dead_max =				trim("$row[1]");
				$dispo_max =			trim("$row[2]");
				$pause_max =			trim("$row[3]");
				$dead_max_dispo =		trim("$row[4]");
				$dispo_max_dispo =		trim("$row[5]");
				$dial_timeout =			trim("$row[6]");
				$wrapup_bypass =		trim("$row[7]");
				$wrapup_message =		trim("$row[8]");
				$wrapup_after_hotkey =	trim("$row[9]");
				$manual_dial_timeout =	trim("$row[10]");
				}

			if ( ($manual_dial_timeout < 1) or (strlen($manual_dial_timeout) < 1) )
				{$manual_dial_timeout = $dial_timeout;}
			if ($wrapup_seconds_override >= 0)
				{$wrapup_seconds = $wrapup_seconds_override;}
			if ( ($pause_max < 10) or (strlen($pause_max)<2) )
				{$pause_max=0;}
			if ( ($pause_max > 9) and ($pause_max <= $dial_timeout) )
				{$pause_max = ($dial_timeout + 10);}

			$SettingS_InfO .=	"SETTINGS GATHERED\n";
			$SettingS_InfO .=	"wrapup_seconds: " . $wrapup_seconds . "\n";
			$SettingS_InfO .=	"dead_max: " . $dead_max . "\n";
			$SettingS_InfO .=	"dispo_max: " . $dispo_max . "\n";
			$SettingS_InfO .=	"pause_max: " . $pause_max . "\n";
			$SettingS_InfO .=	"dead_max_dispo: " . $dead_max_dispo . "\n";
			$SettingS_InfO .=	"dispo_max_dispo: " . $dispo_max_dispo . "\n";
			$SettingS_InfO .=	"dial_timeout: " . $dial_timeout . "\n";
			$SettingS_InfO .=	"wrapup_bypass: " . $wrapup_bypass . "\n";
			$SettingS_InfO .=	"wrapup_message: " . $wrapup_message . "\n";
			$SettingS_InfO .=	"wrapup_after_hotkey: " . $wrapup_after_hotkey . "\n";
			$SettingS_InfO .=	"manual_dial_timeout: " . $manual_dial_timeout . "\n";
			$SettingS_InfO .=	"\n";
			}
		echo $SettingS_InfO;
		}
	else
		{
		echo "ERROR: "._QXZ("no agent session")."\n";
		}
	}


################################################################################
### manDiaLnextCaLL - for manual VICIDiaL dialing this will grab the next lead
###                   in the campaign, reserve it, send data back to client and
###                   place the call by inserting into vicidial_manager
################################################################################
if ($ACTION == 'manDiaLnextCaLL')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$override_dial_number='';
	$channel_live=1;
	$MDF_search_flag='MAIN';
	$lead_id = preg_replace("/[^0-9]/","",$lead_id);
	if ( (strlen($conf_exten)<1) || (strlen($campaign)<1)  || (strlen($ext_context)<1) )
		{
		$channel_live=0;
		echo "HOPPER EMPTY\n";
		echo _QXZ("Conf Exten %1s or campaign %2s or ext_context %3s is not valid",0,'',$conf_exten,$campaign,$ext_context)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		##### grab number of calls today in this campaign and increment
		$eac_phone='';
		$stmt="SELECT calls_today,extension,external_dial,status FROM vicidial_live_agents WHERE user='$user' and campaign_id='$campaign';";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00015',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$vla_cc_ct = mysqli_num_rows($rslt);
		if ($vla_cc_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$calls_today =	$row[0];
			$eac_phone =	$row[1];
			$ed_vla =		$row[2];
			$vla_status =	$row[3];
			}
		else
			{$calls_today ='0';}
		$calls_today++;

		if (preg_match("/^MANUALNEXT/",$ed_vla))
			{
			$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00544',$user,$server_ip,$session_name,$one_mysql_log);}
			$VLAEDXaffected_rows = mysqli_affected_rows($link);
			}

		$script_recording_delay=0;
		##### find if script contains recording fields
		$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_campaigns vc WHERE campaign_id='$campaign' and vs.script_id=vc.campaign_script and script_text LIKE \"%--A--recording_%\";";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00257',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$vs_vc_ct = mysqli_num_rows($rslt);
		if ($vs_vc_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$script_recording_delay = $row[0];
			}

		$lead_id_defined=0;
		### check if this is a callback, if it is, skip the grabbing of a new lead and mark the callback as INACTIVE
		if ( (strlen($callback_id)>0) and (strlen($lead_id)>0) )
			{
			$affected_rows=1;
			$CBleadIDset=1;

			$stmt = "UPDATE vicidial_callbacks set status='INACTIVE' where callback_id='$callback_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00016',$user,$server_ip,$session_name,$one_mysql_log);}
			$lead_id_defined++;
			}
		### check if this is a specific lead call, if it is, skip the grabbing of a new lead
		elseif (strlen($lead_id)>0)
			{
			$affected_rows=1;
			$CBleadIDset=1;

			if (strlen($phone_number) > 5)
				{$override_dial_number = $phone_number;}
			else
				{
				##### gather phone number from the lead to be called if not supplied
				$stmt="SELECT phone_number FROM vicidial_list where lead_id='$lead_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00534',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$lid_chk_ct = mysqli_num_rows($rslt);
				if ($lid_chk_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$phone_number =			$row[0];
					}
				}
			$lead_id_defined++;
			}

		### BEGIN lookup of lead or flag for insert ###
		$lookup_empty_insert_lead=0;
		if ($lead_id_defined < 1)
			{
			if (strlen($phone_number)>3)
				{
				if ($stage=='lookup')
					{
					$manual_dial_search_filterSQL='';
					if (preg_match("/CAMPLISTS/",$manual_dial_search_filter))
						{
						$stmt="SELECT list_id,active from vicidial_lists where campaign_id='$campaign'";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00019',$user,$server_ip,$session_name,$one_mysql_log);}
						$lists_to_parse = mysqli_num_rows($rslt);
						$Scamp_lists='';
						$o=0;
						while ($lists_to_parse > $o) 
							{
							$rowx=mysqli_fetch_row($rslt);
							if (preg_match("/Y/", $rowx[1])) {$active_lists++;   $Scamp_lists .= "'$rowx[0]',";}
							if (preg_match("/ALL/",$manual_dial_search_filter))
								{
								if (preg_match("/N/", $rowx[1])) 
									{$inactive_lists++; $Scamp_lists .= "'$rowx[0]',";}
								}
							else
								{
								if (preg_match("/N/", $rowx[1])) 
									{$inactive_lists++;}
								}
							$o++;
							}
						$Scamp_lists = preg_replace("/.$/i","",$Scamp_lists);
						if (strlen($Scamp_lists)<2) {$Scamp_lists="''";}
						$manual_dial_search_filterSQL = "and list_id IN($Scamp_lists)";
						}
					if (strlen($vendor_lead_code)>0)
						{
						$stmt="SELECT lead_id FROM vicidial_list where vendor_lead_code=\"$vendor_lead_code\" $manual_dial_search_filterSQL order by modify_date desc LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00021',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$man_leadID_ct = mysqli_num_rows($rslt);
						if ( ($man_leadID_ct > 0) and (strlen($phone_number) > 5) )
							{$override_phone++;}
						}
					else
						{
						$stmt="SELECT lead_id FROM vicidial_list where phone_number='$phone_number' $manual_dial_search_filterSQL order by modify_date desc LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00362',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$man_leadID_ct = mysqli_num_rows($rslt);

						if ( ($man_leadID_ct < 1) and (preg_match("/WITH_ALT/",$manual_dial_search_filter)) )
							{
							$stmt="SELECT lead_id FROM vicidial_list where alt_phone='$phone_number' $manual_dial_search_filterSQL order by modify_date desc LIMIT 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00617',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$man_leadID_ct = mysqli_num_rows($rslt);
							if ($man_leadID_ct > 0) {$MDF_search_flag='ALT';   $agent_dialed_type='ALT';}

							if ( ($man_leadID_ct < 1) and (preg_match("/WITH_ALT_ADDR3/",$manual_dial_search_filter)) )
								{
								$stmt="SELECT lead_id FROM vicidial_list where address3='$phone_number' $manual_dial_search_filterSQL order by modify_date desc LIMIT 1;";
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00618',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$man_leadID_ct = mysqli_num_rows($rslt);
								if ($man_leadID_ct > 0) {$MDF_search_flag='ADDR3';   $agent_dialed_type='ADDR3';}
								}
							}
						}
					if ($man_leadID_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$affected_rows=1;
						$lead_id =$row[0];
						$CBleadIDset=1;
						}
					else
						{
						$lookup_empty_insert_lead++;
						}
					}
				else
					{
					$lookup_empty_insert_lead++;
					}
				}
			}
		### END lookup of lead or flag for insert ###

		if (strlen($phone_number)>3)
			{
			### BEGIN check for manual dial filtering ###
			if (preg_match("/ENABLED/",$manual_dial_call_time_check))
				{
				$secX = date("U");
				$hour = date("H");
				$min = date("i");
				$sec = date("s");
				$mon = date("m");
				$mday = date("d");
				$year = date("Y");
				$isdst = date("I");
				$Shour = date("H");
				$Smin = date("i");
				$Ssec = date("s");
				$Smon = date("m");
				$Smday = date("d");
				$Syear = date("Y");
				$pulldate0 = "$year-$mon-$mday $hour:$min:$sec";
				$inSD = $pulldate0;
				$dsec = ( ( ($hour * 3600) + ($min * 60) ) + $sec );

				$postalgmt='';
				$postal_code='';
				$state='';
				if (strlen($phone_code)<1)
					{$phone_code=$default_phone_code;}

				$local_call_time='24hours';
				##### gather local call time setting from campaign
				$stmt="SELECT local_call_time FROM vicidial_campaigns where campaign_id='$campaign';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00353',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$camp_lct_ct = mysqli_num_rows($rslt);
				if ($camp_lct_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$local_call_time =			$row[0];
					}

				### get current gmt_offset of the phone_number
				$USarea = substr($phone_number, 0, 3);
				$gmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmt,$postal_code);

				#################################
				### Get list_id for lead
				if ($lookup_empty_insert_lead > 0)
					{
					$lead_list_id = $list_id;
					}
				else
					{
					$stmt="SELECT list_id,state FROM vicidial_list where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00600',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$row=mysqli_fetch_row($rslt);
					$lead_list_id =	$row[0];
					$state =		$row[1];
					}
				
				### Get local_call_time for list
				$stmt="SELECT local_call_time,list_description FROM vicidial_lists where list_id='$lead_list_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00601',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$list_local_call_time =	$row[0];
				$list_description =		$row[1];

				# check that call time exists
				if ($list_local_call_time != "campaign") 
					{
					$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$list_local_call_time';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00612',$user,$server_ip,$session_name,$one_mysql_log);}					
					$row=mysqli_fetch_row($rslt);
					$call_time_exists  =	$row[0];
					if ($call_time_exists < 1) 
						{$list_local_call_time = 'campaign';}
					}

				#Check if we are with the gmt for campaign
				if( (dialable_gmt($DB,$link,$local_call_time,$gmt_offset,$state) == 1) and ($list_local_call_time != "campaign") )
					{
					#Now check if we are with the GMT for the list
					$dialable = dialable_gmt($DB,$link,$list_local_call_time,$gmt_offset,$state);
					}
				else 
					{
					$dialable = dialable_gmt($DB,$link,$local_call_time,$gmt_offset,$state);
					}
				$affected_rows = $dialable;
				#################################
				if ($dialable < 1)
					{
					### purge from the dial queue and api
					$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00354',$user,$server_ip,$session_name,$one_mysql_log);}
					$VMDQaffected_rows = mysqli_affected_rows($link);

					$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00355',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAEDaffected_rows = mysqli_affected_rows($link);

					echo "OUTSIDE OF LOCAL CALL TIME   $VMDQaffected_rows|$VLAEDaffected_rows\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				}

			### BEGIN DNC manual dial filtering ###
			# legacy, use campaign DNC settings(internal and campaign DNC lists)

			if ( (preg_match("/DNC/",$manual_dial_filter)) and (!preg_match("/CAMPDNC_ONLY/",$manual_dial_filter)) and (!preg_match("/INTERNALDNC_ONLY/",$manual_dial_filter)) )
				{
				if (preg_match("/AREACODE/",$use_internal_dnc))
					{
					$phone_number_areacode = substr($phone_number, 0, 3);
					$phone_number_areacode .= "XXXXXXX";
					$stmt="SELECT count(*) from vicidial_dnc where phone_number IN('$phone_number','$phone_number_areacode');";
					}
				else
					{$stmt="SELECT count(*) FROM vicidial_dnc where phone_number='$phone_number';";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00017',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					### purge from the dial queue and api
					$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00356',$user,$server_ip,$session_name,$one_mysql_log);}
					$VMDQaffected_rows = mysqli_affected_rows($link);

					$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00357',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAEDaffected_rows = mysqli_affected_rows($link);

					echo "DNC NUMBER\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
					{
					$stmt="SELECT use_other_campaign_dnc from vicidial_campaigns where campaign_id='$campaign';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00445',$user,$server_ip,$session_name,$one_mysql_log);}
					$row=mysqli_fetch_row($rslt);
					$use_other_campaign_dnc =	$row[0];
					$temp_campaign_id = $campaign;
					if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}

					if (preg_match("/AREACODE/",$use_campaign_dnc))
						{
						$phone_number_areacode = substr($phone_number, 0, 3);
						$phone_number_areacode .= "XXXXXXX";
						$stmt="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$phone_number','$phone_number_areacode') and campaign_id='$temp_campaign_id';";
						}
					else
						{$stmt="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$phone_number' and campaign_id='$temp_campaign_id';";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00018',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$row=mysqli_fetch_row($rslt);
					if ($row[0] > 0)
						{
						### purge from the dial queue and api
						$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00358',$user,$server_ip,$session_name,$one_mysql_log);}
						$VMDQaffected_rows = mysqli_affected_rows($link);

						$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00359',$user,$server_ip,$session_name,$one_mysql_log);}
						$VLAEDaffected_rows = mysqli_affected_rows($link);

						echo "DNC NUMBER\n";
						if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
						exit;
						}
					}
				}

			# ignore campaign DNC settings use only campaign DNC lists
			if (preg_match("/CAMPDNC/",$manual_dial_filter))
				{
				$temp_campaign_id = $campaign;
				if (preg_match("/AREACODE/",$use_campaign_dnc))
					{
					$phone_number_areacode = substr($phone_number, 0, 3);
					$phone_number_areacode .= "XXXXXXX";
					$stmt="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$phone_number','$phone_number_areacode') and campaign_id='$temp_campaign_id';";
					}
				else
					{$stmt="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$phone_number' and campaign_id='$temp_campaign_id';";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00018',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					### purge from the dial queue and api
					$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00358',$user,$server_ip,$session_name,$one_mysql_log);}
					$VMDQaffected_rows = mysqli_affected_rows($link);

					$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00359',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAEDaffected_rows = mysqli_affected_rows($link);

					echo "DNC NUMBER\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				}

			# ignore campaign DNC settings use only internal DNC list
			if (preg_match("/INTERNALDNC/",$manual_dial_filter))
				{
				if (preg_match("/AREACODE/",$use_internal_dnc))
					{
					$phone_number_areacode = substr($phone_number, 0, 3);
					$phone_number_areacode .= "XXXXXXX";
					$stmt="SELECT count(*) from vicidial_dnc where phone_number IN('$phone_number','$phone_number_areacode');";
					}
				else
					{$stmt="SELECT count(*) FROM vicidial_dnc where phone_number='$phone_number';";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00017',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					### purge from the dial queue and api
					$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00356',$user,$server_ip,$session_name,$one_mysql_log);}
					$VMDQaffected_rows = mysqli_affected_rows($link);

					$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00357',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAEDaffected_rows = mysqli_affected_rows($link);

					echo "DNC NUMBER\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				}
			### END DNC manual dial filtering ###

			if (preg_match("/CAMPLISTS/",$manual_dial_filter))
				{
				$stmt="SELECT list_id,active from vicidial_lists where campaign_id='$campaign'";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00019',$user,$server_ip,$session_name,$one_mysql_log);}
				$lists_to_parse = mysqli_num_rows($rslt);
				$camp_lists='';
				$o=0;
				while ($lists_to_parse > $o) 
					{
					$rowx=mysqli_fetch_row($rslt);
					if (preg_match("/Y/", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
					if (preg_match("/ALL/",$manual_dial_filter))
						{
						if (preg_match("/N/", $rowx[1])) 
							{$inactive_lists++; $camp_lists .= "'$rowx[0]',";}
						}
					else
						{
						if (preg_match("/N/", $rowx[1])) 
							{$inactive_lists++;}
						}
					$o++;
					}
				$camp_lists = preg_replace("/.$/i","",$camp_lists);
				if (strlen($camp_lists)<2) {$camp_lists="''";}

				$stmt="SELECT count(*) FROM vicidial_list where phone_number='$phone_number' and list_id IN($camp_lists);";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00020',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$MDF_search_flag='MAIN';

				if ( ($row[0] < 1) and (preg_match("/WITH_ALT/",$manual_dial_filter)) )
					{
					$stmt="SELECT count(*) FROM vicidial_list where alt_phone='$phone_number' and list_id IN($camp_lists);";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00619',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$row=mysqli_fetch_row($rslt);
					$MDF_search_flag='ALT';
					}

				if ( ($row[0] < 1) and (preg_match("/WITH_ALT_ADDR3/",$manual_dial_filter)) )
					{
					$stmt="SELECT count(*) FROM vicidial_list where address3='$phone_number' and list_id IN($camp_lists);";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00620',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$row=mysqli_fetch_row($rslt);
					$MDF_search_flag='ADDR3';
					}

				if ($row[0] < 1)
					{
					### purge from the dial queue and api
					$stmt = "DELETE from vicidial_manual_dial_queue where phone_number='$phone_number' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00360',$user,$server_ip,$session_name,$one_mysql_log);}
					$VMDQaffected_rows = mysqli_affected_rows($link);

					$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00361',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAEDaffected_rows = mysqli_affected_rows($link);

					echo "NUMBER NOT IN CAMPLISTS\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				}
				### END check for manual dial filtering ###

			if ($lookup_empty_insert_lead > 0)
				{
				### insert a new lead in the system with this phone number
				$stmt = "INSERT INTO vicidial_list SET phone_code='$phone_code',phone_number='$phone_number',list_id='$list_id',status='QUEUE',user='$user',called_since_last_reset='Y',entry_date='$ENTRYdate',last_local_call_time='$NOW_TIME',vendor_lead_code=\"$vendor_lead_code\";";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00022',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				$lead_id = mysqli_insert_id($link);
				$CBleadIDset=1;
				}
			}
		else	
			{
			if ($lead_id_defined < 1)
				{
				##### gather no hopper dialing settings from campaign
				$stmt="SELECT no_hopper_dialing,agent_dial_owner_only,local_call_time,dial_statuses,drop_lockout_time,lead_filter_id,lead_order,lead_order_randomize,lead_order_secondary,call_count_limit,next_dial_my_callbacks,callback_list_calltime,callback_hours_block FROM vicidial_campaigns where campaign_id='$campaign';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00236',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$camp_nohopper_ct = mysqli_num_rows($rslt);
				if ($camp_nohopper_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$no_hopper_dialing =		$row[0];
					$agent_dial_owner_only =	$row[1];
					$local_call_time =			$row[2];
					$dial_statuses =			$row[3];
					$drop_lockout_time =		$row[4];
					$lead_filter_id =			$row[5];
					$lead_order =				$row[6];
					$lead_order_randomize =		$row[7];
					$lead_order_secondary =		$row[8];
					$call_count_limit =			$row[9];
					$next_dial_my_callbacks =	$row[10];
					$callback_list_calltime =	$row[11];
					$callback_hours_block =		$row[12];
					}
				if (preg_match("/N/i",$no_hopper_dialing))
					{
					$no_hopper_dialing_used=0;
					### grab the next lead in the hopper for this campaign and reserve it for the user
					$stmt = "UPDATE vicidial_hopper set status='QUEUE', user='$user' where campaign_id='$campaign' and status='READY' order by priority desc,hopper_id LIMIT 1";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00024',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($link);
					}
				else
					{
					$no_hopper_dialing_used=1;
					### figure out what the next lead that should be dialed is

					##########################################################
					### BEGIN find the next lead to dial without looking in the hopper (NO HOPPER DIALING)
					##########################################################
				#	$DB=1;

					##### gather user lead filter setting
					$USERlead_filter_id='';
					$USERfSQL='';
					$stmt="SELECT lead_filter_id FROM vicidial_users where user='$user';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00621',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$camp_nohopper_ct = mysqli_num_rows($rslt);
					if ($camp_nohopper_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$USERlead_filter_id = $row[0];
						}
					if ( ($USERlead_filter_id != 'NONE') and (strlen($USERlead_filter_id) > 0) )
						{
						$stmt="SELECT lead_filter_sql FROM vicidial_lead_filters where lead_filter_id='$USERlead_filter_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00622',$user,$server_ip,$session_name,$one_mysql_log);}
						$filtersql_ct = mysqli_num_rows($rslt);
						if ($DB) {echo "$filtersql_ct|$stmt\n";}
						if ($filtersql_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$USERfSQL = "and ($row[0])";
							$USERfSQL = preg_replace('/\\\\/','',$USERfSQL);
							}
						}

					$origUSERfSQL = $USERfSQL;
					$find_lead_ct=0;
					$callback_id_exclude="''";
					while ($find_lead_ct < 20)
						{
						$dial_next_callback=0;
						if ( ($next_dial_my_callbacks == 'ENABLED') and ($find_lead_ct < 19) )
							{
							$stmt="SELECT lead_id,callback_id FROM vicidial_callbacks where user='$user' and recipient='USERONLY' and status='LIVE' and callback_time < NOW() and campaign_id='$campaign' and callback_id NOT IN($callback_id_exclude) order by callback_time limit 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00701',$user,$server_ip,$session_name,$one_mysql_log);}
							$filtersql_ct = mysqli_num_rows($rslt);
							if ($DB) {echo "$filtersql_ct|$stmt\n";}
							if ($filtersql_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$USERfSQL = "and (lead_id='$row[0]')";
								$callback_id = $row[1];
								$callback_id_exclude .= ",'$row[1]'";
								$find_lead_ct++;
								$dial_next_callback=1;
								}
							else
								{$find_lead_ct = 20;   $USERfSQL = $origUSERfSQL;}
							}
						else
							{$find_lead_ct = 20;   $USERfSQL = $origUSERfSQL;}

						if (strlen($dial_statuses)>2)
							{
							$g=0;
							$p='13';
							$GMT_gmt[0] = '';
							$GMT_hour[0] = '';
							$GMT_day[0] = '';
							$YMD =  date("Y-m-d");
							while ($p > -13)
								{
								$pzone=3600 * $p;
								$pmin=(gmdate("i", time() + $pzone));
								$phour=( (gmdate("G", time() + $pzone)) * 100);
								$pday=gmdate("w", time() + $pzone);
								$tz = sprintf("%.2f", $p);	
								$GMT_gmt[$g] = "$tz";
								$GMT_day[$g] = "$pday";
								$GMT_hour[$g] = ($phour + $pmin);
								$p = ($p - 0.25);
								$g++;
								}
		
							$stmt="SELECT call_time_id,call_time_name,call_time_comments,ct_default_start,ct_default_stop,ct_sunday_start,ct_sunday_stop,ct_monday_start,ct_monday_stop,ct_tuesday_start,ct_tuesday_stop,ct_wednesday_start,ct_wednesday_stop,ct_thursday_start,ct_thursday_stop,ct_friday_start,ct_friday_stop,ct_saturday_start,ct_saturday_stop,ct_state_call_times,ct_holidays FROM vicidial_call_times where call_time_id='$local_call_time';";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00237',$user,$server_ip,$session_name,$one_mysql_log);}
							$rowx=mysqli_fetch_row($rslt);
							$Gct_default_start =	$rowx[3];
							$Gct_default_stop =		$rowx[4];
							$Gct_sunday_start =		$rowx[5];
							$Gct_sunday_stop =		$rowx[6];
							$Gct_monday_start =		$rowx[7];
							$Gct_monday_stop =		$rowx[8];
							$Gct_tuesday_start =	$rowx[9];
							$Gct_tuesday_stop =		$rowx[10];
							$Gct_wednesday_start =	$rowx[11];
							$Gct_wednesday_stop =	$rowx[12];
							$Gct_thursday_start =	$rowx[13];
							$Gct_thursday_stop =	$rowx[14];
							$Gct_friday_start =		$rowx[15];
							$Gct_friday_stop =		$rowx[16];
							$Gct_saturday_start =	$rowx[17];
							$Gct_saturday_stop =	$rowx[18];
							$Gct_state_call_times = $rowx[19];
							$Gct_holidays =			$rowx[20];
							
							### BEGIN Check for outbound holiday ###
							$holiday_id = '';
							if (strlen($Gct_holidays)>2)
								{
								$Gct_holidaysSQL = preg_replace("/\|/", "','", "$Gct_holidays");
								$Gct_holidaysSQL = "'".$Gct_holidaysSQL."'";
								$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id IN($Gct_holidaysSQL) and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
								$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00240',$user,$server_ip,$session_name,$one_mysql_log);}
								$sthCrows=mysqli_num_rows($rslt);
								if ($sthCrows > 0)
									{
									$aryC=mysqli_fetch_row($rslt);
									$Sholiday_id =				$aryC[0];
									$Sholiday_date =			$aryC[1];
									$Sholiday_name =			$aryC[2];
									if ( ($Gct_default_start < $aryC[3]) && ($Gct_default_stop > 0) )		{$Gct_default_start = $aryC[3];}
									if ( ($Gct_default_stop > $aryC[4]) && ($Gct_default_stop > 0) )		{$Gct_default_stop = $aryC[4];}
									if ( ($Gct_sunday_start < $aryC[3]) && ($Gct_sunday_stop > 0) )			{$Gct_sunday_start = $aryC[3];}
									if ( ($Gct_sunday_stop > $aryC[4]) && ($Gct_sunday_stop > 0) )			{$Gct_sunday_stop = $aryC[4];}
									if ( ($Gct_monday_start < $aryC[3]) && ($Gct_monday_stop > 0) )			{$Gct_monday_start = $aryC[3];}
									if ( ($Gct_monday_stop >	$aryC[4]) && ($Gct_monday_stop > 0) )		{$Gct_monday_stop =	$aryC[4];}
									if ( ($Gct_tuesday_start < $aryC[3]) && ($Gct_tuesday_stop > 0) )		{$Gct_tuesday_start = $aryC[3];}
									if ( ($Gct_tuesday_stop > $aryC[4]) && ($Gct_tuesday_stop > 0) )		{$Gct_tuesday_stop = $aryC[4];}
									if ( ($Gct_wednesday_start < $aryC[3]) && ($Gct_wednesday_stop > 0) ) 	{$Gct_wednesday_start = $aryC[3];}
									if ( ($Gct_wednesday_stop > $aryC[4]) && ($Gct_wednesday_stop > 0) )	{$Gct_wednesday_stop = $aryC[4];}
									if ( ($Gct_thursday_start < $aryC[3]) && ($Gct_thursday_stop > 0) )		{$Gct_thursday_start = $aryC[3];}
									if ( ($Gct_thursday_stop > $aryC[4]) && ($Gct_thursday_stop > 0) )		{$Gct_thursday_stop = $aryC[4];}
									if ( ($Gct_friday_start < $aryC[3]) && ($Gct_friday_stop > 0) )			{$Gct_friday_start = $aryC[3];}
									if ( ($Gct_friday_stop > $aryC[4]) && ($Gct_friday_stop > 0) )			{$Gct_friday_stop = $aryC[4];}
									if ( ($Gct_saturday_start < $aryC[3]) && ($Gct_saturday_stop > 0) )		{$Gct_saturday_start = $aryC[3];}
									if ( ($Gct_saturday_stop > $aryC[4]) && ($Gct_saturday_stop > 0) )		{$Gct_saturday_stop = $aryC[4];}
									if ($DB) {echo "CAMPAIGN CALL TIME HOLIDAY FOUND!   $local_call_time|$holiday_id|$holiday_date|$holiday_name|$Gct_default_start|$Gct_default_stop|\n";}
									}
								}
							### END Check for outbound holiday ###

							$ct_states = '';
							$ct_state_gmt_SQL = '';
							$ct_srs=0;
							$b=0;
							if (strlen($Gct_state_call_times)>2)
								{
								$state_rules = explode('|',$Gct_state_call_times);
								$ct_srs = ((count($state_rules)) - 2);
								}
							while($ct_srs >= $b)
								{
								if (strlen($state_rules[$b])>1)
									{
									$stmt="SELECT state_call_time_id,state_call_time_state,state_call_time_name,state_call_time_comments,sct_default_start,sct_default_stop,sct_sunday_start,sct_sunday_stop,sct_monday_start,sct_monday_stop,sct_tuesday_start,sct_tuesday_stop,sct_wednesday_start,sct_wednesday_stop,sct_thursday_start,sct_thursday_stop,sct_friday_start,sct_friday_stop,sct_saturday_start,sct_saturday_stop,ct_holidays from vicidial_state_call_times where state_call_time_id='$state_rules[$b]';";
									$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00238',$user,$server_ip,$session_name,$one_mysql_log);}
									$row=mysqli_fetch_row($rslt);
									$Gstate_call_time_id =		$row[0];
									$Gstate_call_time_state =	$row[1];
									$Gsct_default_start =		$row[4];
									$Gsct_default_stop =		$row[5];
									$Gsct_sunday_start =		$row[6];
									$Gsct_sunday_stop =			$row[7];
									$Gsct_monday_start =		$row[8];
									$Gsct_monday_stop =			$row[9];
									$Gsct_tuesday_start =		$row[10];
									$Gsct_tuesday_stop =		$row[11];
									$Gsct_wednesday_start =		$row[12];
									$Gsct_wednesday_stop =		$row[13];
									$Gsct_thursday_start =		$row[14];
									$Gsct_thursday_stop =		$row[15];
									$Gsct_friday_start =		$row[16];
									$Gsct_friday_stop =			$row[17];
									$Gsct_saturday_start =		$row[18];
									$Gsct_saturday_stop =		$row[19];
									$Sct_holidays =				$row[20];
									$ct_states .="'$Gstate_call_time_state',";

									### BEGIN Check for outbound state holiday ###
									$Sholiday_id = '';
									if ((strlen($Sct_holidays)>2) or ((strlen($holiday_id)>2) and (strlen($Sholiday_id)<2))) 
										{
										#Apply state holiday
										if (strlen($Sct_holidays)>2)
											{								
											$Sct_holidaysSQL = preg_replace("/\|/", "','", "$Sct_holidays");
											$Sct_holidaysSQL = "'".$Sct_holidaysSQL."'";
											$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id IN($Sct_holidaysSQL) and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
											$holidaytype = "CAMPAIGN STATE CALL TIME HOLIDAY FOUND!   ";
											}
										#Apply call time wide holiday
										elseif ((strlen($holiday_id)>2) and (strlen($Sholiday_id)<2))
											{
											$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id='$holiday_id' and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
											$holidaytype = "CAMPAIGN NO STATE HOLIDAY APPLYING CALL TIME HOLIDAY!   ";
											}				
										$rslt=mysql_to_mysqli($stmt, $link);
										if ($DB) {echo "$stmt\n";}
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00602',$user,$server_ip,$session_name,$one_mysql_log);}
										$sthCrows=mysqli_num_rows($rslt);
										if ($sthCrows > 0)
											{
											$aryC=mysqli_fetch_row($rslt);
											$Sholiday_id =				$aryC[0];
											$Sholiday_date =			$aryC[1];
											$Sholiday_name =			$aryC[2];
											if ( ($Gsct_default_start < $aryC[3]) && ($Gsct_default_stop > 0) )		{$Gsct_default_start = $aryC[3];}
											if ( ($Gsct_default_stop > $aryC[4]) && ($Gsct_default_stop > 0) )		{$Gsct_default_stop = $aryC[4];}
											if ( ($Gsct_sunday_start < $aryC[3]) && ($Gsct_sunday_stop > 0) )		{$Gsct_sunday_start = $aryC[3];}
											if ( ($Gsct_sunday_stop > $aryC[4]) && ($Gsct_sunday_stop > 0) )		{$Gsct_sunday_stop = $aryC[4];}
											if ( ($Gsct_monday_start < $aryC[3]) && ($Gsct_monday_stop > 0) )		{$Gsct_monday_start = $aryC[3];}
											if ( ($Gsct_monday_stop > $aryC[4]) && ($Gsct_monday_stop > 0) )		{$Gsct_monday_stop = $aryC[4];}
											if ( ($Gsct_tuesday_start < $aryC[3]) && ($Gsct_tuesday_stop > 0) )		{$Gsct_tuesday_start = $aryC[3];}
											if ( ($Gsct_tuesday_stop > $aryC[4]) && ($Gsct_tuesday_stop > 0) )		{$Gsct_tuesday_stop = $aryC[4];}
											if ( ($Gsct_wednesday_start < $aryC[3]) && ($Gsct_wednesday_stop > 0) ) {$Gsct_wednesday_start = $aryC[3];}
											if ( ($Gsct_wednesday_stop > $aryC[4]) && ($Gsct_wednesday_stop > 0) )	{$Gsct_wednesday_stop = $aryC[4];}
											if ( ($Gsct_thursday_start < $aryC[3]) && ($Gsct_thursday_stop > 0) )	{$Gsct_thursday_start = $aryC[3];}
											if ( ($Gsct_thursday_stop > $aryC[4]) && ($Gsct_thursday_stop > 0) )	{$Gsct_thursday_stop = $aryC[4];}
											if ( ($Gsct_friday_start < $aryC[3]) && ($Gsct_friday_stop > 0) )		{$Gsct_friday_start = $aryC[3];}
											if ( ($Gsct_friday_stop > $aryC[4]) && ($Gsct_friday_stop > 0) )		{$Gsct_friday_stop = $aryC[4];}
											if ( ($Gsct_saturday_start < $aryC[3]) && ($Gsct_saturday_stop > 0) )	{$Gsct_saturday_start = $aryC[3];}
											if ( ($Gsct_saturday_stop > $aryC[4]) && ($Gsct_saturday_stop > 0) )	{$Gsct_saturday_stop = $aryC[4];}
											if ($DB) {echo "$holidaytype   |$Gstate_call_time_id|$Gstate_call_time_state|$Sholiday_id|$Sholiday_date|$Sholiday_name|$Gsct_default_start|$Gsct_default_stop|\n";}
											}
										}
										
									### END Check for outbound state holiday ###


									$r=0;
									$state_gmt='';
									while($r < $g)
										{
										if ($DB > 0)
											{echo "CSCT_gmt: $r|$GMT_day[$r]|$GMT_gmt[$r]|$Gsct_sunday_start|$Gsct_sunday_stop|$GMT_hour[$r]|$Gsct_default_start|$Gsct_default_stop\n";}
										if ($GMT_day[$r]==0)	#### Sunday local time
											{
											if (($Gsct_sunday_start==0) and ($Gsct_sunday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_sunday_start) and ($GMT_hour[$r]<$Gsct_sunday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==1)	#### Monday local time
											{
											if (($Gsct_monday_start==0) and ($Gsct_monday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_monday_start) and ($GMT_hour[$r]<$Gsct_monday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==2)	#### Tuesday local time
											{
											if (($Gsct_tuesday_start==0) and ($Gsct_tuesday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_tuesday_start) and ($GMT_hour[$r]<$Gsct_tuesday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==3)	#### Wednesday local time
											{
											if (($Gsct_wednesday_start==0) and ($Gsct_wednesday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_wednesday_start) and ($GMT_hour[$r]<$Gsct_wednesday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==4)	#### Thursday local time
											{
											if (($Gsct_thursday_start==0) and ($Gsct_thursday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_thursday_start) and ($GMT_hour[$r]<$Gsct_thursday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==5)	#### Friday local time
											{
											if (($Gsct_friday_start==0) and ($Gsct_friday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_friday_start) and ($GMT_hour[$r]<$Gsct_friday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==6)	#### Saturday local time
											{
											if (($Gsct_saturday_start==0) and ($Gsct_saturday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gsct_default_start) and ($GMT_hour[$r]<$Gsct_default_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gsct_saturday_start) and ($GMT_hour[$r]<$Gsct_saturday_stop) )
													{$state_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										$r++;
										}
									$state_gmt = "$state_gmt'99'";
									$ct_state_gmt_SQL .= "or (state='$Gstate_call_time_state' and gmt_offset_now IN($state_gmt)) ";
									}

								$b++;
								}
							if (strlen($ct_states)>2)
								{
								$ct_states = preg_replace("/,$/i",'',$ct_states);
								$ct_statesSQL = "and state NOT IN($ct_states)";
								}
							else
								{
								$ct_statesSQL = "";
								}

							$r=0;
							$default_gmt='';
							while($r < $g)
								{
								if ($DB > 0)
									{echo "CSCT_gmt: $r|$GMT_day[$r]|$GMT_gmt[$r]|$Gct_sunday_start|$Gct_sunday_stop|$GMT_hour[$r]|$Gct_default_start|$Gct_default_stop\n";}
								if ($GMT_day[$r]==0)	#### Sunday local time
									{
									if (($Gct_sunday_start==0) and ($Gct_sunday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_sunday_start) and ($GMT_hour[$r]<$Gct_sunday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==1)	#### Monday local time
									{
									if (($Gct_monday_start==0) and ($Gct_monday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_monday_start) and ($GMT_hour[$r]<$Gct_monday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==2)	#### Tuesday local time
									{
									if (($Gct_tuesday_start==0) and ($Gct_tuesday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_tuesday_start) and ($GMT_hour[$r]<$Gct_tuesday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==3)	#### Wednesday local time
									{
									if (($Gct_wednesday_start==0) and ($Gct_wednesday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_wednesday_start) and ($GMT_hour[$r]<$Gct_wednesday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==4)	#### Thursday local time
									{
									if (($Gct_thursday_start==0) and ($Gct_thursday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_thursday_start) and ($GMT_hour[$r]<$Gct_thursday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==5)	#### Friday local time
									{
									if (($Gct_friday_start==0) and ($Gct_friday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_friday_start) and ($GMT_hour[$r]<$Gct_friday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								if ($GMT_day[$r]==6)	#### Saturday local time
									{
									if (($Gct_saturday_start==0) and ($Gct_saturday_stop==0))
										{
										if ( ($GMT_hour[$r]>=$Gct_default_start) and ($GMT_hour[$r]<$Gct_default_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									else
										{
										if ( ($GMT_hour[$r]>=$Gct_saturday_start) and ($GMT_hour[$r]<$Gct_saturday_stop) )
											{$default_gmt.="'$GMT_gmt[$r]',";}
										}
									}
								$r++;
								}

							$default_gmt = "$default_gmt'99'";
							$all_gmtSQL = "(gmt_offset_now IN($default_gmt) $ct_statesSQL) $ct_state_gmt_SQL";

							$dial_statuses = preg_replace("/ -$/","",$dial_statuses);
							$Dstatuses = explode(" ", $dial_statuses);
							$Ds_to_print = (count($Dstatuses) - 0);
							$Dsql = '';
							$o=0;
							while ($Ds_to_print > $o) 
								{
								$o++;
								$Dsql .= "'$Dstatuses[$o]',";
								}
							$Dsql = preg_replace("/,$/","",$Dsql);
							if (strlen($Dsql) < 2) {$Dsql = "''";}

							$DLTsql='';
							if ($drop_lockout_time > 0)
								{
								$DLseconds = ($drop_lockout_time * 3600);
								$DLseconds = floor($DLseconds);
								$DLseconds = intval("$DLseconds");
								$DLTsql = "and ( ( (status IN('DROP','XDROP')) and (last_local_call_time < CONCAT(DATE_ADD(NOW(), INTERVAL -$DLseconds SECOND),' ',CURTIME()) ) ) or (status NOT IN('DROP','XDROP')) )";
								}

							$CCLsql='';
							if ($call_count_limit > 0)
								{
								$CCLsql = "and (called_count < $call_count_limit)";
								}

							$stmt="SELECT lead_filter_sql FROM vicidial_lead_filters where lead_filter_id='$lead_filter_id';";
							$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00239',$user,$server_ip,$session_name,$one_mysql_log);}
							$filtersql_ct = mysqli_num_rows($rslt);
							if ($DB) {echo "$filtersql_ct|$stmt\n";}
							if ($filtersql_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$fSQL = "and ($row[0])";
								$fSQL = preg_replace('/\\\\/','',$fSQL);
								}

							#################################								
							# Camp List
							$vulnl_SQL='';
							$vulnlOVERALL_SQL='';
							$stmt="SELECT list_id FROM vicidial_lists where campaign_id='$campaign' and active='Y';";
							$rslt_list=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00603',$user,$server_ip,$session_name,$one_mysql_log);}
							$camplists_ct = mysqli_num_rows($rslt_list);
							if ($DB) {echo "$camplists_ct|$stmt\n";}
							$k=0;
							$camp_lists='';
							while ($camplists_ct > $k)
								{
								$rowA = mysqli_fetch_row($rslt_list);
								$camp_lists .=	"'$rowA[0]',";

								##### Get Call List call time settings
								##### BEGIN calculate what gmt_offset_now values are within the allowed local_call_time setting ###
								$g=0;
								$p='13';
								$GMT_gmt[0] = '';
								$GMT_hour[0] = '';
								$GMT_day[0] = '';
								$YMD =  date("Y-m-d");
								while ($p > -13)
									{
									$pzone=3600 * $p;
									$pmin=(gmdate("i", time() + $pzone));
									$phour=( (gmdate("G", time() + $pzone)) * 100);
									$pday=gmdate("w", time() + $pzone);
									$tz = sprintf("%.2f", $p);	
									$GMT_gmt[$g] = "$tz";
									$GMT_day[$g] = "$pday";
									$GMT_hour[$g] = ($phour + $pmin);
									$p = ($p - 0.25);
									$g++;
									}

								# Set List ID Variable
								$cur_list_id = $rowA[0];			
								$list_local_call_time = "";

								# Pull the call times and user_new_lead_limit settings for the lists
								$stmt="SELECT local_call_time,list_description,user_new_lead_limit FROM vicidial_lists where list_id='$cur_list_id';";
								$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00604',$user,$server_ip,$session_name,$one_mysql_log);}					
								$rslt_ct = mysqli_num_rows($rslt);
								if ($rslt_ct > 0)
									{
									#set Cur call_time
									$row=mysqli_fetch_row($rslt);
									$cur_call_time  =		$row[0];
									$list_description =		$row[1];
									$user_new_lead_limit =	$row[2];
									}
								
								# build NEW lead limit SQL, if that setting is enabled
								if ($SSuser_new_lead_limit > 0)
									{
									$vulnl_new_sum=0;
									$stmt="SELECT sum(new_count) from vicidial_user_list_new_lead where user='$user';";
									$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00659',$user,$server_ip,$session_name,$one_mysql_log);}
									$vulnlags_ct = mysqli_num_rows($rslt);
									if ($vulnlags_ct > 0)
										{
										$row=mysqli_fetch_row($rslt);
										$vulnl_new_sum  =	$row[0];
										if (strlen($vulnl_new_sum)<1) {$vulnl_new_sum=0;}
										}
									if ( ($VUuser_new_lead_limit > -1) and ($vulnl_new_sum >= $VUuser_new_lead_limit) )
										{
										$vulnlOVERALL_SQL .= "and (status!='NEW')";
										}

									$vulnl_user_override='-1';
									$vulnl_new_count=0;
									$stmt="SELECT user_override,new_count FROM vicidial_user_list_new_lead where user='$user' and list_id='$cur_list_id';";
									$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00655',$user,$server_ip,$session_name,$one_mysql_log);}
									$vulnlag_ct = mysqli_num_rows($rslt);
									if ($vulnlag_ct > 0)
										{
										$row=mysqli_fetch_row($rslt);
										$vulnl_user_override  =	$row[0];
										$vulnl_new_count =		$row[1];
										}
									if ($vulnl_user_override > -1)
										{$user_new_lead_limit = $vulnl_user_override;}
									if ( ($user_new_lead_limit > -1) and ($vulnl_new_count >= $user_new_lead_limit) )
										{
										$vulnl_SQL .= "and ( ( (list_id=$cur_list_id) and (status!='NEW') ) or (list_id!=$cur_list_id) )";
										}

							#		$fp = fopen ("./DNNdebug_log.txt", "a");
							#		fwrite ($fp, "$NOW_TIME|     |$k|$cur_list_id|$SSuser_new_lead_limit|$user_new_lead_limit|$vulnl_user_override|$vulnl_new_count|$user|$vulnl_SQL|$stmt|\n");
							#		fclose($fp);  
									}

								# check that call time exists
								if ($cur_call_time != "campaign") 
									{
									$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$cur_call_time';";
									$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00613',$user,$server_ip,$session_name,$one_mysql_log);}					
									$row=mysqli_fetch_row($rslt);
									$call_time_exists  =	$row[0];
									if ($call_time_exists < 1) 
										{$cur_call_time = 'campaign';}
									}

								##### BEGIN local call time for list set different than campaign #####
								if ($cur_call_time != "campaign")
									{
									##### BEGIN calculate what gmt_offset_now values are within the allowed local_call_time setting ###
									$stmt = "SELECT call_time_id,call_time_name,call_time_comments,ct_default_start,ct_default_stop,ct_sunday_start,ct_sunday_stop,ct_monday_start,ct_monday_stop,ct_tuesday_start,ct_tuesday_stop,ct_wednesday_start,ct_wednesday_stop,ct_thursday_start,ct_thursday_stop,ct_friday_start,ct_friday_stop,ct_saturday_start,ct_saturday_stop,ct_state_call_times,ct_holidays FROM vicidial_call_times where call_time_id='$cur_call_time';";
									if ($DB) {echo "$stmt\n";}
									$rsltD=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00237',$user,$server_ip,$session_name,$one_mysql_log);}					
									$aryD=mysqli_fetch_row($rsltD);
									$Gct_default_start =	$aryD[3];
									$Gct_default_stop =		$aryD[4];
									$Gct_sunday_start =		$aryD[5];
									$Gct_sunday_stop =		$aryD[6];
									$Gct_monday_start =		$aryD[7];
									$Gct_monday_stop =		$aryD[8];
									$Gct_tuesday_start =	$aryD[9];
									$Gct_tuesday_stop =		$aryD[10];
									$Gct_wednesday_start =	$aryD[11];
									$Gct_wednesday_stop =	$aryD[12];
									$Gct_thursday_start =	$aryD[13];
									$Gct_thursday_stop =	$aryD[14];
									$Gct_friday_start =		$aryD[15];
									$Gct_friday_stop =		$aryD[16];
									$Gct_saturday_start =	$aryD[17];
									$Gct_saturday_stop =	$aryD[18];
									$Gct_state_call_times = $aryD[19];
									$Gct_holidays =			$aryD[20];

									### BEGIN Check for outbound holiday ###
									$holiday_id = '';
									if (strlen($Gct_holidays)>2)
										{
										$Gct_holidaysSQL = preg_replace("/\|/", "','", "$Gct_holidays");
										$Gct_holidaysSQL = "'".$Gct_holidaysSQL."'";
										
										$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id IN($Gct_holidaysSQL) and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
										$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00605',$user,$server_ip,$session_name,$one_mysql_log);}
										$sthCrows=mysqli_num_rows($rslt);
										if ($sthCrows > 0)
											{
											$aryC=mysqli_fetch_row($rslt);
											$holiday_id =				$aryC[0];
											$holiday_date =				$aryC[1];
											$holiday_name =				$aryC[2];
											if ( ($Gct_default_start < $aryC[3]) && ($Gct_default_stop > 0) )		{$Gct_default_start = $aryC[3];}
											if ( ($Gct_default_stop > $aryC[4]) && ($Gct_default_stop > 0) )		{$Gct_default_stop = $aryC[4];}
											if ( ($Gct_sunday_start < $aryC[3]) && ($Gct_sunday_stop > 0) )			{$Gct_sunday_start = $aryC[3];}
											if ( ($Gct_sunday_stop > $aryC[4]) && ($Gct_sunday_stop > 0) )			{$Gct_sunday_stop = $aryC[4];}
											if ( ($Gct_monday_start < $aryC[3]) && ($Gct_monday_stop > 0) )			{$Gct_monday_start = $aryC[3];}
											if ( ($Gct_monday_stop >	$aryC[4]) && ($Gct_monday_stop > 0) )		{$Gct_monday_stop =	$aryC[4];}
											if ( ($Gct_tuesday_start < $aryC[3]) && ($Gct_tuesday_stop > 0) )		{$Gct_tuesday_start = $aryC[3];}
											if ( ($Gct_tuesday_stop > $aryC[4]) && ($Gct_tuesday_stop > 0) )		{$Gct_tuesday_stop = $aryC[4];}
											if ( ($Gct_wednesday_start < $aryC[3]) && ($Gct_wednesday_stop > 0) ) 	{$Gct_wednesday_start = $aryC[3];}
											if ( ($Gct_wednesday_stop > $aryC[4]) && ($Gct_wednesday_stop > 0) )	{$Gct_wednesday_stop = $aryC[4];}
											if ( ($Gct_thursday_start < $aryC[3]) && ($Gct_thursday_stop > 0) )		{$Gct_thursday_start = $aryC[3];}
											if ( ($Gct_thursday_stop > $aryC[4]) && ($Gct_thursday_stop > 0) )		{$Gct_thursday_stop = $aryC[4];}
											if ( ($Gct_friday_start < $aryC[3]) && ($Gct_friday_stop > 0) )			{$Gct_friday_start = $aryC[3];}
											if ( ($Gct_friday_stop > $aryC[4]) && ($Gct_friday_stop > 0) )			{$Gct_friday_stop = $aryC[4];}
											if ( ($Gct_saturday_start < $aryC[3]) && ($Gct_saturday_stop > 0) )		{$Gct_saturday_start = $aryC[3];}
											if ( ($Gct_saturday_stop > $aryC[4]) && ($Gct_saturday_stop > 0) )		{$Gct_saturday_stop = $aryC[4];}
											if ($DB) {echo "LIST CALL TIME HOLIDAY FOUND!   $local_call_time|$holiday_id|$holiday_date|$holiday_name|$Gct_default_start|$Gct_default_stop|\n";}
											}
										}
									### END Check for outbound holiday ###

									$ct_states = '';
									$ct_state_gmt_SQL = '';
									$ct_srs=0;
									$b=0;
									if (strlen($Gct_state_call_times)>2)
										{
										$state_rules = explode('|',$Gct_state_call_times);
										$ct_srs = ((count($state_rules)) - 2);
										}
									while($ct_srs >= $b)
										{
										if (strlen($state_rules[$b])>1)
											{
											$stmt = "SELECT state_call_time_id,state_call_time_state,state_call_time_name,state_call_time_comments,sct_default_start,sct_default_stop,sct_sunday_start,sct_sunday_stop,sct_monday_start,sct_monday_stop,sct_tuesday_start,sct_tuesday_stop,sct_wednesday_start,sct_wednesday_stop,sct_thursday_start,sct_thursday_stop,sct_friday_start,sct_friday_stop,sct_saturday_start,sct_saturday_stop,ct_holidays from vicidial_state_call_times where state_call_time_id='$state_rules[$b]';";
											$rslt=mysql_to_mysqli($stmt, $link);
											if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00606',$user,$server_ip,$session_name,$one_mysql_log);}
											$sthCrows=mysqli_num_rows($rslt);
											if ($sthCrows > 0)
												{
												$aryC=mysqli_fetch_row($rslt);
												$Gstate_call_time_id =		$aryC[0];
												$Gstate_call_time_state =	$aryC[1];
												$Gsct_default_start =		$aryC[4];
												$Gsct_default_stop =		$aryC[5];
												$Gsct_sunday_start =		$aryC[6];
												$Gsct_sunday_stop =			$aryC[7];
												$Gsct_monday_start =		$aryC[8];
												$Gsct_monday_stop =			$aryC[9];
												$Gsct_tuesday_start =		$aryC[10];
												$Gsct_tuesday_stop =		$aryC[11];
												$Gsct_wednesday_start =		$aryC[12];
												$Gsct_wednesday_stop =		$aryC[13];
												$Gsct_thursday_start =		$aryC[14];
												$Gsct_thursday_stop =		$aryC[15];
												$Gsct_friday_start =		$aryC[16];
												$Gsct_friday_stop =			$aryC[17];
												$Gsct_saturday_start =		$aryC[18];
												$Gsct_saturday_stop =		$aryC[19];
												$Sct_holidays =				$aryC[20];
												$ct_states .="'$Gstate_call_time_state',";
												}

											### BEGIN Check for outbound state holiday ###
											$Sholiday_id = '';
											if ((strlen($Sct_holidays)>2) or ((strlen($holiday_id)>2) and (strlen($Sholiday_id)<2))) 
												{
												#Apply state holiday
												if (strlen($Sct_holidays)>2)
													{								
													$Sct_holidaysSQL = preg_replace("/\|/", "','", "$Sct_holidays");
													$Sct_holidaysSQL = "'".$Sct_holidaysSQL."'";
													$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id IN($Sct_holidaysSQL) and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
													$holidaytype = "LIST STATE CALL TIME HOLIDAY FOUND!   ";
													}
												#Apply call time wide holiday
												elseif ((strlen($holiday_id)>2) and (strlen($Sholiday_id)<2))
													{
													$stmt = "SELECT holiday_id,holiday_date,holiday_name,ct_default_start,ct_default_stop from vicidial_call_time_holidays where holiday_id='$holiday_id' and holiday_status='ACTIVE' and holiday_date='$YMD' order by holiday_id;";
													$holidaytype = "LIST NO STATE HOLIDAY APPLYING CALL TIME HOLIDAY!   ";
													}				
												$rslt=mysql_to_mysqli($stmt, $link);
												if ($DB) {echo "$stmt\n";}
												if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00607',$user,$server_ip,$session_name,$one_mysql_log);}
												$sthCrows=mysqli_num_rows($rslt);
												if ($sthCrows > 0)
													{
													$aryC=mysqli_fetch_row($rslt);
													$Sholiday_id =				$aryC[0];
													$Sholiday_date =			$aryC[1];
													$Sholiday_name =			$aryC[2];
													if ( ($Gsct_default_start < $aryC[3]) && ($Gsct_default_stop > 0) )		{$Gsct_default_start = $aryC[3];}
													if ( ($Gsct_default_stop > $aryC[4]) && ($Gsct_default_stop > 0) )		{$Gsct_default_stop = $aryC[4];}
													if ( ($Gsct_sunday_start < $aryC[3]) && ($Gsct_sunday_stop > 0) )		{$Gsct_sunday_start = $aryC[3];}
													if ( ($Gsct_sunday_stop > $aryC[4]) && ($Gsct_sunday_stop > 0) )		{$Gsct_sunday_stop = $aryC[4];}
													if ( ($Gsct_monday_start < $aryC[3]) && ($Gsct_monday_stop > 0) )		{$Gsct_monday_start = $aryC[3];}
													if ( ($Gsct_monday_stop >	$aryC[4]) && ($Gsct_monday_stop > 0) )		{$Gsct_monday_stop =	$aryC[4];}
													if ( ($Gsct_tuesday_start < $aryC[3]) && ($Gsct_tuesday_stop > 0) )		{$Gsct_tuesday_start = $aryC[3];}
													if ( ($Gsct_tuesday_stop > $aryC[4]) && ($Gsct_tuesday_stop > 0) )		{$Gsct_tuesday_stop = $aryC[4];}
													if ( ($Gsct_wednesday_start < $aryC[3]) && ($Gsct_wednesday_stop > 0) ) {$Gsct_wednesday_start = $aryC[3];}
													if ( ($Gsct_wednesday_stop > $aryC[4]) && ($Gsct_wednesday_stop > 0) )	{$Gsct_wednesday_stop = $aryC[4];}
													if ( ($Gsct_thursday_start < $aryC[3]) && ($Gsct_thursday_stop > 0) )	{$Gsct_thursday_start = $aryC[3];}
													if ( ($Gsct_thursday_stop > $aryC[4]) && ($Gsct_thursday_stop > 0) )	{$Gsct_thursday_stop = $aryC[4];}
													if ( ($Gsct_friday_start < $aryC[3]) && ($Gsct_friday_stop > 0) )		{$Gsct_friday_start = $aryC[3];}
													if ( ($Gsct_friday_stop > $aryC[4]) && ($Gsct_friday_stop > 0) )		{$Gsct_friday_stop = $aryC[4];}
													if ( ($Gsct_saturday_start < $aryC[3]) && ($Gsct_saturday_stop > 0) )	{$Gsct_saturday_start = $aryC[3];}
													if ( ($Gsct_saturday_stop > $aryC[4]) && ($Gsct_saturday_stop > 0) )	{$Gsct_saturday_stop = $aryC[4];}
													if ($DB) {echo "$holidaytype   |$Gstate_call_time_id|$Gstate_call_time_state|$Sholiday_id|$Sholiday_date|$Sholiday_name|$Gsct_default_start|$Gsct_default_stop|\n";}
													}
												}
											### END Check for outbound state holiday ###

											$r=0;
											$state_gmt='';
											$del_state_gmt='';
											while($r < $g)
												{
												if ($GMT_day[$r]==0)	#### Sunday local time
													{
													if (($Gsct_sunday_start==0) && ($Gsct_sunday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_sunday_start) && ($GMT_hour[$r]<$Gsct_sunday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==1)	#### Monday local time
													{
													if (($Gsct_monday_start==0) && ($Gsct_monday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_monday_start) && ($GMT_hour[$r]<$Gsct_monday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==2)	#### Tuesday local time
													{
													if (($Gsct_tuesday_start==0) && ($Gsct_tuesday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_tuesday_start) && ($GMT_hour[$r]<$Gsct_tuesday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==3)	#### Wednesday local time
													{
													if (($Gsct_wednesday_start==0) && ($Gsct_wednesday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_wednesday_start) && ($GMT_hour[$r]<$Gsct_wednesday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==4)	#### Thursday local time
													{
													if (($Gsct_thursday_start==0) && ($Gsct_thursday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_thursday_start) && ($GMT_hour[$r]<$Gsct_thursday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==5)	#### Friday local time
													{
													if (($Gsct_friday_start==0) && ($Gsct_friday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_friday_start) && ($GMT_hour[$r]<$Gsct_friday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												if ($GMT_day[$r]==6)	#### Saturday local time
													{
													if (($Gsct_saturday_start==0) && ($Gsct_saturday_stop==0))
														{
														if ( ($GMT_hour[$r]>=$Gsct_default_start) && ($GMT_hour[$r]<$Gsct_default_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													else
														{
														if ( ($GMT_hour[$r]>=$Gsct_saturday_start) && ($GMT_hour[$r]<$Gsct_saturday_stop) )
															{$state_gmt.="'$GMT_gmt[$r]',";}
														}
													}
												$r++;
												}
											$state_gmt = "$state_gmt'99'";
						
											$del_list_state_gmt_SQL .= "or (list_id=\"$cur_list_id\" and state='$Gstate_call_time_state' and gmt_offset_now NOT IN($state_gmt)) ";
											$list_state_gmt_SQL .= "or (list_id=\"$cur_list_id\" and state='$Gstate_call_time_state' and gmt_offset_now IN($state_gmt)) ";
											}

										$b++;
										}
									if (strlen($ct_states)>2)
										{
										$ct_states = preg_replace("/,$/i",'',$ct_states);
										$ct_statesSQL = "and state NOT IN($ct_states)";
										}
									else
										{
										$ct_statesSQL = "";
										}

									$r=0;
									$dgA=0;
									$list_default_gmt='';
									while($r < $g)
										{
										if ($DB > 0) 
											{echo "LCT_gmt: $r|$GMT_day[$r]|$GMT_gmt[$r]|$Gct_sunday_start|$Gct_sunday_stop|$GMT_hour[$r]|$Gct_default_start|$Gct_default_stop\n";}

										if ($GMT_day[$r]==0)	#### Sunday local time
											{
											if (($Gct_sunday_start==0) && ($Gct_sunday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_sunday_start) && ($GMT_hour[$r]<$Gct_sunday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==1)	#### Monday local time
											{
											if (($Gct_monday_start==0) && ($Gct_monday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_monday_start) && ($GMT_hour[$r]<$Gct_monday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==2)	#### Tuesday local time
											{
											if (($Gct_tuesday_start==0) && ($Gct_tuesday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_tuesday_start) && ($GMT_hour[$r]<$Gct_tuesday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==3)	#### Wednesday local time
											{
											if (($Gct_wednesday_start==0) && ($Gct_wednesday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_wednesday_start) && ($GMT_hour[$r]<$Gct_wednesday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==4)	#### Thursday local time
											{
											if (($Gct_thursday_start==0) && ($Gct_thursday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_thursday_start) && ($GMT_hour[$r]<$Gct_thursday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==5)	#### Friday local time
											{
											if (($Gct_friday_start==0) && ($Gct_friday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_friday_start) && ($GMT_hour[$r]<$Gct_friday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										if ($GMT_day[$r]==6)	#### Saturday local time
											{
											if (($Gct_saturday_start==0) && ($Gct_saturday_stop==0))
												{
												if ( ($GMT_hour[$r]>=$Gct_default_start) && ($GMT_hour[$r]<$Gct_default_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											else
												{
												if ( ($GMT_hour[$r]>=$Gct_saturday_start) && ($GMT_hour[$r]<$Gct_saturday_stop) )
													{}
												else
													{$list_default_gmt.="'$GMT_gmt[$r]',";}
												}
											}
										$r++;
										}

									$list_default_gmt = "$list_default_gmt'99'";
									if ($k == 0) 
										{
										$list_id_sql = "((list_id=\"$cur_list_id\" and gmt_offset_now NOT IN($list_default_gmt) $ct_statesSQL) $list_state_gmt_SQL)";
										}
									else 
										{
										$list_id_sql .= " or ((list_id=\"$cur_list_id\" and gmt_offset_now NOT IN($list_default_gmt) $ct_statesSQL) $list_state_gmt_SQL)";
										}
									}
								##### END local call time for list set different than campaign #####

								else
									{
									if ($k == 0) 
										{
										$list_id_sql = "(list_id=\"$cur_list_id\")";
										}
									else 
										{
										$list_id_sql .= " or (list_id=\"$cur_list_id\")";
										}
									}

								$k++;
								}
							$camp_lists = preg_replace("/.$/i","",$camp_lists);
							if (strlen($camp_lists) < 4) {$camp_lists="''";}
							if (strlen($list_id_sql) < 4) {$list_id_sql="list_id=''";}

							$stmt="SELECT user_group,territory FROM vicidial_users where user='$user';";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00241',$user,$server_ip,$session_name,$one_mysql_log);}
							$userterr_ct = mysqli_num_rows($rslt);
							if ($DB) {echo "$userterr_ct|$stmt\n";}
							if ($userterr_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$user_group =	$row[0];
								$territory =	$row[1];
								}

							$adooSQL = '';
							if (preg_match("/TERRITORY/i",$agent_dial_owner_only)) 
								{
								$agent_territories='';
								$agent_choose_territories=0;
								$stmt="SELECT agent_choose_territories from vicidial_users where user='$user';";
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00406',$user,$server_ip,$session_name,$one_mysql_log);}
								$Uterrs_to_parse = mysqli_num_rows($rslt);
								if ($Uterrs_to_parse > 0) 
									{
									$rowx=mysqli_fetch_row($rslt);
									$agent_choose_territories = $rowx[0];
									}

								if ($agent_choose_territories < 1)
									{
									$stmt="SELECT territory from vicidial_user_territories where user='$user';";
									$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00407',$user,$server_ip,$session_name,$one_mysql_log);}
									$vuts_to_parse = mysqli_num_rows($rslt);
									$o=0;
									while ($vuts_to_parse > $o) 
										{
										$rowx=mysqli_fetch_row($rslt);
										$agent_territories .= "'$rowx[0]',";
										$o++;
										}
									$agent_territories = preg_replace("/\,$/",'',$agent_territories);
									$searchownerSQL=" and owner IN($agent_territories)";
									if ($vuts_to_parse < 1)
										{$searchownerSQL=" and lead_id < 0";}
									}
								else
									{
									$stmt="SELECT agent_territories from vicidial_live_agents where user='$user';";
									$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00408',$user,$server_ip,$session_name,$one_mysql_log);}
									$terrs_to_parse = mysqli_num_rows($rslt);
									if ($terrs_to_parse > 0) 
										{
										$rowx=mysqli_fetch_row($rslt);
										$agent_territories = $rowx[0];
										$agent_territories = preg_replace("/ -$|^ /",'',$agent_territories);
										$agent_territories = preg_replace("/ /","','",$agent_territories);
										$searchownerSQL=" and owner IN('$agent_territories')";
										}
									}

								$adooSQL = $searchownerSQL;
								}
							if (preg_match("/USER/i",$agent_dial_owner_only)) {$adooSQL = "and owner='$user'";}
							if (preg_match("/USER_GROUP/i",$agent_dial_owner_only)) {$adooSQL = "and owner='$user_group'";}
							if (preg_match("/_BLANK/",$agent_dial_owner_only))
								{
								$adooSQLa = preg_replace("/^and /",'',$adooSQL);
								$blankSQL = "and ( ($adooSQLa) or (owner='') or (owner is NULL) )";
								$adooSQL = $blankSQL;
								}

							if ($lead_order_randomize == 'Y') {$last_order = "RAND()";}
							else 
								{
								$last_order = "lead_id asc";
								if ($lead_order_secondary == 'LEAD_ASCEND') {$last_order = "lead_id asc";}
								if ($lead_order_secondary == 'LEAD_DESCEND') {$last_order = "lead_id desc";}
								if ($lead_order_secondary == 'CALLTIME_ASCEND') {$last_order = "last_local_call_time asc";}
								if ($lead_order_secondary == 'CALLTIME_DESCEND') {$last_order = "last_local_call_time desc";}
								if ($lead_order_secondary == 'VENDOR_ASCEND') {$last_order = "vendor_lead_code+0 asc, vendor_lead_code asc";}
								if ($lead_order_secondary == 'VENDOR_DESCEND') {$last_order = "vendor_lead_code+0 desc, vendor_lead_code desc";}
								}

							$order_stmt = '';
							if (preg_match("/DOWN/i",$lead_order)){$order_stmt = 'order by lead_id asc';}
							if (preg_match("/UP/i",$lead_order)){$order_stmt = 'order by lead_id desc';}
							if (preg_match("/UP LAST NAME/i",$lead_order)){$order_stmt = "order by last_name desc, $last_order";}
							if (preg_match("/DOWN LAST NAME/i",$lead_order)){$order_stmt = "order by last_name, $last_order";}
							if (preg_match("/UP PHONE/i",$lead_order)){$order_stmt = "order by phone_number desc, $last_order";}
							if (preg_match("/DOWN PHONE/i",$lead_order)){$order_stmt = "order by phone_number, $last_order";}
							if (preg_match("/UP COUNT/i",$lead_order)){$order_stmt = "order by called_count desc, $last_order";}
							if (preg_match("/DOWN COUNT/i",$lead_order)){$order_stmt = "order by called_count, $last_order";}
							if (preg_match("/UP LAST CALL TIME/i",$lead_order)){$order_stmt = "order by last_local_call_time desc, $last_order";}
							if (preg_match("/DOWN LAST CALL TIME/i",$lead_order)){$order_stmt = "order by last_local_call_time, $last_order";}
							if (preg_match("/RANDOM/i",$lead_order)){$order_stmt = "order by RAND()";}
							if (preg_match("/UP RANK/i",$lead_order)){$order_stmt = "order by rank desc, $last_order";}
							if (preg_match("/DOWN RANK/i",$lead_order)){$order_stmt = "order by rank, $last_order";}
							if (preg_match("/UP OWNER/i",$lead_order)){$order_stmt = "order by owner desc, $last_order";}
							if (preg_match("/DOWN OWNER/i",$lead_order)){$order_stmt = "order by owner, $last_order";}
							if (preg_match("/UP TIMEZONE/i",$lead_order)){$order_stmt = "order by gmt_offset_now desc, $last_order";}
							if (preg_match("/DOWN TIMEZONE/i",$lead_order)){$order_stmt = "order by gmt_offset_now, $last_order";}

							$stmt="UPDATE vicidial_list SET user='QUEUE$user' where called_since_last_reset='N' and ( (user NOT LIKE \"QUEUE%\") or (user is NULL) ) and status IN($Dsql) and ($list_id_sql) and ($all_gmtSQL) $CCLsql $DLTsql $fSQL $USERfSQL $adooSQL $vulnl_SQL $vulnlOVERALL_SQL $order_stmt LIMIT 1;";
							if ($dial_next_callback > 0)
								{
								$stmt="UPDATE vicidial_list SET user='QUEUE$user' where ( (user NOT LIKE \"QUEUE%\") or (user is NULL) ) $USERfSQL LIMIT 1;";
								if ($callback_list_calltime == 'ENABLED')
									{
									$stmt="UPDATE vicidial_list SET user='QUEUE$user' where ( (user NOT LIKE \"QUEUE%\") or (user is NULL) ) and ($all_gmtSQL) $USERfSQL LIMIT 1;";
									}
								}
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00242',$user,$server_ip,$session_name,$one_mysql_log);}
							$affected_rows = mysqli_affected_rows($link);

					#		$fp = fopen ("./DNNdebug_log.txt", "a");
					#		fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$agent_dialed_number|$user|M|$MqueryCID||$province|$affected_rows|$stmt|\n");
					#		fclose($fp);  

							if ($affected_rows > 0)
								{
								$stmt="SELECT lead_id,list_id,gmt_offset_now,state,entry_list_id,vendor_lead_code,status FROM vicidial_list where user='QUEUE$user' and called_since_last_reset='N' and status IN($Dsql) and list_id IN($camp_lists) and ($all_gmtSQL) and (modify_date > CONCAT(DATE_ADD(CURDATE(), INTERVAL -1 HOUR),' ',CURTIME()) ) $CCLsql $DLTsql $fSQL $USERfSQL $adooSQL order by modify_date desc LIMIT 1;";
								if ($dial_next_callback > 0)
									{
									$stmt="SELECT lead_id,list_id,gmt_offset_now,state,entry_list_id,vendor_lead_code,status FROM vicidial_list where user='QUEUE$user'  $USERfSQL LIMIT 1;";
									}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00243',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$leadpick_ct = mysqli_num_rows($rslt);
								if ($leadpick_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$lead_id =			$row[0];
									$list_id =			$row[1];
									$gmt_offset_now =	$row[2];
									$state =			$row[3];
									$entry_list_id =	$row[4];
									$vendor_lead_code = $row[5];
									$old_status =		$row[6];

									$stmt = "INSERT INTO vicidial_hopper SET lead_id='$lead_id',campaign_id='$campaign',status='QUEUE',list_id='$list_id',gmt_offset_now='$gmt_offset_now',state='$state',alt_dial='MAIN',user='$user',priority='0',source='Q',vendor_lead_code=\"$vendor_lead_code\";";
									if ($DB) {echo "$stmt\n";}
									$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00244',$user,$server_ip,$session_name,$one_mysql_log);}

									if ($find_lead_ct < 20)
										{$find_lead_ct = 20;}

									### BEGIN user_new_lead_limit logging section ###
									if ( ($old_status == 'NEW') and ($SSuser_new_lead_limit > 0) )
										{
										$stmt="SELECT new_count FROM vicidial_user_list_new_lead WHERE list_id='$list_id' and user='$user';";
										$rslt=mysql_to_mysqli($stmt, $link);
											if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00656',$user,$server_ip,$session_name,$one_mysql_log);}
										if ($DB) {echo "$stmt\n";}
										$vulnl_ct = mysqli_num_rows($rslt);
										if ($vulnl_ct > 0)
											{
											$row=mysqli_fetch_row($rslt);
											$new_countUPDATE =			($row[0] + 1);

											$stmt = "UPDATE vicidial_user_list_new_lead SET new_count='$new_countUPDATE' WHERE list_id='$list_id' and user='$user';";
											if ($DB) {echo "$stmt\n";}
											$rslt=mysql_to_mysqli($stmt, $link);
												if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00657',$user,$server_ip,$session_name,$one_mysql_log);}
											}
										else
											{
											$stmt = "INSERT INTO vicidial_user_list_new_lead SET list_id='$list_id',user='$user',new_count='1';";
											if ($DB) {echo "$stmt\n";}
											$rslt=mysql_to_mysqli($stmt, $link);
												if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00658',$user,$server_ip,$session_name,$one_mysql_log);}
											}
										}
									### END user_new_lead_limit logging section ###
									}
								}
							}
						}
					##########################################################
					### END  find the next lead to dial without looking in the hopper
					##########################################################
				#	$DB=0;
					}
				}
			}
		if ($affected_rows > 0)
			{
			if (!$CBleadIDset)
				{
				##### grab the lead_id of the reserved user in vicidial_hopper
				$stmt="SELECT lead_id FROM vicidial_hopper where campaign_id='$campaign' and status='QUEUE' and user='$user' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00025',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$hopper_leadID_ct = mysqli_num_rows($rslt);
				if ($hopper_leadID_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$lead_id =$row[0];
					}
				}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00026',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$entry_date		= trim("$row[1]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$lead_list_id	= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$called_since_last_reset = trim("$row[9]");
				$phone_code		= trim("$row[10]");
				if ($override_phone < 1)
					{$phone_number	= trim("$row[11]");}
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase		= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
					if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}
			if ($qc_features_active > 0)
				{
				//Added by Poundteam for Audited Comments
				##### if list has audited comments, grab the audited comments
				require_once('audit_comments.php');
				$ACcount =		'';
				$ACcomments =		'';
				$audit_comments_active=audit_comments_active($list_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
				if ($audit_comments_active)
					{
					get_audited_comments($lead_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
					}
				$ACcomments = strip_tags(htmlentities($ACcomments));
				$ACcomments = preg_replace("/\r/i",'',$ACcomments);
				$ACcomments = preg_replace("/\n/i",'!N',$ACcomments);
				//END Added by Poundteam for Audited Comments
				}

			$called_count++;

			if ( (strlen($agent_dialed_type) < 3) or (strlen($agent_dialed_number) < 6) )
				{
				$agent_dialed_number = $phone_number;
				if (strlen($agent_dialed_type) < 3)
					{$agent_dialed_type = 'MAIN';}
				}
			if ( (strlen($callback_id)>0) and (strlen($lead_id)>0) )
				{
				if ($agent_dialed_type=='ALT')
					{$agent_dialed_number = $alt_phone;}
				if ($agent_dialed_type=='ADDR3')
					{$agent_dialed_number = $address3;}
				}

			##### BEGIN check for postal_code and phone time zones if alert enabled
			$post_phone_time_diff_alert_message='';
			$stmt="SELECT post_phone_time_diff_alert,local_call_time,owner_populate,default_xfer_group FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00414',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$camp_pptda_ct = mysqli_num_rows($rslt);
			if ($camp_pptda_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$post_phone_time_diff_alert =	$row[0];
				$local_call_time =				$row[1];
				$owner_populate =				$row[2];
				$default_xfer_group =			$row[3];
				}
			if ( ($post_phone_time_diff_alert == 'ENABLED') or (preg_match("/OUTSIDE_CALLTIME/",$post_phone_time_diff_alert)) )
				{
				### get current gmt_offset of the phone_number
				$postalgmtNOW = '';
				$USarea = substr($agent_dialed_number, 0, 3);
				$PHONEgmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmtNOW,$postal_code);

				$postalgmtNOW = 'POSTAL';
				$POSTgmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmtNOW,$postal_code);

				### Get local_call_time for list
				$stmt="SELECT local_call_time,list_description FROM vicidial_lists where list_id='$lead_list_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00608',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$list_local_call_time =	$row[0];
				$list_description =		$row[1];

				# check that call time exists
				if ($list_local_call_time != "campaign") 
					{
					$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$list_local_call_time';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00614',$user,$server_ip,$session_name,$one_mysql_log);}					
					$row=mysqli_fetch_row($rslt);
					$call_time_exists  =	$row[0];
					if ($call_time_exists < 1) 
						{$list_local_call_time = 'campaign';}
					}

				#Check if we are within the gmt for campaign for $PHONEdialable
				if ( (dialable_gmt($DB,$link,$local_call_time,$PHONEgmt_offset,$state) == 1) and ($list_local_call_time != "campaign") )
					{
					#Now check if we are with the GMT for the list local call time
					$PHONEdialable = dialable_gmt($DB,$link,$list_local_call_time,$PHONEgmt_offset,$state);
					}
				else 
					{
					$PHONEdialable = dialable_gmt($DB,$link,$local_call_time,$PHONEgmt_offset,$state);
					}
				#Check if we are with the gmt for campaign for $POSTdialable
				if ( (dialable_gmt($DB,$link,$local_call_time,$POSTgmt_offset,$state) == 1) and ($list_local_call_time != "campaign") )
					{
					#Now check if we are with the GMT for the list local call time
					$POSTdialable = dialable_gmt($DB,$link,$list_local_call_time,$POSTgmt_offset,$state);
					}
				else 
					{
					$POSTdialable = dialable_gmt($DB,$link,$local_call_time,$POSTgmt_offset,$state);
					}

			#	$post_phone_time_diff_alert_message = "$POSTgmt_offset|$POSTdialable   ---   $PHONEgmt_offset|$PHONEdialable|$USarea";
				$post_phone_time_diff_alert_message = '';

				if ($PHONEgmt_offset != $POSTgmt_offset)
					{
					$post_phone_time_diff_alert_message .= _QXZ("Phone and Post Code Time Zone Mismatch! ");

					if ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_ONLY')
						{
						$post_phone_time_diff_alert_message='';
						if ($PHONEdialable < 1)
							{$post_phone_time_diff_alert_message .= _QXZ(" Phone Area Code Outside Dialable Zone")." $PHONEgmt_offset ";}
						if ($POSTdialable < 1)
							{$post_phone_time_diff_alert_message .= _QXZ(" Postal Code Outside Dialable Zone")." $POSTgmt_offset";}
						}
					}
				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_PHONE') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_POSTAL') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{$post_phone_time_diff_alert_message = '';}

				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_PHONE') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{
					if ($PHONEdialable < 1)
						{$post_phone_time_diff_alert_message .= _QXZ(" Phone Area Code Outside Dialable Zone")." $PHONEgmt_offset ";}
					}
				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_POSTAL') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{
					if ($POSTdialable < 1)
						{$post_phone_time_diff_alert_message .= _QXZ(" Postal Code Outside Dialable Zone")." $POSTgmt_offset ";}
					}
				}
			##### END check for postal_code and phone time zones if alert enabled


			##### if lead is a callback, grab the callback comments
			$CBentry_time =		'';
			$CBcallback_time =	'';
			$CBuser =			'';
			$CBcomments =		'';
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00366',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00367',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or ($dispo == 'CBHOLD') or ($dial_next_callback > 0) )
				{
				$stmt="SELECT entry_time,callback_time,user,comments FROM vicidial_callbacks where lead_id='$lead_id' order by callback_id desc LIMIT 1;";

				if ($dial_next_callback > 0)
					{
					$stmt = "UPDATE vicidial_callbacks set status='INACTIVE' where callback_id='$callback_id';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00708',$user,$server_ip,$session_name,$one_mysql_log);}

					$stmt="SELECT entry_time,callback_time,user,comments FROM vicidial_callbacks where lead_id='$lead_id' and callback_id='$callback_id' LIMIT 1;";
					}

				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00028',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBentry_time =		trim("$row[0]");
					$CBcallback_time =	trim("$row[1]");
					$CBuser =			trim("$row[2]");
					$CBcomments =		trim("$row[3]");

					}
				}

			$stmt = "SELECT local_gmt FROM servers where active='Y' limit 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00029',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$server_ct = mysqli_num_rows($rslt);
			if ($server_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$local_gmt =	$row[0];
				$isdst = date("I");
				if ($isdst) {$local_gmt++;}
				}
			$LLCT_DATE_offset = ($local_gmt - $gmt_offset_now);
			$LLCT_DATE = date("Y-m-d H:i:s", mktime(date("H")-$LLCT_DATE_offset,date("i"),date("s"),date("m"),date("d"),date("Y")));

			if (preg_match('/Y/',$called_since_last_reset))
				{
				$called_since_last_reset = preg_replace('/Y/','',$called_since_last_reset);
				if (strlen($called_since_last_reset) < 1) {$called_since_last_reset = 0;}
				$called_since_last_reset++;
				$called_since_last_reset = "Y$called_since_last_reset";
				}
			else {$called_since_last_reset = 'Y';}
			$ownerSQL='';
			if ( ($owner_populate=='ENABLED') and ( (strlen($owner) < 1) or ($owner=='NULL') ) )
				{
				$ownerSQL = ",owner='$user'";
				$owner=$user;
				}
			### flag the lead as called and change it's status to INCALL
			$stmt = "UPDATE vicidial_list set status='INCALL', called_since_last_reset='$called_since_last_reset', called_count='$called_count',user='$user',last_local_call_time='$LLCT_DATE'$ownerSQL where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00030',$user,$server_ip,$session_name,$one_mysql_log);}

			if (!$CBleadIDset)
				{
				### delete the lead from the hopper
				$stmt = "DELETE FROM vicidial_hopper where lead_id='$lead_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00031',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			$stmt="UPDATE vicidial_agent_log set lead_id='$lead_id',comments='MANUAL' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00032',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmt="UPDATE vicidial_lists set list_lastcalldate=NOW() where list_id='$list_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00439',$user,$server_ip,$session_name,$one_mysql_log);}

			$campaign_cid_override='';
			$LISTweb_form_address='';
			$LISTweb_form_address_two='';
			$LISTweb_form_address_three='';
			### check if there is a list_id override
			if (strlen($list_id) > 1)
				{
				$stmt = "SELECT campaign_cid_override,web_form_address,web_form_address_two,web_form_address_three,list_description,default_xfer_group FROM vicidial_lists where list_id='$list_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00245',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$lio_ct = mysqli_num_rows($rslt);
				if ($lio_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$campaign_cid_override =		$row[0];
					$LISTweb_form_address =			$row[1];
					$LISTweb_form_address_two =		$row[2];
					$LISTweb_form_address_three =	$row[3];
					$list_description =				$row[4];
					$LISTdefault_xfer_group =		$row[5];
					if ( (strlen($LISTdefault_xfer_group)>0) and (!preg_match("/---NONE---/",$LISTdefault_xfer_group)) )
						{$default_xfer_group = $LISTdefault_xfer_group;}
					}
				}

			##### BEGIN if preview dialing, do not send the call #####
			if ($preview == 'YES')
				{
				### update the agent record with the preview_lead_id in vicidial_live_agents
				$stmt = "UPDATE vicidial_live_agents set preview_lead_id='$lead_id' where user='$user' and server_ip='$server_ip';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00590',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			##### BEGIN if NOT preview dialing, do send the call #####
			if ( (strlen($preview)<1) or ($preview == 'NO') or (strlen($dial_ingroup) > 1) )
				{
				### prepare variables to place manual call from VICIDiaL
				$CCID_on=0;   $CCID='';
				$local_DEF = 'Local/';
				$local_AMP = '@';
				$Local_out_prefix = '9';
				$Local_dial_timeout = '60';
				$Local_persist = '';	#	$Local_persist = '/n';
				if ($dial_timeout > 4) {$Local_dial_timeout = $dial_timeout;}
				$Local_dial_timeout = ($Local_dial_timeout * 1000);
				if (strlen($dial_prefix) > 0) {$Local_out_prefix = "$dial_prefix";}
				if (strlen($campaign_cid) > 6) {$CCID = "$campaign_cid";   $CCID_on++;}
				### check for custom cid use
				$use_custom_cid=0;
				$stmt = "SELECT use_custom_cid,manual_dial_hopper_check,start_call_url,manual_dial_filter,use_internal_dnc,use_campaign_dnc,use_other_campaign_dnc,cid_group_id FROM vicidial_campaigns where campaign_id='$campaign';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00313',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$uccid_ct = mysqli_num_rows($rslt);
				if ($uccid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$use_custom_cid =			$row[0];
					$manual_dial_hopper_check =	$row[1];
					$OUT_start_call_url =		$row[2];
					$manual_dial_filter =		$row[3];
					$use_internal_dnc =			$row[4];
					$use_campaign_dnc =			$row[5];
					$use_other_campaign_dnc =	$row[6];
					$cid_group_id =				$row[7];
					}

				if ($no_hopper_dialing_used > 0)
					{
					### BEGIN check phone filtering for DNC or camplists if enabled ###
					if (preg_match("/DNC/",$manual_dial_filter))
						{
						if (preg_match("/AREACODE/",$use_internal_dnc))
							{
							$phone_number_areacode = substr($agent_dialed_number, 0, 3);
							$phone_number_areacode .= "XXXXXXX";
							$stmt="SELECT count(*) from vicidial_dnc where phone_number IN('$agent_dialed_number','$phone_number_areacode');";
							}
						else
							{$stmt="SELECT count(*) FROM vicidial_dnc where phone_number='$agent_dialed_number';";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00685',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$row=mysqli_fetch_row($rslt);
						if ($row[0] > 0)
							{
							### flag the lead as DNCL
							$stmt = "UPDATE vicidial_list set status='DNCL' where lead_id='$lead_id';";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00686',$user,$server_ip,$session_name,$one_mysql_log);}

							### reset agent log record
							$stmt="UPDATE vicidial_agent_log set lead_id=NULL,comments='' where agent_log_id='$agent_log_id';";
								if ($format=='debug') {echo "\n<!-- $stmt -->";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00687',$user,$server_ip,$session_name,$one_mysql_log);}

							echo " NO-HOPPER DNC\nTRY AGAIN\n";
							$stage .= "|$agent_log_id|$vla_status|$agent_dialed_type|$agent_dialed_number|";
							if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
							exit;
							}
						if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
							{
							$stmt="SELECT use_other_campaign_dnc from vicidial_campaigns where campaign_id='$campaign';";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00688',$user,$server_ip,$session_name,$one_mysql_log);}
							$row=mysqli_fetch_row($rslt);
							$use_other_campaign_dnc =	$row[0];
							$temp_campaign_id = $campaign;
							if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}

							if (preg_match("/AREACODE/",$use_campaign_dnc))
								{
								$phone_number_areacode = substr($agent_dialed_number, 0, 3);
								$phone_number_areacode .= "XXXXXXX";
								$stmt="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$agent_dialed_number','$phone_number_areacode') and campaign_id='$temp_campaign_id';";
								}
							else
								{$stmt="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$agent_dialed_number' and campaign_id='$temp_campaign_id';";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00689',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$row=mysqli_fetch_row($rslt);
							if ($row[0] > 0)
								{
								### flag the lead as DNCC
								$stmt = "UPDATE vicidial_list set status='DNCC' where lead_id='$lead_id';";
								if ($DB) {echo "$stmt\n";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00690',$user,$server_ip,$session_name,$one_mysql_log);}

								### reset agent log record
								$stmt="UPDATE vicidial_agent_log set lead_id='0',comments='' where agent_log_id='$agent_log_id';";
									if ($format=='debug') {echo "\n<!-- $stmt -->";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00691',$user,$server_ip,$session_name,$one_mysql_log);}

								echo " NO-HOPPER DNC CAMPAIGN\nTRY AGAIN\n";
								$stage .= "|$agent_log_id|$vla_status|$agent_dialed_type|$agent_dialed_number|";
								if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
								exit;
								}
							}
						}
					}

				if (strlen($campaign_cid_override) > 6) {$CCID = "$campaign_cid_override";   $CCID_on++;}
				else
					{
					if ($uccid_ct > 0)
						{
						if ($use_custom_cid == 'Y')
							{
							$temp_CID = preg_replace("/\D/",'',$security_phrase);
							if (strlen($temp_CID) > 6) 
								{$CCID = "$temp_CID";   $CCID_on++;}
							}
						if ( (preg_match('/^USER_CUSTOM/', $use_custom_cid)) and ($cid_lock < 1) )
							{
							$temp_vu='';
							$use_custom_cid=preg_replace('/^USER_/', "", $use_custom_cid);
							$pattern=array('/1/', '/2/', '/3/', '/4/', '/5/');
							$replace=array('one', 'two', 'three', 'four', 'five');
							$use_custom_cid = strtolower(preg_replace($pattern,$replace, $use_custom_cid));
							$stmt="select $use_custom_cid from vicidial_users where user='$user'";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00660',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$vu_ct = mysqli_num_rows($rslt);
							$act=0;
							while ($vu_ct > $act)
								{
								$row=mysqli_fetch_row($rslt);
								$temp_vu =	$row[0];
								$act++;
								}
							$temp_CID = preg_replace("/\D/",'',$temp_vu);
							if (strlen($temp_CID) > 6) 
								{$CCID = "$temp_CID";   $CCID_on++;}
							}
						$CIDG_set=0;
						if ( ($cid_group_id != '---DISABLED---') and ($cid_lock < 1) )
							{
							$stmt = "SELECT cid_group_type FROM vicidial_cid_groups where cid_group_id='$cid_group_id';";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00714',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$cidg_ct = mysqli_num_rows($rslt);
							if ($cidg_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$cid_group_type =	$row[0];
								$temp_vcca='';
								$temp_ac='';

								if ($cid_group_type == 'AREACODE')
									{
									$temp_ac_two = substr("$agent_dialed_number", 0, 2);
									$temp_ac_three = substr("$agent_dialed_number", 0, 3);
									$temp_ac_four = substr("$agent_dialed_number", 0, 4);
									$temp_ac_five = substr("$agent_dialed_number", 0, 5);
									$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$cid_group_id' and areacode IN('$temp_ac_two','$temp_ac_three','$temp_ac_four','$temp_ac_five') and active='Y' order by CAST(areacode as SIGNED INTEGER) asc, call_count_today desc limit 100000;";
									}
								if ($cid_group_type == 'STATE')
									{
									$temp_state = $state;
									$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$cid_group_id' and areacode IN('$temp_state') and active='Y' order by call_count_today desc limit 100000;";
									}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00715',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$vcca_ct = mysqli_num_rows($rslt);
								$act=0;
								while ($vcca_ct > $act)
									{
									$row=mysqli_fetch_row($rslt);
									$temp_vcca =	$row[0];
									$temp_ac =		$row[1];
									$act++;
									}
								if ($act > 0) 
									{
									$stmt="UPDATE vicidial_campaign_cid_areacodes set call_count_today=(call_count_today + 1) where campaign_id='$cid_group_id' and areacode='$temp_ac' and outbound_cid='$temp_vcca';";
										if ($format=='debug') {echo "\n<!-- $stmt -->";}
									$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00716',$user,$server_ip,$session_name,$one_mysql_log);}
									}
								}
							$temp_CID = preg_replace("/\D/",'',$temp_vcca);
							if (strlen($temp_CID) > 6) 
								{$CCID = "$temp_CID";   $CCID_on++;   $CIDG_set++;}
							}
						if ( ($use_custom_cid == 'AREACODE') and ($cid_lock < 1) and ($CIDG_set < 1) )
							{
							$temp_vcca='';
							$temp_ac='';
							$temp_ac_two = substr("$agent_dialed_number", 0, 2);
							$temp_ac_three = substr("$agent_dialed_number", 0, 3);
							$temp_ac_four = substr("$agent_dialed_number", 0, 4);
							$temp_ac_five = substr("$agent_dialed_number", 0, 5);
							$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$campaign' and areacode IN('$temp_ac_two','$temp_ac_three','$temp_ac_four','$temp_ac_five') and active='Y' order by CAST(areacode as SIGNED INTEGER) asc, call_count_today desc limit 100000;";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00426',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$vcca_ct = mysqli_num_rows($rslt);
							$act=0;
							while ($vcca_ct > $act)
								{
								$row=mysqli_fetch_row($rslt);
								$temp_vcca =	$row[0];
								$temp_ac =		$row[1];
								$act++;
								}
							if ($act > 0) 
								{
								$stmt="UPDATE vicidial_campaign_cid_areacodes set call_count_today=(call_count_today + 1) where campaign_id='$campaign' and areacode='$temp_ac' and outbound_cid='$temp_vcca';";
									if ($format=='debug') {echo "\n<!-- $stmt -->";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00427',$user,$server_ip,$session_name,$one_mysql_log);}
								}

							$temp_CID = preg_replace("/\D/",'',$temp_vcca);
							if (strlen($temp_CID) > 6) 
								{$CCID = "$temp_CID";   $CCID_on++;}
							}
						}
					}

				if (preg_match("/x/i",$dial_prefix)) {$Local_out_prefix = '';}

				$PADlead_id = sprintf("%010s", $lead_id);
					while (strlen($PADlead_id) > 10) {$PADlead_id = substr("$PADlead_id", 1);}

				#### BEGIN run manual_dial_hopper_check process if enabled
				if ($manual_dial_hopper_check == 'Y')
					{
					$mdhc_lead_ids_SQL='';
					$stmt = "SELECT lead_id FROM vicidial_list where phone_number='$agent_dialed_number';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00650',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$mdhc_ct = mysqli_num_rows($rslt);
					$d=0;
					while ($mdhc_ct > $d)
						{
						$row=mysqli_fetch_row($rslt);
						$mdhc_lead_ids_SQL .=	"'$row[0]',";
						$d++;
						}
					if ($mdhc_ct > 0)
						{
						$stmt = "DELETE FROM vicidial_hopper where lead_id IN($mdhc_lead_ids_SQL'');";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00651',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					}
				#### END run manual_dial_hopper_check process if enabled

				### check for extension append in campaign
				$use_eac=0;
				$stmt = "SELECT count(*) FROM vicidial_campaigns where extension_appended_cidname='Y' and campaign_id='$campaign';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00322',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$eacid_ct = mysqli_num_rows($rslt);
				if ($eacid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$use_eac =	$row[0];
					}

				# Create unique calleridname to track the call: MmddhhmmssLLLLLLLLLL
				$MqueryCID = "M$CIDdate$PADlead_id";
				$EAC='';
				if ($use_eac > 0)
					{
					$eac_extension = preg_replace("/SIP\/|IAX2\/|Zap\/|DAHDI\/|Local\//",'',$eac_phone);
					$EAC=" $eac_extension";
					}

				### whether to omit phone_code or not
				if (preg_match('/Y/i',$omit_phone_code)) 
					{$Ndialstring = "$Local_out_prefix$agent_dialed_number";}
				else
					{$Ndialstring = "$Local_out_prefix$phone_code$agent_dialed_number";}

				if ( ($usegroupalias > 0) and (strlen($account)>1) )
					{
					$RAWaccount = $account;
					$account = "Account: $account";
					$variable = "Variable: usegroupalias=1";
					}
				else
					{$account='';   $variable='';}

				$dial_channel = "$local_DEF$conf_exten$local_AMP$ext_context$Local_persist";

				$preset_name='';
				if (strlen($dial_ingroup) > 1)
					{
					### look for a dial-ingroup cid
					$dial_ingroup_cid='';
					$stmt = "SELECT dial_ingroup_cid,start_call_url FROM vicidial_inbound_groups where group_id='$dial_ingroup';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00440',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$digcid_ct = mysqli_num_rows($rslt);
					if ($digcid_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$dial_ingroup_cid =		$row[0];
						$IN_start_call_url =	$row[1];
						}
					if (strlen($dial_ingroup_cid) > 6) {$CCID = "$dial_ingroup_cid";   $CCID_on++;}

					$preset_name='DIG';
					$MqueryCID = "Y$CIDdate$PADlead_id";
					
					$loop_ingroup_dial_prefix = '8305888888888888';
					$dial_wait_seconds = '4';	# 1 digit only
					if ($nocall_dial_flag == 'ENABLED')
						{
						$Ndialstring = "$loop_ingroup_dial_prefix$dial_wait_seconds" . "999";
						$preset_name='DIG_NODIAL';
						}
					else
						{$Ndialstring = "$loop_ingroup_dial_prefix$dial_wait_seconds$Ndialstring";}

	#				$dial_ingroup_dialstring = "90009*$dial_ingroup" . "**$lead_id" . "**$agent_dialed_number" . "*$user" . "*$user" . "**1*$conf_exten";
	#				$dial_channel = "$local_DEF$dial_ingroup_dialstring$local_AMP$ext_context$Local_persist";

					$dial_channel = "$local_DEF$Ndialstring$local_AMP$ext_context$Local_persist";

					$dial_wait_seconds = '0';	# 1 digit only
					$dial_ingroup_dialstring = "90009*$dial_ingroup" . "**$lead_id" . "**$agent_dialed_number" . "*$user" . "*$user" . "**1*$conf_exten";
					$Ndialstring = "$loop_ingroup_dial_prefix$dial_wait_seconds$dial_ingroup_dialstring";
					}

				if ($CCID_on) {$CIDstring = "\"$MqueryCID$EAC\" <$CCID>";}
				else {$CIDstring = "$MqueryCID$EAC";}

				### insert the call action into the vicidial_manager table to initiate the call
				#	$stmt = "INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Originate','$MqueryCID','Exten: $conf_exten','Context: $ext_context','Channel: $local_DEF$Local_out_prefix$phone_code$phone_number$local_AMP$ext_context','Priority: 1','Callerid: $CIDstring','Timeout: $Local_dial_timeout','','','','');";
				$stmt = "INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Originate','$MqueryCID','Exten: $Ndialstring','Context: $ext_context','Channel: $dial_channel','Priority: 1','Callerid: $CIDstring','Timeout: $Local_dial_timeout','$account','$variable','','');";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00033',$user,$server_ip,$session_name,$one_mysql_log);}

				### log outbound call in the dial log
				$stmt = "INSERT INTO vicidial_dial_log SET caller_code='$MqueryCID',lead_id='$lead_id',server_ip='$server_ip',call_date='$NOW_TIME',extension='$Ndialstring',channel='$dial_channel', timeout='$Local_dial_timeout',outbound_cid='$CIDstring',context='$ext_context';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00442',$user,$server_ip,$session_name,$one_mysql_log);}

				### Skip logging and list overrides if dial in-group is used
				if (strlen($dial_ingroup) < 1)
					{
					$stmt = "INSERT INTO vicidial_auto_calls (server_ip,campaign_id,status,lead_id,callerid,phone_code,phone_number,call_time,call_type) values('$server_ip','$campaign','XFER','$lead_id','$MqueryCID','$phone_code','$agent_dialed_number','$NOW_TIME','OUT')";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00034',$user,$server_ip,$session_name,$one_mysql_log);}
					}

				### update the agent status to INCALL in vicidial_live_agents
				$stmt = "UPDATE vicidial_live_agents set status='INCALL',last_call_time='$NOW_TIME',callerid='$MqueryCID',lead_id='$lead_id',comments='MANUAL',calls_today='$calls_today',external_hangup=0,external_status='',external_pause='',external_dial='',last_state_change='$NOW_TIME',pause_code='' where user='$user' and server_ip='$server_ip';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00035',$user,$server_ip,$session_name,$one_mysql_log);}

				### update calls_today count in vicidial_campaign_agents
				$stmt = "UPDATE vicidial_campaign_agents set calls_today='$calls_today' where user='$user' and campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00036',$user,$server_ip,$session_name,$one_mysql_log);}

				if ($agent_dialed_number > 0)
					{
					$stmt = "INSERT INTO user_call_log (user,call_date,call_type,server_ip,phone_number,number_dialed,lead_id,callerid,group_alias_id,preset_name) values('$user','$NOW_TIME','$agent_dialed_type','$server_ip','$agent_dialed_number','$Ndialstring','$lead_id','$CCID','$RAWaccount','$preset_name')";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00191',$user,$server_ip,$session_name,$one_mysql_log);}
					}

				### Skip logging and list overrides if dial in-group is used
				if (strlen($dial_ingroup) < 1)
					{
					$val_pause_epoch=0;
					$val_pause_sec=0;
					$stmt = "SELECT pause_epoch,pause_sec,wait_epoch,wait_sec FROM vicidial_agent_log where agent_log_id='$agent_log_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00323',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vald_ct = mysqli_num_rows($rslt);
					if ($vald_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						if ($last_VDRP_stage == 'PAUSED')
							{
							$val_pause_epoch =	$row[0];
							$val_pause_sec = ($StarTtime - $val_pause_epoch);
							$val_SQL = "set pause_sec='$val_pause_sec',wait_epoch='$StarTtime'";
							}
						else
							{
							$val_wait_epoch =	$row[2];
							$val_wait_sec = ($StarTtime - $val_wait_epoch);
							$val_SQL = "set wait_sec='$val_wait_sec'";
							}
						}

					$stmt="UPDATE vicidial_agent_log $val_SQL where agent_log_id='$agent_log_id';";
						if ($format=='debug') {echo "\n<!-- $stmt -->";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00324',$user,$server_ip,$session_name,$one_mysql_log);}

					#############################################
					##### START QUEUEMETRICS LOGGING LOOKUP #####
					$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_pe_phone_append,queuemetrics_socket,queuemetrics_socket_url,queuemetrics_pause_type FROM system_settings;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00037',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$qm_conf_ct = mysqli_num_rows($rslt);
					if ($qm_conf_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$enable_queuemetrics_logging =	$row[0];
						$queuemetrics_server_ip	=		$row[1];
						$queuemetrics_dbname =			$row[2];
						$queuemetrics_login	=			$row[3];
						$queuemetrics_pass =			$row[4];
						$queuemetrics_log_id =			$row[5];
						$queuemetrics_pe_phone_append = $row[6];
						$queuemetrics_socket =			$row[7];
						$queuemetrics_socket_url =		$row[8];
						$queuemetrics_pause_type =		$row[9];
						}
					##### END QUEUEMETRICS LOGGING LOOKUP #####
					###########################################

					if ($enable_queuemetrics_logging > 0)
						{
						$data4SQL='';
						$data4SS='';
						$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00389',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$cqpe_ct = mysqli_num_rows($rslt);
						if ($cqpe_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$pe_append='';
							if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
								{$pe_append = "-$qm_extension";}
							$data4SQL = ",data4='$row[0]$pe_append'";
							$data4SS = "&data4=$row[0]$pe_append";
							}

						$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
						if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
						mysqli_select_db($linkB, "$queuemetrics_dbname");

						# UNPAUSEALL
						$pause_typeSQL='';
						if ($queuemetrics_pause_type > 0)
							{$pause_typeSQL=",data5='AGENT'";}
						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='UNPAUSEALL',serverid='$queuemetrics_log_id' $data4SQL $pause_typeSQL;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00038',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);

						# CALLOUTBOUND (formerly ENTERQUEUE)
						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MqueryCID',queue='$campaign',agent='NONE',verb='CALLOUTBOUND',data2='$agent_dialed_number',serverid='$queuemetrics_log_id' $data4SQL;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00039',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);

						# CONNECT
						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MqueryCID',queue='$campaign',agent='Agent/$user',verb='CONNECT',data1='0',serverid='$queuemetrics_log_id' $data4SQL;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00040',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);

						mysqli_close($linkB);

						if ( ($queuemetrics_socket == 'CONNECT_COMPLETE') and (strlen($queuemetrics_socket_url) > 10) )
							{
							if (preg_match("/--A--/",$queuemetrics_socket_url))
								{
								$queuemetrics_socket_url = preg_replace('/^VAR/','',$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--lead_id--B--/i',"$lead_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--list_id--B--/i',"$list_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--phone_number--B--/i',"$phone_number",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--title--B--/i',"$title",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--first_name--B--/i',"$first_name",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--last_name--B--/i',"$last_name",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--postal_code--B--/i',"$postal_code",$queuemetrics_socket_url);
								}
							$socket_send_data_begin='?';
							$socket_send_data = "time_id=$StarTtime&call_id=$MqueryCID&queue=$campaign&agent=Agent/$user&verb=CONNECT&data1=0$data4SS";
							if (preg_match("/\?/",$queuemetrics_socket_url))
								{$socket_send_data_begin='&';}
							### send queue_log data to the queuemetrics_socket_url ###
							if ($DB > 0) {echo "$queuemetrics_socket_url$socket_send_data_begin$socket_send_data<BR>\n";}
							$SCUfile = file("$queuemetrics_socket_url$socket_send_data_begin$socket_send_data");
							if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}
							}
						}
					}

				##### check if system is set to generate logfile for transfers
				$stmt="SELECT enable_agc_xfer_log FROM system_settings;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00027',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$enable_agc_xfer_log_ct = mysqli_num_rows($rslt);
				if ($enable_agc_xfer_log_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$enable_agc_xfer_log =$row[0];
					}
				if ( ($WeBRooTWritablE > 0) and ($enable_agc_xfer_log > 0) )
					{
					#	DATETIME|campaign|lead_id|phone_number|user|type
					#	2007-08-22 11:11:11|TESTCAMP|65432|3125551212|1234|M
					$fp = fopen ("./xfer_log.txt", "a");
					fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$agent_dialed_number|$user|M|$MqueryCID||$province\n");
					fclose($fp);
					}

				### BEGIN start_call_url processing ###
				if (strlen($IN_start_call_url) > 7)
					{$VDCL_start_call_url = $IN_start_call_url;}
				else
					{$VDCL_start_call_url = $OUT_start_call_url;}

				### Issue Start Call URL if defined
				if (strlen($VDCL_start_call_url) > 7)
					{
					if (preg_match('/--A--user_custom_/i',$VDCL_start_call_url))
						{
						$stmt = "SELECT custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_users where user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00662',$user,$server_ip,$session_name,$one_mysql_log);}
						$VUC_ct = mysqli_num_rows($rslt);
						if ($VUC_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$user_custom_one	=		urlencode(trim($row[0]));
							$user_custom_two	=		urlencode(trim($row[1]));
							$user_custom_three	=		urlencode(trim($row[2]));
							$user_custom_four	=		urlencode(trim($row[3]));
							$user_custom_five	=		urlencode(trim($row[4]));
							}
						}
					$VDCL_start_call_url = preg_replace('/^VAR/','',$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--lead_id--B--/i',urlencode(trim($lead_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--vendor_id--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--vendor_lead_code--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--list_id--B--/i',urlencode(trim($list_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--list_name--B--/i',urlencode(trim($list_name)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--list_description--B--/i',urlencode(trim($list_description)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--gmt_offset_now--B--/i',urlencode(trim($gmt_offset_now)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--phone_code--B--/i',urlencode(trim($phone_code)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--phone_number--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--title--B--/i',urlencode(trim($title)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--first_name--B--/i',urlencode(trim($first_name)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--middle_initial--B--/i',urlencode(trim($middle_initial)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--last_name--B--/i',urlencode(trim($last_name)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--address1--B--/i',urlencode(trim($address1)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--address2--B--/i',urlencode(trim($address2)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--address3--B--/i',urlencode(trim($address3)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--city--B--/i',urlencode(trim($city)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--state--B--/i',urlencode(trim($state)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--province--B--/i',urlencode(trim($province)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--postal_code--B--/i',urlencode(trim($postal_code)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--country_code--B--/i',urlencode(trim($country_code)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--gender--B--/i',urlencode(trim($gender)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--date_of_birth--B--/i',urlencode(trim($date_of_birth)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--alt_phone--B--/i',urlencode(trim($alt_phone)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--email--B--/i',urlencode(trim($email)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--security_phrase--B--/i',urlencode(trim($security_phrase)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--comments--B--/i',urlencode(trim($comments)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user--B--/i',urlencode(trim($user)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--pass--B--/i',urlencode(trim($orig_pass)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--campaign--B--/i',urlencode(trim($campaign)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--phone_login--B--/i',urlencode(trim($phone_login)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--original_phone_login--B--/i',urlencode(trim($original_phone_login)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--phone_pass--B--/i',urlencode(trim($phone_pass)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--fronter--B--/i',urlencode(trim($fronter)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--closer--B--/i',urlencode(trim($closer)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--channel_group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--SQLdate--B--/i',urlencode(trim($SQLdate)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--epoch--B--/i',urlencode(trim($epoch)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--uniqueid--B--/i',urlencode(trim($uniqueid)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--customer_zap_channel--B--/i',urlencode(trim($channel)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--customer_server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--SIPexten--B--/i',urlencode(trim($exten)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--session_id--B--/i',urlencode(trim($conf_exten)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--phone--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--parked_by--B--/i',urlencode(trim($parked_by)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--dispo--B--/i',urlencode(trim($dispo)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--dialed_number--B--/i',urlencode(trim($agent_dialed_number)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--dialed_label--B--/i',urlencode(trim($agent_dialed_type)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--source_id--B--/i',urlencode(trim($source_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--rank--B--/i',urlencode(trim($rank)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--owner--B--/i',urlencode(trim($owner)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--camp_script--B--/i',urlencode(trim($camp_script)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--in_script--B--/i',urlencode(trim($VDCL_ingroup_script)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--fullname--B--/i',urlencode(trim($fullname)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_custom_one--B--/i',urlencode(trim($user_custom_one)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_custom_two--B--/i',urlencode(trim($user_custom_two)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_custom_three--B--/i',urlencode(trim($user_custom_three)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_custom_four--B--/i',urlencode(trim($user_custom_four)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_custom_five--B--/i',urlencode(trim($user_custom_five)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--talk_time--B--/i',"0",$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--talk_time_min--B--/i',"0",$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--entry_list_id--B--/i',urlencode(trim($entry_list_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--closecallid--B--/i',urlencode(trim($INclosecallid)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--xfercallid--B--/i',urlencode(trim($INxfercallid)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--agent_log_id--B--/i',urlencode(trim($agent_log_id)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--call_id--B--/i',urlencode(trim($MqueryCID)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--user_group--B--/i',urlencode(trim($user_group)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--entry_date--B--/i',urlencode(trim($entry_date)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--agent_email--B--/i',urlencode(trim($agent_email)),$VDCL_start_call_url);
					$VDCL_start_call_url = preg_replace('/--A--called_count--B--/i',urlencode(trim($called_count)),$VDCL_start_call_url);

					if (strlen($custom_field_names)>2)
						{
						$custom_field_names = preg_replace("/^\||\|$/",'',$custom_field_names);
						$custom_field_names = preg_replace("/\|/",",",$custom_field_names);
						$custom_field_names_ARY = explode(',',$custom_field_names);
						$custom_field_names_ct = count($custom_field_names_ARY);
						$custom_field_names_SQL = $custom_field_names;

						if (preg_match("/cf_encrypt/",$active_modules))
							{
							$enc_fields=0;
							$stmt = "SELECT count(*) from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00663',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$enc_field_ct = mysqli_num_rows($rslt);
							if ($enc_field_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$enc_fields =	$row[0];
								}
							if ($enc_fields > 0)
								{
								$stmt = "SELECT field_label from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00664',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$enc_field_ct = mysqli_num_rows($rslt);
								$r=0;
								while ($enc_field_ct > $r)
									{
									$row=mysqli_fetch_row($rslt);
									$encrypt_list .= "$row[0],";
									$r++;
									}
								$encrypt_list = ",$encrypt_list";
								}
							}

						##### BEGIN grab the data from custom table for the lead_id
						$stmt="SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00665',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$list_lead_ct = mysqli_num_rows($rslt);
						if ($list_lead_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$o=0;
							while ($custom_field_names_ct > $o) 
								{
								$field_name_id =		$custom_field_names_ARY[$o];
								$field_name_tag =		"--A--" . $field_name_id . "--B--";
								if ($enc_fields > 0)
									{
									$field_enc='';   $field_enc_all='';
									if ($DB) {echo "|$column_list|$encrypt_list|\n";}
									if ( (preg_match("/,$field_name_id,/",$encrypt_list)) and (strlen($row[$o]) > 0) )
										{
										exec("../agc/aes.pl --decrypt --text=$row[$o]", $field_enc);
										$field_enc_ct = count($field_enc);
										$k=0;
										while ($field_enc_ct > $k)
											{
											$field_enc_all .= $field_enc[$k];
											$k++;
											}
										$field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/",'',$field_enc_all);
										$row[$o] = base64_decode($field_enc_all);
										}
									}
								$form_field_value =		urlencode(trim("$row[$o]"));
								$VDCL_start_call_url = preg_replace("/$field_name_tag/i","$form_field_value",$VDCL_start_call_url);
								$o++;
								}
							}
						}

					$stmt="UPDATE vicidial_log_extended set start_url_processed='Y' where uniqueid='$uniqueid';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00666',$user,$server_ip,$session_name,$one_mysql_log);}
					$vle_update = mysqli_affected_rows($link);

					### insert a new url log entry
					$SQL_log = "$VDCL_start_call_url";
					$SQL_log = preg_replace('/;/','',$SQL_log);
					$SQL_log = addslashes($SQL_log);
					$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date='$NOW_TIME',url_type='start',url='$SQL_log',url_response='';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00667',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($link);
					$url_id = mysqli_insert_id($link);

					$URLstart_sec = date("U");

					### grab the call_start_url ###
					if ($DB > 0) {echo "$VDCL_start_call_url<BR>\n";}
					$SCUfile = file("$VDCL_start_call_url");
					if ( !($SCUfile) )
						{
						$error_array = error_get_last();
						$error_type = $error_array["type"];
						$error_message = $error_array["message"];
						$error_line = $error_array["line"];
						$error_file = $error_array["file"];
						}

					if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

					### update url log entry
					$URLend_sec = date("U");
					$URLdiff_sec = ($URLend_sec - $URLstart_sec);
					if ($SCUfile)
						{
						$SCUfile_contents = implode("", $SCUfile);
						$SCUfile_contents = ereg_replace(';','',$SCUfile_contents);
						$SCUfile_contents = addslashes($SCUfile_contents);
						}
					else
						{
						$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
						}
					$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='$SCUfile_contents' where url_log_id='$url_id';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00668',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($link);

					$stage .= "|SCU|$URLdiff_sec";

					##### BEGIN special filtering and response for Vtiger account balance function #####
					# http://vtiger/vicidial/api.php?mode=callxfer&contactwsid=--A--vendor_lead_code--B--&minuteswarning=3
					$stmt = "SELECT enable_vtiger_integration FROM system_settings;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00669',$user,$server_ip,$session_name,$one_mysql_log);}
					$ss_conf_ct = mysqli_num_rows($rslt);
					if ($ss_conf_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$enable_vtiger_integration =	$row[0];
						}
					if ( ( ($enable_vtiger_integration > 0) and (preg_match('/callxfer/',$VDCL_start_call_url)) and (preg_match('/contactwsid/',$VDCL_start_call_url)) ) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
						{
						$SCUoutput='';
						foreach ($SCUfile as $SCUline) 
							{$SCUoutput .= "$SCUline";}
						# {"result":true,"durationLimit":3071}
						if ( (strlen($SCUoutput) > 4) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
							{
							$minuteswarning=3; # default to 3
							if (preg_match("/minuteswarning/",$VDCL_start_call_url))
								{
								$minuteswarningARY = explode('minuteswarning=',$VDCL_start_call_url);
								$minuteswarning = preg_replace('/&.*/','',$minuteswarningARY[1]);
								}
							### add this to the Start Call URL for callcard calls to be logged "&minuteswarning=1&callcard=1"
							if (preg_match("/callcard=/",$VDCL_start_call_url))
								{
								$stmt="SELECT balance_minutes_start FROM callcard_log where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00670',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$bms_ct = mysqli_num_rows($rslt);
								if ($bms_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$durationLimit = $row[0];

									$stmt="UPDATE callcard_log set agent_time='$NOW_TIME',agent='$user' where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
									if ($DB) {echo "$stmt\n";}
									$rslt=mysql_to_mysqli($stmt, $link);
										if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00671',$user,$server_ip,$session_name,$one_mysql_log);}
									$ccl_update = mysqli_affected_rows($link);
									}
								}
							else
								{
								$SCUresponse = explode('durationLimit',$SCUoutput);
								$durationLimit = preg_replace('/\D/','',$SCUresponse[1]);
								}
							if (strlen($durationLimit) < 1) {$durationLimit = 0;}
							$durationLimitSECnext = ( ($minuteswarning + 0) * 60);
							$durationLimitSEC = ( ( ($durationLimit + 0) - $minuteswarning) * 60);  # minutes - 3 for 3-minute-warning
							if ($durationLimitSEC < 5) {$durationLimitSEC = 5;}
							if ( ($durationLimitSECnext < 30) or (strlen($durationLimitSECnext)<1) ) {$durationLimitSECnext = 30;}

							$timer_action_destination='';
							if (preg_match("/nextstep=/",$VDCL_start_call_url))
								{
								$nextstepARY = explode('nextstep=',$VDCL_start_call_url);
								$nextstep = preg_replace("/&.*/",'',$nextstepARY[1]);
								$nextmessageARY = explode('nextmessage=',$VDCL_start_call_url);
								$nextmessage = preg_replace("/&.*/",'',$nextmessageARY[1]);
								$destinationARY = explode('destination=',$VDCL_start_call_url);
								$destination = preg_replace("/&.*/",'',$destinationARY[1]);
								$timer_action_destination = "nextstep---$nextstep--$durationLimitSECnext--$destination--$nextmessage--";
								}

							$stmt="UPDATE vicidial_live_agents set external_timer_action='D1_DIAL',external_timer_action_message='$minuteswarning minute warning for customer',external_timer_action_seconds='$durationLimitSEC',external_timer_action_destination='$timer_action_destination' where user='$user';";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00672',$user,$server_ip,$session_name,$one_mysql_log);}
							$vla_update_timer = mysqli_affected_rows($link);

							$fp = fopen ("./call_url_log.txt", "a");
							fwrite ($fp, "$VDCL_start_call_url\n$SCUoutput\n$durationLimit|$durationLimitSEC|$vla_update_timer|$minuteswarning|$uniqueid|\n");
							fclose($fp);
							}
						}
					##### END special filtering and response for Vtiger account balance function #####
					}
				### END start_call_url processing ###
				}
			##### END if NOT preview dialing, send the call #####

			$stmt = "SELECT campaign_script from vicidial_campaigns where campaign_id='$campaign';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00623',$user,$server_ip,$session_name,$one_mysql_log);}
			$VC_script_ct = mysqli_num_rows($rslt);
			if ($VC_script_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDCL_campaign_script =	$row[0];
				}

			##### find if script contains recording fields
			$stmt="SELECT count(*) FROM vicidial_lists WHERE list_id='$list_id' and agent_script_override!='' and agent_script_override IS NOT NULL and agent_script_override!='NONE';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00259',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vls_vc_ct = mysqli_num_rows($rslt);
			if ($vls_vc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					$script_recording_delay=0;
					##### find if script contains recording fields
					$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_lists vls WHERE list_id='$list_id' and vs.script_id=vls.agent_script_override and script_text LIKE \"%--A--recording_%\";";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00260',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vs_vc_ct = mysqli_num_rows($rslt);
					if ($vs_vc_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$script_recording_delay = $row[0];
						}
					$stmt = "SELECT agent_script_override,list_description from vicidial_lists where list_id='$list_id';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00624',$user,$server_ip,$session_name,$one_mysql_log);}
					$VC_script_ct = mysqli_num_rows($rslt);
					if ($VC_script_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_campaign_script =	$row[0];
						$list_description =		$row[1];
						}
					}
				}

			### Gather number preset settings from campaign
			$VDCL_xferconf_a_number='';
			$VDCL_xferconf_b_number='';
			$VDCL_xferconf_c_number='';
			$VDCL_xferconf_d_number='';
			$VDCL_xferconf_e_number='';
			$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number from vicidial_campaigns where campaign_id='$campaign';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00277',$user,$server_ip,$session_name,$one_mysql_log);}
			$VC_preset_ct = mysqli_num_rows($rslt);
			if ($VC_preset_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDCL_xferconf_a_number =	$row[0];
				$VDCL_xferconf_b_number =	$row[1];
				$VDCL_xferconf_c_number =	$row[2];
				$VDCL_xferconf_d_number =	$row[3];
				$VDCL_xferconf_e_number =	$row[4];
				}

			### Look for number preset override settings from list
			if (strlen($list_id)>0)
				{
				$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number,list_name,list_description,status_group_id from vicidial_lists where list_id='$list_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00278',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_preset_ct = mysqli_num_rows($rslt);
				if ($VDIG_preset_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					if (strlen($row[0]) > 0)
						{$VDCL_xferconf_a_number =	$row[0];}
					if (strlen($row[1]) > 0)
						{$VDCL_xferconf_b_number =	$row[1];}
					if (strlen($row[2]) > 0)
						{$VDCL_xferconf_c_number =	$row[2];}
					if (strlen($row[3]) > 0)
						{$VDCL_xferconf_d_number =	$row[3];}
					if (strlen($row[4]) > 0)
						{$VDCL_xferconf_e_number =	$row[4];}
					if (strlen($row[5]) > 0)
						{$list_name =	$row[5];}
					$list_description = $row[6];
					$status_group_gather_data = status_group_gather($row[7],'LIST');
					}

				$custom_field_names='|';
				$custom_field_names_SQL='';
				$custom_field_values='----------';
				$custom_field_types='|';
				### find the names of all custom fields, if any
				$stmt = "SELECT field_label,field_type FROM vicidial_lists_fields where list_id='$entry_list_id' and field_type NOT IN('SCRIPT','DISPLAY') and field_label NOT IN('entry_date','vendor_lead_code','source_id','list_id','gmt_offset_now','called_since_last_reset','phone_code','phone_number','title','first_name','middle_initial','last_name','address1','address2','address3','city','state','province','postal_code','country_code','gender','date_of_birth','alt_phone','email','security_phrase','comments','called_count','last_local_call_time','rank','owner') and field_label NOT LIKE \"%_DUPLICATE_%\";";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00334',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cffn_ct = mysqli_num_rows($rslt);
				$d=0;
				while ($cffn_ct > $d)
					{
					$row=mysqli_fetch_row($rslt);
					$custom_field_names .=	"$row[0]|";
					$custom_field_names_SQL .=	"$row[0],";
					$custom_field_types .=	"$row[1]|";
					$custom_field_values .=	"----------";
					$d++;
					}
				if ($cffn_ct > 0)
					{
					$custom_field_names_SQL = preg_replace("/.$/i","",$custom_field_names_SQL);
					### find the values of the named custom fields
					$stmt = "SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' limit 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00335',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cffv_ct = mysqli_num_rows($rslt);
					if ($cffv_ct > 0)
						{
						$custom_field_values='----------';
						$row=mysqli_fetch_row($rslt);
						$d=0;
						while ($cffn_ct > $d)
							{
							$custom_field_values .=	"$row[$d]----------";
							$d++;
							}
						$custom_field_values = preg_replace("/\n/"," ",$custom_field_values);
						$custom_field_values = preg_replace("/\r/","",$custom_field_values);
						}
					}
				}

			$VDCL_ingroup_script_color='';
			if ( (strlen($VDCL_campaign_script)>1) and ($VDCL_campaign_script != 'NONE') )
				{
				$stmt = "SELECT script_color from vicidial_scripts where script_id='$VDCL_campaign_script';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00625',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_scrptcolor_ct = mysqli_num_rows($rslt);
				if ($VDIG_scrptcolor_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_ingroup_script_color	= $row[0];
					}
				}


			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);

			$LeaD_InfO =	$MqueryCID . "\n";
			$LeaD_InfO .=	$lead_id . "\n";
			$LeaD_InfO .=	$dispo . "\n";
			$LeaD_InfO .=	$tsr . "\n";
			$LeaD_InfO .=	$vendor_id . "\n";
			$LeaD_InfO .=	$list_id . "\n";
			$LeaD_InfO .=	$gmt_offset_now . "\n";
			$LeaD_InfO .=	$phone_code . "\n";
			$LeaD_InfO .=	$phone_number . "\n";
			$LeaD_InfO .=	$title . "\n";
			$LeaD_InfO .=	$first_name . "\n";
			$LeaD_InfO .=	$middle_initial . "\n";
			$LeaD_InfO .=	$last_name . "\n";
			$LeaD_InfO .=	$address1 . "\n";
			$LeaD_InfO .=	$address2 . "\n";
			$LeaD_InfO .=	$address3 . "\n";
			$LeaD_InfO .=	$city . "\n";
			$LeaD_InfO .=	$state . "\n";
			$LeaD_InfO .=	$province . "\n";
			$LeaD_InfO .=	$postal_code . "\n";
			$LeaD_InfO .=	$country_code . "\n";
			$LeaD_InfO .=	$gender . "\n";
			$LeaD_InfO .=	$date_of_birth . "\n";
			$LeaD_InfO .=	$alt_phone . "\n";
			$LeaD_InfO .=	$email . "\n";
			$LeaD_InfO .=	$security_phrase . "\n";
			$LeaD_InfO .=	$comments . "\n";
			$LeaD_InfO .=	$called_count . "\n";
			$LeaD_InfO .=	$CBentry_time . "\n";
			$LeaD_InfO .=	$CBcallback_time . "\n";
			$LeaD_InfO .=	$CBuser . "\n";
			$LeaD_InfO .=	$CBcomments . "\n";
			$LeaD_InfO .=	$agent_dialed_number . "\n";
			$LeaD_InfO .=	$agent_dialed_type . "\n";
			$LeaD_InfO .=	$source_id . "\n";
			$LeaD_InfO .=	$rank . "\n";
			$LeaD_InfO .=	$owner . "\n";
			$LeaD_InfO .=	"\n";
			$LeaD_InfO .=	$script_recording_delay . "\n";
			$LeaD_InfO .=	$VDCL_xferconf_a_number . "\n";
			$LeaD_InfO .=	$VDCL_xferconf_b_number . "\n";
			$LeaD_InfO .=	$VDCL_xferconf_c_number . "\n";
			$LeaD_InfO .=	$VDCL_xferconf_d_number . "\n";
			$LeaD_InfO .=	$VDCL_xferconf_e_number . "\n";
			$LeaD_InfO .=	$entry_list_id . "\n";
			$LeaD_InfO .=	$custom_field_names . "\n";
			$LeaD_InfO .=	$custom_field_values . "\n";
			$LeaD_InfO .=	$custom_field_types . "\n";
			$LeaD_InfO .=	$LISTweb_form_address . "\n";
			$LeaD_InfO .=	$LISTweb_form_address_two . "\n";
			$LeaD_InfO .=	$post_phone_time_diff_alert_message . "\n";
			$LeaD_InfO .=   $ACcount . "\n";
			$LeaD_InfO .=   $ACcomments . "\n";
			$LeaD_InfO .=   $list_name . "\n";
			$LeaD_InfO .=	$LISTweb_form_address_three . "\n";
			$LeaD_InfO .=	$VDCL_ingroup_script_color . "\n";
			$LeaD_InfO .=	$list_description . "\n";
			$LeaD_InfO .=	$entry_date . "\n";
			$LeaD_InfO .=	$status_group_gather_data . "\n";
			$LeaD_InfO .=	$call_date . "\n";
			$LeaD_InfO .=	$default_xfer_group . "\n";

			echo $LeaD_InfO;
			}
		else
			{
			echo "HOPPER EMPTY\n";
			}
		}
	$stage .= "|$agent_log_id|$vla_status|$agent_dialed_type|$agent_dialed_number|";
	}


################################################################################
### alt_phone_change - change alt phone numbers to active and inactive
### 
################################################################################
if ($ACTION == 'alt_phone_change')
{
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($stage)<1) || (strlen($called_count)<1) || (strlen($lead_id)<1)  || (strlen($phone_number)<1) )
		{
		$channel_live=0;
		echo _QXZ("ALT PHONE NUMBER STATUS NOT CHANGED")."\n";
		echo _QXZ("%1s %2s %3s or %4s is not valid",0,'',$phone_number,$stage,$lead_id,$called_count)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt = "UPDATE vicidial_list_alt_phones set active='$stage' where lead_id='$lead_id' and phone_number='$phone_number' and alt_phone_count='$called_count';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00041',$user,$server_ip,$session_name,$one_mysql_log);}

		echo _QXZ("ALT PHONE NUMBER STATUS CHANGED")."\n";
		}
}


################################################################################
### AlertControl - change the agent alert setting in vicidial_users
### 
################################################################################
if ($ACTION == 'AlertControl')
{
	if (strlen($stage)<1)
		{
		$channel_live=0;
		echo _QXZ("AGENT ALERT SETTING NOT CHANGED")."\n";
		echo _QXZ("%1s is not valid",0,'',$stage)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		if (preg_match('/ON/',$stage)) {$stage = '1';}
		else {$stage = '0';}

		$stmt = "UPDATE vicidial_users set alert_enabled='$stage' where user='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00185',$user,$server_ip,$session_name,$one_mysql_log);}

		echo _QXZ("AGENT ALERT SETTING CHANGED %1s",0,'',$stage)."\n";
		}
}


################################################################################
### manDiaLskip - for manual VICIDiaL dialing this skips the lead that was
###               previewed in the step above and puts it back in orig status
################################################################################
if ($ACTION == 'manDiaLskip')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($stage)<1) || (strlen($called_count)<1) || (strlen($lead_id)<1) )
		{
		$channel_live=0;
		echo "LEAD NOT REVERTED\n";
		echo _QXZ("Conf Exten %1s or campaign %2s or ext_context %3s is not valid",0,'',$conf_exten,$campaign,$ext_context)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		### set the api dial action to blank if used
		$stmt = "UPDATE vicidial_live_agents set external_dial='' where user='$user' and external_dial='SKIP';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00538',$user,$server_ip,$session_name,$one_mysql_log);}

		### clear the preview dial flag of the lead_id being previewed
		$stmt = "UPDATE vicidial_live_agents set preview_lead_id='0' where user='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00591',$user,$server_ip,$session_name,$one_mysql_log);}

		$called_count = ($called_count - 1);
		### set the lead back to previous status and called_count
		$stmt = "UPDATE vicidial_list set status='$stage', called_count='$called_count',user='$user' where lead_id='$lead_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00042',$user,$server_ip,$session_name,$one_mysql_log);}

		### log the skip event
		$stmt = "INSERT INTO vicidial_agent_skip_log set campaign_id='$campaign', previous_status='$stage', previous_called_count='$called_count',user='$user', lead_id='$lead_id', event_date=NOW();";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00419',$user,$server_ip,$session_name,$one_mysql_log);}

		echo "LEAD REVERTED\n";
		}
	}


################################################################################
### manDiaLonly - for manual VICIDiaL dialing this sends the call that was
###               previewed in the step above
################################################################################
if ($ACTION == 'manDiaLonly')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	$MDF_search_flag='MAIN';
	if ( (strlen($conf_exten)<1) || (strlen($campaign)<1) || (strlen($ext_context)<1) || (strlen($phone_number)<1) || (strlen($lead_id)<1) )
		{
		$channel_live=0;
		echo " CALL NOT PLACED\n";
		echo _QXZ("Conf Exten %1s or campaign %2s or ext_context %3s or phone_number %4s or lead_id %5s is not valid",0,'',$conf_exten,$campaign,$ext_context,$phone_number,$lead_id)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		##### clear out last call to same lead if exists #####
		if (strlen($old_CID) > 16)
			{
			$old_lead_id = substr($old_CID, -10);
			$old_lead_id = ($old_lead_id + 0);
			if ($lead_id == "$old_lead_id")
				{
				$stmt="DELETE FROM vicidial_auto_calls where callerid='$old_CID' and lead_id='$old_lead_id';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00428',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}

		### set the api dial action to blank if used
		$stmt = "UPDATE vicidial_live_agents set external_dial='',preview_lead_id='0' where user='$user' and external_dial IN('DIALONLY','ALTDIAL','ADR3DIAL');";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00539',$user,$server_ip,$session_name,$one_mysql_log);}

		##### grab number of calls today in this campaign and increment
		$stmt="SELECT calls_today,extension FROM vicidial_live_agents WHERE user='$user' and campaign_id='$campaign';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00043',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$vla_cc_ct = mysqli_num_rows($rslt);
		if ($vla_cc_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$calls_today =	$row[0];
			$eac_phone =	$row[1];
			}
		else
			{$calls_today ='0';}
		$calls_today++;


		### check for manual dial filter and extension append settings in campaign
		$use_eac=0;
		$use_custom_cid=0;
		$stmt = "SELECT manual_dial_filter,use_internal_dnc,use_campaign_dnc,use_other_campaign_dnc,extension_appended_cidname,start_call_url FROM vicidial_campaigns where campaign_id='$campaign';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00325',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$vcstgs_ct = mysqli_num_rows($rslt);
		if ($vcstgs_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$manual_dial_filter =			$row[0];
			$use_internal_dnc =				$row[1];
			$use_campaign_dnc =				$row[2];
			$use_other_campaign_dnc =		$row[3];
			$extension_appended_cidname =	$row[4];
			$start_call_url =				$row[5];
			if ($extension_appended_cidname == 'Y')
				{$use_eac++;}
			}

		### BEGIN check phone filtering for DNC or camplists if enabled ###
		if (preg_match("/DNC/",$manual_dial_filter))
			{
			if (preg_match("/AREACODE/",$use_internal_dnc))
				{
				$phone_number_areacode = substr($phone_number, 0, 3);
				$phone_number_areacode .= "XXXXXXX";
				$stmt="SELECT count(*) from vicidial_dnc where phone_number IN('$phone_number','$phone_number_areacode');";
				}
			else
				{$stmt="SELECT count(*) FROM vicidial_dnc where phone_number='$phone_number';";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00529',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			if ($row[0] > 0)
				{
				echo " CALL NOT PLACED\nDNC NUMBER\n";
				if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
				exit;
				}
			if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
				{
				$stmt="SELECT use_other_campaign_dnc from vicidial_campaigns where campaign_id='$campaign';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00530',$user,$server_ip,$session_name,$one_mysql_log);}
				$row=mysqli_fetch_row($rslt);
				$use_other_campaign_dnc =	$row[0];
				$temp_campaign_id = $campaign;
				if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}

				if (preg_match("/AREACODE/",$use_campaign_dnc))
					{
					$phone_number_areacode = substr($phone_number, 0, 3);
					$phone_number_areacode .= "XXXXXXX";
					$stmt="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$phone_number','$phone_number_areacode') and campaign_id='$temp_campaign_id';";
					}
				else
					{$stmt="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$phone_number' and campaign_id='$temp_campaign_id';";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00531',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					echo " CALL NOT PLACED\nDNC NUMBER\n";
					if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
					exit;
					}
				}
			}
		if (preg_match("/CAMPLISTS/",$manual_dial_filter))
			{
			$stmt="SELECT list_id,active from vicidial_lists where campaign_id='$campaign'";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00532',$user,$server_ip,$session_name,$one_mysql_log);}
			$lists_to_parse = mysqli_num_rows($rslt);
			$camp_lists='';
			$o=0;
			while ($lists_to_parse > $o) 
				{
				$rowx=mysqli_fetch_row($rslt);
				if (preg_match("/Y/", $rowx[1])) {$active_lists++;   $camp_lists .= "'$rowx[0]',";}
				if (preg_match("/ALL/",$manual_dial_filter))
					{
					if (preg_match("/N/", $rowx[1])) 
						{$inactive_lists++; $camp_lists .= "'$rowx[0]',";}
					}
				else
					{
					if (preg_match("/N/", $rowx[1])) 
						{$inactive_lists++;}
					}
				$o++;
				}
			$camp_lists = preg_replace("/.$/i","",$camp_lists);
			if (strlen($camp_lists)<2) {$camp_lists="''";}

			$stmt="SELECT count(*) FROM vicidial_list where phone_number='$phone_number' and list_id IN($camp_lists);";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00533',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$row=mysqli_fetch_row($rslt);
			$MDF_search_flag='MAIN';

			if ( ($row[0] < 1) and (preg_match("/WITH_ALT/",$manual_dial_filter)) )
				{
				$stmt="SELECT count(*) FROM vicidial_list where alt_phone='$phone_number' and list_id IN($camp_lists);";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00626',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$MDF_search_flag='ALT';
				}

			if ( ($row[0] < 1) and (preg_match("/WITH_ALT_ADDR3/",$manual_dial_filter)) )
				{
				$stmt="SELECT count(*) FROM vicidial_list where address3='$phone_number' and list_id IN($camp_lists);";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00627',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$row=mysqli_fetch_row($rslt);
				$MDF_search_flag='ADDR3';
				}

			if ($row[0] < 1)
				{
				echo " CALL NOT PLACED\nNUMBER NOT IN CAMPLISTS\n";
				if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
				exit;
				}
			}
		### END check phone filtering for DNC or camplists if enabled ###


		### prepare variables to place manual call from VICIDiaL
		$CCID_on=0;   $CCID='';
		$LISTweb_form_address='';
		$LISTweb_form_address_two='';
		$LISTweb_form_address_three='';
		$local_DEF = 'Local/';
		$local_AMP = '@';
		$Local_out_prefix = '9';
		$Local_dial_timeout = '60';
		$Local_persist = '/n';
		if ($dial_timeout > 4) {$Local_dial_timeout = $dial_timeout;}
		$Local_dial_timeout = ($Local_dial_timeout * 1000);
		if (strlen($dial_prefix) > 0) {$Local_out_prefix = "$dial_prefix";}
		if (strlen($campaign_cid) > 6) {$CCID = "$campaign_cid";   $CCID_on++;}
		if (preg_match("/x/i",$dial_prefix)) {$Local_out_prefix = '';}
		$campaign_cid_override='';
		### check if there is a list_id override
		if (strlen($lead_id) > 1)
			{
			$list_id='';
			$stmt = "SELECT list_id,province,security_phrase FROM vicidial_list where lead_id='$lead_id';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00246',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$lio_ct = mysqli_num_rows($rslt);
			if ($lio_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$list_id =			$row[0];
				$province =			$row[1];
				$security_phrase =	$row[2];

				if (strlen($list_id) > 1)
					{
					$stmt = "SELECT campaign_cid_override,web_form_address,web_form_address_two,web_form_address_three,list_description FROM vicidial_lists where list_id='$list_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00247',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$lio_ct = mysqli_num_rows($rslt);
					if ($lio_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$campaign_cid_override =		$row[0];
						$LISTweb_form_address =			$row[1];
						$LISTweb_form_address_two =		$row[2];
						$LISTweb_form_address_three =	$row[3];
						$list_description =				$row[4];
						}
					}
				}
			}

		if (strlen($campaign_cid_override) > 6) {$CCID = "$campaign_cid_override";   $CCID_on++;}
		else
			{
			### check for custom cid use
			$use_custom_cid=0;
			$stmt = "SELECT use_custom_cid,manual_dial_hopper_check,cid_group_id FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00314',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$uccid_ct = mysqli_num_rows($rslt);
			if ($uccid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$use_custom_cid =			$row[0];
				$manual_dial_hopper_check =	$row[1];
				$cid_group_id =				$row[2];
				if ($use_custom_cid == 'Y')
					{
					$temp_CID = preg_replace("/\D/",'',$security_phrase);
					if (strlen($temp_CID) > 6) 
						{$CCID = "$temp_CID";   $CCID_on++;}
					}
				if ( (preg_match('/^USER_CUSTOM/', $use_custom_cid)) and ($cid_lock < 1) )
					{
					$temp_vu='';
					$use_custom_cid=preg_replace('/^USER_/', "", $use_custom_cid);
					$pattern=array('/1/', '/2/', '/3/', '/4/', '/5/');
					$replace=array('one', 'two', 'three', 'four', 'five');
					$use_custom_cid = strtolower(preg_replace($pattern,$replace, $use_custom_cid));
					$stmt="select $use_custom_cid from vicidial_users where user='$user'";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00661',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vu_ct = mysqli_num_rows($rslt);
					$act=0;
					while ($vu_ct > $act)
						{
						$row=mysqli_fetch_row($rslt);
						$temp_vu =	$row[0];
						$act++;
						}
					$temp_CID = preg_replace("/\D/",'',$temp_vu);
					if (strlen($temp_CID) > 6) 
						{$CCID = "$temp_CID";   $CCID_on++;}
					}
				$CIDG_set=0;
				if ( ($cid_group_id != '---DISABLED---') and ($cid_lock < 1) )
					{
					$stmt = "SELECT cid_group_type FROM vicidial_cid_groups where cid_group_id='$cid_group_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00717',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cidg_ct = mysqli_num_rows($rslt);
					if ($cidg_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$cid_group_type =	$row[0];
						$temp_vcca='';
						$temp_ac='';

						if ($cid_group_type == 'AREACODE')
							{
							$temp_ac_two = substr("$agent_dialed_number", 0, 2);
							$temp_ac_three = substr("$agent_dialed_number", 0, 3);
							$temp_ac_four = substr("$agent_dialed_number", 0, 4);
							$temp_ac_five = substr("$agent_dialed_number", 0, 5);
							$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$cid_group_id' and areacode IN('$temp_ac_two','$temp_ac_three','$temp_ac_four','$temp_ac_five') and active='Y' order by CAST(areacode as SIGNED INTEGER) asc, call_count_today desc limit 100000;";
							}
						if ($cid_group_type == 'STATE')
							{
							$temp_state = $state;
							$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$cid_group_id' and areacode IN('$temp_state') and active='Y' order by call_count_today desc limit 100000;";
							}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00718',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$vcca_ct = mysqli_num_rows($rslt);
						$act=0;
						while ($vcca_ct > $act)
							{
							$row=mysqli_fetch_row($rslt);
							$temp_vcca =	$row[0];
							$temp_ac =		$row[1];
							$act++;
							}
						if ($act > 0) 
							{
							$stmt="UPDATE vicidial_campaign_cid_areacodes set call_count_today=(call_count_today + 1) where campaign_id='$cid_group_id' and areacode='$temp_ac' and outbound_cid='$temp_vcca';";
								if ($format=='debug') {echo "\n<!-- $stmt -->";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00719',$user,$server_ip,$session_name,$one_mysql_log);}
							}
						}
					$temp_CID = preg_replace("/\D/",'',$temp_vcca);
					if (strlen($temp_CID) > 6) 
						{$CCID = "$temp_CID";   $CCID_on++;   $CIDG_set++;}
					}
				if ( ($use_custom_cid == 'AREACODE') and ($cid_lock < 1) and ($CIDG_set < 1) )
					{
					$temp_vcca='';
					$temp_ac='';
					$temp_ac_two = substr("$phone_number", 0, 2);
					$temp_ac_three = substr("$phone_number", 0, 3);
					$temp_ac_four = substr("$phone_number", 0, 4);
					$temp_ac_five = substr("$phone_number", 0, 5);
					$stmt = "SELECT outbound_cid,areacode FROM vicidial_campaign_cid_areacodes where campaign_id='$campaign' and areacode IN('$temp_ac_two','$temp_ac_three','$temp_ac_four','$temp_ac_five') and active='Y' order by CAST(areacode as SIGNED INTEGER) asc, call_count_today desc limit 100000;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00429',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vcca_ct = mysqli_num_rows($rslt);
					$act=0;
					while ($vcca_ct > $act)
						{
						$row=mysqli_fetch_row($rslt);
						$temp_vcca =	$row[0];
						$temp_ac =		$row[1];
						$act++;
						}
					if ($act > 0) 
						{
						$stmt="UPDATE vicidial_campaign_cid_areacodes set call_count_today=(call_count_today + 1) where campaign_id='$campaign' and areacode='$temp_ac' and outbound_cid='$temp_vcca';";
							if ($format=='debug') {echo "\n<!-- $stmt -->";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00430',$user,$server_ip,$session_name,$one_mysql_log);}
						}

					$temp_CID = preg_replace("/\D/",'',$temp_vcca);
					if (strlen($temp_CID) > 6) 
						{$CCID = "$temp_CID";   $CCID_on++;}
					}
				}
			}

		#### BEGIN run manual_dial_hopper_check process if enabled
		if ($manual_dial_hopper_check == 'Y')
			{
			$mdhc_lead_ids_SQL='';
			$stmt = "SELECT lead_id FROM vicidial_list where phone_number='$phone_number';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00652',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$mdhc_ct = mysqli_num_rows($rslt);
			$d=0;
			while ($mdhc_ct > $d)
				{
				$row=mysqli_fetch_row($rslt);
				$mdhc_lead_ids_SQL .=	"'$row[0]',";
				$d++;
				}
			if ($mdhc_ct > 0)
				{
				$stmt = "DELETE FROM vicidial_hopper where lead_id IN($mdhc_lead_ids_SQL'');";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00653',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		#### END run manual_dial_hopper_check process if enabled

		$PADlead_id = sprintf("%010s", $lead_id);
			while (strlen($PADlead_id) > 10) {$PADlead_id = substr("$PADlead_id", 1);}

		# Create unique calleridname to track the call: MmddhhmmssLLLLLLLLLL
			$MqueryCID = "M$CIDdate$PADlead_id";
		$EAC='';
		if ($use_eac > 0)
			{
			$eac_extension = preg_replace("/SIP\/|IAX2\/|Zap\/|DAHDI\/|Local\//",'',$eac_phone);
			$EAC=" $eac_extension";
			}
		if ($CCID_on) {$CIDstring = "\"$MqueryCID$EAC\" <$CCID>";}
		else {$CIDstring = "$MqueryCID$EAC";}

		if ( ($usegroupalias > 0) and (strlen($account)>1) )
			{
			$RAWaccount = $account;
			$account = "Account: $account";
			$variable = "Variable: usegroupalias=1";
			}
		else
			{$account='';   $variable='';}

		### whether to omit phone_code or not
		if (preg_match('/Y/i',$omit_phone_code)) 
			{$Ndialstring = "$Local_out_prefix$phone_number";}
		else
			{$Ndialstring = "$Local_out_prefix$phone_code$phone_number";}
		### insert the call action into the vicidial_manager table to initiate the call
		#	$stmt = "INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Originate','$MqueryCID','Exten: $conf_exten','Context: $ext_context','Channel: $local_DEF$Local_out_prefix$phone_code$phone_number$local_AMP$ext_context','Priority: 1','Callerid: $CIDstring','Timeout: $Local_dial_timeout','','','','');";
		$stmt = "INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Originate','$MqueryCID','Exten: $Ndialstring','Context: $ext_context','Channel: $local_DEF$conf_exten$local_AMP$ext_context$Local_persist','Priority: 1','Callerid: $CIDstring','Timeout: $Local_dial_timeout','$account','$variable','','');";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00044',$user,$server_ip,$session_name,$one_mysql_log);}

		### log outbound call in the dial log
		$stmt = "INSERT INTO vicidial_dial_log SET caller_code='$MqueryCID',lead_id='$lead_id',server_ip='$server_ip',call_date='$NOW_TIME',extension='$Ndialstring',channel='$local_DEF$conf_exten$local_AMP$ext_context$Local_persist',timeout='$Local_dial_timeout',outbound_cid='$CIDstring',context='$ext_context';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00443',$user,$server_ip,$session_name,$one_mysql_log);}

		$stmt = "INSERT INTO vicidial_auto_calls (server_ip,campaign_id,status,lead_id,callerid,phone_code,phone_number,call_time,call_type) values('$server_ip','$campaign','XFER','$lead_id','$MqueryCID','$phone_code','$phone_number','$NOW_TIME','OUT')";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00045',$user,$server_ip,$session_name,$one_mysql_log);}

		### update the agent status to INCALL in vicidial_live_agents
		$stmt = "UPDATE vicidial_live_agents set status='INCALL',last_call_time='$NOW_TIME',callerid='$MqueryCID',lead_id='$lead_id',comments='MANUAL',calls_today='$calls_today',external_hangup=0,external_status='',external_pause='',external_dial='',last_state_change='$NOW_TIME',pause_code='',preview_lead_id='0' where user='$user' and server_ip='$server_ip';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00046',$user,$server_ip,$session_name,$one_mysql_log);}
		$retry_count=0;
		while ( ($errno > 0) and ($retry_count < 9) )
			{
			$rslt=mysql_to_mysqli($stmt, $link);
			$one_mysql_log=1;
			$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9046$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
			$one_mysql_log=0;
			$retry_count++;
			}

		$stmt = "UPDATE vicidial_campaign_agents set calls_today='$calls_today' where user='$user' and campaign_id='$campaign';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00047',$user,$server_ip,$session_name,$one_mysql_log);}

		echo "$MqueryCID\n";

#		#### update vicidial_agent_log if not MANUAL dial_method
#		if ($dial_method != 'MANUAL')
#			{
#			$pause_sec=0;
#			$stmt = "SELECT pause_epoch,pause_sec,wait_epoch,talk_epoch,dispo_epoch,agent_log_id from vicidial_agent_log where agent_log_id >= '$agent_log_id' and user='$user' order by agent_log_id desc limit 1;";
#			if ($DB) {echo "$stmt\n";}
#			$rslt=mysql_to_mysqli($stmt, $link);
#					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00304',$user,$server_ip,$session_name,$one_mysql_log);}
#			$VDpr_ct = mysqli_num_rows($rslt);
#			if ( ($VDpr_ct > 0) and (strlen($row[3]<5)) and (strlen($row[4]<5)) )
#				{
#				$row=mysqli_fetch_row($rslt);
#				$agent_log_id = $row[5];
#				$pause_sec = (($StarTtime - $row[0]) + $row[1]);
#
#				$stmt="UPDATE vicidial_agent_log set pause_sec='$pause_sec',wait_epoch='$StarTtime' where agent_log_id='$agent_log_id';";
#					if ($format=='debug') {echo "\n<!-- $stmt -->";}
#				$rslt=mysql_to_mysqli($stmt, $link);
#					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00305',$user,$server_ip,$session_name,$one_mysql_log);}
#				}
#			}

		$val_pause_epoch=0;
		$val_pause_sec=0;
		$val_dispo_epoch=0;
		$val_dispo_sec=0;
		$val_wait_epoch=0;
		$val_wait_sec=0;
		$stmt = "SELECT dispo_epoch,wait_epoch,pause_epoch FROM vicidial_agent_log where agent_log_id='$agent_log_id';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00326',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$vald_ct = mysqli_num_rows($rslt);
		if ($vald_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$val_dispo_epoch =	$row[0];
			$val_wait_epoch =	$row[1];
			$val_pause_epoch =	$row[2];
			$val_dispo_sec = ($StarTtime - $val_dispo_epoch);
			$val_wait_sec = ($StarTtime - $val_wait_epoch);
			$val_pause_sec = ($StarTtime - $val_pause_epoch);
			}
		if ($val_dispo_epoch > 1000)
			{
			$stmt="UPDATE vicidial_agent_log set status='ALTNUM',dispo_sec='$val_dispo_sec' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00327',$user,$server_ip,$session_name,$one_mysql_log);}

			$user_group='';
			$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00328',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				}

			$stmt="INSERT INTO vicidial_agent_log (user,server_ip,event_time,campaign_id,pause_epoch,pause_sec,wait_epoch,user_group,sub_status,pause_type) values('$user','$server_ip','$NOW_TIME','$campaign','$StarTtime','0','$StarTtime','$user_group','ANDIAL','AGENT');";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00329',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			$agent_log_id = mysqli_insert_id($link);

			$stmt="UPDATE vicidial_live_agents SET agent_log_id='$agent_log_id',last_state_change='$NOW_TIME' where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00330',$VD_login,$server_ip,$session_name,$one_mysql_log);}
			$VLAaffected_rows_update = mysqli_affected_rows($link);
			}
		else
			{
			$stmt="UPDATE vicidial_agent_log set pause_sec='$val_pause_sec',wait_epoch='$StarTtime' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00331',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		echo "$agent_log_id\n";


		if ($agent_dialed_number > 0)
			{
			$stmt = "INSERT INTO user_call_log (user,call_date,call_type,server_ip,phone_number,number_dialed,lead_id,callerid,group_alias_id) values('$user','$NOW_TIME','$agent_dialed_type','$server_ip','$phone_number','$Ndialstring','$lead_id','$CCID','$RAWaccount')";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00192',$user,$server_ip,$session_name,$one_mysql_log);}
			}


		#############################################
		##### START QUEUEMETRICS LOGGING LOOKUP #####
		$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_pe_phone_append,queuemetrics_socket,queuemetrics_socket_url,queuemetrics_pause_type FROM system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00048',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$qm_conf_ct = mysqli_num_rows($rslt);
		if ($qm_conf_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$enable_queuemetrics_logging =	$row[0];
			$queuemetrics_server_ip	=		$row[1];
			$queuemetrics_dbname =			$row[2];
			$queuemetrics_login	=			$row[3];
			$queuemetrics_pass =			$row[4];
			$queuemetrics_log_id =			$row[5];
			$queuemetrics_pe_phone_append = $row[6];
			$queuemetrics_socket =			$row[7];
			$queuemetrics_socket_url =		$row[8];
			$queuemetrics_pause_type =		$row[9];
			}
		##### END QUEUEMETRICS LOGGING LOOKUP #####
		###########################################
		if ($enable_queuemetrics_logging > 0)
			{
			$data4SQL='';
			$data4SS='';
			$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00390',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cqpe_ct = mysqli_num_rows($rslt);
			if ($cqpe_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$pe_append='';
				if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
					{$pe_append = "-$qm_extension";}
				$data4SQL = ",data4='$row[0]$pe_append'";
				$data4SS = "&data4=$row[0]$pe_append";
				}

			$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
			if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
			mysqli_select_db($linkB, "$queuemetrics_dbname");

			# UNPAUSEALL
			$pause_typeSQL='';
			if ($queuemetrics_pause_type > 0)
				{$pause_typeSQL=",data5='AGENT'";}
			$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='UNPAUSEALL',serverid='$queuemetrics_log_id' $data4SQL $pause_typeSQL;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00049',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($linkB);

			# CALLOUTBOUND (formerly ENTERQUEUE)
			$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MqueryCID',queue='$campaign',agent='NONE',verb='CALLOUTBOUND',data2='$phone_number',serverid='$queuemetrics_log_id' $data4SQL;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00050',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($linkB);

			# CONNECT
			$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MqueryCID',queue='$campaign',agent='Agent/$user',verb='CONNECT',data1='0',serverid='$queuemetrics_log_id' $data4SQL;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00051',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($linkB);

			mysqli_close($linkB);

			if ( ($queuemetrics_socket == 'CONNECT_COMPLETE') and (strlen($queuemetrics_socket_url) > 10) )
				{
				if (preg_match("/--A--/",$queuemetrics_socket_url))
					{
					##### grab the data from vicidial_list for the lead_id
					$stmt="SELECT vendor_lead_code,list_id,phone_code,phone_number,title,first_name,middle_initial,last_name,postal_code FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00540',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$list_lead_ct = mysqli_num_rows($rslt);
					if ($list_lead_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$vendor_id		= urlencode(trim($row[0]));
						$list_id		= urlencode(trim($row[1]));
						$phone_code		= urlencode(trim($row[2]));
						$phone_number	= urlencode(trim($row[3]));
						$title			= urlencode(trim($row[4]));
						$first_name		= urlencode(trim($row[5]));
						$middle_initial	= urlencode(trim($row[6]));
						$last_name		= urlencode(trim($row[7]));
						$postal_code	= urlencode(trim($row[8]));
						}
					$queuemetrics_socket_url = preg_replace('/^VAR/','',$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--lead_id--B--/i',"$lead_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--list_id--B--/i',"$list_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--phone_number--B--/i',"$phone_number",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--title--B--/i',"$title",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--first_name--B--/i',"$first_name",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--last_name--B--/i',"$last_name",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--postal_code--B--/i',"$postal_code",$queuemetrics_socket_url);
					}
				$socket_send_data_begin='?';
				$socket_send_data = "time_id=$StarTtime&call_id=$MqueryCID&queue=$campaign&agent=Agent/$user&verb=CONNECT&data1=0$data4SS";
				if (preg_match("/\?/",$queuemetrics_socket_url))
					{$socket_send_data_begin='&';}
				### send queue_log data to the queuemetrics_socket_url ###
				if ($DB > 0) {echo "$queuemetrics_socket_url$socket_send_data_begin$socket_send_data<BR>\n";}
				$SCUfile = file("$queuemetrics_socket_url$socket_send_data_begin$socket_send_data");
				if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}
				}
			}
		##### check if system is set to generate logfile for transfers
		$stmt="SELECT enable_agc_xfer_log FROM system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00441',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$enable_agc_xfer_log_ct = mysqli_num_rows($rslt);
		if ($enable_agc_xfer_log_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$enable_agc_xfer_log =$row[0];
			}
		if ( ($WeBRooTWritablE > 0) and ($enable_agc_xfer_log > 0) )
			{
			#	DATETIME|campaign|lead_id|phone_number|user|type
			#	2007-08-22 11:11:11|TESTCAMP|65432|3125551212|1234|M
			$fp = fopen ("./xfer_log.txt", "a");
			fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$phone_number|$user|M|$MqueryCID||$province\n");
			fclose($fp);
			}

		### BEGIN start_call_url processing ###
		$VDCL_start_call_url = $start_call_url;

		### Issue Start Call URL if defined
		if (strlen($VDCL_start_call_url) > 7)
			{
			if (preg_match('/--A--user_custom_/i',$VDCL_start_call_url))
				{
				$stmt = "SELECT custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_users where user='$user';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00673',$user,$server_ip,$session_name,$one_mysql_log);}
				$VUC_ct = mysqli_num_rows($rslt);
				if ($VUC_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$user_custom_one	=		urlencode(trim($row[0]));
					$user_custom_two	=		urlencode(trim($row[1]));
					$user_custom_three	=		urlencode(trim($row[2]));
					$user_custom_four	=		urlencode(trim($row[3]));
					$user_custom_five	=		urlencode(trim($row[4]));
					}
				}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00674',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$entry_date		= trim("$row[1]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$lead_list_id	= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$called_since_last_reset = trim("$row[9]");
				$phone_code		= trim("$row[10]");
				if ($override_phone < 1)
					{$phone_number	= trim("$row[11]");}
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase		= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
					if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}

			$VDCL_start_call_url = preg_replace('/^VAR/','',$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--lead_id--B--/i',urlencode(trim($lead_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--vendor_id--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--vendor_lead_code--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--list_id--B--/i',urlencode(trim($list_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--list_name--B--/i',urlencode(trim($list_name)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--list_description--B--/i',urlencode(trim($list_description)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--gmt_offset_now--B--/i',urlencode(trim($gmt_offset_now)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--phone_code--B--/i',urlencode(trim($phone_code)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--phone_number--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--title--B--/i',urlencode(trim($title)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--first_name--B--/i',urlencode(trim($first_name)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--middle_initial--B--/i',urlencode(trim($middle_initial)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--last_name--B--/i',urlencode(trim($last_name)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--address1--B--/i',urlencode(trim($address1)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--address2--B--/i',urlencode(trim($address2)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--address3--B--/i',urlencode(trim($address3)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--city--B--/i',urlencode(trim($city)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--state--B--/i',urlencode(trim($state)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--province--B--/i',urlencode(trim($province)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--postal_code--B--/i',urlencode(trim($postal_code)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--country_code--B--/i',urlencode(trim($country_code)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--gender--B--/i',urlencode(trim($gender)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--date_of_birth--B--/i',urlencode(trim($date_of_birth)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--alt_phone--B--/i',urlencode(trim($alt_phone)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--email--B--/i',urlencode(trim($email)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--security_phrase--B--/i',urlencode(trim($security_phrase)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--comments--B--/i',urlencode(trim($comments)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user--B--/i',urlencode(trim($user)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--pass--B--/i',urlencode(trim($orig_pass)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--campaign--B--/i',urlencode(trim($campaign)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--phone_login--B--/i',urlencode(trim($phone_login)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--original_phone_login--B--/i',urlencode(trim($original_phone_login)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--phone_pass--B--/i',urlencode(trim($phone_pass)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--fronter--B--/i',urlencode(trim($fronter)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--closer--B--/i',urlencode(trim($closer)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--channel_group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--SQLdate--B--/i',urlencode(trim($SQLdate)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--epoch--B--/i',urlencode(trim($epoch)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--uniqueid--B--/i',urlencode(trim($uniqueid)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--customer_zap_channel--B--/i',urlencode(trim($channel)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--customer_server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--SIPexten--B--/i',urlencode(trim($exten)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--session_id--B--/i',urlencode(trim($conf_exten)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--phone--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--parked_by--B--/i',urlencode(trim($parked_by)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--dispo--B--/i',urlencode(trim($dispo)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--dialed_number--B--/i',urlencode(trim($agent_dialed_number)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--dialed_label--B--/i',urlencode(trim($agent_dialed_type)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--source_id--B--/i',urlencode(trim($source_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--rank--B--/i',urlencode(trim($rank)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--owner--B--/i',urlencode(trim($owner)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--camp_script--B--/i',urlencode(trim($camp_script)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--in_script--B--/i',urlencode(trim($VDCL_ingroup_script)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--fullname--B--/i',urlencode(trim($fullname)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_custom_one--B--/i',urlencode(trim($user_custom_one)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_custom_two--B--/i',urlencode(trim($user_custom_two)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_custom_three--B--/i',urlencode(trim($user_custom_three)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_custom_four--B--/i',urlencode(trim($user_custom_four)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_custom_five--B--/i',urlencode(trim($user_custom_five)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--talk_time--B--/i',"0",$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--talk_time_min--B--/i',"0",$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--entry_list_id--B--/i',urlencode(trim($entry_list_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--closecallid--B--/i',urlencode(trim($INclosecallid)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--xfercallid--B--/i',urlencode(trim($INxfercallid)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--agent_log_id--B--/i',urlencode(trim($agent_log_id)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--call_id--B--/i',urlencode(trim($MqueryCID)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--user_group--B--/i',urlencode(trim($user_group)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--entry_date--B--/i',urlencode(trim($entry_date)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--agent_email--B--/i',urlencode(trim($agent_email)),$VDCL_start_call_url);
			$VDCL_start_call_url = preg_replace('/--A--called_count--B--/i',urlencode(trim($called_count)),$VDCL_start_call_url);

			if (strlen($custom_field_names)>2)
				{
				$custom_field_names = preg_replace("/^\||\|$/",'',$custom_field_names);
				$custom_field_names = preg_replace("/\|/",",",$custom_field_names);
				$custom_field_names_ARY = explode(',',$custom_field_names);
				$custom_field_names_ct = count($custom_field_names_ARY);
				$custom_field_names_SQL = $custom_field_names;

				if (preg_match("/cf_encrypt/",$active_modules))
					{
					$enc_fields=0;
					$stmt = "SELECT count(*) from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00675',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$enc_field_ct = mysqli_num_rows($rslt);
					if ($enc_field_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$enc_fields =	$row[0];
						}
					if ($enc_fields > 0)
						{
						$stmt = "SELECT field_label from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00676',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$enc_field_ct = mysqli_num_rows($rslt);
						$r=0;
						while ($enc_field_ct > $r)
							{
							$row=mysqli_fetch_row($rslt);
							$encrypt_list .= "$row[0],";
							$r++;
							}
						$encrypt_list = ",$encrypt_list";
						}
					}

				##### BEGIN grab the data from custom table for the lead_id
				$stmt="SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00677',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$list_lead_ct = mysqli_num_rows($rslt);
				if ($list_lead_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$o=0;
					while ($custom_field_names_ct > $o) 
						{
						$field_name_id =		$custom_field_names_ARY[$o];
						$field_name_tag =		"--A--" . $field_name_id . "--B--";
						if ($enc_fields > 0)
							{
							$field_enc='';   $field_enc_all='';
							if ($DB) {echo "|$column_list|$encrypt_list|\n";}
							if ( (preg_match("/,$field_name_id,/",$encrypt_list)) and (strlen($row[$o]) > 0) )
								{
								exec("../agc/aes.pl --decrypt --text=$row[$o]", $field_enc);
								$field_enc_ct = count($field_enc);
								$k=0;
								while ($field_enc_ct > $k)
									{
									$field_enc_all .= $field_enc[$k];
									$k++;
									}
								$field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/",'',$field_enc_all);
								$row[$o] = base64_decode($field_enc_all);
								}
							}
						$form_field_value =		urlencode(trim("$row[$o]"));
						$VDCL_start_call_url = preg_replace("/$field_name_tag/i","$form_field_value",$VDCL_start_call_url);
						$o++;
						}
					}
				}

			$stmt="UPDATE vicidial_log_extended set start_url_processed='Y' where uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00678',$user,$server_ip,$session_name,$one_mysql_log);}
			$vle_update = mysqli_affected_rows($link);

			### insert a new url log entry
			$SQL_log = "$VDCL_start_call_url";
			$SQL_log = preg_replace('/;/','',$SQL_log);
			$SQL_log = addslashes($SQL_log);
			$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date='$NOW_TIME',url_type='start',url='$SQL_log',url_response='';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00679',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			$url_id = mysqli_insert_id($link);

			$URLstart_sec = date("U");

			### grab the call_start_url ###
			if ($DB > 0) {echo "$VDCL_start_call_url<BR>\n";}
			$SCUfile = file("$VDCL_start_call_url");
			if ( !($SCUfile) )
				{
				$error_array = error_get_last();
				$error_type = $error_array["type"];
				$error_message = $error_array["message"];
				$error_line = $error_array["line"];
				$error_file = $error_array["file"];
				}

			if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

			### update url log entry
			$URLend_sec = date("U");
			$URLdiff_sec = ($URLend_sec - $URLstart_sec);
			if ($SCUfile)
				{
				$SCUfile_contents = implode("", $SCUfile);
				$SCUfile_contents = preg_replace('/;/','',$SCUfile_contents);
				$SCUfile_contents = addslashes($SCUfile_contents);
				}
			else
				{
				$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
				}
			$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='$SCUfile_contents' where url_log_id='$url_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00680',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);

			$stage .= "|SCU|$URLdiff_sec";

			##### BEGIN special filtering and response for Vtiger account balance function #####
			# http://vtiger/vicidial/api.php?mode=callxfer&contactwsid=--A--vendor_lead_code--B--&minuteswarning=3
			$stmt = "SELECT enable_vtiger_integration FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00681',$user,$server_ip,$session_name,$one_mysql_log);}
			$ss_conf_ct = mysqli_num_rows($rslt);
			if ($ss_conf_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_vtiger_integration =	$row[0];
				}
			if ( ( ($enable_vtiger_integration > 0) and (preg_match('/callxfer/',$VDCL_start_call_url)) and (preg_match('/contactwsid/',$VDCL_start_call_url)) ) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
				{
				$SCUoutput='';
				foreach ($SCUfile as $SCUline) 
					{$SCUoutput .= "$SCUline";}
				# {"result":true,"durationLimit":3071}
				if ( (strlen($SCUoutput) > 4) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
					{
					$minuteswarning=3; # default to 3
					if (preg_match("/minuteswarning/",$VDCL_start_call_url))
						{
						$minuteswarningARY = explode('minuteswarning=',$VDCL_start_call_url);
						$minuteswarning = preg_replace('/&.*/','',$minuteswarningARY[1]);
						}
					### add this to the Start Call URL for callcard calls to be logged "&minuteswarning=1&callcard=1"
					if (preg_match("/callcard=/",$VDCL_start_call_url))
						{
						$stmt="SELECT balance_minutes_start FROM callcard_log where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00682',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$bms_ct = mysqli_num_rows($rslt);
						if ($bms_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$durationLimit = $row[0];

							$stmt="UPDATE callcard_log set agent_time='$NOW_TIME',agent='$user' where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00683',$user,$server_ip,$session_name,$one_mysql_log);}
							$ccl_update = mysqli_affected_rows($link);
							}
						}
					else
						{
						$SCUresponse = explode('durationLimit',$SCUoutput);
						$durationLimit = preg_replace('/\D/','',$SCUresponse[1]);
						}
					if (strlen($durationLimit) < 1) {$durationLimit = 0;}
					$durationLimitSECnext = ( ($minuteswarning + 0) * 60);
					$durationLimitSEC = ( ( ($durationLimit + 0) - $minuteswarning) * 60);  # minutes - 3 for 3-minute-warning
					if ($durationLimitSEC < 5) {$durationLimitSEC = 5;}
					if ( ($durationLimitSECnext < 30) or (strlen($durationLimitSECnext)<1) ) {$durationLimitSECnext = 30;}

					$timer_action_destination='';
					if (preg_match("/nextstep=/",$VDCL_start_call_url))
						{
						$nextstepARY = explode('nextstep=',$VDCL_start_call_url);
						$nextstep = preg_replace("/&.*/",'',$nextstepARY[1]);
						$nextmessageARY = explode('nextmessage=',$VDCL_start_call_url);
						$nextmessage = preg_replace("/&.*/",'',$nextmessageARY[1]);
						$destinationARY = explode('destination=',$VDCL_start_call_url);
						$destination = preg_replace("/&.*/",'',$destinationARY[1]);
						$timer_action_destination = "nextstep---$nextstep--$durationLimitSECnext--$destination--$nextmessage--";
						}

					$stmt="UPDATE vicidial_live_agents set external_timer_action='D1_DIAL',external_timer_action_message='$minuteswarning minute warning for customer',external_timer_action_seconds='$durationLimitSEC',external_timer_action_destination='$timer_action_destination' where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00684',$user,$server_ip,$session_name,$one_mysql_log);}
					$vla_update_timer = mysqli_affected_rows($link);

					$fp = fopen ("./call_url_log.txt", "a");
					fwrite ($fp, "$VDCL_start_call_url\n$SCUoutput\n$durationLimit|$durationLimitSEC|$vla_update_timer|$minuteswarning|$uniqueid|\n");
					fclose($fp);
					}
				}
			##### END special filtering and response for Vtiger account balance function #####
			}
		### END start_call_url processing ###

		$stage .= "|$agent_dialed_type|$agent_dialed_number|";
		}
	}


################################################################################
### manDiaLlookCaLL - for manual VICIDiaL dialing this will attempt to look up
###                   the trunk channel that the call was placed on
################################################################################
if ($ACTION == 'manDiaLlookCaLL')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$call_good=0;
	$local_update=0;
	if (strlen($MDnextCID)<18)
		{
		echo "NO\n";
		echo "MDnextCID $MDnextCID is not valid\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		##### look for the channel in the UPDATED vicidial_manager record of the call initiation
		$stmt="SELECT uniqueid,channel FROM vicidial_manager where callerid='$MDnextCID' and server_ip='$server_ip' and status IN('UPDATED','DEAD') LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00052',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$VM_mancall_ct = mysqli_num_rows($rslt);
		if ($VM_mancall_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$uniqueid =		$row[0];
			$channel =		$row[1];
			if (preg_match("/^Local/",$channel))
				{$local_update++;}# Local channel not answered or resolved
			else
				{
				$call_output = "$uniqueid\n$channel\n";
				$call_good++;
				}
			}
		if ( ($VM_mancall_ct < 1) or ($local_update > 0) )
			{
			### after 10 seconds, start checking for call termination in the carrier log
			if ( ($DiaL_SecondS > 0) and (preg_match("/0$/",$DiaL_SecondS)) )
				{
				$stmt="SELECT uniqueid,channel,end_epoch FROM call_log where caller_code='$MDnextCID' and server_ip='$server_ip' order by start_time desc LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00291',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$VM_mancallX_ct = mysqli_num_rows($rslt);
				if ($VM_mancallX_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$uniqueid =		$row[0];
					$channel =		$row[1];
					$end_epoch =	$row[2];

					### Check carrier log for error
					$stmt="SELECT dialstatus,hangup_cause,sip_hangup_cause,sip_hangup_reason FROM vicidial_carrier_log where uniqueid='$uniqueid' and server_ip='$server_ip' and channel='$channel' and dialstatus IN('BUSY','CHANUNAVAIL','CONGESTION') LIMIT 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00292',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$CL_mancall_ct = mysqli_num_rows($rslt);
					if ($CL_mancall_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$dialstatus =			$row[0];
						$hangup_cause =			$row[1];
						$sip_hangup_cause =		$row[2];
						$sip_hangup_reason =	$row[3];

						$channel = $dialstatus;
						$hangup_cause_msg = "Cause: " . $hangup_cause . " - " . hangup_cause_description($hangup_cause);
						$sip_hangup_cause_msg='';
						if (strlen($sip_hangup_cause) > 1)
							{
							$sip_hangup_cause_msg = "SIP: " . $sip_hangup_cause . " - ";
							if (strlen($sip_hangup_reason) < 2)
								{$sip_hangup_cause_msg .= sip_hangup_cause_description($sip_hangup_cause);}
							else
								{$sip_hangup_cause_msg .= $sip_hangup_reason;}
							}

						$call_output = "$uniqueid\n$channel\nERROR\n" . $hangup_cause_msg . "\n<br>" . $sip_hangup_cause_msg; 
						$call_good++;

						### Delete call record
						$stmt="DELETE from vicidial_auto_calls where callerid='$MDnextCID';";
							if ($format=='debug') {echo "\n<!-- $stmt -->";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00293',$user,$server_ip,$session_name,$one_mysql_log);}

						$stmt="UPDATE vicidial_live_agents set ring_callerid='' where ring_callerid='$MDnextCID';";
							if ($format=='debug') {echo "\n<!-- $stmt -->";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00399',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					}
				}
			}

		if ($call_good > 0)
			{
			if ($stage != "YES")
				{
				$wait_sec=0;
				$dead_epochSQL = '';
				$stmt = "SELECT wait_epoch,wait_sec,dead_epoch from vicidial_agent_log where agent_log_id='$agent_log_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00053',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDpr_ct = mysqli_num_rows($rslt);
				if ($VDpr_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$wait_sec = (($StarTtime - $row[0]) + $row[1]);
					$now_dead_epoch = $row[2];
					if ( ($now_dead_epoch > 1000) and ($now_dead_epoch < $StarTtime) )
						{$dead_epochSQL = ",dead_epoch='$StarTtime'";}
					}
				$stmt="UPDATE vicidial_agent_log set wait_sec='$wait_sec',talk_epoch='$StarTtime',lead_id='$lead_id' $dead_epochSQL where agent_log_id='$agent_log_id';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00054',$user,$server_ip,$session_name,$one_mysql_log);}

				$stmt="UPDATE vicidial_auto_calls set uniqueid='$uniqueid',channel='$channel' where callerid='$MDnextCID';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00055',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			$stmt="UPDATE call_log set uniqueid='$uniqueid',channel='$channel' where caller_code='$MDnextCID';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00300',$user,$server_ip,$session_name,$one_mysql_log);}

			echo "$call_output";
			}
		else
			{echo "NO\n$DiaL_SecondS\n";}
		}
	}



################################################################################
### manDiaLlogCALL - for manual VICIDiaL logging of calls places record in
###                  vicidial_log and then sends process to call_log entry
################################################################################
if ($ACTION == 'manDiaLlogCaLL')
{
	$MT[0]='';
	$row='';   $rowx='';
	$vidSQL='';
	$VDterm_reason='';

if ($stage == "start")
	{
	if ( (strlen($uniqueid)<1) || (strlen($lead_id)<1) || (strlen($list_id)<1) || (strlen($phone_number)<1) || (strlen($campaign)<1) )
		{
		if ($WeBRooTWritablE > 0)
			{
			$fp = fopen ("./vicidial_debug.txt", "a");
			fwrite ($fp, "$NOW_TIME|VL_LOG_0|$uniqueid|$lead_id|$user|$list_id|$campaign|$start_epoch|$phone_number|$agent_log_id|\n");
			fclose($fp);
			}

		echo "LOG NOT ENTERED\n";
		echo _QXZ("uniqueid %1s or lead_id: %2s or list_id: %3s or phone_number: %4s or campaign: %5s is not valid",0,'',$uniqueid,$lead_id,$list_id,$phone_number,$campaign)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$user_group='';
		$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00056',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$ug_record_ct = mysqli_num_rows($rslt);
		if ($ug_record_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$user_group =		trim("$row[0]");
			}

		##### insert log into vicidial_log_extended for manual VICIDiaL call
		$stmt="INSERT IGNORE INTO vicidial_log_extended SET uniqueid='$uniqueid',server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID',custom_call_id='' ON DUPLICATE KEY UPDATE server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00400',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rowsX = mysqli_affected_rows($link);

		$manualVLexists=0;
		$beginUNIQUEID = preg_replace("/\..*/","",$uniqueid);
		$stmt="SELECT count(*) from vicidial_log where lead_id='$lead_id' and user='$user' and phone_number='$phone_number' and uniqueid LIKE \"$beginUNIQUEID%\" and called_count='$called_count';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00223',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$VL_exists_ct = mysqli_num_rows($rslt);
		if ($VL_exists_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$manualVLexists =		$row[0];
			}

		$manualVLexistsDUP=0;
		if ($manualVLexists < 1)
			{
			##### insert log into vicidial_log for manual VICIDiaL call
			$stmt="INSERT INTO vicidial_log (uniqueid,lead_id,list_id,campaign_id,call_date,start_epoch,status,phone_code,phone_number,user,comments,processed,user_group,alt_dial,called_count) values('$uniqueid','$lead_id','$list_id','$campaign','$NOW_TIME','$StarTtime','INCALL','$phone_code','$phone_number','$user','MANUAL','N','$user_group','$alt_dial','$called_count');";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00279',$user,$server_ip,$session_name,$one_mysql_log);}
			$DUPerrno = mysqli_errno($link);
			if ($DUPerrno > 0)
				{$manualVLexistsDUP=1;}
			$affected_rows = mysqli_affected_rows($link);
			}
		if ( ($manualVLexists > 0) or ($manualVLexistsDUP > 0) )
			{
			##### insert log into vicidial_log for manual VICIDiaL call
			$stmt="UPDATE vicidial_log SET list_id='$list_id',comments='MANUAL',user_group='$user_group',alt_dial='$alt_dial' where lead_id='$lead_id' and user='$user' and phone_number='$phone_number' and uniqueid LIKE \"$beginUNIQUEID%\" and called_count='$called_count';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00224',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			}

		if ($affected_rows > 0)
			{
			echo _QXZ("VICIDiaL_LOG Inserted:")." $uniqueid|$channel|$NOW_TIME\n";
			echo "$StarTtime\n";
			}
		else
			{
			echo "LOG NOT ENTERED\n";
			}

		$stmt = "UPDATE vicidial_auto_calls SET uniqueid='$uniqueid' where lead_id='$lead_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00058',$user,$server_ip,$session_name,$one_mysql_log);}

	#	##### insert log into call_log for manual VICIDiaL call
	#	$stmt = "INSERT INTO call_log (uniqueid,channel,server_ip,extension,number_dialed,caller_code,start_time,start_epoch) values('$uniqueid','$channel','$server_ip','$exten','$phone_code$phone_number','MD $user $lead_id','$NOW_TIME','$StarTtime')";
	#	if ($DB) {echo "$stmt\n";}
	#	$rslt=mysql_to_mysqli($stmt, $link);
	#	$affected_rows = mysqli_affected_rows($link);

	#	if ($affected_rows > 0)
	#		{
	#		echo "CALL_LOG Inserted: $uniqueid|$channel|$NOW_TIME";
	#		}
	#	else
	#		{
	#		echo "LOG NOT ENTERED\n";
	#		}
		}
	}

if ($stage == "end")
	{
	$status_dispo = 'DISPO';
	$log_no_enter=0;
	if ($alt_num_status > 0)
		{$status_dispo = 'ALTNUM';}
	$number_dialed = $phone_number;
	##### get call type from vicidial_live_agents table
	$VLA_inOUT='NONE';
	$stmt="SELECT comments FROM vicidial_live_agents where user='$user' order by last_update_time desc limit 1;";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00059',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($DB) {echo "$stmt\n";}
	$VLA_inOUT_ct = mysqli_num_rows($rslt);
	if ($VLA_inOUT_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$VLA_inOUT =		$row[0];
		}

	if (strlen($user_group) < 1)
		{
		$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00596',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$ug_record_ct = mysqli_num_rows($rslt);
		if ($ug_record_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$user_group =		trim("$row[0]");
			}
		}

	if ( (strlen($uniqueid)<1) and ($VLA_inOUT == 'INBOUND') )
		{
		$fp = fopen ("./vicidial_debug.txt", "a");
		fwrite ($fp, "$NOW_TIME|INBND_LOG_0|$uniqueid|$lead_id|$user|$inOUT|$VLA_inOUT|$start_epoch|$phone_number|$agent_log_id|\n");
		fclose($fp);
		$uniqueid='6666.1';
		}

	if ( (strlen($uniqueid)<1) and ($VLA_inOUT == 'MANUAL') )
		{
		$stmt="SELECT uniqueid FROM vicidial_log_extended where caller_code='$MDnextCID' order by call_date desc limit 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00595',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$VLE_unid_ct = mysqli_num_rows($rslt);
		if ($VLE_unid_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$uniqueid =		$row[0];
			}
		else
			{
			$PADlead_id = sprintf("%010s", $lead_id);
				while (strlen($PADlead_id) > 9) {$PADlead_id = substr("$PADlead_id", 1);}
			$uniqueid = "$StarTtime.$PADlead_id";
			}
		$VDvicidial_id = $uniqueid;
		}

	if ( (strlen($uniqueid)<1) or (strlen($lead_id)<1) )
		{
		echo "LOG NOT ENTERED\n";
		echo _QXZ("uniqueid %1s or lead_id: %2s is not valid",0,'',$uniqueid,$lead_id)."\n";
		$log_no_enter=1;
		}
	else
		{
		$term_reason='NONE';
		if ($start_epoch < 1000)
			{
			if ( ($VLA_inOUT == 'INBOUND') or ($VLA_inOUT == 'CHAT') or ($VLA_inOUT == 'EMAIL') )
				{
				$four_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-4,date("i"),date("s"),date("m"),date("d"),date("Y")));

				##### look for the start epoch in the vicidial_closer_log table
				$stmt="SELECT start_epoch,term_reason,closecallid,campaign_id,status FROM vicidial_closer_log where phone_number='$phone_number' and lead_id='$lead_id' and user='$user' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
				$VDIDselect =		"VDCL_LID $lead_id $phone_number $user $four_hours_ago";
				}
			else
				{
				##### look for the start epoch in the vicidial_log table
				$stmt="SELECT start_epoch,term_reason,uniqueid,campaign_id,status FROM vicidial_log where uniqueid='$uniqueid' and lead_id='$lead_id' and called_count='$called_count' order by call_date desc limit 1;";
				$VDIDselect =		"VDL_UIDLID $uniqueid $lead_id";
				}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00060',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$VM_mancall_ct = mysqli_num_rows($rslt);
			if ($VM_mancall_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$start_epoch =		$row[0];
				$VDterm_reason =	$row[1];
				$VDvicidial_id =	$row[2];
				$VDcampaign_id =	$row[3];
				$VDstatus =			$row[4];
				$length_in_sec = ($StarTtime - $start_epoch);
				}
			else
				{
				$length_in_sec = 0;
				}

			if ( ($length_in_sec < 1) and ($VLA_inOUT == 'INBOUND') )
				{
				$fp = fopen ("./vicidial_debug.txt", "a");
				fwrite ($fp, "$NOW_TIME|INBND_LOG_1|$uniqueid|$lead_id|$user|$inOUT|$length_in_sec|$VDterm_reason|$VDvicidial_id|$start_epoch|\n");
				fclose($fp);

				##### start epoch in the vicidial_log table, couldn't find one in vicidial_closer_log
				$stmt="SELECT start_epoch,term_reason,campaign_id,status FROM vicidial_log where uniqueid='$uniqueid' and lead_id='$lead_id' and called_count='$called_count' order by call_date desc limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00061',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$VM_mancall_ct = mysqli_num_rows($rslt);
				if ($VM_mancall_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$start_epoch =		$row[0];
					$VDterm_reason =	$row[1];
					$VDcampaign_id =	$row[2];
					$VDstatus =			$row[3];
					$length_in_sec = ($StarTtime - $start_epoch);
					}
				else
					{
					$length_in_sec = 0;
					}
				}
			}
		else {$length_in_sec = ($StarTtime - $start_epoch);}
		
		if (strlen($VDcampaign_id)<1) {$VDcampaign_id = $campaign;}

		$four_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-4,date("i"),date("s"),date("m"),date("d"),date("Y")));

		if ( ($VLA_inOUT == 'INBOUND') or ($VLA_inOUT == 'CHAT') or ($VLA_inOUT == 'EMAIL') )
			{
			$vcl_statusSQL='';
			if ($VDstatus == 'INCALL') {$vcl_statusSQL = ",status='$status_dispo'";}
			$stmt = "UPDATE vicidial_closer_log set end_epoch='$StarTtime', length_in_sec='$length_in_sec' $vcl_statusSQL where lead_id='$lead_id' and user='$user' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00062',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			if ($affected_rows > 0)
				{
				echo "$uniqueid\n$channel\n";

			#	$fp = fopen ("./vicidial_debug.txt", "a");
			#	fwrite ($fp, "$NOW_TIME|INBND_LOG_4|$VDstatus|$uniqueid|$lead_id|$user|$inOUT|$length_in_sec|$VDterm_reason|$VDvicidial_id|$start_epoch|$stmt|\n");
			#	fclose($fp);
				}
			else
				{
				$fp = fopen ("./vicidial_debug.txt", "a");
				fwrite ($fp, "$NOW_TIME|INBND_LOG_2|$uniqueid|$lead_id|$user|$inOUT|$length_in_sec|$VDterm_reason|$VDvicidial_id|$start_epoch|\n");
				fclose($fp);
				}
			}

		#############################################
		##### START QUEUEMETRICS LOGGING LOOKUP #####
		$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_dispo_pause,queuemetrics_pe_phone_append,queuemetrics_socket,queuemetrics_socket_url,queuemetrics_pause_type FROM system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00063',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$qm_conf_ct = mysqli_num_rows($rslt);
		$i=0;
		if ($qm_conf_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$enable_queuemetrics_logging =	$row[0];
			$queuemetrics_server_ip	=		$row[1];
			$queuemetrics_dbname =			$row[2];
			$queuemetrics_login	=			$row[3];
			$queuemetrics_pass =			$row[4];
			$queuemetrics_log_id =			$row[5];
			$queuemetrics_dispo_pause =		$row[6];
			$queuemetrics_pe_phone_append = $row[7];
			$queuemetrics_socket =			$row[8];
			$queuemetrics_socket_url =		$row[9];
			$queuemetrics_pause_type =		$row[10];

			if ($enable_queuemetrics_logging > 0)
				{
				$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
				if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
				mysqli_select_db($linkB, "$queuemetrics_dbname");
				}
			}
		##### END QUEUEMETRICS LOGGING LOOKUP #####
		###########################################

		if ($auto_dial_level > 0)
			{
			### check to see if campaign has alt_dial enabled
			$stmt="SELECT auto_alt_dial,use_internal_dnc,use_campaign_dnc,use_other_campaign_dnc FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00064',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$VAC_mancall_ct = mysqli_num_rows($rslt);
			if ($VAC_mancall_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$auto_alt_dial =			$row[0];
				$use_internal_dnc =			$row[1];
				$use_campaign_dnc =			$row[2];
				$use_other_campaign_dnc =	$row[3];
				}
			else {$auto_alt_dial = 'NONE';}
			if (preg_match("/(ALT_ONLY|ADDR3_ONLY|ALT_AND_ADDR3|ALT_AND_EXTENDED|ALT_AND_ADDR3_AND_EXTENDED|EXTENDED_ONLY)/i",$auto_alt_dial))
				{
				### check to see if lead should be alt_dialed
				if (strlen($alt_dial)<2) {$alt_dial = 'NONE';}

				### check if inbound call, if so find a recent outbound call to pull alt_dial value from
				if ($VLA_inOUT == 'INBOUND')
					{
					$one_hour_ago = date("Y-m-d H:i:s", mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y")));
					##### find a recent outbound call associated with this inbound call
					$stmt="SELECT alt_dial FROM vicidial_log where lead_id='$lead_id' and status IN('DROP','XDROP') and call_date > \"$one_hour_ago\" order by call_date desc limit 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00235',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VL_alt_ct = mysqli_num_rows($rslt);
					if ($VL_alt_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$alt_dial =		$row[0];
						}
					}

				if ( (preg_match("/(NONE|MAIN)/i",$alt_dial)) and (preg_match("/(ALT_ONLY|ALT_AND_ADDR3|ALT_AND_EXTENDED)/i",$auto_alt_dial)) )
					{
					$alt_dial_skip=0;
					$stmt="SELECT alt_phone,gmt_offset_now,state,vendor_lead_code FROM vicidial_list where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00065',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VAC_mancall_ct = mysqli_num_rows($rslt);
					if ($VAC_mancall_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$alt_phone =		$row[0];
						$alt_phone = preg_replace("/[^0-9]/i","",$alt_phone);
						$gmt_offset_now =	$row[1];
						$state =			$row[2];
						$vendor_lead_code =	$row[3];
						}
					else {$alt_phone = '';}
					if (strlen($alt_phone)>5)
						{
						if ( (preg_match("/Y/",$use_internal_dnc)) or (preg_match("/AREACODE/",$use_internal_dnc)) )
							{
							if (preg_match("/AREACODE/",$use_internal_dnc))
								{
								$alt_phone_areacode = substr($alt_phone, 0, 3);
								$alt_phone_areacode .= "XXXXXXX";
								$stmtA="SELECT count(*) from vicidial_dnc where phone_number IN('$alt_phone','$alt_phone_areacode');";
								}
							else
								{$stmtA="SELECT count(*) FROM vicidial_dnc where phone_number='$alt_phone';";}
							$rslt=mysql_to_mysqli($stmtA, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00066',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$VLAP_dnc_ct = mysqli_num_rows($rslt);
							if ($VLAP_dnc_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$VD_alt_dnc_count =		$row[0];
								}
							}
						else {$VD_alt_dnc_count=0;}
						if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
							{
							$temp_campaign_id = $campaign;
							if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}
							if (preg_match("/AREACODE/",$use_campaign_dnc))
								{
								$alt_phone_areacode = substr($alt_phone, 0, 3);
								$alt_phone_areacode .= "XXXXXXX";
								$stmtA="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$alt_phone','$alt_phone_areacode') and campaign_id='$temp_campaign_id';";
								}
							else
								{$stmtA="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$alt_phone' and campaign_id='$temp_campaign_id';";}
							$rslt=mysql_to_mysqli($stmtA, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00067',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$VLAP_cdnc_ct = mysqli_num_rows($rslt);
							if ($VLAP_cdnc_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$VD_alt_dnc_count =		($VD_alt_dnc_count + $row[0]);
								}
							}
						if ($VD_alt_dnc_count < 1)
							{
							### insert record into vicidial_hopper for alt_phone call attempt
							$stmt = "INSERT INTO vicidial_hopper SET lead_id='$lead_id',campaign_id='$campaign',status='HOLD',list_id='$list_id',gmt_offset_now='$gmt_offset_now',state='$state',alt_dial='ALT',user='',priority='25',source='A',vendor_lead_code=\"$vendor_lead_code\";";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00068',$user,$server_ip,$session_name,$one_mysql_log);}
							}
						else
							{$alt_dial_skip=1;}
						}
					else
						{$alt_dial_skip=1;}
					if ($alt_dial_skip > 0)
						{$alt_dial='ALT';}
					}

				if ( ( (preg_match("/(ALT)/i",$alt_dial)) and (preg_match("/ALT_AND_ADDR3/i",$auto_alt_dial)) ) or ( (preg_match("/(NONE|MAIN)/i",$alt_dial)) and (preg_match("/ADDR3_ONLY/i",$auto_alt_dial)) ) )
					{
					$addr3_dial_skip=0;
					$stmt="SELECT address3,gmt_offset_now,state,vendor_lead_code FROM vicidial_list where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00069',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VAC_mancall_ct = mysqli_num_rows($rslt);
					if ($VAC_mancall_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$address3 =			$row[0];
						$address3 = preg_replace("/[^0-9]/i","",$address3);
						$gmt_offset_now =	$row[1];
						$state =			$row[2];
						$vendor_lead_code = $row[3];
						}
					else {$address3 = '';}
					if (strlen($address3)>5)
						{
						if ( (preg_match("/Y/",$use_internal_dnc)) or (preg_match("/AREACODE/",$use_internal_dnc)) )
							{
							if (preg_match("/AREACODE/",$use_internal_dnc))
								{
								$addr3_phone_areacode = substr($address3, 0, 3);
								$addr3_phone_areacode .= "XXXXXXX";
								$stmtA="SELECT count(*) from vicidial_dnc where phone_number IN('$address3','$addr3_phone_areacode');";
								}
							else
								{$stmtA="SELECT count(*) FROM vicidial_dnc where phone_number='$address3';";}
							$rslt=mysql_to_mysqli($stmtA, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00070',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$VLAP_dnc_ct = mysqli_num_rows($rslt);
							if ($VLAP_dnc_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$VD_alt_dnc_count =		$row[0];
								}
							}
						else {$VD_alt_dnc_count=0;}
						if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
							{
							$temp_campaign_id = $campaign;
							if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}
							if (preg_match("/AREACODE/",$use_campaign_dnc))
								{
								$addr3_phone_areacode = substr($address3, 0, 3);
								$addr3_phone_areacode .= "XXXXXXX";
								$stmtA="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$address3','$addr3_phone_areacode') and campaign_id='$temp_campaign_id';";
								}
							else
								{$stmtA="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$address3' and campaign_id='$temp_campaign_id';";}
							$rslt=mysql_to_mysqli($stmtA, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00071',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$VLAP_cdnc_ct = mysqli_num_rows($rslt);
							if ($VLAP_cdnc_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$VD_alt_dnc_count =		($VD_alt_dnc_count + $row[0]);
								}
							}
						if ($VD_alt_dnc_count < 1)
							{
							### insert record into vicidial_hopper for address3 call attempt
							$stmt = "INSERT INTO vicidial_hopper SET lead_id='$lead_id',campaign_id='$campaign',status='HOLD',list_id='$list_id',gmt_offset_now='$gmt_offset_now',state='$state',alt_dial='ADDR3',user='',priority='20',source='A',vendor_lead_code=\"$vendor_lead_code\";";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00072',$user,$server_ip,$session_name,$one_mysql_log);}
							}
						else
							{$addr3_dial_skip=1;}
						}
					else
						{$addr3_dial_skip=1;}
					if ($addr3_dial_skip > 0)
						{$alt_dial='ADDR3';}
					}

	#		$fp = fopen ("./alt_multi_log.txt", "a");
	#		fwrite ($fp, "$NOW_TIME|PRE-X|$campaign|$lead_id|$phone_number|$user|$Ctype|$callerid|$uniqueid|$stmt|$auto_alt_dial|$alt_dial\n");
	#		fclose($fp);

				if ( ( ( (preg_match("/(NONE|MAIN)/i",$alt_dial)) and (preg_match("/EXTENDED_ONLY/i",$auto_alt_dial)) ) or ( (preg_match("/(ALT)/i",$alt_dial)) and (preg_match("/(ALT_AND_EXTENDED)/i",$auto_alt_dial)) ) or ( (preg_match("/(ADDR3)/i",$alt_dial)) and (preg_match("/(ADDR3_AND_EXTENDED|ALT_AND_ADDR3_AND_EXTENDED)/i",$auto_alt_dial)) ) or ( (preg_match("/(X)/i",$alt_dial)) and (preg_match("/EXTENDED/i",$auto_alt_dial)) ) )  and (!preg_match("/LAST/i",$alt_dial)) )
					{
					if (preg_match("/(ADDR3)/i",$alt_dial)) {$Xlast=0;}
					else
						{$Xlast = preg_replace("/[^0-9]/","",$alt_dial);}
					if (strlen($Xlast)<1)
						{$Xlast=0;}
					$VD_altdialx='';

					$stmt="SELECT gmt_offset_now,state,list_id,entry_list_id,vendor_lead_code FROM vicidial_list where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00073',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VL_deailts_ct = mysqli_num_rows($rslt);
					if ($VL_deailts_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$EA_gmt_offset_now =	$row[0];
						$EA_state =				$row[1];
						$EA_list_id =			$row[2];
						$EA_entry_list_id =		$row[3];
						$EA_vendor_lead_code =	$row[4];
						}
					$alt_dial_phones_count=0;
					$stmt="SELECT count(*) FROM vicidial_list_alt_phones where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00074',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VLAP_ct = mysqli_num_rows($rslt);
					if ($VLAP_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$alt_dial_phones_count =	$row[0];
						}
					while ( ($alt_dial_phones_count > 0) and ($alt_dial_phones_count > $Xlast) )
						{
						$Xlast++;
						$stmt="SELECT alt_phone_id,phone_number,active FROM vicidial_list_alt_phones where lead_id='$lead_id' and alt_phone_count='$Xlast';";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00075',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$VLAP_detail_ct = mysqli_num_rows($rslt);
						if ($VLAP_detail_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$VD_altdial_id =		$row[0];
							$VD_altdial_phone =		$row[1];
							$VD_altdial_active =	$row[2];
							}
						else
							{$Xlast=9999999999;}

						if (preg_match("/Y/",$VD_altdial_active))
							{
							if ( (preg_match("/Y/",$use_internal_dnc)) or (preg_match("/AREACODE/",$use_internal_dnc)) )
								{
								if (preg_match("/AREACODE/",$use_internal_dnc))
									{
									$vdap_phone_areacode = substr($VD_altdial_phone, 0, 3);
									$vdap_phone_areacode .= "XXXXXXX";
									$stmtA="SELECT count(*) from vicidial_dnc where phone_number IN('$VD_altdial_phone','$vdap_phone_areacode');";
									}
								else
									{$stmtA="SELECT count(*) FROM vicidial_dnc where phone_number='$VD_altdial_phone';";}
								$rslt=mysql_to_mysqli($stmtA, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00076',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$VLAP_dnc_ct = mysqli_num_rows($rslt);
								if ($VLAP_dnc_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$VD_alt_dnc_count =		$row[0];
									}
								}
							else {$VD_alt_dnc_count=0;}
							if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
								{
								$temp_campaign_id = $campaign;
								if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}
								if (preg_match("/AREACODE/",$use_campaign_dnc))
									{
									$vdap_phone_areacode = substr($VD_altdial_phone, 0, 3);
									$vdap_phone_areacode .= "XXXXXXX";
									$stmtA="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$VD_altdial_phone','$vdap_phone_areacode') and campaign_id='$temp_campaign_id';";
									}
								else
									{$stmtA="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$VD_altdial_phone' and campaign_id='$temp_campaign_id';";}
								$rslt=mysql_to_mysqli($stmtA, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00077',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$VLAP_cdnc_ct = mysqli_num_rows($rslt);
								if ($VLAP_cdnc_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$VD_alt_dnc_count =		($VD_alt_dnc_count + $row[0]);
									}
								}
							if ($VD_alt_dnc_count < 1)
								{
								if ($alt_dial_phones_count == $Xlast) 
									{$Xlast = 'LAST';}
								$stmt = "INSERT INTO vicidial_hopper SET lead_id='$lead_id',campaign_id='$campaign',status='HOLD',list_id='$EA_list_id',gmt_offset_now='$EA_gmt_offset_now',state='$EA_state',alt_dial='X$Xlast',user='',priority='15',source='A',vendor_lead_code=\"$EA_vendor_lead_code\";";
								if ($DB) {echo "$stmt\n";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00078',$user,$server_ip,$session_name,$one_mysql_log);}
								$Xlast=9999999999;
								}
							}
						}
					}
				}

			if ($enable_queuemetrics_logging > 0)
				{
				### grab call lead information needed for QM logging
				$stmt="SELECT auto_call_id,lead_id,phone_number,status,campaign_id,phone_code,alt_dial,stage,callerid,uniqueid from vicidial_auto_calls where lead_id='$lead_id' order by call_time limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00079',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$VAC_qm_ct = mysqli_num_rows($rslt);
				if ($VAC_qm_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$auto_call_id	= $row[0];
					$CLlead_id		= $row[1];
					$CLphone_number	= $row[2];
					$CLstatus		= $row[3];
					$CLcampaign_id	= $row[4];
					$CLphone_code	= $row[5];
					$CLalt_dial		= $row[6];
					$CLstage		= $row[7];
					$CLcallerid		= $row[8];
					$CLuniqueid		= $row[9];
					}

				$CLstage = preg_replace("/.*-/",'',$CLstage);
				if (strlen($CLstage) < 1) {$CLstage=0;}

				$stmt="SELECT count(*) from queue_log where call_id='$MDnextCID' and verb='COMPLETECALLER' and queue='$VDcampaign_id';";
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00080',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$VAC_cc_ct = mysqli_num_rows($rslt);
				if ($VAC_cc_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$caller_complete	= $row[0];
					}

				if ($caller_complete < 1)
					{
					$term_reason='AGENT';
					}
				else
					{
					$term_reason='CALLER';
					}

				}

			if ($nodeletevdac < 1)
				{
				### delete call record from  vicidial_auto_calls
				$stmt = "DELETE from vicidial_auto_calls where lead_id='$lead_id' and campaign_id='$VDcampaign_id' and uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00081',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			$licf_SQL = '';
			if ($VLA_inOUT == 'INBOUND')
				{$licf_SQL = ",last_inbound_call_finish='$NOW_TIME'";}
			$stmt = "UPDATE vicidial_live_agents set status='PAUSED',uniqueid=0,callerid='',channel='',call_server_ip='',last_call_finish='$NOW_TIME',comments='',last_state_change='$NOW_TIME',preview_lead_id='0' $licf_SQL where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00082',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9082$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			$affected_rows = mysqli_affected_rows($link);
			if ($affected_rows > 0) 
				{
				if ($enable_queuemetrics_logging > 0)
					{
					$data4SQL='';
					$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00391',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cqpe_ct = mysqli_num_rows($rslt);
					if ($cqpe_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$pe_append='';
						if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
							{$pe_append = "-$qm_extension";}
						$data4SQL = ",data4='$row[0]$pe_append'";
						}

					$pause_typeSQL='';
					if ($queuemetrics_pause_type > 0)
						{$pause_typeSQL=",data5='AGENT'";}
					$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='PAUSEALL',serverid='$queuemetrics_log_id' $data4SQL $pause_typeSQL;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00083',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($linkB);
					}
				}
			}
		else
			{
			if ($enable_queuemetrics_logging > 0)
				{
				$CLqueue_position=1;
				### check to see if lead should be alt_dialed
				$stmt="SELECT auto_call_id,lead_id,phone_number,status,campaign_id,phone_code,alt_dial,stage,callerid,uniqueid,queue_position from vicidial_auto_calls where lead_id='$lead_id' order by call_time desc limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00084',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$VAC_qm_ct = mysqli_num_rows($rslt);
				if ($VAC_qm_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$auto_call_id = 		$row[0];
					$CLlead_id = 			$row[1];
					$CLphone_number =		$row[2];
					$CLstatus = 			$row[3];
					$CLcampaign_id = 		$row[4];
					$CLphone_code = 		$row[5];
					$CLalt_dial =			$row[6];
					$CLstage =				$row[7];
					$CLcallerid =			$row[8];
					$CLuniqueid =			$row[9];
					$CLqueue_position =		$row[10];
					}

				$CLstage = preg_replace("/XFER|CLOSER|-/",'',$CLstage);
				if ($CLstage < 0.25) {$CLstage=0;}

				$data4SQL='';
				$data4SS='';
				$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00392',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cqpe_ct = mysqli_num_rows($rslt);
				if ($cqpe_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$pe_append='';
					if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
						{$pe_append = "-$qm_extension";}
					$data4SQL = ",data4='$row[0]$pe_append'";
					$data4SS = "&data4=$row[0]$pe_append";
					}

				$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MDnextCID',queue='$VDcampaign_id',agent='Agent/$user',verb='COMPLETEAGENT',data1='$CLstage',data2='$length_in_sec',data3='$CLqueue_position',serverid='$queuemetrics_log_id' $data4SQL;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00085',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($linkB);

				if ( ($queuemetrics_socket == 'CONNECT_COMPLETE') and (strlen($queuemetrics_socket_url) > 10) )
					{
					if (preg_match("/--A--/",$queuemetrics_socket_url))
						{
						##### grab the data from vicidial_list for the lead_id
						$stmt="SELECT vendor_lead_code,list_id,phone_code,phone_number,title,first_name,middle_initial,last_name,postal_code FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00541',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$list_lead_ct = mysqli_num_rows($rslt);
						if ($list_lead_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$vendor_id		= urlencode(trim($row[0]));
							$list_id		= urlencode(trim($row[1]));
							$phone_code		= urlencode(trim($row[2]));
							$phone_number	= urlencode(trim($row[3]));
							$title			= urlencode(trim($row[4]));
							$first_name		= urlencode(trim($row[5]));
							$middle_initial	= urlencode(trim($row[6]));
							$last_name		= urlencode(trim($row[7]));
							$postal_code	= urlencode(trim($row[8]));
							}
						$queuemetrics_socket_url = preg_replace('/^VAR/','',$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--lead_id--B--/i',"$lead_id",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_id",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--list_id--B--/i',"$list_id",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--phone_number--B--/i',"$phone_number",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--title--B--/i',"$title",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--first_name--B--/i',"$first_name",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--last_name--B--/i',"$last_name",$queuemetrics_socket_url);
						$queuemetrics_socket_url = preg_replace('/--A--postal_code--B--/i',"$postal_code",$queuemetrics_socket_url);
						}
					$socket_send_data_begin='?';
					$socket_send_data = "time_id=$StarTtime&call_id=$MDnextCID&queue=$VDcampaign_id&agent=Agent/$user&verb=COMPLETEAGENT&data1=$CLstage&data2=$length_in_sec&data3=$CLqueue_position$data4SS";
					if (preg_match("/\?/",$queuemetrics_socket_url))
						{$socket_send_data_begin='&';}
					### send queue_log data to the queuemetrics_socket_url ###
					if ($DB > 0) {echo "$queuemetrics_socket_url$socket_send_data_begin$socket_send_data<BR>\n";}
					$SCUfile = file("$queuemetrics_socket_url$socket_send_data_begin$socket_send_data");
					if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}
					}
				}

			if ($nodeletevdac < 1)
				{
			#	$stmt = "DELETE from vicidial_auto_calls where lead_id='$lead_id' and campaign_id='$campaign' and uniqueid='$uniqueid';";
				$stmt = "DELETE from vicidial_auto_calls where lead_id='$lead_id' and campaign_id='$VDcampaign_id' and callerid LIKE \"M%\";";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00086',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			$stmt = "UPDATE vicidial_live_agents set status='PAUSED',uniqueid=0,callerid='',channel='',call_server_ip='',last_call_finish='$NOW_TIME',comments='',last_state_change='$NOW_TIME',preview_lead_id='0' where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00087',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9087$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			$affected_rows = mysqli_affected_rows($link);
			if ($affected_rows > 0) 
				{
				if ($enable_queuemetrics_logging > 0)
					{
					$pause_typeSQL='';
					if ($queuemetrics_pause_type > 0)
						{$pause_typeSQL=",data5='AGENT'";}
					$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='PAUSEALL',serverid='$queuemetrics_log_id' $data4SQL $pause_typeSQL;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00088',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($linkB);
					}
				}
			}

		if ( ($VLA_inOUT == 'AUTO') or ($VLA_inOUT == 'MANUAL') )
			{
			$SQLterm = "term_reason='$term_reason',";

			if ( (preg_match("/NONE/",$term_reason)) or (preg_match("/NONE/",$VDterm_reason)) or (strlen($VDterm_reason) < 1) )
				{
				### check to see if lead should be alt_dialed
				$stmt="SELECT term_reason,uniqueid,status from vicidial_log where uniqueid='$uniqueid' and lead_id='$lead_id' order by call_date desc limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00089',$user,$server_ip,$session_name,$one_mysql_log);}
				$VAC_qm_ct = mysqli_num_rows($rslt);
				if ($VAC_qm_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDterm_reason =	$row[0];
					$VDvicidial_id =	$row[1];
					$VDstatus =			$row[2];
					$VDIDselect =		"VDL_UIDLID $uniqueid $lead_id";
					}
				if (preg_match("/CALLER/",$VDterm_reason))
					{
					$SQLterm = "";
					}
				else
					{
					$SQLterm = "term_reason='AGENT',";
					}
				}

			### check to see if the vicidial_log record exists, if not, insert it
			$manualVLexists=0;
			$beginUNIQUEID = preg_replace("/\..*/","",$uniqueid);
			$stmt="SELECT status from vicidial_log where lead_id='$lead_id' and user IN('$user','VDAD') and phone_number='$number_dialed' and uniqueid LIKE \"$beginUNIQUEID%\" and called_count='$called_count';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00547',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$stmtVQ = $stmt;
			$manualVLexists = mysqli_num_rows($rslt);
			if ($manualVLexists > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDstatus =		$row[0];
				}

			if ($manualVLexists < 1)
				{
				##### insert log into vicidial_log for manual VICIDiaL call if not already there
				$stmtVL="INSERT INTO vicidial_log SET $SQLterm end_epoch='$StarTtime',length_in_sec='$length_in_sec',uniqueid='$uniqueid',lead_id='$lead_id',list_id='$list_id',campaign_id='$campaign',call_date='$NOW_TIME',start_epoch='$StarTtime',status='DONEM',phone_code='$phone_code',phone_number='$number_dialed',user='$user',comments='MANUAL',processed='N',user_group='$user_group',alt_dial='$alt_dial',called_count='$called_count';";
				if ($DB) {echo "$stmtVL\n";}
				$rslt=mysql_to_mysqli($stmtVL, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtVL,'00280',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rowsVL = mysqli_affected_rows($link);

				if ($affected_rowsVL > 0)
					{
					echo _QXZ("VICIDiaL_LOG Inserted:")." $uniqueid|$channel|$NOW_TIME\n";
					echo "$StarTtime\n";
					}
				else
					{
					echo "LOG NOT ENTERED\n\n";
					}
				}
			else
				{
				##### update vicidial_log record with end time, duration and other fields
				$stmtVL="UPDATE vicidial_log SET $SQLterm end_epoch='$StarTtime',length_in_sec='$length_in_sec',uniqueid='$uniqueid',alt_dial='$alt_dial',user='$user' where lead_id='$lead_id' and user IN('$user','VDAD') and phone_number='$number_dialed' and uniqueid LIKE \"$beginUNIQUEID%\" and called_count='$called_count';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmtVL, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtVL,'00057',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rowsVL = mysqli_affected_rows($link);
				}

			##### insert log into vicidial_log_extended for manual VICIDiaL call
			$stmt="INSERT IGNORE INTO vicidial_log_extended SET uniqueid='$uniqueid',server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID',custom_call_id='' ON DUPLICATE KEY UPDATE server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00401',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rowsX = mysqli_affected_rows($link);

			##### if status of call in vicidial_log is INCALL update to DISPO
			if ($VDstatus == 'INCALL') 
				{
				$stmt="UPDATE vicidial_log set status='$status_dispo' where uniqueid='$uniqueid' and lead_id='$lead_id' and user='$user' and called_count='$called_count' and status='INCALL' order by call_date desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00090',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				}

			if ($affected_rowsVL > 0)
				{
				echo "$uniqueid\n$channel\n";
				}
			else
				{
				echo "LOG NOT ENTERED\n\n";
				}
			}
		else
			{
			$SQLterm = "term_reason='$term_reason'";
			$QL_term='';

			if ( (preg_match("/NONE/",$term_reason)) or (preg_match("/NONE/",$VDterm_reason)) or (strlen($VDterm_reason) < 1) )
				{
				### find out who hung up the call
				$stmt="SELECT term_reason,closecallid,queue_position from vicidial_closer_log where lead_id='$lead_id' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00091',$user,$server_ip,$session_name,$one_mysql_log);}
				$VAC_qm_ct = mysqli_num_rows($rslt);
				if ($VAC_qm_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDterm_reason =		$row[0];
					$VDvicidial_id =		$row[1];
					$VDqueue_position =		$row[2];
					$VDIDselect =		"VDCL_LID4HOUR $lead_id $four_hours_ago";
					}
				if (preg_match("/CALLER/",$VDterm_reason))
					{
					$SQLterm = "";
					}
				else
					{
					$SQLterm = "term_reason='AGENT'";
					$QL_term = 'COMPLETEAGENT';
					}
				}

			if (strlen($SQLterm) > 0)
				{
				##### update the duration and end time in the vicidial_closer_log table
				$stmt="UPDATE vicidial_closer_log set $SQLterm where lead_id='$lead_id' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00092',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				}

			if ($enable_queuemetrics_logging > 0)
				{
				if ( (strlen($QL_term) > 0) and ($leaving_threeway > 0) )
					{
					$stmt="SELECT count(*) from queue_log where call_id='$MDnextCID' and verb='COMPLETEAGENT' and queue='$VDcampaign_id';";
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00093',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VAC_cc_ct = mysqli_num_rows($rslt);
					if ($VAC_cc_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$agent_complete	= $row[0];
						}
					if ($agent_complete < 1)
						{
						if (strlen($VDqueue_position) < 1)
							{
							### find out who hung up the call
							$stmt="SELECT queue_position from vicidial_closer_log where lead_id='$lead_id' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00273',$user,$server_ip,$session_name,$one_mysql_log);}
							$VAC_qm_ct = mysqli_num_rows($rslt);
							if ($VAC_qm_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$VDqueue_position =		$row[0];
								}
							}
						if (strlen($VDqueue_position) < 1)
							{$VDqueue_position=1;}

						$data4SQL='';
						$data4SS='';
						$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00393',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$cqpe_ct = mysqli_num_rows($rslt);
						if ($cqpe_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$pe_append='';
							if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
								{$pe_append = "-$qm_extension";}
							$data4SQL = ",data4='$row[0]$pe_append'";
							$data4SS = "&data4=$row[0]$pe_append";
							}

						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MDnextCID',queue='$VDcampaign_id',agent='Agent/$user',verb='COMPLETEAGENT',data1='$CLstage',data2='$length_in_sec',data3='$VDqueue_position',serverid='$queuemetrics_log_id' $data4SQL;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00094',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);

						if ( ($queuemetrics_socket == 'CONNECT_COMPLETE') and (strlen($queuemetrics_socket_url) > 10) )
							{
							if (preg_match("/--A--/",$queuemetrics_socket_url))
								{
								##### grab the data from vicidial_list for the lead_id
								$stmt="SELECT vendor_lead_code,list_id,phone_code,phone_number,title,first_name,middle_initial,last_name,postal_code FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00542',$user,$server_ip,$session_name,$one_mysql_log);}
								if ($DB) {echo "$stmt\n";}
								$list_lead_ct = mysqli_num_rows($rslt);
								if ($list_lead_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$vendor_id		= urlencode(trim($row[0]));
									$list_id		= urlencode(trim($row[1]));
									$phone_code		= urlencode(trim($row[2]));
									$phone_number	= urlencode(trim($row[3]));
									$title			= urlencode(trim($row[4]));
									$first_name		= urlencode(trim($row[5]));
									$middle_initial	= urlencode(trim($row[6]));
									$last_name		= urlencode(trim($row[7]));
									$postal_code	= urlencode(trim($row[8]));
									}
								$queuemetrics_socket_url = preg_replace('/^VAR/','',$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--lead_id--B--/i',"$lead_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--list_id--B--/i',"$list_id",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--phone_number--B--/i',"$phone_number",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--title--B--/i',"$title",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--first_name--B--/i',"$first_name",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--last_name--B--/i',"$last_name",$queuemetrics_socket_url);
								$queuemetrics_socket_url = preg_replace('/--A--postal_code--B--/i',"$postal_code",$queuemetrics_socket_url);
								}
							$socket_send_data_begin='?';
							$socket_send_data = "time_id=$StarTtime&call_id=$MDnextCID&queue=$VDcampaign_id&agent=Agent/$user&verb=COMPLETEAGENT&data1=$CLstage&data2=$length_in_sec&data3=$VDqueue_position$data4SS";
							if (preg_match("/\?/",$queuemetrics_socket_url))
								{$socket_send_data_begin='&';}
							### send queue_log data to the queuemetrics_socket_url ###
							if ($DB > 0) {echo "$queuemetrics_socket_url$socket_send_data_begin$socket_send_data<BR>\n";}
							$SCUfile = file("$queuemetrics_socket_url$socket_send_data_begin$socket_send_data");
							if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}
							}
						}
					}
				}
			}
		}

	#  . '|' . $lead_id . '|' . $agent_log_id . '|' . $alt_dial . '|' . $affected_rowsVL . '|' . $stmtVQ
	echo $VDstop_rec_after_each_call . '|' . $extension . '|' . $conf_silent_prefix . '|' . $conf_exten . '|' . $user_abb . "|\n";

	##### if VICIDiaL call and hangup_after_each_call activated, find all recording 
	##### channels and hang them up while entering info into recording_log and 
	##### returning filename/recordingID
	if ($VDstop_rec_after_each_call == 1)
		{
		$local_DEF = 'Local/';
		$local_AMP = '@';
		$total_rec=0;
		$total_hangup=0;
		$loop_count=0;
		$stmt="SELECT channel FROM live_sip_channels where server_ip = '$server_ip' and extension = '$conf_exten' order by channel desc;";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00095',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$rec_list = mysqli_num_rows($rslt);}
			while ($rec_list>$loop_count)
			{
			$row=mysqli_fetch_row($rslt);
			if (preg_match("/Local\/$conf_silent_prefix$conf_exten\@/i",$row[0]))
				{
				$rec_channels[$total_rec] = "$row[0]";
				$total_rec++;
				}
			else
				{
		#		if (preg_match("/$agentchannel/i",$row[0]))
				if ( ($agentchannel == "$row[0]") or (preg_match('/ASTblind/',$row[0])) )
					{
					$donothing=1;
					}
				else
					{
					$hangup_channels[$total_hangup] = "$row[0]";
					$total_hangup++;
					}
				}
			if ($format=='debug') {echo "\n<!-- $row[0] -->";}
			$loop_count++; 
			}

		$loop_count=0;
		$stmt="SELECT channel FROM live_channels where server_ip = '$server_ip' and extension = '$conf_exten' order by channel desc;";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00548',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$rec_list = mysqli_num_rows($rslt);}
			while ($rec_list>$loop_count)
			{
			$row=mysqli_fetch_row($rslt);
			if (preg_match("/Local\/$conf_silent_prefix$conf_exten\@/i",$row[0]))
				{
				$rec_channels[$total_rec] = "$row[0]";
				$total_rec++;
				}
			else
				{
		#		if (preg_match("/$agentchannel/i",$row[0]))
				if ( ($agentchannel == "$row[0]") or (preg_match('/ASTblind/',$row[0])) )
					{
					$donothing=1;
					}
				else
					{
					$hangup_channels[$total_hangup] = "$row[0]";
					$total_hangup++;
					}
				}
			if ($format=='debug') {echo "\n<!-- $row[0] -->";}
			$loop_count++; 
			}


		### if a conference call or 3way call was attempted, then hangup all channels except for the agentchannel
		if ( ( ($conf_dialed > 0) or ($hangup_all_non_reserved > 0) ) and ($leaving_threeway < 1) and ($blind_transfer < 1) )
			{
			$loop_count=0;
			while($loop_count < $total_hangup)
				{
				if (strlen($hangup_channels[$loop_count])>5)
					{
					$variable = "Variable: ctuserserverconfleadphone=$loop_count$US$user$US$server_ip$US$conf_exten$US$lead_id$US$phone_number";

					$stmt="INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Hangup','CH12346$StarTtime$loop_count','Channel: $hangup_channels[$loop_count]','$variable','','','','','','','','');";
						if ($format=='debug') {echo "\n<!-- $stmt -->";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00096',$user,$server_ip,$session_name,$one_mysql_log);}
					}
				$loop_count++;
				}
			}

		$total_recFN=0;
		$loop_count=0;
		$filename=$MT;		# not necessary : and cmd_line_f LIKE \"%_$user_abb\"
		$stmt="SELECT cmd_line_f FROM vicidial_manager where server_ip='$server_ip' and action='Originate' and cmd_line_b = 'Channel: $local_DEF$conf_silent_prefix$conf_exten$local_AMP$ext_context' order by entry_date desc limit $total_rec;";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00097',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$recFN_list = mysqli_num_rows($rslt);}
			while ($recFN_list>$loop_count)
			{
			$row=mysqli_fetch_row($rslt);
			$filename[$total_recFN] = preg_replace("/Callerid: /i","",$row[0]);
			if ($format=='debug') {echo "\n<!-- $row[0] -->";}
			$total_recFN++;
			$loop_count++; 
			}

		$loop_count=0;
		while($loop_count < $total_rec)
			{
			if (strlen($rec_channels[$loop_count])>5)
				{
				$stmt="INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Hangup','RH12345$StarTtime$loop_count','Channel: $rec_channels[$loop_count]','','','','','','','','','');";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00098',$user,$server_ip,$session_name,$one_mysql_log);}

				echo "REC_STOP|$rec_channels[$loop_count]|$filename[$loop_count]|";
				if (strlen($filename[$loop_count])>2)
					{
					$stmt="SELECT recording_id,start_epoch,vicidial_id,lead_id FROM recording_log where filename='$filename[$loop_count]' order by start_epoch desc;";
						if ($format=='debug') {echo "\n<!-- $stmt -->";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00099',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($rslt) {$fn_count = mysqli_num_rows($rslt);}
					if ($fn_count)
						{
						$row=mysqli_fetch_row($rslt);
						$recording_id = $row[0];
						$start_time =	$row[1];
						$vicidial_id =	$row[2];
						$RClead_id =	$row[3];

						if ( (strlen($RClead_id)<1) or ($RClead_id < 1) or ($RClead_id=='NULL') )
							{$lidSQL = ",lead_id='$lead_id'";}
						if (strlen($vicidial_id)<1) 
							{$vidSQL = ",vicidial_id='$VDvicidial_id'";}
						else
							{
							if ( (preg_match('/\./',$vicidial_id)) and ($VLA_inOUT == 'INBOUND') )
								{
								if (!preg_match('/\./',$VDvicidial_id))
									{$vidSQL = ",vicidial_id='$VDvicidial_id'";}

								if ($WeBRooTWritablE > 0)
									{
									$fp = fopen ("./vicidial_debug.txt", "a");
									fwrite ($fp, "$NOW_TIME|INBND_LOG_3|$uniqueid|$lead_id|$user|$inOUT|$VLA_inOUT|$length_in_sec|$VDterm_reason|$VDvicidial_id|$vicidial_id|$start_epoch|$recording_id|\n");
									fclose($fp);
									}
								}
							}
						$length_in_sec = ($StarTtime - $start_time);
						$length_in_min = ($length_in_sec / 60);
						$length_in_min = sprintf("%8.2f", $length_in_min);

						$stmt="UPDATE recording_log set end_time='$NOW_TIME',end_epoch='$StarTtime',length_in_sec=$length_in_sec,length_in_min='$length_in_min' $vidSQL $lidSQL where filename='$filename[$loop_count]' and end_epoch is NULL order by start_epoch desc;";
							if ($format=='debug') {echo "\n<!-- $stmt -->";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00100',$user,$server_ip,$session_name,$one_mysql_log);}

						echo "$recording_id|$length_in_min|";

			#			$fp = fopen ("./recording_debug_$NOW_DATE$txt", "a");
			#			fwrite ($fp, "$NOW_TIME|RECORD_LOG|$filename[$loop_count]|$uniqueid|$lead_id|$user|$inOUT|$VLA_inOUT|$length_in_sec|$VDterm_reason|$VDvicidial_id|$VDvicidial_id|$vicidial_id|$start_epoch|$recording_id|$VDIDselect|\n");
			#			fclose($fp);
						}
					else {echo "||";}
					}
				else {echo "||";}
				echo "\n";
				}
			$loop_count++;
			}
		}

	if ($log_no_enter > 0)
		{
		$fp = fopen ("./vicidial_debug.txt", "a");
		fwrite ($fp, "$NOW_TIME|DIAL_LOG_1N|$uniqueid|$lead_id|$user|$inOUT|$VLA_inOUT|$start_epoch|$phone_number|$MDnextCID|$agentchannel|$loop_count|$total_rec|$total_hangup|$VDstop_rec_after_each_call\n");
		fclose($fp);

		exit;
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		}

	$talk_sec=0;
	$talk_epochSQL='';
	$dead_secSQL='';
	$lead_id_commentsSQL='';
	$StarTtime = date("U");
	$stmt = "SELECT talk_epoch,talk_sec,wait_sec,wait_epoch,lead_id,comments,dead_epoch from vicidial_agent_log where agent_log_id='$agent_log_id';";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00101',$user,$server_ip,$session_name,$one_mysql_log);}
	$VDpr_ct = mysqli_num_rows($rslt);
	if ($VDpr_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		if ( (preg_match("/NULL/i",$row[0])) or ($row[0] < 1000) )
			{
			$talk_epochSQL=",talk_epoch='$StarTtime'";
			$row[0]=$row[3];
			}
		if ( (!preg_match("/NULL/i",$row[6])) and ($row[6] > 1000) )
			{
			$dead_sec = ($StarTtime - $row[6]);
			if ($dead_sec < 0) {$dead_sec=0;}
			$dead_secSQL=",dead_sec='$dead_sec'";
			}
		$talk_sec = (($StarTtime - $row[0]) + $row[1]);
		if ( ( ($auto_dial_level < 1) or (preg_match('/INBOUND_MAN/',$dial_method)) ) and (preg_match('/^M/',$MDnextCID)) )
			{
			if ( (preg_match("/NULL/i",$row[5])) or (strlen($row[5]) < 1) )
				{
				$lead_id_commentsSQL .= ",comments='MANUAL'";
				}
			if ( (preg_match("/NULL/i",$row[4])) or ($row[4] < 1) or (strlen($row[4]) < 1) )
				{
				$lead_id_commentsSQL .= ",lead_id='$lead_id'";
				}
			}
		if ( ( ($VLA_inOUT == 'CHAT') or ($VLA_inOUT == 'EMAIL') or ($VLA_inOUT == 'INBOUND') ) and ( (preg_match("/NULL/i",$row[5])) or (strlen($row[5]) < 1) ) )
			{
			$lead_id_commentsSQL .= ",comments='$VLA_inOUT'";
			}
		}
	$stmt="UPDATE vicidial_agent_log set talk_sec='$talk_sec',dispo_epoch='$StarTtime',uniqueid='$uniqueid' $talk_epochSQL $dead_secSQL $lead_id_commentsSQL where agent_log_id='$agent_log_id';";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00102',$user,$server_ip,$session_name,$one_mysql_log);}

	### update vicidial_carrier_log to match uniqueIDs
	$beginUNIQUEID = preg_replace("/\..*/","",$uniqueid);
	$stmt="UPDATE vicidial_carrier_log set uniqueid='$uniqueid' where lead_id='$lead_id' and uniqueid LIKE \"$beginUNIQUEID%\";";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00299',$user,$server_ip,$session_name,$one_mysql_log);}

	### if queuemetrics_dispo_pause dispo tag is enabled, log it here
	if ( ($enable_queuemetrics_logging > 0) and (strlen($queuemetrics_dispo_pause) > 0) )
		{
		$pause_typeSQL='';
		if ($queuemetrics_pause_type > 0)
			{$pause_typeSQL=",data5='AGENT'";}

		$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MDnextCID',queue='NONE',agent='Agent/$user',verb='PAUSEREASON',serverid='$queuemetrics_log_id',data1='$queuemetrics_dispo_pause'$pause_typeSQL;";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $linkB);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00364',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($linkB);
		}
	}
}


################################################################################
### VDADREcheckINCOMING - for auto-dial VICIDiaL dialing this will recheck for
###                       calls to see if the channel has updated
################################################################################
if ($ACTION == 'VDADREcheckINCOMING')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($campaign)<1) || (strlen($server_ip)<1) || (strlen($lead_id)<1) )
		{
		$channel_live=0;
		echo "0\n";
		echo _QXZ("Campaign %1s is not valid",0,'',$campaign)."\n";
		echo _QXZ("lead_id %1s is not valid",0,'',$lead_id)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		### grab the call and lead info from the vicidial_live_agents table
		$stmt = "SELECT lead_id,uniqueid,callerid,channel,call_server_ip FROM vicidial_live_agents where server_ip = '$server_ip' and user='$user' and campaign_id='$campaign' and lead_id='$lead_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00103',$user,$server_ip,$session_name,$one_mysql_log);}
		$queue_leadID_ct = mysqli_num_rows($rslt);

		if ($queue_leadID_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$lead_id	=$row[0];
			$uniqueid	=$row[1];
			$callerid	=$row[2];
			$channel	=$row[3];
			$call_server_ip	=$row[4];
				if (strlen($call_server_ip)<7) {$call_server_ip = $server_ip;}
			echo "1\n" . $lead_id . '|' . $uniqueid . '|' . $callerid . '|' . $channel . '|' . $call_server_ip . "|\n";
			$stage = $callerid . '|' . $channel . '|' . $call_server_ip . '|' . $uniqueid;
			}
		}
	}


################################################################################
### VDADcheckINCOMING - for auto-dial VICIDiaL dialing this will check for calls
###                     in the vicidial_live_agents table in QUEUE status, then
###                     lookup the lead info and pass it back to vicidial.php
################################################################################
if ($ACTION == 'VDADcheckINCOMING')
	{
	$VDCL_ingroup_recording_override = '';
	$VDCL_ingroup_rec_filename = '';
	$Ctype = 'A';
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	$alt_phone_code='';
	$alt_phone_number='';
	$alt_phone_note='';
	$alt_phone_active='';
	$alt_phone_count='';
	$INclosecallid='';
	$INxfercallid='';

	if ( (strlen($campaign)<1) || (strlen($server_ip)<1) )
		{
		$channel_live=0;
		echo "0\n";
		echo _QXZ("Campaign %1s is not valid",0,'',$campaign)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		### grab the call and lead info from the vicidial_live_agents table
		$stmt = "SELECT lead_id,uniqueid,callerid,channel,call_server_ip,comments FROM vicidial_live_agents where server_ip = '$server_ip' and user='$user' and campaign_id='$campaign' and status='QUEUE';";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00104',$user,$server_ip,$session_name,$one_mysql_log);}
		$queue_leadID_ct = mysqli_num_rows($rslt);

		if ($queue_leadID_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$lead_id	=$row[0];
			$uniqueid	=$row[1];
			$callerid	=$row[2];
			$channel	=$row[3];
			$call_server_ip	=$row[4];
			$VLAcomments=$row[5];

				if (strlen($call_server_ip)<7) {$call_server_ip = $server_ip;}
			echo "1\n" . $lead_id . '|' . $uniqueid . '|' . $callerid . '|' . $channel . '|' . $call_server_ip . "|\n";

			##### grab number of calls today in this campaign and increment
			$stmt="SELECT calls_today FROM vicidial_live_agents WHERE user='$user' and campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00105',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vla_cc_ct = mysqli_num_rows($rslt);
			if ($vla_cc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$calls_today =$row[0];
				}
			else
				{$calls_today ='0';}
			$calls_today++;

			### update the agent status to INCALL in vicidial_live_agents
			$stmt = "UPDATE vicidial_live_agents set status='INCALL',last_call_time='$NOW_TIME',calls_today='$calls_today',external_hangup=0,external_status='',external_pause='',external_dial='',last_state_change='$NOW_TIME',pause_code='',preview_lead_id='0' where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00106',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9106$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			### update vicidial_inbound_callback_queue record to SENT if one exists in SENDING state for this lead_id
			$stmt = "UPDATE vicidial_inbound_callback_queue set icbq_status='SENT' where lead_id='$lead_id' and icbq_status='SENDING' order by icbq_date limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00709',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmt = "UPDATE vicidial_campaign_agents set calls_today='$calls_today' where user='$user' and campaign_id='$campaign';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00107',$user,$server_ip,$session_name,$one_mysql_log);}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00108',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$entry_date		= trim("$row[1]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$phone_code		= trim("$row[10]");
				$phone_number	= trim("$row[11]");
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase	= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
				if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}
			if ($qc_features_active > 0)
				{
				//Added by Poundteam for Audited Comments
				##### if list has audited comments, grab the audited comments
				require_once('audit_comments.php');
				$ACcount =		'';
				$ACcomments =		'';
				$audit_comments_active=audit_comments_active($list_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
				if ($audit_comments_active)
					{
					get_audited_comments($lead_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
					}
				$ACcomments = strip_tags(htmlentities($ACcomments));
				$ACcomments = preg_replace("/\r/i",'',$ACcomments);
				$ACcomments = preg_replace("/\n/i",'!N',$ACcomments);
				//END Added by Poundteam for Audited Comments
				}

			##### if lead is a callback, grab the callback comments
			$CBentry_time =		'';
			$CBcallback_time =	'';
			$CBuser =			'';
			$CBcomments =		'';
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00368',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00369',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or ($dispo == 'CBHOLD') )
				{
				$stmt="SELECT entry_time,callback_time,user,comments FROM vicidial_callbacks where lead_id='$lead_id' order by callback_id desc LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00109',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBentry_time =		trim("$row[0]");
					$CBcallback_time =	trim("$row[1]");
					$CBuser =			trim("$row[2]");
					$CBcomments =		trim("$row[3]");
					}
				}
			$stmt="SELECT owner_populate FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00444',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$camp_op_ct = mysqli_num_rows($rslt);
			if ($camp_op_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$owner_populate =				$row[0];
				}
			$ownerSQL='';
			if ( ($owner_populate=='ENABLED') and ( (strlen($owner) < 1) or ($owner=='NULL') ) )
				{
				$ownerSQL = ",owner='$user'";
				$owner=$user;
				}

			### update the lead status to INCALL
			$stmt = "UPDATE vicidial_list set status='INCALL', user='$user' $ownerSQL where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00110',$user,$server_ip,$session_name,$one_mysql_log);}

			### gather custom_call_id from vicidial_log_extended table
			$custom_call_id='';
			$stmt="SELECT custom_call_id FROM vicidial_log_extended where uniqueid='$uniqueid';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00333',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vle_record_ct = mysqli_num_rows($rslt);
			if ($vle_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_call_id =		$row[0];
				}

			### gather user_group and full_name of agent
			$user_group='';
			$stmt="SELECT user_group,full_name FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00111',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				$fullname =			$row[1];
				}

			$stmt = "SELECT campaign_id,phone_number,alt_dial,call_type from vicidial_auto_calls where callerid = '$callerid' order by call_time desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00112',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDAC_cid_ct = mysqli_num_rows($rslt);
			if ($VDAC_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDADchannel_group	=$row[0];
				$dialed_number		=$row[1];
				$dialed_label		=$row[2];
				$call_type			=$row[3];
				if ( ($dialed_number != $phone_number) and (strlen($dialed_label) < 3) )
					{
					if ($dialed_number != $alt_phone)
						{
						if ($dialed_number != $address3)
							{
							$dialed_label = 'X1';
							$stmt = "SELECT alt_phone_count from vicidial_list_alt_phones where lead_id='$lead_id' and phone_number = '$dialed_number' order by alt_phone_count limit 1;";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00248',$user,$server_ip,$session_name,$one_mysql_log);}
							$VDAP_cid_ct = mysqli_num_rows($rslt);
							if ($VDAP_cid_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$Xalt_phone_count	=$row[0];

								$stmt = "SELECT count(*) from vicidial_list_alt_phones where lead_id='$lead_id';";
								if ($DB) {echo "$stmt\n";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00249',$user,$server_ip,$session_name,$one_mysql_log);}
								$VDAPct_cid_ct = mysqli_num_rows($rslt);
								if ($VDAPct_cid_ct > 0)
									{
									$row=mysqli_fetch_row($rslt);
									$COUNTalt_phone_count	=$row[0];

									if ($COUNTalt_phone_count <= $Xalt_phone_count)
										{$dialed_label = 'XLAST';}
									else
										{$dialed_label = "X$Xalt_phone_count";}
									}

								}
							}
						else
							{$dialed_label = 'ADDR3';}
						}
					else
						{$dialed_label = 'ALT';}
					}
				}
			else
				{
				$dialed_number = $phone_number;
				$dialed_label = 'MAIN';
				if (preg_match('/^M|^V/',$callerid))
					{
					$call_type = 'OUT';
					$VDADchannel_group = $campaign;
					}
				else
					{
					$call_type = 'IN';
					$stmt = "SELECT campaign_id,closecallid,xfercallid from vicidial_closer_log where lead_id = '$lead_id' order by closecallid desc limit 1;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00183',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDCL_mvac_ct = mysqli_num_rows($rslt);
					if ($VDCL_mvac_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDADchannel_group =	$row[0];
						$INclosecallid =		$row[1];
						$INxfercallid =			$row[2];
						}
					}
				if ($WeBRooTWritablE > 0)
					{
					$fp = fopen ("./vicidial_debug.txt", "a");
					fwrite ($fp, "$NOW_TIME|INBND|$callerid|$user|$user_group|$list_id|$lead_id|$phone_number|$uniqueid|$VDADchannel_group|$call_type|$dialed_number|$dialed_label|$INclosecallid|$INxfercallid|\n");
					fclose($fp);
					}
				}

			if ( ($call_type=='OUT') or ($call_type=='OUTBALANCE') )
				{
				$stmt = "UPDATE vicidial_log set user='$user', comments='AUTO', list_id='$list_id', status='INCALL', user_group='$user_group' where lead_id='$lead_id' and uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00113',$user,$server_ip,$session_name,$one_mysql_log);}

				$script_recording_delay=0;
				##### grab number of calls today in this campaign and increment
				$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_campaigns vc WHERE campaign_id='$campaign' and vs.script_id=vc.campaign_script and script_text LIKE \"%--A--recording_%\";";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00261',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$vs_vc_ct = mysqli_num_rows($rslt);
				if ($vs_vc_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$script_recording_delay = $row[0];
					}

				$stmt = "SELECT campaign_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_xfer_group,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action,timer_action_message,timer_action_seconds,timer_action_destination from vicidial_campaigns where campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00114',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cid_ct = mysqli_num_rows($rslt);
				if ($VDIG_cid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_campaign_script =			$row[0];
					$VDCL_get_call_launch =			$row[1];
					$VDCL_xferconf_a_dtmf =			$row[2];
					$VDCL_xferconf_a_number =		$row[3];
					$VDCL_xferconf_b_dtmf =			$row[4];
					$VDCL_xferconf_b_number =		$row[5];
					$VDCL_default_xfer_group =		$row[6];
					if (strlen($VDCL_default_xfer_group)<2) {$VDCL_default_xfer_group='X';}
					$VDCL_start_call_url =			$row[7];
					$VDCL_dispo_call_url =			$row[8];
					$VDCL_xferconf_c_number =		$row[9];
					$VDCL_xferconf_d_number =		$row[10];
					$VDCL_xferconf_e_number =		$row[11];
					$VDCL_timer_action =			$row[12];
					$VDCL_timer_action_message =	$row[13];
					$VDCL_timer_action_seconds =	$row[14];
					$VDCL_timer_action_destination =	$row[15];
					}

				$VDCL_ingroup_script_color='';
				if ( (strlen($VDCL_campaign_script)>1) and ($VDCL_campaign_script != 'NONE') )
					{
					$stmt = "SELECT script_color from vicidial_scripts where script_id='$VDCL_campaign_script';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00628',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_scrptcolor_ct = mysqli_num_rows($rslt);
					if ($VDIG_scrptcolor_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_ingroup_script_color	= $row[0];
						}
					}

				$VDCL_group_web='';
				$VDCL_group_name='';
				### Check for List ID override settings
				if (strlen($list_id)>0)
					{
					$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number,web_form_address,web_form_address_two,list_name,web_form_address_three,list_description,status_group_id,default_xfer_group from vicidial_lists where list_id='$list_id';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00281',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_xferOR_ct = mysqli_num_rows($rslt);
					if ($VDIG_xferOR_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						if (strlen($row[0]) > 0)
							{$VDCL_xferconf_a_number =	$row[0];}
						if (strlen($row[1]) > 0)
							{$VDCL_xferconf_b_number =	$row[1];}
						if (strlen($row[2]) > 0)
							{$VDCL_xferconf_c_number =	$row[2];}
						if (strlen($row[3]) > 0)
							{$VDCL_xferconf_d_number =	$row[3];}
						if (strlen($row[4]) > 0)
							{$VDCL_xferconf_e_number =	$row[4];}
						if (strlen($row[5]) > 5)
							{$VDCL_group_web =			$row[5];}
						if (strlen($row[6]) > 5)
							{$VDCL_group_web_two =		$row[6];}
						if (strlen($row[7]) > 0)
							{$list_name =				$row[7];}
						if (strlen($row[8]) > 5)
							{$VDCL_group_web_three =	$row[8];}
						$list_description =				$row[9];
						$status_group_gather_data = status_group_gather($row[10],'LIST');
						if ( (strlen($row[11]) > 0) and (!preg_match("/---NONE---/",$row[11])) )
							{$VDCL_default_xfer_group =	$row[11];}
						}
					}

				echo "$VDCL_group_web|$VDCL_group_name||||$VDCL_campaign_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|X|X||||$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number||||$VDCL_timer_action_destination||||||$VDCL_group_web_three|$VDCL_ingroup_script_color|\n|\n";
				
				if (preg_match('/X/',$dialed_label))
					{
					if (preg_match('/LAST/',$dialed_label))
						{
						$stmt = "SELECT phone_code,phone_number,alt_phone_note,active,alt_phone_count FROM vicidial_list_alt_phones where lead_id='$lead_id' order by alt_phone_count desc limit 1;";
						}
					else
						{
						$Talt_dial = preg_replace("/[^0-9]/","",$dialed_label);
						$stmt = "SELECT phone_code,phone_number,alt_phone_note,active,alt_phone_count FROM vicidial_list_alt_phones where lead_id='$lead_id' and alt_phone_count='$Talt_dial';";										
						}

					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00116',$user,$server_ip,$session_name,$one_mysql_log);}
					$VLAP_ct = mysqli_num_rows($rslt);
					if ($VLAP_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$alt_phone_code	=	$row[0];
						$alt_phone_number = $row[1];
						$alt_phone_note =	$row[2];
						$alt_phone_active = $row[3];
						$alt_phone_count =	$row[4];
						}
					}
				}
			else
				{
				### update the vicidial_closer_log user to INCALL
				$stmt = "UPDATE vicidial_closer_log set user='$user', comments='AUTO', list_id='$list_id', status='INCALL', user_group='$user_group' where lead_id='$lead_id' order by closecallid desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00117',$user,$server_ip,$session_name,$one_mysql_log);}

				if (strlen($closecallid)<1)
					{
					$stmt = "SELECT closecallid,xfercallid from vicidial_closer_log where lead_id='$lead_id' and user='$user' and list_id='$list_id' order by closecallid desc limit 1;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00336',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDCL_mvac_ct = mysqli_num_rows($rslt);
					if ($VDCL_mvac_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$INclosecallid =		$row[0];
						$INxfercallid =			$row[1];
						}
					}

				$stmt = "SELECT count(*) from vicidial_log where lead_id='$lead_id' and uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00118',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDL_cid_ct = mysqli_num_rows($rslt);
				if ($VDL_cid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_front_VDlog	=$row[0];
					}

				$script_recording_delay=0;
				##### find if script contains recording fields
				$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_inbound_groups vig WHERE group_id='$VDADchannel_group' and vs.script_id=vig.ingroup_script and script_text LIKE \"%--A--recording_%\";";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00262',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$vs_vc_ct = mysqli_num_rows($rslt);
				if ($vs_vc_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$script_recording_delay = $row[0];
					}

				$stmt = "SELECT group_name,group_color,web_form_address,fronter_display,ingroup_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_xfer_group,ingroup_recording_override,ingroup_rec_filename,default_group_alias,web_form_address_two,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,uniqueid_status_display,uniqueid_status_prefix,timer_action_destination,web_form_address_three,status_group_id,inbound_survey from vicidial_inbound_groups where group_id='$VDADchannel_group';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00119',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cid_ct = mysqli_num_rows($rslt);
				if ($VDIG_cid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_group_name =					$row[0];
					$VDCL_group_color =					$row[1];
					$VDCL_group_web	=					stripslashes($row[2]);
					$VDCL_fronter_display =				$row[3];
					$VDCL_ingroup_script =				$row[4];
					$VDCL_get_call_launch =				$row[5];
					$VDCL_xferconf_a_dtmf =				$row[6];
					$VDCL_xferconf_a_number =			$row[7];
					$VDCL_xferconf_b_dtmf =				$row[8];
					$VDCL_xferconf_b_number =			$row[9];
					$VDCL_default_xfer_group =			$row[10];
					$VDCL_ingroup_recording_override =	$row[11];
					$VDCL_ingroup_rec_filename =		$row[12];
					$VDCL_default_group_alias =			$row[13];
					$VDCL_group_web_two =		stripslashes($row[14]);
					$VDCL_timer_action =				$row[15];
					$VDCL_timer_action_message =		$row[16];
					$VDCL_timer_action_seconds =		$row[17];
					$VDCL_start_call_url =				$row[18];
					$VDCL_dispo_call_url =				$row[19];
					$VDCL_xferconf_c_number =			$row[20];
					$VDCL_xferconf_d_number =			$row[21];
					$VDCL_xferconf_e_number =			$row[22];
					$VDCL_uniqueid_status_display =		$row[23];
					$VDCL_uniqueid_status_prefix =		$row[24];
					$VDCL_timer_action_destination =	$row[25];
					$VDCL_group_web_three =		stripslashes($row[26]);
					$VDCL_inbound_survey =				$row[28];

					$status_group_gather_data = status_group_gather($row[27],'INGROUP');

					$stmt = "SELECT campaign_script,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_group_alias,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action_destination,default_xfer_group from vicidial_campaigns where campaign_id='$campaign';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00181',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidOR_ct = mysqli_num_rows($rslt);
					if ($VDIG_cidOR_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						if (strlen($VDCL_xferconf_a_dtmf) < 1)
							{$VDCL_xferconf_a_dtmf =	$row[1];}
						if (strlen($VDCL_xferconf_a_number) < 1)
							{$VDCL_xferconf_a_number =	$row[2];}
						if (strlen($VDCL_xferconf_b_dtmf) < 1)
							{$VDCL_xferconf_b_dtmf =	$row[3];}
						if (strlen($VDCL_xferconf_b_number) < 1)
							{$VDCL_xferconf_b_number =	$row[4];}
						if (strlen($VDCL_default_group_alias) < 1)
							{$VDCL_default_group_alias =	$row[5];}
						if (strlen($VDCL_timer_action) < 1)
							{$VDCL_timer_action =	$row[6];}
						if (strlen($VDCL_timer_action_message) < 1)
							{$VDCL_timer_action_message =	$row[7];}
						if (strlen($VDCL_timer_action_seconds) < 1)
							{$VDCL_timer_action_seconds =	$row[8];}
						if (strlen($VDCL_start_call_url) < 1)
							{$VDCL_start_call_url =	$row[9];}
						if (strlen($VDCL_dispo_call_url) < 1)
							{$VDCL_dispo_call_url =	$row[10];}
						if (strlen($VDCL_xferconf_c_number) < 1)
							{$VDCL_xferconf_c_number =	$row[11];}
						if (strlen($VDCL_xferconf_d_number) < 1)
							{$VDCL_xferconf_d_number =	$row[12];}
						if (strlen($VDCL_xferconf_e_number) < 1)
							{$VDCL_xferconf_e_number =	$row[13];}
						if (strlen($VDCL_timer_action_destination) < 1)
							{$VDCL_timer_action_destination =	$row[14];}
						if ( (strlen($row[15]) > 0) and (!preg_match("/---NONE---/",$row[15])) )
							{$VDCL_default_xfer_group =	$row[15];}

						if ( ( (preg_match('/NONE/',$VDCL_ingroup_script)) and (strlen($VDCL_ingroup_script) < 5) ) or (strlen($VDCL_ingroup_script) < 1) )
							{
							$VDCL_ingroup_script =		$row[0];
							$script_recording_delay=0;
							##### find if script contains recording fields
							$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_campaigns vc WHERE campaign_id='$campaign' and vs.script_id=vc.campaign_script and script_text LIKE \"%--A--recording_%\";";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00263',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$vs_vc_ct = mysqli_num_rows($rslt);
							if ($vs_vc_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$script_recording_delay = $row[0];
								}
							}
						}

					$stmt = "SELECT group_web_vars from vicidial_inbound_group_agents where group_id='$VDADchannel_group' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00188',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidgwv_ct = mysqli_num_rows($rslt);
					if ($VDIG_cidgwv_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_group_web_vars =	$row[0];
						}

					if (strlen($VDCL_group_web_vars) < 1)
						{
						$stmt = "SELECT group_web_vars from vicidial_campaign_agents where campaign_id='$campaign' and user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00189',$user,$server_ip,$session_name,$one_mysql_log);}
						$VDIG_cidogwv = mysqli_num_rows($rslt);
						if ($VDIG_cidogwv > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$VDCL_group_web_vars =	$row[0];
							}
						}

					### BEGIN check if ask post-call survery is enabled and caller agreed to participate
					$VDCL_survey_participate='N';
					if ($VDCL_inbound_survey == 'ENABLED')
						{
						$stmt = "SELECT participate from vicidial_inbound_survey_log where campaign_id='$VDADchannel_group' and lead_id='$lead_id' and uniqueid='$uniqueid' order by call_date desc limit 1;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00692',$user,$server_ip,$session_name,$one_mysql_log);}
						$VDIG_visl_ct = mysqli_num_rows($rslt);
						if ($VDIG_visl_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$VDCL_survey_participate	=		$row[0];
							}
						}
					### END check if ask post-call survery is enabled and caller agreed to participate

					### update the comments in vicidial_live_agents record
					$stmt = "UPDATE vicidial_live_agents set comments='INBOUND',last_inbound_call_time='$NOW_TIME' where user='$user' and server_ip='$server_ip';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00120',$user,$server_ip,$session_name,$one_mysql_log);}

					$Ctype = 'I';
					}
				else
					{
					$stmt = "SELECT campaign_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_group_alias,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action_destination from vicidial_campaigns where campaign_id='$VDADchannel_group';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00121',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cid_ct = mysqli_num_rows($rslt);
					if ($VDIG_cid_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_ingroup_script	=		$row[0];
						$VDCL_get_call_launch	=		$row[1];
						$VDCL_xferconf_a_dtmf	=		$row[2];
						$VDCL_xferconf_a_number	=		$row[3];
						$VDCL_xferconf_b_dtmf	=		$row[4];
						$VDCL_xferconf_b_number	=		$row[5];
						$VDCL_default_group_alias =		$row[6];
						$VDCL_timer_action = 			$row[7];
						$VDCL_timer_action_message = 	$row[8];
						$VDCL_timer_action_seconds = 	$row[9];
						$VDCL_start_call_url =			$row[10];
						$VDCL_dispo_call_url =			$row[11];
						$VDCL_xferconf_c_number =		$row[12];
						$VDCL_xferconf_d_number =		$row[13];
						$VDCL_xferconf_e_number =		$row[14];
						$VDCL_timer_action_destination = $row[15];
						}

					$script_recording_delay=0;
					##### find if script contains recording fields
					$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_campaigns vc WHERE campaign_id='$VDADchannel_group' and vs.script_id=vc.campaign_script and script_text LIKE \"%--A--recording_%\";";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00264',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vs_vc_ct = mysqli_num_rows($rslt);
					if ($vs_vc_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$script_recording_delay = $row[0];
						}

					$stmt = "SELECT group_web_vars from vicidial_campaign_agents where campaign_id='$VDADchannel_group' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00190',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidogwv = mysqli_num_rows($rslt);
					if ($VDIG_cidogwv > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_group_web_vars =	$row[0];
						}
					}

				$VDCL_caller_id_number='';
				if (strlen($VDCL_default_group_alias)>1)
					{
					$stmt = "SELECT caller_id_number from groups_alias where group_alias_id='$VDCL_default_group_alias';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00187',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidnum_ct = mysqli_num_rows($rslt);
					if ($VDIG_cidnum_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_caller_id_number	= $row[0];
						}
					}

				$VDCL_ingroup_script_color='';
				if ( (strlen($VDCL_ingroup_script)>1) and ($VDCL_ingroup_script != 'NONE') )
					{
					$stmt = "SELECT script_color from vicidial_scripts where script_id='$VDCL_ingroup_script';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00629',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_scrptcolor_ct = mysqli_num_rows($rslt);
					if ($VDIG_scrptcolor_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_ingroup_script_color	= $row[0];
						}
					}

				### Check for List ID override settings
				if (strlen($list_id)>0)
					{
					$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number,web_form_address,web_form_address_two,list_name,web_form_address_three,list_description,status_group_id from vicidial_lists where list_id='$list_id';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00282',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidOR_ct = mysqli_num_rows($rslt);
					if ($VDIG_cidOR_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						if (strlen($row[0]) > 0)
							{$VDCL_xferconf_a_number =	$row[0];}
						if (strlen($row[1]) > 0)
							{$VDCL_xferconf_b_number =	$row[1];}
						if (strlen($row[2]) > 0)
							{$VDCL_xferconf_c_number =	$row[2];}
						if (strlen($row[3]) > 0)
							{$VDCL_xferconf_d_number =	$row[3];}
						if (strlen($row[4]) > 0)
							{$VDCL_xferconf_e_number =	$row[4];}
						if (strlen($row[5]) > 5)
							{$VDCL_group_web =			$row[5];}
						if (strlen($row[6]) > 5)
							{$VDCL_group_web_two =		$row[6];}
						if (strlen($row[7]) > 0)
							{$list_name =				$row[7];}
						if (strlen($row[8]) > 5)
							{$VDCL_group_web_three =	$row[8];}
						$list_description =				$row[9];
						if (strlen($status_group_gather_data)<5)
							{
							$status_group_gather_data = status_group_gather($row[10],'LIST');
							}
						}
					}

				$DID_id='';
				$DID_extension='';
				$DID_pattern='';
				$DID_description='';

				$stmt = "SELECT did_id,extension from vicidial_did_log where uniqueid='$uniqueid' and ( (caller_id_number='$phone_number') or (caller_id_number LIKE \"%$phone_number\") ) order by call_date desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00337',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIDL_ct = mysqli_num_rows($rslt);
				if ($VDIDL_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$DID_id	=			$row[0];
					$DID_extension	=	$row[1];

					$stmt = "SELECT did_pattern,did_description,custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_inbound_dids where did_id='$DID_id' limit 1;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00338',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIDL_ct = mysqli_num_rows($rslt);
					if ($VDIDL_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$DID_pattern =		$row[0];
						$DID_description =	$row[1];
						$DID_custom_one =	$row[2];
						$DID_custom_two=	$row[3];
						$DID_custom_three=	$row[4];
						$DID_custom_four=	$row[5];
						$DID_custom_five=	$row[6];
						}
					}

				### if web form is set then send on to vicidial.php for override of WEB_FORM address
				if ( (strlen($VDCL_group_web)>5) or (strlen($VDCL_group_name)>0) ) {echo "$VDCL_group_web|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|$VDCL_inbound_survey|$VDCL_survey_participate|\n";}
				else {echo "X|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|$VDCL_inbound_survey|$VDCL_survey_participate|\n";}

				$stmt = "SELECT full_name from vicidial_users where user='$tsr';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00122',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDU_cid_ct = mysqli_num_rows($rslt);
				if ($VDU_cid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$fronter_full_name		= $row[0];
					echo $fronter_full_name . '|' . $tsr . "\n";
					}
				else {echo '|' . $tsr . "\n";}
				}

			##### find if script contains recording fields
			$stmt="SELECT count(*) FROM vicidial_lists WHERE list_id='$list_id' and agent_script_override!='' and agent_script_override IS NOT NULL and agent_script_override!='NONE';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00265',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vls_vc_ct = mysqli_num_rows($rslt);
			if ($vls_vc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					$script_recording_delay=0;
					##### find if script contains recording fields
					$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_lists vls WHERE list_id='$list_id' and vs.script_id=vls.agent_script_override and script_text LIKE \"%--A--recording_%\";";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00266',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vs_vc_ct = mysqli_num_rows($rslt);
					if ($vs_vc_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$script_recording_delay = $row[0];
						}
					}
				}

			$custom_field_names='|';
			$custom_field_names_SQL='';
			$custom_field_values='----------';
			$custom_field_types='|';
			### find the names of all custom fields, if any
			$stmt = "SELECT field_label,field_type FROM vicidial_lists_fields where list_id='$entry_list_id' and field_type NOT IN('SCRIPT','DISPLAY') and field_label NOT IN('entry_date','vendor_lead_code','source_id','list_id','gmt_offset_now','called_since_last_reset','phone_code','phone_number','title','first_name','middle_initial','last_name','address1','address2','address3','city','state','province','postal_code','country_code','gender','date_of_birth','alt_phone','email','security_phrase','comments','called_count','last_local_call_time','rank','owner') and field_label NOT LIKE \"%_DUPLICATE_%\";";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00339',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cffn_ct = mysqli_num_rows($rslt);
			$d=0;
			while ($cffn_ct > $d)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_field_names .=	"$row[0]|";
				$custom_field_names_SQL .=	"$row[0],";
				$custom_field_types .=	"$row[1]|";
				$custom_field_values .=	"----------";
				$d++;
				}
			if ($cffn_ct > 0)
				{
				$custom_field_names_SQL = preg_replace("/.$/i","",$custom_field_names_SQL);
				### find the values of the named custom fields
				$stmt = "SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00340',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cffv_ct = mysqli_num_rows($rslt);
				if ($cffv_ct > 0)
					{
					$custom_field_values='----------';
					$row=mysqli_fetch_row($rslt);
					$d=0;
					while ($cffn_ct > $d)
						{
						$custom_field_values .=	"$row[$d]----------";
						$d++;
						}
					$custom_field_values = preg_replace("/\n/"," ",$custom_field_values);
					$custom_field_values = preg_replace("/\r/","",$custom_field_values);
					}
				}


			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);

			$LeaD_InfO =	$callerid . "\n";
			$LeaD_InfO .=	$lead_id . "\n";
			$LeaD_InfO .=	$dispo . "\n";
			$LeaD_InfO .=	$tsr . "\n";
			$LeaD_InfO .=	$vendor_id . "\n";
			$LeaD_InfO .=	$list_id . "\n";
			$LeaD_InfO .=	$gmt_offset_now . "\n";
			$LeaD_InfO .=	$phone_code . "\n";
			$LeaD_InfO .=	$phone_number . "\n";
			$LeaD_InfO .=	$title . "\n";
			$LeaD_InfO .=	$first_name . "\n";
			$LeaD_InfO .=	$middle_initial . "\n";
			$LeaD_InfO .=	$last_name . "\n";
			$LeaD_InfO .=	$address1 . "\n";
			$LeaD_InfO .=	$address2 . "\n";
			$LeaD_InfO .=	$address3 . "\n";
			$LeaD_InfO .=	$city . "\n";
			$LeaD_InfO .=	$state . "\n";
			$LeaD_InfO .=	$province . "\n";
			$LeaD_InfO .=	$postal_code . "\n";
			$LeaD_InfO .=	$country_code . "\n";
			$LeaD_InfO .=	$gender . "\n";
			$LeaD_InfO .=	$date_of_birth . "\n";
			$LeaD_InfO .=	$alt_phone . "\n";
			$LeaD_InfO .=	$email . "\n";
			$LeaD_InfO .=	$security_phrase . "\n";
			$LeaD_InfO .=	$comments . "\n";
			$LeaD_InfO .=	$called_count . "\n";
			$LeaD_InfO .=	$CBentry_time . "\n";
			$LeaD_InfO .=	$CBcallback_time . "\n";
			$LeaD_InfO .=	$CBuser . "\n";
			$LeaD_InfO .=	$CBcomments . "\n";
			$LeaD_InfO .=	$dialed_number . "\n";
			$LeaD_InfO .=	$dialed_label . "\n";
			$LeaD_InfO .=	$source_id . "\n";
			$LeaD_InfO .=	$alt_phone_code . "\n";
			$LeaD_InfO .=	$alt_phone_number . "\n";
			$LeaD_InfO .=	$alt_phone_note . "\n";
			$LeaD_InfO .=	$alt_phone_active . "\n";
			$LeaD_InfO .=	$alt_phone_count . "\n";
			$LeaD_InfO .=	$rank . "\n";
			$LeaD_InfO .=	$owner . "\n";
			$LeaD_InfO .=	$script_recording_delay . "\n";
			$LeaD_InfO .=	$entry_list_id . "\n";
			$LeaD_InfO .=	$custom_field_names . "\n";
			$LeaD_InfO .=	$custom_field_values . "\n";
			$LeaD_InfO .=	$custom_field_types . "\n";
			$LeaD_InfO .=   $LISTweb_form_address . "\n";
			$LeaD_InfO .=   $LISTweb_form_address_two . "\n";
			$LeaD_InfO .=   $ACcount . "\n";
			$LeaD_InfO .=   $ACcomments . "\n";
			$LeaD_InfO .=   $list_name . "\n";
			$LeaD_InfO .=   $LISTweb_form_address_three . "\n";
			$LeaD_InfO .=	$VDCL_ingroup_script_color . "\n";
			$LeaD_InfO .=	$list_description . "\n";
			$LeaD_InfO .=	$entry_date . "\n";
			$LeaD_InfO .=	$DID_custom_one . "\n";
			$LeaD_InfO .=	$DID_custom_two . "\n";
			$LeaD_InfO .=	$DID_custom_three . "\n";
			$LeaD_InfO .=	$DID_custom_four . "\n";
			$LeaD_InfO .=	$DID_custom_five . "\n";
			$LeaD_InfO .=	$status_group_gather_data . "\n";
			$LeaD_InfO .=	$call_date . "\n";

			echo $LeaD_InfO;


			$wait_sec=0;
			$StarTtime = date("U");
			$stmt = "SELECT wait_epoch,wait_sec from vicidial_agent_log where agent_log_id='$agent_log_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00123',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDpr_ct = mysqli_num_rows($rslt);
			if ($VDpr_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$wait_sec = (($StarTtime - $row[0]) + $row[1]);
				}
			$stmt="UPDATE vicidial_agent_log set wait_sec='$wait_sec',talk_epoch='$StarTtime',lead_id='$lead_id' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00124',$user,$server_ip,$session_name,$one_mysql_log);}

			### If a scheduled callback, change vicidial_callback record to INACTIVE
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00370',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00371',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or (preg_match("/CALLBK|CBHOLD/i", $dispo)) )
				{
				$stmt="UPDATE vicidial_callbacks set status='INACTIVE' where lead_id='$lead_id' and status NOT IN('INACTIVE','DEAD','ARCHIVE');";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00125',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			##### check if system is set to generate logfile for transfers
			$stmt="SELECT enable_agc_xfer_log FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00126',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$enable_agc_xfer_log_ct = mysqli_num_rows($rslt);
			if ($enable_agc_xfer_log_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_agc_xfer_log =$row[0];
				}

			if ( ($WeBRooTWritablE > 0) and ($enable_agc_xfer_log > 0) )
				{
				#	DATETIME|campaign|lead_id|phone_number|user|type
				#	2007-08-22 11:11:11|TESTCAMP|65432|3125551212|1234|A
				$fp = fopen ("./xfer_log.txt", "a");
				fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$phone_number|$user|$Ctype|$callerid|$uniqueid|$province\n");
				fclose($fp);
				}

			### Issue Start Call URL if defined
			if (strlen($VDCL_start_call_url) > 7)
				{
				if (preg_match('/--A--user_custom_/i',$VDCL_start_call_url))
					{
					$stmt = "SELECT custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_users where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00283',$user,$server_ip,$session_name,$one_mysql_log);}
					$VUC_ct = mysqli_num_rows($rslt);
					if ($VUC_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$user_custom_one	=		urlencode(trim($row[0]));
						$user_custom_two	=		urlencode(trim($row[1]));
						$user_custom_three	=		urlencode(trim($row[2]));
						$user_custom_four	=		urlencode(trim($row[3]));
						$user_custom_five	=		urlencode(trim($row[4]));
						}
					}
				$VDCL_start_call_url = preg_replace('/^VAR/','',$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--lead_id--B--/i',urlencode(trim($lead_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--vendor_id--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--vendor_lead_code--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_id--B--/i',urlencode(trim($list_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_name--B--/i',urlencode(trim($list_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_description--B--/i',urlencode(trim($list_description)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--gmt_offset_now--B--/i',urlencode(trim($gmt_offset_now)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_code--B--/i',urlencode(trim($phone_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_number--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--title--B--/i',urlencode(trim($title)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--first_name--B--/i',urlencode(trim($first_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--middle_initial--B--/i',urlencode(trim($middle_initial)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--last_name--B--/i',urlencode(trim($last_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address1--B--/i',urlencode(trim($address1)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address2--B--/i',urlencode(trim($address2)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address3--B--/i',urlencode(trim($address3)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--city--B--/i',urlencode(trim($city)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--state--B--/i',urlencode(trim($state)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--province--B--/i',urlencode(trim($province)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--postal_code--B--/i',urlencode(trim($postal_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--country_code--B--/i',urlencode(trim($country_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--gender--B--/i',urlencode(trim($gender)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--date_of_birth--B--/i',urlencode(trim($date_of_birth)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--alt_phone--B--/i',urlencode(trim($alt_phone)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--email--B--/i',urlencode(trim($email)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--security_phrase--B--/i',urlencode(trim($security_phrase)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--comments--B--/i',urlencode(trim($comments)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user--B--/i',urlencode(trim($user)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--pass--B--/i',urlencode(trim($orig_pass)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--campaign--B--/i',urlencode(trim($campaign)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_login--B--/i',urlencode(trim($phone_login)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--original_phone_login--B--/i',urlencode(trim($original_phone_login)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_pass--B--/i',urlencode(trim($phone_pass)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--fronter--B--/i',urlencode(trim($fronter)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--closer--B--/i',urlencode(trim($closer)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--channel_group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--SQLdate--B--/i',urlencode(trim($SQLdate)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--epoch--B--/i',urlencode(trim($epoch)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--uniqueid--B--/i',urlencode(trim($uniqueid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--customer_zap_channel--B--/i',urlencode(trim($channel)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--customer_server_ip--B--/i',urlencode(trim($call_server_ip)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--SIPexten--B--/i',urlencode(trim($exten)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--session_id--B--/i',urlencode(trim($conf_exten)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--parked_by--B--/i',urlencode(trim($parked_by)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dispo--B--/i',urlencode(trim($dispo)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dialed_number--B--/i',urlencode(trim($dialed_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dialed_label--B--/i',urlencode(trim($dialed_label)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--source_id--B--/i',urlencode(trim($source_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--rank--B--/i',urlencode(trim($rank)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--owner--B--/i',urlencode(trim($owner)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--camp_script--B--/i',urlencode(trim($camp_script)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--in_script--B--/i',urlencode(trim($VDCL_ingroup_script)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--fullname--B--/i',urlencode(trim($fullname)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_one--B--/i',urlencode(trim($user_custom_one)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_two--B--/i',urlencode(trim($user_custom_two)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_three--B--/i',urlencode(trim($user_custom_three)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_four--B--/i',urlencode(trim($user_custom_four)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_five--B--/i',urlencode(trim($user_custom_five)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--talk_time--B--/i',"0",$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--talk_time_min--B--/i',"0",$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--entry_list_id--B--/i',urlencode(trim($entry_list_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_id--B--/i',urlencode(trim($DID_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_extension--B--/i',urlencode(trim($DID_extension)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_pattern--B--/i',urlencode(trim($DID_pattern)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_description--B--/i',urlencode(trim($DID_description)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--closecallid--B--/i',urlencode(trim($INclosecallid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--xfercallid--B--/i',urlencode(trim($INxfercallid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--agent_log_id--B--/i',urlencode(trim($agent_log_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--call_id--B--/i',urlencode(trim($callerid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_group--B--/i',urlencode(trim($user_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--entry_date--B--/i',urlencode(trim($entry_date)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_one--B--/i',urlencode(trim($DID_custom_one)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_two--B--/i',urlencode(trim($DID_custom_two)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_three--B--/i',urlencode(trim($DID_custom_three)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_four--B--/i',urlencode(trim($DID_custom_four)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_five--B--/i',urlencode(trim($DID_custom_five)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--agent_email--B--/i',urlencode(trim($agent_email)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--called_count--B--/i',urlencode(trim($called_count)),$VDCL_start_call_url);

				if (strlen($custom_field_names)>2)
					{
					$custom_field_names = preg_replace("/^\||\|$/",'',$custom_field_names);
					$custom_field_names = preg_replace("/\|/",",",$custom_field_names);
					$custom_field_names_ARY = explode(',',$custom_field_names);
					$custom_field_names_ct = count($custom_field_names_ARY);
					$custom_field_names_SQL = $custom_field_names;

					if (preg_match("/cf_encrypt/",$active_modules))
						{
						$enc_fields=0;
						$stmt = "SELECT count(*) from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
						if ($DB) {echo "$stmt\n";}
						$enc_field_ct = mysqli_num_rows($rslt);
						if ($enc_field_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$enc_fields =	$row[0];
							}
						if ($enc_fields > 0)
							{
							$stmt = "SELECT field_label from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
							$rslt=mysql_to_mysqli($stmt, $link);
							if ($DB) {echo "$stmt\n";}
							$enc_field_ct = mysqli_num_rows($rslt);
							$r=0;
							while ($enc_field_ct > $r)
								{
								$row=mysqli_fetch_row($rslt);
								$encrypt_list .= "$row[0],";
								$r++;
								}
							$encrypt_list = ",$encrypt_list";
							}
						}

					##### BEGIN grab the data from custom table for the lead_id
					$stmt="SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00344',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$list_lead_ct = mysqli_num_rows($rslt);
					if ($list_lead_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$o=0;
						while ($custom_field_names_ct > $o) 
							{
							$field_name_id =		$custom_field_names_ARY[$o];
							$field_name_tag =		"--A--" . $field_name_id . "--B--";
							if ($enc_fields > 0)
								{
								$field_enc='';   $field_enc_all='';
								if ($DB) {echo "|$column_list|$encrypt_list|\n";}
								if ( (preg_match("/,$field_name_id,/",$encrypt_list)) and (strlen($row[$o]) > 0) )
									{
									exec("../agc/aes.pl --decrypt --text=$row[$o]", $field_enc);
									$field_enc_ct = count($field_enc);
									$k=0;
									while ($field_enc_ct > $k)
										{
										$field_enc_all .= $field_enc[$k];
										$k++;
										}
									$field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/",'',$field_enc_all);
									$row[$o] = base64_decode($field_enc_all);
									}
								}
							$form_field_value =		urlencode(trim("$row[$o]"));
							$VDCL_start_call_url = preg_replace("/$field_name_tag/i","$form_field_value",$VDCL_start_call_url);
							$o++;
							}
						}
					}

				$stmt="UPDATE vicidial_log_extended set start_url_processed='Y' where uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00420',$user,$server_ip,$session_name,$one_mysql_log);}
				$vle_update = mysqli_affected_rows($link);

				### insert a new url log entry
				$SQL_log = "$VDCL_start_call_url";
				$SQL_log = preg_replace('/;/','',$SQL_log);
				$SQL_log = addslashes($SQL_log);
				$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date='$NOW_TIME',url_type='start',url='$SQL_log',url_response='';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00421',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				$url_id = mysqli_insert_id($link);

				$URLstart_sec = date("U");

				### grab the call_start_url ###
				if ($DB > 0) {echo "$VDCL_start_call_url<BR>\n";}
				$SCUfile = file("$VDCL_start_call_url");
                if ( !($SCUfile) )
					{
					$error_array = error_get_last();
					$error_type = $error_array["type"];
					$error_message = $error_array["message"];
					$error_line = $error_array["line"];
					$error_file = $error_array["file"];
					}

				if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

				### update url log entry
				$URLend_sec = date("U");
				$URLdiff_sec = ($URLend_sec - $URLstart_sec);
                if ($SCUfile)
					{
					$SCUfile_contents = implode("", $SCUfile);
					$SCUfile_contents = preg_replace('/;/','',$SCUfile_contents);
					$SCUfile_contents = addslashes($SCUfile_contents);
					}
                else
					{
					$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
					}
				$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='$SCUfile_contents' where url_log_id='$url_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00422',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);

				##### BEGIN special filtering and response for Vtiger account balance function #####
				# http://vtiger/vicidial/api.php?mode=callxfer&contactwsid=--A--vendor_lead_code--B--&minuteswarning=3
				$stmt = "SELECT enable_vtiger_integration FROM system_settings;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00294',$user,$server_ip,$session_name,$one_mysql_log);}
				$ss_conf_ct = mysqli_num_rows($rslt);
				if ($ss_conf_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$enable_vtiger_integration =	$row[0];
					}
				if ( ( ($enable_vtiger_integration > 0) and (preg_match('/callxfer/',$VDCL_start_call_url)) and (preg_match('/contactwsid/',$VDCL_start_call_url)) ) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
					{
					$SCUoutput='';
					foreach ($SCUfile as $SCUline) 
						{$SCUoutput .= "$SCUline";}
					# {"result":true,"durationLimit":3071}
					if ( (strlen($SCUoutput) > 4) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
						{
						$minuteswarning=3; # default to 3
						if (preg_match("/minuteswarning/",$VDCL_start_call_url))
							{
							$minuteswarningARY = explode('minuteswarning=',$VDCL_start_call_url);
							$minuteswarning = preg_replace('/&.*/','',$minuteswarningARY[1]);
							}
						### add this to the Start Call URL for callcard calls to be logged "&minuteswarning=1&callcard=1"
						if (preg_match("/callcard=/",$VDCL_start_call_url))
							{
							$stmt="SELECT balance_minutes_start FROM callcard_log where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00315',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$bms_ct = mysqli_num_rows($rslt);
							if ($bms_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$durationLimit = $row[0];

								$stmt="UPDATE callcard_log set agent_time='$NOW_TIME',agent='$user' where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
								if ($DB) {echo "$stmt\n";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00316',$user,$server_ip,$session_name,$one_mysql_log);}
								$ccl_update = mysqli_affected_rows($link);
								}
							}
						else
							{
							$SCUresponse = explode('durationLimit',$SCUoutput);
							$durationLimit = preg_replace('/\D/','',$SCUresponse[1]);
							}
						if (strlen($durationLimit) < 1) {$durationLimit = 0;}
						$durationLimitSECnext = ( ($minuteswarning + 0) * 60);
						$durationLimitSEC = ( ( ($durationLimit + 0) - $minuteswarning) * 60);  # minutes - 3 for 3-minute-warning
						if ($durationLimitSEC < 5) {$durationLimitSEC = 5;}
						if ( ($durationLimitSECnext < 30) or (strlen($durationLimitSECnext)<1) ) {$durationLimitSECnext = 30;}

						$timer_action_destination='';
						if (preg_match("/nextstep=/",$VDCL_start_call_url))
							{
							$nextstepARY = explode('nextstep=',$VDCL_start_call_url);
							$nextstep = preg_replace("/&.*/",'',$nextstepARY[1]);
							$nextmessageARY = explode('nextmessage=',$VDCL_start_call_url);
							$nextmessage = preg_replace("/&.*/",'',$nextmessageARY[1]);
							$destinationARY = explode('destination=',$VDCL_start_call_url);
							$destination = preg_replace("/&.*/",'',$destinationARY[1]);
							$timer_action_destination = "nextstep---$nextstep--$durationLimitSECnext--$destination--$nextmessage--";
							}

						$stmt="UPDATE vicidial_live_agents set external_timer_action='D1_DIAL',external_timer_action_message='$minuteswarning minute warning for customer',external_timer_action_seconds='$durationLimitSEC',external_timer_action_destination='$timer_action_destination' where user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00295',$user,$server_ip,$session_name,$one_mysql_log);}
						$vla_update_timer = mysqli_affected_rows($link);

						$fp = fopen ("./call_url_log.txt", "a");
						fwrite ($fp, "$VDCL_start_call_url\n$SCUoutput\n$durationLimit|$durationLimitSEC|$vla_update_timer|$minuteswarning|$uniqueid|\n");
						fclose($fp);
						}
					}
				##### END special filtering and response for Vtiger account balance function #####
				}
			$stage = $VDADchannel_group . '|' . $call_type . '|' . $uniqueid . '|' . $callerid . '|' . $channel . '|' . $call_server_ip;
			}
		else
			{
			echo "0\n";
		#	echo "No calls in QUEUE for $user on $server_ip\n";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		}
	}


#######################################################################################
### XFERemail - for auto-dial VICIDiaL dialing this will check for emails
###                          in the vicidial_email_list table in NEW status, then
###                          lookup the lead info and pass it back to vicidial.php
###                          Also looks up transferred emails in vicidial_xfer_log
######################################################################################
if ($ACTION == 'XFERemail')
	{
	# xferemail_query = "server_ip=" + server_ip + "&session_name=" + session_name + "&user=" + user + "&pass=" + pass + "&ACTION=XFERemail&format=text&channel=" + redirectvalue + "&call_server_ip=" + redirectserverip + "&queryCID=" + queryCID + "&exten=" + redirectdestination + "&ext_context=" + ext_context + "&ext_priority=1&extrachannel=" + redirectXTRAvalue + "&lead_id=" + document.vicidial_form.lead_id.value + "&phone_code=" + document.vicidial_form.phone_code.value + "&phone_number=" + document.vicidial_form.phone_number.value + "&filename=" + taskdebugnote + "&campaign=" + XfeR_GrouP + "&session_id=" + session_id + "&agentchannel=" + agentchannel + "&protocol=" + protocol + "&extension=" + extension + "&auto_dial_level=" + auto_dial_level;

	$ins_stmt="INSERT INTO vicidial_xfer_log (lead_id,list_id,campaign_id,call_date,phone_code,phone_number,user,closer) values('$lead_id','$list_id','$campaign','$NOW_TIME','$phone_code','$phone_number','$user','EMAIL_XFER')";
	$ins_rslt=mysql_to_mysqli($ins_stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$ins_stmt,'00485',$user,$server_ip,$session_name,$one_mysql_log);}
	$xfercallid = mysqli_insert_id($link);
	echo mysqli_affected_rows($link)."|$ins_stmt";
	
	$upd_stmt="update vicidial_email_list set xfercallid='$xfercallid' where email_row_id='$email_row_id'";
	$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$upd_stmt,'00486',$user,$server_ip,$session_name,$one_mysql_log);}
	}

#######################################################################################
### ManagerChatsCheck - for campaigns/systems where chatting is enabled, this will
###                     look in the vicidial_manager_chats table for any active chats
###                     involving the agent ID being passed and will return any current
###                     chats involving the agent, and will blink for unread messages,
###                     including chats where the agent is the manager/originator
#######################################################################################
if ($ACTION == 'ManagerChatsCheck')
	{
	// Get a count on how many chats the agent is involved in, and also any chats where there are unread messages BY THE USER to determine if the user gets a blinking light.
	$chat_stmt="select manager_chat_id, manager_chat_subid, sum(if(message_viewed_date is null and user='$user', 1, 0)) from vicidial_manager_chat_log where (user='$user' or manager='$user') group by manager_chat_id, manager_chat_subid order by manager_chat_id, manager_chat_subid";
	$chat_rslt=mysql_to_mysqli($chat_stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$chat_stmt,'00636',$user,$server_ip,$session_name,$one_mysql_log);}
	$active_chats=mysqli_num_rows($chat_rslt);
	while ($chat_row=mysqli_fetch_row($chat_rslt)) 
		{
		$unread_messages+=$chat_row[2];
		}
	#$upd_stmt="update vicidial_manager_chat_log set audio_alerted='Y' where (user='$user' or manager='$user') and audio_alerted='N' and message_posted_by!='$user'";
	$upd_stmt="select count(*) From vicidial_manager_chat_log where (user='$user' or manager='$user')";
	$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
	#$message_alert=mysqli_affected_rows($link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$upd_stmt,'00637',$user,$server_ip,$session_name,$one_mysql_log);}

	$upd_row=mysqli_fetch_row($upd_rslt);
	$message_alert=$upd_row[0];
	echo "$active_chats|$unread_messages|$message_alert";
	$stage = "$active_chats|$unread_messages|$message_alert";
	}

#######################################################################################
### VDADcheckINCOMINGother - for auto-dial VICIDiaL dialing this will check for emails
###                          in the vicidial_email_list table in NEW status, then
###                          lookup the lead info and pass it back to vicidial.php
###                          Also looks up transferred emails in vicidial_xfer_log
#######################################################################################
if ($ACTION == 'VDADcheckINCOMINGother')
	{
	$VDCL_ingroup_recording_override = '';
	$VDCL_ingroup_rec_filename = '';
	$Ctype = 'A';
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	$alt_phone_code='';
	$alt_phone_number='';
	$alt_phone_note='';
	$alt_phone_active='';
	$alt_phone_count='';
	$INclosecallid='';
	$INxfercallid='';
	$email_group_str='';
	$chat_group_str="";
	$VLA_inOUT='NONE';
	$queue_seconds=0;

	$email_group_ct=count($inbound_email_groups); # This should always be greater than zero for the script to reach this point, but just in case...
	for ($i=0; $i<$email_group_ct; $i++) 
		{
		$inbound_email_groups[$i] = preg_replace("/\'|\"|\\\\|;/","",$inbound_email_groups[$i]);
		$email_group_str.="'$inbound_email_groups[$i]',";
		}
	$email_group_str=substr($email_group_str, 0, -1);
	if (strlen($email_group_str) < 2) {$email_group_str = "''";}

	$chat_group_ct=count($inbound_chat_groups); # This should always be greater than zero for the script to reach this point, but just in case...
	for ($i=0; $i<$chat_group_ct; $i++) 
		{
		$inbound_chat_groups[$i] = preg_replace("/\'|\"|\\\\|;/","",$inbound_chat_groups[$i]);
		$chat_group_str.="'$inbound_chat_groups[$i]',";
		}
	$chat_group_str=substr($chat_group_str, 0, -1);
	if (strlen($chat_group_str) < 2) {$chat_group_str = "''";}

	# $DB=1;

	if ( (strlen($campaign)<1) || (strlen($server_ip)<1) )
		{
		$channel_live=0;
		echo "0\n";
		echo _QXZ("Campaign %1s is not valid",0,'',$campaign)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		### CHECK FOR EMAILS AND CHATS ###

		### Check for transfers
		$stmt="SELECT vicidial_email_list.lead_id, UNIX_TIMESTAMP(vicidial_email_list.email_date), vicidial_email_list.email_to, vicidial_email_list.email_from, vicidial_email_list.subject, vicidial_xfer_log.campaign_id, vicidial_email_list.email_row_id, vicidial_xfer_log.xfercallid from vicidial_email_list, vicidial_xfer_log where vicidial_email_list.status='QUEUE' and vicidial_email_list.user='$user' and vicidial_xfer_log.xfercallid=vicidial_email_list.xfercallid and direction='INBOUND' and vicidial_xfer_log.campaign_id in ($email_group_str) and closer='EMAIL_XFER' order by vicidial_xfer_log.call_date asc limit 1";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00487',$user,$server_ip,$session_name,$one_mysql_log);}
		$email_ct = mysqli_num_rows($rslt);
		$xferred_email=$email_ct;

		# Check if there are any QUEUE emails 
		if ($email_ct==0) 
			{
			# Check if there are any QUEUE emails 
			$stmt = "SELECT lead_id, UNIX_TIMESTAMP(email_date), email_to, email_from, subject, group_id, email_row_id from vicidial_email_list where status='QUEUE' and direction='INBOUND' and user='$user' and group_id in ($email_group_str) order by email_date asc;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00488',$user,$server_ip,$session_name,$one_mysql_log);}
			$email_ct = mysqli_num_rows($rslt);
			}

		### If no emails have been sent to agent, check for chats, this is the code section where the agent interface will grab the next available chat
		if ($email_ct==0) 
			{
			# Chats don't have a priority setting, but we use it for the AGENTDIRECT_CHAT one (which has it set to 99 and is uneditable through the admin) so that is always the highest priority.  Also ensures that agent does not transfer to self if transferring to the same ingroup (transferring_agent!=user clause)
			$stmt="SELECT vlc.chat_id,UNIX_TIMESTAMP(vlc.chat_start_time),vlc.status,vlc.chat_creator,vlc.group_id,vlc.lead_id,vlc.user_direct_group_id,vig.queue_priority,vig.get_call_launch from vicidial_live_chats vlc, vicidial_inbound_groups vig where vlc.status='WAITING' and (vlc.group_id in ($chat_group_str) or (vlc.group_id='AGENTDIRECT_CHAT' and user_direct='$user')) and (transferring_agent is null or transferring_agent!='$user') order by queue_priority desc, chat_id asc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00638',$user,$server_ip,$session_name,$one_mysql_log);}
			if (mysqli_num_rows($rslt)>0) 
				{
				$chat_row=mysqli_fetch_row($rslt);
				$chat_id =				$chat_row[0];
				$other_start_epoch =	$chat_row[1];
				$status =				$chat_row[2];
				$chat_creator =			$chat_row[3];
				$group_id =				$chat_row[4];
				$VDADchannel_group =	$chat_row[4];
				$lead_id =				$chat_row[5];
				$user_direct_group_id =	$chat_row[6];
				$uniqueid=date("U").".".rand(1, 9999);
				# If this is a transfer directly to an agent, the group ID is 'AGENTDIRECT_CHAT', and we need to set this back to the group ID it was prior to coming over (maybe)
				if ($group_id=="AGENTDIRECT_CHAT") {$upd_clause=", group_id='$user_direct_group_id'";} else {$upd_clause="";}

				$upd_stmt="update vicidial_live_chats set status='LIVE', chat_creator='$user'$upd_clause where chat_id='$chat_id'";
				$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
				$chat_ct=mysqli_affected_rows($link);
				}
			}

		if ($email_ct > 0)
			{
			$VLA_inOUT='EMAIL';
			$row=mysqli_fetch_row($rslt);
			$lead_id =				$row[0];
			$other_start_epoch =	$row[1];
			$email_to =				$row[2];
			$email_from =			$row[3];
			$subject =				$row[4];
			$VDADchannel_group =	$row[5];
			$email_row_id =			$row[6];
			$xfercallid =			$row[7];
			$uniqueid=date("U").".".rand(1, 9999);
			$PADlead_id = sprintf("%010s", $lead_id);
				while (strlen($PADlead_id) > 10) {$PADlead_id = substr("$PADlead_id", 1);}
			$PADemail_row_id = sprintf("%010s", $email_row_id);
				while (strlen($PADemail_row_id) > 9) {$PADemail_row_id = substr("$PADemail_row_id", 1);}
			$caller_code = "E$PADemail_row_id$PADlead_id";

			if (strlen($call_server_ip)<7) {$call_server_ip = $server_ip;}

			$stmt="SELECT get_call_launch FROM vicidial_inbound_groups where group_id='$VDADchannel_group';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00702',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$eg_ct = mysqli_num_rows($rslt);
			if ($eg_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$get_call_launch = $row[0];
				}
			if (!preg_match("/EMAIL|SCRIPT|WEBFORM/",$get_call_launch))
				{$get_call_launch='EMAIL';}
			# Change to better suit the output processed by the agent interface
			 echo "1\n" . $lead_id . '|'.$uniqueid.'|' . $email_from . '|' . $get_call_launch . '|' . $email_row_id . '|' . $email_row_id . "|EMAIL\n"; # VDIC_data_VDAC

			##### grab number of calls today in this campaign and increment
			$stmt="SELECT calls_today FROM vicidial_live_agents WHERE user='$user' and campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00489',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vla_cc_ct = mysqli_num_rows($rslt);
			if ($vla_cc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$calls_today =$row[0];
				}
			else
				{$calls_today ='0';}
			$calls_today++;

			### update the agent status to INCALL in vicidial_live_agents while handling email
			$stmt = "UPDATE vicidial_live_agents set status='INCALL',comments='EMAIL',last_call_time='$NOW_TIME',lead_id='$lead_id',calls_today='$calls_today',external_hangup=0,external_status='',external_pause='',external_dial='',last_state_change='$NOW_TIME',pause_code='',callerid='$caller_code' where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00490',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9106$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			$stmt = "UPDATE vicidial_campaign_agents set calls_today='$calls_today' where user='$user' and campaign_id='$campaign';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00491',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmtA = "UPDATE vicidial_live_inbound_agents set calls_today='$calls_today',last_call_time=NOW() WHERE user='$user' and group_id='$VDADchannel_group';";
			$rsltA=mysql_to_mysqli($stmtA, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00549',$user,$server_ip,$session_name,$one_mysql_log);}
			$stmtA = "UPDATE vicidial_inbound_group_agents set calls_today='$calls_today',group_type='E' WHERE user='$user' and group_id='$VDADchannel_group';";
			$rsltA=mysql_to_mysqli($stmtA, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00550',$user,$server_ip,$session_name,$one_mysql_log);}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00492',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$entry_date		= trim("$row[1]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$phone_code		= trim("$row[10]");
				$phone_number	= trim("$row[11]");
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase	= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
				if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}

			### update the lead status to INCALL
			$stmt = "UPDATE vicidial_list set status='INCALL', user='$user' where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00493',$user,$server_ip,$session_name,$one_mysql_log);}


			### IF incoming result => answer email, not chat...
	
			### update the email lead status to INCALL
			# user='$user' clause moved here because it is now getting added to the lead when the status becomes QUEUE
			$stmt = "UPDATE vicidial_email_list set status='INCALL', uniqueid='$uniqueid' where lead_id='$lead_id' and email_row_id='$email_row_id' and user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00494',$user,$server_ip,$session_name,$one_mysql_log);}

			### END IF
			
			### if a transfer, update the transfer record with the user
			if ($xferred_email==1) 
				{
				$stmt = "UPDATE vicidial_xfer_log set closer='$user' where xfercallid='$xfercallid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00495',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			#############################################
			##### START QUEUEMETRICS LOGGING LOOKUP #####
			$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_callstatus,queuemetrics_dispo_pause,queuemetrics_pe_phone_append,queuemetrics_socket,queuemetrics_socket_url FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00703',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$qm_conf_ct = mysqli_num_rows($rslt);
			if ($qm_conf_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_queuemetrics_logging =	$row[0];
				$queuemetrics_server_ip	=		$row[1];
				$queuemetrics_dbname =			$row[2];
				$queuemetrics_login	=			$row[3];
				$queuemetrics_pass =			$row[4];
				$queuemetrics_log_id =			$row[5];
				$queuemetrics_callstatus =		$row[6];
				$queuemetrics_dispo_pause =		$row[7];
				$queuemetrics_pe_phone_append = $row[8];
				$queuemetrics_socket =			$row[9];
				$queuemetrics_socket_url =		$row[10];
				}
			##### END QUEUEMETRICS LOGGING LOOKUP #####
			###########################################
			if ($enable_queuemetrics_logging > 0)
				{
				$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
				if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
				mysqli_select_db($linkB, "$queuemetrics_dbname");

				$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$caller_code',queue='$VDADchannel_group',agent='NONE',verb='ENTERQUEUE',data2='$email_row_id',serverid='$queuemetrics_log_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00704',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($linkB);

				$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$caller_code',queue='$VDADchannel_group',agent='Agent/$user',verb='CONNECT',data1='0',serverid='$queuemetrics_log_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00705',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($linkB);

				mysqli_close($linkB);
				}
			}
		else if ($chat_ct>0) 
			{
			$VLA_inOUT='CHAT';
			if (strlen($call_server_ip)<7) {$call_server_ip = $server_ip;}

			# Change to better suit the output processed by the agent interface
			 echo "1\n" . $lead_id . '|'.$uniqueid.'|' . $email_from . '|CHAT|' . $chat_id . '|' . $chat_id . "|CHAT\n"; # VDIC_data_VDAC

			
			##### grab number of calls today in this campaign and increment
			$stmt="SELECT calls_today FROM vicidial_live_agents WHERE user='$user' and campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00639',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vla_cc_ct = mysqli_num_rows($rslt);
			if ($vla_cc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$calls_today =$row[0];
				}
			else
				{$calls_today ='0';}
			$calls_today++;

			### update the agent status to INCALL in vicidial_live_agents while handling email
			$stmt = "UPDATE vicidial_live_agents set status='INCALL',comments='CHAT',last_call_time='$NOW_TIME',lead_id='$lead_id',calls_today='$calls_today',external_hangup=0,external_status='',external_pause='',external_dial='',last_state_change='$NOW_TIME',pause_code='' where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00640',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9106$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			$stmt = "UPDATE vicidial_campaign_agents set calls_today='$calls_today' where user='$user' and campaign_id='$campaign';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00641',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmtA = "UPDATE vicidial_live_inbound_agents set calls_today='$calls_today',last_call_time=NOW() WHERE user='$user' and group_id='$VDADchannel_group';";
			$rsltA=mysql_to_mysqli($stmtA, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00642',$user,$server_ip,$session_name,$one_mysql_log);}
			$stmtA = "UPDATE vicidial_inbound_group_agents set calls_today='$calls_today',group_type='C' WHERE user='$user' and group_id='$VDADchannel_group';";
			$rsltA=mysql_to_mysqli($stmtA, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00643',$user,$server_ip,$session_name,$one_mysql_log);}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00644',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$phone_code		= trim("$row[10]");
				$phone_number	= trim("$row[11]");
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase	= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
				if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}

			### update the lead status to INCALL
			$stmt = "UPDATE vicidial_list set status='INCALL', user='$user' where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00645',$user,$server_ip,$session_name,$one_mysql_log);}
			
			}

		if ($email_ct>0 || $chat_ct>0) {
			### ANYTHING AFTER THIS POINT - DOES NOT MATTER WHETHER AN EMAIL OR CHAT IS BEING FIELDED
			

			### gather custom_call_id from vicidial_log_extended table
			$custom_call_id='';
			/* Can't use this - $unique_id is gotten from querying the vicidial_live_agents from an inbound call.  These are not calls.
			$stmt="SELECT custom_call_id FROM vicidial_log_extended where uniqueid='$uniqueid';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00551',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vle_record_ct = mysqli_num_rows($rslt);
			if ($vle_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_call_id =		$row[0];
				}
			*/
			$custom_call_id='';

			### gather user_group and full_name of agent
			$user_group='';
			$stmt="SELECT user_group,full_name FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00496',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				$fullname =			$row[1];
				}

			if ($other_start_epoch > 1000)
				{$queue_seconds = ($StarTtime - $other_start_epoch);}

			### update the vicidial_closer_log user to INCALL
			#$stmt = "UPDATE vicidial_closer_log set user='$user', comments='AUTO', list_id='$list_id', status='INCALL', user_group='$user_group' where lead_id='$lead_id' order by closecallid desc limit 1;";
			$stmt="INSERT INTO vicidial_closer_log(call_date, start_epoch, user, comments, list_id, status, user_group, lead_id, campaign_id, processed, phone_code, phone_number, xfercallid, queue_position, uniqueid, queue_seconds) values('".date("Y-m-d H:i:s")."', '".date("U")."', '$user', '$VLA_inOUT', '$list_id', 'INCALL', '$user_group', '$lead_id', '$VDADchannel_group', 'N', '$phone_code', '$phone_number', '0', '1', '$uniqueid', '$queue_seconds');";

			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00497',$user,$server_ip,$session_name,$one_mysql_log);}

			if (strlen($closecallid)<1)
				{
				$stmt = "SELECT closecallid,xfercallid from vicidial_closer_log where lead_id='$lead_id' and user='$user' and list_id='$list_id' order by closecallid desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00498',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDCL_mvac_ct = mysqli_num_rows($rslt);
				if ($VDCL_mvac_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$INclosecallid =		$row[0];
					$INxfercallid =			$row[1];
					}
				}

			$stmt = "SELECT count(*) from vicidial_log where lead_id='$lead_id' and uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00499',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDL_cid_ct = mysqli_num_rows($rslt);
			if ($VDL_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDCL_front_VDlog	=$row[0];
				}
			$stmt = "SELECT group_name,group_color,web_form_address,fronter_display,ingroup_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_xfer_group,ingroup_recording_override,ingroup_rec_filename,default_group_alias,web_form_address_two,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,uniqueid_status_display,uniqueid_status_prefix,timer_action_destination,web_form_address_three,status_group_id from vicidial_inbound_groups where group_id='$VDADchannel_group';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00500',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDIG_cid_ct = mysqli_num_rows($rslt);
			if ($VDIG_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDCL_group_name =					$row[0];
				$VDCL_group_color =					$row[1];
				$VDCL_group_web	=					stripslashes($row[2]);
				$VDCL_fronter_display =				$row[3];
				$VDCL_ingroup_script =				$row[4];
				$VDCL_get_call_launch =				$row[5];
				$VDCL_xferconf_a_dtmf =				$row[6];
				$VDCL_xferconf_a_number =			$row[7];
				$VDCL_xferconf_b_dtmf =				$row[8];
				$VDCL_xferconf_b_number =			$row[9];
				$VDCL_default_xfer_group =			$row[10];
				$VDCL_ingroup_recording_override =	$row[11];
				$VDCL_ingroup_rec_filename =		$row[12];
				$VDCL_default_group_alias =			$row[13];
				$VDCL_group_web_two =		stripslashes($row[14]);
				$VDCL_timer_action =				$row[15];
				$VDCL_timer_action_message =		$row[16];
				$VDCL_timer_action_seconds =		$row[17];
				$VDCL_start_call_url =				$row[18];
				$VDCL_dispo_call_url =				$row[19];
				$VDCL_xferconf_c_number =			$row[20];
				$VDCL_xferconf_d_number =			$row[21];
				$VDCL_xferconf_e_number =			$row[22];
				$VDCL_uniqueid_status_display =		$row[23];
				$VDCL_uniqueid_status_prefix =		$row[24];
				$VDCL_timer_action_destination =	$row[25];
				$VDCL_group_web_three =		stripslashes($row[26]);

				$status_group_gather_data = status_group_gather($row[27],'INGROUP');

				$stmt = "SELECT campaign_script,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_group_alias,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action_destination from vicidial_campaigns where campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00501',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidOR_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidOR_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					if (strlen($VDCL_xferconf_a_dtmf) < 1)
						{$VDCL_xferconf_a_dtmf =	$row[1];}
					if (strlen($VDCL_xferconf_a_number) < 1)
						{$VDCL_xferconf_a_number =	$row[2];}
					if (strlen($VDCL_xferconf_b_dtmf) < 1)
						{$VDCL_xferconf_b_dtmf =	$row[3];}
					if (strlen($VDCL_xferconf_b_number) < 1)
						{$VDCL_xferconf_b_number =	$row[4];}
					if (strlen($VDCL_default_group_alias) < 1)
						{$VDCL_default_group_alias =	$row[5];}
					if (strlen($VDCL_timer_action) < 1)
						{$VDCL_timer_action =	$row[6];}
					if (strlen($VDCL_timer_action_message) < 1)
						{$VDCL_timer_action_message =	$row[7];}
					if (strlen($VDCL_timer_action_seconds) < 1)
						{$VDCL_timer_action_seconds =	$row[8];}
					if (strlen($VDCL_start_call_url) < 1)
						{$VDCL_start_call_url =	$row[9];}
					if (strlen($VDCL_dispo_call_url) < 1)
						{$VDCL_dispo_call_url =	$row[10];}
					if (strlen($VDCL_xferconf_c_number) < 1)
						{$VDCL_xferconf_c_number =	$row[11];}
					if (strlen($VDCL_xferconf_d_number) < 1)
						{$VDCL_xferconf_d_number =	$row[12];}
					if (strlen($VDCL_xferconf_e_number) < 1)
						{$VDCL_xferconf_e_number =	$row[13];}
					if (strlen($VDCL_timer_action_destination) < 1)
						{$VDCL_timer_action_destination =	$row[14];}
					}
				$stmt = "SELECT group_web_vars from vicidial_inbound_group_agents where group_id='$VDADchannel_group' and user='$user';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00502',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidgwv_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidgwv_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_group_web_vars =	$row[0];
					}

				if (strlen($VDCL_group_web_vars) < 1)
					{
					$stmt = "SELECT group_web_vars from vicidial_campaign_agents where campaign_id='$campaign' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00503',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidogwv = mysqli_num_rows($rslt);
					if ($VDIG_cidogwv > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_group_web_vars =	$row[0];
						}
					}

				### update the comments in vicidial_live_agents record
				$stmt = "UPDATE vicidial_live_agents set last_inbound_call_time='$NOW_TIME' where user='$user' and server_ip='$server_ip';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00504',$user,$server_ip,$session_name,$one_mysql_log);}

				$Ctype = 'I';
				}
			else
				{
				$stmt = "SELECT campaign_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_group_alias,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action_destination from vicidial_campaigns where campaign_id='$VDADchannel_group';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00505',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cid_ct = mysqli_num_rows($rslt);
				if ($VDIG_cid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_ingroup_script	=		$row[0];
					$VDCL_get_call_launch	=		$row[1];
					$VDCL_xferconf_a_dtmf	=		$row[2];
					$VDCL_xferconf_a_number	=		$row[3];
					$VDCL_xferconf_b_dtmf	=		$row[4];
					$VDCL_xferconf_b_number	=		$row[5];
					$VDCL_default_group_alias =		$row[6];
					$VDCL_timer_action = 			$row[7];
					$VDCL_timer_action_message = 	$row[8];
					$VDCL_timer_action_seconds = 	$row[9];
					$VDCL_start_call_url =			$row[10];
					$VDCL_dispo_call_url =			$row[11];
					$VDCL_xferconf_c_number =		$row[12];
					$VDCL_xferconf_d_number =		$row[13];
					$VDCL_xferconf_e_number =		$row[14];
					$VDCL_timer_action_destination = $row[15];
					}

				$stmt = "SELECT group_web_vars from vicidial_campaign_agents where campaign_id='$VDADchannel_group' and user='$user';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00506',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidogwv = mysqli_num_rows($rslt);
				if ($VDIG_cidogwv > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_group_web_vars =	$row[0];
					}
				}

			$VDCL_ingroup_script_color='';
			if ( (strlen($VDCL_ingroup_script)>1) and ($VDCL_ingroup_script != 'NONE') )
				{
				$stmt = "SELECT script_color from vicidial_scripts where script_id='$VDCL_ingroup_script';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00630',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_scrptcolor_ct = mysqli_num_rows($rslt);
				if ($VDIG_scrptcolor_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_ingroup_script_color	= $row[0];
					}
				}

			$VDCL_caller_id_number='';
			if (strlen($VDCL_default_group_alias)>1)
				{
				$stmt = "SELECT caller_id_number from groups_alias where group_alias_id='$VDCL_default_group_alias';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00507',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidnum_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidnum_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_caller_id_number	= $row[0];
					}
				}

			### Check for List ID override settings
			if (strlen($list_id)>0)
				{
				$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number,web_form_address,web_form_address_two,list_name,web_form_address_three,list_description,status_group_id from vicidial_lists where list_id='$list_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00508',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidOR_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidOR_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					if (strlen($row[0]) > 0)
						{$VDCL_xferconf_a_number =	$row[0];}
					if (strlen($row[1]) > 0)
						{$VDCL_xferconf_b_number =	$row[1];}
					if (strlen($row[2]) > 0)
						{$VDCL_xferconf_c_number =	$row[2];}
					if (strlen($row[3]) > 0)
						{$VDCL_xferconf_d_number =	$row[3];}
					if (strlen($row[4]) > 0)
						{$VDCL_xferconf_e_number =	$row[4];}
					if (strlen($row[5]) > 5)
						{$VDCL_group_web =			$row[5];}
					if (strlen($row[6]) > 5)
						{$VDCL_group_web_two =		$row[6];}
					if (strlen($row[7]) > 0)
						{$list_name =				$row[7];}
					if (strlen($row[8]) > 5)
						{$VDCL_group_web_three =	$row[8];}
					$list_description =				$row[9];
					if (strlen($status_group_gather_data)<5)
						{
						$status_group_gather_data = status_group_gather($row[10],'LIST');
						}
					}
				}

			$DID_id='';
			$DID_extension='';
			$DID_pattern='';
			$DID_description='';

			$stmt = "SELECT did_id,extension from vicidial_did_log where uniqueid='$uniqueid' and caller_id_number='$phone_number' order by call_date desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00509',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDIDL_ct = mysqli_num_rows($rslt);
			if ($VDIDL_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$DID_id	=			$row[0];
				$DID_extension	=	$row[1];

				$stmt = "SELECT did_pattern,did_description,custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_inbound_dids where did_id='$DID_id' limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00510',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIDL_ct = mysqli_num_rows($rslt);
				if ($VDIDL_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$DID_pattern =		$row[0];
					$DID_description =	$row[1];
					$DID_custom_one =	$row[2];
					$DID_custom_two=	$row[3];
					$DID_custom_three=	$row[4];
					$DID_custom_four=	$row[5];
					$DID_custom_five=	$row[6];
					}
				}

			### if web form is set then send on to vicidial.php for override of WEB_FORM address
			if ( (strlen($VDCL_group_web)>5) or (strlen($VDCL_group_name)>0) ) {echo "$VDCL_group_web|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|\n";}
			else {echo "X|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|\n";}

			$stmt = "SELECT full_name from vicidial_users where user='$tsr';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00511',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDU_cid_ct = mysqli_num_rows($rslt);
			if ($VDU_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$fronter_full_name		= $row[0];
				echo $fronter_full_name . '|' . $tsr . "\n";
				}
			else {echo '|' . $tsr . "\n";}

			$custom_field_names='|';
			$custom_field_names_SQL='';
			$custom_field_values='----------';
			$custom_field_types='|';
			### find the names of all custom fields, if any
			$stmt = "SELECT field_label,field_type FROM vicidial_lists_fields where list_id='$entry_list_id' and field_type NOT IN('SCRIPT','DISPLAY') and field_label NOT IN('entry_date','vendor_lead_code','source_id','list_id','gmt_offset_now','called_since_last_reset','phone_code','phone_number','title','first_name','middle_initial','last_name','address1','address2','address3','city','state','province','postal_code','country_code','gender','date_of_birth','alt_phone','email','security_phrase','comments','called_count','last_local_call_time','rank','owner') and field_label NOT LIKE \"%_DUPLICATE_%\";";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00512',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cffn_ct = mysqli_num_rows($rslt);
			$d=0;
			while ($cffn_ct > $d)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_field_names .=	"$row[0]|";
				$custom_field_names_SQL .=	"$row[0],";
				$custom_field_types .=	"$row[1]|";
				$custom_field_values .=	"----------";
				$d++;
				}
			if ($cffn_ct > 0)
				{
				$custom_field_names_SQL = preg_replace("/.$/i","",$custom_field_names_SQL);
				### find the values of the named custom fields
				$stmt = "SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00513',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cffv_ct = mysqli_num_rows($rslt);
				if ($cffv_ct > 0)
					{
					$custom_field_values='----------';
					$row=mysqli_fetch_row($rslt);
					$d=0;
					while ($cffn_ct > $d)
						{
						$custom_field_values .=	"$row[$d]----------";
						$d++;
						}
					$custom_field_values = preg_replace("/\n/"," ",$custom_field_values);
					$custom_field_values = preg_replace("/\r/","",$custom_field_values);
					}
				}


			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);

			$LeaD_InfO =	$caller_code . "\n";
			$LeaD_InfO .=	$lead_id . "\n";
			$LeaD_InfO .=	$dispo . "\n";
			$LeaD_InfO .=	$tsr . "\n";
			$LeaD_InfO .=	$vendor_id . "\n";
			$LeaD_InfO .=	$list_id . "\n";
			$LeaD_InfO .=	$gmt_offset_now . "\n";
			$LeaD_InfO .=	$phone_code . "\n";
			$LeaD_InfO .=	$phone_number . "\n";
			$LeaD_InfO .=	$title . "\n";
			$LeaD_InfO .=	$first_name . "\n";
			$LeaD_InfO .=	$middle_initial . "\n";
			$LeaD_InfO .=	$last_name . "\n";
			$LeaD_InfO .=	$address1 . "\n";
			$LeaD_InfO .=	$address2 . "\n";
			$LeaD_InfO .=	$address3 . "\n";
			$LeaD_InfO .=	$city . "\n";
			$LeaD_InfO .=	$state . "\n";
			$LeaD_InfO .=	$province . "\n";
			$LeaD_InfO .=	$postal_code . "\n";
			$LeaD_InfO .=	$country_code . "\n";
			$LeaD_InfO .=	$gender . "\n";
			$LeaD_InfO .=	$date_of_birth . "\n";
			$LeaD_InfO .=	$alt_phone . "\n";
			$LeaD_InfO .=	$email . "\n";
			$LeaD_InfO .=	$security_phrase . "\n";
			$LeaD_InfO .=	$comments . "\n";
			$LeaD_InfO .=	$called_count . "\n";
			$LeaD_InfO .=	$CBentry_time . "\n";
			$LeaD_InfO .=	$CBcallback_time . "\n";
			$LeaD_InfO .=	$CBuser . "\n";
			$LeaD_InfO .=	$CBcomments . "\n";
			$LeaD_InfO .=	$dialed_number . "\n";
			$LeaD_InfO .=	$dialed_label . "\n";
			$LeaD_InfO .=	$source_id . "\n";
			$LeaD_InfO .=	$alt_phone_code . "\n";
			$LeaD_InfO .=	$alt_phone_number . "\n";
			$LeaD_InfO .=	$alt_phone_note . "\n";
			$LeaD_InfO .=	$alt_phone_active . "\n";
			$LeaD_InfO .=	$alt_phone_count . "\n";
			$LeaD_InfO .=	$rank . "\n";
			$LeaD_InfO .=	$owner . "\n";
			$LeaD_InfO .=	$script_recording_delay . "\n";
			$LeaD_InfO .=	$entry_list_id . "\n";
			$LeaD_InfO .=	$custom_field_names . "\n";
			$LeaD_InfO .=	$custom_field_values . "\n";
			$LeaD_InfO .=	$custom_field_types . "\n";
			$LeaD_InfO .=	$list_name . "\n";
			$LeaD_InfO .=   $LISTweb_form_address_three . "\n";
			$LeaD_InfO .=	$VDCL_ingroup_script_color . "\n";
			$LeaD_InfO .=	$list_description . "\n";
			$LeaD_InfO .=	$entry_date . "\n";
			$LeaD_InfO .=	$DID_custom_one . "\n";
			$LeaD_InfO .=	$DID_custom_two . "\n";
			$LeaD_InfO .=	$DID_custom_three . "\n";
			$LeaD_InfO .=	$DID_custom_four . "\n";
			$LeaD_InfO .=	$DID_custom_five . "\n";
			$LeaD_InfO .=	$status_group_gather_data . "\n";
			$LeaD_InfO .=	$call_date . "\n";

			echo $LeaD_InfO;


			$wait_sec=0;
			$StarTtime = date("U");
			$stmt = "SELECT wait_epoch,wait_sec from vicidial_agent_log where agent_log_id='$agent_log_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00514',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDpr_ct = mysqli_num_rows($rslt);
			if ($VDpr_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$wait_sec = (($StarTtime - $row[0]) + $row[1]);
				}
			$stmt="UPDATE vicidial_agent_log set wait_sec='$wait_sec',talk_epoch='$StarTtime',lead_id='$lead_id' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00515',$user,$server_ip,$session_name,$one_mysql_log);}

			### If a scheduled callback, change vicidial_callback record to INACTIVE
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00516',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00517',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or (preg_match("/CALLBK|CBHOLD/i", $dispo)) )
				{
				$stmt="UPDATE vicidial_callbacks set status='INACTIVE' where lead_id='$lead_id' and status NOT IN('INACTIVE','DEAD','ARCHIVE');";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00518',$user,$server_ip,$session_name,$one_mysql_log);}
				}

			##### check if system is set to generate logfile for transfers
			$stmt="SELECT enable_agc_xfer_log FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00519',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$enable_agc_xfer_log_ct = mysqli_num_rows($rslt);
			if ($enable_agc_xfer_log_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_agc_xfer_log =$row[0];
				}

			if ( ($WeBRooTWritablE > 0) and ($enable_agc_xfer_log > 0) )
				{
				#	DATETIME|campaign|lead_id|phone_number|user|type
				#	2007-08-22 11:11:11|TESTCAMP|65432|3125551212|1234|A
				$fp = fopen ("./xfer_log.txt", "a");
				fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$phone_number|$user|$Ctype|$callerid|$uniqueid|$province\n");
				fclose($fp);
				}

			### Issue Start Call URL if defined
			if (strlen($VDCL_start_call_url) > 7)
				{
				if (preg_match('/--A--user_custom_/i',$VDCL_start_call_url))
					{
					$stmt = "SELECT custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_users where user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00520',$user,$server_ip,$session_name,$one_mysql_log);}
					$VUC_ct = mysqli_num_rows($rslt);
					if ($VUC_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$user_custom_one	=		urlencode(trim($row[0]));
						$user_custom_two	=		urlencode(trim($row[1]));
						$user_custom_three	=		urlencode(trim($row[2]));
						$user_custom_four	=		urlencode(trim($row[3]));
						$user_custom_five	=		urlencode(trim($row[4]));
						}
					}
				$VDCL_start_call_url = preg_replace('/^VAR/','',$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--lead_id--B--/i',urlencode(trim($lead_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--vendor_id--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--vendor_lead_code--B--/i',urlencode(trim($vendor_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_id--B--/i',urlencode(trim($list_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_name--B--/i',urlencode(trim($list_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--list_description--B--/i',urlencode(trim($list_description)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--gmt_offset_now--B--/i',urlencode(trim($gmt_offset_now)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_code--B--/i',urlencode(trim($phone_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_number--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--title--B--/i',urlencode(trim($title)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--first_name--B--/i',urlencode(trim($first_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--middle_initial--B--/i',urlencode(trim($middle_initial)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--last_name--B--/i',urlencode(trim($last_name)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address1--B--/i',urlencode(trim($address1)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address2--B--/i',urlencode(trim($address2)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--address3--B--/i',urlencode(trim($address3)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--city--B--/i',urlencode(trim($city)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--state--B--/i',urlencode(trim($state)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--province--B--/i',urlencode(trim($province)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--postal_code--B--/i',urlencode(trim($postal_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--country_code--B--/i',urlencode(trim($country_code)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--gender--B--/i',urlencode(trim($gender)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--date_of_birth--B--/i',urlencode(trim($date_of_birth)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--alt_phone--B--/i',urlencode(trim($alt_phone)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--email--B--/i',urlencode(trim($email)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--security_phrase--B--/i',urlencode(trim($security_phrase)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--comments--B--/i',urlencode(trim($comments)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user--B--/i',urlencode(trim($user)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--pass--B--/i',urlencode(trim($orig_pass)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--campaign--B--/i',urlencode(trim($campaign)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_login--B--/i',urlencode(trim($phone_login)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--original_phone_login--B--/i',urlencode(trim($original_phone_login)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone_pass--B--/i',urlencode(trim($phone_pass)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--fronter--B--/i',urlencode(trim($fronter)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--closer--B--/i',urlencode(trim($closer)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--channel_group--B--/i',urlencode(trim($VDADchannel_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--SQLdate--B--/i',urlencode(trim($SQLdate)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--epoch--B--/i',urlencode(trim($epoch)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--uniqueid--B--/i',urlencode(trim($uniqueid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--customer_zap_channel--B--/i',urlencode(trim($channel)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--customer_server_ip--B--/i',urlencode(trim($call_server_ip)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--server_ip--B--/i',urlencode(trim($server_ip)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--SIPexten--B--/i',urlencode(trim($exten)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--session_id--B--/i',urlencode(trim($conf_exten)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--phone--B--/i',urlencode(trim($phone_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--parked_by--B--/i',urlencode(trim($parked_by)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dispo--B--/i',urlencode(trim($dispo)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dialed_number--B--/i',urlencode(trim($dialed_number)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--dialed_label--B--/i',urlencode(trim($dialed_label)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--source_id--B--/i',urlencode(trim($source_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--rank--B--/i',urlencode(trim($rank)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--owner--B--/i',urlencode(trim($owner)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--camp_script--B--/i',urlencode(trim($camp_script)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--in_script--B--/i',urlencode(trim($VDCL_ingroup_script)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--fullname--B--/i',urlencode(trim($fullname)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_one--B--/i',urlencode(trim($user_custom_one)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_two--B--/i',urlencode(trim($user_custom_two)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_three--B--/i',urlencode(trim($user_custom_three)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_four--B--/i',urlencode(trim($user_custom_four)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_custom_five--B--/i',urlencode(trim($user_custom_five)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--talk_time--B--/i',"0",$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--talk_time_min--B--/i',"0",$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--entry_list_id--B--/i',urlencode(trim($entry_list_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_id--B--/i',urlencode(trim($DID_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_extension--B--/i',urlencode(trim($DID_extension)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_pattern--B--/i',urlencode(trim($DID_pattern)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_description--B--/i',urlencode(trim($DID_description)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--closecallid--B--/i',urlencode(trim($INclosecallid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--xfercallid--B--/i',urlencode(trim($INxfercallid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--agent_log_id--B--/i',urlencode(trim($agent_log_id)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--call_id--B--/i',urlencode(trim($callerid)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--user_group--B--/i',urlencode(trim($user_group)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--entry_date--B--/i',urlencode(trim($entry_date)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_one--B--/i',urlencode(trim($DID_custom_one)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_two--B--/i',urlencode(trim($DID_custom_two)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_three--B--/i',urlencode(trim($DID_custom_three)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_four--B--/i',urlencode(trim($DID_custom_four)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--did_custom_five--B--/i',urlencode(trim($DID_custom_five)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--agent_email--B--/i',urlencode(trim($agent_email)),$VDCL_start_call_url);
				$VDCL_start_call_url = preg_replace('/--A--called_count--B--/i',urlencode(trim($called_count)),$VDCL_start_call_url);

				if (strlen($custom_field_names)>2)
					{
					$custom_field_names = preg_replace("/^\||\|$/",'',$custom_field_names);
					$custom_field_names = preg_replace("/\|/",",",$custom_field_names);
					$custom_field_names_ARY = explode(',',$custom_field_names);
					$custom_field_names_ct = count($custom_field_names_ARY);
					$custom_field_names_SQL = $custom_field_names;

					if (preg_match("/cf_encrypt/",$active_modules))
						{
						$enc_fields=0;
						$stmt = "SELECT count(*) from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
						$rslt=mysql_to_mysqli($stmt, $link);
						if ($DB) {echo "$stmt\n";}
						$enc_field_ct = mysqli_num_rows($rslt);
						if ($enc_field_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$enc_fields =	$row[0];
							}
						if ($enc_fields > 0)
							{
							$stmt = "SELECT field_label from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
							$rslt=mysql_to_mysqli($stmt, $link);
							if ($DB) {echo "$stmt\n";}
							$enc_field_ct = mysqli_num_rows($rslt);
							$r=0;
							while ($enc_field_ct > $r)
								{
								$row=mysqli_fetch_row($rslt);
								$encrypt_list .= "$row[0],";
								$r++;
								}
							$encrypt_list = ",$encrypt_list";
							}
						}

					##### BEGIN grab the data from custom table for the lead_id
					$stmt="SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00521',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$list_lead_ct = mysqli_num_rows($rslt);
					if ($list_lead_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$o=0;
						while ($custom_field_names_ct > $o) 
							{
							$field_name_id =		$custom_field_names_ARY[$o];
							$field_name_tag =		"--A--" . $field_name_id . "--B--";
							if ($enc_fields > 0)
								{
								$field_enc='';   $field_enc_all='';
								if ($DB) {echo "|$column_list|$encrypt_list|\n";}
								if ( (preg_match("/,$field_name_id,/",$encrypt_list)) and (strlen($row[$o]) > 0) )
									{
									exec("../agc/aes.pl --decrypt --text=$row[$o]", $field_enc);
									$field_enc_ct = count($field_enc);
									$k=0;
									while ($field_enc_ct > $k)
										{
										$field_enc_all .= $field_enc[$k];
										$k++;
										}
									$field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/",'',$field_enc_all);
									$row[$o] = base64_decode($field_enc_all);
									}
								}
							$form_field_value =		urlencode(trim("$row[$o]"));
							$VDCL_start_call_url = preg_replace("/$field_name_tag/i","$form_field_value",$VDCL_start_call_url);
							$o++;
							}
						}
					}

				$stmt="UPDATE vicidial_log_extended set start_url_processed='Y' where uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00522',$user,$server_ip,$session_name,$one_mysql_log);}
				$vle_update = mysqli_affected_rows($link);

				### insert a new url log entry
				$SQL_log = "$VDCL_start_call_url";
				$SQL_log = preg_replace('/;/','',$SQL_log);
				$SQL_log = addslashes($SQL_log);
			#	$upd_stmt="update vicidial_email_list set message='URL: $SQL_log' where lead_id='$lead_id'";
			#	$upd_rslt=mysql_to_mysqli($upd_stmt, $link);

				$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date='$NOW_TIME',url_type='start',url='$SQL_log',url_response='';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00523',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				$url_id = mysqli_insert_id($link);

				$URLstart_sec = date("U");

				### grab the call_start_url ###
				if ($DB > 0) {echo "$VDCL_start_call_url<BR>\n";}
				$SCUfile = file("$VDCL_start_call_url");
                if ( !($SCUfile) )
					{
					$error_array = error_get_last();
					$error_type = $error_array["type"];
					$error_message = $error_array["message"];
					$error_line = $error_array["line"];
					$error_file = $error_array["file"];
					}

				if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

				### update url log entry
				$URLend_sec = date("U");
				$URLdiff_sec = ($URLend_sec - $URLstart_sec);
                if ($SCUfile)
					{
					$SCUfile_contents = implode("", $SCUfile);
					$SCUfile_contents = preg_replace('/;/','',$SCUfile_contents);
					$SCUfile_contents = addslashes($SCUfile_contents);
					}
                else
					{
					$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
					}
				$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='$SCUfile_contents' where url_log_id='$url_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00524',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);

				##### BEGIN special filtering and response for Vtiger account balance function #####
				# http://vtiger/vicidial/api.php?mode=callxfer&contactwsid=--A--vendor_lead_code--B--&minuteswarning=3
				$stmt = "SELECT enable_vtiger_integration FROM system_settings;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00525',$user,$server_ip,$session_name,$one_mysql_log);}
				$ss_conf_ct = mysqli_num_rows($rslt);
				if ($ss_conf_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$enable_vtiger_integration =	$row[0];
					}
				if ( ( ($enable_vtiger_integration > 0) and (preg_match('/callxfer/',$VDCL_start_call_url)) and (preg_match('/contactwsid/',$VDCL_start_call_url)) ) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
					{
					$SCUoutput='';
					foreach ($SCUfile as $SCUline) 
						{$SCUoutput .= "$SCUline";}
					# {"result":true,"durationLimit":3071}
					if ( (strlen($SCUoutput) > 4) or (preg_match("/minuteswarning/",$VDCL_start_call_url)) )
						{
						$minuteswarning=3; # default to 3
						if (preg_match("/minuteswarning/",$VDCL_start_call_url))
							{
							$minuteswarningARY = explode('minuteswarning=',$VDCL_start_call_url);
							$minuteswarning = preg_replace('/&.*/','',$minuteswarningARY[1]);
							}
						### add this to the Start Call URL for callcard calls to be logged "&minuteswarning=1&callcard=1"
						if (preg_match("/callcard=/",$VDCL_start_call_url))
							{
							$stmt="SELECT balance_minutes_start FROM callcard_log where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
							$rslt=mysql_to_mysqli($stmt, $link);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00526',$user,$server_ip,$session_name,$one_mysql_log);}
							if ($DB) {echo "$stmt\n";}
							$bms_ct = mysqli_num_rows($rslt);
							if ($bms_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$durationLimit = $row[0];

								$stmt="UPDATE callcard_log set agent_time='$NOW_TIME',agent='$user' where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
								if ($DB) {echo "$stmt\n";}
								$rslt=mysql_to_mysqli($stmt, $link);
									if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00527',$user,$server_ip,$session_name,$one_mysql_log);}
								$ccl_update = mysqli_affected_rows($link);
								}
							}
						else
							{
							$SCUresponse = explode('durationLimit',$SCUoutput);
							$durationLimit = preg_replace('/\D/','',$SCUresponse[1]);
							}
						if (strlen($durationLimit) < 1) {$durationLimit = 0;}
						$durationLimitSECnext = ( ($minuteswarning + 0) * 60);
						$durationLimitSEC = ( ( ($durationLimit + 0) - $minuteswarning) * 60);  # minutes - 3 for 3-minute-warning
						if ($durationLimitSEC < 5) {$durationLimitSEC = 5;}
						if ( ($durationLimitSECnext < 30) or (strlen($durationLimitSECnext)<1) ) {$durationLimitSECnext = 30;}

						$timer_action_destination='';
						if (preg_match("/nextstep=/",$VDCL_start_call_url))
							{
							$nextstepARY = explode('nextstep=',$VDCL_start_call_url);
							$nextstep = preg_replace("/&.*/",'',$nextstepARY[1]);
							$nextmessageARY = explode('nextmessage=',$VDCL_start_call_url);
							$nextmessage = preg_replace("/&.*/",'',$nextmessageARY[1]);
							$destinationARY = explode('destination=',$VDCL_start_call_url);
							$destination = preg_replace("/&.*/",'',$destinationARY[1]);
							$timer_action_destination = "nextstep---$nextstep--$durationLimitSECnext--$destination--$nextmessage--";
							}

						$stmt="UPDATE vicidial_live_agents set external_timer_action='D1_DIAL',external_timer_action_message='$minuteswarning minute warning for customer',external_timer_action_seconds='$durationLimitSEC',external_timer_action_destination='$timer_action_destination' where user='$user';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00528',$user,$server_ip,$session_name,$one_mysql_log);}
						$vla_update_timer = mysqli_affected_rows($link);

						$fp = fopen ("./call_url_log.txt", "a");
						fwrite ($fp, "$VDCL_start_call_url\n$SCUoutput\n$durationLimit|$durationLimitSEC|$vla_update_timer|$minuteswarning|$uniqueid|\n");
						fclose($fp);
						}
					}
				##### END special filtering and response for Vtiger account balance function #####
				}
			}
			else
			{
			echo "0\n";
		#	echo "No calls in QUEUE for $user on $server_ip\n";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		}
	}

################################################################################
### LeaDSearcHSelecTUpdatE - for inbound lead search update select calls
###                          gathers lead information to send to agent screen
################################################################################
if ($ACTION == 'LeaDSearcHSelecTUpdatE')
	{
	$VDCL_ingroup_recording_override = '';
	$VDCL_ingroup_rec_filename = '';
	$Ctype = 'A';
	$MT[0]='';
	$row='';   $rowx='';
	$channel_live=1;
	$alt_phone_code='';
	$alt_phone_number='';
	$alt_phone_note='';
	$alt_phone_active='';
	$alt_phone_count='';
	$INclosecallid='';
	$INxfercallid='';

	if ( (strlen($campaign)<1) || (strlen($server_ip)<1) || ($lead_id<0) )
		{
		$channel_live=0;
		echo "0\n";
		echo _QXZ("Campaign %1s is not valid or lead_id %2s is not valid",0,'',$campaign,$lead_id)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		### grab the call info from the vicidial_live_agents table
		$stmt = "SELECT uniqueid,callerid,channel,call_server_ip,comments,lead_id FROM vicidial_live_agents where server_ip = '$server_ip' and user='$user' and campaign_id='$campaign';";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00447',$user,$server_ip,$session_name,$one_mysql_log);}
		$queue_leadID_ct = mysqli_num_rows($rslt);

		if ($queue_leadID_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$uniqueid =			$row[0];
			$callerid =			$row[1];
			$channel =			$row[2];
			$call_server_ip =	$row[3];
			$VLAcomments =		$row[4];
			$old_lead_id =		$row[4];

			if (strlen($call_server_ip)<7) {$call_server_ip = $server_ip;}
			echo "1\n" . $lead_id . '|' . $uniqueid . '|' . $callerid . '|' . $channel . '|' . $call_server_ip . "|\n";

			$original_phone_number = $phone_number;

			### update the agent lead_id to the new lead_id in vicidial_live_agents
			$stmt = "UPDATE vicidial_live_agents set lead_id='$lead_id',external_lead_id=0 where user='$user' and server_ip='$server_ip';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00448',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9106$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			### update the auto calls lead_id to the new lead_id in vicidial_auto_calls
			$stmt = "UPDATE vicidial_auto_calls set lead_id='$lead_id' where callerid='$callerid' and uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00449',$user,$server_ip,$session_name,$one_mysql_log);}

			### update the previous lead_id(stage) entry in vicidial_list, set the status to LSMERG
			$stmt = "UPDATE vicidial_list set status='LSMERG' where lead_id='$stage';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00450',$user,$server_ip,$session_name,$one_mysql_log);}

			### update the vicidial_grab_call_log lead_id to the new lead_id
			$stmt = "UPDATE vicidial_grab_call_log set lead_id='$lead_id' where lead_id='$stage' and user='$user' and uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00451',$user,$server_ip,$session_name,$one_mysql_log);}

			### update the vicidial_log_extended lead_id to the new lead_id
			$stmt = "UPDATE vicidial_log_extended set lead_id='$lead_id' where lead_id='$stage' and caller_code='$callerid' and uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00453',$user,$server_ip,$session_name,$one_mysql_log);}

			### update the park_log lead_id to the new lead_id
			$stmt = "UPDATE park_log set lead_id='$lead_id' where lead_id='$stage' and user='$user' and uniqueid='$uniqueid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00454',$user,$server_ip,$session_name,$one_mysql_log);}

			### insert into the vicidial_agent_function_log table that the switch happened
			$stmt = "INSERT INTO vicidial_agent_function_log set agent_log_id='$agent_log_id',user='$user',function='switch_lead',event_time=NOW(),campaign_id='$campaign',user_group='$user_group',lead_id='$stage',uniqueid='$uniqueid',caller_code='$callerid',stage='$lead_id',comments='$phone_number';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00710',$user,$server_ip,$session_name,$one_mysql_log);}

			##### grab the data from vicidial_list for the lead_id
			$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00455',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$list_lead_ct = mysqli_num_rows($rslt);
			if ($list_lead_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
			#	$lead_id		= trim("$row[0]");
				$entry_date		= trim("$row[1]");
				$dispo			= trim("$row[3]");
				$tsr			= trim("$row[4]");
				$vendor_id		= trim("$row[5]");
				$source_id		= trim("$row[6]");
				$list_id		= trim("$row[7]");
				$gmt_offset_now	= trim("$row[8]");
				$phone_code		= trim("$row[10]");
				$phone_number	= trim("$row[11]");
				$title			= trim("$row[12]");
				$first_name		= trim("$row[13]");
				$middle_initial	= trim("$row[14]");
				$last_name		= trim("$row[15]");
				$address1		= trim("$row[16]");
				$address2		= trim("$row[17]");
				$address3		= trim("$row[18]");
				$city			= trim("$row[19]");
				$state			= trim("$row[20]");
				$province		= trim("$row[21]");
				$postal_code	= trim("$row[22]");
				$country_code	= trim("$row[23]");
				$gender			= trim("$row[24]");
				$date_of_birth	= trim("$row[25]");
				$alt_phone		= trim("$row[26]");
				$email			= trim("$row[27]");
				$security_phrase	= trim("$row[28]");
				$comments		= stripslashes(trim("$row[29]"));
				$called_count	= trim("$row[30]");
				$call_date		= trim("$row[31]");
				$rank			= trim("$row[32]");
				$owner			= trim("$row[33]");
				$entry_list_id	= trim("$row[34]");
				if ($entry_list_id < 100) {$entry_list_id = $list_id;}
				}
			if ($qc_features_active > 0)
				{
				//Added by Poundteam for Audited Comments
				##### if list has audited comments, grab the audited comments
				require_once('audit_comments.php');
				$ACcount =		'';
				$ACcomments =		'';
				$audit_comments_active=audit_comments_active($list_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
				if ($audit_comments_active)
					{
					get_audited_comments($lead_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log);
					}
				$ACcomments = strip_tags(htmlentities($ACcomments));
				$ACcomments = preg_replace("/\r/i",'',$ACcomments);
				$ACcomments = preg_replace("/\n/i",'!N',$ACcomments);
				//END Added by Poundteam for Audited Comments
				}

			##### if lead is a callback, grab the callback comments
			$CBentry_time =		'';
			$CBcallback_time =	'';
			$CBuser =			'';
			$CBcomments =		'';
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00456',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00457',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or ($dispo == 'CBHOLD') )
				{
				$stmt="SELECT entry_time,callback_time,user,comments FROM vicidial_callbacks where lead_id='$lead_id' order by callback_id desc LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00458',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBentry_time =		trim("$row[0]");
					$CBcallback_time =	trim("$row[1]");
					$CBuser =			trim("$row[2]");
					$CBcomments =		trim("$row[3]");
					}
				}
			$stmt="SELECT owner_populate FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00459',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$camp_op_ct = mysqli_num_rows($rslt);
			if ($camp_op_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$owner_populate =				$row[0];
				}
			$ownerSQL='';
			if ( ($owner_populate=='ENABLED') and ( (strlen($owner) < 1) or ($owner=='NULL') ) )
				{
				$ownerSQL = ",owner='$user'";
				$owner=$user;
				}

			### update the lead status to INCALL
			$stmt = "UPDATE vicidial_list set status='INCALL', user='$user' $ownerSQL where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00460',$user,$server_ip,$session_name,$one_mysql_log);}

			### gather custom_call_id from vicidial_log_extended table
			$custom_call_id='';
			$stmt="SELECT custom_call_id FROM vicidial_log_extended where uniqueid='$uniqueid';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00461',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vle_record_ct = mysqli_num_rows($rslt);
			if ($vle_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_call_id =		$row[0];
				}

			### update the log status to INCALL
			$user_group='';
			$stmt="SELECT user_group,full_name FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00462',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				$fullname =			$row[1];
				}

			$dialed_number = $phone_number;
			$dialed_label = 'MAIN';
			$call_type = 'IN';
			$stmt = "SELECT campaign_id,closecallid,xfercallid from vicidial_closer_log where lead_id = '$stage' order by closecallid desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00463',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDCL_mvac_ct = mysqli_num_rows($rslt);
			if ($VDCL_mvac_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDADchannel_group =	$row[0];
				$INclosecallid =		$row[1];
				$INxfercallid =			$row[2];
				}
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./vicidial_debug.txt", "a");
				fwrite ($fp, "$NOW_TIME|INBND|$callerid|$user|$user_group|$list_id|$lead_id|$phone_number|$uniqueid|$VDADchannel_group|$call_type|$dialed_number|$dialed_label|$INclosecallid|$INxfercallid|\n");
				fclose($fp);
				}

			### update the recording_log lead_id to the new lead_id
			$stmt = "UPDATE recording_log set lead_id='$lead_id' where lead_id='$stage' and user='$user' and vicidial_id='$INclosecallid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00464',$user,$server_ip,$session_name,$one_mysql_log);}

			### update the vicidial_closer_log user to INCALL
			$stmt = "UPDATE vicidial_closer_log set lead_id='$lead_id' where lead_id='$stage' and user='$user' and uniqueid='$uniqueid' order by closecallid desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00465',$user,$server_ip,$session_name,$one_mysql_log);}

			if (strlen($closecallid)<1)
				{
				$stmt = "SELECT closecallid,xfercallid from vicidial_closer_log where lead_id='$lead_id' and user='$user' order by closecallid desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00466',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDCL_mvac_ct = mysqli_num_rows($rslt);
				if ($VDCL_mvac_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$INclosecallid =		$row[0];
					$INxfercallid =			$row[1];
					}
				}

			### update the vicidial_xfer_log lead_id to the new lead_id
			$stmt = "UPDATE vicidial_xfer_log set lead_id='$lead_id' where lead_id='$stage' and closer='$user' and xfercallid='$INxfercallid';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00452',$user,$server_ip,$session_name,$one_mysql_log);}

			$script_recording_delay=0;
			##### find if script contains recording fields
			$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_inbound_groups vig WHERE group_id='$VDADchannel_group' and vs.script_id=vig.ingroup_script and script_text LIKE \"%--A--recording_%\";";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00467',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vs_vc_ct = mysqli_num_rows($rslt);
			if ($vs_vc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$script_recording_delay = $row[0];
				}

			$stmt = "SELECT group_name,group_color,web_form_address,fronter_display,ingroup_script,get_call_launch,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_xfer_group,ingroup_recording_override,ingroup_rec_filename,default_group_alias,web_form_address_two,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,uniqueid_status_display,uniqueid_status_prefix,timer_action_destination,web_form_address_three,status_group_id from vicidial_inbound_groups where group_id='$VDADchannel_group';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00468',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDIG_cid_ct = mysqli_num_rows($rslt);
			if ($VDIG_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDCL_group_name =					$row[0];
				$VDCL_group_color =					$row[1];
				$VDCL_group_web	=					stripslashes($row[2]);
				$VDCL_fronter_display =				$row[3];
				$VDCL_ingroup_script =				$row[4];
				$VDCL_get_call_launch =				$row[5];
				$VDCL_xferconf_a_dtmf =				$row[6];
				$VDCL_xferconf_a_number =			$row[7];
				$VDCL_xferconf_b_dtmf =				$row[8];
				$VDCL_xferconf_b_number =			$row[9];
				$VDCL_default_xfer_group =			$row[10];
				$VDCL_ingroup_recording_override =	$row[11];
				$VDCL_ingroup_rec_filename =		$row[12];
				$VDCL_default_group_alias =			$row[13];
				$VDCL_group_web_two =		stripslashes($row[14]);
				$VDCL_timer_action =				$row[15];
				$VDCL_timer_action_message =		$row[16];
				$VDCL_timer_action_seconds =		$row[17];
				$VDCL_start_call_url =				$row[18];
				$VDCL_dispo_call_url =				$row[19];
				$VDCL_xferconf_c_number =			$row[20];
				$VDCL_xferconf_d_number =			$row[21];
				$VDCL_xferconf_e_number =			$row[22];
				$VDCL_uniqueid_status_display =		$row[23];
				$VDCL_uniqueid_status_prefix =		$row[24];
				$VDCL_timer_action_destination =	$row[25];
				$VDCL_group_web_three =		stripslashes($row[26]);

				$status_group_gather_data = status_group_gather($row[27],'INGROUP');

				$stmt = "SELECT campaign_script,xferconf_a_dtmf,xferconf_a_number,xferconf_b_dtmf,xferconf_b_number,default_group_alias,timer_action,timer_action_message,timer_action_seconds,start_call_url,dispo_call_url,xferconf_c_number,xferconf_d_number,xferconf_e_number,timer_action_destination from vicidial_campaigns where campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00469',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidOR_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidOR_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					if (strlen($VDCL_xferconf_a_dtmf) < 1)
						{$VDCL_xferconf_a_dtmf =	$row[1];}
					if (strlen($VDCL_xferconf_a_number) < 1)
						{$VDCL_xferconf_a_number =	$row[2];}
					if (strlen($VDCL_xferconf_b_dtmf) < 1)
						{$VDCL_xferconf_b_dtmf =	$row[3];}
					if (strlen($VDCL_xferconf_b_number) < 1)
						{$VDCL_xferconf_b_number =	$row[4];}
					if (strlen($VDCL_default_group_alias) < 1)
						{$VDCL_default_group_alias =	$row[5];}
					if (strlen($VDCL_timer_action) < 1)
						{$VDCL_timer_action =	$row[6];}
					if (strlen($VDCL_timer_action_message) < 1)
						{$VDCL_timer_action_message =	$row[7];}
					if (strlen($VDCL_timer_action_seconds) < 1)
						{$VDCL_timer_action_seconds =	$row[8];}
					if (strlen($VDCL_start_call_url) < 1)
						{$VDCL_start_call_url =	$row[9];}
					if (strlen($VDCL_dispo_call_url) < 1)
						{$VDCL_dispo_call_url =	$row[10];}
					if (strlen($VDCL_xferconf_c_number) < 1)
						{$VDCL_xferconf_c_number =	$row[11];}
					if (strlen($VDCL_xferconf_d_number) < 1)
						{$VDCL_xferconf_d_number =	$row[12];}
					if (strlen($VDCL_xferconf_e_number) < 1)
						{$VDCL_xferconf_e_number =	$row[13];}
					if (strlen($VDCL_timer_action_destination) < 1)
						{$VDCL_timer_action_destination =	$row[14];}

					if ( ( (preg_match('/NONE/',$VDCL_ingroup_script)) and (strlen($VDCL_ingroup_script) < 5) ) or (strlen($VDCL_ingroup_script) < 1) )
						{
						$VDCL_ingroup_script =		$row[0];
						$script_recording_delay=0;
						##### find if script contains recording fields
						$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_campaigns vc WHERE campaign_id='$campaign' and vs.script_id=vc.campaign_script and script_text LIKE \"%--A--recording_%\";";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00470',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "$stmt\n";}
						$vs_vc_ct = mysqli_num_rows($rslt);
						if ($vs_vc_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$script_recording_delay = $row[0];
							}
						}
					}

				$stmt = "SELECT group_web_vars from vicidial_inbound_group_agents where group_id='$VDADchannel_group' and user='$user';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00471',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidgwv_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidgwv_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_group_web_vars =	$row[0];
					}

				if (strlen($VDCL_group_web_vars) < 1)
					{
					$stmt = "SELECT group_web_vars from vicidial_campaign_agents where campaign_id='$campaign' and user='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00472',$user,$server_ip,$session_name,$one_mysql_log);}
					$VDIG_cidogwv = mysqli_num_rows($rslt);
					if ($VDIG_cidogwv > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VDCL_group_web_vars =	$row[0];
						}
					}

				$Ctype = 'I';
				}

			$VDCL_ingroup_script_color='';
			if ( (strlen($VDCL_ingroup_script)>1) and ($VDCL_ingroup_script != 'NONE') )
				{
				$stmt = "SELECT script_color from vicidial_scripts where script_id='$VDCL_ingroup_script';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00631',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_scrptcolor_ct = mysqli_num_rows($rslt);
				if ($VDIG_scrptcolor_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$VDCL_ingroup_script_color	= $row[0];
					}
				}


			### Check for List ID override settings
			if (strlen($list_id)>0)
				{
				$stmt = "SELECT xferconf_a_number,xferconf_b_number,xferconf_c_number,xferconf_d_number,xferconf_e_number,web_form_address,web_form_address_two,list_name,web_form_address_three,list_description,status_group_id from vicidial_lists where list_id='$list_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00473',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIG_cidOR_ct = mysqli_num_rows($rslt);
				if ($VDIG_cidOR_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					if (strlen($row[0]) > 0)
						{$VDCL_xferconf_a_number =	$row[0];}
					if (strlen($row[1]) > 0)
						{$VDCL_xferconf_b_number =	$row[1];}
					if (strlen($row[2]) > 0)
						{$VDCL_xferconf_c_number =	$row[2];}
					if (strlen($row[3]) > 0)
						{$VDCL_xferconf_d_number =	$row[3];}
					if (strlen($row[4]) > 0)
						{$VDCL_xferconf_e_number =	$row[4];}
					if (strlen($row[5]) > 5)
						{$VDCL_group_web =			$row[5];}
					if (strlen($row[6]) > 5)
						{$VDCL_group_web_two =		$row[6];}
					if (strlen($row[7]) > 0)
						{$list_name =				$row[7];}
					if (strlen($row[8]) > 5)
						{$VDCL_group_web_three =	$row[8];}
					$list_description =				$row[9];
					if (strlen($status_group_gather_data)<5)
						{
						$status_group_gather_data = status_group_gather($row[10],'LIST');
						}
					}
				}

			$DID_id='';
			$DID_extension='';
			$DID_pattern='';
			$DID_description='';

			$stmt = "SELECT did_id,extension from vicidial_did_log where uniqueid='$uniqueid' and caller_id_number='$phone_number' order by call_date desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00474',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDIDL_ct = mysqli_num_rows($rslt);
			if ($VDIDL_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$DID_id	=			$row[0];
				$DID_extension	=	$row[1];

				$stmt = "SELECT did_pattern,did_description,custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_inbound_dids where did_id='$DID_id' limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00475',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIDL_ct = mysqli_num_rows($rslt);
				if ($VDIDL_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$DID_pattern =		$row[0];
					$DID_description =	$row[1];
					$DID_custom_one =	$row[2];
					$DID_custom_two=	$row[3];
					$DID_custom_three=	$row[4];
					$DID_custom_four=	$row[5];
					$DID_custom_five=	$row[6];
					}
				}

			### if web form is set then send on to vicidial.php for override of WEB_FORM address
			if ( (strlen($VDCL_group_web)>5) or (strlen($VDCL_group_name)>0) ) {echo "$VDCL_group_web|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|\n";}
			else {echo "X|$VDCL_group_name|$VDCL_group_color|$VDCL_fronter_display|$VDADchannel_group|$VDCL_ingroup_script|$VDCL_get_call_launch|$VDCL_xferconf_a_dtmf|$VDCL_xferconf_a_number|$VDCL_xferconf_b_dtmf|$VDCL_xferconf_b_number|$VDCL_default_xfer_group|$VDCL_ingroup_recording_override|$VDCL_ingroup_rec_filename|$VDCL_default_group_alias|$VDCL_caller_id_number|$VDCL_group_web_vars|$VDCL_group_web_two|$VDCL_timer_action|$VDCL_timer_action_message|$VDCL_timer_action_seconds|$VDCL_xferconf_c_number|$VDCL_xferconf_d_number|$VDCL_xferconf_e_number|$VDCL_uniqueid_status_display|$custom_call_id|$VDCL_uniqueid_status_prefix|$VDCL_timer_action_destination|$DID_id|$DID_extension|$DID_pattern|$DID_description|$INclosecallid|$INxfercallid|$VDCL_group_web_three|$VDCL_ingroup_script_color|\n";}

			$stmt = "SELECT full_name from vicidial_users where user='$tsr';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00476',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDU_cid_ct = mysqli_num_rows($rslt);
			if ($VDU_cid_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$fronter_full_name		= $row[0];
				echo $fronter_full_name . '|' . $tsr . "\n";
				}
			else {echo '|' . $tsr . "\n";}


			##### find if script contains recording fields
			$stmt="SELECT count(*) FROM vicidial_lists WHERE list_id='$list_id' and agent_script_override!='' and agent_script_override IS NOT NULL and agent_script_override!='NONE';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00477',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$vls_vc_ct = mysqli_num_rows($rslt);
			if ($vls_vc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					$script_recording_delay=0;
					##### find if script contains recording fields
					$stmt="SELECT count(*) FROM vicidial_scripts vs,vicidial_lists vls WHERE list_id='$list_id' and vs.script_id=vls.agent_script_override and script_text LIKE \"%--A--recording_%\";";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00478',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$vs_vc_ct = mysqli_num_rows($rslt);
					if ($vs_vc_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$script_recording_delay = $row[0];
						}
					}
				}

			$custom_field_names='|';
			$custom_field_names_SQL='';
			$custom_field_values='----------';
			$custom_field_types='|';
			### find the names of all custom fields, if any
			$stmt = "SELECT field_label,field_type FROM vicidial_lists_fields where list_id='$entry_list_id' and field_type NOT IN('SCRIPT','DISPLAY') and field_label NOT IN('entry_date','vendor_lead_code','source_id','list_id','gmt_offset_now','called_since_last_reset','phone_code','phone_number','title','first_name','middle_initial','last_name','address1','address2','address3','city','state','province','postal_code','country_code','gender','date_of_birth','alt_phone','email','security_phrase','comments','called_count','last_local_call_time','rank','owner') and field_label NOT LIKE \"%_DUPLICATE_%\";";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00479',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cffn_ct = mysqli_num_rows($rslt);
			$d=0;
			while ($cffn_ct > $d)
				{
				$row=mysqli_fetch_row($rslt);
				$custom_field_names .=	"$row[0]|";
				$custom_field_names_SQL .=	"$row[0],";
				$custom_field_types .=	"$row[1]|";
				$custom_field_values .=	"----------";
				$d++;
				}
			if ($cffn_ct > 0)
				{
				$custom_field_names_SQL = preg_replace("/.$/i","",$custom_field_names_SQL);
				### find the values of the named custom fields
				$stmt = "SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' limit 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00480',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cffv_ct = mysqli_num_rows($rslt);
				if ($cffv_ct > 0)
					{
					$custom_field_values='----------';
					$row=mysqli_fetch_row($rslt);
					$d=0;
					while ($cffn_ct > $d)
						{
						$custom_field_values .=	"$row[$d]----------";
						$d++;
						}
					$custom_field_values = preg_replace("/\n/"," ",$custom_field_values);
					$custom_field_values = preg_replace("/\r/","",$custom_field_values);
					}
				}

			if (strlen($phone_number) < 3) 
				{$phone_number = $original_phone_number;}
			else
				{
				if (strlen($alt_phone) < 3) 
					{$alt_phone = $original_phone_number;}
				else
					{
					if (strlen($address3) < 3) 
						{$address3 = $original_phone_number;}
					}
				}
			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);

			$LeaD_InfO =	$callerid . "\n";
			$LeaD_InfO .=	$lead_id . "\n";
			$LeaD_InfO .=	$dispo . "\n";
			$LeaD_InfO .=	$tsr . "\n";
			$LeaD_InfO .=	$vendor_id . "\n";
			$LeaD_InfO .=	$list_id . "\n";
			$LeaD_InfO .=	$gmt_offset_now . "\n";
			$LeaD_InfO .=	$phone_code . "\n";
			$LeaD_InfO .=	$phone_number . "\n";
			$LeaD_InfO .=	$title . "\n";
			$LeaD_InfO .=	$first_name . "\n";
			$LeaD_InfO .=	$middle_initial . "\n";
			$LeaD_InfO .=	$last_name . "\n";
			$LeaD_InfO .=	$address1 . "\n";
			$LeaD_InfO .=	$address2 . "\n";
			$LeaD_InfO .=	$address3 . "\n";
			$LeaD_InfO .=	$city . "\n";
			$LeaD_InfO .=	$state . "\n";
			$LeaD_InfO .=	$province . "\n";
			$LeaD_InfO .=	$postal_code . "\n";
			$LeaD_InfO .=	$country_code . "\n";
			$LeaD_InfO .=	$gender . "\n";
			$LeaD_InfO .=	$date_of_birth . "\n";
			$LeaD_InfO .=	$alt_phone . "\n";
			$LeaD_InfO .=	$email . "\n";
			$LeaD_InfO .=	$security_phrase . "\n";
			$LeaD_InfO .=	$comments . "\n";
			$LeaD_InfO .=	$called_count . "\n";
			$LeaD_InfO .=	$CBentry_time . "\n";
			$LeaD_InfO .=	$CBcallback_time . "\n";
			$LeaD_InfO .=	$CBuser . "\n";
			$LeaD_InfO .=	$CBcomments . "\n";
			$LeaD_InfO .=	$dialed_number . "\n";
			$LeaD_InfO .=	$dialed_label . "\n";
			$LeaD_InfO .=	$source_id . "\n";
			$LeaD_InfO .=	$alt_phone_code . "\n";
			$LeaD_InfO .=	$alt_phone_number . "\n";
			$LeaD_InfO .=	$alt_phone_note . "\n";
			$LeaD_InfO .=	$alt_phone_active . "\n";
			$LeaD_InfO .=	$alt_phone_count . "\n";
			$LeaD_InfO .=	$rank . "\n";
			$LeaD_InfO .=	$owner . "\n";
			$LeaD_InfO .=	$script_recording_delay . "\n";
			$LeaD_InfO .=	$entry_list_id . "\n";
			$LeaD_InfO .=	$custom_field_names . "\n";
			$LeaD_InfO .=	$custom_field_values . "\n";
			$LeaD_InfO .=	$custom_field_types . "\n";
			$LeaD_InfO .=   $LISTweb_form_address . "\n";
			$LeaD_InfO .=   $LISTweb_form_address_two . "\n";
			$LeaD_InfO .=   $ACcount . "\n";
			$LeaD_InfO .=   $ACcomments . "\n";
			$LeaD_InfO .=   $list_name . "\n";
			$LeaD_InfO .=   $LISTweb_form_address_three . "\n";
			$LeaD_InfO .=	$VDCL_ingroup_script_color . "\n";
			$LeaD_InfO .=	$list_description . "\n";
			$LeaD_InfO .=	$entry_date . "\n";
			$LeaD_InfO .=	$DID_custom_one . "\n";
			$LeaD_InfO .=	$DID_custom_two . "\n";
			$LeaD_InfO .=	$DID_custom_three . "\n";
			$LeaD_InfO .=	$DID_custom_four . "\n";
			$LeaD_InfO .=	$DID_custom_five . "\n";
			$LeaD_InfO .=	$status_group_gather_data . "\n";
			$LeaD_InfO .=	$call_date . "\n";

			echo $LeaD_InfO;


			$stmt="UPDATE vicidial_agent_log set lead_id='$lead_id' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00481',$user,$server_ip,$session_name,$one_mysql_log);}

			### If a scheduled callback, change vicidial_callback record to INACTIVE
			$CBstatus =			0;

			$stmt="SELECT count(*) FROM vicidial_statuses where status='$dispo' and scheduled_callback='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00482',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$cb_record_ct = mysqli_num_rows($rslt);
			if ($cb_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$CBstatus =		$row[0];
				}
			if ($CBstatus < 1)
				{
				$stmt="SELECT count(*) FROM vicidial_campaign_statuses where status='$dispo' and scheduled_callback='Y';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00483',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cb_record_ct = mysqli_num_rows($rslt);
				if ($cb_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$CBstatus =		$row[0];
					}
				}
			if ( ($CBstatus > 0) or (preg_match("/CALLBK|CBHOLD/i", $dispo)) )
				{
				$stmt="UPDATE vicidial_callbacks set status='INACTIVE' where lead_id='$lead_id' and status NOT IN('INACTIVE','DEAD','ARCHIVE');";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00484',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		else
			{
			echo "0\n";
		#	echo "No leads to update for $user on $server_ip\n";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		}
	$stage .= "|$lead_id|$agent_log_id|";
	}



################################################################################
### updateDISPO - update the vicidial_list table to reflect the agent choice of
###               call disposition for that lead
################################################################################
if ($ACTION == 'updateDISPO')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$MAN_vl_insert=0;
	if ( (strlen($dispo_choice)<1) || (strlen($lead_id)<1) )
		{
		echo _QXZ("Dispo Choice %1s or lead_id %2s is not valid",0,'',$dispo,$lead_id)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt = "SELECT dispo_call_url,queuemetrics_callstatus_override,comments_dispo_screen,comments_callback_screen,vc.campaign_id from vicidial_campaigns vc,vicidial_live_agents vla where vla.campaign_id=vc.campaign_id and vla.user='$user';";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00284',$user,$server_ip,$session_name,$one_mysql_log);}
		$VC_dcu_ct = mysqli_num_rows($rslt);
		if ($VC_dcu_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$dispo_call_url =						$row[0];
			$queuemetrics_callstatus_override =		$row[1];
			$comments_dispo_screen =				$row[2];
			$comments_callback_screen =				$row[3];
			$DUcampaign_id =						$row[4];
			$DUentry_type = 'campaign';
			}

		### reset the API fields in vicidial_live_agents record
		$stmt = "UPDATE vicidial_live_agents set lead_id=0,external_hangup=0,external_status='',external_update_fields='0',external_update_fields_data='',external_timer_action_seconds='-1',external_dtmf='',external_transferconf='',external_park='',external_recording='',last_state_change='$NOW_TIME',preview_lead_id='0' where user='$user' and server_ip='$server_ip';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00141',$user,$server_ip,$session_name,$one_mysql_log);}
		$retry_count=0;
		while ( ($errno > 0) and ($retry_count < 9) )
			{
			$rslt=mysql_to_mysqli($stmt, $link);
			$one_mysql_log=1;
			$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9141$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
			$one_mysql_log=0;
			$retry_count++;
			}

		if ($auto_dial_level < 1)
			{
			$stmt = "UPDATE vicidial_live_agents set status='PAUSED',callerid='' where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00285',$user,$server_ip,$session_name,$one_mysql_log);}
			}
		$commentsSQL='';
		if ( (strlen($dispo_comments)>0) and ( ($comments_dispo_screen == 'ENABLED') or ($comments_dispo_screen == 'REPLACE_CALL_NOTES') ) )
			{$commentsSQL = ",comments='" . mysqli_real_escape_string($link, $dispo_comments) . "'";}
		if ( (strlen($cbcomment_comments)>0) and ( ($comments_callback_screen == 'ENABLED') or ($comments_callback_screen == 'REPLACE_CB_NOTES') ) )
			{$commentsSQL = ",comments='" . mysqli_real_escape_string($link, $cbcomment_comments) . "'";}
		$stmt="UPDATE vicidial_list set status='$dispo_choice', user='$user' $commentsSQL where lead_id='$lead_id';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00142',$user,$server_ip,$session_name,$one_mysql_log);}

		//Added by Poundteam Incorporated for Audit Comments Package
		require_once('audit_comments.php');
		audit_comments($lead_id,$list_id,$format,$user,$mel,$NOW_TIME,$link,$server_ip,$session_name,$one_mysql_log,$campaign);

		// JOEJ - Email feature - may not be necessary if vicidial_email_list doesn't need a status column.
		if ($email_enabled>0) 
			{
			$stmt="UPDATE vicidial_email_list set status='$dispo_choice', user='$user' where lead_id='$lead_id' and uniqueid='$uniqueid';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00552',$user,$server_ip,$session_name,$one_mysql_log);}
			}

	#	$fp = fopen ("./vicidial_debug.txt", "a");
	#	fwrite ($fp, "$NOW_TIME|DISPO_CALL |$MDnextCID|$stage|$campaign|$lead_id|$dispo_choice|$user|$uniqueid|$auto_dial_level|$agent_log_id|\n");
	#	fclose($fp);
		$log_dispo_choice = $dispo_choice;
		if (strlen($CallBackLeadStatus) > 0) {$log_dispo_choice = $CallBackLeadStatus;}

		$term_reasonSQL = '';
		if ($parked_hangup=='1')
			{$term_reasonSQL = ",term_reason='CALLER'";}

		$stmt = "SELECT count(*) from vicidial_inbound_groups where group_id='$stage';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00143',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);
		if ($row[0] > 0)
			{
			$call_type='IN';
			$stmt = "UPDATE vicidial_closer_log set status='$log_dispo_choice' $term_reasonSQL where lead_id='$lead_id' and user='$user' order by closecallid desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00144',$user,$server_ip,$session_name,$one_mysql_log);}
			$VCLaffected_rows = mysqli_affected_rows($link);

	#		$fp = fopen ("./vicidial_debug.txt", "a");
	#		fwrite ($fp, "$NOW_TIME|DISPO_CALL2|$VCLaffected_rows|$stmt|\n");
	#		fclose($fp);

			$stmt = "UPDATE vicidial_live_inbound_agents set last_call_finish=NOW() where group_id='$stage' and user='$user' limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00553',$user,$server_ip,$session_name,$one_mysql_log);}

			$stmt = "SELECT dispo_call_url from vicidial_inbound_groups where group_id='$stage';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00286',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			if ($row[0] != 'CAMP')
				{
				$dispo_call_url = $row[0];
				$DUcampaign_id = $stage;
				$DUentry_type = 'ingroup';
				}
			}
		else
			{
			$call_type='OUT';
			$four_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-4,date("i"),date("s"),date("m"),date("d"),date("Y")));

			if ( ($auto_dial_level < 1) or (preg_match('/^M/',$MDnextCID)) )
				{
				$stmt = "SELECT count(*) from vicidial_log where lead_id='$lead_id' and call_date > \"$four_hours_ago\" and called_count='$called_count';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00213',$user,$server_ip,$session_name,$one_mysql_log);}
				$row=mysqli_fetch_row($rslt);
				if ($row[0] > 0)
					{
					$stmt="UPDATE vicidial_log set status='$log_dispo_choice',user='$user' $term_reasonSQL where lead_id='$lead_id' and call_date > \"$four_hours_ago\" and called_count='$called_count' order by uniqueid desc limit 1;";
						if ($format=='debug') {echo "\n<!-- $stmt -->";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00145',$user,$server_ip,$session_name,$one_mysql_log);}
					}
				else
					{
					$VLlist_id = '';   $VLphone_number = '';   $VLphone_code = '';   $user_group='';
					$stmt = "SELECT user_group FROM vicidial_users where user='$user';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00217',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VUinfo_ct = mysqli_num_rows($rslt);
					if ($VUinfo_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$user_group =		"$row[0]";
						}

					$stmt = "SELECT list_id,phone_number,phone_code,alt_phone,address3 FROM vicidial_list where lead_id='$lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00216',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$VLinfo_ct = mysqli_num_rows($rslt);
					if ($VLinfo_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$VLlist_id =		$row[0];
						if (strlen($phone_number)<6)
							{
							$VLphone_number =	$row[1];
							$VLalt =			'MAIN';
							$VLalt_phone =		$row[3];
							$VLaddress3 =		$row[4];
							}
						else
							{
							$VLphone_number =	"$phone_number";
							if ($phone_number == "$row[1]")
								{$VLalt =			'MAIN';}
							else
								{
								if ($phone_number != $VLalt_phone)
									{
									if ($phone_number != $VLaddress3)
										{
										$VLalt = 'X1';
										$stmt = "SELECT alt_phone_count from vicidial_list_alt_phones where lead_id='$lead_id' and phone_number = '$dialed_number' order by alt_phone_count limit 1;";
										if ($DB) {echo "$stmt\n";}
										$rslt=mysql_to_mysqli($stmt, $link);
											if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00250',$user,$server_ip,$session_name,$one_mysql_log);}
										$VDAP_cid_ct = mysqli_num_rows($rslt);
										if ($VDAP_cid_ct > 0)
											{
											$row=mysqli_fetch_row($rslt);
											$Xalt_phone_count	=$row[0];

											$stmt = "SELECT count(*) from vicidial_list_alt_phones where lead_id='$lead_id';";
											if ($DB) {echo "$stmt\n";}
											$rslt=mysql_to_mysqli($stmt, $link);
												if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00251',$user,$server_ip,$session_name,$one_mysql_log);}
											$VDAPct_cid_ct = mysqli_num_rows($rslt);
											if ($VDAPct_cid_ct > 0)
												{
												$row=mysqli_fetch_row($rslt);
												$COUNTalt_phone_count	=$row[0];

												if ($COUNTalt_phone_count <= $Xalt_phone_count)
													{$VLalt = 'XLAST';}
												else
													{$VLalt = "X$Xalt_phone_count";}
												}

											}
										}
									else
										{$VLalt =			'ADDR3';}
									}
								else
									{$VLalt =			'ALT';}
								}
							}
						if (strlen($phone_code)<1)
							{$VLphone_code =	"$row[2]";}
						else
							{$VLphone_code =	"$phone_code";}
						}

					$PADlead_id = sprintf("%010s", $lead_id);
						while (strlen($PADlead_id) > 9) {$PADlead_id = substr("$PADlead_id", 1);}
					$FAKEcall_id = "$StarTtime.$PADlead_id";
					$stmt = "INSERT INTO vicidial_log set uniqueid='$FAKEcall_id',lead_id='$lead_id',list_id='$VLlist_id',campaign_id='$campaign',call_date='$NOW_TIME',start_epoch='$StarTtime',end_epoch='$StarTtime',length_in_sec='0',status='$log_dispo_choice',phone_code='$VLphone_code',phone_number='$VLphone_number',user='$user',comments='MANUAL',processed='N',user_group='$user_group',term_reason='AGENT',alt_dial='$VLalt',called_count='$called_count';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00215',$user,$server_ip,$session_name,$one_mysql_log);}

					##### insert log into vicidial_log_extended for manual VICIDiaL call
					$stmt="INSERT IGNORE INTO vicidial_log_extended SET uniqueid='$FAKEcall_id',server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID',custom_call_id='' ON DUPLICATE KEY UPDATE server_ip='$server_ip',call_date='$NOW_TIME',lead_id='$lead_id',caller_code='$MDnextCID';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00402',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rowsX = mysqli_affected_rows($link);

					$MAN_vl_insert++;
					}

				$stmt="DELETE FROM vicidial_auto_calls where callerid='$MDnextCID';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00219',$user,$server_ip,$session_name,$one_mysql_log);}

				$stmt="UPDATE vicidial_live_agents set ring_callerid='' where ring_callerid='$MDnextCID';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00403',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			else
				{
				$stmt="UPDATE vicidial_log set status='$log_dispo_choice' $term_reasonSQL where lead_id='$lead_id' and user='$user' and call_date > \"$four_hours_ago\" order by uniqueid desc limit 1;";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00145',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}

		### find all DNC-type statuses in the system
		if ( ($use_internal_dnc=='Y') or ($use_campaign_dnc=='Y') or ($use_internal_dnc=='AREACODE') or ($use_campaign_dnc=='AREACODE') )
			{
			$DNC_string_check = '|';
			$stmt = "SELECT status FROM vicidial_statuses where dnc='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00195',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$dncvs_ct = mysqli_num_rows($rslt);
			$i=0;
			while ($i < $dncvs_ct)
				{
				$row=mysqli_fetch_row($rslt);
				$DNC_string_check .= "$row[0]|";
				$i++;
				}

			$stmt = "SELECT status FROM vicidial_campaign_statuses where dnc='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00196',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$dncvcs_ct = mysqli_num_rows($rslt);
			$i=0;
			while ($i < $dncvcs_ct)
				{
				$row=mysqli_fetch_row($rslt);
				$DNC_string_check .= "$row[0]|";
				$i++;
				}

		#	echo "$DNC_string_check";
			}

		$insert_into_dnc=0;
		if ( ( ($use_internal_dnc=='Y') or ($use_internal_dnc=='AREACODE') ) and (preg_match("/\|$log_dispo_choice\|/i", $DNC_string_check) ) )
			{
			$stmt = "SELECT phone_number from vicidial_list where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00146',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$stmt="INSERT IGNORE INTO vicidial_dnc (phone_number) values('$row[0]');";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00147',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$insert_into_dnc++;
			$stmt="INSERT INTO vicidial_dnc_log SET phone_number='$row[0]', campaign_id='-SYSINT-', action='add', action_date=NOW(), user='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00632',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			}
		if ( ( ($use_campaign_dnc=='Y') or ($use_campaign_dnc=='AREACODE') ) and (preg_match("/\|$log_dispo_choice\|/i", $DNC_string_check) ) )
			{
			$stmt="SELECT use_other_campaign_dnc from vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00446',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$use_other_campaign_dnc =	$row[0];
			$temp_campaign_id = $campaign;
			if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}

			$stmt = "SELECT phone_number from vicidial_list where lead_id='$lead_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00148',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$stmt="INSERT IGNORE INTO vicidial_campaign_dnc (phone_number,campaign_id) values('$row[0]','$temp_campaign_id');";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00149',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$insert_into_dnc++;
			$stmt="INSERT INTO vicidial_dnc_log SET phone_number='$row[0]', campaign_id='$temp_campaign_id', action='add', action_date=NOW(), user='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00633',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			}
		}

	$dispo_sec=0;
	$dispo_epochSQL='';
	$lead_id_commentsSQL='';
	$StarTtime = date("U");
	$stmt = "SELECT dispo_epoch,dispo_sec,talk_epoch,wait_epoch,lead_id,comments,agent_log_id from vicidial_agent_log where agent_log_id <='$agent_log_id' and lead_id='$lead_id' order by agent_log_id desc limit 1;";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00150',$user,$server_ip,$session_name,$one_mysql_log);}
	$VDpr_ct = mysqli_num_rows($rslt);
	if ($VDpr_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$agent_log_id = $row[6];
		if ( (preg_match("/NULL/i",$row[2])) or ($row[2] < 1000) )
			{
			$row[2]=$StarTtime;
			$wait_sec=($row[2] - $row[3]);
			$dispo_epochSQL = ",talk_epoch='$row[2]',wait_sec='$wait_sec'";
			}
		if ( (preg_match("/NULL/i",$row[0])) or ($row[0] < 1000) )
			{
			$dispo_epochSQL .= ",dispo_epoch='$StarTtime'";
			$row[0]=$row[2];
			}
		$dispo_sec = (($StarTtime - $row[0]) + $row[1]);
		if ( (preg_match('/^M/',$MDnextCID)) and (preg_match('/INBOUND_MAN/',$dial_method)) )
			{
			if ( (preg_match("/NULL/i",$row[5])) or (strlen($row[5]) < 1) )
				{
				$lead_id_commentsSQL .= ",comments='MANUAL'";
				}
			if ( (preg_match("/NULL/i",$row[4])) or ($row[4] < 1) or (strlen($row[4]) < 1) )
				{
				$lead_id_commentsSQL .= ",lead_id='$lead_id'";
				}
			}
		}
	$stmt="UPDATE vicidial_agent_log set dispo_sec='$dispo_sec',status='$log_dispo_choice',uniqueid='$uniqueid' $dispo_epochSQL $lead_id_commentsSQL where agent_log_id='$agent_log_id';";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00151',$user,$server_ip,$session_name,$one_mysql_log);}

	$stmt="UPDATE vicidial_campaigns set campaign_calldate='$NOW_TIME' where campaign_id='$campaign';";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00272',$user,$server_ip,$session_name,$one_mysql_log);}

	$user_group='';
	$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00152',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($DB) {echo "$stmt\n";}
	$ug_record_ct = mysqli_num_rows($rslt);
	if ($ug_record_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$user_group =		trim("$row[0]");
		}
	$CALL_agent_log_id = $agent_log_id;

	if ($auto_dial_level < 1)
		{
		$MAN_insert_leadIDsql='';
		if ($MAN_vl_insert > 0)
			{$MAN_insert_leadIDsql = ",lead_id='$lead_id'";}
		$stmt="INSERT INTO vicidial_agent_log SET user='$user',server_ip='$server_ip',event_time='$NOW_TIME',campaign_id='$campaign',pause_epoch='$StarTtime',pause_sec='0',wait_epoch='$StarTtime',user_group='$user_group',pause_type='AGENT'$MAN_insert_leadIDsql;";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00153',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($link);
		$agent_log_id = mysqli_insert_id($link);

		$stmt="UPDATE vicidial_live_agents SET agent_log_id='$agent_log_id' where user='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00220',$VD_login,$server_ip,$session_name,$one_mysql_log);}
		$VLAaffected_rows_update = mysqli_affected_rows($link);
		}

	### CALLBACK ENTRY
	if ( ($dispo_choice == 'CBHOLD') and (strlen($CallBackDatETimE)>10) )
		{
		$comments = preg_replace('/"/i','',$comments);
		$comments = preg_replace("/'/i",'',$comments);
		$comments = preg_replace('/;/i','',$comments);
		$comments = preg_replace("/\\\\/i",' ',$comments);
		$stmt="INSERT INTO vicidial_callbacks (lead_id,list_id,campaign_id,status,entry_time,callback_time,user,recipient,comments,user_group,lead_status) values('$lead_id','$list_id','$campaign','ACTIVE','$NOW_TIME','$CallBackDatETimE','$user','$recipient','$comments','$user_group','$CallBackLeadStatus');";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00154',$user,$server_ip,$session_name,$one_mysql_log);}
		}

	### BEGIN Call Notes Logging ###
	if (strlen($call_notes) > 1)
		{
		$VDADchannel_group=$campaign;
		$stmt = "SELECT campaign_id,closecallid from vicidial_closer_log where uniqueid='$uniqueid' and user='$user' order by closecallid desc limit 1;";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00372',$user,$server_ip,$session_name,$one_mysql_log);}
		$VDCL_cn_ct = mysqli_num_rows($rslt);
		if ($VDCL_cn_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$VDADchannel_group =	$row[0];
			$vicidial_id =			$row[1];
			}
		else
			{$vicidial_id = $uniqueid;}
		if (strlen($vicidial_id)<6)
			{
			if (strlen($FAKEcall_id)<7)
				{
				$stmt = "SELECT uniqueid from vicidial_log_extended where caller_code='$MDnextCID' order by call_date desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00597',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDCL_cn_ct = mysqli_num_rows($rslt);
				if ($VDCL_cn_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$FAKEcall_id =	$row[0];
					}
				}
			if (strlen($FAKEcall_id)>6)
				{$vicidial_id = $FAKEcall_id;}
			}
		# Insert into vicidial_call_notes
		$stmt="INSERT INTO vicidial_call_notes set lead_id='$lead_id',vicidial_id='$vicidial_id',call_date='$NOW_TIME',call_notes='" . mysqli_real_escape_string($link, $call_notes) . "';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00373',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($link);
		$notesid = mysqli_insert_id($link);
		}
	### END Call Notes Logging ###

	$stmt="SELECT auto_alt_dial_statuses,use_internal_dnc,use_campaign_dnc,api_manual_dial,use_other_campaign_dnc from vicidial_campaigns where campaign_id='$campaign';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00155',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$VC_auto_alt_dial_statuses =	$row[0];
	$use_internal_dnc =				$row[1];
	$use_campaign_dnc =				$row[2];
	$api_manual_dial =				$row[3];
	$use_other_campaign_dnc =		$row[4];

	if ( ($auto_dial_level > 0) and (preg_match("/\s$dispo_choice\s/",$VC_auto_alt_dial_statuses)) )
		{
		$stmt = "SELECT count(*) from vicidial_hopper where lead_id='$lead_id' and status='HOLD';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00156',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);

		if ($row[0] > 0)
			{
			##### Check for alt phone number in DNC list if applicable
			$UD_DNC_campaign=0;
			$UD_DNC_internal=0;
			$vh_phone='';
			$stmt="SELECT phone_number FROM vicidial_list where lead_id='$lead_id';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00267',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ud_record_ct = mysqli_num_rows($rslt);
			if ($ud_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$vh_phone =		$row[0];
				}

			if ( (preg_match("/Y/",$use_internal_dnc)) or (preg_match("/AREACODE/",$use_internal_dnc)) )
				{
				if (preg_match("/AREACODE/",$use_internal_dnc))
					{
					$vhp_phone_areacode = substr($vh_phone, 0, 3);
					$vhp_phone_areacode .= "XXXXXXX";
					$stmtA="SELECT count(*) from vicidial_dnc where phone_number IN('$vh_phone','$vhp_phone_areacode');";
					}
				else
					{$stmtA="SELECT count(*) FROM vicidial_dnc where phone_number='$vh_phone';";}
				$rslt=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00268',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$ud_record_ct = mysqli_num_rows($rslt);
				if ($ud_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$UD_DNC_internal =		$row[0];
					}
				}

			if ( (preg_match("/Y/",$use_campaign_dnc)) or (preg_match("/AREACODE/",$use_campaign_dnc)) )
				{
				$temp_campaign_id = $campaign;
				if (strlen($use_other_campaign_dnc) > 0) {$temp_campaign_id = $use_other_campaign_dnc;}
				if (preg_match("/AREACODE/",$use_campaign_dnc))
					{
					$vhp_phone_areacode = substr($vh_phone, 0, 3);
					$vhp_phone_areacode .= "XXXXXXX";
					$stmtA="SELECT count(*) from vicidial_campaign_dnc where phone_number IN('$vh_phone','$vhp_phone_areacode') and campaign_id='$temp_campaign_id';";
					}
				else
					{$stmtA="SELECT count(*) FROM vicidial_campaign_dnc where phone_number='$vh_phone' and campaign_id='$temp_campaign_id';";}
				$rslt=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00269',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$ud_record_ct = mysqli_num_rows($rslt);
				if ($ud_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$UD_DNC_campaign =		$row[0];
					}
				}

			if ( ($UD_DNC_campaign > 0) or ($UD_DNC_internal > 0) ) 
				{
				if ( ( (preg_match("/\sDNCC\s/",$VC_auto_alt_dial_statuses)) and ($UD_DNC_campaign > 0) ) or ( (preg_match("/\sDNCL\s/",$VC_auto_alt_dial_statuses)) and ($UD_DNC_internal > 0) ) )
					{
					$stmt="UPDATE vicidial_hopper set status='DNC' where lead_id='$lead_id' and status='HOLD' limit 1;";
						if ($format=='debug') {echo "\n<!-- $stmt -->";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00157',$user,$server_ip,$session_name,$one_mysql_log);}
					}
				}
			else
				{
				$stmt="UPDATE vicidial_hopper set status='READY' where lead_id='$lead_id' and status='HOLD' limit 1;";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00554',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		}
	else
		{
		$stmt="DELETE from vicidial_hopper where lead_id='$lead_id' and status='HOLD';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00158',$user,$server_ip,$session_name,$one_mysql_log);}
		}
	if ( ($api_manual_dial=='QUEUE') or ($api_manual_dial=='QUEUE_AND_AUTOCALL') )
		{
		$stmt="DELETE from vicidial_manual_dial_queue where user='$user' and status='QUEUE';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00363',$user,$server_ip,$session_name,$one_mysql_log);}
		}

	####### START Vtiger Call Logging #######
	$stmt = "SELECT enable_vtiger_integration,vtiger_server_ip,vtiger_dbname,vtiger_login,vtiger_pass,vtiger_url FROM system_settings;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00197',$user,$server_ip,$session_name,$one_mysql_log);}
	$ss_conf_ct = mysqli_num_rows($rslt);
	if ($ss_conf_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$enable_vtiger_integration =	$row[0];
		$vtiger_server_ip	=			$row[1];
		$vtiger_dbname =				$row[2];
		$vtiger_login =					$row[3];
		$vtiger_pass =					$row[4];
		$vtiger_url =					$row[5];
		}

	if ($enable_vtiger_integration > 0)
		{
		$stmt = "SELECT vtiger_search_category,vtiger_create_call_record,vtiger_create_lead_record,vtiger_search_dead,vtiger_status_call FROM vicidial_campaigns where campaign_id='$campaign';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00198',$user,$server_ip,$session_name,$one_mysql_log);}
		$vtc_conf_ct = mysqli_num_rows($rslt);
		if ($vtc_conf_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$vtiger_search_category =		$row[0];
			$vtiger_create_call_record =	$row[1];
			$vtiger_create_lead_record =	$row[2];
			$vtiger_search_dead =			$row[3];
			$vtiger_status_call =			$row[4];
			}
		if ( (preg_match('/ACCTID/',$vtiger_search_category)) or (preg_match('/ACCOUNT/',$vtiger_search_category)) )
			{
			### find the full status name for this status
			$stmt = "SELECT status_name from vicidial_statuses where status='$dispo_choice';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00211',$user,$server_ip,$session_name,$one_mysql_log);}
			$vs_ct = mysqli_num_rows($rslt);
			if ($vs_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$status_name =		$row[0];
				}
			else
				{
				$stmt = "SELECT status_name from vicidial_campaign_statuses where status='$dispo_choice' and campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00212',$user,$server_ip,$session_name,$one_mysql_log);}
				$vs_ct = mysqli_num_rows($rslt);
				if ($vs_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$status_name =		$row[0];
					}
				}
			if (strlen($status_name) < 1) {$status_name = $dispo_choice;}

			### connect to your vtiger database
			$linkV=mysqli_connect("$vtiger_server_ip", "$vtiger_login","$vtiger_pass", "$vtiger_dbname");
			if (!$linkV) {die("Could not connect: $vtiger_server_ip|$vtiger_dbname|$vtiger_login|$vtiger_pass" . mysqli_connect_error());}

			$stmt = "SELECT vendor_lead_code FROM vicidial_list where lead_id='$lead_id';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00210',$user,$server_ip,$session_name,$one_mysql_log);}
			$vlc_ct = mysqli_num_rows($rslt);
			if ($vlc_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$vendor_id =		$row[0];
				}

			# make sure the ID is present in Vtiger database as an account
			$stmt="SELECT count(*) from vtiger_account where accountid='$vendor_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $linkV);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00199',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$VIDcount = $row[0];
			if ($VIDcount > 0)
				{
				### create a call record in vtiger linked to the account
				if (preg_match('/DISPO/',$vtiger_create_call_record))
					{
					$TODAY = date("Y-m-d");
					$HHMMnow = date("H:i");
					$minute_old = mktime(date("H"), date("i")+5, date("s"), date("m"), date("d"),  date("Y"));
					$HHMMend = date("H:i",$minute_old);

					#Get logged in user ID
					$stmt="SELECT id from vtiger_users where user_name='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkV);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00200',$user,$server_ip,$session_name,$one_mysql_log);}
					$row=mysqli_fetch_row($rslt);
					$user_id = $row[0];

					## if numbered callback activity record, alter existing record
					$vtiger_callback_modified=0;
					if ($vtiger_callback_id > 0)
						{
						# make sure the ID is present in Vtiger database as an account
						$stmt="SELECT count(*) from vtiger_seactivityrel where activityid='$vtiger_callback_id';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00555',$user,$server_ip,$session_name,$one_mysql_log);}
						$vt_act_ct = mysqli_num_rows($rslt);
						if ($vt_act_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$activity_check = $row[0];
							}
						if ($activity_check > 0)
							{
							$act_description='';
							$stmt="SELECT description from vtiger_crmentity where crmid='$vtiger_callback_id';";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $linkV);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00214',$user,$server_ip,$session_name,$one_mysql_log);}
							$vt_actd_ct = mysqli_num_rows($rslt);
							if ($vt_actd_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$act_description = $row[0];
								}
							$act_subject='';
							$stmt="SELECT subject from vtiger_activity where activityid='$vtiger_callback_id';";
							if ($DB) {echo "$stmt\n";}
							$rslt=mysql_to_mysqli($stmt, $linkV);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00556',$user,$server_ip,$session_name,$one_mysql_log);}
							$vt_actd_ct = mysqli_num_rows($rslt);
							if ($vt_actd_ct > 0)
								{
								$row=mysqli_fetch_row($rslt);
								$act_subject = $row[0];
								}

							$stmt = "UPDATE vtiger_crmentity SET modifiedby='$user_id', description='$act_description - VICIDIAL Call user $user',modifiedtime='$NOW_TIME',viewedtime='$NOW_TIME' where crmid='$vtiger_callback_id';";
							if ($DB) {echo "|$stmt|\n";}
							$rslt=mysql_to_mysqli($stmt, $linkV);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00557',$user,$server_ip,$session_name,$one_mysql_log);}
							$stmt = "UPDATE vtiger_activity SET subject='VC Call: $status_name - $act_subject',date_start='$TODAY',time_start='$HHMMnow',time_end='$HHMMend',eventstatus='Held' where activityid='$vtiger_callback_id';";
							if ($DB) {echo "|$stmt|\n";}
							$rslt=mysql_to_mysqli($stmt, $linkV);
								if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00558',$user,$server_ip,$session_name,$one_mysql_log);}
							$vtiger_callback_modified=1;
							}
						}

					## create new activity record
					if ($vtiger_callback_modified < 1)
						{
						# Get next aviable id from vtiger_crmentity_seq to use as activityid in vtiger_crmentity	
						$stmt="SELECT id from vtiger_crmentity_seq ;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00201',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$activityid = ($row[0] + 1);

						# Increase next aviable crmid with 1 so next record gets proper id
						$stmt="UPDATE vtiger_crmentity_seq SET id = '$activityid';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00202',$user,$server_ip,$session_name,$one_mysql_log);}
						
						#Insert values into vtiger_salesmanactivityrel
						$stmt = "INSERT INTO vtiger_salesmanactivityrel SET smid='$user_id',activityid='$activityid';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00203',$user,$server_ip,$session_name,$one_mysql_log);}
						
						#Insert values into vtiger_seactivityrel
						$stmt = "INSERT INTO vtiger_seactivityrel SET crmid='$vendor_id',activityid='$activityid';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00204',$user,$server_ip,$session_name,$one_mysql_log);}
						
						#Insert values into vtiger_crmentity
						$stmt = "INSERT INTO vtiger_crmentity (crmid, smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime, viewedtime, status, version, presence, deleted) VALUES ('$activityid', '$user_id', '$user_id','$user_id', 'Calendar', 'VICIDIAL Call user $user', '$NOW_TIME', '$NOW_TIME', '$NOW_TIME', NULL, '0', '1', '0');";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00205',$user,$server_ip,$session_name,$one_mysql_log);}

						#Insert values into vtiger_activity
						$stmt = "INSERT INTO vtiger_activity SET activityid='$activityid',subject='VC Call: $status_name',activitytype='Call',date_start='$TODAY',due_date='$TODAY',time_start='$HHMMnow',time_end='$HHMMend',sendnotification='0',duration_hours='0',duration_minutes='1',status='',eventstatus='Held',priority='Medium',location='VICIDIAL User $user',notime='0',visibility='Public',recurringtype='--None--';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00206',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "|$leadid|\n";}
						}
					}
				### update the status of the record in vtiger
				if (preg_match('/Y/',$vtiger_status_call))
					{
					#Get logged in user ID
					$stmt="SELECT id from vtiger_users where user_name='$user';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkV);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00207',$user,$server_ip,$session_name,$one_mysql_log);}
					$row=mysqli_fetch_row($rslt);
					$user_id = $row[0];

					#Update vtiger_crmentity
					$stmt = "UPDATE vtiger_crmentity SET modifiedby='$user_id', modifiedtime='$NOW_TIME' where crmid='$vendor_id';";
					if ($DB) {echo "|$stmt|\n";}
					$rslt=mysql_to_mysqli($stmt, $linkV);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00208',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "|$leadid|\n";}

					if ($insert_into_dnc > 0) {$emailoptoutSQL = ", emailoptout='1'";}
					#Update vtiger_account   dnc=emailoptout
					$stmt = "UPDATE vtiger_account SET siccode='$status_name' $emailoptoutSQL where accountid='$vendor_id';";
					if ($DB) {echo "|$stmt|\n";}
					$rslt=mysql_to_mysqli($stmt, $linkV);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00209',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "|$leadid|\n";}


					### check and see if the custom date fields exist, if they do then update them if necessary
					# Date of Last Attempt, Date of Last Non-Contact, Date of Last Contact, Date of Last Sale

					# first find the sale statuses that are in the system
					$SALE_string_check = '|';
					$stmt = "SELECT status FROM vicidial_statuses where sale='Y';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00559',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$salevs_ct = mysqli_num_rows($rslt);
					$i=0;
					while ($i < $salevs_ct)
						{
						$row=mysqli_fetch_row($rslt);
						$SALE_string_check .= "$row[0]|";
						$i++;
						}
					$stmt = "SELECT status FROM vicidial_campaign_statuses where sale='Y';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00560',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$salevcs_ct = mysqli_num_rows($rslt);
					$i=0;
					while ($i < $salevcs_ct)
						{
						$row=mysqli_fetch_row($rslt);
						$SALE_string_check .= "$row[0]|";
						$i++;
						}

					# second find the customer contact statuses that are in the system
					$CC_string_check = '|';
					$stmt = "SELECT status FROM vicidial_statuses where customer_contact='Y';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00561',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cc_vs_ct = mysqli_num_rows($rslt);
					$i=0;
					while ($i < $cc_vs_ct)
						{
						$row=mysqli_fetch_row($rslt);
						$CC_string_check .= "$row[0]|";
						$i++;
						}
					$stmt = "SELECT status FROM vicidial_campaign_statuses where customer_contact='Y';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00287',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$cc_vcs_ct = mysqli_num_rows($rslt);
					$i=0;
					while ($i < $cc_vcs_ct)
						{
						$row=mysqli_fetch_row($rslt);
						$CC_string_check .= "$row[0]|";
						$i++;
						}

					# third calculate what custom date fields need their date updated
					$VT_last_noncontact_update=0;	$VT_last_noncontact_ct=0;
					$VT_last_contact_update=0;		$VT_last_contact_ct=0;
					$VT_last_sale_update=0;			$VT_last_sale_ct=0;
					if (preg_match("/\|$dispo_choice\|/i", $SALE_string_check) )
						{$VT_last_sale_update++;}
					if (preg_match("/\|$dispo_choice\|/i", $CC_string_check) )
						{$VT_last_contact_update++;}
					else
						{$VT_last_noncontact_update++;}

					# fourth see if the vtiger database has the custom date fields in it
					$stmt="SELECT count(*) from vtiger_field where fieldlabel='Date of Last Attempt';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkV);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00562',$user,$server_ip,$session_name,$one_mysql_log);}
					$row=mysqli_fetch_row($rslt);
					$VT_last_attempt_ct = $row[0];

					if ($VT_last_noncontact_update > 0)
						{
						$stmt="SELECT count(*) from vtiger_field where fieldlabel='Date of Last Non-Contact';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00563',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_noncontact_ct = $row[0];
						}
					if ($VT_last_contact_update > 0)
						{
						$stmt="SELECT count(*) from vtiger_field where fieldlabel='Date of Last Contact';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00564',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_contact_ct = $row[0];
						}
					if ($VT_last_sale_update > 0)
						{
						$stmt="SELECT count(*) from vtiger_field where fieldlabel='Date of Last Sale';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00218',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_sale_ct = $row[0];
						}

					# fifth find the fieldnames if they exist and update the dates
					if ($VT_last_attempt_ct > 0)
						{
						$stmt="SELECT fieldname from vtiger_field where fieldlabel='Date of Last Attempt';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00565',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_attempt_field = $row[0];

						$stmt = "UPDATE vtiger_accountscf SET $VT_last_attempt_field='$TODAY' where accountid='$vendor_id';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00566',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					if ($VT_last_noncontact_ct > 0)
						{
						$stmt="SELECT fieldname from vtiger_field where fieldlabel='Date of Last Non-Contact';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00567',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_noncontact_field = $row[0];

						$stmt = "UPDATE vtiger_accountscf SET $VT_last_noncontact_field='$TODAY' where accountid='$vendor_id';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00568',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					if ($VT_last_contact_ct > 0)
						{
						$stmt="SELECT fieldname from vtiger_field where fieldlabel='Date of Last Contact';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00221',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_contact_field = $row[0];

						$stmt = "UPDATE vtiger_accountscf SET $VT_last_contact_field='$TODAY' where accountid='$vendor_id';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00225',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					if ($VT_last_sale_ct > 0)
						{
						$stmt="SELECT fieldname from vtiger_field where fieldlabel='Date of Last Sale';";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00569',$user,$server_ip,$session_name,$one_mysql_log);}
						$row=mysqli_fetch_row($rslt);
						$VT_last_sale_field = $row[0];

						$stmt = "UPDATE vtiger_accountscf SET $VT_last_sale_field='$TODAY' where accountid='$vendor_id';";
						if ($DB) {echo "|$stmt|\n";}
						$rslt=mysql_to_mysqli($stmt, $linkV);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkV,$mel,$stmt,'00226',$user,$server_ip,$session_name,$one_mysql_log);}
						}
					}
				}
			}
		}
	####### END Vtiger Call Logging #######

	#############################################
	##### START QUEUEMETRICS LOGGING LOOKUP #####
	$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_callstatus,queuemetrics_dispo_pause,queuemetrics_pe_phone_append,queuemetrics_socket,queuemetrics_socket_url FROM system_settings;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00159',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($DB) {echo "$stmt\n";}
	$qm_conf_ct = mysqli_num_rows($rslt);
	if ($qm_conf_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$enable_queuemetrics_logging =	$row[0];
		$queuemetrics_server_ip	=		$row[1];
		$queuemetrics_dbname =			$row[2];
		$queuemetrics_login	=			$row[3];
		$queuemetrics_pass =			$row[4];
		$queuemetrics_log_id =			$row[5];
		$queuemetrics_callstatus =		$row[6];
		$queuemetrics_dispo_pause =		$row[7];
		$queuemetrics_pe_phone_append = $row[8];
		$queuemetrics_socket =			$row[9];
		$queuemetrics_socket_url =		$row[10];
		}
	##### END QUEUEMETRICS LOGGING LOOKUP #####
	###########################################
	if ( ($enable_queuemetrics_logging > 0) and ( ( ($queuemetrics_callstatus > 0) or ($queuemetrics_callstatus_override=='YES') ) and ($queuemetrics_callstatus_override!='NO') ) )
		{
		$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
		if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
		mysqli_select_db($linkB, "$queuemetrics_dbname");

		if (strlen($stage) < 2) 
			{$stage = $campaign;}
		$qm_dispo_codeSQL='';
		if (strlen($qm_dispo_code) > 0)
			{$qm_dispo_codeSQL = ",data3='$qm_dispo_code'";}
		$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$MDnextCID',queue='$stage',agent='Agent/$user',verb='CALLSTATUS',data1='$log_dispo_choice',serverid='$queuemetrics_log_id' $qm_dispo_codeSQL;";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $linkB);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00160',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($linkB);

		### check to make sure a COMPLETE record is present for this call
		$QLcomplete_records=0;
		$stmt = "SELECT count(*) FROM queue_log where verb IN('COMPLETEAGENT','COMPLETECALLER') and call_id='$MDnextCID' and agent='Agent/$user' and queue='$stage';";
		$rslt=mysql_to_mysqli($stmt, $linkB);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00409',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$comp_ct = mysqli_num_rows($rslt);
		if ($comp_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$QLcomplete_records =	$row[0];
			}

		### if there are no complete records, look up information to insert one for this call
		if ($QLcomplete_records < 1)
			{
			$QLconnect_time=$StarTtime;
			$QLcomplete_time=$StarTtime;
			$QLconnect_one='';
			$QLconnect_four='';
			$QLcomplete_position=1;

			$stmt = "SELECT time_id,data1,data4 FROM queue_log where verb='CONNECT' and call_id='$MDnextCID' and agent='Agent/$user' and queue='$stage' order by time_id desc limit 1;";
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00410',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$connect_ct = mysqli_num_rows($rslt);
			if ($connect_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$QLconnect_time =	$row[0];
				$QLconnect_one =	$row[1];
				$QLconnect_four =	$row[2];
				}

			$stmt = "SELECT time_id FROM queue_log where verb='PAUSEREASON' and call_id='$MDnextCID' and agent='Agent/$user' and data1='$queuemetrics_dispo_pause' order by time_id desc limit 1;";
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00411',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$pausereason_ct = mysqli_num_rows($rslt);
			if ($pausereason_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$QLcomplete_time =	$row[0];
				}

			$QLcomplete_length = ($QLcomplete_time - $QLconnect_time);
			if ($QLcomplete_length < 0) {$QLcomplete_length=0;}
			if ($QLcomplete_length > 86400) {$QLcomplete_length=1;}

			## if inbound, check for initial queue position
			if (preg_match("/^Y/",$MDnextCID))
				{
				$four_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-4,date("i"),date("s"),date("m"),date("d"),date("Y")));

				$stmt = "SELECT queue_position FROM vicidial_closer_log where lead_id='$lead_id' and campaign_id='$stage' and call_date > \"$four_hours_ago\" order by closecallid desc limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00412',$user,$server_ip,$session_name,$one_mysql_log);}
				$vcl_ct = mysqli_num_rows($rslt);
				if ($vcl_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$QLcomplete_position =		$row[0];
					}
				}

			$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$QLcomplete_time',call_id='$MDnextCID',queue='$stage',agent='Agent/$user',verb='COMPLETEAGENT',data1='$QLconnect_one',data2='$QLcomplete_length',data3='$QLcomplete_position',serverid='$queuemetrics_log_id',data4='$QLconnect_four';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $linkB);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00413',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($linkB);

			if ( ($queuemetrics_socket == 'CONNECT_COMPLETE') and (strlen($queuemetrics_socket_url) > 10) )
				{
				if (preg_match("/--A--/",$queuemetrics_socket_url))
					{
					##### grab the data from vicidial_list for the lead_id
					$stmt="SELECT vendor_lead_code,list_id,phone_code,phone_number,title,first_name,middle_initial,last_name,postal_code FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00543',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$list_lead_ct = mysqli_num_rows($rslt);
					if ($list_lead_ct > 0)
						{
						$row=mysqli_fetch_row($rslt);
						$vendor_id		= urlencode(trim($row[0]));
						$list_id		= urlencode(trim($row[1]));
						$phone_code		= urlencode(trim($row[2]));
						$phone_number	= urlencode(trim($row[3]));
						$title			= urlencode(trim($row[4]));
						$first_name		= urlencode(trim($row[5]));
						$middle_initial	= urlencode(trim($row[6]));
						$last_name		= urlencode(trim($row[7]));
						$postal_code	= urlencode(trim($row[8]));
						}
					$queuemetrics_socket_url = preg_replace('/^VAR/','',$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--lead_id--B--/i',"$lead_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--list_id--B--/i',"$list_id",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--phone_number--B--/i',"$phone_number",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--title--B--/i',"$title",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--first_name--B--/i',"$first_name",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--last_name--B--/i',"$last_name",$queuemetrics_socket_url);
					$queuemetrics_socket_url = preg_replace('/--A--postal_code--B--/i',"$postal_code",$queuemetrics_socket_url);
					}
				$socket_send_data_begin='?';
				$socket_send_data = "time_id=$QLcomplete_time&call_id=$MDnextCID&queue=$stage&agent=Agent/$user&verb=COMPLETEAGENT&data1=$QLconnect_one&data2=$QLcomplete_length&data3=$QLcomplete_position&data4=$QLconnect_four";
				if (preg_match("/\?/",$queuemetrics_socket_url))
					{$socket_send_data_begin='&';}
				### send queue_log data to the queuemetrics_socket_url ###
				if ($DB > 0) {echo "$queuemetrics_socket_url$socket_send_data_begin$socket_send_data<BR>\n";}
				$SCUfile = file("$queuemetrics_socket_url$socket_send_data_begin$socket_send_data");
				if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}
				}
			}

		mysqli_close($linkB);
		}

	##### check if system is set to generate logfile for dispos
	$stmt="SELECT enable_agc_dispo_log FROM system_settings;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00311',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($DB) {echo "$stmt\n";}
	$enable_agc_dispo_log_ct = mysqli_num_rows($rslt);
	if ($enable_agc_dispo_log_ct > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$enable_agc_dispo_log =$row[0];
		}

	if ( ($WeBRooTWritablE > 0) and ($enable_agc_dispo_log > 0) )
		{
		$talk_time = 0;
		$stmt = "SELECT talk_sec,dead_sec from vicidial_agent_log where lead_id='$lead_id' and agent_log_id='$CALL_agent_log_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00312',$user,$server_ip,$session_name,$one_mysql_log);}
		$VAL_talk_ct = mysqli_num_rows($rslt);
		if ($VAL_talk_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$talk_sec	=		$row[0];
			$dead_sec	=		$row[1];
			$talk_time = ($talk_sec - $dead_sec);
			if ($talk_time < 1)
				{
				$talk_time = 0;
				}
			}

		#	DATETIME|campaign|lead_id|phone_number|user|type|Call_ID||province|talk_sec|
		#	2010-02-19 11:11:11|TESTCAMP|65432|3125551212|1234|D|Y09876543210987654||note|123|
		$fp = fopen ("./xfer_log.txt", "a");
		fwrite ($fp, "$NOW_TIME|$campaign|$lead_id|$phone_number|$user|D|$MDnextCID||$province|$talk_sec|\n");
		fclose($fp);
		}

	# debug testing sleep
	# sleep(5);

	echo _QXZ("Lead %1s has been changed to %2s Status",0,'',$lead_id,$dispo_choice)."\nNext agent_log_id:\n" . $agent_log_id . "\n";


	############################################
	### BEGIN Issue Dispo Call URL if defined
	############################################
	$dispo_call_url_count=0;
	$dispo_call_urlARY[0]='';
	$dispo_urls='';
	if ( (strlen($dispo_call_url) > 7) or ($dispo_call_url == 'ALT') )
		{
		if ($dispo_call_url == 'ALT')
			{
			$stmt="SELECT url_rank,url_statuses,url_address,url_lists from vicidial_url_multi where campaign_id='$DUcampaign_id' and entry_type='$DUentry_type' and url_type='dispo' and active='Y' order by url_rank limit 1000;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00634',$user,$server_ip,$session_name,$one_mysql_log);}
			$VUM_ct = mysqli_num_rows($rslt);
			$k=0;
			while ($VUM_ct > $k)
				{
				$row=mysqli_fetch_row($rslt);
				$url_rank =			$row[0];
				$url_statuses =		" $row[1] ";
				$url_address =		$row[2];
				$url_lists =		" $row[3] ";

				if ( ( (preg_match("/---ALL---/",$url_statuses)) or ( (strlen($url_statuses)>2) and (preg_match("/ $dispo_choice /",$url_statuses)) ) ) and ( (strlen($url_lists)<3) or ( (strlen($url_lists)>2) and (preg_match("/ $list_id /",$url_lists)) ) ) )
					{
					$dispo_call_urlARY[$dispo_call_url_count] = $url_address;
					$dispo_call_url_count++;
					}
				$k++;
				}
			}
		else
			{
			$dispo_call_urlARY[0] = $dispo_call_url;
			$dispo_call_url_count=1;
			}
		}
	### loop through each Dispo URL entry and process ###
	$j=0;
	while ($dispo_call_url_count > $j)
		{
		$talk_time=0;
		$talk_time_ms=0;
		$talk_time_min=0;
		if ( (preg_match('/--A--user_custom_/i',$dispo_call_urlARY[$j])) or (preg_match('/--A--fullname/i',$dispo_call_urlARY[$j])) or (preg_match('/--A--user_group/i',$dispo_call_urlARY[$j])) )
			{
			$stmt = "SELECT custom_one,custom_two,custom_three,custom_four,custom_five,full_name,user_group from vicidial_users where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00288',$user,$server_ip,$session_name,$one_mysql_log);}
			$VUC_ct = mysqli_num_rows($rslt);
			if ($VUC_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_custom_one =		urlencode(trim($row[0]));
				$user_custom_two =		urlencode(trim($row[1]));
				$user_custom_three =	urlencode(trim($row[2]));
				$user_custom_four =		urlencode(trim($row[3]));
				$user_custom_five =		urlencode(trim($row[4]));
				$fullname =				urlencode(trim($row[5]));
				$user_group =			urlencode(trim($row[6]));
				}
			}

		if (preg_match('/--A--talk_time/i',$dispo_call_urlARY[$j]))
			{
			$stmt = "SELECT talk_sec,dead_sec from vicidial_agent_log where lead_id='$lead_id' and agent_log_id='$CALL_agent_log_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00289',$user,$server_ip,$session_name,$one_mysql_log);}
			$VAL_talk_ct = mysqli_num_rows($rslt);
			if ($VAL_talk_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$talk_sec	=		$row[0];
				$dead_sec	=		$row[1];
				$talk_time = ($talk_sec - $dead_sec);
				if ($talk_time < 1)
					{
					$talk_time = 0;
					$talk_time_ms = 0;
					}
				else
					{
					$talk_time_ms = ($talk_time * 1000);
					$talk_time_min = ceil($talk_time / 60);
					}
				}
			}

		if (preg_match('/--A--dispo_name--B--/i',$dispo_call_urlARY[$j]))
			{
			### find the full status name for this status
			$stmt = "SELECT status_name from vicidial_statuses where status='$dispo_choice';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00297',$user,$server_ip,$session_name,$one_mysql_log);}
			$vs_name_ct = mysqli_num_rows($rslt);
			if ($vs_name_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$status_name =		urlencode(trim($row[0]));
				}
			else
				{
				$stmt = "SELECT status_name from vicidial_campaign_statuses where status='$dispo_choice' and campaign_id='$campaign';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00298',$user,$server_ip,$session_name,$one_mysql_log);}
				$vcs_name_ct = mysqli_num_rows($rslt);
				if ($vcs_name_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$status_name =		urlencode(trim($row[0]));
					}
				}
			if (strlen($status_name) < 1) {$status_name = $dispo_choice;}
			}
		$dispo_name = urlencode(trim($status_name));

		if (preg_match('/--A--call_notes/i',$dispo_call_urlARY[$j]))
			{
			if (strlen($call_notes) > 1)
				{$url_call_notes =		urlencode(trim($call_notes));}
			else
				{$url_call_notes =		urlencode(" ");}
			}

		if (preg_match('/--A--dialed_/i',$dispo_call_urlARY[$j]))
			{
			$dialed_number =	$phone_number;
			$dialed_label =		'NONE';

			if ($call_type=='OUT')
				{
				### find the dialed number and label for this call
				$stmt = "SELECT phone_number,alt_dial from vicidial_log where uniqueid='$uniqueid';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00341',$user,$server_ip,$session_name,$one_mysql_log);}
				$vl_dialed_ct = mysqli_num_rows($rslt);
				if ($vl_dialed_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$dialed_number =	$row[0];
					$dialed_label =		$row[1];
					}
				}
			}

		if (preg_match('/--A--did_/i',$dispo_call_urlARY[$j]))
			{
			$DID_id='';
			$DID_extension='';
			$DID_pattern='';
			$DID_description='';

			$stmt = "SELECT did_id,extension from vicidial_did_log where uniqueid='$uniqueid' and caller_id_number='$phone_number' order by call_date desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00346',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDIDL_ct = mysqli_num_rows($rslt);
			if ($VDIDL_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$DID_id	=			$row[0];
				$DID_extension	=	$row[1];

				$stmt = "SELECT did_pattern,did_description,custom_one,custom_two,custom_three,custom_four,custom_five from vicidial_inbound_dids where did_id='$DID_id' limit 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00347',$user,$server_ip,$session_name,$one_mysql_log);}
				$VDIDL_ct = mysqli_num_rows($rslt);
				if ($VDIDL_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$DID_pattern =		urlencode(trim($row[0]));
					$DID_description =	urlencode(trim($row[1]));
					$DID_custom_one =	urlencode(trim($row[2]));
					$DID_custom_two=	urlencode(trim($row[3]));
					$DID_custom_three=	urlencode(trim($row[4]));
					$DID_custom_four=	urlencode(trim($row[5]));
					$DID_custom_five=	urlencode(trim($row[6]));
					}
				}
			}

		if ((preg_match('/callid--B--/i',$dispo_call_urlARY[$j])) or (preg_match('/group--B--/i',$dispo_call_urlARY[$j])))
			{
			$INclosecallid='';
			$INxfercallid='';
			$VDADchannel_group=$campaign;
			$stmt = "SELECT campaign_id,closecallid,xfercallid from vicidial_closer_log where uniqueid='$uniqueid' and user='$user' order by closecallid desc limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00348',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDCL_mvac_ct = mysqli_num_rows($rslt);
			if ($VDCL_mvac_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$VDADchannel_group =	$row[0];
				$INclosecallid =		$row[1];
				$INxfercallid =			$row[2];
				}
			}

		##### grab the data from vicidial_list for the lead_id
		$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$lead_id' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00290',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$list_lead_ct = mysqli_num_rows($rslt);
		if ($list_lead_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$entry_date		= urlencode(trim($row[1]));
			$dispo			= urlencode(trim($row[3]));
			$tsr			= urlencode(trim($row[4]));
			$vendor_id		= urlencode(trim($row[5]));
			$vendor_lead_code	= urlencode(trim($row[5]));
			$source_id		= urlencode(trim($row[6]));
			$list_id		= urlencode(trim($row[7]));
			$gmt_offset_now	= urlencode(trim($row[8]));
			$phone_code		= urlencode(trim($row[10]));
			$phone_number	= urlencode(trim($row[11]));
			$title			= urlencode(trim($row[12]));
			$first_name		= urlencode(trim($row[13]));
			$middle_initial	= urlencode(trim($row[14]));
			$last_name		= urlencode(trim($row[15]));
			$address1		= urlencode(trim($row[16]));
			$address2		= urlencode(trim($row[17]));
			$address3		= urlencode(trim($row[18]));
			$city			= urlencode(trim($row[19]));
			$state			= urlencode(trim($row[20]));
			$province		= urlencode(trim($row[21]));
			$postal_code	= urlencode(trim($row[22]));
			$country_code	= urlencode(trim($row[23]));
			$gender			= urlencode(trim($row[24]));
			$date_of_birth	= urlencode(trim($row[25]));
			$alt_phone		= urlencode(trim($row[26]));
			$email			= urlencode(trim($row[27]));
			$security_phrase	= urlencode(trim($row[28]));
			$comments		= urlencode(trim($row[29]));
			$called_count	= urlencode(trim($row[30]));
			$call_date		= urlencode(trim($row[31]));
			$rank			= urlencode(trim($row[32]));
			$owner			= urlencode(trim($row[33]));
			$entry_list_id	= urlencode(trim($row[34]));
			}

		if (preg_match('/list_name--B--|list_description--B--/i',$dispo_call_urlARY[$j]))
			{
			$stmt = "SELECT list_name,list_description from vicidial_lists where list_id='$list_id' limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00609',$user,$server_ip,$session_name,$one_mysql_log);}
			$VL_ln_ct = mysqli_num_rows($rslt);
			if ($VL_ln_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$list_name =	urlencode(trim($row[0]));
				$list_description = urlencode(trim($row[1]));
				}
			}

		##### Check for a dispo filter in the URL
		$dispo_filter_enabled=0;
		if (preg_match('/dispo_filter_container=/i',$dispo_call_urlARY[$j]))
			{
			$df_fields='|';
			$temp_filter = explode('dispo_filter_container=',$dispo_call_urlARY[$j]);
			$temp_filter[1] = preg_replace("/&.*/",'',$temp_filter[1]);
			$filter_container = $temp_filter[1];

			### Gather container entry (example: "first_name,,TEST")
			$stmt = "SELECT container_entry from vicidial_settings_containers where container_id='$filter_container' limit 1;";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00713',$user,$server_ip,$session_name,$one_mysql_log);}
			$VSC_ct = mysqli_num_rows($rslt);
			if ($VSC_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$container_entry =	$row[0];
				if (strlen($container_entry) > 4)
					{
					$dispo_filter_enabled++;
					$container_entry = preg_replace("/\r|\t/",'',$container_entry);
					$dispo_filters = explode("\n",$container_entry);
					$dispo_filters_ct = count($dispo_filters);
					if ($DB) {echo "DF-Debug 1: $dispo_filters_ct|$dispo_filter_enabled|$container_entry|\n";}
					$dct=0;
					while ($dispo_filters_ct > $dct)
						{
						$temp_df = explode(',',$dispo_filters[$dct]);
						$df_fields .= "$temp_df[0]|";
						$lm=0;

						if ( (preg_match("/^lead_id$/i",$temp_df[0])) and ($lead_id == $temp_df[1]) )						{$lead_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^vendor_id$/i",$temp_df[0])) and ($vendor_id == $temp_df[1]) )					{$vendor_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^vendor_lead_code$/i",$temp_df[0])) and ($vendor_lead_code == $temp_df[1]) )		{$vendor_lead_code = $temp_df[2];   $lm++;}
						if ( (preg_match("/^list_id$/i",$temp_df[0])) and ($list_id == $temp_df[1]) )						{$list_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^list_name$/i",$temp_df[0])) and ($list_name == $temp_df[1]) )					{$list_name = $temp_df[2];   $lm++;}
						if ( (preg_match("/^list_description$/i",$temp_df[0])) and ($list_description == $temp_df[1]) )		{$list_description = $temp_df[2];   $lm++;}
						if ( (preg_match("/^gmt_offset_now$/i",$temp_df[0])) and ($gmt_offset_now == $temp_df[1]) )			{$gmt_offset_now = $temp_df[2];   $lm++;}
						if ( (preg_match("/^phone_code$/i",$temp_df[0])) and ($phone_code == $temp_df[1]) )					{$phone_code = $temp_df[2];   $lm++;}
						if ( (preg_match("/^phone_number$/i",$temp_df[0])) and ($phone_number == $temp_df[1]) )				{$phone_number = $temp_df[2];   $lm++;}
						if ( (preg_match("/^title$/i",$temp_df[0])) and ($title == $temp_df[1]) )							{$title = $temp_df[2];   $lm++;}
						if ( (preg_match("/^first_name$/i",$temp_df[0])) and ($first_name == $temp_df[1]) )					{$first_name = $temp_df[2];   $lm++;}
						if ( (preg_match("/^middle_initial$/i",$temp_df[0])) and ($middle_initial == $temp_df[1]) )			{$middle_initial = $temp_df[2];   $lm++;}
						if ( (preg_match("/^last_name$/i",$temp_df[0])) and ($last_name == $temp_df[1]) )					{$last_name = $temp_df[2];   $lm++;}
						if ( (preg_match("/^address1$/i",$temp_df[0])) and ($address1 == $temp_df[1]) )						{$address1 = $temp_df[2];   $lm++;}
						if ( (preg_match("/^address2$/i",$temp_df[0])) and ($address2 == $temp_df[1]) )						{$address2 = $temp_df[2];   $lm++;}
						if ( (preg_match("/^address3$/i",$temp_df[0])) and ($address3 == $temp_df[1]) )						{$address3 = $temp_df[2];   $lm++;}
						if ( (preg_match("/^city$/i",$temp_df[0])) and ($city == $temp_df[1]) )								{$city = $temp_df[2];   $lm++;}
						if ( (preg_match("/^state$/i",$temp_df[0])) and ($state == $temp_df[1]) )							{$state = $temp_df[2];   $lm++;}
						if ( (preg_match("/^province$/i",$temp_df[0])) and ($province == $temp_df[1]) )						{$province = $temp_df[2];   $lm++;}
						if ( (preg_match("/^postal_code$/i",$temp_df[0])) and ($postal_code == $temp_df[1]) )				{$postal_code = $temp_df[2];   $lm++;}
						if ( (preg_match("/^country_code$/i",$temp_df[0])) and ($country_code == $temp_df[1]) )				{$country_code = $temp_df[2];   $lm++;}
						if ( (preg_match("/^gender$/i",$temp_df[0])) and ($gender == $temp_df[1]) )							{$gender = $temp_df[2];   $lm++;}
						if ( (preg_match("/^date_of_birth$/i",$temp_df[0])) and ($date_of_birth == $temp_df[1]) )			{$date_of_birth = $temp_df[2];   $lm++;}
						if ( (preg_match("/^alt_phone$/i",$temp_df[0])) and ($alt_phone == $temp_df[1]) )					{$alt_phone = $temp_df[2];   $lm++;}
						if ( (preg_match("/^email$/i",$temp_df[0])) and ($email == $temp_df[1]) )							{$email = $temp_df[2];   $lm++;}
						if ( (preg_match("/^security_phrase$/i",$temp_df[0])) and ($security_phrase == $temp_df[1]) )		{$security_phrase = $temp_df[2];   $lm++;}
						if ( (preg_match("/^comments$/i",$temp_df[0])) and ($comments == $temp_df[1]) )						{$comments = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user$|^closer$/i",$temp_df[0])) and ($user == $temp_df[1]) )					{$user = $temp_df[2];   $lm++;}
						if ( (preg_match("/^pass$/i",$temp_df[0])) and ($orig_pass == $temp_df[1]) )						{$orig_pass = $temp_df[2];   $lm++;}
						if ( (preg_match("/^campaign$/i",$temp_df[0])) and ($campaign == $temp_df[1]) )						{$campaign = $temp_df[2];   $lm++;}
						if ( (preg_match("/^phone_login$/i",$temp_df[0])) and ($phone_login == $temp_df[1]) )				{$phone_login = $temp_df[2];   $lm++;}
						if ( (preg_match("/^original_phone_login$/i",$temp_df[0])) and ($original_phone_login == $temp_df[1]) ) {$original_phone_login = $temp_df[2];   $lm++;}
						if ( (preg_match("/^phone_pass$/i",$temp_df[0])) and ($phone_pass == $temp_df[1]) )					{$phone_pass = $temp_df[2];   $lm++;}
						if ( (preg_match("/^fronter$/i",$temp_df[0])) and ($fronter == $temp_df[1]) )						{$fronter = $temp_df[2];   $lm++;}
						if ( (preg_match("/^group$|^channel_group$/i",$temp_df[0])) and ($VDADchannel_group == $temp_df[1]) ) {$VDADchannel_group = $temp_df[2];   $lm++;}
						if ( (preg_match("/^SQLdate$/i",$temp_df[0])) and ($SQLdate == $temp_df[1]) )						{$SQLdate = $temp_df[2];   $lm++;}
						if ( (preg_match("/^epoch$/i",$temp_df[0])) and ($epoch == $temp_df[1]) )							{$epoch = $temp_df[2];   $lm++;}
						if ( (preg_match("/^uniqueid$/i",$temp_df[0])) and ($uniqueid == $temp_df[1]) )						{$uniqueid = $temp_df[2];   $lm++;}
						if ( (preg_match("/^customer_zap_channel$/i",$temp_df[0])) and ($customer_zap_channel == $temp_df[1]) )	{$customer_zap_channel = $temp_df[2];   $lm++;}
						if ( (preg_match("/^customer_server_ip$/i",$temp_df[0])) and ($customer_server_ip == $temp_df[1]) ) {$customer_server_ip = $temp_df[2];   $lm++;}
						if ( (preg_match("/^server_ip$/i",$temp_df[0])) and ($server_ip == $temp_df[1]) )					{$server_ip = $temp_df[2];   $lm++;}
						if ( (preg_match("/^SIPexten$/i",$temp_df[0])) and ($exten == $temp_df[1]) )						{$exten = $temp_df[2];   $lm++;}
						if ( (preg_match("/^session_id$/i",$temp_df[0])) and ($conf_exten == $temp_df[1]) )					{$conf_exten = $temp_df[2];   $lm++;}
						if ( (preg_match("/^phone$/i",$temp_df[0])) and ($phone_number == $temp_df[1]) )					{$phone_number = $temp_df[2];   $lm++;}
						if ( (preg_match("/^parked_by$/i",$temp_df[0])) and ($parked_by == $temp_df[1]) )					{$parked_by = $temp_df[2];   $lm++;}
						if ( (preg_match("/^dispo$/i",$temp_df[0])) and ($dispo == $temp_df[1]) )							{$dispo = $temp_df[2];   $lm++;}
						if ( (preg_match("/^dispo_name$/i",$temp_df[0])) and ($dispo_name == $temp_df[1]) )					{$dispo_name = $temp_df[2];   $lm++;}
						if ( (preg_match("/^dialed_number$/i",$temp_df[0])) and ($dialed_number == $temp_df[1]) )			{$dialed_number = $temp_df[2];   $lm++;}
						if ( (preg_match("/^dialed_label$/i",$temp_df[0])) and ($dialed_label == $temp_df[1]) )				{$dialed_label = $temp_df[2];   $lm++;}
						if ( (preg_match("/^source_id$/i",$temp_df[0])) and ($source_id == $temp_df[1]) )					{$source_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^rank$/i",$temp_df[0])) and ($rank == $temp_df[1]) )								{$rank = $temp_df[2];   $lm++;}
						if ( (preg_match("/^owner$/i",$temp_df[0])) and ($owner == $temp_df[1]) )							{$owner = $temp_df[2];   $lm++;}
						if ( (preg_match("/^camp_script$/i",$temp_df[0])) and ($camp_script == $temp_df[1]) )				{$camp_script = $temp_df[2];   $lm++;}
						if ( (preg_match("/^in_script$/i",$temp_df[0])) and ($in_script == $temp_df[1]) )					{$in_script = $temp_df[2];   $lm++;}
						if ( (preg_match("/^fullname$/i",$temp_df[0])) and ($fullname == $temp_df[1]) )						{$fullname = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_custom_one$/i",$temp_df[0])) and ($user_custom_one == $temp_df[1]) )		{$user_custom_one = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_custom_two$/i",$temp_df[0])) and ($user_custom_two == $temp_df[1]) )		{$user_custom_two = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_custom_three$/i",$temp_df[0])) and ($user_custom_three == $temp_df[1]) )	{$user_custom_three = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_custom_four$/i",$temp_df[0])) and ($user_custom_four == $temp_df[1]) )		{$user_custom_four = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_custom_five$/i",$temp_df[0])) and ($user_custom_five == $temp_df[1]) )		{$user_custom_five = $temp_df[2];   $lm++;}
						if ( (preg_match("/^talk_time$/i",$temp_df[0])) and ($talk_time == $temp_df[1]) )					{$talk_time = $temp_df[2];   $lm++;}
						if ( (preg_match("/^talk_time_ms$/i",$temp_df[0])) and ($talk_time_ms == $temp_df[1]) )				{$talk_time_ms = $temp_df[2];   $lm++;}
						if ( (preg_match("/^talk_time_min$/i",$temp_df[0])) and ($talk_time_min == $temp_df[1]) )			{$talk_time_min = $temp_df[2];   $lm++;}
						if ( (preg_match("/^agent_log_id$/i",$temp_df[0])) and ($CALL_agent_log_id == $temp_df[1]) )		{$CALL_agent_log_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^entry_list_id$/i",$temp_df[0])) and ($entry_list_id == $temp_df[1]) )			{$entry_list_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_id$/i",$temp_df[0])) and ($DID_id == $temp_df[1]) )							{$DID_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_extension$/i",$temp_df[0])) and ($DID_extension == $temp_df[1]) )			{$DID_extension = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_pattern$/i",$temp_df[0])) and ($DID_pattern == $temp_df[1]) )				{$DID_pattern = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_description$/i",$temp_df[0])) and ($DID_description == $temp_df[1]) )		{$DID_description = $temp_df[2];   $lm++;}
						if ( (preg_match("/^closecallid$/i",$temp_df[0])) and ($INclosecallid == $temp_df[1]) )				{$INclosecallid = $temp_df[2];   $lm++;}
						if ( (preg_match("/^xfercallid$/i",$temp_df[0])) and ($INxfercallid == $temp_df[1]) )				{$INxfercallid = $temp_df[2];   $lm++;}
						if ( (preg_match("/^call_id$/i",$temp_df[0])) and ($MDnextCID == $temp_df[1]) )						{$MDnextCID = $temp_df[2];   $lm++;}
						if ( (preg_match("/^user_group$/i",$temp_df[0])) and ($user_group == $temp_df[1]) )					{$user_group = $temp_df[2];   $lm++;}
						if ( (preg_match("/^call_notes$/i",$temp_df[0])) and ($url_call_notes == $temp_df[1]) )				{$url_call_notes = $temp_df[2];   $lm++;}
						if ( (preg_match("/^recording_id$/i",$temp_df[0])) and ($recording_id == $temp_df[1]) )				{$recording_id = $temp_df[2];   $lm++;}
						if ( (preg_match("/^recording_filename$/i",$temp_df[0])) and ($recording_filename == $temp_df[1]) ) {$recording_filename = $temp_df[2];   $lm++;}
						if ( (preg_match("/^entry_date$/i",$temp_df[0])) and ($entry_date == $temp_df[1]) )					{$entry_date = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_custom_one$/i",$temp_df[0])) and ($DID_custom_one == $temp_df[1]) )			{$DID_custom_one = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_custom_two$/i",$temp_df[0])) and ($DID_custom_two == $temp_df[1]) )			{$DID_custom_two = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_custom_three$/i",$temp_df[0])) and ($DID_custom_three == $temp_df[1]) )		{$DID_custom_three = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_custom_four$/i",$temp_df[0])) and ($DID_custom_four == $temp_df[1]) )		{$DID_custom_four = $temp_df[2];   $lm++;}
						if ( (preg_match("/^did_custom_five$/i",$temp_df[0])) and ($DID_custom_five == $temp_df[1]) )		{$DID_custom_five = $temp_df[2];   $lm++;}
						if ( (preg_match("/^agent_email$/i",$temp_df[0])) and ($agent_email == $temp_df[1]) )				{$agent_email = $temp_df[2];   $lm++;}
						if ( (preg_match("/^callback_lead_status$/i",$temp_df[0])) and ($CallBackLeadStatus == $temp_df[1]) ) {$CallBackLeadStatus = $temp_df[2];   $lm++;}
						if ( (preg_match("/^callback_datetime$/i",$temp_df[0])) and ($CallBackDatETimE == $temp_df[1]) )	{$CallBackDatETimE = $temp_df[2];   $lm++;}
						if ( (preg_match("/^called_count$/i",$temp_df[0])) and ($called_count == $temp_df[1]) )				{$called_count = $temp_df[2];   $lm++;}

						if ($DB) {echo "DF-Debug 2: $dct|$lm|$temp_df[0]|$temp_df[1]|$temp_df[2]|\n";}
						$dct++;
						}
					}
				}
			}


		$dispo_call_urlARY[$j] = preg_replace('/^VAR/','',$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--lead_id--B--/i',"$lead_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_lead_code",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--list_id--B--/i',"$list_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--list_name--B--/i',"$list_name",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--list_description--B--/i',"$list_description",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--gmt_offset_now--B--/i',"$gmt_offset_now",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--phone_code--B--/i',"$phone_code",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--phone_number--B--/i',"$phone_number",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--title--B--/i',"$title",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--first_name--B--/i',"$first_name",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--last_name--B--/i',"$last_name",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--address1--B--/i',"$address1",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--address2--B--/i',"$address2",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--address3--B--/i',"$address3",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--city--B--/i',"$city",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--state--B--/i',"$state",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--province--B--/i',"$province",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--postal_code--B--/i',"$postal_code",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--country_code--B--/i',"$country_code",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--gender--B--/i',"$gender",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--date_of_birth--B--/i',"$date_of_birth",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--alt_phone--B--/i',"$alt_phone",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--email--B--/i',"$email",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--security_phrase--B--/i',"$security_phrase",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--comments--B--/i',"$comments",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user--B--/i',"$user",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--pass--B--/i',"$orig_pass",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--campaign--B--/i',"$campaign",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--phone_login--B--/i',"$phone_login",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--original_phone_login--B--/i',"$original_phone_login",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--phone_pass--B--/i',"$phone_pass",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--fronter--B--/i',"$fronter",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--closer--B--/i',"$user",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--group--B--/i',"$VDADchannel_group",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--channel_group--B--/i',"$VDADchannel_group",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--SQLdate--B--/i',urlencode(trim($SQLdate)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--epoch--B--/i',"$epoch",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--uniqueid--B--/i',"$uniqueid",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--customer_zap_channel--B--/i',urlencode(trim($customer_zap_channel)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--customer_server_ip--B--/i',"$customer_server_ip",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--server_ip--B--/i',"$server_ip",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--SIPexten--B--/i',urlencode(trim($exten)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--session_id--B--/i',"$conf_exten",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--phone--B--/i',"$phone_number",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--parked_by--B--/i',"$parked_by",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--dispo--B--/i',"$dispo",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--dispo_name--B--/i',"$dispo_name",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--dialed_number--B--/i',"$dialed_number",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--dialed_label--B--/i',"$dialed_label",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--source_id--B--/i',"$source_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--rank--B--/i',"$rank",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--owner--B--/i',"$owner",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--camp_script--B--/i',"$camp_script",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--in_script--B--/i',"$in_script",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--fullname--B--/i',"$fullname",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_custom_one--B--/i',"$user_custom_one",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_custom_two--B--/i',"$user_custom_two",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_custom_three--B--/i',"$user_custom_three",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_custom_four--B--/i',"$user_custom_four",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_custom_five--B--/i',"$user_custom_five",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--talk_time--B--/i',"$talk_time",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--talk_time_ms--B--/i',"$talk_time_ms",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--talk_time_min--B--/i',"$talk_time_min",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--agent_log_id--B--/i',"$CALL_agent_log_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--entry_list_id--B--/i',"$entry_list_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_id--B--/i',urlencode(trim($DID_id)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_extension--B--/i',urlencode(trim($DID_extension)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_pattern--B--/i',urlencode(trim($DID_pattern)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_description--B--/i',urlencode(trim($DID_description)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--closecallid--B--/i',urlencode(trim($INclosecallid)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--xfercallid--B--/i',urlencode(trim($INxfercallid)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--call_id--B--/i',urlencode(trim($MDnextCID)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--user_group--B--/i',urlencode(trim($user_group)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--call_notes--B--/i',"$url_call_notes",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--recording_id--B--/i',"$recording_id",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--recording_filename--B--/i',"$recording_filename",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--entry_date--B--/i',"$entry_date",$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_custom_one--B--/i',urlencode(trim($DID_custom_one)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_custom_two--B--/i',urlencode(trim($DID_custom_two)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_custom_three--B--/i',urlencode(trim($DID_custom_three)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_custom_four--B--/i',urlencode(trim($DID_custom_four)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--did_custom_five--B--/i',urlencode(trim($DID_custom_five)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--agent_email--B--/i',urlencode(trim($agent_email)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--callback_lead_status--B--/i',urlencode(trim($CallBackLeadStatus)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--callback_datetime--B--/i',urlencode(trim($CallBackDatETimE)),$dispo_call_urlARY[$j]);
		$dispo_call_urlARY[$j] = preg_replace('/--A--called_count--B--/i',"$called_count",$dispo_call_urlARY[$j]);


		if (strlen($FORMcustom_field_names)>2)
			{
			$custom_field_names = preg_replace("/^\||\|$/",'',$FORMcustom_field_names);
			$custom_field_names = preg_replace("/\|.*_DUPLICATE_.*\|/",'|',$custom_field_names);
			$custom_field_names = preg_replace("/\|/",",",$custom_field_names);
			$custom_field_names_ARY = explode(',',$custom_field_names);
			$custom_field_names_ct = count($custom_field_names_ARY);
			$custom_field_names_SQL = $custom_field_names;

			if (preg_match("/cf_encrypt/",$active_modules))
				{
				$enc_fields=0;
				$stmt = "SELECT count(*) from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($DB) {echo "$stmt\n";}
				$enc_field_ct = mysqli_num_rows($rslt);
				if ($enc_field_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$enc_fields =	$row[0];
					}
				if ($enc_fields > 0)
					{
					$stmt = "SELECT field_label from vicidial_lists_fields where field_encrypt='Y' and list_id='$entry_list_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($DB) {echo "$stmt\n";}
					$enc_field_ct = mysqli_num_rows($rslt);
					$r=0;
					while ($enc_field_ct > $r)
						{
						$row=mysqli_fetch_row($rslt);
						$encrypt_list .= "$row[0],";
						$r++;
						}
					$encrypt_list = ",$encrypt_list";
					}
				}


			##### BEGIN grab the data from custom table for the lead_id
			if ($entry_list_id > 0)
				{
				$stmt="SELECT $custom_field_names_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00345',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$list_lead_ct = mysqli_num_rows($rslt);
				if ($list_lead_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$o=0;
					while ($custom_field_names_ct > $o) 
						{
						$field_name_id =		$custom_field_names_ARY[$o];
						$field_name_tag =		"--A--" . $field_name_id . "--B--";
						if ($enc_fields > 0)
							{
							$field_enc='';   $field_enc_all='';
							if ($DB) {echo "|$column_list|$encrypt_list|\n";}
							if ( (preg_match("/,$field_name_id,/",$encrypt_list)) and (strlen($row[$o]) > 0) )
								{
								exec("../agc/aes.pl --decrypt --text=$row[$o]", $field_enc);
								$field_enc_ct = count($field_enc);
								$k=0;
								while ($field_enc_ct > $k)
									{
									$field_enc_all .= $field_enc[$k];
									$k++;
									}
								$field_enc_all = preg_replace("/CRYPT: |\n|\r|\t/",'',$field_enc_all);
								$row[$o] = base64_decode($field_enc_all);
								}
							}
						$form_field_value =		urlencode(trim("$row[$o]"));

						### Check for dispo filter, run if enabled and field matches
						if ( ($dispo_filter_enabled > 0) and (preg_match("/\|$field_name_id\|/",$df_fields)) )
							{
							$dct=0;
							while ($dispo_filters_ct > $dct)
								{
								$temp_df = explode(',',$dispo_filters[$dct]);
								$lm=0;

								if ( (preg_match("/^$field_name_id$/i",$temp_df[0])) and ($form_field_value == $temp_df[1]) )	{$form_field_value = $temp_df[2];   $lm++;}

								if ($DB) {echo "DF-Debug 3: $dct|$lm|$temp_df[0]($field_name_id)|$temp_df[1]($form_field_value)|$temp_df[2]|\n";}
								$dct++;
								}
							}
						$dispo_call_urlARY[$j] = preg_replace("/$field_name_tag/i","$form_field_value",$dispo_call_urlARY[$j]);
						$o++;
						}
					}
				}
			}

		$stmt="UPDATE vicidial_log_extended set dispo_url_processed='Y' where uniqueid='$uniqueid';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00423',$user,$server_ip,$session_name,$one_mysql_log);}
		$vle_update = mysqli_affected_rows($link);

		### insert a new url log entry
		$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date=NOW(),url_type='dispo',url='" . mysqli_real_escape_string($link, $dispo_call_urlARY[$j]) . "',url_response='';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00424',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($link);
		$url_id = mysqli_insert_id($link);

		$URLstart_sec = date("U");

		### send dispo_call_url ###
		if ($DB > 0) {echo "$dispo_call_urlARY[$j]<BR>\n";}

		$dispo_urls .= "$url_id|";

		# exec("./AST_send_URLbasic.pl --url_id=$url_id &");

		/*
		$SCUfile = file("$dispo_call_urlARY[$j]");
		if ( !($SCUfile) )
			{
			$error_array = error_get_last();
			$error_type = $error_array["type"];
			$error_message = $error_array["message"];
			$error_line = $error_array["line"];
			$error_file = $error_array["file"];
			}

		if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

		### update url log entry
		$URLend_sec = date("U");
		$URLdiff_sec = ($URLend_sec - $URLstart_sec);
		if ($SCUfile)
			{
			$SCUfile_contents = implode("", $SCUfile);
			$SCUfile_contents = preg_replace('/;/','',$SCUfile_contents);
			$SCUfile_contents = addslashes($SCUfile_contents);
			}
		else
			{
			$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
			}
		$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='$SCUfile_contents' where url_log_id='$url_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00425',$user,$server_ip,$session_name,$one_mysql_log);}
		$affected_rows = mysqli_affected_rows($link);
		*/

		$stmt = "SELECT enable_vtiger_integration FROM system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00296',$user,$server_ip,$session_name,$one_mysql_log);}
		$ss_conf_ct = mysqli_num_rows($rslt);
		if ($ss_conf_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$enable_vtiger_integration =	$row[0];
			}
		if ( ($enable_vtiger_integration > 0) and (preg_match('/mode=callend/',$dispo_call_urlARY[$j])) and (preg_match('/contactwsid/',$dispo_call_urlARY[$j])) )
			{
			$SCUoutput='';
			foreach ($SCUfile as $SCUline) 
				{$SCUoutput .= "$SCUline";}
			$fp = fopen ("./call_url_log.txt", "a");
			fwrite ($fp, "$dispo_call_urlARY[$j]\n$SCUoutput\n");
			fclose($fp);
			}

		### add this to the Dispo URL for callcard calls to be logged "&callcard=--A--talk_time_min--B--"
		if (preg_match("/callcard/",$dispo_call_urlARY[$j]))
			{
			$stmt="SELECT balance_minutes_start,card_id FROM callcard_log where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00317',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$bms_ct = mysqli_num_rows($rslt);
			$fp = fopen ("./call_url_log.txt", "a");
			fwrite ($fp, "$dispo_call_urlARY[$j]\n$stmt|$bms_ct\n");
			fclose($fp);

			if ($bms_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$balance_minutes_start =	$row[0];
				$card_id =					$row[1];

				$current_minutes = ($balance_minutes_start - $talk_time_min);

				$stmt="UPDATE callcard_log set agent_talk_sec='$talk_time',agent_talk_min='$talk_time_min',dispo_time='$NOW_TIME',agent_dispo='$dispo' where uniqueid='$uniqueid' order by call_time desc LIMIT 1;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00318',$user,$server_ip,$session_name,$one_mysql_log);}
				$ccl_update = mysqli_affected_rows($link);

				$stmt="UPDATE callcard_accounts set balance_minutes='$current_minutes' where card_id='$card_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00319',$user,$server_ip,$session_name,$one_mysql_log);}
				$cca_update = mysqli_affected_rows($link);

				$stmt="UPDATE callcard_accounts_details set balance_minutes='$current_minutes' where card_id='$card_id';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00320',$user,$server_ip,$session_name,$one_mysql_log);}
				$ccad_update = mysqli_affected_rows($link);
				}
			}
		$j++;
		}
	echo "Dispo URLs:\n$dispo_urls\n";
	############################################
	### END Issue Dispo Call URL if defined
	############################################
	$stage .= "|$call_type|$dispo_choice|";
	}


################################################################################
### RUNurls - update the vicidial_list table to reflect the values that are
###              in the agents screen at time of call hangup
################################################################################
if ($ACTION == 'RUNurls')
	{
	$MT[0]='';
	$row='';   $rowx='';
	if (strlen($url_ids) < 2)
		{
		echo _QXZ("URL IDs are is not valid",0,'',$url_ids)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$urls_split = explode('|',$url_ids);
		$urls_split_ct = count($urls_split);
		$k=0;
		while ($k < $urls_split_ct)
			{
			if (strlen($urls_split[$k]) > 0)
				{
				$stmt="SELECT url FROM vicidial_url_log where url_log_id='$urls_split[$k]';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00635',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$urlid_ct = mysqli_num_rows($rslt);
				if ($urlid_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$url =	$row[0];

					$URLstart_sec = date("U");

					$SCUfile = file("$url");
					if ( !($SCUfile) )
						{
						$error_array = error_get_last();
						$error_type = $error_array["type"];
						$error_message = $error_array["message"];
						$error_line = $error_array["line"];
						$error_file = $error_array["file"];
						}

					if ($DB > 0) {echo "$SCUfile[0]<BR>\n";}

					### update url log entry
					$URLend_sec = date("U");
					$URLdiff_sec = ($URLend_sec - $URLstart_sec);
					if ($SCUfile)
						{
						$SCUfile_contents = implode("", $SCUfile);
						$SCUfile_contents = preg_replace('/;/','',$SCUfile_contents);
						$SCUfile_contents = addslashes($SCUfile_contents);
						}
					else
						{
						$SCUfile_contents = "PHP ERROR: Type=$error_type - Message=$error_message - Line=$error_line - File=$error_file";
						}
					$stmt = "UPDATE vicidial_url_log SET response_sec='$URLdiff_sec',url_response='" . date("r") . "|$SCUfile_contents' where url_log_id='$urls_split[$k]';";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00425',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($link);

					echo "URL sent: $k|$urls_split[$k]|$affected_rows|$URLdiff_sec\n";
					}
				}
			$k++;
			}
		}
	}


################################################################################
### updateLEAD - update the vicidial_list table to reflect the values that are
###              in the agents screen at time of call hangup
################################################################################
if ($ACTION == 'updateLEAD')
	{
	$MT[0]='';
	$row='';   $rowx='';
	$DO_NOT_UPDATE=0;
	$DO_NOT_UPDATE_text='';
	if ( ( (strlen($phone_number)<1) and (strlen($email)<1) ) or (strlen($lead_id)<1) )
		{
		echo _QXZ("phone_number %1s or lead_id %2s is not valid",0,'',$phone_number,$lead_id)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt = "SELECT disable_alter_custdata,disable_alter_custphone FROM vicidial_campaigns where campaign_id='$campaign'";
		if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00161',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$dac_conf_ct = mysqli_num_rows($rslt);
		$i=0;
		while ($i < $dac_conf_ct)
			{
			$row=mysqli_fetch_row($rslt);
			$disable_alter_custdata =	$row[0];
			$disable_alter_custphone =	$row[1];
			$i++;
			}
		if ( (preg_match('/Y/',$disable_alter_custdata)) or (preg_match('/Y/',$disable_alter_custphone)) )
			{
			if (preg_match('/Y/',$disable_alter_custdata))
				{
				$DO_NOT_UPDATE=1;
				$DO_NOT_UPDATE_text=' NOT';
				}
			if (preg_match('/Y/',$disable_alter_custphone))
				{
				$DO_NOT_UPDATEphone=1;
				}
			$stmt = "SELECT alter_custdata_override,alter_custphone_override FROM vicidial_users where user='$user'";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00162',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$aco_conf_ct = mysqli_num_rows($rslt);
			$i=0;
			while ($i < $aco_conf_ct)
				{
				$row=mysqli_fetch_row($rslt);
				$alter_custdata_override =	$row[0];
				$alter_custphone_override = $row[1];
				$i++;
				}
			if (preg_match('/ALLOW_ALTER/',$alter_custdata_override))
				{
				$DO_NOT_UPDATE=0;
				$DO_NOT_UPDATE_text='';
				}
			if (preg_match('/ALLOW_ALTER/',$alter_custphone_override))
				{
				$DO_NOT_UPDATEphone=0;
				}
			}

		if ($DO_NOT_UPDATE < 1)
			{
			$comments = preg_replace("/\r/i",'',$comments);
			$comments = preg_replace("/\n/i",'!N',$comments);
			$comments = preg_replace("/--AMP--/i",'&',$comments);
			$comments = preg_replace("/--QUES--/i",'?',$comments);
			$comments = preg_replace("/--POUND--/i",'#',$comments);

			$phoneSQL='';
			if ($DO_NOT_UPDATEphone < 1)
				{$phoneSQL = ",phone_number='$phone_number'";}

			$stmt="UPDATE vicidial_list set vendor_lead_code='" . mysqli_real_escape_string($link, $vendor_lead_code) . "', title='" . mysqli_real_escape_string($link, $title) . "', first_name='" . mysqli_real_escape_string($link, $first_name) . "', middle_initial='" . mysqli_real_escape_string($link, $middle_initial) . "', last_name='" . mysqli_real_escape_string($link, $last_name) . "', address1='" . mysqli_real_escape_string($link, $address1) . "', address2='" . mysqli_real_escape_string($link, $address2) . "', address3='" . mysqli_real_escape_string($link, $address3) . "', city='" . mysqli_real_escape_string($link, $city) . "', state='" . mysqli_real_escape_string($link, $state) . "', province='" . mysqli_real_escape_string($link, $province) . "', postal_code='" . mysqli_real_escape_string($link, $postal_code) . "', country_code='" . mysqli_real_escape_string($link, $country_code) . "', gender='" . mysqli_real_escape_string($link, $gender) . "', date_of_birth='" . mysqli_real_escape_string($link, $date_of_birth) . "', alt_phone='" . mysqli_real_escape_string($link, $alt_phone) . "', email='" . mysqli_real_escape_string($link, $email) . "', security_phrase='" . mysqli_real_escape_string($link, $security_phrase) . "', comments='" . mysqli_real_escape_string($link, $comments) . "' $phoneSQL where lead_id='$lead_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00163',$user,$server_ip,$session_name,$one_mysql_log);}
			$VLaffected_rows = mysqli_affected_rows($link);
			}

		$random = (rand(1000000, 9999999) + 10000000);
		$stmt="UPDATE vicidial_live_agents set random_id='$random' where user='$user' and server_ip='$server_ip';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00164',$user,$server_ip,$session_name,$one_mysql_log);}
		$retry_count=0;
		while ( ($errno > 0) and ($retry_count < 9) )
			{
			$rslt=mysql_to_mysqli($stmt, $link);
			$one_mysql_log=1;
			$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9164$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
			$one_mysql_log=0;
			$retry_count++;
			}

		}
	echo _QXZ("Lead %1s information has%2s been updated",0,'',$lead_id,$DO_NOT_UPDATE_text)."\n";
	$stage = "$DO_NOT_UPDATE|$DO_NOT_UPDATEphone|$random|$VLaffected_rows";
	}


################################################################################
### VDADpause - update the vicidial_live_agents table to show that the agent is
###  or ready   now active and ready to take calls
################################################################################
if ( ($ACTION == 'VDADpause') or ($ACTION == 'VDADready') or ($pause_trigger == 'PAUSE') )
	{
	$MT[0]='';
	$row='';   $rowx='';
	$vla_status = $stage;
	if ($pause_trigger == 'PAUSE')
		{$vla_status = 'PAUSED';}

	if ( (strlen($vla_status)<2) or (strlen($server_ip)<1) )
		{
		echo _QXZ("stage %1s is not valid",0,'',$vla_status)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$random = (rand(1000000, 9999999) + 10000000);
		if ($comments != 'NO_STATUS_CHANGE')
			{
			$VLAaffected_rows=0;
			$vla_lead_wipeSQL='';
			$vla_where_SQL='';
			if ($ACTION == 'VDADready')
				{
				$vla_lead_wipeSQL = ",lead_id=0";
				$vla_where_SQL = "and status NOT IN('QUEUE','INCALL')";
				}
			if ( ($ACTION == 'VDADpause') or ($pause_trigger == 'PAUSE') )
				{
				$vla_ring_resetSQL = ",ring_callerid='',random_id='$random'";
				$vla_where_SQL = "and status NOT IN('QUEUE','INCALL')";
				}
			$stmt="UPDATE vicidial_live_agents set status='$vla_status' $vla_lead_wipeSQL $vla_ring_resetSQL where user='$user' and server_ip='$server_ip' $vla_where_SQL;";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00166',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9166$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}
			$VLAaffected_rows = mysqli_affected_rows($link);
			}

		if ( ($VLAaffected_rows > 0) or ($comments == 'NO_STATUS_CHANGE') )
			{
			$vla_autodialSQL='';
			$vla_pausecodeSQL='';
			if (preg_match('/INBOUND_MAN/',$dial_method))
				{$vla_autodialSQL = ",outbound_autodial='N'";}
			if ($ACTION == 'VDADready')
				{$vla_pausecodeSQL = ",pause_code='',external_pause_code=''";}
			$stmt="UPDATE vicidial_live_agents set uniqueid=0,callerid='',channel='', random_id='$random',comments='',last_state_change='$NOW_TIME' $vla_autodialSQL $vla_pausecodeSQL where user='$user' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00165',$user,$server_ip,$session_name,$one_mysql_log);}
			$retry_count=0;
			while ( ($errno > 0) and ($retry_count < 9) )
				{
				$rslt=mysql_to_mysqli($stmt, $link);
				$one_mysql_log=1;
				$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9165$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
				$one_mysql_log=0;
				$retry_count++;
				}

			#############################################
			##### START QUEUEMETRICS LOGGING LOOKUP #####
			$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,queuemetrics_pe_phone_append,queuemetrics_pause_type FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00167',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$qm_conf_ct = mysqli_num_rows($rslt);
			$i=0;
			while ($i < $qm_conf_ct)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_queuemetrics_logging =	$row[0];
				$queuemetrics_server_ip	=		$row[1];
				$queuemetrics_dbname =			$row[2];
				$queuemetrics_login	=			$row[3];
				$queuemetrics_pass =			$row[4];
				$queuemetrics_log_id =			$row[5];
				$queuemetrics_pe_phone_append =	$row[6];
				$queuemetrics_pause_type =		$row[7];
				$i++;
				}
			##### END QUEUEMETRICS LOGGING LOOKUP #####
			###########################################
			if ($enable_queuemetrics_logging > 0)
				{
				if ( (preg_match('/READY/',$stage)) or (preg_match('/CLOSER/',$stage)) ) {$QMstatus='UNPAUSEALL';}
				if ( (preg_match('/PAUSE/',$stage)) or ($pause_trigger == 'PAUSE') ) {$QMstatus='PAUSEALL';}
				$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
				if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
				mysqli_select_db($linkB, "$queuemetrics_dbname");

				$user_group='';
				$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00182',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$ug_record_ct = mysqli_num_rows($rslt);
				if ($ug_record_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$user_group =		trim("$row[0]");
					}

				$data4SQL='';
				$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00395',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cqpe_ct = mysqli_num_rows($rslt);
				if ($cqpe_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$pe_append='';
					if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
						{$pe_append = "-$qm_extension";}
					$data4SQL = ",data4='$row[0]$pe_append'";
					}

				$pause_typeSQL='';
				if ($queuemetrics_pause_type > 0)
					{$pause_typeSQL=",data5='AGENT'";}
				$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='$QMstatus',serverid='$queuemetrics_log_id' $data4SQL $pause_typeSQL;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00168',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($linkB);

				mysqli_close($linkB);
				}
			}

		$pause_sec=0;
		$stmt = "SELECT pause_epoch,pause_sec,wait_epoch,wait_sec,dispo_epoch from vicidial_agent_log where agent_log_id='$agent_log_id';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00169',$user,$server_ip,$session_name,$one_mysql_log);}
		$VDpr_ct = mysqli_num_rows($rslt);
		if ($VDpr_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$dispo_epoch = $row[4];
			$wait_sec=0;
			if ($row[2] > 0)
				{
				$wait_sec = (($StarTtime - $row[2]) + $row[3]);
				}
			if ( (preg_match("/NULL/i",$row[4])) or ($row[4] < 1000) )
				{$pause_sec = (($StarTtime - $row[0]) + $row[1]);}
			else
				{$pause_sec = (($row[4] - $row[0]) + $row[1]);}

			}
		if ($ACTION == 'VDADready')
			{
			if ( (preg_match("/NULL/i",$dispo_epoch)) or ($dispo_epoch < 1000) )
				{
				$stmt="UPDATE vicidial_agent_log set pause_sec='$pause_sec',wait_epoch='$StarTtime' where agent_log_id='$agent_log_id';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00170',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		if ( ($ACTION == 'VDADpause') or ($pause_trigger == 'PAUSE') )
			{
			if ( (preg_match("/NULL/i",$dispo_epoch)) or ($dispo_epoch < 1000) )
				{
				$stmt="UPDATE vicidial_agent_log set wait_sec='$wait_sec' where agent_log_id='$agent_log_id';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00171',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			if ($VLAaffected_rows > 0)
				{$agent_log = 'NEW_ID';}
			}

		if ($wrapup == 'WRAPUP')
			{
			if ( (preg_match("/NULL/i",$dispo_epoch)) or ($dispo_epoch < 1000) )
				{
				$stmt="UPDATE vicidial_agent_log set dispo_epoch='$StarTtime', dispo_sec='0' where agent_log_id='$agent_log_id';";
				}
			else
				{
				$dispo_sec = ($StarTtime - $dispo_epoch);
				$stmt="UPDATE vicidial_agent_log set dispo_sec='$dispo_sec' where agent_log_id='$agent_log_id';";
				}

				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00194',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		if ($agent_log == 'NEW_ID')
			{
			$user_group='';
			$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00570',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				}

			$stmt="INSERT INTO vicidial_agent_log (user,server_ip,event_time,campaign_id,pause_epoch,pause_sec,wait_epoch,user_group,pause_type) values('$user','$server_ip','$NOW_TIME','$campaign','$StarTtime','0','$StarTtime','$user_group','AGENT');";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00571',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			$agent_log_id = mysqli_insert_id($link);

			$stmt="UPDATE vicidial_live_agents SET agent_log_id='$agent_log_id' where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00572',$VD_login,$server_ip,$session_name,$one_mysql_log);}
			$VLAaffected_rows_update = mysqli_affected_rows($link);
			}
		}
	if (strlen($sub_status) > 0)
		{
		### if a pause code(sub_status) is sent with this pause request, continue on to that action without printing output
		# $stage = 0;   # yes I know this is overriden below
		$pause_to_code_jump=1;
		$status = $sub_status;
		$stage .= "|$ACTION|$agent_log_id|";
		$ACTION = 'PauseCodeSubmit';
		}
	else
		{
		$stage .= "|$agent_log|$agent_log_id|";
		echo _QXZ("Agent %1s is now in status %2s",0,'',$user,$vla_status)."\nNext agent_log_id:\n$agent_log_id\n";
		}
	}


################################################################################
### userLOGout - Logs the user out of VICIDiaL client, deleting db records and 
###              inserting into vicidial_user_log
################################################################################
if ($ACTION == 'userLOGout')
	{
	$MT[0]='';
	$row='';   $rowx='';
	if ( (strlen($campaign)<1) || (strlen($conf_exten)<1) )
		{
		echo "NO\n";
		echo _QXZ("campaign %1s or conf_exten %2s is not valid",0,'',$campaign,$conf_exten)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$user_group='';
		$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00127',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$ug_record_ct = mysqli_num_rows($rslt);
		if ($ug_record_ct > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$user_group =		trim("$row[0]");
			}
		##### Insert a LOGOUT record into the user log
		$insert_user_log=1;
		if ($stage=='DISABLED')
			{
			$stmt="SELECT event FROM vicidial_user_log where user='$user' order by user_log_id desc LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00693',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ul_record_ct = mysqli_num_rows($rslt);
			if ($ul_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$last_event =		trim("$row[0]");
				if ($last_event == 'LOGOUT') {$insert_user_log=0;}
				}
			}
		$user_log_event = "LOGOUT";
		if ($stage=='TIMEOUT') {$user_log_event = "TIMEOUTLOGOUT";}
		if ($insert_user_log > 0)
			{
			$stmt="INSERT INTO vicidial_user_log (user,event,campaign_id,event_date,event_epoch,user_group) values('$user','$user_log_event','$campaign','$NOW_TIME','$StarTtime','$user_group');";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00128',$user,$server_ip,$session_name,$one_mysql_log);}
			$vul_insert = mysqli_affected_rows($link);
			}

		if ($no_delete_sessions < 1)
			{
			##### Remove the reservation on the vicidial_conferences meetme room
			$stmt="UPDATE vicidial_conferences set extension='' where server_ip='$server_ip' and conf_exten='$conf_exten';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00129',$user,$server_ip,$session_name,$one_mysql_log);}
			$vc_remove = mysqli_affected_rows($link);
			}

		##### Delete the web_client_sessions
		$stmt="DELETE from web_client_sessions where server_ip='$server_ip' and session_name ='$session_name';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00132',$user,$server_ip,$session_name,$one_mysql_log);}
		$wcs_delete = mysqli_affected_rows($link);

		##### Hangup the client phone
		$stmt="SELECT channel FROM live_sip_channels where server_ip = '$server_ip' and channel LIKE \"$protocol/$extension%\" order by channel desc;";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00133',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) 
			{
			$row=mysqli_fetch_row($rslt);
			$agent_channel = "$row[0]";
			if ($format=='debug') {echo "\n<!-- $row[0] -->";}
			$stmt="INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Hangup','ULGH3459$StarTtime','Channel: $agent_channel','','','','','','','','','');";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00134',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		if ($LogouTKicKAlL > 0)
			{
			$local_DEF = 'Local/5555';
			$local_AMP = '@';
			$kick_local_channel = "$local_DEF$conf_exten$local_AMP$ext_context";
			$queryCID = "ULGH3458$StarTtime";

			$stmt="INSERT INTO vicidial_manager values('','','$NOW_TIME','NEW','N','$server_ip','','Originate','$queryCID','Channel: $kick_local_channel','Context: $ext_context','Exten: 8300','Priority: 1','Callerid: $queryCID','','','','$channel','$exten');";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00135',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		sleep(1);

		##### End any still-active chats initiated by the agent
		if ($allow_chats==1) {
			$stmt="SELECT manager_chat_id from vicidial_manager_chats where manager='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);

			while ($row=mysqli_fetch_row($rslt)) {
				$manager_chat_id=$row[0];

				$archive_stmt="INSERT IGNORE INTO vicidial_manager_chat_log_archive SELECT manager_chat_message_id,manager_chat_id,manager_chat_subid,manager,user,message,message_date,message_viewed_date,message_posted_by,audio_alerted from vicidial_manager_chat_log where manager_chat_id='$manager_chat_id';";
				$archive_rslt=mysql_to_mysqli($archive_stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$archive_stmt,'00646',$user,$server_ip,$session_name,$one_mysql_log);}

				$archive_stmt="INSERT IGNORE INTO vicidial_manager_chats_archive SELECT manager_chat_id,chat_start_date,manager,selected_agents,selected_user_groups,selected_campaigns,allow_replies from vicidial_manager_chats where manager_chat_id='$manager_chat_id';";
				$archive_rslt=mysql_to_mysqli($archive_stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$archive_stmt,'00647',$user,$server_ip,$session_name,$one_mysql_log);}

				$delete_stmt="DELETE from vicidial_manager_chat_log where manager_chat_id='$manager_chat_id';";
				$delete_rslt=mysql_to_mysqli($delete_stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$delete_stmt,'00648',$user,$server_ip,$session_name,$one_mysql_log);}

				if (mysqli_affected_rows($link)>0) {
					$archive_stmt="DELETE from vicidial_manager_chats where manager_chat_id='$manager_chat_id';";
					$archive_rslt=mysql_to_mysqli($archive_stmt, $link);
	if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$archive_stmt,'00649',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		}
		######

		##### Delete the vicidial_live_agents record for this session
		$stmt="DELETE from vicidial_live_agents where server_ip='$server_ip' and user ='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00130',$user,$server_ip,$session_name,$one_mysql_log);}
		$retry_count=0;
		while ( ($errno > 0) and ($retry_count < 9) )
			{
			$rslt=mysql_to_mysqli($stmt, $link);
			$one_mysql_log=1;
			$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,"9130$retry_count",$user,$server_ip,$session_name,$one_mysql_log);
			$one_mysql_log=0;
			$retry_count++;
			}
		$vla_delete = mysqli_affected_rows($link);

		##### Delete the vicidial_live_inbound_agents records for this session
		$stmt="DELETE from vicidial_live_inbound_agents where user='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00131',$user,$server_ip,$session_name,$one_mysql_log);}
		$vlia_delete = mysqli_affected_rows($link);

		$pause_sec=0;
		$stmt = "SELECT pause_epoch,pause_sec,wait_epoch,talk_epoch,dispo_epoch,agent_log_id from vicidial_agent_log where agent_log_id >= '$agent_log_id' and user='$user' order by agent_log_id desc limit 1;";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00136',$user,$server_ip,$session_name,$one_mysql_log);}
		$VDpr_ct = mysqli_num_rows($rslt);
		if ( ($VDpr_ct > 0) and (strlen($row[3]<5)) and (strlen($row[4]<5)) )
			{
			$row=mysqli_fetch_row($rslt);
			$agent_log_id = $row[5];
			$pause_sec = (($StarTtime - $row[0]) + $row[1]);

			$stmt="UPDATE vicidial_agent_log set pause_sec='$pause_sec',wait_epoch='$StarTtime' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00137',$user,$server_ip,$session_name,$one_mysql_log);}
			}

		if ($vla_delete > 0) 
			{
			#############################################
			##### START QUEUEMETRICS LOGGING LOOKUP #####
			$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,allow_sipsak_messages,queuemetrics_loginout,queuemetrics_addmember_enabled,queuemetrics_dispo_pause,queuemetrics_pe_phone_append,queuemetrics_pause_type FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00138',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$qm_conf_ct = mysqli_num_rows($rslt);
			if ($qm_conf_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_queuemetrics_logging =		$row[0];
				$queuemetrics_server_ip	=			$row[1];
				$queuemetrics_dbname =				$row[2];
				$queuemetrics_login	=				$row[3];
				$queuemetrics_pass =				$row[4];
				$queuemetrics_log_id =				$row[5];
				$allow_sipsak_messages =			$row[6];
				$queuemetrics_loginout =			$row[7];
				$queuemetrics_addmember_enabled =	$row[8];
				$queuemetrics_dispo_pause =			$row[9];
				$queuemetrics_pe_phone_append =		$row[10];
				$queuemetrics_pause_type =			$row[11];
				}
			##### END QUEUEMETRICS LOGGING LOOKUP #####
			###########################################
			if ( ($enable_sipsak_messages > 0) and ($allow_sipsak_messages > 0) and (preg_match("/SIP/i",$protocol)) )
				{
				$extension = preg_replace("/\'|\"|\\\\|;/","",$extension);
				$phone_ip = preg_replace("/\'|\"|\\\\|;/","",$phone_ip);
				$SIPSAK_message = 'LOGGED OUT';
				passthru("/usr/local/bin/sipsak -M -O desktop -B \"$SIPSAK_message\" -r 5060 -s sip:$extension@$phone_ip > /dev/null");
				}

			if ($enable_queuemetrics_logging > 0)
				{
				$QM_LOGOFF = 'AGENTLOGOFF';
				if ($queuemetrics_loginout=='CALLBACK')
					{$QM_LOGOFF = 'AGENTCALLBACKLOGOFF';}

				$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
				if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
				mysqli_select_db($linkB, "$queuemetrics_dbname");

			#	$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='$campaign',agent='Agent/$user',verb='PAUSE',serverid='1';";
			#	if ($DB) {echo "$stmt\n";}
			#	
			#	$rslt=mysql_to_mysqli($stmt, $linkB);
			#	$affected_rows = mysqli_affected_rows($linkB);

				$logintime=0;
				$stmt = "SELECT time_id,data1 FROM queue_log where agent='Agent/$user' and verb IN('AGENTLOGIN','AGENTCALLBACKLOGIN') and time_id > $check_time order by time_id desc limit 1;";
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00139',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$li_conf_ct = mysqli_num_rows($rslt);
				$i=0;
				while ($i < $li_conf_ct)
					{
					$row=mysqli_fetch_row($rslt);
					$logintime =	$row[0];
					$loginphone =	$row[1];
					$i++;
					}

				$data4SQL='';
				$stmt="SELECT queuemetrics_phone_environment FROM vicidial_campaigns where campaign_id='$campaign' and queuemetrics_phone_environment!='';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00394',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$cqpe_ct = mysqli_num_rows($rslt);
				if ($cqpe_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$pe_append='';
					if ( ($queuemetrics_pe_phone_append > 0) and (strlen($row[0])>0) )
						{$pe_append = "-$qm_extension";}
					$data4SQL = ",data4='$row[0]$pe_append'";
					}

				$time_logged_in = ($StarTtime - $logintime);
				if ($time_logged_in > 1000000) {$time_logged_in=1;}

				if ($queuemetrics_loginout != 'NONE')
					{
					$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='$QM_LOGOFF',data1='$loginphone',data2='$time_logged_in',serverid='$queuemetrics_log_id' $data4SQL;";
					if ($DB) {echo "$stmt\n";}
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00140',$user,$server_ip,$session_name,$one_mysql_log);}
					$affected_rows = mysqli_affected_rows($linkB);
					}

				if ($queuemetrics_addmember_enabled > 0)
					{
					if ($queuemetrics_loginout == 'NONE')
						{
						$pause_typeSQL='';
						if ($queuemetrics_pause_type > 0)
							{$pause_typeSQL=",data5='AGENT'";}
						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='NONE',agent='Agent/$user',verb='PAUSEREASON',serverid='$queuemetrics_log_id',data1='LOGOFF'$pause_typeSQL;";
						if ($DB) {echo "$stmt\n";}
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00396',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);
						}
					if ( ($logintime < 1) or ($queuemetrics_loginout == 'NONE') )
						{
						$stmtB = "SELECT time_id,data3 FROM queue_log where agent='Agent/$user' and verb='PAUSEREASON' and data1='LOGIN' order by time_id desc limit 1;";
						$rsltB=mysql_to_mysqli($stmtB, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00365',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {echo "<BR>$stmtB\n";}
						$qml_ct = mysqli_num_rows($rsltB);
						if ($qml_ct > 0)
							{
							$row=mysqli_fetch_row($rsltB);
							$logintime =		$row[0];
							$loginphone =		$row[1];
							}
						}
					$stmt = "SELECT distinct queue FROM queue_log where time_id >= $logintime and agent='Agent/$user' and verb IN('ADDMEMBER','ADDMEMBER2') and queue != '$campaign' order by time_id desc;";
					$rslt=mysql_to_mysqli($stmt, $linkB);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00351',$user,$server_ip,$session_name,$one_mysql_log);}
					if ($DB) {echo "$stmt\n";}
					$amq_conf_ct = mysqli_num_rows($rslt);
					$i=0;
					while ($i < $amq_conf_ct)
						{
						$row=mysqli_fetch_row($rslt);
						$AMqueue[$i] =	$row[0];
						$i++;
						}

					### add the logged-in campaign as well
					$AMqueue[$i] = $campaign;
					$i++;
					$amq_conf_ct++;

					$i=0;
					while ($i < $amq_conf_ct)
						{
						$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='NONE',queue='$AMqueue[$i]',agent='Agent/$user',verb='REMOVEMEMBER',data1='$loginphone',serverid='$queuemetrics_log_id' $data4SQL;";
						$rslt=mysql_to_mysqli($stmt, $linkB);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00352',$user,$server_ip,$session_name,$one_mysql_log);}
						$affected_rows = mysqli_affected_rows($linkB);
						$i++;
						}
					}
				mysqli_close($linkB);
				}
			}

		echo "$vul_insert|$vc_remove|$vla_delete|$wcs_delete|$agent_channel|$vlia_delete\n";
		}
	$stage .= " $version $build";
	}


################################################################################
### UpdatEFavoritEs - update the astguiclient favorites list for this extension
################################################################################
if ($ACTION == 'UpdatEFavoritEs')
	{
	$row='';   $rowx='';
	$channel_live=1;
	if ( (strlen($favorites_list)<1) || (strlen($user)<1) || (strlen($exten)<1) )
		{
		echo _QXZ("favorites list %1s is not valid",0,'',$favorites_list)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt = "SELECT count(*) from phone_favorites where extension='$exten' and server_ip='$server_ip';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00172',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);

		if ($row[0] > 0)
			{
			$stmt="UPDATE phone_favorites set extensions_list=\"$favorites_list\" where extension='$exten' and server_ip='$server_ip';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00173',$user,$server_ip,$session_name,$one_mysql_log);}
			}
		else
			{
			$stmt="INSERT INTO phone_favorites values('$exten','$server_ip',\"$favorites_list\");";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00174',$user,$server_ip,$session_name,$one_mysql_log);}
			}
		}
		echo _QXZ("Favorites list has been updated to %1s for %2s",0,'',$favorites_list,$exten)."\n";
	}


################################################################################
### PauseCodeSubmit - Update vicidial_agent_log with pause code
################################################################################
if ($ACTION == 'PauseCodeSubmit')
	{
	$row='';   $rowx='';
	if ( (strlen($status)<1) or (strlen($agent_log_id)<1) )
		{
		echo _QXZ("agent_log_id %1s or pause_code %2s is not valid",0,'',$agent_log_id,$status)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmt="UPDATE vicidial_live_agents SET pause_code='$status',external_pause_code='' where user='$user';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00535',$VD_login,$server_ip,$session_name,$one_mysql_log);}
		$VLAPCaffected_rows_update = mysqli_affected_rows($link);

		### if this is the first pause code entry in a pause session, simply update and log to queue_log
		if ( ($stage < 1) or ($pause_to_code_jump > 0) )
			{
			$stmt="UPDATE vicidial_agent_log set sub_status=\"$status\",pause_type='AGENT' where agent_log_id >= '$agent_log_id' and user='$user' and ( (sub_status is NULL) or (sub_status='') )order by agent_log_id limit 2;";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00175',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			}
		### this is not the first pause code entry, insert new vicidial_agent_log entry
		else
			{
			$pause_sec=0;
			$stmt = "SELECT pause_epoch from vicidial_agent_log where agent_log_id='$agent_log_id';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00306',$user,$server_ip,$session_name,$one_mysql_log);}
			$VDpr_ct = mysqli_num_rows($rslt);
			if ($VDpr_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$pause_sec = ($StarTtime - $row[0]);
				}
			$stmt="UPDATE vicidial_agent_log set pause_sec='$pause_sec' where agent_log_id='$agent_log_id';";
				if ($format=='debug') {echo "\n<!-- $stmt -->";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00307',$user,$server_ip,$session_name,$one_mysql_log);}

			$user_group='';
			$stmt="SELECT user_group FROM vicidial_users where user='$user' LIMIT 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00308',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$ug_record_ct = mysqli_num_rows($rslt);
			if ($ug_record_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$user_group =		trim("$row[0]");
				}

			$stmt="INSERT INTO vicidial_agent_log (user,server_ip,event_time,campaign_id,pause_epoch,pause_sec,wait_epoch,user_group,sub_status,pause_type) values('$user','$server_ip','$NOW_TIME','$campaign','$StarTtime','0','$StarTtime','$user_group','$status','AGENT');";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00309',$user,$server_ip,$session_name,$one_mysql_log);}
			$affected_rows = mysqli_affected_rows($link);
			$agent_log_id = mysqli_insert_id($link);

			$stmt="UPDATE vicidial_live_agents SET agent_log_id='$agent_log_id',last_state_change='$NOW_TIME' where user='$user';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00310',$VD_login,$server_ip,$session_name,$one_mysql_log);}
			$VLAaffected_rows_update = mysqli_affected_rows($link);
			}

		### if entry accepted, add a queue_log entry if QM integration is enabled
		if ($affected_rows > 0) 
			{
			#############################################
			##### START QUEUEMETRICS LOGGING LOOKUP #####
			$stmt = "SELECT enable_queuemetrics_logging,queuemetrics_server_ip,queuemetrics_dbname,queuemetrics_login,queuemetrics_pass,queuemetrics_log_id,allow_sipsak_messages,queuemetrics_pe_phone_append,queuemetrics_pause_type FROM system_settings;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00176',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$qm_conf_ct = mysqli_num_rows($rslt);
			$i=0;
			while ($i < $qm_conf_ct)
				{
				$row=mysqli_fetch_row($rslt);
				$enable_queuemetrics_logging =	$row[0];
				$queuemetrics_server_ip	=		$row[1];
				$queuemetrics_dbname =			$row[2];
				$queuemetrics_login	=			$row[3];
				$queuemetrics_pass =			$row[4];
				$queuemetrics_log_id =			$row[5];
				$allow_sipsak_messages =		$row[6];
				$queuemetrics_pe_phone_append = $row[7];
				$queuemetrics_pause_type =		$row[8];
				$i++;
				}
			##### END QUEUEMETRICS LOGGING LOOKUP #####
			###########################################
			if ( ($enable_sipsak_messages > 0) and ($allow_sipsak_messages > 0) and (preg_match("/SIP/i",$protocol)) )
				{
				$extension = preg_replace("/\'|\"|\\\\|;/","",$extension);
				$phone_ip = preg_replace("/\'|\"|\\\\|;/","",$phone_ip);
				$SIPSAK_prefix = 'BK-';
				passthru("/usr/local/bin/sipsak -M -O desktop -B \"$SIPSAK_prefix$status\" -r 5060 -s sip:$extension@$phone_ip > /dev/null");
				}
			if ($enable_queuemetrics_logging > 0)
				{
				$pause_call_id='NONE';
				if (strlen($campaign_cid) > 12) {$pause_call_id = $campaign_cid;}
				if ( (preg_match("/^E/",$MDnextCID)) and (strlen($MDnextCID) > 19) ) {$pause_call_id = $MDnextCID;}
				$linkB=mysqli_connect("$queuemetrics_server_ip", "$queuemetrics_login", "$queuemetrics_pass");
				if (!$linkB) {die(_QXZ("Could not connect: ")."$queuemetrics_server_ip|$queuemetrics_login" . mysqli_connect_error());}
				mysqli_select_db($linkB, "$queuemetrics_dbname");

				$pause_typeSQL='';
				if ($queuemetrics_pause_type > 0)
					{$pause_typeSQL=",data5='AGENT'";}

				$stmt = "INSERT INTO queue_log SET `partition`='P01',time_id='$StarTtime',call_id='$pause_call_id',queue='NONE',agent='Agent/$user',verb='PAUSEREASON',serverid='$queuemetrics_log_id',data1='$status'$pause_typeSQL;";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $linkB);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkB,$mel,$stmt,'00177',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($linkB);

				mysqli_close($linkB);
				}
			}
		}
	echo _QXZ(" Pause Code %1s has been recorded",0,'',$status)."\nNext agent_log_id:\n" . $agent_log_id . "\n";
	$stage .= "|$pause_to_code_jump|$agent_log|$agent_log_id|$status|";
	}


################################################################################
### PauseCodeMgrApr - Manager approval of agent pause code
################################################################################
if ($ACTION == 'PauseCodeMgrApr')
	{
	$row='';   $rowx='';
	if ( (strlen($status)<1) or (strlen($MgrApr_user)<1) or (strlen($MgrApr_pass)<1) )
		{
		echo _QXZ("manager username %1s, password or pause_code %2s is not valid",0,'',$MgrApr_user,$status)."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$auth_message = user_authorization($MgrApr_user,$MgrApr_pass,'',0,0,0,0);
		if ($auth_message == 'GOOD')
			{
			$auth_pca=0;
			$stmt = "SELECT count(*) from vicidial_users where user='$MgrApr_user' and pause_code_approval='1';";
			if ($DB) {echo "$stmt\n";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00711',$user,$server_ip,$session_name,$one_mysql_log);}
			$VUpca_ct = mysqli_num_rows($rslt);
			if ($VUpca_ct > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$auth_pca = $row[0];
				}

			if ($auth_pca > 0)
				{
				### insert into the vicidial_agent_function_log table that the switch happened
				$stmt = "INSERT INTO vicidial_agent_function_log set agent_log_id='$agent_log_id',user='$user',function='mgrapr_pause_code',event_time=NOW(),campaign_id='$campaign',user_group='$user_group',lead_id='0',uniqueid='',caller_code='',stage='$MgrApr_user',comments='$status';";
				if ($DB) {echo "$stmt\n";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {$errno = mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00712',$user,$server_ip,$session_name,$one_mysql_log);}

				echo _QXZ("Manager Approval of Pause Code is Accepted %1s",0,'',$status)." STATUS:\n" . $auth_message . "\n";
				$stage .= "|$MgrApr_user|$status|$auth_message|";
				}
			else
				{
				echo _QXZ("Invalid Manager Permissions %1s",0,'',$MgrApr_user)." STATUS:\nBAD PERMISSIONS\n";
				$stage .= "|$MgrApr_user|$status|$auth_message|";
				}
			}
		else
			{
			echo _QXZ("Invalid Manager Credentials %1s",0,'',$MgrApr_user)." STATUS:\n" . $auth_message . "\n";
			$stage .= "|$MgrApr_user|$status|$auth_message|";
			}
		}
	}


################################################################################
### AGENTSview - List statuses of other agents in sidebar or xfer frame
################################################################################
if ($ACTION == 'AGENTSview')
	{
	$stmt="SELECT user_group from vicidial_users where user='$user';";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00573',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$VU_user_group =	$row[0];

	$agent_status_viewable_groupsSQL='';
	### Gather timeclock and shift enforcement restriction settings
	$stmt="SELECT agent_status_viewable_groups,agent_status_view_time from vicidial_user_groups where user_group='$VU_user_group';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00574',$VD_login,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$agent_status_viewable_groups = $row[0];
	$agent_status_viewable_groupsSQL = preg_replace('/\s\s/i','',$agent_status_viewable_groups);
	$agent_status_viewable_groupsSQL = preg_replace('/\s/i',"','",$agent_status_viewable_groupsSQL);
	$agent_status_viewable_groupsSQL = "user_group IN('$agent_status_viewable_groupsSQL')";
	$agent_status_view = 0;
	if (strlen($agent_status_viewable_groups) > 2)
		{$agent_status_view = 1;}
	$agent_status_view_time=0;
	if ($row[1] == 'Y')
		{$agent_status_view_time=1;}
	$andSQL='';
	if (preg_match("/ALL-GROUPS/",$agent_status_viewable_groups))
		{$AGENTviewSQL = "";}
	else
		{
		$AGENTviewSQL = "($agent_status_viewable_groupsSQL)";

		if (preg_match("/CAMPAIGN-AGENTS/",$agent_status_viewable_groups))
			{$AGENTviewSQL = "($AGENTviewSQL or (campaign_id='$campaign'))";}
		$AGENTviewSQL = "and $AGENTviewSQL";
		}
	if ($comments=='AgentXferViewSelect') 
		{
		if ($status == 'Y')
			{
			$AGENTviewSQL .= " and (vla.closer_campaigns LIKE \"% $group_name %\")";
			}
		else
			{
			$AGENTviewSQL .= " and (vla.closer_campaigns LIKE \"%AGENTDIRECT%\")";
			}
		}


	echo "<TABLE CELLPADDING=0 CELLSPACING=1>";
	### Gather agents data and statuses
	$agentviewlistSQL='';
	$j=0;
	$stmt="SELECT vla.user,vla.status,vu.full_name,UNIX_TIMESTAMP(last_call_time),UNIX_TIMESTAMP(last_call_finish),UNIX_TIMESTAMP(last_state_change) from vicidial_live_agents vla,vicidial_users vu where vla.user=vu.user $AGENTviewSQL order by vu.full_name;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00227',$VD_login,$server_ip,$session_name,$one_mysql_log);}
	if ($rslt) {$agents_count = mysqli_num_rows($rslt);}
	$loop_count=0;
	while ($agents_count > $loop_count)
		{
		$row=mysqli_fetch_row($rslt);
		$user =			$row[0];
		$status =		$row[1];
		$full_name =	$row[2];
		$call_start =	$row[3];
		$call_finish =	$row[4];
		$state_change = $row[5];
		$agentviewlistSQL .= "'$user',";

		if ( ($status=='READY') or ($status=='CLOSER') ) 
			{
			$statuscolor='#ADD8E6';
			$call_time = ($StarTtime - $state_change);
			}
		if ( ($status=='QUEUE') or ($status=='INCALL') ) 
			{
			$statuscolor='#D8BFD8';
			$call_time = ($StarTtime - $state_change);
			}
		if ($status=='PAUSED') 
			{
			$statuscolor='#F0E68C';
			$call_time = ($StarTtime - $state_change);
			}

		if ($call_time < 1)
			{
			$call_time = "0:00";
			}
		else
			{
			$Fminutes_M = ($call_time / 60);
			$Fminutes_M_int = floor($Fminutes_M);
			$Fminutes_M_int = intval("$Fminutes_M_int");
			$Fminutes_S = ($Fminutes_M - $Fminutes_M_int);
			$Fminutes_S = ($Fminutes_S * 60);
			$Fminutes_S = round($Fminutes_S, 0);
			if ($Fminutes_S < 10) {$Fminutes_S = "0$Fminutes_S";}
			$call_time = "$Fminutes_M_int:$Fminutes_S";
			}

		if ($comments=='AgentXferViewSelect') 
			{
			$AXVSuserORDER[$j] =	"$full_name$US$j";
			$AXVSuser[$j] =			$user;
			$AXVSfull_name[$j] =	$full_name;
			$AXVScall_time[$j] =	$call_time;
			$AXVSstatuscolor[$j] =	$statuscolor;
			$j++;
			}
		else
			{
			echo "<TR BGCOLOR=\"$statuscolor\"><TD><font style=\"font-size: 12px;  font-family: sans-serif;\"> &nbsp; ";
			echo "$row[0] - $row[2]";
			echo "&nbsp;</font></TD>";
			if ($agent_status_view_time > 0)
				{echo "<TD><font style=\"font-size: 12px;  font-family: sans-serif;\">&nbsp; $call_time &nbsp;</font></TD>";}
			echo "</TR>";
			}
		$loop_count++;
		}
	$agentviewlistSQL = preg_replace("/.$/i","",$agentviewlistSQL);
	if (strlen($agentviewlistSQL)<3)
		{$agentviewlistSQL = "''";}

	if (preg_match("/NOT-LOGGED-IN-AGENTS/",$agent_status_viewable_groups))
		{
		$stmt="SELECT user,full_name from vicidial_users where user NOT IN($agentviewlistSQL) order by full_name;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00301',$VD_login,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$agents_count = mysqli_num_rows($rslt);}
		$loop_count=0;
		while ($agents_count > $loop_count)
			{
			$row=mysqli_fetch_row($rslt);
			$user =			$row[0];
			$full_name =	$row[1];

			if ($comments=='AgentXferViewSelect') 
				{
				$AXVSuserORDER[$j] =	"$full_name$US$j";
				$AXVSuser[$j] =			$user;
				$AXVSfull_name[$j] =	$full_name;
				$AXVScall_time[$j] =	'0:00';
				$AXVSstatuscolor[$j] =	'white';
				$j++;
				}
			else
				{
				echo "<TR BGCOLOR=\"white\"><TD><font style=\"font-size: 12px;  font-family: sans-serif;\"> &nbsp; ";
				echo "$user - $full_name";
				echo "&nbsp;</font></TD>";
				if ($agent_status_view_time > 0)
					{echo "<TD><font style=\"font-size: 12px;  font-family: sans-serif;\">&nbsp; 0:00 &nbsp;</font></TD>";}
				echo "</TR>";
				}
			$loop_count++;
			}
		}

	### BEGIN Display the agent transfer select view ###
	$k=0;
	if ($comments=='AgentXferViewSelect') 
		{
		echo "<TABLE CELLPADDING=0 CELLSPACING=1><TR><TD VALIGN=TOP><TABLE CELLPADDING=0 CELLSPACING=1>";

		$AXVSrecords=100;
		$AXVScolumns=1;
		$AXVSfontsize='12px';
		if ($j > 30) {$AXVScolumns++;}
		if ($j > 60) {$AXVScolumns++;   $AXVSfontsize='11px';}
		if ($j > 90) {$AXVScolumns++;   $AXVSfontsize='10px';}
		if ($j > 120) {$AXVScolumns++;   $AXVSfontsize='9px';}
		$AXVSrecords = ($j / $AXVScolumns);
		$AXVSrecords = round($AXVSrecords, 0);
		$m=0;

		sort($AXVSuserORDER);
		while ($j > $k)
			{
			$order_split = explode("_",$AXVSuserORDER[$k]);
			$i = $order_split[1];

			echo "<TR BGCOLOR=\"$AXVSstatuscolor[$i]\"><TD><font style=\"font-size: $AXVSfontsize; font-family: sans-serif;\"> &nbsp; <a href=\"#\" onclick=\"AgentsXferSelect('$AXVSuser[$i]','AgentXferViewSelect');return false;\">$AXVSuser[$i] - $AXVSfull_name[$i]</a>&nbsp;</font></TD>";
			if ($agent_status_view_time > 0)
				{echo "<TD><font style=\"font-size: $AXVSfontsize;  font-family: sans-serif;\">&nbsp; $AXVScall_time[$i] &nbsp;</font></TD>";}
			echo "</TR>";

			$k++;
			$m++;
			if ($m >= $AXVSrecords)
				{
				echo "</TABLE></TD><TD VALIGN=TOP> &nbsp; </TD>";
				echo "<TD VALIGN=TOP><TABLE CELLPADDING=0 CELLSPACING=1>";
				$m=0;
				}
			}
		echo "</TD></TR></TABLE>";
		}

	echo "</TABLE><BR>\n";
	echo "<font style=\"font-size:10px;font-family:sans-serif;\"><font style=\"background-color:#ADD8E6;\"> &nbsp; &nbsp;</font>-"._QXZ("READY")." &nbsp; <font style=\"background-color:#D8BFD8;\">&nbsp; &nbsp;</font>-"._QXZ("INCALL")." &nbsp; <font style=\"background-color:#F0E68C;\"> &nbsp; &nbsp;</font>-"._QXZ("PAUSED")." &nbsp;\n";
	if (preg_match("/NOT-LOGGED-IN-AGENTS/",$agent_status_viewable_groups))
		{echo "<font style=\"background-color:#FFFFFF;\"> &nbsp; &nbsp;</font>"._QXZ("-LOGGED-OUT")." &nbsp;\n";}

	echo "</font>\n";
	}


################################################################################
### CALLSINQUEUEview - List calls in queue for the bottombar 228
################################################################################
if ($ACTION == 'CALLSINQUEUEview')
	{
	$stmt="SELECT view_calls_in_queue,grab_calls_in_queue from vicidial_campaigns where campaign_id='$campaign'";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00228',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$view_calls_in_queue =	$row[0];
	$grab_calls_in_queue =	$row[1];

	if (preg_match('/NONE/i',$view_calls_in_queue))
		{
		echo _QXZ("Calls in Queue View Disabled for this campaign")."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$view_calls_in_queue = preg_replace('/ALL/','99', $view_calls_in_queue);
	
		### grab the status and campaign/in-group information for this agent to display
		$ADsql='';
		$stmt="SELECT status,campaign_id,closer_campaigns from vicidial_live_agents where user='$user' and server_ip='$server_ip';";
		if ($DB) {echo "|$stmt|\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00229',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);
		$Alogin=$row[0];
		$Acampaign=$row[1];
		$AccampSQL=$row[2];
		$AccampSQL = preg_replace('/\s-/','', $AccampSQL);
		$AccampSQL = preg_replace('/\s/',"','", $AccampSQL);
		if (preg_match('/AGENTDIRECT/i', $AccampSQL))
			{
			$AccampSQL = preg_replace('/AGENTDIRECT/','', $AccampSQL);
			$ADsql = "or ( (campaign_id LIKE \"%AGENTDIRECT%\") and (agent_only='$user') )";
			}

		### grab the basic data on calls in the queue for this agent
		$stmt="SELECT lead_id,campaign_id,phone_number,uniqueid,UNIX_TIMESTAMP(call_time),call_type,auto_call_id from vicidial_auto_calls where status IN('LIVE') and ( (campaign_id='$Acampaign') or (campaign_id IN('$AccampSQL')) $ADsql) order by queue_priority,call_time;";
		if ($DB) {echo "|$stmt|\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00230',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$calls_count = mysqli_num_rows($rslt);}
		$loop_count=0;
		while ($calls_count > $loop_count)
			{
			$row=mysqli_fetch_row($rslt);
			$CQlead_id[$loop_count] =		$row[0];
			$CQcampaign_id[$loop_count] =	$row[1];
			$CQphone_number[$loop_count] =	$row[2];
			$CQuniqueid[$loop_count] =		$row[3];
			$CQcall_time[$loop_count] =		$row[4];
			$CQcall_type[$loop_count] =		$row[5];
			$CQauto_call_id[$loop_count] =	$row[6];
			$loop_count++;
			}

		### re-order the calls to always make sure the AGENTDIRECT calls are first
		$loop_count=0;
		$o=0;
		while ($calls_count > $loop_count)
			{
			if (preg_match('/AGENTDIRECT/i', $CQcampaign_id[$loop_count]))
				{
				$OQlead_id[$o] =		$CQlead_id[$loop_count];
				$OQcampaign_id[$o] =	$CQcampaign_id[$loop_count];
				$OQphone_number[$o] =	$CQphone_number[$loop_count];
				$OQuniqueid[$o] =		$CQuniqueid[$loop_count];
				$OQcall_time[$o] =		$CQcall_time[$loop_count];
				$OQcall_type[$o] =		$CQcall_type[$loop_count];
				$OQauto_call_id[$o] =	$CQauto_call_id[$loop_count];
				$o++;
				}
			$loop_count++;
			}
		$loop_count=0;
		while ($calls_count > $loop_count)
			{
			if (!preg_match('/AGENTDIRECT/i', $CQcampaign_id[$loop_count]))
				{
				$OQlead_id[$o] =		$CQlead_id[$loop_count];
				$OQcampaign_id[$o] =	$CQcampaign_id[$loop_count];
				$OQphone_number[$o] =	$CQphone_number[$loop_count];
				$OQuniqueid[$o] =		$CQuniqueid[$loop_count];
				$OQcall_time[$o] =		$CQcall_time[$loop_count];
				$OQcall_type[$o] =		$CQcall_type[$loop_count];
				$OQauto_call_id[$o] =	$CQauto_call_id[$loop_count];
				$o++;
				}
			$loop_count++;
			}

		echo "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
		echo "<TR>";
		echo "<TD> &nbsp; </TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("PHONE")." &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("FULL NAME")." &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("WAIT")." &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("AGENT")." &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"> &nbsp; &nbsp; &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("CALL GROUP")." &nbsp; </font></TD>";
		echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("TYPE")." &nbsp; </font></TD>";
		echo "</TR>";

		### Print call information and gather more info on the calls as they are printed
		$loop_count=0;
		while ( ($calls_count > $loop_count) and ($view_calls_in_queue > $loop_count) )
			{
			$call_time = ($StarTtime - $OQcall_time[$loop_count]);
			$Fminutes_M = ($call_time / 60);
			$Fminutes_M_int = floor($Fminutes_M);
			$Fminutes_M_int = intval("$Fminutes_M_int");
			$Fminutes_S = ($Fminutes_M - $Fminutes_M_int);
			$Fminutes_S = ($Fminutes_S * 60);
			$Fminutes_S = round($Fminutes_S, 0);
			if ($Fminutes_S < 10) {$Fminutes_S = "0$Fminutes_S";}
			$call_time = "$Fminutes_M_int:$Fminutes_S";
			$call_handle_method='';

			if ($OQcall_type[$loop_count]=='IN')
				{
				$stmt="SELECT group_name,group_color from vicidial_inbound_groups where group_id='$OQcampaign_id[$loop_count]';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00231',$user,$server_ip,$session_name,$one_mysql_log);}
				$row=mysqli_fetch_row($rslt);
				$group_name =			$row[0];
				$group_color =			$row[1];
				}
			$stmt="SELECT comments,user,first_name,last_name from vicidial_list where lead_id='$OQlead_id[$loop_count]'";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00232',$user,$server_ip,$session_name,$one_mysql_log);}
			$row=mysqli_fetch_row($rslt);
			$comments =		$row[0];
			$agent =		$row[1];
			$first_last_name =	"$row[2] $row[3]";
			$caller_name =	$first_last_name;

			$stmt="SELECT full_name from vicidial_users where user='$agent'";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00575',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($rslt) {$agent_name_count = mysqli_num_rows($rslt);}
			if ($agent_name_count > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$agent_name =		$row[0];
				}
			else
				{$agent_name='';}

			if (strlen($caller_name)<2)
				{$caller_name =	$comments;}
			if (strlen($caller_name) > 30) {$caller_name = substr("$caller_name", 0, 30);}

			if (preg_match("/0$|2$|4$|6$|8$/i", $loop_count)) {$Qcolor='bgcolor="#FCFCFC"';} 
			else{$Qcolor='bgcolor="#ECECEC"';}

			if ( (preg_match('/Y/i',$grab_calls_in_queue)) and ($OQcall_type[$loop_count]=='IN') )
				{
				echo "<TR $Qcolor>";
				echo "<TD> <a href=\"#\" onclick=\"callinqueuegrab('$OQauto_call_id[$loop_count]');return false;\"><font style=\"font-size: 11px; font-family: sans-serif;\">"._QXZ("TAKE CALL")."</a> &nbsp; </TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQphone_number[$loop_count] &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $caller_name &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $call_time &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $agent - $agent_name &nbsp; </font></TD>";
				echo "<TD bgcolor=\"$group_color\"><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; &nbsp; &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQcampaign_id[$loop_count] - $group_name &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQcall_type[$loop_count] &nbsp; </font></TD>";
				echo "</TR>";
				}
			else
				{
				echo "<TR $Qcolor>";
				echo "<TD> &nbsp; </TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQphone_number[$loop_count] &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $caller_name &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $call_time &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $agent - $agent_name &nbsp; </font></TD>";
				echo "<TD bgcolor=\"$group_color\"><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; &nbsp; &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQcampaign_id[$loop_count] - $group_name &nbsp; </font></TD>";
				echo "<TD><font style=\"font-size: 11px; font-family: sans-serif;\"> &nbsp; $OQcall_type[$loop_count] &nbsp; </font></TD>";
				echo "</TR>";
				}
			$loop_count++;
			}
		echo "</TABLE><BR> &nbsp;\n";
		}
	}


################################################################################
### CALLLOGview - display one day calls for an agent
################################################################################
if ($ACTION == 'CALLLOGview')
	{
	if (strlen($date) < 10)
		{$date = $NOW_DATE;}
	if (strlen($stage) < 3)
		{$stage = '670';}

	$date_array = explode("-",$date);
	$day_next = mktime(7, 0, 0, $date_array[1], ($date_array[2] + 1), $date_array[0]);
	$next_day_date = date("Y-m-d",$day_next);
	$day_old = mktime(7, 0, 0, $date_array[1], ($date_array[2] - 1), $date_array[0]);
	$past_day_date = date("Y-m-d",$day_old);
	$week_old = mktime(7, 0, 0, $date_array[1], ($date_array[2] - 7), $date_array[0]);
	$past_week_date = date("Y-m-d",$week_old);

	echo "<CENTER>\n";
	echo "<font style=\"font-size:14px;font-family:sans-serif;\"><B>";
	echo "<a href=\"#\" onclick=\"VieWCalLLoG('$past_week_date','');return false;\"> << $past_week_date</a> &nbsp; &nbsp; ";
	echo "<a href=\"#\" onclick=\"VieWCalLLoG('$past_day_date','');return false;\"> < $past_day_date</a> &nbsp; &nbsp; ";
	if ($NOW_DATE != $date)
		{echo "<a href=\"#\" onclick=\"VieWCalLLoG('$next_day_date','');return false;\"> $next_day_date > </a> &nbsp; &nbsp; ";}
	echo "<input type=text name=calllogdate id=calllogdate value=\"$date\" size=12 maxlength=10> ";
	echo "<a href=\"#\" onclick=\"VieWCalLLoG('','form');return false;\">"._QXZ("GO")."</a> &nbsp;  &nbsp; &nbsp; ";
	echo "<a href=\"#\" onclick=\"hideDiv('CalLLoGDisplaYBox');return false;\"> "._QXZ("close")." </a>";
	echo "</B></font>\n";
	echo "<BR>\n";
	echo "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
	echo "<TR>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:10px;font-family:sans-serif;\"><B> &nbsp; # &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DATE/TIME")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("LENGTH")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("STATUS")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("PHONE")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("FULL NAME")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("CAMPAIGN")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("IN/OUT")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("ALT")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("HANGUP")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("INFO")." &nbsp; </font></TD>";
	echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DIAL")." &nbsp; </font></TD>";
	echo "</TR>";


	$stmt="SELECT start_epoch,call_date,campaign_id,length_in_sec,status,phone_code,phone_number,lead_id,term_reason,alt_dial,comments from vicidial_log where user='$user' and call_date >= '$date 0:00:00'  and call_date <= '$date 23:59:59' order by call_date desc limit 10000;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00576',$user,$server_ip,$session_name,$one_mysql_log);}
	$out_logs_to_print = mysqli_num_rows($rslt);
	if ($format=='debug') {echo "|$out_logs_to_print|$stmt|";}

	$g=0;
	$u=0;
	while ($out_logs_to_print > $u) 
		{
		$row=mysqli_fetch_row($rslt);
		$ALLsort[$g] =			"$row[0]-----$g";
		$ALLstart_epoch[$g] =	$row[0];
		$ALLcall_date[$g] =		$row[1];
		$ALLcampaign_id[$g] =	$row[2];
		$ALLlength_in_sec[$g] =	$row[3];
		$ALLstatus[$g] =		$row[4];
		$ALLphone_code[$g] =	$row[5];
		$ALLphone_number[$g] =	$row[6];
		$ALLlead_id[$g] =		$row[7];
		$ALLhangup_reason[$g] =	$row[8];
		$ALLalt_dial[$g] =		$row[9];
		$ALLin_out[$g] =		"OUT-AUTO";
		if ($row[10] == 'MANUAL') {$ALLin_out[$g] = "OUT-MANUAL";}

		$stmtA="SELECT first_name,last_name FROM vicidial_list WHERE lead_id='$ALLlead_id[$g]';";
		$rsltA=mysql_to_mysqli($stmtA, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00577',$user,$server_ip,$session_name,$one_mysql_log);}
		$rowA=mysqli_fetch_row($rsltA);
		$Allfirst_name[$g] =	$rowA[0];
		$Alllast_name[$g] =		$rowA[1];

		$g++;
		$u++;
		}

	$stmt="SELECT start_epoch,call_date,campaign_id,length_in_sec,status,phone_code,phone_number,lead_id,term_reason,queue_seconds from vicidial_closer_log where user='$user' and call_date >= '$date 0:00:00'  and call_date <= '$date 23:59:59' order by closecallid desc limit 10000;";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00578',$user,$server_ip,$session_name,$one_mysql_log);}
	$in_logs_to_print = mysqli_num_rows($rslt);
	if ($format=='debug') {echo "|$in_logs_to_print|$stmt|";}

	$u=0;
	while ($in_logs_to_print > $u) 
		{
		$row=mysqli_fetch_row($rslt);
		$ALLsort[$g] =			"$row[0]-----$g";
		$ALLstart_epoch[$g] =	$row[0];
		$ALLcall_date[$g] =		$row[1];
		$ALLcampaign_id[$g] =	$row[2];
		$ALLlength_in_sec[$g] =	($row[3] - $row[9]);
		if ($ALLlength_in_sec[$g] < 0) {$ALLlength_in_sec[$g]=0;}
		$ALLstatus[$g] =		$row[4];
		$ALLphone_code[$g] =	$row[5];
		$ALLphone_number[$g] =	$row[6];
		$ALLlead_id[$g] =		$row[7];
		$ALLhangup_reason[$g] =	$row[8];
		$ALLalt_dial[$g] =		"MAIN";
		$ALLin_out[$g] =		"IN";

		$stmtA="SELECT first_name,last_name FROM vicidial_list WHERE lead_id='$ALLlead_id[$g]';";
		$rsltA=mysql_to_mysqli($stmtA, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00579',$user,$server_ip,$session_name,$one_mysql_log);}
		$rowA=mysqli_fetch_row($rsltA);
		$Allfirst_name[$g] =	$rowA[0];
		$Alllast_name[$g] =		$rowA[1];

		$g++;
		$u++;
		}

	if ($g > 0)
		{sort($ALLsort, SORT_NUMERIC);}
	else
		{echo "<tr bgcolor=white><td colspan=11 align=center>"._QXZ("No calls on this day")."</td></tr>";}

	$u=0;
	while ($g > $u) 
		{
		$sort_split = explode("-----",$ALLsort[$u]);
		$i = $sort_split[1];

		if (preg_match("/1$|3$|5$|7$|9$/i", $u))
			{$bgcolor='bgcolor="#B9CBFD"';} 
		else
			{$bgcolor='bgcolor="#9BB9FB"';}

		$phone_number_display = $ALLphone_number[$i];
		if ($disable_alter_custphone == 'HIDE')
			{$phone_number_display = 'XXXXXXXXXX';}
		$u++;
		echo "<tr $bgcolor>";
		echo "<td><font size=1>$u</td>";
		echo "<td align=right><font class='sb_text'>$ALLcall_date[$i]</td>";
		echo "<td align=right><font class='sb_text'> $ALLlength_in_sec[$i]</td>\n";
		echo "<td align=right><font class='sb_text'> $ALLstatus[$i]</td>\n";
		echo "<td align=right><font class='sb_text'> $ALLphone_code[$i] $phone_number_display </td>\n";
		echo "<td align=right><font class='sb_text'> $Allfirst_name[$i] $Alllast_name[$i] </td>\n";
		echo "<td align=right><font class='sb_text'> $ALLcampaign_id[$i] </td>\n";
		echo "<td align=right><font class='sb_text'> $ALLin_out[$i] </td>\n";
		echo "<td align=right><font class='sb_text'> $ALLalt_dial[$i] </td>\n";
		echo "<td align=right><font class='sb_text'> $ALLhangup_reason[$i] </td>\n";
		echo "<td align=right><font class='sb_text'> <a href=\"#\" onclick=\"VieWLeaDInfO($ALLlead_id[$i]);return false;\"> "._QXZ("INFO")."</A> </td>\n";
		if ($manual_dial_filter > 0)
			{echo "<td align=right><font class='sb_text'> <a href=\"#\" onclick=\"NeWManuaLDiaLCalL('CALLLOG','$ALLphone_code[$i]','$ALLphone_number[$i]','$ALLlead_id[$i]','','YES');return false;\"> "._QXZ("DIAL")." </A> </td>\n";}
		else
			{echo "<td align=right><font class='sb_text'> "._QXZ("DIAL")." </td>\n";}
		echo "</tr>\n";
		}

	echo "</TABLE>";
	echo "<BR>";
	echo "<a href=\"#\" onclick=\"CalLLoGVieWClose();return false;\">"._QXZ("Close Call Log")."</a>";
	echo "</CENTER>";
	}


################################################################################
### SEARCHRESULTSview - display search results for lead search
################################################################################
if ($ACTION == 'SEARCHRESULTSview')
	{
	if (strlen($stage) < 3)
		{$stage = '670';}

	$stmt="SELECT agent_lead_search_method,manual_dial_list_id from vicidial_campaigns where campaign_id='$campaign';";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00374',$user,$server_ip,$session_name,$one_mysql_log);}
	$camps_to_print = mysqli_num_rows($rslt);
	if ($camps_to_print > 0) 
		{
		$row=mysqli_fetch_row($rslt);
		$agent_lead_search_method =		$row[0];
		$manual_dial_list_id =			$row[1];

		$searchSQL='';
		$searchmethodSQL='';
	
		$lead_id=preg_replace("/[^0-9]/","",$lead_id);
		$vendor_lead_code = preg_replace("/\"|\\\\|;/","",$vendor_lead_code);
		$last_name = preg_replace("/\"|\\\\|;/","",$last_name);
		$first_name = preg_replace("/\"|\\\\|;/","",$first_name);
		$city = preg_replace("/\"|\\\\|;/","",$city);
		$state = preg_replace("/\"|\\\\|;/","",$state);
		$postal_code = preg_replace("/\"|\\\\|;/","",$postal_code);

		if (strlen($lead_id) > 0)
			{
			### lead ID entered, search by this
			$searchSQL = "lead_id='$lead_id'";
			}
		elseif (strlen($vendor_lead_code) > 0)
			{
			### vendor ID entered, search by this
			$searchSQL = "vendor_lead_code=\"$vendor_lead_code\"";
			}
		elseif ( (strlen($phone_number) >= 6) and (strlen($search) > 2) )
			{
			### phone number entered, search by this
			if (preg_match('/MAIN|ALT|ADDR3/',$search))
				{$searchSQL = "(";}
			if (preg_match('/MAIN/',$search))
				{$searchSQL .= "phone_number='$phone_number'";}
			if (preg_match('/ALT/',$search))
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " or ";}
				$searchSQL .= "alt_phone='$phone_number'";
				}
			if (preg_match('/ADDR3/',$search))
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " or ";}
				$searchSQL .= "address3='$phone_number'";
				}
			if (strlen($searchSQL) > 10)
				{$searchSQL .= ")";}
			}
		elseif (strlen($last_name) > 0)
			{
			### last name entered, search by this and other fields
			$searchSQL = "last_name=\"$last_name\"";
			if (strlen($first_name) > 0)
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " and ";}
				$searchSQL .= "first_name=\"$first_name\"";
				}
			if (strlen($city) > 0)
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " and ";}
				$searchSQL .= "city=\"$city\"";
				}
			if (strlen($state) > 0)
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " and ";}
				$searchSQL .= "state=\"$state\"";
				}
			if (strlen($postal_code) > 0)
				{
				if (strlen($searchSQL) > 10)
					{$searchSQL .= " and ";}
				$searchSQL .= "postal_code=\"$postal_code\"";
				}
			}
		else
			{
			echo "ERROR: "._QXZ("You must enter in search terms, one of these must be populated: lead ID, vendor ID, phone number, last name")."\n";
			echo "<BR><BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSDisplaYBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}

		$searchownerSQL='';
		### limit results to specified search method
		# USER_, GROUP_, TERRITORY_
		if (preg_match('/USER_/',$agent_lead_search_method))
			{$searchownerSQL=" and owner='$user'";}
		if (preg_match('/GROUP_/',$agent_lead_search_method))
			{
			$stmt="SELECT user_group from vicidial_users where user='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00386',$user,$server_ip,$session_name,$one_mysql_log);}
			$groups_to_parse = mysqli_num_rows($rslt);
			if ($groups_to_parse > 0) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$searchownerSQL=" and owner='$rowx[0]'";
				}
			}
		if (preg_match('/TERRITORY_/',$agent_lead_search_method))
			{
			$agent_territories='';
			$agent_choose_territories=0;
			$stmt="SELECT agent_choose_territories from vicidial_users where user='$user';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00404',$user,$server_ip,$session_name,$one_mysql_log);}
			$Uterrs_to_parse = mysqli_num_rows($rslt);
			if ($Uterrs_to_parse > 0) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$agent_choose_territories = $rowx[0];
				}

			if ($agent_choose_territories < 1)
				{
				$stmt="SELECT territory from vicidial_user_territories where user='$user';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00405',$user,$server_ip,$session_name,$one_mysql_log);}
				$vuts_to_parse = mysqli_num_rows($rslt);
				$o=0;
				while ($vuts_to_parse > $o) 
					{
					$rowx=mysqli_fetch_row($rslt);
					$agent_territories .= "'$rowx[0]',";
					$o++;
					}
				$agent_territories = preg_replace("/\,$/",'',$agent_territories);
				$searchownerSQL=" and owner IN($agent_territories)";
				if ($vuts_to_parse < 1)
					{$searchownerSQL=" and lead_id < 0";}
				}
			else
				{
				$stmt="SELECT agent_territories from vicidial_live_agents where user='$user';";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00387',$user,$server_ip,$session_name,$one_mysql_log);}
				$terrs_to_parse = mysqli_num_rows($rslt);
				if ($terrs_to_parse > 0) 
					{
					$rowx=mysqli_fetch_row($rslt);
					$agent_territories = $rowx[0];
					$agent_territories = preg_replace("/ -$|^ /",'',$agent_territories);
					$agent_territories = preg_replace("/ /","','",$agent_territories);
					$searchownerSQL=" and owner IN('$agent_territories')";
					}
				}
			}

		### limit results to specified search method
		# 'SYSTEM','CAMPAIGNLISTS','CAMPLISTS_ALL','LIST'
		if (preg_match('/SYSTEM/',$agent_lead_search_method))
			{$searchmethodSQL='';}
		if (preg_match('/LIST/',$agent_lead_search_method))
			{$searchmethodSQL=" and list_id='$manual_dial_list_id'";}
		if (preg_match('/CAMPLISTS_ALL/',$agent_lead_search_method))
			{
			$stmt="SELECT list_id from vicidial_lists where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00375',$user,$server_ip,$session_name,$one_mysql_log);}
			$lists_to_parse = mysqli_num_rows($rslt);
			$camp_lists='';
			$o=0;
			while ($lists_to_parse > $o) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$camp_lists .= "'$rowx[0]',";
				$o++;
				}
			$camp_lists = preg_replace("/.$/i","",$camp_lists);
			if (strlen($camp_lists)<2) {$camp_lists="''";}
			$searchmethodSQL=" and list_id IN($camp_lists)";
			}
		if (preg_match('/CAMPAIGNLISTS/',$agent_lead_search_method))
			{
			$stmt="SELECT list_id,active from vicidial_lists where campaign_id='$campaign' and active='Y';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00376',$user,$server_ip,$session_name,$one_mysql_log);}
			$lists_to_parse = mysqli_num_rows($rslt);
			$camp_lists='';
			$o=0;
			while ($lists_to_parse > $o) 
				{
				$rowx=mysqli_fetch_row($rslt);
				$camp_lists .= "'$rowx[0]',";
				$o++;
				}
			$camp_lists = preg_replace("/.$/i","",$camp_lists);
			if (strlen($camp_lists)<2) {$camp_lists="''";}
			$searchmethodSQL=" and list_id IN($camp_lists)";
			}


		##### BEGIN search queries and output #####
		$stmt="SELECT count(*) from vicidial_list where $searchSQL $searchownerSQL $searchmethodSQL;";

		### LOG INSERTION Search Log Table ###
		$SQL_log = "$stmt|";
		$SQL_log = preg_replace('/;/','',$SQL_log);
		$SQL_log = addslashes($SQL_log);
		$stmtL="INSERT INTO vicidial_lead_search_log set event_date='$NOW_TIME', user='$user', source='agent', results='0', search_query=\"$SQL_log\";";
		if ($DB) {echo "|$stmtL|\n";}
		$rslt=mysql_to_mysqli($stmtL, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00377',$user,$server_ip,$session_name,$one_mysql_log);}
		$search_log_id = mysqli_insert_id($link);

		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00378',$user,$server_ip,$session_name,$one_mysql_log);}
		$counts_to_print = mysqli_num_rows($rslt);
		if ($counts_to_print > 0) 
			{
			$row=mysqli_fetch_row($rslt);
			$search_result_count =		$row[0];

			$end_process_time = date("U");
			$search_seconds = ($end_process_time - $StarTtime);

			$stmtL="UPDATE vicidial_lead_search_log set results='$search_result_count',seconds='$search_seconds' where search_log_id='$search_log_id';";
			if ($DB) {echo "|$stmtL|\n";}
			$rslt=mysql_to_mysqli($stmtL, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00379',$user,$server_ip,$session_name,$one_mysql_log);}


			echo "<CENTER>\n";
			echo "<font style=\"font-size:14px;font-family:sans-serif;\"><B>";
			echo _QXZ("Results Found:")." $search_result_count";
			echo "</B></font>\n";
			echo "<BR>\n";
			echo "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
			echo "<TR>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:10px;font-family:sans-serif;\"><B> &nbsp; # &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("FULL NAME")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("PHONE")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("STATUS")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("LAST CALL")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("CITY")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("STATE")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("ZIP")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("VENDOR ID")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("INFO")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DIAL")." &nbsp; </font></TD>";
			echo "</TR>";

			if ($search_result_count)
				{
				$stmt="SELECT first_name,last_name,phone_code,phone_number,status,last_local_call_time,lead_id,city,state,postal_code,vendor_lead_code from vicidial_list where $searchSQL $searchownerSQL $searchmethodSQL order by last_local_call_time desc limit 1000;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00380',$user,$server_ip,$session_name,$one_mysql_log);}
				$out_logs_to_print = mysqli_num_rows($rslt);
				if ($format=='debug') {echo "|$out_logs_to_print|$stmt|";}

				$g=0;
				$u=0;
				while ($out_logs_to_print > $u) 
					{
					$row=mysqli_fetch_row($rslt);
					$ALLsort[$g] =				"$row[0]-----$g";
					$ALLname[$g] =				"$row[0] $row[1]";
					$ALLphone_code[$g] =		$row[2];
					$ALLphone_number[$g] =		$row[3];
					$ALLstatus[$g] =			$row[4];
					$ALLcall_date[$g] =			$row[5];
					$ALLlead_id[$g] =			$row[6];
					$ALLcity[$g] =				$row[7];
					$ALLstate[$g] =				$row[8];
					$ALLpostal_code[$g] =		$row[9];
					$ALLvendor_lead_code[$g] =	$row[10];

					$g++;
					$u++;
					}

				if ($g < 1)
					{echo "<tr bgcolor=white><td colspan=10 align=center><font class='sh_text'>"._QXZ("No results found")."</font></td></tr>";}

				$u=0;
				while ($g > $u) 
					{
					$sort_split = explode("-----",$ALLsort[$u]);
					$i = $sort_split[1];

					if (preg_match("/1$|3$|5$|7$|9$/i", $u))
						{$bgcolor='bgcolor="#B9CBFD"';} 
					else
						{$bgcolor='bgcolor="#9BB9FB"';}

					$u++;
					echo "<tr $bgcolor>";
					echo "<td><font size=1>$u</td>";
					echo "<td align=right><font class=\"sb_text\">$ALLname[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLphone_code[$i] $ALLphone_number[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLstatus[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLcall_date[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLcity[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLstate[$i]</font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLpostal_code[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> $ALLvendor_lead_code[$i] </font></td>\n";
					echo "<td align=right><font class=\"sb_text\"> <a href=\"#\" onclick=\"VieWLeaDInfO($ALLlead_id[$i],'','$inbound_lead_search');return false;\"> "._QXZ("INFO")." </A> </font></td>\n";
					if ($inbound_lead_search < 1)
						{
						if ($manual_dial_filter > 0)
							{echo "<td align=right><font class=\"sb_text\"> <a href=\"#\" onclick=\"NeWManuaLDiaLCalL('LEADSEARCH','$ALLphone_code[$i]','$ALLphone_number[$i]','$ALLlead_id[$i]','','YES');return false;\"> "._QXZ("DIAL")." </A> </font></td>\n";}
						else
							{echo "<td align=right><font class=\"sb_text\"> "._QXZ("DIAL")." </font></td>\n";}
						}
					else
						{
						echo "<td align=right><font class=\"sb_text\"> <a href=\"#\" onclick=\"LeaDSearcHSelecT('$ALLlead_id[$i]');return false;\">"._QXZ("SELECT")."</A> </font></td>\n";
						}
					echo "</tr>\n";
					}

				$end_process_time = date("U");
				$search_seconds = ($end_process_time - $StarTtime);

				$stmtL="UPDATE vicidial_lead_search_log set seconds='$search_seconds' where search_log_id='$search_log_id';";
				if ($DB) {echo "|$stmtL|\n";}
				$rslt=mysql_to_mysqli($stmtL, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtL,'00381',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			else
				{echo "<tr bgcolor=white><td colspan=10 align=center><font class='sh_text'>"._QXZ("No results found")."</font></td></tr>";}

			echo "</TABLE>";
			echo "<BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSDisplaYBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			}
		else
			{
			echo "ERROR: "._QXZ("There was a problem with your search terms")."\n";
			echo "<BR><BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSDisplaYBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		##### END search queries and output #####
		}
	else
		{
		echo "ERROR: "._QXZ("Campaign not found")."\n";
		echo "<BR><BR>";
		echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSDisplaYBox');return false;\">"._QXZ("Go Back")."</a>";
		echo "</CENTER>";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	}



################################################################################
### SEARCHCONTACTSRESULTSview - display search results for contacts search
################################################################################
if ($ACTION == 'SEARCHCONTACTSRESULTSview')
	{
	if (strlen($stage) < 3)
		{$stage = '670';}

	$stmt="SELECT agent_lead_search_method,manual_dial_list_id from vicidial_campaigns where campaign_id='$campaign';";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00431',$user,$server_ip,$session_name,$one_mysql_log);}
	$camps_to_print = mysqli_num_rows($rslt);
	if ($camps_to_print > 0) 
		{
		$row=mysqli_fetch_row($rslt);
		$agent_lead_search_method =		$row[0];
		$manual_dial_list_id =			$row[1];

		$searchSQL='';
		$searchmethodSQL='';

		$last_name = preg_replace("/\'|\"|\\\\|;/","",$last_name);
		$first_name = preg_replace("/\'|\"|\\\\|;/","",$first_name);
		$phone_number = preg_replace("/\'|\"|\\\\|;/","",$phone_number);
		$bu_name = preg_replace("/\'|\"|\\\\|;/","",$bu_name);
		$department = preg_replace("/\'|\"|\\\\|;/","",$department);
		$group_name = preg_replace("/\'|\"|\\\\|;/","",$group_name);
		$job_title = preg_replace("/\'|\"|\\\\|;/","",$job_title);
		$location = preg_replace("/\'|\"|\\\\|;/","",$location);

		if (strlen($phone_number) >= 2)
			{
			$searchSQL .= "office_num='$phone_number'";
			}
		elseif (strlen($last_name) > 0)
			{
			$searchSQL = "last_name=\"$last_name\"";
			if (strlen($first_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "first_name=\"$first_name\"";
				}
			if (strlen($bu_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "bu_name=\"$bu_name\"";
				}
			if (strlen($department) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "department=\"$department\"";
				}
			if (strlen($group_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "group_name=\"$group_name\"";
				}
			if (strlen($job_title) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "job_title=\"$job_title\"";
				}
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($first_name) > 0)
			{
			$searchSQL = "first_name=\"$first_name\"";
			if (strlen($bu_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "bu_name=\"$bu_name\"";
				}
			if (strlen($department) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "department=\"$department\"";
				}
			if (strlen($group_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "group_name=\"$group_name\"";
				}
			if (strlen($job_title) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "job_title=\"$job_title\"";
				}
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($bu_name) > 0)
			{
			$searchSQL = "bu_name=\"$bu_name\"";
			if (strlen($department) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "department=\"$department\"";
				}
			if (strlen($group_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "group_name=\"$group_name\"";
				}
			if (strlen($job_title) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "job_title=\"$job_title\"";
				}
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($department) > 0)
			{
			$searchSQL = "department=\"$department\"";
			if (strlen($group_name) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "group_name=\"$group_name\"";
				}
			if (strlen($job_title) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "job_title=\"$job_title\"";
				}
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($group_name) > 0)
			{
			$searchSQL = "group_name=\"$group_name\"";
			if (strlen($job_title) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "job_title=\"$job_title\"";
				}
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($job_title) > 0)
			{
			$searchSQL = "job_title=\"$job_title\"";
			if (strlen($location) > 0)
				{
				if (strlen($searchSQL) > 10) {$searchSQL .= " and ";}
				$searchSQL .= "location=\"$location\"";
				}
			}
		elseif (strlen($location) > 0)
			{
			$searchSQL = "location=\"$location\"";
			}
		else
			{
			echo "ERROR: "._QXZ("You must enter in search terms, one of these must be populated: office number, last name, first name")."\n";
			echo "<BR><BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSContactsBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}

		##### BEGIN search queries and output #####
		$stmt="SELECT count(*) from contact_information where $searchSQL;";

		### LOG INSERTION Search Log Table ###
		$SQL_log = "$stmt|";
		$SQL_log = preg_replace('/;/','',$SQL_log);
		$SQL_log = addslashes($SQL_log);
		$stmtL="INSERT INTO vicidial_lead_search_log set event_date='$NOW_TIME', user='$user', source='agent', results='0', search_query=\"$SQL_log\";";
		if ($DB) {echo "|$stmtL|\n";}
		$rslt=mysql_to_mysqli($stmtL, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtL,'00432',$user,$server_ip,$session_name,$one_mysql_log);}
		$search_log_id = mysqli_insert_id($link);

		if ( (preg_match("/contact_information/",$tables_use_alt_log_db)) and (strlen($alt_log_server_ip)>4) and (strlen($alt_log_dbname)>0) )
			{
			$linkALT=mysqli_connect("$alt_log_server_ip", "$alt_log_login", "$alt_log_pass");
			if (!$linkALT) {die(_QXZ("Could not connect: ")."$alt_log_server_ip|$alt_log_login" . mysqli_connect_error());}
			mysqli_select_db($linkALT, "$alt_log_dbname");
			}
		else
			{$linkALT = $link;}

		$rsltALT=mysql_to_mysqli($stmt, $linkALT);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkALT,$mel,$stmt,'00433',$user,$server_ip,$session_name,$one_mysql_log);}
		$counts_to_print = mysqli_num_rows($rsltALT);
		if ($counts_to_print > 0)
			{
			$row=mysqli_fetch_row($rsltALT);
			$search_result_count =		$row[0];

			$end_process_time = date("U");
			$search_seconds = ($end_process_time - $StarTtime);

			$stmtL="UPDATE vicidial_lead_search_log set results='$search_result_count',seconds='$search_seconds' where search_log_id='$search_log_id';";
			if ($DB) {echo "|$stmtL|\n";}
			$rslt=mysql_to_mysqli($stmtL, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtL,'00434',$user,$server_ip,$session_name,$one_mysql_log);}

			echo "<CENTER>\n";
			echo "<font style=\"font-size:14px;font-family:sans-serif;\"><B>";
			echo _QXZ("Results Found:")." $search_result_count";
			echo "</B></font>\n";
			echo "<BR>\n";
			echo "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
			echo "<TR>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:10px;font-family:sans-serif;\"><B> &nbsp; # &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("FIRST NAME")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("LAST NAME")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("OFFICE")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("MOBILE")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("OTHER 1")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("OTHER 2")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("BU NAME")." &nbsp; </font></TD>";
			echo "</TR>";

			if ($search_result_count)
				{
				$stmt="SELECT first_name,last_name,office_num,cell_num,other_num1,other_num2,bu_name,department,group_name,job_title,location from contact_information where $searchSQL order by first_name,last_name desc limit 1000;";
				$rsltALT=mysql_to_mysqli($stmt, $linkALT);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$linkALT,$mel,$stmt,'00435',$user,$server_ip,$session_name,$one_mysql_log);}
				$out_logs_to_print = mysqli_num_rows($rsltALT);
				if ($format=='debug') {echo "|$out_logs_to_print|$stmt|";}

				$g=0;
				$u=0;
				while ($out_logs_to_print > $u) 
					{
					$row=mysqli_fetch_row($rsltALT);
					$ALLsort[$g] =			"$row[0]-----$g";
					$ALLfirst[$g] =			$row[0];
					$ALLlast[$g] =			$row[1];
					$ALLoffice_num[$g] =	$row[2];
					$ALLcell_num[$g] =		$row[3];
					$ALLother_num1[$g] =	$row[4];
					$ALLother_num2[$g] =	$row[5];
					$ALLbu_name[$g] =		$row[6];
					$ALLdepartment[$g] =	$row[7];
					$ALLgroup_name[$g] =	$row[8];
					$ALLjob_title[$g] =		$row[9];
					$ALLlocation[$g] =		$row[10];

					$g++;
					$u++;
					}

				if ($g < 1)
					{echo "<tr bgcolor=white><td colspan=10 align=center>"._QXZ("No results found")."</td></tr>";}

				$u=0;
				while ($g > $u) 
					{
					$sort_split = explode("-----",$ALLsort[$u]);
					$i = $sort_split[1];

					if (preg_match("/1$|3$|5$|7$|9$/i", $u))
						{$bgcolor='bgcolor="#B9CBFD"';} 
					else
						{$bgcolor='bgcolor="#9BB9FB"';}

					$u++;
					echo "<tr $bgcolor>";
					echo "<td><font size=1>$u </td>";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\">$ALLfirst[$i] </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\">$ALLlast[$i] </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\"> &nbsp; <a href=\"#\" onclick=\"PresetSelect_submit('$ALLfirst[$i] $ALLlast[$i]','$ALLoffice_num[$i]','','N','Y');return false;\">$ALLoffice_num[$i]</a> </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\"> &nbsp; <a href=\"#\" onclick=\"PresetSelect_submit('$ALLfirst[$i] $ALLlast[$i]','$ALLcell_num[$i]','','N','Y');return false;\">$ALLcell_num[$i]</a> </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\"> &nbsp; <a href=\"#\" onclick=\"PresetSelect_submit('$ALLfirst[$i] $ALLlast[$i]','$ALLother_num1[$i]','','N','Y');return false;\">$ALLother_num1[$i]</a> </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\"> &nbsp; <a href=\"#\" onclick=\"PresetSelect_submit('$ALLfirst[$i] $ALLlast[$i]','$ALLother_num2[$i]','','N','Y');return false;\">$ALLother_num2[$i]</a> </td>\n";
					echo "<td align=left> <font size=3 face=\"Arial, Helvetica, sans-serif\">$ALLbu_name[$i] </td>\n";
					echo "</tr>\n";
					echo "<tr $bgcolor>";
					echo "<td colspan=8><font class='sh_text'> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <B>"._QXZ("Dept:")."</B> $ALLdepartment[$i] &nbsp; &nbsp; &nbsp; <B>"._QXZ("Group").":</B> $ALLgroup_name[$i] &nbsp; &nbsp; &nbsp; <B>"._QXZ("Job:")."</B> $ALLjob_title[$i] &nbsp; &nbsp; &nbsp; <B>"._QXZ("Location:")."</B> $ALLlocation[$i]</td>";
					echo "</tr>\n";
					}

				$end_process_time = date("U");
				$search_seconds = ($end_process_time - $StarTtime);

				$stmtL="UPDATE vicidial_lead_search_log set seconds='$search_seconds' where search_log_id='$search_log_id';";
				if ($DB) {echo "|$stmtL|\n";}
				$rslt=mysql_to_mysqli($stmtL, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtL,'00436',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			else
				{echo "<tr bgcolor=white><td colspan=10 align=center>"._QXZ("No results found")."</td></tr>";}

			echo "</TABLE>";
			echo "<BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSContactsBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			}
		else
			{
			echo "ERROR: "._QXZ("There was a problem with your search terms")."\n";
			echo "<BR><BR>";
			echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSContactsBox');return false;\">"._QXZ("Go Back")."</a>";
			echo "</CENTER>";
			if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
			exit;
			}
		##### END search queries and output #####
		}
	else
		{
		echo "ERROR: "._QXZ("Campaign not found")."\n";
		echo "<BR><BR>";
		echo "<a href=\"#\" onclick=\"hideDiv('SearcHResultSContactsBox');return false;\">"._QXZ("Go Back")."</a>";
		echo "</CENTER>";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	}



################################################################################
### LEADINFOview - display the information for a lead and logs for that lead
################################################################################
if ($ACTION == 'LEADINFOview')
	{
	if (strlen($lead_id) < 1)
		{echo "ERROR: "._QXZ("no Lead ID");}
	else
		{
		$hide_dial_links=0;
		echo "<CENTER>\n";

		if ($search == 'logfirst')
			{$hide_dial_links++;}

		if ($inbound_lead_search > 0)
			{$hide_dial_links++;}

		### BEGIN Display callback information ###
		$callback_id = preg_replace('/\D/','',$callback_id);
		if (strlen($callback_id) > 0)
			{
			$stmt="SELECT status,entry_time,callback_time,modify_date,user,recipient,comments,lead_status from vicidial_callbacks where lead_id='$lead_id' and callback_id='$callback_id' limit 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00397',$user,$server_ip,$session_name,$one_mysql_log);}
			$cb_to_print = mysqli_num_rows($rslt);
			if ($format=='debug') {echo "|$cb_to_print|$stmt|";}
			if ($cb_to_print > 0)
				{
				$row=mysqli_fetch_row($rslt);
				echo "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=500>";
				echo "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Callback Status:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>"._QXZ("$row[0]")."</td></tr>";
				echo "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Callback Lead Status:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[7]</td></tr>";
				echo "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Callback Entry Time:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[1]</td></tr>";
				echo "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Callback Trigger Time:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[2]</td></tr>";
				echo "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Callback Comments:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[6]</td></tr>";
				echo "</TABLE>";
				echo "<BR>";
				$hide_dial_links++;
				}
			}
		### END Display callback information ###

		### find the screen_label for this campaign
		$stmt="SELECT screen_labels,hide_call_log_info from vicidial_campaigns where campaign_id='$campaign';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00416',$user,$server_ip,$session_name,$one_mysql_log);}
		$csl_to_print = mysqli_num_rows($rslt);
		if ($format=='debug') {echo "|$csl_to_print|$stmt|";}
		if ($csl_to_print > 0)
			{
			$row=mysqli_fetch_row($rslt);
			$screen_labels =		$row[0];
			$hide_call_log_info =	$row[1];
			}

		### BEGIN Display lead info and custom fields ###
		### BEGIN find any custom field labels ###
		$INFOout='';
		$label_title =				_QXZ(" Title");
		$label_first_name =			_QXZ("First");
		$label_middle_initial =		_QXZ("MI");
		$label_last_name =			_QXZ("Last ");
		$label_address1 =			_QXZ("Address1");
		$label_address2 =			_QXZ("Address2");
		$label_address3 =			_QXZ("Address3");
		$label_city =				_QXZ("City");
		$label_state =				_QXZ(" State");
		$label_province =			_QXZ("Province");
		$label_postal_code =		_QXZ("PostCode");
		$label_vendor_lead_code =	_QXZ("Vendor ID");
		$label_gender =				_QXZ(" Gender");
		$label_phone_number =		_QXZ("Phone");
		$label_phone_code =			_QXZ("DialCode");
		$label_alt_phone =			_QXZ("Alt. Phone");
		$label_security_phrase =	_QXZ("Show");
		$label_email =				_QXZ(" Email");
		$label_comments =			_QXZ(" Comments");

		$stmt="SELECT label_title,label_first_name,label_middle_initial,label_last_name,label_address1,label_address2,label_address3,label_city,label_state,label_province,label_postal_code,label_vendor_lead_code,label_gender,label_phone_number,label_phone_code,label_alt_phone,label_security_phrase,label_email,label_comments,label_hide_field_logs from system_settings;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00417',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);
		if (strlen($row[0])>0)	{$label_title =				$row[0];}
		if (strlen($row[1])>0)	{$label_first_name =		$row[1];}
		if (strlen($row[2])>0)	{$label_middle_initial =	$row[2];}
		if (strlen($row[3])>0)	{$label_last_name =			$row[3];}
		if (strlen($row[4])>0)	{$label_address1 =			$row[4];}
		if (strlen($row[5])>0)	{$label_address2 =			$row[5];}
		if (strlen($row[6])>0)	{$label_address3 =			$row[6];}
		if (strlen($row[7])>0)	{$label_city =				$row[7];}
		if (strlen($row[8])>0)	{$label_state =				$row[8];}
		if (strlen($row[9])>0)	{$label_province =			$row[9];}
		if (strlen($row[10])>0) {$label_postal_code =		$row[10];}
		if (strlen($row[11])>0) {$label_vendor_lead_code =	$row[11];}
		if (strlen($row[12])>0) {$label_gender =			$row[12];}
		if (strlen($row[13])>0) {$label_phone_number =		$row[13];}
		if (strlen($row[14])>0) {$label_phone_code =		$row[14];}
		if (strlen($row[15])>0) {$label_alt_phone =			$row[15];}
		if (strlen($row[16])>0) {$label_security_phrase =	$row[16];}
		if (strlen($row[17])>0) {$label_email =				$row[17];}
		if (strlen($row[18])>0) {$label_comments =			$row[18];}
		$label_hide_field_logs =	$row[19];

		if ( ($screen_labels != '--SYSTEM-SETTINGS--') and (strlen($screen_labels)>1) )
			{
			$stmt="SELECT label_title,label_first_name,label_middle_initial,label_last_name,label_address1,label_address2,label_address3,label_city,label_state,label_province,label_postal_code,label_vendor_lead_code,label_gender,label_phone_number,label_phone_code,label_alt_phone,label_security_phrase,label_email,label_comments,label_hide_field_logs from vicidial_screen_labels where label_id='$screen_labels' and active='Y' limit 1;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00418',$user,$server_ip,$session_name,$one_mysql_log);}
			$screenlabels_count = mysqli_num_rows($rslt);
			if ($screenlabels_count > 0)
				{
				$row=mysqli_fetch_row($rslt);
				if (strlen($row[0])>0)	{$label_title =				$row[0];}
				if (strlen($row[1])>0)	{$label_first_name =		$row[1];}
				if (strlen($row[2])>0)	{$label_middle_initial =	$row[2];}
				if (strlen($row[3])>0)	{$label_last_name =			$row[3];}
				if (strlen($row[4])>0)	{$label_address1 =			$row[4];}
				if (strlen($row[5])>0)	{$label_address2 =			$row[5];}
				if (strlen($row[6])>0)	{$label_address3 =			$row[6];}
				if (strlen($row[7])>0)	{$label_city =				$row[7];}
				if (strlen($row[8])>0)	{$label_state =				$row[8];}
				if (strlen($row[9])>0)	{$label_province =			$row[9];}
				if (strlen($row[10])>0) {$label_postal_code =		$row[10];}
				if (strlen($row[11])>0) {$label_vendor_lead_code =	$row[11];}
				if (strlen($row[12])>0) {$label_gender =			$row[12];}
				if (strlen($row[13])>0) {$label_phone_number =		$row[13];}
				if (strlen($row[14])>0) {$label_phone_code =		$row[14];}
				if (strlen($row[15])>0) {$label_alt_phone =			$row[15];}
				if (strlen($row[16])>0) {$label_security_phrase =	$row[16];}
				if (strlen($row[17])>0) {$label_email =				$row[17];}
				if (strlen($row[18])>0) {$label_comments =			$row[18];}
				$label_hide_field_logs =	$row[19];
				### END find any custom field labels ###
				$hide_gender=0;
				if ($label_gender == '---HIDE---')
					{$hide_gender=1;}
				}
			}
		### END find any custom field labels ###

		$INFOout .= "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=500>";

		$stmt="SELECT status,vendor_lead_code,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id from vicidial_list where lead_id='$lead_id' limit 1;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00398',$user,$server_ip,$session_name,$one_mysql_log);}
		$info_to_print = mysqli_num_rows($rslt);
		if ($format=='debug') {$INFOout .= "|$out_logs_to_print|$stmt|";}

		if ($info_to_print > 0)
			{
			$row=mysqli_fetch_row($rslt);

			##### BEGIN check for postal_code and phone time zones if alert enabled
			$post_phone_time_diff_alert_message='';
			$stmt="SELECT post_phone_time_diff_alert,local_call_time FROM vicidial_campaigns where campaign_id='$campaign';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00415',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$camp_pptda_ct = mysqli_num_rows($rslt);
			if ($camp_pptda_ct > 0)
				{
				$rowx=mysqli_fetch_row($rslt);
				$post_phone_time_diff_alert =	$rowx[0];
				$local_call_time =				$rowx[1];
				}
			if ( ($post_phone_time_diff_alert == 'ENABLED') or (preg_match("/OUTSIDE_CALLTIME/",$post_phone_time_diff_alert)) )
				{
				$lead_list_id = $row[2];
				$phone_code =	$row[5];
				$phone_number = $row[6];
				$state =		$row[15];
				$postal_code =	$row[17];

				### get current gmt_offset of the phone_number
				$postalgmtNOW = '';
				$USarea = substr($phone_number, 0, 3);
				$PHONEgmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmtNOW,$postal_code);

				$postalgmtNOW = 'POSTAL';
				$POSTgmt_offset = lookup_gmt($phone_code,$USarea,$state,$LOCAL_GMT_OFF_STD,$Shour,$Smin,$Ssec,$Smon,$Smday,$Syear,$postalgmtNOW,$postal_code);

				### Get local_call_time for list
				$stmt="SELECT local_call_time,list_description FROM vicidial_lists where list_id='$lead_list_id';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00610',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$rowy=mysqli_fetch_row($rslt);
				$list_local_call_time =	$rowy[0];
				$list_description =		$rowy[1];

				# check that call time exists
				if ($list_local_call_time != "campaign") 
					{
					$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$list_local_call_time';";
					$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00615',$user,$server_ip,$session_name,$one_mysql_log);}					
					$rowc=mysqli_fetch_row($rslt);
					$call_time_exists  =	$rowc[0];
					if ($call_time_exists < 1) 
						{$list_local_call_time = 'campaign';}
					}

				#Check if we are within the gmt for campaign for $PHONEdialable
				if ( (dialable_gmt($DB,$link,$local_call_time,$PHONEgmt_offset,$state) == 1) and ($list_local_call_time != "campaign") )
					{
					#Now check if we are with the GMT for the list local call time
					$PHONEdialable = dialable_gmt($DB,$link,$list_local_call_time,$PHONEgmt_offset,$state);
					}
				else 
					{
					$PHONEdialable = dialable_gmt($DB,$link,$local_call_time,$PHONEgmt_offset,$state);
					}

				#Check if we are with the gmt for campaign for $POSTdialable
				if ( (dialable_gmt($DB,$link,$local_call_time,$POSTgmt_offset,$state) == 1) and ($list_local_call_time != "campaign") )
					{
					#Now check if we are with the GMT for the list local call time
					$POSTdialable = dialable_gmt($DB,$link,$list_local_call_time,$POSTgmt_offset,$state);
					}
				else 
					{
					$POSTdialable = dialable_gmt($DB,$link,$local_call_time,$POSTgmt_offset,$state);
					}
			#	$post_phone_time_diff_alert_message = "$POSTgmt_offset|$POSTdialable|$postal_code   ---   $PHONEgmt_offset|$PHONEdialable|$USarea";
				$post_phone_time_diff_alert_message = '';

				if ($PHONEgmt_offset != $POSTgmt_offset)
					{
					$post_phone_time_diff_alert_message .= _QXZ("Phone and Post Code Time Zone Mismatch! ");

					if ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_ONLY')
						{
						$post_phone_time_diff_alert_message='';
						if ($PHONEdialable < 1)
							{$post_phone_time_diff_alert_message .= _QXZ(" Phone Area Code Outside Dialable Zone")." $PHONEgmt_offset &nbsp; &nbsp; &nbsp; ";}
						if ($POSTdialable < 1)
							{$post_phone_time_diff_alert_message .= _QXZ(" Postal Code Outside Dialable Zone")." $POSTgmt_offset";}
						}
					}
				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_PHONE') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_POSTAL') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{$post_phone_time_diff_alert_message = '';}

				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_PHONE') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{
					if ($PHONEdialable < 1)
						{$post_phone_time_diff_alert_message .= _QXZ(" Phone Area Code Outside Dialable Zone")." $PHONEgmt_offset &nbsp; &nbsp; &nbsp; ";}
					}
				if ( ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_POSTAL') or ($post_phone_time_diff_alert == 'OUTSIDE_CALLTIME_BOTH') )
					{
					if ($POSTdialable < 1)
						{$post_phone_time_diff_alert_message .= _QXZ(" Postal Code Outside Dialable Zone ")."$POSTgmt_offset ";}
					}

				if (strlen($post_phone_time_diff_alert_message)>5)
					{$INFOout .= "<tr bgcolor=white><td colspan=2 align=center><font size=2 color=red><b>$post_phone_time_diff_alert_message</b></font></td></tr>";}
				}
			##### END check for postal_code and phone time zones if alert enabled

			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Status:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[0]</td></tr>";
			if ( ($label_vendor_lead_code!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_vendor_lead_code: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[1]</td></tr>";}
			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("List ID:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[2]</td></tr>";
			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Timezone:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[3]</td></tr>";
			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Called Since Last Reset:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[4]</td></tr>";
			if ( ($label_phone_code!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_phone_code: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[5]</td></tr>";}
			if ( ($label_phone_number!='---HIDE---') or ($label_hide_field_logs=='N') )
				{
				$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_phone_number: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[6] - &nbsp; &nbsp; &nbsp; &nbsp; ";
				if ($hide_dial_links < 1)
					{
					if ($manual_dial_filter > 0)
						{$INFOout .= "<a href=\"#\" onclick=\"NeWManuaLDiaLCalL('CALLLOG',$row[5], $row[6], $lead_id,'','YES');return false;\"> "._QXZ("DIAL")." </a>";}
					else
						{$INFOout .= _QXZ(" DIAL ");}
					}
				}
			if ( ($label_phone_number=='---HIDE---') and ($hide_dial_links < 1) )
				{
				if ($manual_dial_filter > 0)
					{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Dial Link:")." &nbsp; </td><td ALIGN=left><font class='sb_text'><a href=\"#\" onclick=\"NeWManuaLDiaLCalL('CALLLOG',$row[5], $row[6], $lead_id,'','YES');return false;\"> "._QXZ("DIAL")." </a>";}
				else
					{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Dial Link:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>"._QXZ(" DIAL ");}
				}
			$INFOout .= "</td></tr>";
			if ($inbound_lead_search > 0)
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right colspan=2><font class='sb_text'><a href=\"#\" onclick=\"LeaDSearcHSelecT('$lead_id');return false;\">"._QXZ("SELECT THIS LEAD")."</a></td></tr>";}
			if ( ($label_title!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_title: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[7]</td></tr>";}
			if ( ($label_first_name!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_first_name: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[8]</td></tr>";}
			if ( ($label_middle_initial!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_middle_initial: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[9]</td></tr>";}
			if ( ($label_last_name!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_last_name: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[10]</td></tr>";}
			if ( ($label_address1!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_address1: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[11]</td></tr>";}
			if ( ($label_address2!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_address2: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[12]</td></tr>";}
			if ( ($label_address3!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_address3: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[13]</td></tr>";}
			if ( ($label_city!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_city: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[14]</td></tr>";}
			if ( ($label_state!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_state: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[15]</td></tr>";}
			if ( ($label_province!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_province: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[16]</td></tr>";}
			if ( ($label_postal_code!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_postal_code: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[17]</td></tr>";}
			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>Country: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[18]</td></tr>";
			if ( ($label_gender!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_gender: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[19]</td></tr>";}
			if ( ($label_alt_phone!='---HIDE---') or ($label_hide_field_logs=='N') )
				{
				$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_alt_phone: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[20] - &nbsp; &nbsp; &nbsp; &nbsp; ";
				if ($hide_dial_links < 1)
					{
					if ($manual_dial_filter > 0)
						{$INFOout .= "<a href=\"#\" onclick=\"NeWManuaLDiaLCalL('CALLLOG',$row[5], $row[20], $lead_id, 'ALT','YES');return false;\"> "._QXZ("DIAL")." </a>";}
					else
						{$INFOout .= " DIAL ";}
					}
				}
			$INFOout .= "</td></tr>";
			if ( ($label_email!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_email: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[21]</td></tr>";}
			if ( ($label_security_phrase!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_security_phrase: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[22]</td></tr>";}
			if ( ($label_comments!='---HIDE---') or ($label_hide_field_logs=='N') )
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$label_comments: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[23]</td></tr>";}
			if ($hide_call_log_info=='N')
				{$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Called Count:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[24]</td></tr>";}
			$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>"._QXZ("Last Local Call Time:")." &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[25]</td></tr>";
	#		$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>Rank: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[26]</td></tr>";
	#		$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>Owner: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[27]</td></tr>";
	#		$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>Entry List ID: &nbsp; </td><td ALIGN=left><font class='sb_text'>$row[28]</td></tr>";

			$entry_list_id = $row[28];
			$CFoutput='';
			$stmt="SHOW TABLES LIKE \"custom_$entry_list_id\";";
			if ($DB>0) {$INFOout .= "$stmt";}
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00382',$user,$server_ip,$session_name,$one_mysql_log);}
			$tablecount_to_print = mysqli_num_rows($rslt);
			if ($tablecount_to_print > 0) 
				{
				$stmt="SELECT count(*) from custom_$entry_list_id where lead_id='$lead_id';";
				if ($DB>0) {$INFOout .= "$stmt";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00383',$user,$server_ip,$session_name,$one_mysql_log);}
				$fieldscount_to_print = mysqli_num_rows($rslt);
				if ($fieldscount_to_print > 0) 
					{
					$rowx=mysqli_fetch_row($rslt);
					$custom_records_count =	$rowx[0];

					$select_SQL='';
					$stmt="SHOW COLUMNS FROM custom_$entry_list_id where Field != 'lead_id';";
					$rslt=mysql_to_mysqli($stmt, $link);
						if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00384',$user,$server_ip,$session_name,$one_mysql_log);}
					$fields_to_print = mysqli_num_rows($rslt);
					$select_SQL='';
					$o=0;
					while ($fields_to_print > $o) 
						{
						$rowx=mysqli_fetch_row($rslt);
						$select_SQL .= "$rowx[0],";
						$A_field_name[$o] = $rowx[0];
						$o++;
						}
					### gather encrypt and hide settings for custom fields
					$o=0;
					while ($fields_to_print > $o) 
						{
						$stmt="SELECT field_encrypt,field_show_hide FROM vicidial_lists_fields where list_id='$entry_list_id' and field_label='$A_field_name[$o]';";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00635',$user,$server_ip,$session_name,$one_mysql_log);}
						$fieldset_to_print = mysqli_num_rows($rslt);
						if ($fieldset_to_print > 0) 
							{
							$rowx=mysqli_fetch_row($rslt);
							$A_field_encrypt[$o] =		$rowx[0];
							$A_field_show_hide[$o] =	$rowx[1];
							}
						$o++;
						}
					$select_SQL = preg_replace("/.$/",'',$select_SQL);
					if (strlen($select_SQL) > 0)
						{
						$stmt="SELECT $select_SQL FROM custom_$entry_list_id where lead_id='$lead_id' LIMIT 1;";
						$rslt=mysql_to_mysqli($stmt, $link);
							if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00385',$user,$server_ip,$session_name,$one_mysql_log);}
						if ($DB) {$INFOout .= "$stmt\n";}
						$list_lead_ct = mysqli_num_rows($rslt);
						if ($list_lead_ct > 0)
							{
							$row=mysqli_fetch_row($rslt);
							$o=0;
							while ($fields_to_print > $o) 
								{
								$A_field_value		= trim("$row[$o]");
								if ($A_field_encrypt[$o] == 'Y')
									{$A_field_value = _QXZ("ENCRYPTED");}
								else
									{
									if ($A_field_show_hide[$o] != 'DISABLED')
										{
										$field_temp_val = $A_field_value;
										$A_field_value = preg_replace("/./",'X',$field_temp_val);
										}
									}

								$INFOout .= "<tr bgcolor=white><td ALIGN=right><font class='sb_text'>$A_field_name[$o]: &nbsp; </td><td ALIGN=left><font class='sb_text'>$A_field_value</td></tr>";
								
								$o++;
								}
							}
						}
					}
				}
			}

		$INFOout .= "</TABLE>";
		$INFOout .= "<BR>";
		### END Display lead info and custom fields ###


		### BEGIN Gather Call Log and notes ###
		$NOTESout='';
		if ($hide_call_log_info=='N')
			{
			if ($search != 'logfirst')
				{$NOTESout .= "<CENTER>"._QXZ("CALL LOG FOR THIS LEAD:")."<br>\n";}
			$NOTESout .= "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
			$NOTESout .= "<TR>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:10px;font-family:sans-serif;\"><B> &nbsp; # &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DATE/TIME")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("AGENT")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("LENGTH")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("STATUS")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("PHONE")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("CAMPAIGN")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("IN/OUT")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("ALT")." &nbsp; </font></TD>";
			$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\"><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("HANGUP")." &nbsp; </font></TD>";
		#	$NOTESout .= "</TR><TR>";
		#	$NOTESout .= "<TD BGCOLOR=\"#CCCCCC\" COLSPAN=9><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; FULL NAME &nbsp; </font></TD>";
			$NOTESout .= "</TR>";


			$stmt="SELECT start_epoch,call_date,campaign_id,length_in_sec,status,phone_code,phone_number,lead_id,term_reason,alt_dial,comments,uniqueid,user from vicidial_log where lead_id='$lead_id' order by call_date desc limit 10000;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00580',$user,$server_ip,$session_name,$one_mysql_log);}
			$out_logs_to_print = mysqli_num_rows($rslt);
			if ($format=='debug') {$NOTESout .= "|$out_logs_to_print|$stmt|";}

			$g=0;
			$u=0;
			while ($out_logs_to_print > $u) 
				{
				$row=mysqli_fetch_row($rslt);
				$ALLsort[$g] =			"$row[0]-----$g";
				$ALLstart_epoch[$g] =	$row[0];
				$ALLcall_date[$g] =		$row[1];
				$ALLcampaign_id[$g] =	$row[2];
				$ALLlength_in_sec[$g] =	$row[3];
				$ALLstatus[$g] =		$row[4];
				$ALLphone_code[$g] =	$row[5];
				$ALLphone_number[$g] =	$row[6];
				$ALLlead_id[$g] =		$row[7];
				$ALLhangup_reason[$g] =	$row[8];
				$ALLalt_dial[$g] =		$row[9];
				$ALLuniqueid[$g] =		$row[11];
				$ALLuser[$g] =			$row[12];
				$ALLin_out[$g] =		"OUT-AUTO";
				if ($row[10] == 'MANUAL') {$ALLin_out[$g] = "OUT-MANUAL";}

				$stmtA="SELECT call_notes FROM vicidial_call_notes WHERE lead_id='$ALLlead_id[$g]' and vicidial_id='$ALLuniqueid[$g]';";
				$rsltA=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00581',$user,$server_ip,$session_name,$one_mysql_log);}
				$out_notes_to_print = mysqli_num_rows($rslt);
				if ($out_notes_to_print > 0)
					{
					$rowA=mysqli_fetch_row($rsltA);
					$Allcall_notes[$g] =	$rowA[0];
					if (strlen($Allcall_notes[$g]) > 0)
						{$Allcall_notes[$g] =	"<b>NOTES: </b> $Allcall_notes[$g]";}
					}
				$stmtA="SELECT full_name FROM vicidial_users WHERE user='$ALLuser[$g]';";
				$rsltA=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00582',$user,$server_ip,$session_name,$one_mysql_log);}
				$users_to_print = mysqli_num_rows($rslt);
				if ($users_to_print > 0)
					{
					$rowA=mysqli_fetch_row($rsltA);
					$ALLuser[$g] .=	" - $rowA[0]";
					}

				$Allcounter[$g] =		$g;
				$g++;
				$u++;
				}

			$stmt="SELECT start_epoch,call_date,campaign_id,length_in_sec,status,phone_code,phone_number,lead_id,term_reason,queue_seconds,uniqueid,closecallid,user from vicidial_closer_log where lead_id='$lead_id' order by closecallid desc limit 10000;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00583',$user,$server_ip,$session_name,$one_mysql_log);}
			$in_logs_to_print = mysqli_num_rows($rslt);
			if ($format=='debug') {$NOTESout .= "|$in_logs_to_print|$stmt|";}

			$u=0;
			while ($in_logs_to_print > $u) 
				{
				$row=mysqli_fetch_row($rslt);
				$ALLsort[$g] =			"$row[0]-----$g";
				$ALLstart_epoch[$g] =	$row[0];
				$ALLcall_date[$g] =		$row[1];
				$ALLcampaign_id[$g] =	$row[2];
				$ALLlength_in_sec[$g] =	($row[3] - $row[9]);
				if ($ALLlength_in_sec[$g] < 0) {$ALLlength_in_sec[$g]=0;}
				$ALLstatus[$g] =		$row[4];
				$ALLphone_code[$g] =	$row[5];
				$ALLphone_number[$g] =	$row[6];
				$ALLlead_id[$g] =		$row[7];
				$ALLhangup_reason[$g] =	$row[8];
				$ALLuniqueid[$g] =		$row[10];
				$ALLclosecallid[$g] =	$row[11];
				$ALLuser[$g] =			$row[12];
				$ALLalt_dial[$g] =		"MAIN";
				$ALLin_out[$g] =		"IN";

				$stmtA="SELECT call_notes FROM vicidial_call_notes WHERE lead_id='$ALLlead_id[$g]' and vicidial_id IN('$ALLuniqueid[$g]','$ALLclosecallid[$g]');";
				$rsltA=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00584',$user,$server_ip,$session_name,$one_mysql_log);}
				$in_notes_to_print = mysqli_num_rows($rslt);
				if ($in_notes_to_print > 0)
					{
					$rowA=mysqli_fetch_row($rsltA);
					$Allcall_notes[$g] =	$rowA[0];
					if (strlen($Allcall_notes[$g]) > 0)
						{$Allcall_notes[$g] =	"<b>"._QXZ("NOTES:")." </b> $Allcall_notes[$g]";}
					}
				$stmtA="SELECT full_name FROM vicidial_users WHERE user='$ALLuser[$g]';";
				$rsltA=mysql_to_mysqli($stmtA, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtA,'00585',$user,$server_ip,$session_name,$one_mysql_log);}
				$users_to_print = mysqli_num_rows($rslt);
				if ($users_to_print > 0)
					{
					$rowA=mysqli_fetch_row($rsltA);
					$ALLuser[$g] .=	" - $rowA[0]";
					}

				$Allcounter[$g] =		$g;

				$g++;
				$u++;
				}

			if ($g > 0)
				{sort($ALLsort, SORT_NUMERIC);}
			else
				{$NOTESout .= "<tr bgcolor=white><td colspan=11 align=center>"._QXZ("No calls found")."</td></tr>";}

			$u=0;
			while ($g > $u) 
				{
				$sort_split = explode("-----",$ALLsort[$u]);
				$i = $sort_split[1];

				if (preg_match("/1$|3$|5$|7$|9$/i", $u))
					{$bgcolor='bgcolor="#B9CBFD"';} 
				else
					{$bgcolor='bgcolor="#9BB9FB"';}

				$phone_number_display = $ALLphone_number[$i];
				if ($disable_alter_custphone == 'HIDE')
					{$phone_number_display = 'XXXXXXXXXX';}

				$u++;
				$NOTESout .= "<tr $bgcolor>";
				$NOTESout .= "<td><font size=1>$u</td>";
				$NOTESout .= "<td align=right><font class='sb_text'>$ALLcall_date[$i]</td>";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLuser[$i]</td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLlength_in_sec[$i]</td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLstatus[$i]</td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLphone_code[$i] $phone_number_display </td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLcampaign_id[$i] </td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLin_out[$i] </td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLalt_dial[$i] </td>\n";
				$NOTESout .= "<td align=right><font class='sb_text'> $ALLhangup_reason[$i] </td>\n";
				$NOTESout .= "</TR><TR>";
				$NOTESout .= "<td></td>";
				$NOTESout .= "<TD $bgcolor COLSPAN=9 align=left><font style=\"font-size:11px;font-family:sans-serif;\"> $Allcall_notes[$i] </font></TD>";
				$NOTESout .= "</tr>\n";
				}

			$NOTESout .= "</TABLE>";
			$NOTESout .= "<BR>";
			}
		### END Gather Call Log and notes ###


		### BEGIN Email log
		if ($allow_emails>0)
			{
			$NOTESout .= "<CENTER>"._QXZ("EMAIL LOG FOR THIS LEAD:")."<br>\n";
			$NOTESout .= "<TABLE CELLPADDING=0 CELLSPACING=1 BORDER=0 WIDTH=$stage>";
			$NOTESout .= "<TR>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\"><font style=\"font-size:10px;font-family:sans-serif;\"><B> # </B></font></td>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\" align=left><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DATE/TIME")." </B></font></td>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\" align=left><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("AGENT")." </B></font></td>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\" align=left><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("CAMPAIGN")." </B></font></td>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\" align=left><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("EMAIL TO")." </B></font></td>";
			$NOTESout .= "<td BGCOLOR=\"#CCCCCC\" align=left><font style=\"font-size:11px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("ATTACHMENTS")." </B></font></td>";
			$NOTESout .= "</tr>\n";


			$stmt="SELECT email_log_id,email_row_id,lead_id,email_date,user,email_to,message,campaign_id,attachments from vicidial_email_log where lead_id='$lead_id' order by email_date desc limit 500;";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00586',$user,$server_ip,$session_name,$one_mysql_log);}
			$logs_to_print = mysqli_num_rows($rslt);

			$u=0;
			while ($logs_to_print > $u) 
				{
				$row=mysqli_fetch_row($rslt);
				if (preg_match("/1$|3$|5$|7$|9$/i", $u))
					{$bgcolor='bgcolor="#B9CBFD"';} 
				else
					{$bgcolor='bgcolor="#9BB9FB"';}
				if (strlen($row[6])>400) {$row[6]=substr($row[6],0,400)."...";}
				$row[8]=preg_replace('/\|/', ', ', $row[8]);
				$row[8]=preg_replace('/,\s+$/', '', $row[8]);
				$u++;

				$NOTESout .= "<tr $bgcolor>";
				$NOTESout .= "<td><font size=1>$u</td>";
				$NOTESout .= "<td align=left><font class='sb_text'> &nbsp; $row[3]</td>";
				$NOTESout .= "<td align=left><font class='sb_text'> &nbsp; $row[4] </td>\n";
				$NOTESout .= "<td align=left><font class='sb_text'> &nbsp; $row[7]</td>\n";
				$NOTESout .= "<td align=left><font class='sb_text'> &nbsp; $row[5]</td>\n";
				$NOTESout .= "<td align=left><font size=1> &nbsp; $row[8] </td>\n";
				$NOTESout .= "</tr>\n";
				$NOTESout .= "<tr>";
				$NOTESout .= "<td><font size=1> &nbsp; </td>\n";
				$NOTESout .= "<td align=left colspan=5 $bgcolor><font size=1> "._QXZ("MESSAGE:")." $row[6] </td>\n";
				$NOTESout .= "</tr>\n";
				}

			$NOTESout .= "</TABLE>";
			}
		### END Email Log ##

		if ($search == 'logfirst')
			{echo "$NOTESout\n$INFOout\n";}
		else
			{echo "$INFOout\n$NOTESout\n";}

		echo "</CENTER>";
		}
	}



################################################################################
### CALLSINQUEUEgrab - grab a call in queue and reserve it for that agent
################################################################################
if ($ACTION == 'CALLSINQUEUEgrab')
	{
	$stmt="SELECT view_calls_in_queue,grab_calls_in_queue from vicidial_campaigns where campaign_id='$campaign'";
	if ($non_latin > 0) {$rslt=mysql_to_mysqli("SET NAMES 'UTF8'", $link);}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00233',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$view_calls_in_queue =	$row[0];
	$grab_calls_in_queue =	$row[1];

	if ( (preg_match('/NONE/i',$view_calls_in_queue)) or (preg_match('/N/i',$grab_calls_in_queue)) )
		{
		echo "ERROR: "._QXZ("Calls in Queue View Disabled for this campaign")."\n";
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	else
		{
		$stmtU="UPDATE vicidial_auto_calls set agent_grab=\"$user\" where auto_call_id='$stage' and agent_grab='' and status='LIVE';";
			if ($format=='debug') {echo "\n<!-- $stmt -->";}
		$rslt=mysql_to_mysqli($stmtU, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtU,'00234',$user,$server_ip,$session_name,$one_mysql_log);}
		$VACaffected_rows = mysqli_affected_rows($link);
		if ($VACaffected_rows > 0) 
			{
			$stmt="SELECT call_time,campaign_id,uniqueid,phone_number,lead_id,queue_priority,call_type from vicidial_auto_calls where auto_call_id='$stage';";
			$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00270',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($rslt) {$vac_count = mysqli_num_rows($rslt);}
			if ($vac_count > 0)
				{
				$row=mysqli_fetch_row($rslt);
				$GCcall_time =		$row[0];
				$GCcampaign_id =	$row[1];
				$GCuniqueid =		$row[2];
				$GCphone_number =	$row[3];
				$GClead_id =		$row[4];
				$GCqueue_priority = $row[5];
				$GCcall_type =		$row[6];

				$stmt="INSERT INTO vicidial_grab_call_log SET auto_call_id='$stage',user='$user',event_date='$NOW_TIME',call_time='$GCcall_time',campaign_id='$GCcampaign_id',uniqueid='$GCuniqueid',phone_number='$GCphone_number',lead_id='$GClead_id',queue_priority='$GCqueue_priority',call_type='$GCcall_type';";
					if ($format=='debug') {echo "\n<!-- $stmt -->";}
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00271',$user,$server_ip,$session_name,$one_mysql_log);}
				$affected_rows = mysqli_affected_rows($link);
				}

			echo "SUCCESS: "._QXZ("Call %1s grabbed for %2s",0,'',$stage,$user);
			}
		else
			{
			echo "ERROR: "._QXZ("Call %1s could not be grabbed for %2s",0,'',$stage,$user)."\n";
			}

		$stmtD="SELECT auto_call_id,server_ip,campaign_id,status,lead_id,uniqueid,callerid,channel,phone_code,phone_number,call_time,call_type,stage,last_update_time,alt_dial,queue_priority,agent_only,agent_grab,queue_position,extension,agent_grab_extension from vicidial_auto_calls where auto_call_id='$stage';";
		$rslt=mysql_to_mysqli($stmtD, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmtD,'00321',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$DEBUGvac_count = mysqli_num_rows($rslt);}
		if ($DEBUGvac_count > 0)
			{
			$row=mysqli_fetch_row($rslt);
			if ($WeBRooTWritablE > 0)
				{
				$fp = fopen ("./vicidial_debug.txt", "a");
				fwrite ($fp, "$NOW_TIME|GRAB_CALL  |$stmtU|$VACaffected_rows|$stmtD|$row[0]|$row[1]|$row[2]|$row[3]|$row[4]|$row[5]|$row[6]|$row[7]|$row[8]|$row[9]|$row[10]|$row[11]|$row[12]|$row[13]|$row[14]|$row[15]|$row[16]|$row[17]|$row[18]|\n");
				fclose($fp);
				}
			}
		if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
		exit;
		}
	}


################################################################################
### CalLBacKLisT - List the USERONLY callbacks for an agent
################################################################################
if ($ACTION == 'CalLBacKLisT')
	{
	$campaignCBhoursSQL = '';
	$campaignCBdisplaydaysSQL = '';
	$stmt = "SELECT callback_hours_block,callback_list_calltime,local_call_time,callback_display_days from vicidial_campaigns where campaign_id='$campaign';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00437',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($rslt) {$camp_count = mysqli_num_rows($rslt);}
	if ($camp_count > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$callback_hours_block =		$row[0];
		$callback_list_calltime =	$row[1];
		$local_call_time =			$row[2];
		$callback_display_days =	$row[3];
		if ($callback_hours_block > 0)
			{
			$x_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-$callback_hours_block,date("i"),date("s"),date("m"),date("d"),date("Y")));
			$campaignCBhoursSQL = "and entry_time < \"$x_hours_ago\"";
			}
		if ($callback_display_days > 0)
			{
			$x_days_from_now = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")+$callback_display_days,date("Y")));
			$campaignCBdisplaydaysSQL = "and callback_time < \"$x_days_from_now\"";
			}
		}
	$campaignCBsql = '';
	if ($agentonly_callback_campaign_lock > 0)
		{$campaignCBsql = "and campaign_id='$campaign'";}

	$stmt = "SELECT callback_id,lead_id,campaign_id,status,entry_time,callback_time,comments from vicidial_callbacks where recipient='USERONLY' and user='$user' $campaignCBsql $campaignCBhoursSQL $campaignCBdisplaydaysSQL and status NOT IN('INACTIVE','DEAD') order by callback_time;";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00178',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($rslt) {$callbacks_count = mysqli_num_rows($rslt);}
	echo "$callbacks_count\n";
	$loop_count=0;
	while ($callbacks_count>$loop_count)
		{
		$row=mysqli_fetch_row($rslt);
		$callback_id[$loop_count]	= $row[0];
		$lead_id[$loop_count]		= $row[1];
		$campaign_id[$loop_count]	= $row[2];
		$status[$loop_count]		= $row[3];
		$entry_time[$loop_count]	= $row[4];
		$callback_time[$loop_count]	= $row[5];
		$comments[$loop_count]		= $row[6];
		$loop_count++;
		}
	$loop_count=0;
	while ($callbacks_count>$loop_count)
		{
		$alt_phone='';
		$stmt = "SELECT first_name,last_name,phone_number,gmt_offset_now,state,list_id,alt_phone from vicidial_list where lead_id='$lead_id[$loop_count]';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00179',$user,$server_ip,$session_name,$one_mysql_log);}
		$row=mysqli_fetch_row($rslt);
		$PHONEdialable=1;
		$alt_phone =	$row[6];

		if ($callback_list_calltime == 'ENABLED')
			{
			$state =		$row[4];
			$lead_list_id =	$row[5];
					
			### Get local_call_time for list
			$stmt="SELECT local_call_time,list_description FROM vicidial_lists where list_id='$lead_list_id';";
			$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00611',$user,$server_ip,$session_name,$one_mysql_log);}
			if ($DB) {echo "$stmt\n";}
			$rslt_ct = mysqli_num_rows($rslt);
			if ($rslt_ct > 0)
				{
				$rowy=mysqli_fetch_row($rslt);
				$list_local_call_time =	$rowy[0];
				$list_description =		$rowy[1];
				}

			# check that call time exists
			if ($list_local_call_time != "campaign") 
				{
				$stmt="SELECT count(*) from vicidial_call_times where call_time_id='$list_local_call_time';";
				$rslt=mysql_to_mysqli($stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00616',$user,$server_ip,$session_name,$one_mysql_log);}					
				$rowy=mysqli_fetch_row($rslt);
				$call_time_exists  =	$rowy[0];
				if ($call_time_exists < 1) 
					{$list_local_call_time = 'campaign';}
				}

			#Check if we are with the gmt for campaign for $POSTdialable
			if ( (dialable_gmt($DB,$link,$local_call_time,$row[3],$row[4]) == 1) and ($list_local_call_time != "campaign") )
				{
				#Now check if we are with the GMT for the list local call time
				$PHONEdialable = dialable_gmt($DB,$link,$list_local_call_time,$row[3],$row[4]);
				}
			else
				{
				$PHONEdialable = dialable_gmt($DB,$link,$local_call_time,$row[3],$row[4]);
				}
			}
		$CBoutput = "$row[0]-!T-$row[1]-!T-$row[2]-!T-$callback_id[$loop_count]-!T-$lead_id[$loop_count]-!T-$campaign_id[$loop_count]-!T-"._QXZ("$status[$loop_count]")."-!T-$entry_time[$loop_count]-!T-$callback_time[$loop_count]-!T-$comments[$loop_count]-!T-$PHONEdialable-!T-$alt_phone";
		echo "$CBoutput\n";
		$loop_count++;
		}

	}


################################################################################
### CalLBacKCounT - send the count of the USERONLY callbacks for an agent
################################################################################
if ($ACTION == 'CalLBacKCounT')
	{
	$campaignCBhoursSQL = '';
	$campaignCBdisplaydaysSQL = '';
	$stmt = "SELECT callback_hours_block,callback_display_days,scheduled_callbacks_email_alert from vicidial_campaigns where campaign_id='$campaign';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00438',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($rslt) {$camp_count = mysqli_num_rows($rslt);}
	if ($camp_count > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$callback_hours_block =				$row[0];
		$callback_display_days =			$row[1];
		$scheduled_callbacks_email_alert =	$row[2];
		if ($callback_hours_block > 0)
			{
			$x_hours_ago = date("Y-m-d H:i:s", mktime(date("H")-$callback_hours_block,date("i"),date("s"),date("m"),date("d"),date("Y")));
			$campaignCBhoursSQL = "and entry_time < \"$x_hours_ago\"";
			}
		if ($callback_display_days > 0)
			{
			$x_days_from_now = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),date("d")+$callback_display_days,date("Y")));
			$campaignCBdisplaydaysSQL = "and callback_time < \"$x_days_from_now\"";
			}
		}
	$campaignCBsql = '';
	if ($agentonly_callback_campaign_lock > 0)
		{$campaignCBsql = "and campaign_id='$campaign'";}

	$stmt = "SELECT count(*) from vicidial_callbacks where recipient='USERONLY' and user='$user' $campaignCBsql $campaignCBhoursSQL $campaignCBdisplaydaysSQL and status NOT IN('INACTIVE','DEAD');";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00180',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$cbcount=$row[0];

	$stmt = "SELECT count(*) from vicidial_callbacks where recipient='USERONLY' and user='$user' $campaignCBsql $campaignCBhoursSQL $campaignCBdisplaydaysSQL and status IN('LIVE');";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00332',$user,$server_ip,$session_name,$one_mysql_log);}
	$row=mysqli_fetch_row($rslt);
	$cbcount_live=$row[0];

	echo "$cbcount|$cbcount_live";
	$stage = "$campaign|$cbcount|$cbcount_live";

	if ($scheduled_callbacks_email_alert=="Y")
		{
		$user_stmt="SELECT email, full_name from vicidial_users where user='$user'";
		$user_rslt=mysql_to_mysqli($user_stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$user_stmt,'00695',$user,$server_ip,$session_name,$one_mysql_log);}
		$user_row=mysqli_fetch_row($user_rslt);
		$email_to=$user_row[0];
		$agent_name=$user_row[1];

		$container_id="AGENT_CALLBACK_EMAIL";

		$stmt = "SELECT container_entry FROM vicidial_settings_containers where container_id='$container_id';";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00696',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($DB) {echo "$stmt\n";}
		$sc_ct = mysqli_num_rows($rslt);
		if ($sc_ct > 0 && filter_var($email_to, FILTER_VALIDATE_EMAIL))
			{
			$row=mysqli_fetch_row($rslt);
			$container_entry =	$row[0];
			$container_ARY = explode("\n",$container_entry);
			$email_body_gather=0;
			$p=0;
			$container_ct = count($container_ARY);
			while ($p <= $container_ct)
				{
				$line = $container_ARY[$p];
				if ($email_body_gather < 1)
					{
					$line = preg_replace("/>|\n|\r|\t|\#.*|;.*/",'',$line);
					if (preg_match("/^email_to/",$line))
						{$email_to = $line;   $email_to = trim(preg_replace("/.*=/",'',$email_to));}
					if (preg_match("/^email_from/",$line))
						{$email_from = $line;   $email_from = trim(preg_replace("/.*=/",'',$email_from));}
					if (preg_match("/^email_subject/",$line))
						{$email_subject = $line;   $email_subject = trim(preg_replace("/.*=/",'',$email_subject));}
					if (preg_match("/^email_body_begin/",$line))
						{$email_body = $line;   $email_body = trim(preg_replace("/.*=/",'',$email_body)) . "\n";   $email_body_gather++;}
					}
				else
					{
					if (preg_match("/^email_body_end/",$line))
						{$email_body_gather=0;}
					else
						{$email_body .= $line;}
					}
				$p++;
				}

			$email_stmt="SELECT callback_id, lead_id, comments from vicidial_callbacks where recipient='USERONLY' and user='$user' $campaignCBsql and email_alert is null and callback_time>=now()-INTERVAL 1 MINUTE and callback_time<=now()";
			$email_rslt=mysql_to_mysqli($email_stmt, $link);
				if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$email_stmt,'00697',$user,$server_ip,$session_name,$one_mysql_log);}
			while($email_row=mysqli_fetch_array($email_rslt)) 
				{
				$CB_id=$email_row["callback_id"];
				$CB_lead_id=$email_row["lead_id"];
				$callback_comments=$email_row["comments"];

				##### grab the data from vicidial_list for the lead_id
				$stmt="SELECT lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner,entry_list_id FROM vicidial_list where lead_id='$CB_lead_id' LIMIT 1;";
				$rslt=mysql_to_mysqli($stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00698',$user,$server_ip,$session_name,$one_mysql_log);}
				if ($DB) {echo "$stmt\n";}
				$list_lead_ct = mysqli_num_rows($rslt);
				if ($list_lead_ct > 0)
					{
					$row=mysqli_fetch_row($rslt);
					$entry_date		= urlencode(trim($row[1]));
					$dispo			= urlencode(trim($row[3]));
					$tsr			= urlencode(trim($row[4]));
					$vendor_id		= urlencode(trim($row[5]));
					$vendor_lead_code	= urlencode(trim($row[5]));
					$source_id		= urlencode(trim($row[6]));
					$list_id		= urlencode(trim($row[7]));
					$gmt_offset_now	= urlencode(trim($row[8]));
					$phone_code		= urlencode(trim($row[10]));
					$phone_number	= urlencode(trim($row[11]));
					$title			= urlencode(trim($row[12]));
					$first_name		= urlencode(trim($row[13]));
					$middle_initial	= urlencode(trim($row[14]));
					$last_name		= urlencode(trim($row[15]));
					$address1		= urlencode(trim($row[16]));
					$address2		= urlencode(trim($row[17]));
					$address3		= urlencode(trim($row[18]));
					$city			= urlencode(trim($row[19]));
					$state			= urlencode(trim($row[20]));
					$province		= urlencode(trim($row[21]));
					$postal_code	= urlencode(trim($row[22]));
					$country_code	= urlencode(trim($row[23]));
					$gender			= urlencode(trim($row[24]));
					$date_of_birth	= urlencode(trim($row[25]));
					$alt_phone		= urlencode(trim($row[26]));
					$email			= urlencode(trim($row[27]));
					$security_phrase	= urlencode(trim($row[28]));
					$comments		= urlencode(trim($row[29]));
					$called_count	= urlencode(trim($row[30]));
					$rank			= urlencode(trim($row[32]));
					$owner			= urlencode(trim($row[33]));
					$entry_list_id	= urlencode(trim($row[34]));
					}

				### populate variables in email_subject
				if (preg_match('/--A--/i',$email_subject))
					{
					$email_subject = preg_replace('/^VAR|--A--CF_uses_custom_fields--B--/','',$email_subject);
					$email_subject = preg_replace('/--A--lead_id--B--/i',"$lead_id",$email_subject);
					$email_subject = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$email_subject);
					$email_subject = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_lead_code",$email_subject);
					$email_subject = preg_replace('/--A--list_id--B--/i',"$list_id",$email_subject);
					$email_subject = preg_replace('/--A--list_name--B--/i',"$list_name",$email_subject);
					$email_subject = preg_replace('/--A--list_description--B--/i',"$list_description",$email_subject);
					$email_subject = preg_replace('/--A--gmt_offset_now--B--/i',"$gmt_offset_now",$email_subject);
					$email_subject = preg_replace('/--A--phone_code--B--/i',"$phone_code",$email_subject);
					$email_subject = preg_replace('/--A--phone_number--B--/i',"$phone_number",$email_subject);
					$email_subject = preg_replace('/--A--title--B--/i',"$title",$email_subject);
					$email_subject = preg_replace('/--A--first_name--B--/i',"$first_name",$email_subject);
					$email_subject = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$email_subject);
					$email_subject = preg_replace('/--A--last_name--B--/i',"$last_name",$email_subject);
					$email_subject = preg_replace('/--A--address1--B--/i',"$address1",$email_subject);
					$email_subject = preg_replace('/--A--address2--B--/i',"$address2",$email_subject);
					$email_subject = preg_replace('/--A--address3--B--/i',"$address3",$email_subject);
					$email_subject = preg_replace('/--A--city--B--/i',"$city",$email_subject);
					$email_subject = preg_replace('/--A--state--B--/i',"$state",$email_subject);
					$email_subject = preg_replace('/--A--province--B--/i',"$province",$email_subject);
					$email_subject = preg_replace('/--A--postal_code--B--/i',"$postal_code",$email_subject);
					$email_subject = preg_replace('/--A--country_code--B--/i',"$country_code",$email_subject);
					$email_subject = preg_replace('/--A--gender--B--/i',"$gender",$email_subject);
					$email_subject = preg_replace('/--A--date_of_birth--B--/i',"$date_of_birth",$email_subject);
					$email_subject = preg_replace('/--A--alt_phone--B--/i',"$alt_phone",$email_subject);
					$email_subject = preg_replace('/--A--email--B--/i',"$email",$email_subject);
					$email_subject = preg_replace('/--A--security_phrase--B--/i',"$security_phrase",$email_subject);
					$email_subject = preg_replace('/--A--comments--B--/i',"$comments",$email_subject);
					$email_subject = preg_replace('/--A--agent_name--B--/i',"$agent_name",$email_subject);
					$email_subject = preg_replace('/--A--callback_comments--B--/i',"$callback_comments",$email_subject);
					}

				### check for variables in email_body
				if (preg_match('/--A--/i',$email_body))
					{
					$email_body = preg_replace('/^VAR|--A--CF_uses_custom_fields--B--/','',$email_body);
					$email_body = preg_replace('/--A--lead_id--B--/i',"$lead_id",$email_body);
					$email_body = preg_replace('/--A--vendor_id--B--/i',"$vendor_id",$email_body);
					$email_body = preg_replace('/--A--vendor_lead_code--B--/i',"$vendor_lead_code",$email_body);
					$email_body = preg_replace('/--A--list_id--B--/i',"$list_id",$email_body);
					$email_body = preg_replace('/--A--list_name--B--/i',"$list_name",$email_body);
					$email_body = preg_replace('/--A--list_description--B--/i',"$list_description",$email_body);
					$email_body = preg_replace('/--A--gmt_offset_now--B--/i',"$gmt_offset_now",$email_body);
					$email_body = preg_replace('/--A--phone_code--B--/i',"$phone_code",$email_body);
					$email_body = preg_replace('/--A--phone_number--B--/i',"$phone_number",$email_body);
					$email_body = preg_replace('/--A--title--B--/i',"$title",$email_body);
					$email_body = preg_replace('/--A--first_name--B--/i',"$first_name",$email_body);
					$email_body = preg_replace('/--A--middle_initial--B--/i',"$middle_initial",$email_body);
					$email_body = preg_replace('/--A--last_name--B--/i',"$last_name",$email_body);
					$email_body = preg_replace('/--A--address1--B--/i',"$address1",$email_body);
					$email_body = preg_replace('/--A--address2--B--/i',"$address2",$email_body);
					$email_body = preg_replace('/--A--address3--B--/i',"$address3",$email_body);
					$email_body = preg_replace('/--A--city--B--/i',"$city",$email_body);
					$email_body = preg_replace('/--A--state--B--/i',"$state",$email_body);
					$email_body = preg_replace('/--A--province--B--/i',"$province",$email_body);
					$email_body = preg_replace('/--A--postal_code--B--/i',"$postal_code",$email_body);
					$email_body = preg_replace('/--A--country_code--B--/i',"$country_code",$email_body);
					$email_body = preg_replace('/--A--gender--B--/i',"$gender",$email_body);
					$email_body = preg_replace('/--A--date_of_birth--B--/i',"$date_of_birth",$email_body);
					$email_body = preg_replace('/--A--alt_phone--B--/i',"$alt_phone",$email_body);
					$email_body = preg_replace('/--A--email--B--/i',"$email",$email_body);
					$email_body = preg_replace('/--A--security_phrase--B--/i',"$security_phrase",$email_body);
					$email_body = preg_replace('/--A--comments--B--/i',"$comments",$email_body);
					$email_body = preg_replace('/--A--agent_name--B--/i',"$agent_name",$email_body);
					$email_body = preg_replace('/--A--callback_comments--B--/i',"$callback_comments",$email_body);
					$email_body = urldecode($email_body);
					}

				##### sending email through PHP #####
				$sendmail = @mail("$email_to","$email_subject","$email_body", "From: $email_from");
				if ($sendmail) {$email_result="SENT";} else {$email_result="FAILED";}
				$upd_stmt="UPDATE vicidial_callbacks set email_alert=now(), email_result='$email_result' where callback_id='$CB_id'";
				$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
					if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$upd_stmt,'00699',$user,$server_ip,$session_name,$one_mysql_log);}
				}
			}
		$upd_stmt="UPDATE vicidial_callbacks set email_alert=now(), email_result='NOT AVAILABLE' where recipient='USERONLY' and user='$user' and callback_time<=now() and email_alert is null $campaignCBsql";
		$upd_rslt=mysql_to_mysqli($upd_stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$upd_stmt,'00700',$user,$server_ip,$session_name,$one_mysql_log);}
		}
	}



################################################################################
### AGENTtimeREPORT - display today's agent time report
################################################################################
if ($ACTION == 'AGENTtimeREPORT')
	{
	if (strlen($stage) < 5)
		{$stage = 'DISABLED';}

	$stmt="SELECT agent_screen_time_display from vicidial_campaigns where campaign_id='$campaign';";
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00706',$user,$server_ip,$session_name,$one_mysql_log);}
	$camp_to_print = mysqli_num_rows($rslt);
	if ($format=='debug') {echo "|$camp_to_print|$stmt|";}
	if ($camp_to_print > 0) 
		{
		$row=mysqli_fetch_row($rslt);
		$stage =		$row[0];
		}

	if ($stage == 'DISABLED')
		{
		echo "<BR><BR>\n";
		echo "<B>" . _QXZ("ERROR: this feature is disabled for this campaign") . "</B>\n";
		echo "<BR><BR>\n";
		echo "<a href=\"#\" onclick=\"AgentTimeReport('close');return false;\">"._QXZ("Close Agent Time Report")."</a>";
		}
	else
		{
		$stmt="SELECT pause_epoch,wait_epoch,talk_epoch,dispo_epoch,dead_epoch,pause_sec,wait_sec,talk_sec,dispo_sec,dead_sec,sub_status,agent_log_id from vicidial_agent_log where user='$user' and event_time >= '$NOW_DATE 00:00:00'  and event_time <= '$NOW_DATE 23:59:59' order by agent_log_id desc limit 10000;";
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00707',$user,$server_ip,$session_name,$one_mysql_log);}
		$time_logs_to_print = mysqli_num_rows($rslt);
		if ($format=='debug') {echo "|$stage|$time_logs_to_print|$stmt|";}

		$g=0;
		$pauseTOTAL=0;
		$waitTOTAL=0;
		$talkTOTAL=0;
		$dispoTOTAL=0;
		$billTOTAL=0;
		$breakTOTAL=0;
		$lunchTOTAL=0;
		$coachTOTAL=0;
		$loginTOTAL=0;
		while ($time_logs_to_print > $g) 
			{
			$row=mysqli_fetch_row($rslt);
			$Tpause_epoch[$g] =		$row[0];
			$Twait_epoch[$g] =		$row[1];
			$talk_epoch[$g] =		$row[2];
			$Tdispo_epoch[$g] =		$row[3];
			$Tdead_epoch[$g] =		$row[4];
			$Tpause_sec[$g] =		$row[5];
			$Twait_sec[$g] =		$row[6];
			$Ttalk_sec[$g] =		$row[7];
			$Tdispo_sec[$g] =		$row[8];
			$Tdead_sec[$g] =		$row[9];
			$Tsub_status[$g] =		$row[10];
			$Tagent_log_id[$g] =	$row[11];

			if ($Tpause_sec[$g] < 65000)	
				{
				$pauseTOTAL = ($pauseTOTAL + $Tpause_sec[$g]);
				if (preg_match("/break/i",$Tsub_status[$g])) {$breakTOTAL = ($breakTOTAL + $Tpause_sec[$g]);}
				if (preg_match("/lunch/i",$Tsub_status[$g])) {$lunchTOTAL = ($lunchTOTAL + $Tpause_sec[$g]);}
				if (preg_match("/coach/i",$Tsub_status[$g])) {$coachTOTAL = ($coachTOTAL + $Tpause_sec[$g]);}
				}
			if ($Twait_sec[$g] < 65000)		{$waitTOTAL = ($waitTOTAL + $Twait_sec[$g]);}
			if ($Ttalk_sec[$g] < 65000)		{$talkTOTAL = ($talkTOTAL + $Ttalk_sec[$g]);}
			if ($Tdispo_sec[$g] < 65000)	{$dispoTOTAL = ($dispoTOTAL + $Tdispo_sec[$g]);}

			if ($format=='debug') {echo "|$g|$Tagent_log_id[$g]|$Tpause_epoch[$g]|$Tpause_sec[$g]|<BR>\n";}
			$g++;
			}
		$billTOTAL = ($waitTOTAL + $talkTOTAL + $dispoTOTAL);
		$loginTOTAL = ($pauseTOTAL + $waitTOTAL + $talkTOTAL + $dispoTOTAL);

		echo "<CENTER>\n";
		#echo "<font style=\"font-size:14px;font-family:sans-serif;\"><B>"._QXZ("Agent Time Report for Today").":</B></font>\n";
		echo "<BR><BR>\n";
		if ($stage == 'ENABLED_BASIC')
			{
			echo "<TABLE CELLPADDING=2 CELLSPACING=2 BORDER=0 WIDTH=400 BGCOLOR='#999999'>";
			echo "<TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("TOTAL LOGGED IN TIME")." &nbsp; </font></TD>";
			echo "</TR><TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $loginTOTAL) . " &nbsp; </font></TD>";
			echo "</TR>";
			echo "</TABLE>";
			}
		if ($stage == 'ENABLED_FULL')
			{
			echo "<TABLE CELLPADDING=2 CELLSPACING=2 BORDER=0 WIDTH=800 BGCOLOR='#999999'>";
			echo "<TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("TOTAL LOGGED IN")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("WAIT")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("TALK")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("DISPO")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("PAUSE")." &nbsp; </font></TD>";
			echo "</TR><TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $loginTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $waitTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $talkTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $dispoTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $pauseTOTAL) . " &nbsp; </font></TD>";
			echo "</TR>";
			echo "</TABLE>";
			}
		if ($stage == 'ENABLED_BILL_BREAK_LUNCH_COACH')
			{
			echo "<TABLE CELLPADDING=2 CELLSPACING=2 BORDER=0 WIDTH=700 BGCOLOR='#999999'>";
			echo "<TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("BILLABLE")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("BREAK")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("LUNCH")." &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:14px;font-family:sans-serif;\"><B> &nbsp; "._QXZ("COACH")." &nbsp; </font></TD>";
			echo "</TR><TR>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $billTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $breakTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $lunchTOTAL) . " &nbsp; </font></TD>";
			echo "<TD BGCOLOR='white'><font style=\"font-size:12px;font-family:sans-serif;\"><B> &nbsp; " . gmdate("H:i:s", $coachTOTAL) . " &nbsp; </font></TD>";
			echo "</TR>";
			echo "</TABLE>";
			}
		echo "<BR>";
		echo "<a href=\"#\" onclick=\"AgentTimeReport('close');return false;\">"._QXZ("Close Agent Time Report")."</a>";
		echo "</CENTER>";
		}
	}



################################################################################
### customer_3way_hangup_process - send the count of the USERONLY callbacks for an agent
################################################################################
if ($ACTION == 'customer_3way_hangup_process')
	{
	$stmt="UPDATE user_call_log SET customer_hungup='$status',customer_hungup_seconds='$stage' where lead_id='$lead_id' and  user='$user' and call_type LIKE \"%3WAY%\" order by user_call_log_id desc limit 1;";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00342',$user,$server_ip,$session_name,$one_mysql_log);}

	echo _QXZ("DONE:")." $stage|$lead_id|$status";
	}




################################################################################
### DiaLableLeaDsCounT - send the count of the dialable leads in this campaign
################################################################################
if ($ACTION == 'DiaLableLeaDsCounT')
	{
	$stmt = "SELECT dialable_leads from vicidial_campaign_stats where campaign_id='$campaign';";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00252',$user,$server_ip,$session_name,$one_mysql_log);}
	if ($rslt) {$dialable_count = mysqli_num_rows($rslt);}
	if ($dialable_count > 0)
		{
		$row=mysqli_fetch_row($rslt);
		$DLcount	= $row[0];
		}

	echo "$DLcount";
	$stage = $DLcount;
	}


################################################################################
### Clear_API_Field - clears a single vicidial_live_agents field
################################################################################
if ($ACTION == 'Clear_API_Field')
	{
	$stmt="UPDATE vicidial_live_agents SET $comments='' where user='$user';";
		if ($format=='debug') {echo "\n<!-- $stmt -->";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00343',$user,$server_ip,$session_name,$one_mysql_log);}

	echo _QXZ("DONE:")." $comments";
	}


################################################################################
### Log_Webform_Click - Logs the URL of a webform that has been clicked on or opened
################################################################################
if ($ACTION == 'Log_Webform_Click')
	{
	### insert a new url log entry
	$SQL_log = "$url_link";
	$SQL_log = preg_replace('/;/','',$SQL_log);
	$SQL_log = addslashes($SQL_log);
	$stmt = "INSERT INTO vicidial_url_log SET uniqueid='$uniqueid',url_date='$NOW_TIME',url_type='webform',url='$SQL_log',url_response='$stage $lead_id';";
	if ($DB) {echo "$stmt\n";}
	$rslt=mysql_to_mysqli($stmt, $link);
		if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00694',$user,$server_ip,$session_name,$one_mysql_log);}
	$affected_rows = mysqli_affected_rows($link);

	echo _QXZ("Webform Click Logged:")." $stage $lead_id";
	}





if ($format=='debug') 
	{
	$ENDtime = date("U");
	$RUNtime = ($ENDtime - $StarTtime);
	echo "\n<!-- script runtime: $RUNtime seconds -->";
	echo "\n</body>\n</html>\n";
	}

if ($SSagent_debug_logging > 0) {vicidial_ajax_log($NOW_TIME,$startMS,$link,$ACTION,$php_script,$user,$stage,$lead_id,$session_name,$stmt);}
exit; 


##### Hangup Cause Description Map  #####
function hangup_cause_description($code)
	{
	global $hangup_cause_dictionary;
	if ( array_key_exists($code,$hangup_cause_dictionary)  ) { return $hangup_cause_dictionary[$code]; }
	else { return _QXZ("Unidentified Hangup Cause Code."); }
	}

##### SIP Hangup Cause Description Map  #####
function sip_hangup_cause_description($sip_code)
	{
	global $sip_hangup_cause_dictionary;
	if ( array_key_exists($sip_code,$sip_hangup_cause_dictionary)  ) { return $sip_hangup_cause_dictionary[$sip_code]; }
	else { return _QXZ("Unidentified SIP Hangup Cause Code."); }
	}


##### Gather custom list/in-group status group statuses  #####
function status_group_gather($status_group_id,$record_type)
	{
	global $NOW_TIME,$link,$mel,$user,$server_ip,$session_name,$one_mysql_log;

	$status_group_statuses='';
	$cs_ct=0;

	if ( (strlen($status_group_id)>0) and ($status_group_id != 'NONE') )
		{
		$stmt = "SELECT status,status_name,scheduled_callback,min_sec,max_sec from vicidial_campaign_statuses where campaign_id='$status_group_id' and selectable='Y';";
		if ($DB) {echo "$stmt\n";}
		$rslt=mysql_to_mysqli($stmt, $link);
			if ($mel > 0) {mysql_error_logging($NOW_TIME,$link,$mel,$stmt,'00654',$user,$server_ip,$session_name,$one_mysql_log);}
		if ($rslt) {$cs_ct = mysqli_num_rows($rslt);}
		$i=0;
		while ($cs_ct > $i)
			{
			$row=mysqli_fetch_row($rslt);
			$status =				$row[0];
			$status_name =			$row[1];
			$scheduled_callback =	$row[2];
			$min_sec =				$row[3];
			$max_sec =				$row[4];
			$status_group_statuses .= "$status|$status_name|$scheduled_callback|$min_sec|$max_sec,";

			$i++;
			}
		if (strlen($status_group_statuses)>0)
			{$status_group_statuses = substr("$status_group_statuses", 0, -1);}
		}
	return $status_group_statuses;
	}

?>
