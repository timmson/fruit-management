Релизы:
{section name=i loop=$release}
	&nbsp;<a id="{$release[i].id}" href="#" class="rellink" {if $relid eq $release[i].id}style="font-weight:bold"{/if}>
		{$release[i].fm_code}.{$release[i].fm_descr}
	</a>&nbsp;
{/section}
<div style="float:right;">
	<a href="?section=plan">Классическое&nbsp;планирование</a>
</div>
{assign var=plan_hour value=0}
{assign var=all_hour value=0}
{section name=i loop=$structtasks}
	{if $structtasks[i].fm_state_name ne 'declie' and $structtasks[i].fm_state_name ne 'done'}
		{assign var=plan_hour value=$structtasks[i].fm_plan_hour+$plan_hour}
		{assign var=all_hour value=$structtasks[i].fm_all_hour+$all_hour}
	{/if}
{/section}
<div id="tabs">
	<ul>
		<li><a href="#workTab">Текущие</a></li>
		<li><a href="#planTab">План</a></li>
	</ul>
<div id="planTab">
	<table class="container" style="table-layout: fixed;">
		<tr>
			<th>Резерв</th>
			{section name=i loop=$structtasks}
			<th>{$structtasks[i].fm_code}.{$structtasks[i].fm_descr}</th>
			{/section}
		</tr>
		<tr>
			<td style="vertical-align: top;">
				<div class="droppable" id="{$backlogid}" title="plan">
					{section name=i loop=$backlog}
						{include file="agileeditorcard.tpl" task=$backlog[i]}
	   				{/section}
   				</div>
			</td>
			{section name=i loop=$structtasks}
			<td style="vertical-align: top;">
				<div class="droppable" id="{$structtasks[i].id}" title="plan">
					{section name=j loop=$structtasks[i].child}
						{include file="agileeditorcard.tpl" task=$structtasks[i].child[j]}
					{/section}
   				</div>
			</td>
			{/section}
		</tr>
	</table>
</div>
<div id="workTab">
	<div id="progressBar" style="margin-top:25px;"></div>
	{$all_hour}ч затрачено/{$plan_hour-$all_hour}ч осталось
	<table class="plain" style="margin-top:25px; table-layout: fixed;">
		<tr>
			<th>Без оценки</th>
			<th>В плане</th>
			<th>Реализация</th>
			<th>Тестирование</th>
		</tr>
		<tr>
			<td style="padding: 5px; vertical-align: top;">
				<div class="droppable" id="new" title="state">
	   			{section name=i loop=$structtasks}
					{section name=j loop=$structtasks[i].child}
						{if $structtasks[i].child[j].fm_state_name eq 'new'}
							{include file="agileeditorcard.tpl" task=$structtasks[i].child[j]}
						{/if}
					{/section}
				{/section}
	   			</div>
			</td>
			<td style="padding: 5px; vertical-align: top;">
				<div class="droppable" id="planned" title="state">
	   			{section name=i loop=$structtasks}
					{section name=j loop=$structtasks[i].child}
						{if $structtasks[i].child[j].fm_state_name eq 'planned'}
							{include file="agileeditorcard.tpl" task=$structtasks[i].child[j]}
						{/if}
					{/section}
				{/section}
	   			</div>
			</td>
			<td style="padding: 5px; vertical-align: top;">
				<div class="droppable" id="in_progress" title="state">
	   			{section name=i loop=$structtasks}
					{section name=j loop=$structtasks[i].child}
						{if $structtasks[i].child[j].fm_state_name eq 'in_progress'}
							{include file="agileeditorcard.tpl" task=$structtasks[i].child[j]}
						{/if}
					{/section}
				{/section}
				</div>
			</td>
			<td style="padding: 5px; vertical-align: top;">
				<div class="droppable" id="test" title="state">
	   			{section name=i loop=$structtasks}
					{section name=j loop=$structtasks[i].child}
						{if $structtasks[i].child[j].fm_state_name eq 'test'}
							{include file="agileeditorcard.tpl" task=$structtasks[i].child[j]}
						{/if}
					{/section}
				{/section}
	   			</div>
			</td>									
		</tr>
	</table>
</div>
</div>
{literal}
<script type="text/javascript">
	$(function() {
		var all_hour = {/literal}{$all_hour}{literal};
	
		var plan_hour = {/literal}{$plan_hour}{literal};

		var release = {/literal}{$relid}{literal};

		var tab = {/literal}{$smarty.request.tab|default:0}{literal};
	
		$("#tabs").tabs({
			selected: tab 
		});

		$("#progressBar").progressbar({
			value: (all_hour/plan_hour)*100
		});

		$("#release").change(function() {
			var reqdata = {
					'mode':'async', 
					'release': $(this).val()
					};
		
			reload(reqdata);
		});

		$(".rellink").click(function() {
			var reqdata = {
					'mode':'async', 
					'release': $(this).prop("id")
					};
		
			reload(reqdata);
		});

		$(".draggable").draggable({
			start: function( event, ui ) {
				$(this).css("z-index", 100);
			}
		});

		$(".droppable").css("min-height", "300px");

		$(".draggable").click(function(){
			window.location = '?section=task&task=' + $(this).prop("id");
		});

		$(".droppable").droppable({
            drop: function( event, ui ) {
            	var reqdata = {
					'mode':'async',
					'oper': $(this).prop('title'),
					'toid'  : $(this).prop('id'),
					'tab' : $("#tabs").tabs("option" , "selected"),
					'release': release,
					'task' : $(ui.draggable).prop("id")
					};
				reload(reqdata);
			}
		});

	});
</script>
{/literal}

