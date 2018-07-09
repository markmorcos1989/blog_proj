//search, find and highlight
/*function searchhighlight(searchedtext)
{
	if(searchedtext)
	{
		var content = $("#container").HTML();
		//var content = $("#container").contents();
		var searchexp = new RegExp(searchedtext, "ig");
		var matches = content.match(searchexp);
		//var highlighted = searchedtext.css('background-color', 'yellow');
		if(matches)
		{
			$("#container").html(content.replace(searchexp, function(match){
				return "<span class='color'>" + match + "</span>";
				//return "5";
			}));
			//$("#container").html(content.replace(searchexp, highlighted));
		}
		else
		{
			$(".color").removeClass("color");
		}
	}
	else
	{
		$(".color").removeClass("color");
	}
}*/

/*function searchhighlight(searchedtext)
{
	if(searchedtext)
	{
		//var content = $("#container").text();
		var content = $("p").text();
		var searchexp = new RegExp(searchedtext, "ig");
		var matches = content.match(searchexp);
		if(matches)
		{
			$( "p" ).contents().filter(function(){
				return this.nodeType == 3;
			  }).each(function(){
				this.textContent = this.textContent.replace(searchexp, function(match){
					return "<span class='color'>" + match + "</span>";
				});
			});
		}
		else
		{
			$(".color").removeClass("color");
		}
	}
	else
	{
		$(".color").removeClass("color");
	}
}*/

/*$(document).ready(function(){
	$("#searchtext").keyup(function(){
		searchhighlight($(this).val());
	});
});*/

/*$(document).ready(function(){
	$("#search_b").click(function(){
		//searchhighlight($(this).val());
		var searchtext = $("#searchtext").val();
		$("*").removeHighlight().highlight(searchtext);
	});
});*/

/*$(document).ready(function(){
	$("#search_b").click(function(){
		$(function () {   
		   var textToReplace =  $('*').html();
			textToReplace = textToReplace.replace(/a/g,'<strong>a</strong>');
			$('*').html(textToReplace);
		});
	});
});*/
/*$(document).ready(function(){
	$("#searchtext").keyup(function(){
//$(function() {
		$('#searchtext').bind('keyup change', function(ev) {
			// pull in the new value
			var searchTerm = $(this).val();

			// remove any old highlighted terms
			$('*').removeHighlight();

			// disable highlighting if empty
			if ( searchTerm ) {
				// highlight the new term
				$('*').highlight( searchTerm );
			}
		});
	});
});*/