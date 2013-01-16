var EMAx = function()
{

	var EventAdd = function()
	{
		var ret =
		{
			hiddenForPrint:function(table)
			{
				if(table == 'Option')
				{
					optionHiddenForPrint();
				}
				if(table == 'Grade')
				{
					gradeHiddenForPrint();
				}
			},
			eventAddOption:function()
			{
				unifiedEventAdd('Option', 'optionEventMapHiddenText');
			},
			optionHiddenForPrint:function()
			{
				if($('#optionEventMapHiddenText').val() != '')
				{
					hiddenForPrintPrivate($('#optionEventMapHiddenText').val(), 'Option', 'optionShowPrint');
				}
			},
			eventAddGrade:function()
			{
				unifiedEventAdd('Grade', 'gradeEventMapHiddenText');
			},
			gradeHiddenForPrint:function()
			{
				if($('#gradeEventMapHiddenText').val() != '')
				{
					hiddenForPrintPrivate($('#gradeEventMapHiddenText').val(), 'Grade', 'gradeShowPrint');
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
					success:	function(result)
					{
						$('#' + IDtarget ).html(tableName + "s Selected: " + result);
					},
					error: function()
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
					success:	function(result)
					{
						$(result).dialog({
							open: function()
							{
								var alreadyChecked = $('#' + writeTargetHiddenID ).val();
								var alreadyCheckedArr = alreadyChecked.split(",");
								for (var i=0;i<alreadyCheckedArr.length;i++)
								{
									$('input[name=' + alreadyCheckedArr[i] + ']').prop('checked', true);
								}
							},
							close: function()
							{
								$( this ).dialog( "destroy" ).remove();
							},
							closeOnEscape: true,
							draggable: false,
							title: 'Add ' + tableName,
							width: 300,
							resizable: false,
							modal: true,
							buttons:
							{
								'Save': function()
								{
									var serialData = $('form', this).serializeArray();
									var selectedArr = new Array();
									for (var i=0;i<serialData.length;i++)
									{
										selectedArr.push(serialData[i].name);
									}
									$('#' + writeTargetHiddenID ).val(selectedArr.toString());
									hiddenForPrint(tableName);
									$( this ).dialog( "close" );
								}
							}
						});
					},
					error: function()
					{
						alert('error add ' + tableName);
					}
				});
			}
		}
		return ret;
	}();
	var FormDataAjax = function()
	{
		var ret =
		{
			collectFormDataAjax:function(form)
			{
				$.ajax
				({
					type: 'POST',
					url: 'RPC/WriteToDataBaseRPC.php' ,
					data: {formData: $(form).serialize()},
					success:	function(result)
					{
						$("#tooltip").html("Data successfully send to data base");
						if(result)
						{
							loadIsolatedContent(result, $('[name="table"]',this.form).val() );
						}
						else
						{
							alert('error data not saved, make sure you filled everything out something proper!');
							$("#tooltip").html('error data not saved, make sure you filled everything out something proper!');
						}
					},
					error: function()
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
					success:	function()
					{
						$("#tooltip").html("Data successfully removed");
						loadContent('RPC/DefaultViewRPC.php');
					},
					error: function()
					{
						$("#tooltip").html("Data could not be deleted, wait a while and try again");
						alert("Data could not be deleted, wait a while and try again");
					}
				});
			}
		}
		return ret;
	}();
	var DropDown = function()
	{
		var ret = {
			personAssociatedWithOrg: function(organization)
			{
				var orgValue;
				if(typeof(organization)=='string')
				{
					orgValue = organization;
				}
				else
				{
					orgValue = organization.value;
				}
				$.ajax
				({
			  		type: "POST",
			  		url: "RPC/PeopleInOrganizationRPC.php",
			 		data: { orgID: orgValue },
			 		dataType: "html",
					success:	function(result)
					{
						$('select[name="dropDownPerson"]', this.form).remove();
						$("#person").html(result);
					},
					error: function()
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
				optionVal = typeof isolation !== 'undefined' ? isolation : null ;
				$.ajax
				({
					type: 'POST',
					url: locationOfhtml ,
					data: {id: idVal, option: optionVal},
					dataType: "html",
					success:	function(result)
					{
						$("#content").html(result);
						$("#search").val(null);
						if(isolation) isolation();
					},
					error: function()
					{
						$("#tooltip").html("error load content");
					}
				});
			},
			loadIsolatedContent:function(id, tableName)
			{
				var RPClocation = 'RPC/' + tableName + 'RPC.php';
				loadContent(RPClocation, id, null, function(){editPage($('form', '#content'));});
			},
			editPage:function(form)
			{
				$(":input", form).prop("disabled", true);
				$("td:last", form).html('<input type="button" value="Edit" id="editButton" onclick="editButtonClick(this.form, this)" />');
			},
			editButtonClick:function(form, eButton)
			{
				$("td:last", form).html("");
				$(":input", form).removeProp("disabled");
				$(eButton).remove();
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
			//   	data: { user: user.value, password: password.value },
			data: { user: 'mike', password: 'blizzard' },
			 		dataType: "html",
					success:	function(result)
					{
						$("#content").html("");
						if(result != "FALSE")
						{
							var DefaultViewDiv = loadContent('RPC/DefaultViewRPC.php');
							$(".isLogin").show( "fold", 1000,function() {
								$("#content").html(DefaultViewDiv);
								$("#userStatus").html(
									result
									+ " <input type='button' id='changePasswordButton' value='Change Password' onclick='loadChangePasswordModal()' />"
								);
							});
							$("#tooltip").html("This is a list of upcoming events");
						}
						else
						{
							password.value = null;
							alert("check your user name and password and try again")
						}
					},
					error: function()
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
					success:	function(result)
					{
						$("#tooltip").html("New User " + userName + " added");
					},
					error: function()
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
							open: function()
							{
							},
							close: function()
							{
								$( this ).dialog( "destroy" );
							},
							closeOnEscape: true,
							draggable: false,
							title: 'Create User',
							width: 500,
							resizable: false,
							modal: true,
							buttons:
							{
								'Add User': function()
								{
									var userName = document.getElementById("userName");
									var password1 = document.getElementById("password1");
									var password2 = document.getElementById("password2");
									if(password1.value == password2.value)
									{
										createNewUserSecondAJAX(userName.value , password1.value);
									}
									else
									{
										alert(password1.value + " != " + password2.value);
										password1.value = null;
										password2.value = null;
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
							open: function()
							{
							},
							close: function()
							{
								$( this ).dialog( "destroy" );
							},
							closeOnEscape: true,
							draggable: false,
							title: 'Change Password',
							width: 400,
							resizable: false,
							modal: true,
							buttons:
							{
								'Save': function()
								{
									$.ajax
										({
											type: 'POST',
											url: 'RPC/ChangePasswordWriteRPC.php' ,
											data: {formData: $('form', this).serialize()},
											dataType: "html",
											success:	function(result)
											{
												alert(result);
											},
											error: function()
											{
												alert("password not changed");
											}
										});
									$( this ).dialog( "close" );
								}
							}
						});
					},
					error: function()
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
					success:	function(result)
					{
						$( "#city" ).autocomplete({
							source: result.split(",")
						});
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
					success:	function(result)
					{
						$( "#search" ).autocomplete({
							source: result.split(",")
						});
					}
				});
			},
			datepicker:function()
			{
				$( "#datepicker" ).datepicker();
			},
			reloadTabs:function()
			{
				$( "#tabs" ).tabs();
			},
			miscellaneousScript:function(tableName, Action, stringValue, cost)
			{
				cost = typeof cost !== 'undefined' ? cost : 'none' ;
				$.ajax
				({
					type: 'POST',
					url: 'RPC/MiscellaneousWriteRPC.php' ,
					data: {tableName: tableName, Action: Action, stringValue: stringValue, cost: cost},
					success:	function()
					{
						loadContent('RPC/MiscellaneousRPC.php');
						$("#tooltip").html("Add and remove various things");
					},
					error: function()
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
			showSearchResults:function(searchString)
			{
				var searchArr = searchString.split(" ");
				$.ajax
				({
			  		type: "POST",
			  		url: "RPC/SearchResultsRPC.php",
			 		data: { searchArr }
				}).done(function( html )
				{
			  		$("#content").html(html);
				});
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
					autoCompleteSearch();
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

	/*
var EventAdd = function()
var FormDataAjax = function()
var DropDown = function()
var LoadContent = function()
var Login = function()
var Etera = function()
var Valid = function()
	*/

}();