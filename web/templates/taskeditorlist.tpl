<h2>Все задачи</h2>
Поиск:&nbsp;<input class="corp_text" type="text" id="search" value="{$smarty.request.search}" />
&nbsp;
&nbsp;
Статус:&nbsp;<a href="#" id="state_all" {if $smarty.request.state}style="font-weight:bold;"{/if}>Все</a>
&nbsp;<a href="#" id="state_undone" {if $smarty.request.state eq null}style="font-weight:bold;"{/if}>Незавершенные</a>
<br/>
Проект:&nbsp;<a name="all" class="project" href="#" {if $smarty.session.project eq 'all' or $smarty.session.project eq null}style="font-weight:bold;"{/if}>Все</a>
{section name=i loop=$projects}
&nbsp;<a name="{$projects[i].id}" class="project" href="#" {if $smarty.session.project eq $projects[i].id}style="font-weight:bold;"{/if}>
	{$projects[i].fm_name}
</a>
{/section}

<form action="">
<input type="hidden" name="oper" value="new"/>
<input type="hidden" name="task" value="0"/>
<table class="container">
   <tr>
	<th>Код задачи</th>
	<th>Описание</th>
	<th>Пользователь</th>
	<th>%</th>
	<th>Статус</th>
	<th>&nbsp;</th>
   </tr>
   {section name=i loop=$tasks}
   <tr>
	 <td>
	    <a href="?task={$tasks[i].id}">{$tasks[i].fm_project}-{$tasks[i].id}</a>
	</td>
	<td style="text-align:left;">
	   <a href="?task={$tasks[i].id}">
		{$tasks[i].fm_code}.{$tasks[i].fm_descr}
	   </a>
	</td>
	<td> <a href="?dep=user&user={$tasks[i].fm_user}">{$tasks[i].fm_user}</a></td>
	<td>
	  {if $tasks[i].fm_state_name eq 'done'}
           	100
          {else}
	      {math equation="(a/p)*100" a=$tasks[i].fm_all_hour p=$tasks[i].fm_plan_hour format="%.0f"}
          {/if}
	</td>
	<td>
	    <img src="{$factory->img_admin_dir}state_{$tasks[i].fm_state_name}.gif" alt="{$tasks[i].fm_state_name}" title="{$tasks[i].fm_state}"/>
        </td>
	 <td>
	    &nbsp;
	 </td>
   </tr>
   {/section}
   <tr>
	<td>
	   <select name="fm_project" style="corp">
		{section name=i loop=$projects}
		<option value="{$projects[i].id}" {if $projects[i].id eq $smarty.request.project}selected="selected"{/if}>{$projects[i].fm_name}</option>
		{/section}
	   </select>
	</td>
	<td style="text-align:left;">
	   <input type="text" name="fm_name" size="20" class="corp_text"/>
	   <input type="text" name="fm_descr" size="70" class="corp_text"/>
	</td>
	<td style="text-align:center;">
	   {$smarty.session.user.samaccountname}
	</td>
	<td style="text-align:center;">
	   <input type="text" name="fm_plan" size="10" class="corp_text"/>
	</td>
	<td>
	    <img src="{$factory->img_admin_dir}state_new.gif" alt="new" title="Новая"/>
	</td>
	<td>
	   <input type="image" src="{$factory->img_admin_dir}yes.png" name="go" value="Добавить"/>
	</td>
   </tr>
</table>
</form>

{literal}
<script type="text/javascript">

	{/literal}
	var state = '{if $smarty.request.state}{$smarty.request.state}{/if}';
	var project = '{if $smarty.request.project}{$smarty.request.project}{else}all{/if}';
	{literal}

	$("#state_all").click(function() {
		state = 'all';
		hideandreload();
		}
	);

	$("#state_undone").click(function() {
		state = '';
		hideandreload();
		}
	);

	$("a.project").click(function() {
		project = $(this).prop("name");
		hideandreload();
		}
	);

	$("#search").change(function() {
		hideandreload();
	});

	function hideandreload() {
		var reqdata = collect();
		reload(reqdata);
	}

	function collect() {
		var reqdata = {
				'mode':'async', 
				'search': $("#search").val(),
				'state': state,
				'project': project
				};  
		return reqdata;
	}
</script>
{/literal}
