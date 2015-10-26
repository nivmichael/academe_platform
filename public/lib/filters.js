angular.module('acadb.filters', [])

.filter('checkDate', [function() {
    return function(input) {
    	//console.log('The input from the user is :'+input);
    	function getYesterday(){
    		var date = new Date();
    		return new Date(date.setDate(date.getDate() - 1));
    	}
    	
    	function getMonths(date1,date2){
    		var a = moment([date1.getFullYear(),date1.getMonth(),date1.getDate()]);
    		var b = moment([date2.getFullYear(),date2.getMonth(),date2.getDate()]);
    		return a.diff(b,'months',true);
    	}
    	
    	var returnedInput = input;
    	var today = new Date();
    	var lastBuyDate = new Date(input);
    	
    	if(today.toDateString() == lastBuyDate.toDateString()){
    		returnedInput = 'today';
    	} else if(getYesterday().toDateString() == lastBuyDate.toDateString()){	
    		returnedInput = 'yesterday';
    	} else if(getMonths(today,lastBuyDate) >= 6){
    		returnedInput = 'long time ago...';
    	}
    	return returnedInput;
    };
}])
.filter('checkmark', [function() {
    return function(input) {
        // This is V or X characters
        return input ? '\u2713' : '\u2718';
    };
}])
	. filter('capitalize', function() {
		return function(input, all) {
			var reg = (all) ? /([^\W_]+[^\s-]*) */g : /([^\W_]+[^\s-]*)/;
			return (!!input) ? input.replace(reg, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();}) : '';
		}
	})

	.filter('underscoreless', function () {
		return function (input) {
			return input.replace(/_/g, ' ');
		};
	})
.filter('orderObjectBy', function() {
  return function(items, field, reverse) {
    var filtered = [];
    angular.forEach(items, function(item) {
      filtered.push(item);
    });
    filtered.sort(function (a, b) {
      return (a[field] > b[field] ? 1 : -1);
    });
    if(reverse) filtered.reverse();
    return filtered;
  };
});