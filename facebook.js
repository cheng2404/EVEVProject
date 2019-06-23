window.fbAsyncInit = function() {
	FB.init({
		appId			 : '585701108475122',
		autoLogAppEvents : true,
		xfbml			 : true,
		cookie			 : true,
		version			 : 'v2.12'
	});
};

/* Load facebook SDK for JavaScript */
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s);
	js.id = id;
	js.src = "https://connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

