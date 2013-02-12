var EventAdd = function()
{
	var ret =
	{
		showPublicProgramFields:function(input, outsideDiv)
		{
			if(input == 'ON')
			{
				$(outsideDiv).html("<div id='PublicProgramFields'><table><tr><td>Total Revenue</td><td><input type='text' name='revenue' onblur='Valid.moneyValid(this)'/></td></tr><tr><td>Total Expences</td><td><input type='text' name='expense' onblur='Valid.moneyValid(this)'/></td></tr></table></div>");
			}
			if(input == 'OFF')
			{
				$('#PublicProgramFields', outsideDiv).remove();
			}
		},
		hiddenForPrint:function(table)
		{
			if(table == 'Option')
			{
				ret.optionHiddenForPrint();
			}
			if(table == 'Grade')
			{
				ret.gradeHiddenForPrint();
			}
		},
		eventAddOption:function()
		{
			ret.unifiedEventAdd('Option', 'optionEventMapHiddenText');
		},
		optionHiddenForPrint:function()
		{
			if($('#optionEventMapHiddenText').val() != '')
			{
				ret.hiddenForPrintPrivate($('#optionEventMapHiddenText').val(), 'Option', 'optionShowPrint');
			}
		},
		eventAddGrade:function()
		{
			ret.unifiedEventAdd('Grade', 'gradeEventMapHiddenText');
		},
		gradeHiddenForPrint:function()
		{
			if($('#gradeEventMapHiddenText').val() != '')
			{
				ret.hiddenForPrintPrivate($('#gradeEventMapHiddenText').val(), 'Grade', 'gradeShowPrint');
			}
		},
		hiddenForPrintPrivate:function(IDstring, tableName, IDtarget)
		{
			$('#' + IDtarget ).html(tableName + "s Selected: none");
			$.ajax
			({
				type: 'POST',
				url: 'RPC/HiddenPrintRPC.php' ,
				data: {ids: IDstring, table: tableName},
				success:function(result)
				{
					$('#' + IDtarget ).html(tableName + "s Selected: " + result);
				},
				error:function()
				{
					$('#' + IDtarget ).html(tableName + "s Selected: Error");
				}
			});
		},
		unifiedEventAdd:function(tableName, writeTargetHiddenID)
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/' + tableName + 'TableRPC.php' ,
				dataType: "html",
				success:function(result)
				{
					$(result).dialog({
						open:function()
						{
							var alreadyChecked = $('#' + writeTargetHiddenID ).val();
							var alreadyCheckedArr = alreadyChecked.split(",");
							for (var i=0;i<alreadyCheckedArr.length;i++)
							{
								$('input[name=' + alreadyCheckedArr[i] + ']').prop('checked', true);
							}
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Add ' + tableName,
						width: 400,
						resizable: false,
						modal: true,
						buttons:
						{
							'Save':function()
							{
								var serialData = $('form', this).serializeArray();
								var selectedArr = new Array();
								for (var i=0;i<serialData.length;i++)
								{
									selectedArr.push(serialData[i].name);
								}
								$('#' + writeTargetHiddenID ).val(selectedArr.toString());
								ret.hiddenForPrint(tableName);
								$( this ).dialog( "close" );
							}
						}
					});
				},
				error:function()
				{
					alert('error add ' + tableName);
				}
			});
		}
	}
	return ret;
}();
var DropDown = function()
{
	var ret = {
		personAssociatedWithOrg:function(organization)
		{
			var orgValue;
			if(typeof(organization)=='string')
			{
				orgValue = organization;
			}
			else
			{
				orgValue = $(organization).val();
			}
			$.ajax
			({
		  		type: "POST",
		  		url: "RPC/PeopleInOrganizationRPC.php",
		 		data: { orgID: orgValue },
		 		dataType: "html",
				success:function(result)
				{
					$('select[name="dropDownPerson"]', this.form).remove();
					$("#person").html(result);
				},
				error:function()
				{
					$("#tooltip").html("something went wrong in person associated with org");
				}
			});
		},
		setDropDownValue:function(dropDownObj, valueToSet)
		{
			$(dropDownObj).val(valueToSet);
		},
		setEndTimeAfterStartTime:function(endTime)
		{
			var startTime = $('select[name="startTime"]', endTime.form);
			if(parseInt($(startTime).val()) > parseInt($(endTime).val()))
			{
				$(startTime).val($(endTime).val());
			}
		},
		setPersonInForm:function(dropdown)
		{
			$('select[name="Person"]', this.form).val($(dropdown).val());
		},
		setTimePlus2Hr:function(feild)
		{
			var endTime = parseInt($(feild).val()) + (900 * 8);
			var maxEndTime = parseInt($(":last", feild).val() );
			endTime = (endTime > maxEndTime) ? maxEndTime : endTime ;
			$('select[name="endTime"]', feild.form).val(endTime);
		}
	}
	return ret;
}();
var LoadContent = function()
{
	var ret =
	{
		loadContent:function(locationOfhtml, idVal, optionVal, isolation)
		{
			$('#content form').remove();  //not sure if this is necessary at this juncture but we shall find out.
			idVal = typeof idVal !== 'undefined' ? idVal : 'none';
			optionVal = typeof optionVal !== 'undefined' ? optionVal : 'none' ;
			isolation = typeof isolation !== 'undefined' ? isolation : null ;
			$.ajax
			({
				type: 'POST',
				url: locationOfhtml ,
				data: {id: idVal, option: optionVal},
				dataType: "html",
				success:function(result)
				{
					$("#content").html(result);
					$("#search").val(null);
					if(isolation) isolation();
				},
				error:function()
				{
					$("#tooltip").html("error load content");
				}
			});
		},
		loadIsolatedContent:function(id, tableName)
		{
			var RPClocation = 'RPC/' + tableName + 'RPC.php';
			ret.loadContent(RPClocation, id, null, function(){ret.editPage($('form', '#content'));});
		},
		editPage:function(form)
		{
			$(":input", form).prop("disabled", true);
			$("td:last", form).html('<input type="button" value="Edit" id="editButton" onclick="LoadContent.editButtonClick(this.form, this)" /><input type="button" value="Email" id="emailButton" onclick="Email.emailDialog( this.form )" />');
			$('#CostOfEventInPrint').show();
		},
		editButtonClick:function(form, eButton)
		{
			$("td:last", form).html("");
			$('#CostOfEventInPrint').hide();
			$(":input", form).removeProp("disabled");
			$(eButton).remove();
		},
		collectFormDataAjax:function(form)
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/WriteToDataBaseRPC.php' ,
				data: {formData: $(form).serialize()},
				success:function(result)
				{
					$("#tooltip").html("Data successfully send to data base");
					if(result)
					{
						ret.loadIsolatedContent(result, $('[name="table"]',this.form).val() );
					}
					else
					{
						alert('error data not saved, make sure you filled everything out something proper!');
						$("#tooltip").html('error data not saved, make sure you filled everything out something proper!');
					}
				},
				error:function()
				{
					$("#tooltip").html("Data could not be saved, wait a while and try again");
					alert("Data could not be saved, wait a while and try again");
				}
			});
		},
		clearFormData:function(form)
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/DeleteFromDataBaseRPC.php' ,
				data: {formData: $(form).serialize()},
				success:function()
				{
					$("#tooltip").html("Data successfully removed");
					ret.loadContent('RPC/DefaultViewRPC.php');
				},
				error:function()
				{
					$("#tooltip").html("Data could not be deleted, wait a while and try again");
					alert("Data could not be deleted, wait a while and try again");
				}
			});
		}
	}
	return ret;
}();
var Login = function()
{
	var ret =
	{
		loginScript:function()
		{
			var user = $("#userName").val();
			var password = $("#password").val();		
			$.ajax
			({
		  		type: "POST",
		  		url: "RPC/LoginCheckRPC.php",
		   	data: { user: user, password: password },
		 		dataType: "html",
				success:function(result)
				{
					$("#content").html("");
					if(result != "FALSE")
					{
						var DefaultViewDiv = LoadContent.loadContent('RPC/DefaultViewRPC.php');
						$(".isLogin").show( "fold", 1000,function() 
						{
							$("#content").html(DefaultViewDiv);
							$("#userStatus").html(
								result
								+ " <input type='button' id='changePasswordButton' value='Change Password' onclick='Login.loadChangePasswordModal()' />"
							);
						});
						if(result == 'Admin')
						{
							$('.Admin').show()
						}
						else
						{
							$('.Admin').hide()	
						}
						$("#tooltip").html("This is a list of upcoming events");
					}
					else
					{
						$(password).val(null);
						alert("check your user name and password and try again")
					}
				},
				error:function()
				{
					alert("Login Failed");
				}
			});
		},
		createNewUserSecondAJAX:function(userName, password)
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/CreateNewUser_WriteToDataBaseRPC.php',
				data: {userName: userName, password: password},
				success:function(result)
				{
					$("#tooltip").html("New User " + userName + " added");
				},
				error:function()
				{
					alert("failed second ajax");
				}
			});
		},
		createNewUser:function()
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/CreateNewUserRPC.php' ,
				dataType: "html",
				success:	function(result)
				{
					$(result).dialog({
						open:function()
						{
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Create User',
						width: 500,
						resizable: false,
						modal: true,
						buttons:
						{
							'Add User':function()
							{
								if($("#password1").val() == $("#password2").val())
								{
									ret.createNewUserSecondAJAX($("#userName").val() , $("#password1").val());
								}
								else
								{
									alert($("#password1").val() + " != " + $("#password2").val());
									$("#password1").val(null);
									$("#password2").val(null);
								}
								$( this ).dialog( "close" );
							}
						}
					});
				},
				error: function()
				{
					alert("error create new user");
				}
			});
		},
		deleteUser:function()
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/AdminDeleteUserPRC.php' ,
				dataType: "html",
				success:	function(result)
				{
					$(result).dialog({
						open:function()
						{
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Delete User',
						width: 500,
						resizable: false,
						modal: true,
						buttons:
						{
							'Delete':function()
							{
								$.ajax
									({
										type: 'POST',
										url: 'RPC/AdminDeleteUserWritePRC.php' ,
										data: {formData: $('form', this).serialize()},
										dataType: "html",
										success:function(result)
										{
											alert(result);
										},
										error:function()
										{
											alert("User not deleted");
										}
									});
								$( this ).dialog( "close" );
							}
						}
					});
				},
				error:function()
				{
					alert("error change password");
				}
			});
		},
		setUserPassword:function()
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/AdminChangePassWordPRC.php' ,
				dataType: "html",
				success:	function(result)
				{
					$(result).dialog({
						open:function()
						{
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Change Selected User Password',
						width: 500,
						resizable: false,
						modal: true,
						buttons:
						{
							'Change Password':function()
							{
								$.ajax
									({
										type: 'POST',
										url: 'RPC/AdminChangePassWordWritePRC.php' ,
										data: {formData: $('form', this).serialize()},
										dataType: "html",
										success:function(result)
										{
											alert(result);
										},
										error:function()
										{
											alert("target users password not changed");
										}
									});
								$( this ).dialog( "close" );
							}
						}
					});
				},
				error:function()
				{
					alert("error change password");
				}
			});
		},
		loadChangePasswordModal:function()
		{
			$.ajax
			({
				type: 'POST',
				url: 'RPC/ChangePasswordRPC.php' ,
				dataType: "html",
				success:	function(result)
				{
					$(result).dialog({
						open:function()
						{
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Change Password',
						width: 500,
						resizable: false,
						modal: true,
						buttons:
						{
							'Change Password':function()
							{
								$.ajax
									({
										type: 'POST',
										url: 'RPC/ChangePasswordWriteRPC.php' ,
										data: {formData: $('form', this).serialize()},
										dataType: "html",
										success:function(result)
										{
											alert(result);
										},
										error:function()
										{
											alert("password not changed");
										}
									});
								$( this ).dialog( "close" );
							}
						}
					});
				},
				error:function()
				{
					alert("error change password");
				}
			});
		}
	}
	return ret;
}();
var Etera = function()
{
	var ret =
	{
		autoCompleteCity:function()
		{
			$.ajax
			({
				type: 'POST',
				url: "RPC/AutoCompleteCityRPC.php" ,
				dataType: "html",
				success:function(result)
				{
					$( "#city" ).autocomplete({
						source: result.split(",")
					});
				}
			});
		},
		enableDisableOptionGrade:function(tableName, selectionName, setValueTo, buttonObject)
		{
			var correctedValue = (setValueTo == '0') ? '1' : '0';
			$.ajax
			({
		 		type: "POST",
		  		url: "RPC/EnableDisableOptionGradePRC.php",
		 		data: { tableName: tableName, selectionName: selectionName, setValueTo: correctedValue },
				dataType: "html",
				success:function(result)
				{
					var buttonLabel = (result == 'Enable') ? 'Enable' : 'Disable';
					$(buttonObject).val(buttonLabel);
				},
				error:function()
				{
					
				}
			});
		},
		autoCompleteSearch:function()
		{
			$.ajax
			({
				type: 'POST',
				url: "RPC/AutoCompleteSearchRPC.php" ,
				dataType: "html",
				success:function(result)
				{
					$( "#search" ).autocomplete({
						source: result.split(",")
					});
				}
			});
		},
		radioSetHidden:function(radio, hiddenName)
		{
			$(":hidden[name=" + hiddenName + "]").val($(radio).val());
		},
		datepicker:function()
		{
			$( "#datepicker" ).datepicker();
		},
		reloadTabs:function()
		{
			$( "#tabs" ).tabs();
		},
		miscellaneousScript:function(tableName, Action, stringValue, cost1, cost2, cost3, cost4)
		{
			cost1 = typeof cost1 !== 'undefined' ? cost1 : 'none' ;
			cost2 = typeof cost2 !== 'undefined' ? cost2 : 'none' ;
			cost3 = typeof cost3 !== 'undefined' ? cost3 : 'none' ;
			cost4 = typeof cost4 !== 'undefined' ? cost4 : 'none' ;
			$.ajax
			({
				type: 'POST',
				url: 'RPC/MiscellaneousWriteRPC.php' ,
				data: {tableName: tableName, Action: Action, stringValue: stringValue, cost1: cost1, cost2: cost2, cost3: cost3, cost4: cost4},
				success:function()
				{
					LoadContent.loadContent('RPC/MiscellaneousRPC.php');
					$("#tooltip").html("Add and remove various things");
				},
				error:function()
				{
					alert("it failed miscellaneous");
				}
			});
		},
		checkBoxFix:function(field, idOfHiddenInput)
		{
			if(field.checked)
			{
				$('#' + idOfHiddenInput).val(1);
			}
			else
			{
				$('#' + idOfHiddenInput).val(0);
			}
		},
		SearchByDate:function(checkBox)
		{
			if($(checkBox).prop("checked"))
			{
				$( "#search" ).val('');
				$( "#search" ).datepicker();
				$( "#search" ).autocomplete({ disabled: true });
			}
			else
			{
				$( "#search" ).val('');
				$( "#search" ).datepicker( "destroy" );
				ret.autoCompleteSearch();
				$( "#search" ).autocomplete({ disabled: false });
			}
		}
	}
	return ret;
}();
var Valid = function()
{
	var ret =
	{
		positionOfDotFromEndOfString:function(inputString)
		{
			var lengthOfString = inputString.length;
			var positionOfDot = inputString.indexOf(".");
			
			return lengthOfString - positionOfDot - 1;//-1 so we can count like people not computers 
		},
		moneyValid:function(field)
		{
			var money = $(field).val();
			var stripped_money = money.replace(/[^0-9.]/g, '');
			
			if(stripped_money.replace(/[^.]/g, '').length > 0)//stripped money has a . in it
			{
				if(stripped_money.replace(/[^.]/g, '').length == 1)//has only one . in it
				{
					if( ret.positionOfDotFromEndOfString(stripped_money) == 2 )// X.XX
					{
						//do nothing
					}
					if( ret.positionOfDotFromEndOfString(stripped_money) == 1 ) // X.X
					{
						stripped_money += '0';	
					}					
					if( ret.positionOfDotFromEndOfString(stripped_money) == 0 ) // X.
					{
						stripped_money += '00';
					}
					
					if( ret.positionOfDotFromEndOfString(stripped_money) > 2 ) // X.XXX
					{
						stripped_money = '0.00';
						$("#tooltip").html("money malformed, try again");	
					}
					
					if( stripped_money.indexOf(".") == 0 ) // .X (has nothing in front of it)
					{
						stripped_money = '0' + stripped_money;
					}
				}
				else //has more than one . in it
				{
					stripped_money = '0.00';
					$("#tooltip").html("money malformed, try again");	
				}
			}
			else
			{
				if(stripped_money == '')
				{
					stripped_money += '0';
				} 
				stripped_money += '.00';	
			}					
			$(field).val(stripped_money);
		},
		emailValid:function(field)
		{
			var email = $(field).val();
		    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
		    {
		    	$(field).val(email);//this does not really change anything, for clarity
				$("#tooltip").html("email correctly formed (or close enough)");
		    }
		    else
		    {
		    	$(field).val('');
				$("#tooltip").html("email Address malformed, try again");
		    }
		},
		phoneValid:function(field, areaCode)
		{
			var phonenum = $(field).val();
			var raw_number = phonenum.replace(/[^0-9]/g, '');
			if(raw_number.length < 7)
			{
				raw_number = '';
				if(phonenum != '')
				$("#tooltip").html("phone number malformed, try again");
			}
			if(raw_number.length == 7)
			{
				raw_number = areaCode + raw_number;
				$("#tooltip").html("Area code '920' added to number");
			}
			if(raw_number.length > 10)
			{
				//idk padd the end with stuff? EX
				$("#tooltip").html("big phone number, assuming there is an extension");
			}
			var regex1 = /^1?([2-9]..)([2-9]..)(....)$/;
			if(!regex1.test(raw_number))
			{
				$(field).val( raw_number );
			}
			else
			{
				$(field).val( raw_number.replace(regex1,'1 ($1) $2 $3') );
			}
		},
		zipValid:function(field)
		{
			zip = $(field).val();
			var raw_number = zip.replace(/[^0-9]/g, '');
			if(raw_number.length == 5)
			{
				$(field).val(raw_number);
				$("#tooltip").html("Zip code correctly formatted");
				return;
			}
			if(raw_number.length > 5)
			{
				$(field).val(raw_number.slice(0,5));
				$("#tooltip").html("Zip code to long, using first five numbers");
				return;
			}
			if(raw_number.length < 5)
			{
				$(field).val('');
				$("#tooltip").html("No enough numbers for valid zip code, try again");
				return;
			}
		}
	}
	return ret;
}();
var Report = function()
{
	var ret =
	{
		showReportOption:function(form)
		{
			var start = $('[name="start"]', form).val();
			var end = $('[name="end"]', form).val();			
			var filter = $(':radio[name="filterBy"]:checked', form).val();
			var filterID = (filter == 'Option') ? $("#optionSelect", form).val() : $("#roomSelect", form).val() ;
			$.ajax
			({
				type: 'POST',
				url: 'RPC/ReportOptionRPC.php' ,
				data: {start: start, end: end, filter: filter, filterID: filterID},
				success:function(result)
				{
					$('#tabs-Options-Results').html(result);
				},
				error:function()
				{
					alert("it failed report.showReportOption js");
				}
			});
		},	
		showReportAttendance:function(form)
		{
			var start = $('[name="start"]', form).val();
			var end = $('[name="end"]', form).val();
			$.ajax
			({
				type: 'POST',
				url: 'RPC/ReportAttendanceRPC.php',
				data: {start: start, end: end},
				success:function(result)
				{
					$('#tabs-Attendance-Results').html(result);
				},
				error:function()
				{
					alert("it failed report.showReportAttendance js");
				}
			});
		},
		showReportDateRange:function(form)
		{
			var start = $('[name="start"]', form).val();
			var end = $('[name="end"]', form).val();
			$.ajax
			({
				type: 'POST',
				url: 'RPC/ReportDateRangeRPC.php',
				data: {start: start, end: end},
				success:function(result)
				{
					$('#tabs-Time-Results').html(result);
				},
				error:function()
				{
					alert("it failed tabs-Time-Results report.showReportDateRange js");
				}
			});
		},
		radioChange:function(selectObj)
		{
			$('.ReportViewOptions').hide();
			$(selectObj).show();		
		}
	}
	return ret;
}();
var Email = function()
{
	var ret =
	{
		emailDialog:function(form)
		{
			var eventID = $('input[name="id"]',form).val();
			$.ajax
			({
				type: 'POST',
				url: 'RPC/EmailRPC.php' ,
				data: {id: eventID},
				success:function(result)
				{
					$(result).dialog({
						open:function()
						{
							
						},
						close:function()
						{
							$( this ).dialog( "destroy" ).remove();
						},
						closeOnEscape: true,
						draggable: false,
						title: 'Email',
						width: 500,
						resizable: false,
						modal: true,
						buttons:
						{
							//none yet
						}
					});
				},
				error:function()
				{
					alert("it failed Email.emailDialog EMAx.js");
				}
			});
		}
	}
	return ret;
}();
$("html").on({
    ajaxStart:function() 
    { 
        $(this).addClass("loading");
    },
    ajaxStop:function() 
    { 
        $(this).removeClass("loading"); 
    }    
});