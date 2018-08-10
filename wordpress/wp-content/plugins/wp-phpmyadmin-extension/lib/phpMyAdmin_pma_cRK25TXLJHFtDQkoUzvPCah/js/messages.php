<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Exporting of translated messages from PHP to Javascript
 *
 * @package PhpMyAdmin
 */

if (!defined('TESTSUITE')) {
    chdir('..');

    // Send correct type:
    header('Content-Type: text/javascript; charset=UTF-8');

    // Cache output in client - the nocache query parameter makes sure that this
    // file is reloaded when config changes
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

    // Avoid loading the full common.inc.php because this would add many
    // non-js-compatible stuff like DOCTYPE
    define('PMA_MINIMUM_COMMON', true);
    define('PMA_PATH_TO_BASEDIR', '../');
    require_once './libraries/common.inc.php';
    // Close session early as we won't write anything there
    session_write_close();
}

// But this one is needed for Sanitize::escapeJsString()
use PhpMyAdmin\Sanitize;


$buffer = PhpMyAdmin\OutputBuffering::getInstance();
$buffer->start();
if (!defined('TESTSUITE')) {
    register_shutdown_function(
        function () {
            echo PhpMyAdmin\OutputBuffering::getInstance()->getContents();
        }
    );
}

/* For confirmations */
$js_messages['strConfirm'] = __PMA_TRANSL('Confirm');
$js_messages['strDoYouReally'] = __PMA_TRANSL('Do you really want to execute "%s"?');
$js_messages['strDropDatabaseStrongWarning']
    = __PMA_TRANSL('You are about to DESTROY a complete database!');
$js_messages['strDatabaseRenameToSameName']
    = __PMA_TRANSL('Cannot rename database to the same name. Change the name and try again');
$js_messages['strDropTableStrongWarning']
    = __PMA_TRANSL('You are about to DESTROY a complete table!');
$js_messages['strTruncateTableStrongWarning']
    = __PMA_TRANSL('You are about to TRUNCATE a complete table!');
$js_messages['strDeleteTrackingData'] = __PMA_TRANSL('Delete tracking data for this table?');
$js_messages['strDeleteTrackingDataMultiple']
    = __PMA_TRANSL('Delete tracking data for these tables?');
$js_messages['strDeleteTrackingVersion']
    = __PMA_TRANSL('Delete tracking data for this version?');
$js_messages['strDeleteTrackingVersionMultiple']
    = __PMA_TRANSL('Delete tracking data for these versions?');
$js_messages['strDeletingTrackingEntry'] = __PMA_TRANSL('Delete entry from tracking report?');
$js_messages['strDeletingTrackingData'] = __PMA_TRANSL('Deleting tracking data');
$js_messages['strDroppingPrimaryKeyIndex'] = __PMA_TRANSL('Dropping Primary Key/Index');
$js_messages['strDroppingForeignKey'] = __PMA_TRANSL('Dropping Foreign key.');
$js_messages['strOperationTakesLongTime']
    = __PMA_TRANSL('This operation could take a long time. Proceed anyway?');
$js_messages['strDropUserGroupWarning']
    = __PMA_TRANSL('Do you really want to delete user group "%s"?');
$js_messages['strConfirmDeleteQBESearch']
    = __PMA_TRANSL('Do you really want to delete the search "%s"?');
$js_messages['strConfirmNavigation']
    = __PMA_TRANSL('You have unsaved changes; are you sure you want to leave this page?');
$js_messages['strConfirmRowChange']
    = __PMA_TRANSL('You are trying to reduce the number of rows, but have already entered data in those rows which will be lost. Do you wish to continue?');
$js_messages['strDropUserWarning']
    = __PMA_TRANSL('Do you really want to revoke the selected user(s) ?');
$js_messages['strDeleteCentralColumnWarning']
    = __PMA_TRANSL('Do you really want to delete this central column?');
$js_messages['strDropRTEitems']
    = __PMA_TRANSL('Do you really want to delete the selected items?');
$js_messages['strDropPartitionWarning'] = __PMA_TRANSL(
    'Do you really want to DROP the selected partition(s)? This will also DELETE ' .
    'the data related to the selected partition(s)!'
);
$js_messages['strTruncatePartitionWarning']
    = __PMA_TRANSL('Do you really want to TRUNCATE the selected partition(s)?');
$js_messages['strRemovePartitioningWarning']
    = __PMA_TRANSL('Do you really want to remove partitioning?');
$js_messages['strResetSlaveWarning'] = __PMA_TRANSL('Do you really want to RESET SLAVE?');
$js_messages['strChangeColumnCollation'] = __PMA_TRANSL(
    'This operation will attempt to convert your data to the new collation. In '
    . 'rare cases, especially where a character doesn\'t exist in the new '
    . 'collation, this process could cause the data to appear incorrectly under '
    . 'the new collation; in this case we suggest you revert to the original '
    . 'collation and refer to the tips at '
)
    . '<a href="%s" target="garbled_data_wiki">' . __PMA_TRANSL('Garbled Data') . '</a>.'
    . '<br/><br/>'
    . __PMA_TRANSL('Are you sure you wish to change the collation and convert the data?');
$js_messages['strChangeAllColumnCollationsWarning'] = __PMA_TRANSL(
    'Through this operation, MySQL attempts to map the data values between '
    . 'collations. If the character sets are incompatible, there may be data loss '
    . 'and this lost data may <b>NOT</b> be recoverable simply by changing back the '
    . 'column collation(s). <b>To convert existing data, it is suggested to use the '
    . 'column(s) editing feature (the "Change" Link) on the table structure page. '
    . '</b>'
)
. '<br/><br/>'
. __PMA_TRANSL(
    'Are you sure you wish to change all the column collations and convert the data?'
);

/* For modal dialog buttons */
$js_messages['strSaveAndClose'] = __PMA_TRANSL('Save & close');
$js_messages['strReset'] = __PMA_TRANSL('Reset');
$js_messages['strResetAll'] = __PMA_TRANSL('Reset all');

/* For indexes */
$js_messages['strFormEmpty'] = __PMA_TRANSL('Missing value in the form!');
$js_messages['strRadioUnchecked'] = __PMA_TRANSL('Select at least one of the options!');
$js_messages['strEnterValidNumber'] = __PMA_TRANSL('Please enter a valid number!');
$js_messages['strEnterValidLength'] = __PMA_TRANSL('Please enter a valid length!');
$js_messages['strAddIndex'] = __PMA_TRANSL('Add index');
$js_messages['strEditIndex'] = __PMA_TRANSL('Edit index');
$js_messages['strAddToIndex'] = __PMA_TRANSL('Add %s column(s) to index');
$js_messages['strCreateSingleColumnIndex'] = __PMA_TRANSL('Create single-column index');
$js_messages['strCreateCompositeIndex'] = __PMA_TRANSL('Create composite index');
$js_messages['strCompositeWith'] = __PMA_TRANSL('Composite with:');
$js_messages['strMissingColumn'] = __PMA_TRANSL('Please select column(s) for the index.');

/* For Preview SQL*/
$js_messages['strPreviewSQL'] = __PMA_TRANSL('Preview SQL');

/* For Simulate DML*/
$js_messages['strSimulateDML'] = __PMA_TRANSL('Simulate query');
$js_messages['strMatchedRows'] = __PMA_TRANSL('Matched rows:');
$js_messages['strSQLQuery'] = __PMA_TRANSL('SQL query:');

/* Charts */
/* l10n: Default label for the y-Axis of Charts */
$js_messages['strYValues'] = __PMA_TRANSL('Y values');

/* For server_privileges.js */
$js_messages['strHostEmpty'] = __PMA_TRANSL('The host name is empty!');
$js_messages['strUserEmpty'] = __PMA_TRANSL('The user name is empty!');
$js_messages['strPasswordEmpty'] = __PMA_TRANSL('The password is empty!');
$js_messages['strPasswordNotSame'] = __PMA_TRANSL('The passwords aren\'t the same!');
$js_messages['strRemovingSelectedUsers'] = __PMA_TRANSL('Removing Selected Users');
$js_messages['strClose'] = __PMA_TRANSL('Close');

/* For export.js */
$js_messages['strTemplateCreated'] = __PMA_TRANSL('Template was created.');
$js_messages['strTemplateLoaded'] = __PMA_TRANSL('Template was loaded.');
$js_messages['strTemplateUpdated'] = __PMA_TRANSL('Template was updated.');
$js_messages['strTemplateDeleted'] = __PMA_TRANSL('Template was deleted.');

/* l10n: Other, small valued, queries */
$js_messages['strOther'] = __PMA_TRANSL('Other');
/* l10n: Thousands separator */
$js_messages['strThousandsSeparator'] = __PMA_TRANSL(',');
/* l10n: Decimal separator */
$js_messages['strDecimalSeparator'] = __PMA_TRANSL('.');

$js_messages['strChartConnectionsTitle'] = __PMA_TRANSL('Connections / Processes');

/* server status monitor */
$js_messages['strIncompatibleMonitorConfig']
    = __PMA_TRANSL('Local monitor configuration incompatible!');
$js_messages['strIncompatibleMonitorConfigDescription'] = __PMA_TRANSL(
    'The chart arrangement configuration in your browsers local storage is not '
    . 'compatible anymore to the newer version of the monitor dialog. It is very '
    . 'likely that your current configuration will not work anymore. Please reset '
    . 'your configuration to default in the <i>Settings</i> menu.'
);

$js_messages['strQueryCacheEfficiency'] = __PMA_TRANSL('Query cache efficiency');
$js_messages['strQueryCacheUsage'] = __PMA_TRANSL('Query cache usage');
$js_messages['strQueryCacheUsed'] = __PMA_TRANSL('Query cache used');

$js_messages['strSystemCPUUsage'] = __PMA_TRANSL('System CPU usage');
$js_messages['strSystemMemory'] = __PMA_TRANSL('System memory');
$js_messages['strSystemSwap'] = __PMA_TRANSL('System swap');

$js_messages['strAverageLoad'] = __PMA_TRANSL('Average load');
$js_messages['strTotalMemory'] = __PMA_TRANSL('Total memory');
$js_messages['strCachedMemory'] = __PMA_TRANSL('Cached memory');
$js_messages['strBufferedMemory'] = __PMA_TRANSL('Buffered memory');
$js_messages['strFreeMemory'] = __PMA_TRANSL('Free memory');
$js_messages['strUsedMemory'] = __PMA_TRANSL('Used memory');

$js_messages['strTotalSwap'] = __PMA_TRANSL('Total swap');
$js_messages['strCachedSwap'] = __PMA_TRANSL('Cached swap');
$js_messages['strUsedSwap'] = __PMA_TRANSL('Used swap');
$js_messages['strFreeSwap'] = __PMA_TRANSL('Free swap');

$js_messages['strBytesSent'] = __PMA_TRANSL('Bytes sent');
$js_messages['strBytesReceived'] = __PMA_TRANSL('Bytes received');
$js_messages['strConnections'] = __PMA_TRANSL('Connections');
$js_messages['strProcesses'] = __PMA_TRANSL('Processes');

/* summary row */
$js_messages['strB'] = __PMA_TRANSL('B');
$js_messages['strKiB'] = __PMA_TRANSL('KiB');
$js_messages['strMiB'] = __PMA_TRANSL('MiB');
$js_messages['strGiB'] = __PMA_TRANSL('GiB');
$js_messages['strTiB'] = __PMA_TRANSL('TiB');
$js_messages['strPiB'] = __PMA_TRANSL('PiB');
$js_messages['strEiB'] = __PMA_TRANSL('EiB');
$js_messages['strNTables'] = __PMA_TRANSL('%d table(s)');

/* l10n: Questions is the name of a MySQL Status variable */
$js_messages['strQuestions'] = __PMA_TRANSL('Questions');
$js_messages['strTraffic'] = __PMA_TRANSL('Traffic');
$js_messages['strSettings'] = __PMA_TRANSL('Settings');
$js_messages['strAddChart'] = __PMA_TRANSL('Add chart to grid');
$js_messages['strClose'] = __PMA_TRANSL('Close');
$js_messages['strAddOneSeriesWarning']
    = __PMA_TRANSL('Please add at least one variable to the series!');
$js_messages['strNone'] = __PMA_TRANSL('None');
$js_messages['strResumeMonitor'] = __PMA_TRANSL('Resume monitor');
$js_messages['strPauseMonitor'] = __PMA_TRANSL('Pause monitor');
$js_messages['strStartRefresh'] = __PMA_TRANSL('Start auto refresh');
$js_messages['strStopRefresh'] = __PMA_TRANSL('Stop auto refresh');
/* Monitor: Instructions Dialog */
$js_messages['strBothLogOn'] = __PMA_TRANSL('general_log and slow_query_log are enabled.');
$js_messages['strGenLogOn'] = __PMA_TRANSL('general_log is enabled.');
$js_messages['strSlowLogOn'] = __PMA_TRANSL('slow_query_log is enabled.');
$js_messages['strBothLogOff'] = __PMA_TRANSL('slow_query_log and general_log are disabled.');
$js_messages['strLogOutNotTable'] = __PMA_TRANSL('log_output is not set to TABLE.');
$js_messages['strLogOutIsTable'] = __PMA_TRANSL('log_output is set to TABLE.');
$js_messages['strSmallerLongQueryTimeAdvice'] = __PMA_TRANSL(
    'slow_query_log is enabled, but the server logs only queries that take longer '
    . 'than %d seconds. It is advisable to set this long_query_time 0-2 seconds, '
    . 'depending on your system.'
);
$js_messages['strLongQueryTimeSet'] = __PMA_TRANSL('long_query_time is set to %d second(s).');
$js_messages['strSettingsAppliedGlobal'] = __PMA_TRANSL(
    'Following settings will be applied globally and reset to default on server '
    . 'restart:'
);
/* l10n: %s is FILE or TABLE */
$js_messages['strSetLogOutput'] = __PMA_TRANSL('Set log_output to %s');
/* l10n: Enable in this context means setting a status variable to ON */
$js_messages['strEnableVar'] = __PMA_TRANSL('Enable %s');
/* l10n: Disable in this context means setting a status variable to OFF */
$js_messages['strDisableVar'] = __PMA_TRANSL('Disable %s');
/* l10n: %d seconds */
$js_messages['setSetLongQueryTime'] = __PMA_TRANSL('Set long_query_time to %d seconds.');
$js_messages['strNoSuperUser'] = __PMA_TRANSL(
    'You can\'t change these variables. Please log in as root or contact'
    . ' your database administrator.'
);
$js_messages['strChangeSettings'] = __PMA_TRANSL('Change settings');
$js_messages['strCurrentSettings'] = __PMA_TRANSL('Current settings');

$js_messages['strChartTitle'] = __PMA_TRANSL('Chart title');
/* l10n: As in differential values */
$js_messages['strDifferential'] = __PMA_TRANSL('Differential');
$js_messages['strDividedBy'] = __PMA_TRANSL('Divided by %s');
$js_messages['strUnit'] = __PMA_TRANSL('Unit');

$js_messages['strFromSlowLog'] = __PMA_TRANSL('From slow log');
$js_messages['strFromGeneralLog'] = __PMA_TRANSL('From general log');
$js_messages['strServerLogError'] = __PMA_TRANSL(
    'The database name is not known for this query in the server\'s logs.'
);
$js_messages['strAnalysingLogsTitle'] = __PMA_TRANSL('Analysing logs');
$js_messages['strAnalysingLogs']
    = __PMA_TRANSL('Analysing & loading logs. This may take a while.');
$js_messages['strCancelRequest'] = __PMA_TRANSL('Cancel request');
$js_messages['strCountColumnExplanation'] = __PMA_TRANSL(
    'This column shows the amount of identical queries that are grouped together. '
    . 'However only the SQL query itself has been used as a grouping criteria, so '
    . 'the other attributes of queries, such as start time, may differ.'
);
$js_messages['strMoreCountColumnExplanation'] = __PMA_TRANSL(
    'Since grouping of INSERTs queries has been selected, INSERT queries into the '
    . 'same table are also being grouped together, disregarding of the inserted '
    . 'data.'
);
$js_messages['strLogDataLoaded']
    = __PMA_TRANSL('Log data loaded. Queries executed in this time span:');

$js_messages['strJumpToTable'] = __PMA_TRANSL('Jump to Log table');
$js_messages['strNoDataFoundTitle'] = __PMA_TRANSL('No data found');
$js_messages['strNoDataFound']
    = __PMA_TRANSL('Log analysed, but no data found in this time span.');

$js_messages['strAnalyzing'] = __PMA_TRANSL('Analyzing…');
$js_messages['strExplainOutput'] = __PMA_TRANSL('Explain output');
$js_messages['strStatus'] = __PMA_TRANSL('Status');
$js_messages['strTime'] = __PMA_TRANSL('Time');
$js_messages['strTotalTime'] = __PMA_TRANSL('Total time:');
$js_messages['strProfilingResults'] = __PMA_TRANSL('Profiling results');
$js_messages['strTable'] = _pgettext('Display format', 'Table');
$js_messages['strChart'] = __PMA_TRANSL('Chart');

$js_messages['strAliasDatabase'] = _pgettext('Alias', 'Database');
$js_messages['strAliasTable'] = _pgettext('Alias', 'Table');
$js_messages['strAliasColumn'] = _pgettext('Alias', 'Column');

/* l10n: A collection of available filters */
$js_messages['strFiltersForLogTable'] = __PMA_TRANSL('Log table filter options');
/* l10n: Filter as in "Start Filtering" */
$js_messages['strFilter'] = __PMA_TRANSL('Filter');
$js_messages['strFilterByWordRegexp'] = __PMA_TRANSL('Filter queries by word/regexp:');
$js_messages['strIgnoreWhereAndGroup']
    = __PMA_TRANSL('Group queries, ignoring variable data in WHERE clauses');
$js_messages['strSumRows'] = __PMA_TRANSL('Sum of grouped rows:');
$js_messages['strTotal'] = __PMA_TRANSL('Total:');

$js_messages['strLoadingLogs'] = __PMA_TRANSL('Loading logs');
$js_messages['strRefreshFailed'] = __PMA_TRANSL('Monitor refresh failed');
$js_messages['strInvalidResponseExplanation'] = __PMA_TRANSL(
    'While requesting new chart data the server returned an invalid response. This '
    . 'is most likely because your session expired. Reloading the page and '
    . 'reentering your credentials should help.'
);
$js_messages['strReloadPage'] = __PMA_TRANSL('Reload page');

$js_messages['strAffectedRows'] = __PMA_TRANSL('Affected rows:');

$js_messages['strFailedParsingConfig'] = __PMA_TRANSL(
    'Failed parsing config file. It doesn\'t seem to be valid JSON code.'
);
$js_messages['strFailedBuildingGrid'] = __PMA_TRANSL(
    'Failed building chart grid with imported config. Resetting to default config…'
);
$js_messages['strImport'] = __PMA_TRANSL('Import');
$js_messages['strImportDialogTitle'] = __PMA_TRANSL('Import monitor configuration');
$js_messages['strImportDialogMessage']
    = __PMA_TRANSL('Please select the file you want to import.');
$js_messages['strNoImportFile'] = __PMA_TRANSL('No files available on server for import!');

$js_messages['strAnalyzeQuery'] = __PMA_TRANSL('Analyse query');

/* Server status advisor */

$js_messages['strAdvisorSystem'] = __PMA_TRANSL('Advisor system');
$js_messages['strPerformanceIssues'] = __PMA_TRANSL('Possible performance issues');
$js_messages['strIssuse'] = __PMA_TRANSL('Issue');
$js_messages['strRecommendation'] = __PMA_TRANSL('Recommendation');
$js_messages['strRuleDetails'] = __PMA_TRANSL('Rule details');
$js_messages['strJustification'] = __PMA_TRANSL('Justification');
$js_messages['strFormula'] = __PMA_TRANSL('Used variable / formula');
$js_messages['strTest'] = __PMA_TRANSL('Test');

/* For query editor */
$js_messages['strFormatting'] = __PMA_TRANSL('Formatting SQL…');
$js_messages['strNoParam'] = __PMA_TRANSL('No parameters found!');

/* For inline query editing */
$js_messages['strGo'] = __PMA_TRANSL('Go');
$js_messages['strCancel'] = __PMA_TRANSL('Cancel');

/* For page-related settings */
$js_messages['strPageSettings'] = __PMA_TRANSL('Page-related settings');
$js_messages['strApply'] = __PMA_TRANSL('Apply');

/* For Ajax Notifications */
$js_messages['strLoading'] = __PMA_TRANSL('Loading…');
$js_messages['strAbortedRequest'] = __PMA_TRANSL('Request aborted!!');
$js_messages['strProcessingRequest'] = __PMA_TRANSL('Processing request');
$js_messages['strRequestFailed'] = __PMA_TRANSL('Request failed!!');
$js_messages['strErrorProcessingRequest'] = __PMA_TRANSL('Error in processing request');
$js_messages['strErrorCode'] = __PMA_TRANSL('Error code: %s');
$js_messages['strErrorText'] = __PMA_TRANSL('Error text: %s');
$js_messages['strErrorConnection'] = __PMA_TRANSL(
    'It seems that the connection to server has been lost. Please check your ' .
    'network connectivity and server status.'
);
$js_messages['strNoDatabasesSelected'] = __PMA_TRANSL('No databases selected.');
$js_messages['strNoAccountSelected'] = __PMA_TRANSL('No accounts selected.');
$js_messages['strDroppingColumn'] = __PMA_TRANSL('Dropping column');
$js_messages['strAddingPrimaryKey'] = __PMA_TRANSL('Adding primary key');
$js_messages['strOK'] = __PMA_TRANSL('OK');
$js_messages['strDismiss'] = __PMA_TRANSL('Click to dismiss this notification');

/* For db_operations.js */
$js_messages['strRenamingDatabases'] = __PMA_TRANSL('Renaming databases');
$js_messages['strCopyingDatabase'] = __PMA_TRANSL('Copying database');
$js_messages['strChangingCharset'] = __PMA_TRANSL('Changing charset');
$js_messages['strNo'] = __PMA_TRANSL('No');

/* For Foreign key checks */
$js_messages['strForeignKeyCheck'] = __PMA_TRANSL('Enable foreign key checks');

/* For db_stucture.js */
$js_messages['strErrorRealRowCount'] = __PMA_TRANSL('Failed to get real row count.');

/* For db_search.js */
$js_messages['strSearching'] = __PMA_TRANSL('Searching');
$js_messages['strHideSearchResults'] = __PMA_TRANSL('Hide search results');
$js_messages['strShowSearchResults'] = __PMA_TRANSL('Show search results');
$js_messages['strBrowsing'] = __PMA_TRANSL('Browsing');
$js_messages['strDeleting'] = __PMA_TRANSL('Deleting');
$js_messages['strConfirmDeleteResults'] = __PMA_TRANSL('Delete the matches for the %s table?');

/* For db_routines.js */
$js_messages['MissingReturn']
    = __PMA_TRANSL('The definition of a stored function must contain a RETURN statement!');
$js_messages['strExport'] = __PMA_TRANSL('Export');
$js_messages['NoExportable']
    = __PMA_TRANSL('No routine is exportable. Required privileges may be lacking.');

/* For ENUM/SET editor*/
$js_messages['enum_editor'] = __PMA_TRANSL('ENUM/SET editor');
$js_messages['enum_columnVals'] =__PMA_TRANSL('Values for column %s');
$js_messages['enum_newColumnVals'] = __PMA_TRANSL('Values for a new column');
$js_messages['enum_hint'] =__PMA_TRANSL('Enter each value in a separate field.');
$js_messages['enum_addValue'] =__PMA_TRANSL('Add %d value(s)');

/* For import.js */
$js_messages['strImportCSV'] = __PMA_TRANSL(
    'Note: If the file contains multiple tables, they will be combined into one.'
);

/* For sql.js */
$js_messages['strHideQueryBox'] = __PMA_TRANSL('Hide query box');
$js_messages['strShowQueryBox'] = __PMA_TRANSL('Show query box');
$js_messages['strEdit'] = __PMA_TRANSL('Edit');
$js_messages['strDelete'] = __PMA_TRANSL('Delete');
$js_messages['strNotValidRowNumber'] = __PMA_TRANSL('%d is not valid row number.');
$js_messages['strBrowseForeignValues'] = __PMA_TRANSL('Browse foreign values');
$js_messages['strNoAutoSavedQuery'] = __PMA_TRANSL('No auto-saved query');
$js_messages['strBookmarkVariable'] = __PMA_TRANSL('Variable %d:');

/* For Central list of columns */
$js_messages['pickColumn'] = __PMA_TRANSL('Pick');
$js_messages['pickColumnTitle'] = __PMA_TRANSL('Column selector');
$js_messages['searchList'] = __PMA_TRANSL('Search this list');
$js_messages['strEmptyCentralList'] = __PMA_TRANSL(
    'No columns in the central list. Make sure the Central columns list for '
    . 'database %s has columns that are not present in the current table.'
);
$js_messages['seeMore'] = __PMA_TRANSL('See more');
$js_messages['confirmTitle'] = __PMA_TRANSL('Are you sure?');
$js_messages['makeConsistentMessage'] = __PMA_TRANSL(
    'This action may change some of the columns definition.<br/>Are you sure you '
    . 'want to continue?'
);
$js_messages['strContinue'] = __PMA_TRANSL('Continue');

/** For normalization */
$js_messages['strAddPrimaryKey'] = __PMA_TRANSL('Add primary key');
$js_messages['strPrimaryKeyAdded'] = __PMA_TRANSL('Primary key added.');
$js_messages['strToNextStep'] = __PMA_TRANSL('Taking you to next step…');
$js_messages['strFinishMsg']
    = __PMA_TRANSL("The first step of normalization is complete for table '%s'.");
$js_messages['strEndStep'] = __PMA_TRANSL("End of step");
$js_messages['str2NFNormalization'] = __PMA_TRANSL('Second step of normalization (2NF)');
$js_messages['strDone'] = __PMA_TRANSL('Done');
$js_messages['strConfirmPd'] = __PMA_TRANSL('Confirm partial dependencies');
$js_messages['strSelectedPd'] = __PMA_TRANSL('Selected partial dependencies are as follows:');
$js_messages['strPdHintNote'] = __PMA_TRANSL(
    'Note: a, b -> d,f implies values of columns a and b combined together can '
    . 'determine values of column d and column f.'
);
$js_messages['strNoPdSelected'] = __PMA_TRANSL('No partial dependencies selected!');
$js_messages['strBack'] = __PMA_TRANSL('Back');
$js_messages['strShowPossiblePd']
    = __PMA_TRANSL('Show me the possible partial dependencies based on data in the table');
$js_messages['strHidePd'] = __PMA_TRANSL('Hide partial dependencies list');
$js_messages['strWaitForPd'] = __PMA_TRANSL(
    'Sit tight! It may take few seconds depending on data size and column count of '
    . 'the table.'
);
$js_messages['strStep'] = __PMA_TRANSL('Step');
$js_messages['strMoveRepeatingGroup']
    = '<ol><b>' . __PMA_TRANSL('The following actions will be performed:') . '</b>'
    . '<li>' . __PMA_TRANSL('DROP columns %s from the table %s') . '</li>'
    . '<li>' . __PMA_TRANSL('Create the following table') . '</li>';
$js_messages['strNewTablePlaceholder'] = 'Enter new table name';
$js_messages['strNewColumnPlaceholder'] = 'Enter column name';
$js_messages['str3NFNormalization'] = __PMA_TRANSL('Third step of normalization (3NF)');
$js_messages['strConfirmTd'] = __PMA_TRANSL('Confirm transitive dependencies');
$js_messages['strSelectedTd'] = __PMA_TRANSL('Selected dependencies are as follows:');
$js_messages['strNoTdSelected'] = __PMA_TRANSL('No dependencies selected!');

/* For server_variables.js */
$js_messages['strSave'] = __PMA_TRANSL('Save');

/* For tbl_select.js */
$js_messages['strHideSearchCriteria'] = __PMA_TRANSL('Hide search criteria');
$js_messages['strShowSearchCriteria'] = __PMA_TRANSL('Show search criteria');
$js_messages['strRangeSearch'] = __PMA_TRANSL('Range search');
$js_messages['strColumnMax'] = __PMA_TRANSL('Column maximum:');
$js_messages['strColumnMin'] = __PMA_TRANSL('Column minimum:');
$js_messages['strMinValue'] = __PMA_TRANSL('Minimum value:');
$js_messages['strMaxValue'] = __PMA_TRANSL('Maximum value:');

/* For tbl_find_replace.js */
$js_messages['strHideFindNReplaceCriteria'] = __PMA_TRANSL('Hide find and replace criteria');
$js_messages['strShowFindNReplaceCriteria'] = __PMA_TRANSL('Show find and replace criteria');

/* For tbl_zoom_plot_jqplot.js */
$js_messages['strDisplayHelp'] = '<ul><li>'
    . __PMA_TRANSL('Each point represents a data row.')
    . '</li><li>'
    . __PMA_TRANSL('Hovering over a point will show its label.')
    . '</li><li>'
    . __PMA_TRANSL('To zoom in, select a section of the plot with the mouse.')
    . '</li><li>'
    . __PMA_TRANSL('Click reset zoom button to come back to original state.')
    . '</li><li>'
    . __PMA_TRANSL('Click a data point to view and possibly edit the data row.')
    . '</li><li>'
    . __PMA_TRANSL('The plot can be resized by dragging it along the bottom right corner.')
    . '</li></ul>';
$js_messages['strHelpTitle'] = 'Zoom search instructions';
$js_messages['strInputNull'] = '<strong>' . __PMA_TRANSL('Select two columns') . '</strong>';
$js_messages['strSameInputs'] = '<strong>'
    . __PMA_TRANSL('Select two different columns')
    . '</strong>';
$js_messages['strDataPointContent'] = __PMA_TRANSL('Data point content');

/* For tbl_change.js */
$js_messages['strIgnore'] = __PMA_TRANSL('Ignore');
$js_messages['strCopy'] = __PMA_TRANSL('Copy');
$js_messages['strX'] = __PMA_TRANSL('X');
$js_messages['strY'] = __PMA_TRANSL('Y');
$js_messages['strPoint'] = __PMA_TRANSL('Point');
$js_messages['strPointN'] = __PMA_TRANSL('Point %d');
$js_messages['strLineString'] = __PMA_TRANSL('Linestring');
$js_messages['strPolygon'] = __PMA_TRANSL('Polygon');
$js_messages['strGeometry'] = __PMA_TRANSL('Geometry');
$js_messages['strInnerRing'] = __PMA_TRANSL('Inner ring');
$js_messages['strOuterRing'] = __PMA_TRANSL('Outer ring');
$js_messages['strAddPoint'] = __PMA_TRANSL('Add a point');
$js_messages['strAddInnerRing'] = __PMA_TRANSL('Add an inner ring');
$js_messages['strYes'] = __PMA_TRANSL('Yes');
$js_messages['strCopyEncryptionKey'] = __PMA_TRANSL('Do you want to copy encryption key?');
$js_messages['strEncryptionKey'] = __PMA_TRANSL('Encryption key');

/* For Tip to be shown on Time field */
$js_messages['strMysqlAllowedValuesTipTime'] = __PMA_TRANSL(
    'MySQL accepts additional values not selectable by the slider;'
    . ' key in those values directly if desired'
);

/* For Tip to be shown on Date field */
$js_messages['strMysqlAllowedValuesTipDate'] = __PMA_TRANSL(
    'MySQL accepts additional values not selectable by the datepicker;'
    . ' key in those values directly if desired'
);

/* For Lock symbol Tooltip */
$js_messages['strLockToolTip'] = __PMA_TRANSL(
    'Indicates that you have made changes to this page;'
    . ' you will be prompted for confirmation before abandoning changes'
);

/* Designer (js/designer/move.js) */
$js_messages['strSelectReferencedKey'] = __PMA_TRANSL('Select referenced key');
$js_messages['strSelectForeignKey'] = __PMA_TRANSL('Select Foreign Key');
$js_messages['strPleaseSelectPrimaryOrUniqueKey']
    = __PMA_TRANSL('Please select the primary key or a unique key!');
$js_messages['strChangeDisplay'] = __PMA_TRANSL('Choose column to display');
$js_messages['strLeavingDesigner'] = __PMA_TRANSL(
    'You haven\'t saved the changes in the layout. They will be lost if you'
    . ' don\'t save them. Do you want to continue?'
);
$js_messages['strQueryEmpty'] = __PMA_TRANSL('value/subQuery is empty');
$js_messages['strAddTables'] = __PMA_TRANSL('Add tables from other databases');
$js_messages['strPageName'] = __PMA_TRANSL('Page name');
$js_messages['strSavePage'] = __PMA_TRANSL('Save page');
$js_messages['strSavePageAs'] = __PMA_TRANSL('Save page as');
$js_messages['strOpenPage'] = __PMA_TRANSL('Open page');
$js_messages['strDeletePage'] = __PMA_TRANSL('Delete page');
$js_messages['strUntitled'] = __PMA_TRANSL('Untitled');
$js_messages['strSelectPage'] = __PMA_TRANSL('Please select a page to continue');
$js_messages['strEnterValidPageName'] = __PMA_TRANSL('Please enter a valid page name');
$js_messages['strLeavingPage']
    = __PMA_TRANSL('Do you want to save the changes to the current page?');
$js_messages['strSuccessfulPageDelete'] = __PMA_TRANSL('Successfully deleted the page');
$js_messages['strExportRelationalSchema'] = __PMA_TRANSL('Export relational schema');
$js_messages['strModificationSaved'] = __PMA_TRANSL('Modifications have been saved');

/* Visual query builder (js/designer/move.js) */
$js_messages['strAddOption'] = __PMA_TRANSL('Add an option for column "%s".');
$js_messages['strObjectsCreated'] = __PMA_TRANSL('%d object(s) created.');
$js_messages['strSubmit'] = __PMA_TRANSL('Submit');

/* For makegrid.js (column reordering, show/hide column, grid editing) */
$js_messages['strCellEditHint'] = __PMA_TRANSL('Press escape to cancel editing.');
$js_messages['strSaveCellWarning'] = __PMA_TRANSL(
    'You have edited some data and they have not been saved. Are you sure you want '
    . 'to leave this page before saving the data?'
);
$js_messages['strColOrderHint'] = __PMA_TRANSL('Drag to reorder.');
$js_messages['strSortHint'] = __PMA_TRANSL('Click to sort results by this column.');
$js_messages['strMultiSortHint'] = __PMA_TRANSL(
    'Shift+Click to add this column to ORDER BY clause or to toggle ASC/DESC.'
    . '<br />- Ctrl+Click or Alt+Click (Mac: Shift+Option+Click) to remove column '
    . 'from ORDER BY clause'
);
$js_messages['strColMarkHint'] = __PMA_TRANSL('Click to mark/unmark.');
$js_messages['strColNameCopyHint'] = __PMA_TRANSL('Double-click to copy column name.');
$js_messages['strColVisibHint'] = __PMA_TRANSL(
    'Click the drop-down arrow<br />to toggle column\'s visibility.'
);
$js_messages['strShowAllCol'] = __PMA_TRANSL('Show all');
$js_messages['strAlertNonUnique'] = __PMA_TRANSL(
    'This table does not contain a unique column. Features related to the grid '
    . 'edit, checkbox, Edit, Copy and Delete links may not work after saving.'
);
$js_messages['strEnterValidHex']
    = __PMA_TRANSL('Please enter a valid hexadecimal string. Valid characters are 0-9, A-F.');
$js_messages['strShowAllRowsWarning'] = __PMA_TRANSL(
    'Do you really want to see all of the rows? For a big table this could crash '
    . 'the browser.'
);
$js_messages['strOriginalLength'] = __PMA_TRANSL('Original length');

/** Drag & Drop sql import messages */
$js_messages['dropImportMessageCancel'] = __PMA_TRANSL('cancel');
$js_messages['dropImportMessageAborted'] = __PMA_TRANSL('Aborted');
$js_messages['dropImportMessageFailed'] = __PMA_TRANSL('Failed');
$js_messages['dropImportMessageSuccess'] = __PMA_TRANSL('Success');
$js_messages['dropImportImportResultHeader'] = __PMA_TRANSL('Import status');
$js_messages['dropImportDropFiles'] = __PMA_TRANSL('Drop files here');
$js_messages['dropImportSelectDB'] = __PMA_TRANSL('Select database first');

/* For Print view */
$js_messages['print'] = __PMA_TRANSL('Print');
$js_messages['back'] = __PMA_TRANSL('Back');

// this approach does not work when the parameter is changed via user prefs
switch ($GLOBALS['cfg']['GridEditing']) {
case 'double-click':
    $js_messages['strGridEditFeatureHint'] = __PMA_TRANSL(
        'You can also edit most values<br />by double-clicking directly on them.'
    );
    break;
case 'click':
    $js_messages['strGridEditFeatureHint'] = __PMA_TRANSL(
        'You can also edit most values<br />by clicking directly on them.'
    );
    break;
default:
    break;
}
$js_messages['strGoToLink'] = __PMA_TRANSL('Go to link:');
$js_messages['strColNameCopyTitle'] = __PMA_TRANSL('Copy column name.');
$js_messages['strColNameCopyText']
    = __PMA_TRANSL('Right-click the column name to copy it to your clipboard.');

/* password generation */
$js_messages['strGeneratePassword'] = __PMA_TRANSL('Generate password');
$js_messages['strGenerate'] = __PMA_TRANSL('Generate');
$js_messages['strChangePassword'] = __PMA_TRANSL('Change password');

/* navigation tabs */
$js_messages['strMore'] = __PMA_TRANSL('More');

/* navigation panel */
$js_messages['strShowPanel'] = __PMA_TRANSL('Show panel');
$js_messages['strHidePanel'] = __PMA_TRANSL('Hide panel');
$js_messages['strUnhideNavItem'] = __PMA_TRANSL('Show hidden navigation tree items.');
$js_messages['linkWithMain'] = __PMA_TRANSL('Link with main panel');
$js_messages['unlinkWithMain'] = __PMA_TRANSL('Unlink from main panel');

/* microhistory */
$js_messages['strInvalidPage']
    = __PMA_TRANSL('The requested page was not found in the history, it may have expired.');

/* update */
$js_messages['strNewerVersion'] = __PMA_TRANSL(
    'A newer version of phpMyAdmin is available and you should consider upgrading. '
    . 'The newest version is %s, released on %s.'
);
/* l10n: Latest available phpMyAdmin version */
$js_messages['strLatestAvailable'] = __PMA_TRANSL(', latest stable version:');
$js_messages['strUpToDate'] = __PMA_TRANSL('up to date');

$js_messages['strCreateView'] = __PMA_TRANSL('Create view');

/* Error Reporting */
$js_messages['strSendErrorReport'] = __PMA_TRANSL("Send error report");
$js_messages['strSubmitErrorReport'] = __PMA_TRANSL("Submit error report");
$js_messages['strErrorOccurred'] = __PMA_TRANSL(
    "A fatal JavaScript error has occurred. Would you like to send an error report?"
);
$js_messages['strChangeReportSettings'] = __PMA_TRANSL("Change report settings");
$js_messages['strShowReportDetails'] = __PMA_TRANSL("Show report details");
$js_messages['strIgnore'] = __PMA_TRANSL("Ignore");
$js_messages['strTimeOutError'] = __PMA_TRANSL(
    "Your export is incomplete, due to a low execution time limit at the PHP level!"
);

$js_messages['strTooManyInputs'] = __PMA_TRANSL(
    "Warning: a form on this page has more than %d fields. On submission, "
    . "some of the fields might be ignored, due to PHP's "
    . "max_input_vars configuration."
);

$js_messages['phpErrorsFound'] = '<div class="error">'
    . __PMA_TRANSL('Some errors have been detected on the server!')
    . '<br/>'
    . __PMA_TRANSL('Please look at the bottom of this window.')
    . '<div>'
    . '<input id="pma_ignore_errors_popup" type="submit" value="'
    . __PMA_TRANSL('Ignore')
    . '" class="floatright message_errors_found">'
    . '<input id="pma_ignore_all_errors_popup" type="submit" value="'
    . __PMA_TRANSL('Ignore All')
    . '" class="floatright message_errors_found">'
    . '</div></div>';

$js_messages['phpErrorsBeingSubmitted'] = '<div class="error">'
    . __PMA_TRANSL('Some errors have been detected on the server!')
    . '<br/>'
    . __PMA_TRANSL(
        'As per your settings, they are being submitted currently, please be '
        . 'patient.'
    )
    . '<br/>'
    . '<img src="'
    . ($GLOBALS['PMA_Theme']->getImgPath('ajax_clock_small.gif'))
    . '" width="16" height="16" alt="ajax clock"/>'
    . '</div>';

// For console
$js_messages['strConsoleRequeryConfirm'] = __PMA_TRANSL('Execute this query again?');
$js_messages['strConsoleDeleteBookmarkConfirm']
    = __PMA_TRANSL('Do you really want to delete this bookmark?');
$js_messages['strConsoleDebugError']
    = __PMA_TRANSL('Some error occurred while getting SQL debug info.');
$js_messages['strConsoleDebugSummary']
    = __PMA_TRANSL('%s queries executed %s times in %s seconds.');
$js_messages['strConsoleDebugArgsSummary'] = __PMA_TRANSL('%s argument(s) passed');
$js_messages['strConsoleDebugShowArgs'] = __PMA_TRANSL('Show arguments');
$js_messages['strConsoleDebugHideArgs'] = __PMA_TRANSL('Hide arguments');
$js_messages['strConsoleDebugTimeTaken'] = __PMA_TRANSL('Time taken:');
$js_messages['strNoLocalStorage'] = __PMA_TRANSL('There was a problem accessing your browser storage, some features may not work properly for you. It is likely that the browser doesn\'t support storage or the quota limit has been reached. In Firefox, corrupted storage can also cause such a problem, clearing your "Offline Website Data" might help. In Safari, such problem is commonly caused by "Private Mode Browsing".');
// For modals in db_structure.php
$js_messages['strCopyTablesTo'] = __PMA_TRANSL('Copy tables to');
$js_messages['strAddPrefix'] = __PMA_TRANSL('Add table prefix');
$js_messages['strReplacePrefix'] = __PMA_TRANSL('Replace table with prefix');
$js_messages['strCopyPrefix'] = __PMA_TRANSL('Copy table with prefix');

/* For password strength simulation */
$js_messages['strExtrWeak'] = __PMA_TRANSL('Extremely weak');
$js_messages['strVeryWeak'] = __PMA_TRANSL('Very weak');
$js_messages['strWeak'] = __PMA_TRANSL('Weak');
$js_messages['strGood'] = __PMA_TRANSL('Good');
$js_messages['strStrong'] = __PMA_TRANSL('Strong');

/* U2F errors */
$js_messages['strU2FTimeout'] = __PMA_TRANSL('Timed out waiting for security key activation.');
$js_messages['strU2FError'] = __PMA_TRANSL('Failed security key activation (%s).');

echo "var PMA_messages = new Array();\n";
foreach ($js_messages as $name => $js_message) {
    Sanitize::printJsValue("PMA_messages['" . $name . "']", $js_message);
}

/* Calendar */
echo "var themeCalendarImage = '" , $GLOBALS['pmaThemeImage']
    , 'b_calendar.png' , "';\n";

/* Image path */
echo "var pmaThemeImage = '" , $GLOBALS['pmaThemeImage'] , "';\n";

echo "var mysql_doc_template = '" , PhpMyAdmin\Util::getMySQLDocuURL('%s')
    , "';\n";

//Max input vars allowed by PHP.
$maxInputVars = ini_get('max_input_vars');
echo 'var maxInputVars = '
    , (false === $maxInputVars || '' == $maxInputVars ? 'false' : (int)$maxInputVars)
    , ';' . "\n";

echo "if ($.datepicker) {\n";
/* l10n: Display text for calendar close link */
Sanitize::printJsValue("$.datepicker.regional['']['closeText']", __PMA_TRANSL('Done'));
/* l10n: Display text for previous month link in calendar */
Sanitize::printJsValue(
    "$.datepicker.regional['']['prevText']",
    _pgettext('Previous month', 'Prev')
);
/* l10n: Display text for next month link in calendar */
Sanitize::printJsValue(
    "$.datepicker.regional['']['nextText']",
    _pgettext('Next month', 'Next')
);
/* l10n: Display text for current month link in calendar */
Sanitize::printJsValue("$.datepicker.regional['']['currentText']", __PMA_TRANSL('Today'));
Sanitize::printJsValue(
    "$.datepicker.regional['']['monthNames']",
    array(
        __PMA_TRANSL('January'),
        __PMA_TRANSL('February'),
        __PMA_TRANSL('March'),
        __PMA_TRANSL('April'),
        __PMA_TRANSL('May'),
        __PMA_TRANSL('June'),
        __PMA_TRANSL('July'),
        __PMA_TRANSL('August'),
        __PMA_TRANSL('September'),
        __PMA_TRANSL('October'),
        __PMA_TRANSL('November'),
        __PMA_TRANSL('December')
    )
);
Sanitize::printJsValue(
    "$.datepicker.regional['']['monthNamesShort']",
    array(
        /* l10n: Short month name */
        __PMA_TRANSL('Jan'),
        /* l10n: Short month name */
        __PMA_TRANSL('Feb'),
        /* l10n: Short month name */
        __PMA_TRANSL('Mar'),
        /* l10n: Short month name */
        __PMA_TRANSL('Apr'),
        /* l10n: Short month name */
        _pgettext('Short month name', 'May'),
        /* l10n: Short month name */
        __PMA_TRANSL('Jun'),
        /* l10n: Short month name */
        __PMA_TRANSL('Jul'),
        /* l10n: Short month name */
        __PMA_TRANSL('Aug'),
        /* l10n: Short month name */
        __PMA_TRANSL('Sep'),
        /* l10n: Short month name */
        __PMA_TRANSL('Oct'),
        /* l10n: Short month name */
        __PMA_TRANSL('Nov'),
        /* l10n: Short month name */
        __PMA_TRANSL('Dec')
    )
);
Sanitize::printJsValue(
    "$.datepicker.regional['']['dayNames']",
    array(
        __PMA_TRANSL('Sunday'),
        __PMA_TRANSL('Monday'),
        __PMA_TRANSL('Tuesday'),
        __PMA_TRANSL('Wednesday'),
        __PMA_TRANSL('Thursday'),
        __PMA_TRANSL('Friday'),
        __PMA_TRANSL('Saturday')
    )
);
Sanitize::printJsValue(
    "$.datepicker.regional['']['dayNamesShort']",
    array(
        /* l10n: Short week day name */
        __PMA_TRANSL('Sun'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Mon'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Tue'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Wed'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Thu'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Fri'),
        /* l10n: Short week day name */
        __PMA_TRANSL('Sat')
    )
);
Sanitize::printJsValue(
    "$.datepicker.regional['']['dayNamesMin']",
    array(
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Su'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Mo'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Tu'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('We'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Th'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Fr'),
        /* l10n: Minimal week day name */
        __PMA_TRANSL('Sa')
    )
);
/* l10n: Column header for week of the year in calendar */
Sanitize::printJsValue("$.datepicker.regional['']['weekHeader']", __PMA_TRANSL('Wk'));

Sanitize::printJsValue(
    "$.datepicker.regional['']['showMonthAfterYear']",
    /* l10n: Month-year order for calendar, use either "calendar-month-year"
    * or "calendar-year-month".
    */
    (__PMA_TRANSL('calendar-month-year') == 'calendar-year-month')
);
/* l10n: Year suffix for calendar, "none" is empty. */
$year_suffix = _pgettext('Year suffix', 'none');
Sanitize::printJsValue(
    "$.datepicker.regional['']['yearSuffix']",
    ($year_suffix == 'none' ? '' : $year_suffix)
);
?>
$.extend($.datepicker._defaults, $.datepicker.regional['']);
} /* if ($.datepicker) */

<?php
echo "if ($.timepicker) {\n";
Sanitize::printJsValue("$.timepicker.regional['']['timeText']", __PMA_TRANSL('Time'));
Sanitize::printJsValue("$.timepicker.regional['']['hourText']", __PMA_TRANSL('Hour'));
Sanitize::printJsValue("$.timepicker.regional['']['minuteText']", __PMA_TRANSL('Minute'));
Sanitize::printJsValue("$.timepicker.regional['']['secondText']", __PMA_TRANSL('Second'));
?>
$.extend($.timepicker._defaults, $.timepicker.regional['']);
} /* if ($.timepicker) */

<?php
/* Form validation */

echo "function extendingValidatorMessages() {\n";
echo "$.extend($.validator.messages, {\n";
/* Default validation functions */
Sanitize::printJsValueForFormValidation('required', __PMA_TRANSL('This field is required'));
Sanitize::printJsValueForFormValidation('remote', __PMA_TRANSL('Please fix this field'));
Sanitize::printJsValueForFormValidation('email', __PMA_TRANSL('Please enter a valid email address'));
Sanitize::printJsValueForFormValidation('url', __PMA_TRANSL('Please enter a valid URL'));
Sanitize::printJsValueForFormValidation('date', __PMA_TRANSL('Please enter a valid date'));
Sanitize::printJsValueForFormValidation(
    'dateISO',
    __PMA_TRANSL('Please enter a valid date ( ISO )')
);
Sanitize::printJsValueForFormValidation('number', __PMA_TRANSL('Please enter a valid number'));
Sanitize::printJsValueForFormValidation(
    'creditcard',
    __PMA_TRANSL('Please enter a valid credit card number')
);
Sanitize::printJsValueForFormValidation('digits', __PMA_TRANSL('Please enter only digits'));
Sanitize::printJsValueForFormValidation(
    'equalTo',
    __PMA_TRANSL('Please enter the same value again')
);
Sanitize::printJsValueForFormValidation(
    'maxlength',
    __PMA_TRANSL('Please enter no more than {0} characters'),
    true
);
Sanitize::printJsValueForFormValidation(
    'minlength',
    __PMA_TRANSL('Please enter at least {0} characters'),
    true
);
Sanitize::printJsValueForFormValidation(
    'rangelength',
    __PMA_TRANSL('Please enter a value between {0} and {1} characters long'),
    true
);
Sanitize::printJsValueForFormValidation(
    'range',
    __PMA_TRANSL('Please enter a value between {0} and {1}'),
    true
);
Sanitize::printJsValueForFormValidation(
    'max',
    __PMA_TRANSL('Please enter a value less than or equal to {0}'),
    true
);
Sanitize::printJsValueForFormValidation(
    'min',
    __PMA_TRANSL('Please enter a value greater than or equal to {0}'),
    true
);
/* customed functions */
Sanitize::printJsValueForFormValidation(
    'validationFunctionForDateTime',
    __PMA_TRANSL('Please enter a valid date or time'),
    true
);
Sanitize::printJsValueForFormValidation(
    'validationFunctionForHex',
    __PMA_TRANSL('Please enter a valid HEX input'),
    true
);
Sanitize::printJsValueForFormValidation(
    'validationFunctionForFuns',
    __PMA_TRANSL('Error'),
    true,
    false
);
echo "\n});";
echo "\n} /* if ($.validator) */";
?>
