{if $smarty.request.mode ne 'async'}
<h3>Пользователь&nbsp;<input name="user" id="user" class="corp_text" value="{$user}"/></h3>
<h3>Активность</h3>
<table width="100%" class="container">
   <tr style="font-weight:bold;">
      <th>Код</th>
      <th>Задача</th>
      <th>Статус</th>
      <th>ПН</th>
      <th>ВТ</th>
      <th>СР</th>
      <th>ЧТ</th>
      <th>ПТ</th>
   </tr>
   {section name=i loop=$timesheet}
	{assign var="mon" value="$mon+$timesheet[i].task_spent_mon"}
	{assign var="tue" value="$tue+$timesheet[i].task_spent_tue"}
	{assign var="wen" value="$wen+$timesheet[i].task_spent_wen"}
	{assign var="th" value="$th+$timesheet[i].task_spent_th"}
	{assign var="fr" value="$fr+$timesheet[i].task_spent_fr"}
   <tr >
      <td>
	<a href="?dep=task&task={$timesheet[i].task_id}">
		{$timesheet[i].project_name}-{$timesheet[i].task_id}
	</a>
      </td>
      <td style="text-align:left;">
	 <a href="?dep=task&task={$timesheet[i].task_id}">
		{$timesheet[i].task_name}.{$timesheet[i].task_descr}
	</a>
     </td>
      <td>
	<!--img src="{$factory->img_admin_dir}state_{$timesheet[i].fm_state_name}.gif" alt="{$timesheet[i].fm_state_name}" title="{$timesheet[i].fm_state}"/-->{$timesheet[i].task_state}
      </td>
	<td align="center">{$timesheet[i].task_spent_mon}</td>
	<td align="center">{$timesheet[i].task_spent_tue}</td>
	<td align="center">{$timesheet[i].task_spent_wen}</td>
	<td align="center">{$timesheet[i].task_spent_th}</td>
	<td align="center">{$timesheet[i].task_spent_fr}</td>
   </tr>
   {/section}
   <tr style="font-weight:bold;">
      <td colspan="3" style="text-align:right">
		{if $fr eq 8}<span style="text-decoration:blink; color:red;">ОТЧЕТ!!!</span>{else}Итого{/if}
	</td>
	<td align="center">{$mon}</td>
	<td align="center">{$tue}</td>
	<td align="center">{$wen}</td>
	<td align="center">{$th}</td>
	<td align="center">{$fr}</td>
   </tr>
</table>
<h3>Задачи</h3>
<table class="container" width="100%">
   <tr style="font-weight:bold;">
      <td>Код</td>
      <td>Задача</td>
      <td>Состояние</td>
      <td>%</td>
      <td>Приоритет</td>
      <td>Статус</td>
   </tr>
    {section name=i loop=$tasks}
   <tr>
      <td><a href="?dep=task&task={$tasks[i].id}">{$tasks[i].fm_name}</a></td>
      <td style="text-align:left;">
	  <a href="?dep=task&task={$tasks[i].id}">
		{$tasks[i].fm_code}.{$tasks[i].fm_descr}
	  </a>
      </td>
      <td style="font-size:10pt;text-align:left;">{$tasks[i].fm_last_comment}</td>
      <td>
	 {math equation="(a/p)*100" a=$tasks[i].fm_all_hour p=$tasks[i].fm_plan_hour format="%.0f"}
      </td>
      <td>
	   <img src="{$factory->img_admin_dir}priority_{$tasks[i].fm_priority_name}.gif" alt="{$tasks[i].fm_priority_name}" title="{$tasks[i].fm_priority_descr}"/>
	</td>
      <td>
	<img src="{$factory->img_admin_dir}state_{$tasks[i].fm_state_name}.gif" alt="{$tasks[i].fm_state_name}" title="{$tasks[i].fm_state}"/>
        </td>
   </tr>
   {/section}
</table>
{literal}
<script type="text/javascript">
			$("#user").change(function() {
				//filter4pair($(this).prop("name"), $(this).val());
			});
			$("#user").autocomplete({
				source: function (request, response) {
					var reqData = {
						"oper"  :"search", 
						"mode"  :"async",
						"user":request.term
					};
					$.post(window.location, reqData, function(data) { 
		                var suggestions = $.parseJSON(data);
       					response(suggestions);
                	});
				},
				minLength: 5,
				select : function(event, ui) {
					filter4pair($(this).prop("name"), ui.item.value)
				}
			});
</script>
{/literal}
{else}
{$users_json}
{/if}
