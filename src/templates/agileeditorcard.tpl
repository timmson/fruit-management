{if $task.fm_priority_name eq 'high'}
	{assign var="color" value="#f99"}
{elseif $task.fm_priority_name eq 'medium'}
	{assign var="color" value="#ff9"}
{else}
	{assign var="color" value="#9f9"}
{/if}
<div id="{$task.id}" class="ui-widget-content ui-corner-all draggable" style="margin-bottom: 5px; min-height:125px; padding: 2px; cursor:pointer; background:{$color};">
	<div class="ui-widget-header ui-corner-all">
		<img src="{$factory->img_admin_dir}priority_{$task.fm_priority_name}.gif" alt="{$task.fm_priority_name}" title="{$task.fm_priority_descr}"/>
		{$task.fm_name}
	</div>
	<p style="text-align:left; font-size:8pt;">
		{$task.fm_code}.{$task.fm_descr}
	</p>
	<p style="text-align:left; font-size:8pt;">
		<img id="fm_state" src="{$factory->img_admin_dir}state_{$task.fm_state_name}.gif" alt="{$task.fm_state_name}" title="{$task.fm_state}"/>
		&nbsp; 
		{$task.fm_last_comment}
	</p> 
	<p style="text-align:left; font-size:8pt;">{$task.fm_user}&nbsp;&nbsp;&nbsp;
	{if $task.fm_all_hour > $task.fm_plan_hour}
		<span style="color:#00f; font-weight:bold;">перерасход {$task.fm_all_hour-$task.fm_plan_hour}ч</span>
	{else}
		{if $task.fm_state_name ne 'done'}
			{$task.fm_plan_hour-$task.fm_all_hour}ч осталось
		{/if}
	{/if}
	</p>
</div>

