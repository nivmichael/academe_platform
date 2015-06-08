 // filters need to make new file for filters...

angular.module('acadb.filters', [])
  
  .filter('keys', function() {
    return function(input) {
      if (!input) {
        return [];
      };
      return Object.keys(input);
    };
  });

/* Controllers */

angular.module('acadb.controllers', [])
  

.controller("TController",['$scope', '$filter', '$http', 'ParamData','UsersData','$location','ColumnData','DocParamData','DocTypeData','ParamTypeData','ParamValueData','SysParamValuesData', function($scope, $filter, $http, ParamData,UsersData,$location,ColumnData,DocParamData,DocTypeData,ParamTypeData,ParamValueData,SysParamValuesData) {
  
  
    $scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
    $scope.countries = countries = ['Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bangladesh', 'Barbados', 'Bahamas', 'Bahrain', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo-Brazzaville', 'Congo-Kinshasa', 'Cook Islands', 'Costa Rica', '$_[', 'Croatia', 'Curaçao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'El Salvador', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Federated States of Micronesia', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Lands', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania', 'Russia', 'Rwanda', 'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent', 'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Sweden', 'Swaziland', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'USA', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Vietnam', 'Venezuela', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'];



  
  /* ng-repeat function*/ 
    $scope.notSorted = function(obj){
        if (!obj) {
            return [];
        }
        return Object.keys(obj);
    };
     
        
/* fetching json from server via lib/services-ParamData, UserData 
 
 * 
 * make switch instead of else if
 * 
 * 
 * */

   $scope.params = ParamData.query(); 
   $scope.users  = UsersData.query();
   $scope.docParams  = DocParamData.query();
   $scope.docTypes  = DocTypeData.query();
   $scope.paramTypes  = ParamTypeData.query();
   $scope.paramValues = ParamValueData.query();
   $scope.sysParamValues = SysParamValuesData.query();
	
  // console.log($scope.sysParamValues)	;
   

   
   $scope.select_type = {
   	'type_id': 'paramType',
   	'doc_param_id': 'docParam',
   	'doc_type_id' : 'docType',
   	'value_ref'   : 'paramValue',
   	'param_id'   : 'params',
   	'ref_user_id'   : 'users',
   	'doc_type'   : 'docType',
   	
   };
   
//changing variables according path.   
    if($location.path() == '/type_user') 
    {
   		$scope.varName  = 'User';	
   		$scope.pathTo   = '/users';	
   		$scope.objName  = $scope.users;
   		$scope.columns = 'user';
   		$scope.typeAhead = ['state', 'country'];
   		$scope.userTypes = ['tech-admin','user','content-admin'];
    	
    }else if($location.path() == '/param')
    {
   		$scope.varName = 'Param';
   		$scope.pathTo  = '/params';
   		$scope.objName = $scope.params;
   		$scope.columns = 'param';
   		$scope.selects = ['type_id', 'doc_param_id'];
    }
    else if($location.path() == '/doc_param')
    {
   		$scope.varName = 'DocParam';
   		$scope.pathTo  = '/docParam';
   		$scope.objName = $scope.docParams;
   		$scope.columns = 'docParam'; 
   		$scope.selects = ['doc_type_id'];   	
    }
    else if($location.path() == '/doc_type')
    {
   		$scope.varName = 'DocType';
   		$scope.pathTo  = '/docType';
   		$scope.objName = $scope.docTypes;
   		$scope.columns = 'docType';
    	
    }else if($location.path() == '/param_type')
    {
   		$scope.varName = 'ParamType';
   		$scope.pathTo  = '/paramType';
   		$scope.objName = $scope.paramTypes;
   		$scope.columns = 'paramType';
    	
    }else if($location.path() == '/param_value')
    {
   		$scope.varName = 'ParamValue';
   		$scope.pathTo  = '/paramValue';
   		$scope.objName = $scope.paramValues;
   		$scope.columns = 'paramValue';
   		
   		$scope.paramSelect = $scope.params;
    	
    }else if($location.path() == '/sys_param_values')
    {
   		$scope.varName = 'SysParamValues';
   		$scope.pathTo  = '/sysParamValues';
   		$scope.objName = $scope.sysParamValues;
   		$scope.columns = 'sysParamValues';
   	
   			
    }
   
   
   
	  $scope.getColumns = function(){
	  
		  $http.get('/columns/' + $scope.columns).
		  success(function(data, status, headers, config) {
		 	 $scope.columns = data;
   
		  }).
		  error(function(data, status, headers, config) {
		    // called asynchronously if an error occurs
		    // or server returns response with an error status.
		  });
	  };
		
  $scope.getColumns();
  //crud
  
  // delete
   $scope.deleteParam = function(param,index){
		
		var ays = confirm('Are you sure you want to delete this parameter ?');	
		if (ays == true) {			
		 var par = ParamData.delete({id : param.id},function(){
			par.id = param.id;	
		//removing from view						
			$scope.objName.splice($scope.objName.indexOf(param),1);
		 });
		}else{alert('You canceled..');}	
	};

		//add row
		$scope.addParam = function() {
	  	$http.get($scope.pathTo)
	  	.success(function(data, status, headers, config) {
	  		
		//grabbing the last id in database..if empty starts with one.need to change it to start from real last  		
  		var lastValue;
  		var lastKey = Object.keys(data).sort().reverse()[0];
  		if(!lastKey){
  			 lastValue = 0;
  		}else{
			 lastValue = data[lastKey].id;  			
  		}
  		
/* yoni the great */
		$scope.inserted = {};
		  		
  		for (var column_name in data[0]) {
	  		$scope.inserted[column_name] = (column_name == 'id') ? lastValue+1 : '';
	  	}
	  				
		
	//adding to view  				
   		$scope.objName.push($scope.inserted);   
    }).
    error(function(data, status, headers, config) {
 	  //
    });  
  };
  
//save new or edited
 $scope.saveParam = function(data, id) {
    //$scope.user not updated yet
    angular.extend(data, {id: id});
    $http.post($scope.pathTo, data).success( function(){
  	});
   
  };
  
 /*ngOptions get options*/ 
  $scope.groups = {};
  $scope.loadGroups = function(param) {
    return $scope.groups.length ? null : $http.get('/' + $scope.select_type[param]).success(function(data) {
      $scope.groups[param] = data;
    
    });
  };

 $scope.showValues = function(val){
 	console.log(val);
 };
/*ngOptions show options*/ 
  $scope.showGroup = function(param) {
    if(param.type_id && $scope.groups.length) {
      var selected = $filter('filter')($scope.groups, {id: param.type_id});
      return selected.length ? selected[0].text : 'Not set';
    } else {
      return param.type_id || 'Not set';
    }
  };
  
  
  }])

.controller("UserHomeController",['$scope','UsersData','$http','$routeParams','DocParamData','ParamData','ParamValueData','SysParamValuesData', function($scope,UsersData,$http,$routeParams,DocParamData,ParamData,ParamValueData,SysParamValuesData) {
 
  
  $scope.getAuthId = function(){
   		$http.get('/getAuthId').
		success(function(data, status, headers, config) {
			$scope.getUser(data);
		});
   };
  
  $scope.getUser = function(id){ 
   	
		$http.get('/users/'+id).
		success(function(data, status, headers, config) {		
	     
	     $scope.user = data;	
	     console.log($scope.user);     
	    
	  
	    }).
	    error(function(data, status, headers, config) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
	    });	
 	};

  $scope.getAuthId();
  $scope.doc_params = DocParamData.query();
  $scope.params = ParamData.query();
  $scope.sysParamValues = SysParamValuesData.query();
  $scope.paramValues = ParamValueData.query();
  
  	
  	

   $scope.addItem = function() {
     var newItemNo = $scope.items.length + 1;
     $scope.items.push('Item ' + newItemNo);
   };

	

   $scope.saveUser = function(user) {
	   console.log(user);
   	   return $http.post('/users', user).success(function(v){
   	   	
       	   
      }).error(function(err) {
	      if(err.field && err.msg) {
	        // err like {field: "name", msg: "Server-side error for this username!"} 
	        $scope.editableForm.$setError(err.field, err.msg);
      } else { 
        // unknown error
        $scope.editableForm.$setError('name', 'Unknown error!');
      }
    });
  };
// DatePicker 
   $scope.today = function() {
     $scope.dt = new Date();
   };
   $scope.today();

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.disabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
 // $scope.toggleMin();
	
  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = !$scope.opened;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

$scope.status = {
        isOpen: new Array($scope.doc_params.length)
    };

    for (var i = 0; i < $scope.status.isOpen.length; i++) {
        $scope.status.isOpen[i] = (i === 0);
    }



$scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
$scope.countries = countries = ['Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bangladesh', 'Barbados', 'Bahamas', 'Bahrain', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo-Brazzaville', 'Congo-Kinshasa', 'Cook Islands', 'Costa Rica', '$_[', 'Croatia', 'Curaçao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'El Salvador', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Federated States of Micronesia', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Lands', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania', 'Russia', 'Rwanda', 'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent', 'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Sweden', 'Swaziland', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'USA', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Vietnam', 'Venezuela', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'];
   	
}])




.controller("AuthController",['$scope','ParamData','DocParamData','$http','UsersData','DocTypeData','ParamTypeData','$location', function($scope,ParamData,DocParamData,$http,UsersData,DocTypeData,ParamTypeData,$location ) {
	
$scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
$scope.countries = ['Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bangladesh', 'Barbados', 'Bahamas', 'Bahrain', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo-Brazzaville', 'Congo-Kinshasa', 'Cook Islands', 'Costa Rica', '$_[', 'Croatia', 'Curaçao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'El Salvador', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Federated States of Micronesia', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Lands', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania', 'Russia', 'Rwanda', 'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent', 'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Sweden', 'Swaziland', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'USA', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Vietnam', 'Venezuela', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'];
 

  
  
   $scope.params = ParamData.query(); 
   $scope.docParams  = DocParamData.query();
   $scope.docTypes  = DocTypeData.query();
   $scope.paramTypes  = ParamTypeData.query();
   $scope.typeAhead = ['state', 'country'];
   
   $scope.select_type = {
   	'type_id': 'paramType',
   	'doc_param_id': 'docParam',
   	'doc_type_id' : 'docType'
   	
   };
  
   	  $scope.getColumns = function(){
	  
		  $http.get('/columns/user').
		  success(function(data, status, headers, config) {
		 	 $scope.user = data;
 			  
		  }).
		  error(function(data, status, headers, config) {
		    // called asynchronously if an error occurs
		    // or server returns response with an error status.
		  });
	  };
		
  	
  
//   
  // //crud
//   
// 
		// //add row
		// $scope.addUser = function() {
	  	// $http.get('/users')
	  	// .success(function(data, status, headers, config) {
// 	  		
			// //grabbing the last id in database..if empty starts with one.need to change it to start from real last  		
	  		// var lastValue;
	  		// var lastKey = Object.keys(data).sort().reverse()[0];
	  		// if(!lastKey){
	  			 // lastValue = 0;
	  		// }else{
				 // lastValue = data[lastKey].id;  			
	  		// }
// 	  		
			// /* yoni the great */
			// $scope.inserted = {};
// 			  		
	  		// for (var column_name in data[0]) {
		  		 // $scope.inserted[column_name] = (column_name == 'id') ? lastValue+1 : '';
// 		  		
		  		 // $scope.user = $scope.inserted;
// 		  		 
// 		  		 
		  	// }
// 		  				
			// // console.log( $scope.user);
			 // $scope.collectionObj();
//   
			// //adding to view  				
	   		// //$scope.objName.push($scope.inserted);   
    // }).
    // error(function(data, status, headers, config) {
 	  // //
    // });  
  // };
  // $scope.addUser();
//save new or edited


   $scope.oneAtATime=true;

   $scope.saveUser = function(user) {
	   console.log(user);
   	   $http.post('/users', user).success(function(v){
   	   $scope.location.path('/home'); 	
       	   
      }).error(function(err) {
	      if(err.field && err.msg) {
	        // err like {field: "name", msg: "Server-side error for this username!"} 
	        $scope.editableForm.$setError(err.field, err.msg);
      } else { 
        // unknown error
        $scope.editableForm.$setError('name', 'Unknown error!');
      }
    });
  };
  
$scope.getColumns();
 

 
// DatePicker 
   $scope.today = function() {
     $scope.dt = new Date();
   };
   $scope.today();

  $scope.clear = function () {
    $scope.dt = null;
  };

  // Disable weekend selection
  $scope.disabled = function(date, mode) {
    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
  };

  $scope.toggleMin = function() {
    $scope.minDate = $scope.minDate ? null : new Date();
  };
 // $scope.toggleMin();
	
  $scope.open = function($event) {
    $event.preventDefault();
    $event.stopPropagation();

    $scope.opened = !$scope.opened;
  };

  $scope.dateOptions = {
    formatYear: 'yy',
    startingDay: 1
  };

  $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
  $scope.format = $scope.formats[0];

$scope.status = {
        isOpen: new Array($scope.docParams.length)
    };

    for (var i = 0; i < $scope.status.isOpen.length; i++) {
        $scope.status.isOpen[i] = (i === 0);
    }

	
}])
;

