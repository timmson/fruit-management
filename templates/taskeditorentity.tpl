<a href="?">&lt;- Все задачи</a>&nbsp;
<table style="font-size:8pt" class="plain" width="100%">
<tr>
	<td style="width:45%; vertical-align:top; padding: 2px;">
		<h3>Задача {$task.tm_name}&nbsp;
			<a href="?task={$task.id}&oper=clone" title="Клонировать&nbsp;задачу">
				<img src="{$factory->img_admin_dir}copy.png"/>
			</a>
			<a href="#" onclick="changeFieldImg('tm_subscribe', '{$task.tm_subscribe}')" title="Подписка">
				<img src="{$factory->img_admin_dir}follow_{$task.tm_subscribe}.png"/>
			</a>
			<a href="mailto:?subject=Задача&nbsp;{$task.tm_name}?body={$task.tm_url}" title="Поделиться">
				<img src="{$factory->img_admin_dir}share.png"/>
			</a>
		</h3>
		<table class="container">
		   <tr>
			<th style="text-align:right; width:250px;">Проект</th>
			<td style="text-align:left">
				<a id="tm_project">[{$task.tm_project}]{$task.tm_project_descr}</a>
				<a href="#" class="edit" onclick="changeFieldPromt('tm_project', 'select');">
					<img src="{$factory->img_admin_dir}edit.png"/>
				</a>
			</td>
		   </tr>
		   <tr>
			<th style="text-align:right;">Исполнитель</th>
			<td style="text-align:left">
				<a href="?dep=user&user={$task.tm_user}" id="tm_user">{$task.tm_user}</a>
				<a href="#" class="edit" onclick="changeFieldPromt('tm_user', 'input');">
					<img src="{$factory->img_admin_dir}edit.png"/>
				</a>
			</td>
		   </tr>
		   <tr>
			<th style="text-align:right;">Код задачи во внешней системе</th>
			<td style="text-align:left">
				<a id="tm_name">{$task.tm_code}</a>
				<a href="#" onclick="changeFieldPromt('tm_name', 'input');">
					<img src="{$factory->img_admin_dir}edit.png"/>
				</a>
			</td>
		   </tr>
		   <tr>
			<th style="text-align:right;">Название задачи</th>
			<td style="text-align:left">
				<a id="tm_descr">{$task.tm_descr}</a>
				<a href="#" onclick="changeFieldPromt('tm_descr', 'input');">
					<img src="{$factory->img_admin_dir}edit.png"/>
				</a>
			</td>
		   </tr>
		   <tr>
			<th style="text-align:right;">Приоритет</th>
			<td style="text-align:left">
				<table class="container" style="width:10%; border:0px;">
					 <tr>
					<td rowspan="2" style="border:0px;"><img src="{$factory->img_admin_dir}priority_{$task.tm_priority_name}.gif" alt="{$task.tm_priority_name}" title="{$task.tm_priority_descr}"/></td>
					<td style="border:0px; valign:bottom;">{if $task.tm_priority ne 1}<a href="#" onclick="changeFieldImg('tm_priority', '{$task.tm_priority-1}');"><img src="{$factory->img_admin_dir}rateup.png" alt="priority_up" title="Поднять приоритет"/></a>{/if}</td>
							</tr>
					 <tr>
					<td style="border:0px; ">{if $task.tm_priority ne 3}<a href="#" onclick="changeFieldImg('tm_priority', '{$task.tm_priority+1}');"><img src="{$factory->img_admin_dir}ratedown.png" alt="priority_down" title="Понизить приоритет"/></a>{/if}</td>
							</tr>
					  </table>
			</td>
		   </tr>
		   <tr>
				<th style="text-align:right;">Статус</th>
			<td style="text-align:left">
			   <img id="tm_state" src="{$factory->img_admin_dir}state_{$task.tm_state_name}.gif" alt="{$task.tm_state_name}" title="{$task.tm_state}"/>
			   {if $task.tm_next_state_id ne null}
			   <a href="#" onclick="changeFieldImg('tm_state', '{$task.tm_next_state_id}');" title="Дальше">
					<img src="{$factory->img_admin_dir}hide.png" alt="next"/>
			   </a>
			   {/if}
			   {if $task.tm_state_name ne 'done' and $task.tm_state_name ne 'decline'}
			   <a href="#" onclick="changeFieldImg('tm_state', 4);" title="Оменить">
				<img src="{$factory->img_admin_dir}del.png" alt="decline"/>
			   </a>
			   {/if}
			</td>
		   </tr>
		   <tr>
			<th style="text-align:right;">Часов всего затрачено/запланировано</th>
			<td style="text-align:left">
				{$task.tm_all_hour}/<a id="tm_plan">{$task.tm_plan_hour}</a>
				{if $task.tm_state_name eq 'new'}
				<a href="#" onclick="changeFieldPromt('tm_plan', 'input');">
					<img src="{$factory->img_admin_dir}edit.png"/>
				</a>
				{/if}
			</td>
		   </tr>
			<tr>
			<th style="text-align:right;">Подписчики</th>
			<td style="text-align:left">
				{section name=i loop=$task.subscribers}
					<a href="?dep=user&user={$task.subscribers[i].tm_user}">{$task.subscribers[i].tm_user}</a>
				{/section}
			</td>
		   </tr>
		</table>
	</td>
	<td style="vertical-align:top;">
		<h3>Cостоит&nbsp;из</h3>
		<table class="container">
			 <tr>
				<th>Задача</th>
				<th>Исполнитель</th>
				<th>%</th>
				<th>Приоритет</th>
				<th>Статус</th>
				<th>&nbsp;</th>
			 </tr>

				{section name=i loop=$task.child}
			<tr>
				<td style="text-align:left; width:90%">
					 <a href="?task={$task.child[i].id}" style="font-size:8pt">{$task.child[i].tm_name}&nbsp;{$task.child[i].tm_code}.{$task.child[i].tm_descr}</a>
				</td>
				<td >
					 <a href="?dep=user&user={$task.child[i].tm_user}">{$task.child[i].tm_user}</a>
				</td>
				<td>
				   {if $task.child[i].tm_state_name eq 'done'}
						  100
					{else}
						  {math equation="(a/p)*100" a=$task.child[i].tm_all_hour p=$task.child[i].tm_plan_hour format="%.0f"}
					{/if}
				</td>
				 <td>
					<img src="{$factory->img_admin_dir}priority_{$task.child[i].tm_priority_name}.gif" alt="{$task.child[i].tm_priority_name}" title="{$task.tm_priority_descr}"/>
				  </td>
				<td >
					 <img src="{$factory->img_admin_dir}state_{$task.child[i].tm_state_name}.gif" alt="{$task.child[i].tm_state_name}" title="{$task.child[i].tm_state}"/>
				</td>

				  <td>
						<a href="?task={$task.id}&oper=delrel&fname=tm_child&fvalue={$task.child[i].id}">
					   <img src="{$factory->img_admin_dir}del.png" alt="delete" title="Удалить"/>
					</a>
			 </td>
			</tr>

		   {/section}
			<tr>
				<td style="text-align:left;" colspan="6">
					Добавить:&nbsp;
					<input id="tm_child" name="fvalue" class="corp_text" value=""/>
				<td>
			</tr>
		 <table>
         <h3>Подчинена</h3>
		 <table class="container">
			 <tr>
				<th>Задача</th>
				<th>Исполнитель</th>
				<th>%</th>
				<th>Приоритет</th>
				<th>Статус</th>
				<th>&nbsp;</th>
			 </tr>
		
		   {section name=i loop=$task.parent}
			<tr>
				<td style="text-align:left; width:90%">
					 <a href="?task={$task.parent[i].id}" style="font-size:8pt">{$task.parent[i].tm_name}&nbsp;{$task.parent[i].tm_code}.{$task.parent[i].tm_descr}</a>
				</td>
				<td >
					 <a href="?dep=user&user={$task.parent[i].tm_user}">{$task.parent[i].tm_user}</a>
				</td>
				<td>
				   {if $task.parent[i].tm_state_name eq 'done'}
							100
					{else}
						  {math equation="(a/p)*100" a=$task.parent[i].tm_all_hour p=$task.parent[i].tm_plan_hour format="%.0f"}
						{/if}
				</td>
				 <td>
					<img src="{$factory->img_admin_dir}priority_{$task.parent[i].tm_priority_name}.gif" alt="{$task.parent[i].tm_priority_name}" title="{$task.parent[i].tm_priority_descr}"/>
				  </td>
				<td >
					 <img src="{$factory->img_admin_dir}state_{$task.parent[i].tm_state_name}.gif" alt="{$task.parent[i].tm_state_name}" title="{$task.parent[i].tm_state}"/>
				</td>
				<td>
					<a href="?task={$task.id}&oper=delrel&fname=tm_parent&fvalue={$task.parent[i].id}">
					   <img src="{$factory->img_admin_dir}del.png" alt="delete" title="Удалить"/>
					</a>
				 </td>
			</tr>
		   {/section}
			<tr>
				<td style="text-align:left;" colspan="6">
					Добавить:&nbsp;
					<input id="tm_parent" name="fvalue" class="corp_text" value=""/>
				</td>	
			</tr>
		</table>
	</td>
</tr>
</table>

<h3>Описание</h3>
<div style="" >
	<div id="edit_tm_descr_full">
		<a href="#" id="tm_descr_full_edit">
			[Редактировать]
		</a>
	</div>
	<div style="display:none;" id="buttons_tm_descr_full">
		<a href="#" id="save_tm_descr_full">
			[Cохранить]
		</a>
		<a href="#" id="decline_tm_descr_full">
			[Отменить]
		</a>
	</div>
<div>
<br/>
<div id="tm_descr_full" name="tm_descr_full" style="border:1px #ccc solid; padding:5px;">
	{$task.tm_descr_full}
</div>

<h3>Активность</h3>
<form action=".">
<input type="hidden" name="oper" value="add"/>
<input type="hidden" name="task" value="{$task.id}"/>
<table class="container" id="worklog" style="font-size:9pt;">
   <tr>
	<th>Дата</th>
	<th>Тип</th>
	<th>Описание</th>
	<th>Пользователь</th>
	<th>Потрачено</th>
	<th>&nbsp;</th>
   </tr>
   {section name=i loop=$task.worklog}
   <tr >
	<td>{$task.worklog[i].tm_date|date_format:$const.global.dateformat}</td>
    <td>
    	<img src="{$factory->img_admin_dir}log_cat_{$task.worklog[i].tm_cat_name}.gif" alt="{$task.worklog[i].tm_cat_name}" title="{$task.worklog[i].tm_cat_descr}"/>
    </td>
	<td style="text-align:left;">{$task.worklog[i].tm_comment}</td>
	<td>
		<a href="?dep=user&user={$task.worklog[i].tm_user}">{$task.worklog[i].tm_user}</a>
	</td>
	<td>{$task.worklog[i].tm_spent_hour}</td>
	<td>
		{assign var="user" value=$smarty.session.user.samaccountname}
	   {if $user eq $task.worklog[i].tm_user or $user eq 'root'}
	   <a href="?task={$task.id}&oper=delete&tm_work_id={$task.worklog[i].id}">
		<img src="{$factory->img_admin_dir}del.png" alt="delete"/>
	   </a>
	   {/if}
	</td>
   </tr>
   {/section}
   <tr id="workloginput">
	<td>
	   <input type="text" size="10" name="tm_date" value="{$smarty.now|date_format:$const.global.dateformat}" class="corp_text"/>
	</td>
	<td style="text-align:left;">
	   <select name="tm_cat">
	   		{section name=i loop=$task.worklog_cat}
	   		<option value="{$task.worklog_cat[i].id}"{if $task.worklog_cat[i].tm_name eq 'cmnt'}selected="selected"{/if}>{$task.worklog_cat[i].tm_descr}</value>
	   		{/section}
	   </select>
	</td>
	<td style="text-align:left;">
	   <input type="text" name="tm_comment" size="100%" class="corp_text"/>
	</td>
	<td>
	   {$smarty.session.user.samaccountname}
	</td>
	<td>
	   <input type="text" name="tm_spent_hour" size="2" class="corp_text" style="text-align:center"/>
	</td>
	<td>
	   <input type="image" src="{$factory->img_admin_dir}yes.png" name="go" value="Добавить"/>
	</td>
   </tr>
</table>
</form>

<h3>Изменения кодовой базы</h3>
<table class="container" id="worklog" style="font-size:9pt;">
   <tr>
	<th>Дата</th>
	<th>Изменения</th>
	<th>Пользователь</th>
   </tr>
   {section name=i loop=$task.vcslog}
   <tr >
	<td style="vertical-align:top;">
		{$task.vcslog[i].date|date_format:$const.global.dateformat}<br/>{$task.vcslog[i].rev}
	</td>
	<td style="text-align:left;">
		{assign var=changes value=$task.vcslog[i].changes}
		{section name=j loop=$changes}
			 {assign var=type value=$changes[j]|substr:3:1}
			 {assign var=color value=#009}
			 {if $type eq 'A'}
			 	{assign var=color value=#090}
			 {elseif $type eq 'D'}
			 	{assign var=color value=#999}
			 {/if}
			<a href="{$const.global.svnUrl}{$changes[j]|substr:5}" style="color:{$color};">{$changes[j]|substr:5}</a><br/>
		{/section}
	</td>
	<td style="vertical-align:top;">
		{$task.vcslog[i].user}
	</td>
   </tr>
   {/section}
</table>

<div style="display:none;" id="inputPopupPromt" title="Изменить значение поля">
	Введите новое значение:&nbsp;<input type="text" class="corp_text" size="25" name="inputFieldValue" id="inputFieldValue" value=""/>
	<p><div id="inputFieldError" class="ui-state-error ui-corner-all" style="display:none;"></div></p>
</div>
<div style="display:none;" id="selectPopupPromt" title="Изменить проект">
	Перенести в &nbsp;
	<select class="corp" name="selectFieldValue" id="selectFieldValue">
		{section name=i loop=$projects}
		<option value="{$projects[i].id}" {if $projects[i].id eq $task.tm_project_id}selected="selected"{/if}>
			[{$projects[i].tm_name}]{$projects[i].tm_descr}
		</option>
		{/section}
	 </select>
	<p><div id="selectFieldError" class="ui-state-error ui-corner-all" style="display:none;"></div></p>
</div>
<div style="display:none;" id="inputPopupInfo" title="Сообщение">
	Необходимо указать планируемые трудозатраты
</div>
	{literal}
	<script src="./ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		var taskid ={/literal}{$task.id}{literal};

		var projectid ={/literal}{$task.tm_project_id}{literal};
		
		$(function() {
			taskAutoComplete('#tm_child');
			taskAutoComplete('#tm_parent');
			$('#tm_descr_full_edit').click(function() {
				CKEDITOR.replace('tm_descr_full');
				$('#buttons_tm_descr_full').fadeIn(500);
				$('#edit_tm_descr_full').fadeOut(0);
			});
			$('#save_tm_descr_full').click(function() {
				var reqData = {
						"task"  :taskid, 
						"oper"  :"update", 
						"mode"  :"async",
						"fname" :"tm_descr_full", 
						"fvalue": CKEDITOR.instances.tm_descr_full.getData()
				};
				$.post(window.location, reqData, function(data) {
						
						var reqData = {
								"task"  :taskid,
								"mode"  :"async"
						};
						reload(reqData);
					}
				);
			});
			$('#decline_tm_descr_full').click(function() {
						var reqData = {
								"task"  :taskid,
								"mode"  :"async"
						};
						reload(reqData);
			});
		});

		
		
		function changeFieldImg(fieldid, newValue) {
				if (fieldid == 'tm_state' && newValue == 2 && $("#tm_plan").html() == 0) {
					$("#inputPopupInfo").dialog({
						modal: true,
						resizable:false,
						minWidth: 500,
						buttons: {
							"Ок": function() {
								$(this).dialog("close");
							}
						}
					});
					return;
				}
				var reqData = {
						"task"  :taskid, 
						"oper"  :"update", 
						"mode"  :"async",
						"fname" :fieldid, 
						"fvalue":newValue
				};
				$.post(window.location, reqData, function(data) {
						
						var reqData = {
								"task"  :taskid,
								"mode"  :"async"
						};
						reload(reqData);
					}
				);
		}

		function userAutoComplete(selector) {
			$(selector).autocomplete({
				source: function (request, response) {
					var reqData = {
						"task"  :taskid, 
						"oper"  :"search", 
						"mode"  :"async",
						"user":request.term
					};
					$.post(window.location, reqData, function(data) { 
		                var suggestions = $.parseJSON(data);
       					response(suggestions);
                	});
				},
				minLength: 5
			});
		}

		function taskAutoComplete(selector) {
			$(selector).autocomplete({
				source: function (request, response) {
					var reqData = {
						"task"  :taskid, 
						"oper"  :"tasks", 
						"mode"  :"async",
						"search":request.term
					};
					$.post(window.location, reqData, function(data) { 
		                var suggestions = $.parseJSON(data);
       					response(suggestions);
                	});
				},
				select: function(event, ui) {
					var reqData = {
						"task"  :taskid, 
						"oper"  :"addrel", 
						"mode"  :"async",
						"fname" :selector.substr(1), 
						"fvalue":ui.item.value
					};
					$.post(window.location, reqData, function(data) {
						var reqData = {
								"task"  :taskid,
								"mode"  :"async"
						};
						reload(reqData);
						}
					);
				},
				minLength: 3
			});
		}

		function changeFieldPromt(fieldid, type) {
			var oldValue = $("#"+fieldid).html();
			$("#" + type + "FieldValue").val(oldValue);
			if (fieldid=='tm_user') {
				userAutoComplete("#" + type + "FieldValue");
			} else if (fieldid=='tm_task') {
				taskAutoComplete("#" + type + "FieldValue")
			}
			$("#" + type + "PopupPromt").dialog({
                modal: true,
                resizable:false,
                minWidth: 500,
                buttons: {
                    "Ок": function() {
                    	var newValue = $("#" + type + "FieldValue").val();
                        if (newValue!=null && newValue!="" && newValue!=oldValue) {
							var data = changeField(fieldid, newValue);
							if (data!="ok") {
		        				$("#" + type + "FieldError").html(data);
		        				$("#" + type + "FieldError").fadeIn(1000);
		        			} else {
		        				if (type=='select') {
		        					projectid = newValue;
		        					newValue = $('#' + type + 'FieldValue option[value="' + newValue + '"]').html();
		        				}
								$("#" + fieldid).html(newValue);
								$(this).dialog("close");
							}
						}
                    },
                    "Отмена": function() {
                        $(this).dialog("close");
                    }
                }
            });
   			$('#' + type + 'FieldValue option[value="' + projectid + '"]').prop("selected", "selected");
		}

		function changeField(fieldid, newValue) {
				var reqData = {
						"task"  :taskid, 
						"oper"  :"update", 
						"mode"  :"async",
						"fname" :fieldid, 
						"fvalue":newValue
				};
				$.post(window.location, reqData, function(data) {
						return $.trim(data);
					}
				);
				return "ok";
		}
	</script>
	{/literal}
