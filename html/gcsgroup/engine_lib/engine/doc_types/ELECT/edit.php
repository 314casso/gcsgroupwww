<?php
for($i=1;$i<=10; $i++)
{
	$total_votes +=  intval($parent_doc_spec['quest'.$i.'_n']);
}

$vars = array(
		"{ELECT_QUESTION}" => htmlspecialchars($parent_doc_spec['question']),
		"{ELECT_MSG}" => htmlspecialchars($parent_doc_spec['msg']),
		"{ELECT_BUTTON}" => htmlspecialchars($parent_doc_spec['button']),
		"{ELECT_TOTAL}" => $total_votes,
		"{ELECT_ITEM}" => htmlspecialchars($parent_doc_spec['elect_item']),
		"{ELECT_FORMAT}" => htmlspecialchars($parent_doc_spec['elect_format']),
		"{ELECT_VOTED}" => htmlspecialchars($parent_doc_spec['elect_voted']),
		"{ELECT_VOTED_ITEM}" => htmlspecialchars($parent_doc_spec['elect_voted_item']),
		"{ELECT_MESSAGE}" => htmlspecialchars($parent_doc_spec['elect_message']),
		"{ELECT_TYPE_0}" => ($parent_doc_spec['elect_type'] == 0) ? ' SELECTED' : '',
		"{ELECT_TYPE_1}" => ($parent_doc_spec['elect_type'] == 1) ? ' SELECTED' : '',
		"{ELECT_TYPE_2}" => ($parent_doc_spec['elect_type'] == 2) ? ' SELECTED' : '',
		"{ELECT_TOTAL}" => $total_votes);

for($i=1; $i<=10; $i++)
{
	$vars['{QVAL'.$i.'}'] = htmlspecialchars($parent_doc_spec['quest'.$i]);
	$vars['{QUEST'.$i.'}'] = intval($parent_doc_spec['quest'.$i.'_n']);
	$vars['{QUESTP'.$i.'}'] = ($total_votes != 0) ? intval ($parent_doc_spec['quest'.$i.'_n']/$total_votes * 100) : 0;
}

$tpl->assign($vars);

?>