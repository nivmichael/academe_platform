angular.module('acadb.filters', [])
  
  .filter('keys', function() {
    return function(input) {
      if (!input) {
        return [];
      }
      return Object.keys(input);
    }
  });

/* Controllers */

angular.module('acadb.controllers', [])
  

.controller("TController",['$scope', '$filter', '$http', 'ParamData','UsersData','$location','ColumnData', function($scope, $filter, $http, ParamData,UsersData,$location,ColumnData) {
   
   
   
//fetching json from server via lib/services-ParamData, UserData

   $scope.params = ParamData.query();
   $scope.users  = UsersData.query();
   $scope.columns= ColumnData.get();


console.log( $scope.columns,  $scope.params);
//changing variables according path.   
    if($location.path() == '/type_user')
    {
   		$scope.varName  = 'User';	
   		$scope.pathTo   = '/users';	
   		$scope.objName  = $scope.users;
    	
    }else if($location.path() == '/param')
    {
   		$scope.varName = 'Param';
   		$scope.pathTo  = '/params';
   		$scope.objName = $scope.params;
    	
    }
  
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
	  		$scope.inserted = {
	  				id: lastValue+1
	  				};
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
 
	
  
  
  

}])


.controller("UserHomeController",['$scope','UsersData','$http','$routeParams', function($scope,UsersData,$http,$routeParams) {
 
   $scope.states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
   $scope.countries = countries = ['Afghanistan', 'Åland Islands', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bangladesh', 'Barbados', 'Bahamas', 'Bahrain', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Territory', 'British Virgin Islands', 'Brunei Darussalam', 'Bulgaria', 'Burkina Faso', 'Burma', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China', 'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo-Brazzaville', 'Congo-Kinshasa', 'Cook Islands', 'Costa Rica', '$_[', 'Croatia', 'Curaçao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'El Salvador', 'Egypt', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Federated States of Micronesia', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Lands', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti', 'Heard and McDonald Islands', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Moldova', 'Monaco', 'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Northern Mariana Islands', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Réunion', 'Romania', 'Russia', 'Rwanda', 'Saint Barthélemy', 'Saint Helena', 'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent', 'Samoa', 'San Marino', 'São Tomé and Príncipe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leone', 'Singapore', 'Sint Maarten', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'South Georgia', 'South Korea', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Svalbard and Jan Mayen', 'Sweden', 'Swaziland', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad and Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu', 'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'USA', 'United States', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City', 'Vietnam', 'Venezuela', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia', 'Zimbabwe'];

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
		  $scope.groups = [
		    {
		      title: 'Dynamic Group Header - 1',
		      content: 'Dynamic Group Body - 1'
		    },
		    {
		      title: 'Dynamic Group Header - 2',
		      content: 'Dynamic Group Body - 2'
		    }
		  ];
		
		  $scope.items = ['Item 1', 'Item 2', 'Item 3'];
	    }).
	    error(function(data, status, headers, config) {
	    // called asynchronously if an error occurs
	    // or server returns response with an error status.
	    });	
 	};
 	
  $scope.getAuthId();
 
   $scope.addItem = function() {
     var newItemNo = $scope.items.length + 1;
     $scope.items.push('Item ' + newItemNo);
   };

   $scope.status = {
    isFirstOpen: true,
    isFirstDisabled: false
    };
  
 
    $scope.saveUser = function() {
    // $scope.user already updated!
    $scope.user.date_of_birth = $scope.dt;
    return $http.post('/users', $scope.user).error(function(err) {
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


// this func is only for register.blade.php so the inputs are allready open for user
	// $scope.$watch('editableForm.$visible', function() {
	    // $scope.editableForm.$show();
	// });
}])

.controller("datePickerController",['$scope','UsersData','$http', function($scope,UsersData,$http) {
  
   


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
  $scope.toggleMin();
	
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
  
    $scope.saveUser = function() {
    // $scope.user already updated!
    return $http.post('/users', $scope.user).error(function(err) {
      if(err.field && err.msg) {
        // err like {field: "name", msg: "Server-side error for this username!"} 
        $scope.editableForm.$setError(err.field, err.msg);
      } else { 
        // unknown error
        $scope.editableForm.$setError('name', 'Unknown error!');
      }
    });
  };


// this func is only for register.blade.php so the inputs are allready open for user

}])

.controller("ParamController",['$scope','ParamData','$http', function($scope,ParamData,$http) {
  
      
   
//fetching json from server via lib/services-ParamData, UserData
   $scope.params = ParamData.query();
   $scope.users  = UsersData.query();

//changing variables according path.   
    if($location.path() == '/type_user')
    {
   		$scope.varName  = 'User';	
   		$scope.pathTo   = '/users';	
   		$scope.objName  = $scope.users;
    	
    }else if($location.path() == '/type_user_params')
    {
   		$scope.varName = 'Param';
   		$scope.pathTo  = '/params';
   		$scope.objName = $scope.params;
    	
    }
  
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
	  		$scope.inserted = {
	  				id: lastValue+1
	  				};
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
 
	
  
  


}]);


