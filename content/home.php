<label>Your Currency Type:</label>
<input class="form-control" type="text" id="currency-type" placeholder="Points, coins, etc."/>
<label>API Key:</label>
<input class="form-control" type="text" id="api-key" placeholder="Enter Your API Key"/>
<label>User IP Address:</label>
<input class="form-control" type="text" id="ip-address" placeholder="Enter Your IP Address"/>
<label>Unique User Id:</label>
<input class="form-control" type="text" id="user-id" placeholder="Enter Unique UserId"/>
<label>Date Of Birth (yyyy-mm-dd):</label>
<input class="form-control" type="text" id="dob" placeholder="yyyy-mm-dd" />
<label>Gender (1=male, 2=female):</label>
<input class="form-control" type="text" id="gender" placeholder="1 for male, 2 for female" />
<label>US Postcode:</label>
<input class="form-control" type="text" id="postcode" placeholder="Enter US Postcode" />
<br/><br/>
<button class="form-control" id="fetch-surveys">Fetch Surveys</button>
<br/><br/>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Survey Rank</th>
	  <th scope="col">Survey Link</th>
      <th scope="col">User Reward</th>
      <th scope="col">Estimated Length</th>
    </tr>
  </thead>
  <tbody id="survey-table">
  </tbody>
</table>

<script type="text/javascript">
	var clientIPAddress = '<?php echo $_SERVER["REMOTE_ADDR"]; ?>';
	var userId = '<?=createGUID()?>';
	$('#ip-address').val(clientIPAddress);
	$('#user-id').val(userId);
	
    $('#fetch-surveys').click(function(){ 
		var postcode = $('#postcode').val();
		var gender = $('#gender').val();
		var dob = $('#dob').val();
		var apiKey = $('#api-key').val();
		clientIPAddress = $('#ip-address').val();
		userId = $('#user-id').val();
		
		var baseUrl = "https://api.inbrain.ai/supplier-api/v1/surveys";
		var params = "userId=" + userId + "&ipAddress=" + clientIPAddress + "&language=en-us&zipCodeUs=" + postcode + "&gender=" + gender + "&dateOfBirth=" + dob + "&householdIncome=21&ethnicity=1&education=8&maritalStatus=1&employmentStatus=1&employmentIndustry=1&vote=1&primaryDecisionMaker=1&peopleHousehold=2";
         $.ajax({ 
			 beforeSend: function(request) {
				request.setRequestHeader("X-InBrain-Api-Key", apiKey);
			 },
             type: "GET",
             dataType: "json",
             url: baseUrl + '?' + params,
             success: function(data){        
                $('#survey-table').empty();
				$.each(data, function(index, item){
					$('#survey-table').append("<tr><td>" + (index + 1) + "</td><td><a target='_blank' href='" + item.link + "'>Open Survey</a></td><td>" + item.cpi + "</td><td>" + item.lengthOfInterview + "</td></tr>");
				});
             }
         });
    });

</script>